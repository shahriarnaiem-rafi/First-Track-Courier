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
$form_success = "";
$search_query = trim($_GET['search'] ?? $_POST['search_order'] ?? "");


/*
|--------------------------------------------------------------------------
| DELETE ORDER
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {

    $submitted_token = $_POST['csrf_token'] ?? "";

    if (
        empty($submitted_token) ||
        empty($_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $submitted_token)
    ) {
        $form_error = "Invalid form request. Please refresh the page and try again.";
    } else {

        $order_id = filter_var(
            $_POST['order_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($order_id === false || $order_id <= 0) {

            $form_error = "Invalid order ID.";

        } else {

            $stmt = $database->prepare(
                "DELETE FROM customer_section WHERE id = ?"
            );

            if (!$stmt) {

                $form_error = "Unable to prepare the delete request.";

            } else {

                $stmt->bind_param("i", $order_id);

                if ($stmt->execute()) {

                    if ($stmt->affected_rows > 0) {
                        $form_success = "Order #{$order_id} was deleted successfully.";
                    } else {
                        $form_error = "Order #{$order_id} was not found.";
                    }

                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    $csrf_token = $_SESSION['csrf_token'];

                } else {

                    $form_error = "Unable to delete the order.";

                }

                $stmt->close();
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| UPDATE DELIVERY STATUS
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {

    $submitted_token = $_POST['csrf_token'] ?? "";

    if (
        empty($submitted_token) ||
        empty($_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $submitted_token)
    ) {
        $form_error = "Invalid form request. Please refresh the page and try again.";
    } else {

        $order_id = filter_var(
            $_POST['order_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $new_status = trim($_POST['delivery_status'] ?? "");

        $allowed_statuses = [
            "pending",
            "Received",
            "In Transit",
            "Delivered",
            "Cancelled"
        ];

        if ($order_id === false || $order_id <= 0) {

            $form_error = "Invalid order ID.";

        } elseif (!in_array($new_status, $allowed_statuses, true)) {

            $form_error = "Invalid delivery status.";

        } else {

            $stmt = $database->prepare(
                "UPDATE customer_section
                 SET status = ?
                 WHERE id = ?"
            );

            if (!$stmt) {

                $form_error = "Unable to prepare the status update.";

            } else {

                $stmt->bind_param(
                    "si",
                    $new_status,
                    $order_id
                );

                if ($stmt->execute()) {

                    if ($stmt->affected_rows > 0) {
                        $form_success = "Order #{$order_id} status updated successfully.";
                    } else {
                        $form_success = "Order #{$order_id} status is already {$new_status}.";
                    }

                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    $csrf_token = $_SESSION['csrf_token'];

                } else {

                    $form_error = "Unable to update the order status.";

                }

                $stmt->close();
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| LOAD ORDERS
|--------------------------------------------------------------------------
*/

$orders = [];

if ($search_query !== "") {

    $search_like = "%" . $search_query . "%";

    $stmt = $database->prepare(
        "SELECT
            id,
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
            status,
            order_time
         FROM customer_section
         WHERE CAST(id AS CHAR) LIKE ?
         ORDER BY id DESC"
    );

    if ($stmt) {

        $stmt->bind_param("s", $search_like);

        if ($stmt->execute()) {

            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }

            $result->free();

        } else {

            $form_error = "Unable to search orders.";
        }

        $stmt->close();

    } else {

        $form_error = "Unable to prepare the order search.";
    }

} else {

    $query = "
        SELECT
            id,
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
            status,
            order_time
        FROM customer_section
        ORDER BY id DESC
    ";

    $result = $database->query($query);

    if ($result) {

        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        $result->free();

    } else {

        $form_error = "Unable to load orders.";
    }
}


/*
|--------------------------------------------------------------------------
| HELPER FOR HTML OUTPUT
|--------------------------------------------------------------------------
*/

function order_html($value)
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}


/*
|--------------------------------------------------------------------------
| NORMALIZE STATUS CLASS
|--------------------------------------------------------------------------
*/

function status_class($status)
{
    $status = strtolower(trim((string)$status));

    return str_replace(
        [' ', '_'],
        '_',
        $status
    );
}

?>

<style>

    .order-list-container {
        width: 100%;
        margin-top: 20px;
    }

    .order-list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .order-list-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .order-search {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .order-search input {
        min-width: 220px;
        padding: 9px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
    }

    .order-search input:focus {
        border-color: #007bff;
    }

    .order-search button {
        border: none;
        padding: 9px 16px;
        border-radius: 6px;
        cursor: pointer;
    }

    .order-alert {
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .order-alert.error {
        background: #ffe6e6;
        border: 1px solid #ffb3b3;
        color: #b30000;
    }

    .order-alert.success {
        background: #e7f7ec;
        border: 1px solid #b5e2c0;
        color: #176b2c;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
        background: #fff;
        border-radius: 8px;
    }

    .order-table {
        width: 100%;
        min-width: 1200px;
        border-collapse: collapse;
    }

    .order-table thead {
        background-color: #007bff;
        color: #fff;
    }

    .order-table th,
    .order-table td {
        padding: 9px;
        border: 1px solid #ddd;
        text-align: left;
        vertical-align: middle;
    }

    .order-table th {
        font-weight: bold;
        white-space: nowrap;
    }

    .order-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .order-table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .status {
        display: inline-block;
        font-weight: bold;
        padding: 5px 8px;
        border-radius: 4px;
        white-space: nowrap;
    }

    .status.pending {
        color: #856404;
        background-color: #fff3cd;
    }

    .status.received {
        color: #004085;
        background-color: #cce5ff;
    }

    .status.in_transit {
        color: #0d6efd;
        background-color: #cce5ff;
    }

    .status.delivered {
        color: #155724;
        background-color: #d4edda;
    }

    .status.cancelled {
        color: #721c24;
        background-color: #f8d7da;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .action-buttons a,
    .action-buttons button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-size: 19px;
    }

    .edit-action {
        color: green;
    }

    .delete-action {
        color: red;
    }

    .print-action {
        color: blue;
    }

    .empty-orders {
        text-align: center;
        padding: 30px;
        color: #777;
    }

    .modal-body label {
        font-weight: 500;
    }

    @media (max-width: 768px) {

        .order-list-header {
            align-items: stretch;
        }

        .order-search {
            width: 100%;
        }

        .order-search input {
            min-width: 0;
            flex: 1;
        }

    }

</style>


<div class="order-list-container">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="order-list-header">

        <h3>
            Order List
        </h3>

        <form
            action=""
            method="GET"
            class="order-search"
        >

            <input
                type="search"
                name="search"
                value="<?php echo order_html($search_query); ?>"
                placeholder="Search by Order ID"
            >

            <button
                type="submit"
                class="btn btn-primary"
            >
                Search
            </button>

            <?php if ($search_query !== ""): ?>

                <a
                    href="index.php"
                    class="btn btn-secondary"
                >
                    Clear
                </a>

            <?php endif; ?>

        </form>

    </div>


    <!-- =========================================================
         ALERTS
    ========================================================== -->

    <?php if ($form_error !== ""): ?>

        <div class="order-alert error">
            <?php echo order_html($form_error); ?>
        </div>

    <?php endif; ?>


    <?php if ($form_success !== ""): ?>

        <div class="order-alert success">
            <?php echo order_html($form_success); ?>
        </div>

    <?php endif; ?>


    <!-- =========================================================
         ORDER TABLE
    ========================================================== -->

    <div class="table-container">

        <table class="order-table">

            <thead>

                <tr>

                    <th>Order ID</th>

                    <th>Service Type</th>

                    <th>Sender Name</th>

                    <th>Pickup Location</th>

                    <th>Sender Phone</th>

                    <th>Receiver Name</th>

                    <th>Delivery Location</th>

                    <th>Receiver Phone</th>

                    <th>Product</th>

                    <th>Weight (gm)</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

            <?php if (empty($orders)): ?>

                <tr>

                    <td
                        colspan="12"
                        class="empty-orders"
                    >
                        <?php
                        echo $search_query !== ""
                            ? "No orders found for this Order ID."
                            : "No orders available.";
                        ?>
                    </td>

                </tr>

            <?php else: ?>

                <?php foreach ($orders as $row): ?>

                    <?php
                    $order_id = (int)$row['id'];

                    $service = order_html($row['service_type']);
                    $sender_name = order_html($row['sender_name']);
                    $sender_address = order_html($row['sender_address']);
                    $sender_phone = order_html($row['sender_phone']);

                    $receiver_name = order_html($row['receiver_name']);
                    $receiver_address = order_html($row['receiver_address']);
                    $receiver_phone = order_html($row['receiver_phone']);

                    $product = order_html($row['product']);
                    $weight = order_html($row['weight']);
                    $money = order_html($row['money']);
                    $date = order_html($row['date_of_order']);

                    $status_raw = trim((string)$row['status']);

                    $status_display = order_html($status_raw);
                    $status_css = status_class($status_raw);

                    /*
                    |--------------------------------------------------------------------------
                    | Data attributes are escaped
                    |--------------------------------------------------------------------------
                    */

                    $data_service = order_html($row['service_type']);
                    $data_sendername = order_html($row['sender_name']);
                    $data_senderaddress = order_html($row['sender_address']);
                    $data_senderphone = order_html($row['sender_phone']);

                    $data_receivername = order_html($row['receiver_name']);
                    $data_receiveraddress = order_html($row['receiver_address']);
                    $data_receiverphone = order_html($row['receiver_phone']);

                    $data_weight = order_html($row['weight']);
                    $data_money = order_html($row['money']);
                    $data_date = order_html($row['date_of_order']);
                    ?>

                    <tr>

                        <td>
                            <?php echo $order_id; ?>
                        </td>


                        <td>
                            <?php echo $service; ?>
                        </td>


                        <td>
                            <?php echo $sender_name; ?>
                        </td>


                        <td>
                            <?php echo $sender_address; ?>
                        </td>


                        <td>
                            <?php echo $sender_phone; ?>
                        </td>


                        <td>
                            <?php echo $receiver_name; ?>
                        </td>


                        <td>
                            <?php echo $receiver_address; ?>
                        </td>


                        <td>
                            <?php echo $receiver_phone; ?>
                        </td>


                        <td>
                            <?php echo $product; ?>
                        </td>


                        <td>

                            <?php echo $weight; ?>

                            <br>

                            <span>
                                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                <?php echo $money; ?>
                            </span>

                        </td>


                        <td>

                            <span
                                class="status <?php echo order_html($status_css); ?>"
                            >
                                <?php echo $status_display; ?>
                            </span>

                        </td>


                        <td>

                            <div class="action-buttons">

                                <!-- EDIT STATUS -->

                                <button
                                    type="button"
                                    class="edit-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    data-id="<?php echo $order_id; ?>"
                                    data-status="<?php echo order_html($status_raw); ?>"
                                    title="Update Status"
                                >

                                    <i class="fa-solid fa-pen-to-square"></i>

                                </button>


                                <!-- DELETE -->

                                <form
                                    method="POST"
                                    action=""
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete Order #<?php echo $order_id; ?>?');"
                                >

                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?php echo order_html($csrf_token); ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="order_id"
                                        value="<?php echo $order_id; ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="delete_order"
                                        class="delete-action"
                                        title="Delete Order"
                                    >

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>


                                <!-- PRINT -->

                                <button
                                    type="button"
                                    class="print-id print-action"
                                    data-service="<?php echo $data_service; ?>"
                                    data-sendername="<?php echo $data_sendername; ?>"
                                    data-senderaddress="<?php echo $data_senderaddress; ?>"
                                    data-senderphone="<?php echo $data_senderphone; ?>"
                                    data-receivername="<?php echo $data_receivername; ?>"
                                    data-receiveraddress="<?php echo $data_receiveraddress; ?>"
                                    data-receiverphone="<?php echo $data_receiverphone; ?>"
                                    data-weight="<?php echo $data_weight; ?>"
                                    data-money="<?php echo $data_money; ?>"
                                    data-date="<?php echo $data_date; ?>"
                                    data-id="<?php echo $order_id; ?>"
                                    title="Print Receipt"
                                >

                                    <i class="fa-solid fa-print"></i>

                                </button>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>


<!-- =============================================================
     UPDATE STATUS MODAL
============================================================== -->

<div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="exampleModalLabel"
                >
                    Update Order Status
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <form
                    id="updateStatusForm"
                    method="POST"
                    action=""
                >

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?php echo order_html($csrf_token); ?>"
                    >

                    <input
                        type="hidden"
                        id="order-id"
                        name="order_id"
                        value=""
                    >


                    <div class="mb-3">

                        <label
                            for="delivery-status"
                            class="form-label"
                        >
                            Delivery Status
                        </label>


                        <select
                            class="form-select"
                            id="delivery-status"
                            name="delivery_status"
                            required
                        >

                            <option value="pending">
                                Pending
                            </option>

                            <option value="Received">
                                Received
                            </option>

                            <option value="In Transit">
                                In Transit
                            </option>

                            <option value="Delivered">
                                Delivered
                            </option>

                            <option value="Cancelled">
                                Cancelled
                            </option>

                        </select>

                    </div>


                    <button
                        type="submit"
                        name="update_status"
                        value="1"
                        class="btn btn-primary"
                    >
                        Update Status
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<!-- =============================================================
     BOOTSTRAP JS
============================================================== -->

<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>


<!-- =============================================================
     STATUS MODAL JAVASCRIPT
============================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const exampleModal = document.getElementById('exampleModal');

    if (!exampleModal) {
        return;
    }

    exampleModal.addEventListener(
        'show.bs.modal',
        function (event) {

            const button = event.relatedTarget;

            if (!button) {
                return;
            }

            const orderId =
                button.getAttribute('data-id');

            const currentStatus =
                button.getAttribute('data-status');

            const orderIdInput =
                document.getElementById('order-id');

            const statusInput =
                document.getElementById('delivery-status');

            if (orderIdInput) {
                orderIdInput.value = orderId || '';
            }

            if (statusInput) {

                const statusExists =
                    Array.from(statusInput.options)
                        .some(function (option) {
                            return option.value === currentStatus;
                        });

                if (statusExists) {
                    statusInput.value = currentStatus;
                } else {
                    statusInput.value = 'pending';
                }
            }

        }
    );

});

</script>


<!-- =============================================================
     PRINT RECEIPT
============================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.print-id').forEach(function (printButton) {

        printButton.addEventListener('click', function (event) {

            event.preventDefault();

            const service =
                this.getAttribute('data-service') || '';

            const senderName =
                this.getAttribute('data-sendername') || '';

            const senderAddress =
                this.getAttribute('data-senderaddress') || '';

            const senderPhone =
                this.getAttribute('data-senderphone') || '';

            const receiverName =
                this.getAttribute('data-receivername') || '';

            const receiverAddress =
                this.getAttribute('data-receiveraddress') || '';

            const receiverPhone =
                this.getAttribute('data-receiverphone') || '';

            const weight =
                this.getAttribute('data-weight') || '';

            const money =
                this.getAttribute('data-money') || '';

            const date =
                this.getAttribute('data-date') || '';

            const orderId =
                this.getAttribute('data-id') || '';


            generatePDF(
                service,
                senderName,
                senderAddress,
                senderPhone,
                receiverName,
                receiverAddress,
                receiverPhone,
                weight,
                money,
                date,
                orderId
            );

        });

    });

});


/*
|--------------------------------------------------------------------------
| ESCAPE HTML FOR PRINT RECEIPT
|--------------------------------------------------------------------------
*/

function escapeReceiptHtml(value) {

    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

}


/*
|--------------------------------------------------------------------------
| GENERATE PRINT RECEIPT
|--------------------------------------------------------------------------
*/

function generatePDF(
    service,
    senderName,
    senderAddress,
    senderPhone,
    receiverName,
    receiverAddress,
    receiverPhone,
    weight,
    money,
    date,
    orderId
) {

    const receiptWindow = window.open(
        '',
        '_blank',
        'height=700,width=800'
    );

    if (!receiptWindow) {

        alert(
            'Please allow pop-ups in your browser to print the receipt.'
        );

        return;
    }


    const safeService =
        escapeReceiptHtml(service);

    const safeSenderName =
        escapeReceiptHtml(senderName);

    const safeSenderAddress =
        escapeReceiptHtml(senderAddress);

    const safeSenderPhone =
        escapeReceiptHtml(senderPhone);

    const safeReceiverName =
        escapeReceiptHtml(receiverName);

    const safeReceiverAddress =
        escapeReceiptHtml(receiverAddress);

    const safeReceiverPhone =
        escapeReceiptHtml(receiverPhone);

    const safeWeight =
        escapeReceiptHtml(weight);

    const safeMoney =
        escapeReceiptHtml(money);

    const safeDate =
        escapeReceiptHtml(date);

    const safeOrderId =
        escapeReceiptHtml(orderId);


    receiptWindow.document.write(`
        <!DOCTYPE html>

        <html>

        <head>

            <meta charset="UTF-8">

            <title>
                Fast-Track-Courier Receipt
            </title>

            <style>

                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    background: #f4f4f4;
                }

                .receipt {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    border-radius: 10px;
                    background: #fff;
                    box-shadow:
                        0 4px 10px rgba(0,0,0,0.1);
                    border-top: 5px solid #007BFF;
                }

                .logo {
                    display: block;
                    margin: 0 auto 10px auto;
                    height: 100px;
                    width: 100px;
                    object-fit: contain;
                }

                h1,
                h2,
                h3 {
                    text-align: center;
                    color: #333;
                    margin-bottom: 10px;
                }

                p {
                    margin: 5px 0;
                    font-size: 16px;
                }

                strong {
                    color: #333;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }

                table,
                th,
                td {
                    border: 1px solid #ddd;
                }

                th,
                td {
                    padding: 10px;
                    text-align: left;
                }

                th {
                    background: #007BFF;
                    color: white;
                    font-weight: bold;
                }

                .button {
                    margin-top: 20px;
                    text-align: center;
                }

                .button button {
                    margin: 10px;
                    padding: 10px 15px;
                    border: none;
                    border-radius: 5px;
                    background: #007BFF;
                    color: white;
                    cursor: pointer;
                    font-size: 16px;
                }

                .website {
                    text-align: center;
                    font-size: 14px;
                }

                @media print {

                    body {
                        background: white;
                        margin: 0;
                    }

                    .receipt {
                        box-shadow: none;
                        margin: 0 auto;
                    }

                    .button {
                        display: none;
                    }

                }

            </style>

        </head>


        <body>

            <div class="receipt">

                <img
                    src="https://i.ibb.co/hx2RKnfN/logo2.png"
                    alt="Fast-Track-Courier Logo"
                    class="logo"
                >

                <h1>
                    Fast-Track-Courier Receipt
                </h1>

                <h2>
                    Order ID: ${safeOrderId}
                </h2>

                <h3>
                    Date: ${safeDate}
                </h3>


                <table>

                    <tr>
                        <th colspan="2">
                            Sender Information
                        </th>
                    </tr>

                    <tr>
                        <td>
                            <strong>Service Type:</strong>
                        </td>

                        <td>
                            ${safeService}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Name:</strong>
                        </td>

                        <td>
                            ${safeSenderName}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Address:</strong>
                        </td>

                        <td>
                            ${safeSenderAddress}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Phone:</strong>
                        </td>

                        <td>
                            ${safeSenderPhone}
                        </td>
                    </tr>


                    <tr>
                        <th colspan="2">
                            Receiver Information
                        </th>
                    </tr>

                    <tr>
                        <td>
                            <strong>Name:</strong>
                        </td>

                        <td>
                            ${safeReceiverName}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Address:</strong>
                        </td>

                        <td>
                            ${safeReceiverAddress}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Phone:</strong>
                        </td>

                        <td>
                            ${safeReceiverPhone}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Weight:</strong>
                        </td>

                        <td>
                            ${safeWeight} grams
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Cost:</strong>
                        </td>

                        <td>
                            ৳${safeMoney}
                        </td>
                    </tr>

                </table>


                <p class="website">
                    <a
                        href="https://shahriarnaiem.online/"
                        target="_blank"
                    >
                        Visit Our Website
                    </a>
                </p>


                <div class="button">

                    <button
                        onclick="window.print()"
                    >
                        Print
                    </button>

                    <button
                        onclick="window.close()"
                    >
                        Close
                    </button>

                </div>

            </div>

        </body>

        </html>
    `);


    receiptWindow.document.close();

    receiptWindow.focus();

}

</script>