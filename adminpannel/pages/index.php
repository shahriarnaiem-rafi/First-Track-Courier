<?php

/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
*/

require_once __DIR__ . "/../../rootfolder/database.php";


/*
|--------------------------------------------------------------------------
| CHECK DATABASE CONNECTION
|--------------------------------------------------------------------------
*/

if (!isset($database) || !($database instanceof mysqli)) {
    die("Database connection is not available.");
}


/*
|--------------------------------------------------------------------------
| ADMIN AUTHENTICATION
|--------------------------------------------------------------------------
*/

require_once __DIR__ . "/../connect/admin_auth.php";


/*
|--------------------------------------------------------------------------
| DASHBOARD COUNTS
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| TOTAL PARCELS
|--------------------------------------------------------------------------
*/

$total_parcels = 0;

$sql = "SELECT COUNT(*) AS total
        FROM customer_section";

$query = $database->query($sql);

if ($query) {

    $row = $query->fetch_assoc();

    $total_parcels = (int)($row['total'] ?? 0);
}


/*
|--------------------------------------------------------------------------
| RECEIVED PARCELS
|--------------------------------------------------------------------------
*/

$received_parcels = 0;

$sql = "SELECT COUNT(*) AS total
        FROM customer_section
        WHERE LOWER(TRIM(status)) = 'received'";

$query = $database->query($sql);

if ($query) {

    $row = $query->fetch_assoc();

    $received_parcels = (int)($row['total'] ?? 0);
}


/*
|--------------------------------------------------------------------------
| PENDING PARCELS
|--------------------------------------------------------------------------
*/

$pending_parcels = 0;

$sql = "SELECT COUNT(*) AS total
        FROM customer_section
        WHERE LOWER(TRIM(status)) = 'pending'";

$query = $database->query($sql);

if ($query) {

    $row = $query->fetch_assoc();

    $pending_parcels = (int)($row['total'] ?? 0);
}


/*
|--------------------------------------------------------------------------
| DELIVERED / OLD PARCELS
|--------------------------------------------------------------------------
*/

$old_parcels = 0;

$sql = "SELECT COUNT(*) AS total
        FROM customer_section
        WHERE LOWER(TRIM(status)) = 'delivered'";

$query = $database->query($sql);

if ($query) {

    $row = $query->fetch_assoc();

    $old_parcels = (int)($row['total'] ?? 0);
}


/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

include_once __DIR__ . "/../headerfooter/header.php";

?>


<!-- =========================================================
     SIDEBAR
========================================================= -->

<?php

include_once __DIR__ . "/../connect/aside.php";

?>


<!-- =========================================================
     MAIN CONTENT
========================================================= -->

<main class="app-main">


    <!-- =====================================================
         CONTENT HEADER
    ====================================================== -->

    <div class="app-content-header">

        <div class="container-fluid">

            <div class="row">

                <!-- Page title -->

                <div class="col-sm-6">

                    <h3 class="mb-0">
                        Admin Dashboard
                    </h3>

                </div>


                <!-- Breadcrumb -->

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-end">

                        <li class="breadcrumb-item">

                            <a href="../../home.php">
                                Home
                            </a>

                        </li>

                        <li class="breadcrumb-item active"
                            aria-current="page">

                            Dashboard

                        </li>

                    </ol>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         APP CONTENT
    ====================================================== -->

    <div class="app-content">

        <div class="container-fluid dashboard-show"
             id="dashboard-section">


            <!-- =================================================
                 FIRST ROW
            ================================================== -->

            <div class="row">


                <!-- =================================================
                     PARCEL RECEIVED
                ================================================== -->

                <div class="col-lg-6 col-12">

                    <div class="small-box text-bg-primary"
                         style="
                            width: 70%;
                            height: 200px;
                            margin: 0 auto;
                            margin-bottom: 20px;
                         ">

                        <div class="inner">

                            <h3 style="
                                text-align: center;
                                font-size: 30px;
                                font-weight: bold;
                                text-shadow: 2px 2px 2px black;
                                margin-top: 50px;
                            ">

                                <?php echo $received_parcels; ?>

                            </h3>


                            <p style="
                                text-align: center;
                                font-size: 30px;
                                font-weight: bold;
                                text-shadow: 2px 2px 2px black;
                            ">

                                Parcel Received

                            </p>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     OLD PARCEL
                ================================================== -->

                <div class="col-lg-6 col-12">

                    <div class="small-box text-bg-success"
                         style="
                            width: 70%;
                            height: 200px;
                            margin-bottom: 20px;
                         ">

                        <div class="inner">

                            <h3 style="
                                text-align: center;
                                font-size: 30px;
                                font-weight: bold;
                                text-shadow: 2px 2px 2px black;
                                margin-top: 50px;
                            ">

                                <?php echo $old_parcels; ?>

                            </h3>


                            <p style="
                                text-align: center;
                                font-size: 30px;
                                font-weight: bold;
                                text-shadow: 2px 2px 2px black;
                            ">

                                Old Parcel

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 SECOND ROW
            ================================================== -->

            <div class="row">


                <!-- =================================================
                     TOTAL PARCEL
                ================================================== -->

                <div class="col-lg-6 col-12">

                    <div class="small-box"
                         style="
                            width: 70%;
                            height: 200px;
                            margin: 0 auto;
                            margin-bottom: 20px;
                            background: #5A5852;
                            color: white;
                         ">

                        <div class="inner">

                            <h3 style="
                                text-align: center;
                                font-size: 30px;
                                font-weight: bold;
                                text-shadow: 2px 2px 2px black;
                                margin-top: 50px;
                                color: white;
                            ">

                                <?php echo $total_parcels; ?>

                            </h3>


                            <p style="
                                text-align: center;
                                font-size: 30px;
                                font-weight: bold;
                                text-shadow: 2px 2px 2px black;
                                color: white;
                            ">

                                Total Parcel

                            </p>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     PENDING PARCEL
                ================================================== -->

                <div class="col-lg-6 col-12">

                    <div class="small-box text-bg-danger"
                         style="
                            width: 70%;
                            height: 200px;
                            margin-bottom: 20px;
                         ">

                        <div class="inner">

                            <h3 style="
                                text-align: center;
                                font-size: 30px;
                                font-weight: bold;
                                text-shadow: 2px 2px 2px black;
                                margin-top: 50px;
                            ">

                                <?php echo $pending_parcels; ?>

                            </h3>


                            <p style="
                                text-align: center;
                                font-size: 30px;
                                font-weight: bold;
                                text-shadow: 2px 2px 2px black;
                            ">

                                Pending Delivered

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             GRAPH
        ====================================================== -->

        <?php

        // Graph can be enabled later.

        // include_once __DIR__ . "/../connect/graph.php";

        ?>


        <!-- =====================================================
             USER MANAGEMENT
        ====================================================== -->


        <!-- User Section -->

        <div id="user-id" class="hidden">

            <?php

            include_once __DIR__ . "/user-management/usersection.php";

            ?>

        </div>


        <!-- Customer Section -->

        <div id="customer-id" class="hidden">

            <?php

            include_once __DIR__ . "/user-management/customer.php";

            ?>

        </div>


        <!-- =====================================================
             DELIVERY SYSTEM
        ====================================================== -->


        <!-- Order List -->

        <div id="delivery-orderlist-id" class="hidden">

            <?php

            include_once __DIR__ . "/Delivery-system/orderlist.php";

            ?>

        </div>


        <!-- Assign Drivers -->

        <div id="delivery-assing-id" class="hidden">

            <?php

            include_once __DIR__ . "/Delivery-system/asingdrivers.php";

            ?>

        </div>


        <!-- Tracking Information -->

        <div id="delivery-track-id" class="hidden">

            <?php

            include_once __DIR__ . "/Delivery-system/trackinginfo.php";

            ?>

        </div>


        <!-- Parcel Received -->

        <div id="parcel_recive_id" class="hidden">

            <?php

            include_once __DIR__ . "/Delivery-system/parcelrecived.php";

            ?>

        </div>


        <!-- =====================================================
             DRIVER MANAGEMENT
        ====================================================== -->

        <div id="driver-id" class="hidden">

            <?php

            include_once __DIR__ . "/drivermanagement/driverm.php";

            ?>

        </div>


        <!-- =====================================================
             PAYMENT
        ====================================================== -->

        <div id="payment-id" class="hidden">

            <?php

            include_once __DIR__ . "/payment/payment.php";

            ?>

        </div>


        <!-- =====================================================
             BRANCH
        ====================================================== -->

        <div id="branch-id" class="hidden">

            <?php

            include_once __DIR__ . "/branch/branch.php";

            ?>

        </div>


        <!-- =====================================================
             CUSTOMER SUPPORT
        ====================================================== -->

        <div id="support-id" class="hidden">

            <?php

            include_once __DIR__ . "/customersupport/support.php";

            ?>

        </div>


        <!-- =====================================================
             SETTINGS
        ====================================================== -->

        <div id="setting-id" class="hidden">

            <?php

            include_once __DIR__ . "/setting/setting.php";

            ?>

        </div>


        <!-- =====================================================
             LOGIN
        ====================================================== -->

        <div id="aurth-login-id" class="hidden">

            <?php

            include_once __DIR__ . "/login/login.php";

            ?>

        </div>


        <!-- =====================================================
             REGISTRATION
        ====================================================== -->

        <div id="aurth-registry-id" class="hidden">

            <?php

            include_once __DIR__ . "/login/registry.php";

            ?>

        </div>


    </div>

</main>


<!-- =========================================================
     FOOTER
========================================================= -->

<?php

include_once __DIR__ . "/../headerfooter/footer.php";

?>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script src="../DOM/show.js"></script>

<script src="../bootstrap/js/bootstrap.bundle.js"></script>