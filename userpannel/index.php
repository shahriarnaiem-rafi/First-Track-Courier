<?php
require_once "./connect/staff_auth.php";
require_once "../rootfolder/database.php";

// session_start();

if (!isset($_SESSION['user-id'])) {
    header("Location: ../rootfolder/login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Staff') {
    header("Location: ../rootfolder/login.php");
    exit();
}

$user_id = $_SESSION['user-id'];
$user_email = $_SESSION['email'] ?? '';

$database = mysqli_connect("localhost", "root", "", "fasttrack");

if (!$database) {
    die("Database connection failed.");
}

?>
<?php
include_once "./headerfooter/header.php";
?>

<!--begin::Sidebar-->

<?php
include_once "./connect/aside.php";
?>

<!--end::Sidebar-->


<!--begin::App Main-->

<main class="app-main">


    <!--begin::App Content Header-->

    <div class="app-content-header">

        <!--begin::Container-->

        <div class="container-fluid">

            <!--begin::Row-->

            <div class="row">

                <div class="col-sm-6">

                    <h3 class="mb-0">
                        Dashboard
                    </h3>

                </div>


                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-end">

                        <li class="breadcrumb-item">
                            <a href="../home.php">
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

            <!--end::Row-->

        </div>

        <!--end::Container-->

    </div>

    <!--end::App Content Header-->


    <!--begin::App Content-->

    <div>

        <div class="app-content">

            <!--begin::Container-->

            <div class="container-fluid dashboard-show"
                 id="dashboard-section">


                <!-- ==========================================
                     FIRST ROW
                =========================================== -->

                <div class="row">


                    <!-- Parcel Received -->

                    <div class="col-lg-6 col-12">

                        <div class="small-box text-bg-primary"
                             style="
                                width: 70%;
                                height: 200px;
                                margin: 0 auto;
                                margin-bottom: 20px;
                             ">

                            <div class="inner">

                                <?php

                                $sql = "
                                    SELECT COUNT(*) AS total_rows
                                    FROM customer_section
                                ";

                                $query = $database->query($sql);

                                $length = 0;

                                if ($query) {

                                    $row = $query->fetch_assoc();

                                    $length = $row['total_rows'] ?? 0;

                                }

                                ?>

                                <h3
                                    style="
                                        text-align: center;
                                        font-size: 30px;
                                        font-weight: bold;
                                        text-shadow: 2px 2px 2px black;
                                        margin-top: 50px;
                                    "
                                    id="parselrecived">

                                    <?php
                                    echo htmlspecialchars((string)$length);
                                    ?>

                                </h3>


                                <p
                                    style="
                                        text-align: center;
                                        font-size: 30px;
                                        font-weight: bold;
                                        text-shadow: 2px 2px 2px black;
                                    ">

                                    Parsel Received

                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- Old Parcel -->

                    <div class="col-lg-6 col-12">

                        <div class="small-box text-bg-success"
                             style="
                                width: 70%;
                                height: 200px;
                                margin-bottom: 20px;
                             ">

                            <div class="inner">

                                <h3
                                    style="
                                        text-align: center;
                                        font-size: 30px;
                                        font-weight: bold;
                                        text-shadow: 2px 2px 2px black;
                                        margin-top: 50px;
                                    ">

                                    400

                                </h3>


                                <p
                                    style="
                                        text-align: center;
                                        font-size: 30px;
                                        font-weight: bold;
                                        text-shadow: 2px 2px 2px black;
                                    ">

                                    Old Parsel

                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ==========================================
                     SECOND ROW
                =========================================== -->

                <div class="row">


                    <!-- Total Parcel -->

                    <div class="col-lg-6 col-12">

                        <div class="small-box bg-[#5A5852]"
                             style="
                                width: 70%;
                                height: 200px;
                                margin: 0 auto;
                                margin-bottom: 20px;
                             ">

                            <div class="inner">

                                <?php

                                $sql = "
                                    SELECT COUNT(*) AS total_rows
                                    FROM customer_section
                                ";

                                $query = $database->query($sql);

                                $length = 0;

                                if ($query) {

                                    $row = $query->fetch_assoc();

                                    $length = $row['total_rows'] ?? 0;

                                }

                                ?>

                                <h3
                                    style="
                                        text-align: center;
                                        font-size: 30px;
                                        font-weight: bold;
                                        text-shadow: 2px 2px 2px black;
                                        margin-top: 50px;
                                        color: white;
                                    ">

                                    <?php
                                    echo htmlspecialchars((string)$length);
                                    ?>

                                </h3>


                                <p
                                    style="
                                        text-align: center;
                                        font-size: 30px;
                                        font-weight: bold;
                                        text-shadow: 2px 2px 2px black;
                                        color: white;
                                    ">

                                    Total Parsel

                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- Pending Delivered -->

                    <div class="col-lg-6 col-12">

                        <div class="small-box text-bg-danger"
                             style="
                                width: 70%;
                                height: 200px;
                                margin-bottom: 20px;
                             ">

                            <div class="inner">

                                <?php

                                $sql = "
                                    SELECT COUNT(*) AS total_rows
                                    FROM customer_section
                                ";

                                $query = $database->query($sql);

                                $length = 0;

                                if ($query) {

                                    $row = $query->fetch_assoc();

                                    $length = $row['total_rows'] ?? 0;

                                }

                                ?>

                                <h3
                                    style="
                                        text-align: center;
                                        font-size: 30px;
                                        font-weight: bold;
                                        text-shadow: 2px 2px 2px black;
                                        margin-top: 50px;
                                    ">

                                    <?php
                                    echo htmlspecialchars((string)$length);
                                    ?>

                                </h3>


                                <p
                                    style="
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

            <!--end::Dashboard Section-->


            <!-- ==========================================
                 GRAPH
            =========================================== -->

            <?php
            // include_once("../connect/graph.php");
            ?>


            <!-- ==========================================
                 USER MANAGEMENT
            =========================================== -->

            <div id="user-id" class="hidden">

                <?php

                include_once "./user-management/usersection.php";

                ?>

            </div>


            <!-- ==========================================
                 CUSTOMER SECTION
            =========================================== -->

            <div id="customer-id" class="hidden">

                <?php

                include_once "./user-management/customer.php";

                ?>

            </div>


            <!-- ==========================================
                 DELIVERY ORDER LIST
            =========================================== -->

            <div id="delivery-orderlist-id" class="hidden">

                <?php

                include_once "./Delivery-system/orderlist.php";

                ?>

            </div>


            <!-- ==========================================
                 ASSIGN DRIVER
            =========================================== -->

            <div id="delivery-assing-id" class="hidden">

                <?php

                include_once "./Delivery-system/asingdrivers.php";

                ?>

            </div>


            <!-- ==========================================
                 TRACKING
            =========================================== -->

            <div id="delivery-track-id" class="hidden">

                <?php

                include_once "./Delivery-system/trackinginfo.php";

                ?>

            </div>


            <!-- ==========================================
                 PARCEL RECEIVED
            =========================================== -->

            <div id="parcel-receive-id" class="hidden">

                <?php

                include_once "./Delivery-system/parcelrecived.php";

                ?>

            </div>


            <!-- ==========================================
                 AUTH LOGIN
            =========================================== -->

            <div id="aurth-login-id" class="hidden">

                <?php

                include_once "./login/login.php";

                ?>

            </div>


        </div>

        <!--end::Container-->

    </div>

    <!--end::App Content-->

</main>

<!--end::App Main-->


<?php

include_once "./headerfooter/footer.php";

?>