<?php
session_start();

// Database connection
$database = mysqli_connect("localhost", "root", "", "fasttrack");

// Check database connection
if (!$database) {
    die("Database connection failed: " . mysqli_connect_error());
}

$order_id = "";
$status = null;
$error_message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get Order ID
    $order_id = trim($_POST['order_id'] ?? '');

    // Validate Order ID
    if ($order_id === '') {
        $error_message = "Please enter an Order ID.";

    } elseif (!ctype_digit($order_id)) {
        $error_message = "Order ID must contain numbers only.";

    } else {

        $order_id = (int) $order_id;

        // Search order
        $query = "SELECT status FROM customer_section WHERE id = ?";

        $stmt = mysqli_prepare($database, $query);

        if (!$stmt) {

            $error_message = "Unable to process your request.";

        } else {

            mysqli_stmt_bind_param($stmt, "i", $order_id);
            mysqli_stmt_execute($stmt);

            mysqli_stmt_bind_result($stmt, $status);

            if (!mysqli_stmt_fetch($stmt)) {
                $status = null;
                $error_message = "No data found for the provided Order ID.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Track Your Order</title>

    <link rel="shortcut icon"
          href="../img/logo2.png"
          type="image/x-icon">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css"
          rel="stylesheet"
          type="text/css" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9NaoW3Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">

    <style>

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* =========================
           NAVBAR
        ========================== */

        .navbar {
            min-height: 90px;
        }

        .navbar-start {
            display: flex;
            align-items: center;
        }

        .navbar-end {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-name {
            color: orange;
            text-decoration: none;
            font-size: 24px;
            line-height: 1.2;
            margin-left: 10px;
        }

        .brand-name:hover {
            color: darkorange;
        }

        .my-btn:hover {
            background-color: black;
            color: white;
        }


        /* =========================
           TRACKING CONTAINER
        ========================== */

        .tracking-container {

            width: 500px;

            max-width: 90%;

            margin: 40px auto;

            background-color: rgba(255, 255, 255, 0.95);

            padding: 30px;

            border-radius: 12px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.1);

            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .tracking-container h2 {

            text-align: center;

            margin-bottom: 30px;

            font-size: 30px;

            font-weight: bold;

            color: #333;
        }


        /* =========================
           FORM
        ========================== */

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {

            display: block;

            margin-bottom: 10px;

            font-weight: bold;

            font-size: 17px;

            color: #555;
        }

        .form-group input {

            width: 100%;

            padding: 12px;

            font-size: 16px;

            border: 1px solid #ccc;

            border-radius: 8px;

            background-color: #f9f9f9;

            transition: 0.3s;
        }

        .form-group input:focus {

            border-color: #007bff;

            background-color: white;

            outline: none;
        }


        /* =========================
           SEARCH BUTTON
        ========================== */

        .form-actions {
            text-align: center;
        }

        .form-actions button {

            padding: 12px 30px;

            font-size: 18px;

            border: none;

            border-radius: 8px;

            cursor: pointer;

            background-color: #007bff;

            color: white;

            transition: 0.3s;
        }

        .form-actions button:hover {
            background-color: #0056b3;
        }


        /* =========================
           SUCCESS MESSAGE
        ========================== */

        .success-message {

            margin-top: 30px;

            padding: 20px;

            background-color: #e8f7ee;

            border: 1px solid #b8e0c2;

            border-radius: 8px;

            color: #333;
        }

        .success-message strong {
            color: #007bff;
        }


        /* =========================
           ERROR MESSAGE
        ========================== */

        .error-message {

            margin-top: 20px;

            padding: 15px;

            background-color: #ffe5e5;

            border: 1px solid #ffb3b3;

            border-radius: 8px;

            color: #dc3545;

            text-align: center;

            font-weight: bold;
        }


        /* =========================
           DASHBOARD SECTION
        ========================== */

        .dashboard-section {

            min-height: 220px;

            background-color: aqua;

            display: flex;

            align-items: center;

            justify-content: center;

            text-align: center;
        }


        /* =========================
           FOOTER
        ========================== */

        footer {
            margin-top: 0;
        }


        /* =========================
           MOBILE
        ========================== */

        @media (max-width: 768px) {

            .navbar {

                flex-direction: column;

                padding: 15px;
            }

            .navbar-start {

                width: 100%;

                justify-content: center;

                margin-bottom: 15px;
            }

            .navbar-end {

                width: 100%;

                justify-content: center;
            }

            .brand-name {
                font-size: 20px;
            }

            .tracking-container {
                padding: 20px;
            }
        }

    </style>

</head>


<body>


<!-- ==========================================
     NAVBAR
=========================================== -->

<nav>

    <div class="navbar bg-base-100 container mx-auto">


        <!-- LEFT SIDE -->
        <div class="navbar-start">

            <a href="../home.php">

                <img src="../img/logo2.png"
                     alt="Fast-track Courier Service Logo"
                     style="width:120px; border-radius:50px;">

            </a>


            <a href="../home.php"
               class="brand-name">

                Fast-track Courier
                <br>
                Service (Pvt.) Ltd.

            </a>

        </div>


        <!-- RIGHT SIDE -->
        <div class="navbar-end">

            <a href="../home.php"
               class="btn btn-primary text-xl my-btn">

                Home

            </a>


            <a href="login.php"
               class="btn btn-success my-btn">

                <i class="fa-solid fa-lock"></i>

                Log in

            </a>

        </div>

    </div>

</nav>



<!-- ==========================================
     TRACKING
=========================================== -->

<section>

    <div class="tracking-container">


        <h2>
            Tracking Info
        </h2>


        <!-- TRACKING FORM -->

        <form action="track.php"
              method="post"
              id="tracking-form">


            <div class="form-group">

                <label for="order-id-search">

                    Enter Order ID

                </label>


                <input

                    type="text"

                    name="order_id"

                    id="order-id-search"

                    placeholder="Search by Order ID"

                    value="<?php
                        echo htmlspecialchars(
                            (string)$order_id
                        );
                    ?>"

                    inputmode="numeric"

                    pattern="[0-9]+"

                    required

                >

            </div>


            <div class="form-actions">

                <button type="submit">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    Search

                </button>

            </div>


        </form>



        <!-- SUCCESS -->

        <?php if ($status !== null): ?>

            <div class="success-message">

                <strong>
                    Order ID:
                </strong>

                <?php
                    echo htmlspecialchars(
                        (string)$order_id
                    );
                ?>

                <br>
                <br>

                <strong>
                    Status:
                </strong>

                <?php
                    echo htmlspecialchars(
                        (string)$status
                    );
                ?>

            </div>

        <?php endif; ?>



        <!-- ERROR -->

        <?php if ($error_message !== null): ?>

            <div class="error-message">

                <?php
                    echo htmlspecialchars(
                        $error_message
                    );
                ?>

            </div>

        <?php endif; ?>


    </div>

</section>



<!-- ==========================================
     CUSTOMER DASHBOARD
=========================================== -->

<section class="dashboard-section">

    <div class="container">


        <h1 class="mb-4 text-2xl font-bold">

            To see your bookings,
            please visit the Customer Dashboard.

        </h1>


        <!--

        IMPORTANT:

        This button does NOT directly authenticate
        the user.

        It sends the user to index.php.

        index.php itself MUST check the session.

        -->

        <a href="../userpannel/index.php"
           class="btn btn-success">

            <i class="fa-solid fa-user"></i>

            Customer Dashboard

        </a>


    </div>

</section>



<!-- ==========================================
     DOWNLOAD APP
=========================================== -->

<section class="container">

    <div class="hero">

        <div class="hero-content flex-col lg:flex-row">


            <img src="../img/tracking.jpg"
                 class="rounded-lg shadow-2xl"
                 style="width:500px; max-width:100%;"
                 alt="Courier tracking">


            <div>

                <h1 class="text-3xl font-bold">

                    Download our tracking app

                </h1>


                <p class="py-6">

                    Download now & avail all
                    of our services through the app.

                </p>


                <a href="https://play.google.com/store/games?hl=en&pli=1"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn btn-primary">

                    <i class="fa-solid fa-mobile-screen-button"></i>

                    Download

                </a>


            </div>

        </div>

    </div>

</section>



<!-- ==========================================
     FOOTER
=========================================== -->

<footer>

    <div class="footer footer-center bg-base-300 text-base-content p-4">

        <aside>

            <p class="text-xl">

                © 2026

                <a href="../home.php"
                   style="color:Orange;"
                   class="text-xl">

                    Fast-track

                </a>.

                All rights Reserved

            </p>

        </aside>

    </div>

</footer>



<!-- Tailwind -->

<script src="https://cdn.tailwindcss.com"></script>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous">
</script>


</body>

</html>