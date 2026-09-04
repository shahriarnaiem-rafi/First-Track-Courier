<?php

require_once __DIR__ . "/../../../rootfolder/database.php";
require_once __DIR__ . "/../../connect/admin_auth.php";

if (!isset($database) || !($database instanceof mysqli)) {
    die("Database connection is not available.");
}


/*
|--------------------------------------------------------------------------
| CSRF TOKEN
|--------------------------------------------------------------------------
*/

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION['csrf_token'];

$form_error = "";

$receipt_data = null;


/*
|--------------------------------------------------------------------------
| HANDLE FORM SUBMISSION
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submitted"])) {

    $submitted_token = $_POST["csrf_token"] ?? "";

    if (
        empty($submitted_token) ||
        empty($_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $submitted_token)
    ) {

        $form_error = "Invalid form request. Please refresh the page and try again.";

    } else {

        /*
        |--------------------------------------------------------------------------
        | GET FORM VALUES
        |--------------------------------------------------------------------------
        */

        $service_type = trim($_POST['service'] ?? "");

        $sender_name = trim($_POST['senderName'] ?? "");
        $sender_address = trim($_POST['senderAddress'] ?? "");
        $sender_phone = trim($_POST['senderPhone'] ?? "");

        $receiver_name = trim($_POST['receiverName'] ?? "");
        $receiver_address = trim($_POST['receiverAddress'] ?? "");
        $receiver_phone = trim($_POST['receiverPhone'] ?? "");

        $product = trim($_POST['receiverProduct'] ?? "");

        $date = trim($_POST['date'] ?? "");
        $weight_input = trim($_POST['weight'] ?? "");

        /*
        |--------------------------------------------------------------------------
        | PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        $payment_method = trim($_POST['payment_method'] ?? "");

        $status = "pending";
        $money = 0;


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        if (!in_array($service_type, ["Standard", "Express"], true)) {

            $form_error = "Please select a valid service type.";

        } elseif (
            $sender_name === "" ||
            $sender_address === "" ||
            $sender_phone === "" ||
            $receiver_name === "" ||
            $receiver_address === "" ||
            $receiver_phone === "" ||
            $product === "" ||
            $date === "" ||
            $weight_input === ""
        ) {

            $form_error = "Please complete all required fields.";

        } elseif (
            !is_numeric($weight_input) ||
            (float)$weight_input <= 0 ||
            (float)$weight_input > 20000
        ) {

            $form_error = "Weight must be between 1 and 20,000 grams.";

        } elseif (
            !in_array(
                $payment_method,
                ["Cash", "Credit Card", "PayPal", "Bank Transfer"],
                true
            )
        ) {

            $form_error = "Please select a valid payment method.";

        } else {

            $weight = (float)$weight_input;


            /*
            |--------------------------------------------------------------------------
            | DELIVERY PRICE
            |--------------------------------------------------------------------------
            */

            if ($weight <= 1000) {

                $money = 150;

            } elseif ($weight <= 5000) {

                $money = 750;

            } elseif ($weight <= 7000) {

                $money = 1050;

            } elseif ($weight <= 10000) {

                $money = 1800;

            } elseif ($weight <= 15000) {

                $money = 2500;

            } elseif ($weight <= 20000) {

                $money = 3500;
            }


            /*
            |--------------------------------------------------------------------------
            | INSERT CUSTOMER / PARCEL
            |--------------------------------------------------------------------------
            */

            $sql = "INSERT INTO customer_section
                    (
                        service_type,
                        sender_name,
                        sender_address,
                        sender_phone,
                        receiver_name,
                        receiver_address,
                        receiver_phone,
                        product,
                        weight,
                        date_of_order,
                        money,
                        status
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $database->prepare($sql);

            if (!$stmt) {

                $form_error = "Unable to prepare the order. Please try again.";

            } else {

                $stmt->bind_param(
                    "ssssssssdsds",
                    $service_type,
                    $sender_name,
                    $sender_address,
                    $sender_phone,
                    $receiver_name,
                    $receiver_address,
                    $receiver_phone,
                    $product,
                    $weight,
                    $date,
                    $money,
                    $status
                );


                if ($stmt->execute()) {

                    /*
                    |--------------------------------------------------------------------------
                    | GET NEW ORDER ID
                    |--------------------------------------------------------------------------
                    */

                    $order_id = $database->insert_id;


                    /*
                    |--------------------------------------------------------------------------
                    | INSERT PAYMENT
                    |--------------------------------------------------------------------------
                    */

                    $payment_status = "Paid";

                    $payment_date = $date;

                    $payment_sql = "INSERT INTO payment
                                    (
                                        order_id,
                                        customer_name,
                                        amount,
                                        payment_method,
                                        payment_date,
                                        payment_status
                                    )
                                    VALUES (?, ?, ?, ?, ?, ?)";

                    $payment_stmt = $database->prepare($payment_sql);

                    if (!$payment_stmt) {

                        $form_error = "Order created, but payment could not be prepared.";

                    } else {

                        $payment_stmt->bind_param(
                            "isdsss",
                            $order_id,
                            $sender_name,
                            $money,
                            $payment_method,
                            $payment_date,
                            $payment_status
                        );


                        if ($payment_stmt->execute()) {

                            /*
                            |--------------------------------------------------------------------------
                            | RECEIPT DATA
                            |--------------------------------------------------------------------------
                            */

                            $receipt_data = [

                                'order_id' => $order_id,

                                'customer_name' => $sender_name,

                                'receiver_name' => $receiver_name,

                                'product' => $product,

                                'service_type' => $service_type,

                                'weight' => $weight,

                                'amount' => $money,

                                'payment_method' => $payment_method,

                                'payment_date' => $payment_date

                            ];


                            /*
                            |--------------------------------------------------------------------------
                            | REFRESH CSRF TOKEN
                            |--------------------------------------------------------------------------
                            */

                            $_SESSION['csrf_token'] =
                                bin2hex(random_bytes(32));

                            $csrf_token =
                                $_SESSION['csrf_token'];

                        } else {

                            $form_error =
                                "Order created, but payment could not be saved.";

                        }

                        $payment_stmt->close();
                    }

                } else {

                    $form_error =
                        "Unable to save the customer order. Please try again.";

                }

                $stmt->close();
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| LOAD BRANCHES
|--------------------------------------------------------------------------
*/

$branches = [];

$branch_sql = "SELECT *
               FROM branch
               ORDER BY 2 ASC";

$branch_query = $database->query($branch_sql);

if ($branch_query) {

    while ($branch = $branch_query->fetch_row()) {

        if (isset($branch[0], $branch[1], $branch[2])) {

            $branches[] = [

                'id' => $branch[0],

                'branch_name' => $branch[1],

                'branch_code' => $branch[2]

            ];

        }
    }

    $branch_query->free();
}

?>


<style>

    /* ================================
       CUSTOMER FORM DESIGN
    ================================ */

    .customer-section-container {
        width: 100%;
        max-width: 1150px;
        margin: 25px auto;
        padding: 32px;
        background: #ffffff;
        border: 1px solid #e7eaf0;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.07);
    }


    .customer-section-title {
        margin-bottom: 30px;
        padding-bottom: 18px;
        border-bottom: 1px solid #e9edf3;
    }


    .customer-section-title h2 {
        margin: 0;
        color: #1e293b;
        font-size: 27px;
        font-weight: 700;
        letter-spacing: -0.4px;
    }


    /* ================================
       ERROR
    ================================ */

    .form-error {
        margin-bottom: 25px;
        padding: 14px 17px;
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-left: 4px solid #ef4444;
        border-radius: 9px;
        color: #b91c1c;
        font-size: 14px;
        line-height: 1.5;
    }


    /* ================================
       FORM
    ================================ */

    .customer-form {
        width: 100%;
    }


    .customer-form-row {
        display: flex;
        gap: 24px;
        margin-bottom: 22px;
    }


    .customer-form-column {
        flex: 1;
        min-width: 0;
        padding: 23px;
        background: #fafbfe;
        border: 1px solid #e5e9f0;
        border-radius: 13px;
    }


    /* ================================
       HEADINGS
    ================================ */

    .customer-form-column h3 {
        position: relative;
        margin: 0 0 22px;
        padding: 0 0 13px 14px;
        color: #1e293b;
        font-size: 17px;
        font-weight: 700;
        border-bottom: 1px solid #e5e7eb;
    }


    .customer-form-column h3::before {
        content: "";
        position: absolute;
        left: 0;
        top: 1px;
        width: 4px;
        height: 20px;
        background: #4f46e5;
        border-radius: 5px;
    }


    /* ================================
       FORM GROUP
    ================================ */

    .customer-form-group {
        margin-bottom: 19px;
    }


    .customer-form-group:last-child {
        margin-bottom: 0;
    }


    .customer-form-group label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
    }


    /* ================================
       INPUTS
    ================================ */

    .customer-form-group input,
    .customer-form-group select,
    .customer-form-group textarea {
        width: 100%;
        padding: 12px 14px;
        background: #ffffff;
        border: 1px solid #d6dbe4;
        border-radius: 8px;
        color: #1f2937;
        font-family: inherit;
        font-size: 14px;
        line-height: 1.5;
        outline: none;
        box-sizing: border-box;

        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease,
            background-color 0.2s ease;
    }


    .customer-form-group input::placeholder,
    .customer-form-group textarea::placeholder {
        color: #9ca3af;
    }


    .customer-form-group input:hover,
    .customer-form-group select:hover,
    .customer-form-group textarea:hover {
        border-color: #aeb6c3;
    }


    .customer-form-group input:focus,
    .customer-form-group select:focus,
    .customer-form-group textarea:focus {
        border-color: #4f46e5;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.10);
    }


    /* ================================
       TEXTAREA
    ================================ */

    .customer-form-group textarea {
        min-height: 105px;
        resize: vertical;
    }


    /* ================================
       DATE
    ================================ */

    .customer-form-group input[type="date"] {
        cursor: pointer;
    }


    /* ================================
       NUMBER
    ================================ */

    .customer-form-group input[type="number"] {
        appearance: textfield;
    }


    .customer-form-group input[type="number"]::-webkit-inner-spin-button,
    .customer-form-group input[type="number"]::-webkit-outer-spin-button {
        opacity: 1;
    }


    /* ================================
       HELP
    ================================ */

    .weight-help,
    .service-help {
        display: block;
        margin-top: 7px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
    }


    /* ================================
       SELECT
    ================================ */

    .customer-form-group select {
        cursor: pointer;
    }


    /* ================================
       PAYMENT BOX
    ================================ */

    .payment-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 22px;
        margin-bottom: 22px;
    }


    .payment-box-title {
        margin-bottom: 18px;
        color: #1e293b;
        font-size: 17px;
        font-weight: 700;
    }


    .payment-amount {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding: 15px 17px;
        background: #eef2ff;
        border: 1px solid #c7d2fe;
        border-radius: 9px;
    }


    .payment-amount-label {
        color: #475569;
        font-size: 14px;
        font-weight: 600;
    }


    .payment-amount-value {
        color: #4f46e5;
        font-size: 22px;
        font-weight: 700;
    }


    /* ================================
       SUBMIT
    ================================ */

    .submit-area {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
        padding-top: 24px;
        border-top: 1px solid #e9edf3;
    }


    .submit-button {
        min-width: 220px;
        padding: 13px 24px;
        border: none;
        border-radius: 8px;
        background: #4f46e5;
        color: #ffffff;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 5px 14px rgba(79, 70, 229, 0.20);

        transition:
            background-color 0.2s ease,
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }


    .submit-button:hover {
        background: #4338ca;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(79, 70, 229, 0.25);
    }


    /* ================================
       RECEIPT
    ================================ */

    .receipt-container {
        width: 100%;
        max-width: 700px;
        margin: 30px auto;
        padding: 30px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
    }


    .receipt-header {
        text-align: center;
        padding-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
    }


    .receipt-header h2 {
        margin: 0 0 8px;
        color: #1e293b;
    }


    .receipt-header p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }


    .receipt-details {
        margin-top: 20px;
    }


    .receipt-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }


    .receipt-row span:first-child {
        color: #64748b;
    }


    .receipt-row span:last-child {
        color: #1e293b;
        font-weight: 600;
    }


    .receipt-total {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding: 17px;
        background: #eef2ff;
        border-radius: 9px;
        color: #4f46e5;
        font-size: 18px;
        font-weight: 700;
    }


    .print-button {
        display: block;
        width: 100%;
        margin-top: 20px;
        padding: 12px;
        border: none;
        border-radius: 8px;
        background: #16a34a;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }


    .print-button:hover {
        background: #15803d;
    }


    /* ================================
       MOBILE
    ================================ */

    @media (max-width: 900px) {

        .customer-form-row {
            flex-direction: column;
            gap: 0;
        }

        .customer-form-column {
            margin-bottom: 20px;
        }

    }


    @media (max-width: 600px) {

        .customer-section-container {
            width: calc(100% - 20px);
            margin: 15px auto;
            padding: 20px;
            border-radius: 12px;
        }

        .customer-section-title h2 {
            font-size: 23px;
        }

        .customer-form-column {
            padding: 18px;
        }

        .submit-area {
            justify-content: stretch;
            flex-direction: column;
        }

        .submit-button {
            width: 100%;
            min-width: 0;
        }

        .payment-amount {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .receipt-container {
            padding: 20px;
        }

    }


    /* ================================
       PRINT RECEIPT
    ================================ */

    @media print {

        body * {
            visibility: hidden;
        }

        .receipt-container,
        .receipt-container * {
            visibility: visible;
        }

        .receipt-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: none;
            box-shadow: none;
            border: none;
        }

        .print-button {
            display: none;
        }

    }

</style>


<div class="customer-section-container">

    <div class="customer-section-title">

        <h2>
            Customer Details
        </h2>

    </div>


    <?php if ($form_error !== ""): ?>

        <div class="form-error">

            <?php
            echo htmlspecialchars(
                $form_error,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </div>

    <?php endif; ?>


    <form
        method="POST"
        action=""
        class="customer-form"
        autocomplete="off"
    >

        <input
            type="hidden"
            name="csrf_token"
            value="<?php
            echo htmlspecialchars(
                $csrf_token,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>"
        >


        <input
            type="hidden"
            name="submitted"
            value="1"
        >


        <!-- =========================================================
             SENDER + RECEIVER
        ========================================================== -->

        <div class="customer-form-row">


            <!-- SENDER -->

            <div class="customer-form-column">

                <h3>
                    Sender Information
                </h3>


                <div class="customer-form-group">

                    <label for="senderName">
                        Sender Name
                    </label>

                    <input
                        type="text"
                        id="senderName"
                        name="senderName"
                        maxlength="100"
                        required
                        value="<?php
                        echo htmlspecialchars(
                            $_POST['senderName'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>"
                    >

                </div>


                <div class="customer-form-group">

                    <label for="senderAddress">
                        Sender Address
                    </label>

                    <textarea
                        id="senderAddress"
                        name="senderAddress"
                        maxlength="500"
                        required
                    ><?php
                    echo htmlspecialchars(
                        $_POST['senderAddress'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?></textarea>

                </div>


                <div class="customer-form-group">

                    <label for="senderPhone">
                        Sender Phone
                    </label>

                    <input
                        type="tel"
                        id="senderPhone"
                        name="senderPhone"
                        maxlength="30"
                        required
                        value="<?php
                        echo htmlspecialchars(
                            $_POST['senderPhone'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>"
                    >

                </div>

            </div>


            <!-- RECEIVER -->

            <div class="customer-form-column">

                <h3>
                    Receiver Information
                </h3>


                <div class="customer-form-group">

                    <label for="receiverName">
                        Receiver Name
                    </label>

                    <input
                        type="text"
                        id="receiverName"
                        name="receiverName"
                        maxlength="100"
                        required
                        value="<?php
                        echo htmlspecialchars(
                            $_POST['receiverName'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>"
                    >

                </div>


                <div class="customer-form-group">

                    <label for="receiverAddress">
                        Receiver Address
                    </label>

                    <textarea
                        id="receiverAddress"
                        name="receiverAddress"
                        maxlength="500"
                        required
                    ><?php
                    echo htmlspecialchars(
                        $_POST['receiverAddress'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?></textarea>

                </div>


                <div class="customer-form-group">

                    <label for="receiverPhone">
                        Receiver Phone
                    </label>

                    <input
                        type="tel"
                        id="receiverPhone"
                        name="receiverPhone"
                        maxlength="30"
                        required
                        value="<?php
                        echo htmlspecialchars(
                            $_POST['receiverPhone'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>"
                    >

                </div>

            </div>

        </div>


        <!-- =========================================================
             SERVICE + BRANCH
        ========================================================== -->

        <div class="customer-form-row">


            <div class="customer-form-column">

                <div class="customer-form-group">

                    <label for="service">
                        Service Type
                    </label>

                    <select
                        id="service"
                        name="service"
                        required
                    >

                        <option value="">
                            Select Service
                        </option>

                        <option
                            value="Standard"
                            <?php
                            echo (
                                ($_POST['service'] ?? '') === 'Standard'
                            )
                            ? 'selected'
                            : '';
                            ?>
                        >
                            Standard
                        </option>

                        <option
                            value="Express"
                            <?php
                            echo (
                                ($_POST['service'] ?? '') === 'Express'
                            )
                            ? 'selected'
                            : '';
                            ?>
                        >
                            Express
                        </option>

                    </select>


                    <span class="service-help">

                        Select the delivery service required for this parcel.

                    </span>

                </div>

            </div>


            <div class="customer-form-column">

                <div class="customer-form-group">

                    <label for="senderBranch">
                        Sender Branch
                    </label>

                    <select
                        id="senderBranch"
                        name="senderBranch"
                    >

                        <option value="">
                            Select Sender Branch
                        </option>


                        <?php foreach ($branches as $branch): ?>

                            <option
                                value="<?php
                                echo htmlspecialchars(
                                    $branch['id'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
                            >

                                <?php
                                echo htmlspecialchars(
                                    $branch['id'] .
                                    ' ' .
                                    $branch['branch_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>

        </div>


        <div class="customer-form-row">


            <div class="customer-form-column">

                <div class="customer-form-group">

                    <label for="receiverBranch">
                        Receiver Branch
                    </label>

                    <select
                        id="receiverBranch"
                        name="receiverBranch"
                    >

                        <option value="">
                            Select Receiver Branch
                        </option>


                        <?php foreach ($branches as $branch): ?>

                            <option
                                value="<?php
                                echo htmlspecialchars(
                                    $branch['id'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>"
                            >

                                <?php
                                echo htmlspecialchars(
                                    $branch['id'] .
                                    ' ' .
                                    $branch['branch_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>


            <div class="customer-form-column">
                &nbsp;
            </div>

        </div>


        <!-- =========================================================
             PRODUCT
        ========================================================== -->

        <div class="customer-form-row">


            <div class="customer-form-column">

                <div class="customer-form-group">

                    <label for="receiverProduct">
                        Product
                    </label>

                    <input
                        type="text"
                        id="receiverProduct"
                        name="receiverProduct"
                        maxlength="255"
                        required
                        value="<?php
                        echo htmlspecialchars(
                            $_POST['receiverProduct'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>"
                    >

                </div>

            </div>


            <div class="customer-form-column">

                <div class="customer-form-group">

                    <label for="date">
                        Date of Order
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        required
                        value="<?php
                        echo htmlspecialchars(
                            $_POST['date'] ??
                            date('Y-m-d'),
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>"
                    >

                </div>

            </div>

        </div>


        <!-- =========================================================
             WEIGHT
        ========================================================== -->

        <div class="customer-form-row">


            <div class="customer-form-column">

                <div class="customer-form-group">

                    <label for="weight">
                        Weight (grams)
                    </label>

                    <input
                        type="number"
                        id="weight"
                        name="weight"
                        min="1"
                        max="20000"
                        step="1"
                        required
                        value="<?php
                        echo htmlspecialchars(
                            $_POST['weight'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>"
                    >


                    <span class="weight-help">

                        1–1000g: 150 |
                        1001–5000g: 750 |
                        5001–7000g: 1050 |
                        7001–10000g: 1800 |
                        10001–15000g: 2500 |
                        15001–20000g: 3500

                    </span>

                </div>

            </div>


            <div class="customer-form-column">
                &nbsp;
            </div>

        </div>


        <!-- =========================================================
             PAYMENT
        ========================================================== -->

        <div class="payment-box">

            <div class="payment-box-title">

                Payment Information

            </div>


            <div class="payment-amount">

                <span class="payment-amount-label">

                    Delivery Amount

                </span>


                <span
                    class="payment-amount-value"
                    id="paymentAmount"
                >

                    ৳0

                </span>

            </div>


            <div class="customer-form-group">

                <label for="payment-method">

                    Payment Method

                </label>


                <select
                    id="payment-method"
                    name="payment_method"
                    required
                >

                    <option value="">
                        Select Payment Method
                    </option>

                    <option value="Cash">
                        Cash
                    </option>

                    <option value="Credit Card">
                        Credit Card
                    </option>

                    <option value="PayPal">
                        PayPal
                    </option>

                    <option value="Bank Transfer">
                        Bank Transfer
                    </option>

                </select>

            </div>

        </div>


        <!-- =========================================================
             SUBMIT
        ========================================================== -->

        <div class="submit-area">

            <button
                type="submit"
                class="submit-button"
            >

                Create Customer Order & Payment

            </button>

        </div>

    </form>

</div>


<!-- =========================================================
     RECEIPT
========================================================== -->

<?php if ($receipt_data !== null): ?>

    <div
        class="receipt-container"
        id="receipt"
    >

        <div class="receipt-header">

            <h2>
                Payment Receipt
            </h2>

            <p>
                Courier System
            </p>

        </div>


        <div class="receipt-details">


            <div class="receipt-row">

                <span>
                    Order ID
                </span>

                <span>
                    #
                    <?php
                    echo htmlspecialchars(
                        $receipt_data['order_id'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>


            <div class="receipt-row">

                <span>
                    Customer
                </span>

                <span>
                    <?php
                    echo htmlspecialchars(
                        $receipt_data['customer_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>


            <div class="receipt-row">

                <span>
                    Receiver
                </span>

                <span>
                    <?php
                    echo htmlspecialchars(
                        $receipt_data['receiver_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>


            <div class="receipt-row">

                <span>
                    Product
                </span>

                <span>
                    <?php
                    echo htmlspecialchars(
                        $receipt_data['product'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>


            <div class="receipt-row">

                <span>
                    Service
                </span>

                <span>
                    <?php
                    echo htmlspecialchars(
                        $receipt_data['service_type'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>


            <div class="receipt-row">

                <span>
                    Weight
                </span>

                <span>
                    <?php
                    echo htmlspecialchars(
                        $receipt_data['weight'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                    grams
                </span>

            </div>


            <div class="receipt-row">

                <span>
                    Payment Method
                </span>

                <span>
                    <?php
                    echo htmlspecialchars(
                        $receipt_data['payment_method'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>


            <div class="receipt-row">

                <span>
                    Payment Date
                </span>

                <span>
                    <?php
                    echo htmlspecialchars(
                        $receipt_data['payment_date'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>


            <div class="receipt-total">

                <span>
                    Total Paid
                </span>

                <span>

                    ৳<?php
                    echo number_format(
                        $receipt_data['amount'],
                        2
                    );
                    ?>

                </span>

            </div>


            <button
                type="button"
                class="print-button"
                onclick="window.print()"
            >

                Generate / Print Receipt

            </button>

        </div>

    </div>

<?php endif; ?>


<script>

    /*
    |--------------------------------------------------------------------------
    | CALCULATE DELIVERY PRICE
    |--------------------------------------------------------------------------
    */

    const weightInput =
        document.getElementById('weight');

    const paymentAmount =
        document.getElementById('paymentAmount');


    function updatePaymentAmount() {

        const weight =
            parseFloat(weightInput.value) || 0;

        let amount = 0;


        if (weight > 0 && weight <= 1000) {

            amount = 150;

        } else if (weight <= 5000 && weight > 1000) {

            amount = 750;

        } else if (weight <= 7000 && weight > 5000) {

            amount = 1050;

        } else if (weight <= 10000 && weight > 7000) {

            amount = 1800;

        } else if (weight <= 15000 && weight > 10000) {

            amount = 2500;

        } else if (weight <= 20000 && weight > 15000) {

            amount = 3500;

        }


        paymentAmount.textContent =
            "৳" + amount.toLocaleString();

    }


    if (weightInput) {

        weightInput.addEventListener(
            'input',
            updatePaymentAmount
        );

        updatePaymentAmount();

    }


    /*
    |--------------------------------------------------------------------------
    | AUTO SCROLL TO RECEIPT
    |--------------------------------------------------------------------------
    */

    <?php if ($receipt_data !== null): ?>

        window.addEventListener(
            'load',
            function() {

                const receipt =
                    document.getElementById('receipt');

                if (receipt) {

                    receipt.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                }

            }
        );

    <?php endif; ?>

</script>