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


/*
|--------------------------------------------------------------------------
| ASSIGN DRIVER
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_driver'])) {

    $submitted_token = $_POST['csrf_token'] ?? "";

    if (
        empty($submitted_token) ||
        empty($_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $submitted_token)
    ) {
        $form_error = "Invalid form request. Please refresh the page and try again.";
    } else {

        $driver_id = filter_var(
            $_POST['driver'] ?? null,
            FILTER_VALIDATE_INT
        );

        $order_id = filter_var(
            $_POST['customer_id1'] ?? null,
            FILTER_VALIDATE_INT
        );

        $vehicle = trim($_POST['vehicle'] ?? "");

        $allowed_vehicles = [
            "Truck 101",
            "Van 202",
            "Bike 303"
        ];

        if ($driver_id === false || $driver_id <= 0) {

            $form_error = "Please select a valid driver.";

        } elseif ($order_id === false || $order_id <= 0) {

            $form_error = "Please select a valid order.";

        } elseif (!in_array($vehicle, $allowed_vehicles, true)) {

            $form_error = "Please select a valid vehicle.";

        } else {

            /*
            |--------------------------------------------------------------------------
            | CHECK ORDER EXISTS
            |--------------------------------------------------------------------------
            */

            $check_order = $database->prepare(
                "SELECT id FROM customer_section WHERE id = ? LIMIT 1"
            );

            if (!$check_order) {

                $form_error = "Unable to verify the selected order.";

            } else {

                $check_order->bind_param("i", $order_id);
                $check_order->execute();

                $order_result = $check_order->get_result();

                if ($order_result->num_rows === 0) {

                    $form_error = "The selected order does not exist.";

                }

                $order_result->free();
                $check_order->close();
            }


            /*
            |--------------------------------------------------------------------------
            | CHECK DRIVER EXISTS
            |--------------------------------------------------------------------------
            */

            if ($form_error === "") {

                $check_driver = $database->prepare(
                    "SELECT * FROM driver_management WHERE id = ? LIMIT 1"
                );

                if (!$check_driver) {

                    $form_error = "Unable to verify the selected driver.";

                } else {

                    $check_driver->bind_param("i", $driver_id);
                    $check_driver->execute();

                    $driver_result = $check_driver->get_result();

                    if ($driver_result->num_rows === 0) {

                        $form_error = "The selected driver does not exist.";

                    }

                    $driver_result->free();
                    $check_driver->close();
                }
            }


            /*
            |--------------------------------------------------------------------------
            | CHECK WHETHER ORDER IS ALREADY ASSIGNED
            |--------------------------------------------------------------------------
            */

            if ($form_error === "") {

                $check_assignment = $database->prepare(
                    "SELECT id
                     FROM assing_drivers
                     WHERE order_id = ?
                     LIMIT 1"
                );

                if (!$check_assignment) {

                    $form_error = "Unable to check the existing assignment.";

                } else {

                    $check_assignment->bind_param("i", $order_id);
                    $check_assignment->execute();

                    $assignment_result =
                        $check_assignment->get_result();

                    if ($assignment_result->num_rows > 0) {

                        $form_error =
                            "This order is already assigned to a driver.";

                    }

                    $assignment_result->free();
                    $check_assignment->close();
                }
            }


            /*
            |--------------------------------------------------------------------------
            | INSERT ASSIGNMENT
            |--------------------------------------------------------------------------
            */

            if ($form_error === "") {

                $stmt = $database->prepare(
                    "INSERT INTO assing_drivers
                    (
                        driver_id,
                        vehicle,
                        order_id
                    )
                    VALUES (?, ?, ?)"
                );

                if (!$stmt) {

                    $form_error =
                        "Unable to prepare the driver assignment.";

                } else {

                    $stmt->bind_param(
                        "isi",
                        $driver_id,
                        $vehicle,
                        $order_id
                    );

                    if ($stmt->execute()) {

                        $form_success =
                            "Order #{$order_id} was assigned successfully.";

                        $_SESSION['csrf_token'] =
                            bin2hex(random_bytes(32));

                        $csrf_token =
                            $_SESSION['csrf_token'];

                    } else {

                        $form_error =
                            "Unable to assign the driver. Please try again.";
                    }

                    $stmt->close();
                }
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| DELETE ASSIGNMENT
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['delete_assignment'])
) {

    $submitted_token = $_POST['csrf_token'] ?? "";

    if (
        empty($submitted_token) ||
        empty($_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $submitted_token)
    ) {

        $form_error =
            "Invalid form request. Please refresh the page and try again.";

    } else {

        $assignment_id = filter_var(
            $_POST['assignment_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($assignment_id === false || $assignment_id <= 0) {

            $form_error = "Invalid assignment ID.";

        } else {

            $stmt = $database->prepare(
                "DELETE FROM assing_drivers WHERE id = ?"
            );

            if (!$stmt) {

                $form_error =
                    "Unable to prepare the delete request.";

            } else {

                $stmt->bind_param(
                    "i",
                    $assignment_id
                );

                if ($stmt->execute()) {

                    if ($stmt->affected_rows > 0) {

                        $form_success =
                            "Driver assignment deleted successfully.";

                    } else {

                        $form_error =
                            "The driver assignment was not found.";
                    }

                    $_SESSION['csrf_token'] =
                        bin2hex(random_bytes(32));

                    $csrf_token =
                        $_SESSION['csrf_token'];

                } else {

                    $form_error =
                        "Unable to delete the driver assignment.";
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

$order_query = "
    SELECT id
    FROM customer_section
    ORDER BY id DESC
";

$order_result = $database->query($order_query);

if ($order_result) {

    while ($order = $order_result->fetch_assoc()) {
        $orders[] = $order;
    }

    $order_result->free();
}


/*
|--------------------------------------------------------------------------
| LOAD DRIVERS
|--------------------------------------------------------------------------
|
| Your original code expects the first three columns to be:
|
| column 0 = id
| column 1 = driver name
| column 2 = driver phone
|
| We preserve that behavior instead of assuming additional column names.
|
|--------------------------------------------------------------------------
*/

$drivers = [];

$driver_query = "
    SELECT *
    FROM driver_management
";

$driver_result = $database->query($driver_query);

if ($driver_result) {

    while ($driver = $driver_result->fetch_row()) {

        if (isset($driver[0], $driver[1])) {

            $drivers[] = [
                'id' => $driver[0],
                'name' => $driver[1],
                'phone' => $driver[2] ?? ""
            ];
        }
    }

    $driver_result->free();
}


/*
|--------------------------------------------------------------------------
| LOAD ASSIGNMENTS
|--------------------------------------------------------------------------
*/

$assignments = [];

$assignment_query = "
    SELECT
        id,
        driver_id,
        vehicle,
        order_id
    FROM assing_drivers
    ORDER BY id DESC
";

$assignment_result =
    $database->query($assignment_query);

if ($assignment_result) {

    while ($assignment = $assignment_result->fetch_assoc()) {

        $assignments[] = $assignment;
    }

    $assignment_result->free();
}


/*
|--------------------------------------------------------------------------
| HTML ESCAPE HELPER
|--------------------------------------------------------------------------
*/

function assign_html($value)
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}

?>

<style>

    .assign-container {
        max-width: 550px;
        margin: 20px auto;
        background: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .assign-container h2 {
        text-align: center;
        margin-bottom: 25px;
    }

    .assign-alert {
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .assign-alert.error {
        background: #ffe6e6;
        border: 1px solid #ffb3b3;
        color: #b30000;
    }

    .assign-alert.success {
        background: #e7f7ec;
        border: 1px solid #b5e2c0;
        color: #176b2c;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .form-group select,
    .form-group input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-group select:focus,
    .form-group input:focus {
        outline: none;
        border-color: #007bff;
    }

    .form-actions {
        text-align: center;
        margin-top: 20px;
    }

    .form-actions button {
        padding: 10px 25px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
    }

    .form-actions button:hover {
        background-color: #0069d9;
    }

    .assignment-table-container {
        width: 100%;
        overflow-x: auto;
        margin-top: 25px;
    }

    .assignment-table {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
        background: #fff;
    }

    .assignment-table th,
    .assignment-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .assignment-table th {
        background-color: #007bff;
        color: white;
    }

    .assignment-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .assignment-table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .assignment-delete {
        color: red;
        font-size: 18px;
        border: none;
        background: transparent;
        cursor: pointer;
    }

    .assignment-delete:hover {
        opacity: 0.7;
    }

    .search-container {
        margin-top: 25px;
        margin-bottom: 15px;
    }

    .search-container label {
        display: block;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .search-container input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .empty-assignment {
        text-align: center;
        padding: 25px;
        color: #777;
    }

    @media (max-width: 768px) {

        .assign-container {
            margin: 15px 0;
            padding: 18px;
        }

    }

</style>


<!-- =============================================================
     ASSIGN DRIVER FORM
============================================================== -->

<div class="assign-container">

    <h2>
        Assign Drivers
    </h2>


    <?php if ($form_error !== ""): ?>

        <div class="assign-alert error">
            <?php echo assign_html($form_error); ?>
        </div>

    <?php endif; ?>


    <?php if ($form_success !== ""): ?>

        <div class="assign-alert success">
            <?php echo assign_html($form_success); ?>
        </div>

    <?php endif; ?>


    <form
        action=""
        method="POST"
    >

        <input
            type="hidden"
            name="csrf_token"
            value="<?php echo assign_html($csrf_token); ?>"
        >


        <!-- ORDER -->

        <div class="form-group">

            <label for="order-id">
                Order ID
            </label>

            <select
                name="customer_id1"
                id="order-id"
                required
            >

                <option value="">
                    Select Order
                </option>

                <?php foreach ($orders as $order): ?>

                    <option
                        value="<?php echo (int)$order['id']; ?>"
                    >
                        <?php echo (int)$order['id']; ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- DRIVER -->

        <div class="form-group">

            <label for="driver">
                Assign Driver
            </label>

            <select
                id="driver"
                name="driver"
                required
            >

                <option value="">
                    Select Driver
                </option>

                <?php foreach ($drivers as $driver): ?>

                    <option
                        value="<?php echo (int)$driver['id']; ?>"
                    >

                        <?php
                        echo assign_html($driver['name']);
                        ?>

                        <?php if ($driver['phone'] !== ""): ?>

                            -
                            <?php
                            echo assign_html($driver['phone']);
                            ?>

                        <?php endif; ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- VEHICLE -->

        <div class="form-group">

            <label for="vehicle">
                Assign Vehicle
            </label>

            <select
                id="vehicle"
                name="vehicle"
                required
            >

                <option value="">
                    Select Vehicle
                </option>

                <option value="Truck 101">
                    Truck 101
                </option>

                <option value="Van 202">
                    Van 202
                </option>

                <option value="Bike 303">
                    Bike 303
                </option>

            </select>

        </div>


        <!-- SUBMIT -->

        <div class="form-actions">

            <button
                type="submit"
                name="assign_driver"
                value="1"
            >
                Assign Driver
            </button>

        </div>

    </form>

</div>


<!-- =============================================================
     SEARCH
============================================================== -->

<div class="search-container">

    <label for="search-input">
        Search by Order ID
    </label>

    <input
        type="search"
        id="search-input"
        placeholder="Enter Order ID"
        autocomplete="off"
    >

</div>


<!-- =============================================================
     ASSIGNMENT TABLE
============================================================== -->

<div class="assignment-table-container">

    <table class="assignment-table">

        <thead>

            <tr>

                <th>
                    ID
                </th>

                <th>
                    Driver ID
                </th>

                <th>
                    Vehicle
                </th>

                <th>
                    Order ID
                </th>

                <th>
                    Action
                </th>

            </tr>

        </thead>


        <tbody id="table-body">

            <?php if (empty($assignments)): ?>

                <tr>

                    <td
                        colspan="5"
                        class="empty-assignment"
                    >
                        No driver assignments found.
                    </td>

                </tr>

            <?php else: ?>

                <?php foreach ($assignments as $assignment): ?>

                    <?php
                    $assignment_id =
                        (int)$assignment['id'];

                    $driver_id =
                        (int)$assignment['driver_id'];

                    $order_id =
                        (int)$assignment['order_id'];

                    $vehicle =
                        assign_html($assignment['vehicle']);
                    ?>

                    <tr>

                        <td>
                            <?php echo $assignment_id; ?>
                        </td>

                        <td>
                            <?php echo $driver_id; ?>
                        </td>

                        <td>
                            <?php echo $vehicle; ?>
                        </td>

                        <td>
                            <?php echo $order_id; ?>
                        </td>

                        <td>

                            <form
                                action=""
                                method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Are you sure you want to delete this driver assignment?');"
                            >

                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?php echo assign_html($csrf_token); ?>"
                                >

                                <input
                                    type="hidden"
                                    name="assignment_id"
                                    value="<?php echo $assignment_id; ?>"
                                >

                                <button
                                    type="submit"
                                    name="delete_assignment"
                                    value="1"
                                    class="assignment-delete"
                                    title="Delete Assignment"
                                >

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

        </tbody>

    </table>

</div>


<!-- =============================================================
     SEARCH JAVASCRIPT
============================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('search-input');

    const tableBody =
        document.getElementById('table-body');

    if (!searchInput || !tableBody) {
        return;
    }


    searchInput.addEventListener(
        'input',
        function () {

            const searchValue =
                this.value.trim().toLowerCase();

            const tableRows =
                tableBody.querySelectorAll('tr');

            tableRows.forEach(function (row) {

                const cells =
                    row.children;

                /*
                | Order ID is column 4.
                | Index is 3 because arrays start at 0.
                */

                if (cells.length < 4) {
                    return;
                }

                const orderId =
                    cells[3].textContent
                        .trim()
                        .toLowerCase();

                if (
                    searchValue === "" ||
                    orderId.includes(searchValue)
                ) {

                    row.style.display = "";

                } else {

                    row.style.display = "none";
                }

            });

        }
    );

});

</script>