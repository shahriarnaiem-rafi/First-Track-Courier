
<?php

require_once __DIR__ . "/../../../rootfolder/database.php";
require_once __DIR__ . "/../../connect/admin_auth.php";

/*
|--------------------------------------------------------------------------
| CSRF Protection
|--------------------------------------------------------------------------
*/
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION['csrf_token'];

/*
|--------------------------------------------------------------------------
| Variables
|--------------------------------------------------------------------------
*/
$order_id = null;
$status = null;
$message = "";
$message_type = "";

/*
|--------------------------------------------------------------------------
| Allowed Delivery Statuses
|--------------------------------------------------------------------------
*/
$allowed_statuses = [
    "pending",
    "Received",
    "In Transit",
    "Delivered",
    "Cancelled"
];

/*
|--------------------------------------------------------------------------
| Handle POST Requests
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /*
    |--------------------------------------------------------------------------
    | Check CSRF Token
    |--------------------------------------------------------------------------
    */
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($csrf_token, $_POST['csrf_token'])
    ) {
        $message = "Invalid security token. Please try again.";
        $message_type = "danger";
    } else {

        /*
        |--------------------------------------------------------------------------
        | Update Order Status
        |--------------------------------------------------------------------------
        */
        if (isset($_POST['delivery_status'])) {

            $order_id = filter_input(
                INPUT_POST,
                'order_id',
                FILTER_VALIDATE_INT
            );

            $new_status = trim($_POST['delivery_status']);

            if (!$order_id || $order_id < 1) {

                $message = "Invalid Order ID.";
                $message_type = "danger";

            } elseif (!in_array($new_status, $allowed_statuses, true)) {

                $message = "Invalid delivery status.";
                $message_type = "danger";

            } else {

                /*
                |--------------------------------------------------------------------------
                | Check whether order exists
                |--------------------------------------------------------------------------
                */
                $check_stmt = $database->prepare(
                    "SELECT id FROM customer_section WHERE id = ? LIMIT 1"
                );

                if (!$check_stmt) {

                    $message = "Unable to verify the order.";
                    $message_type = "danger";

                } else {

                    $check_stmt->bind_param("i", $order_id);
                    $check_stmt->execute();
                    $check_stmt->store_result();

                    if ($check_stmt->num_rows === 0) {

                        $message = "Order not found.";
                        $message_type = "danger";

                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | Update Status
                        |--------------------------------------------------------------------------
                        */
                        $update_stmt = $database->prepare(
                            "UPDATE customer_section
                             SET status = ?
                             WHERE id = ?"
                        );

                        if (!$update_stmt) {

                            $message = "Unable to update order status.";
                            $message_type = "danger";

                        } else {

                            $update_stmt->bind_param(
                                "si",
                                $new_status,
                                $order_id
                            );

                            if ($update_stmt->execute()) {

                                $message = "Order status updated successfully.";
                                $message_type = "success";

                                $status = $new_status;

                            } else {

                                $message = "Failed to update order status.";
                                $message_type = "danger";
                            }

                            $update_stmt->close();
                        }
                    }

                    $check_stmt->close();
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | View Tracking Information
        |--------------------------------------------------------------------------
        */
        elseif (isset($_POST['customer_id1'])) {

            $order_id = filter_input(
                INPUT_POST,
                'customer_id1',
                FILTER_VALIDATE_INT
            );

            if (!$order_id || $order_id < 1) {

                $message = "Please select a valid Order ID.";
                $message_type = "danger";

            } else {

                $stmt = $database->prepare(
                    "SELECT status
                     FROM customer_section
                     WHERE id = ?
                     LIMIT 1"
                );

                if (!$stmt) {

                    $message = "Unable to retrieve tracking information.";
                    $message_type = "danger";

                } else {

                    $stmt->bind_param("i", $order_id);
                    $stmt->execute();
                    $stmt->bind_result($status);

                    if (!$stmt->fetch()) {

                        $status = null;
                        $message = "Order not found.";
                        $message_type = "danger";
                    }

                    $stmt->close();
                }
            }
        }
    }
}

/*
|--------------------------------------------------------------------------
| Fetch All Orders
|--------------------------------------------------------------------------
*/
$orders = [];

$order_query = $database->query(
    "SELECT id, status
     FROM customer_section
     ORDER BY id DESC"
);

if ($order_query) {

    while ($row = $order_query->fetch_assoc()) {
        $orders[] = $row;
    }

    $order_query->free();
}

/*
|--------------------------------------------------------------------------
| HTML Escape Helper
|--------------------------------------------------------------------------
*/
function e($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

?>

<style>
    .tracking-container {
        max-width: 600px;
        margin: 30px auto;
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .tracking-container h2 {
        text-align: center;
        margin-bottom: 25px;
    }

    .tracking-container .form-group {
        margin-bottom: 18px;
    }

    .tracking-container label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
    }

    .tracking-container select {
        width: 100%;
        padding: 11px 12px;
        font-size: 16px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        background: #fff;
    }

    .tracking-container .form-actions {
        text-align: center;
    }

    .tracking-container .form-actions button {
        padding: 10px 25px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .tracking-info {
        margin-top: 25px;
        padding: 18px;
        background: #f1f3f5;
        border-radius: 7px;
        border-left: 4px solid #0d6efd;
    }

    .tracking-info .status {
        font-weight: 700;
    }

    .tracking-actions {
        margin-top: 15px;
        text-align: center;
    }

    .alert {
        margin-bottom: 20px;
    }

    @media (max-width: 576px) {
        .tracking-container {
            margin: 15px;
            padding: 20px;
        }
    }
</style>

<div class="tracking-container">

    <h2>Tracking Info</h2>

    <?php if ($message !== ""): ?>
        <div class="alert alert-<?php echo e($message_type); ?>" role="alert">
            <?php echo e($message); ?>
        </div>
    <?php endif; ?>

    <!--
    |--------------------------------------------------------------------------
    | Select Order
    |--------------------------------------------------------------------------
    -->
    <form action="" method="post">

        <input
            type="hidden"
            name="csrf_token"
            value="<?php echo e($csrf_token); ?>"
        >

        <div class="form-group">

            <label for="tracking-order-id">
                Order ID
            </label>

            <select
                name="customer_id1"
                id="tracking-order-id"
                required
            >

                <option value="">
                    Select Order ID
                </option>

                <?php foreach ($orders as $order): ?>

                    <option
                        value="<?php echo e($order['id']); ?>"
                        <?php echo (
                            (int) $order['id'] === (int) $order_id
                        ) ? 'selected' : ''; ?>
                    >
                        <?php echo e($order['id']); ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                View Tracking
            </button>

        </div>

    </form>

    <!--
    |--------------------------------------------------------------------------
    | Tracking Information
    |--------------------------------------------------------------------------
    -->
    <?php if ($order_id && $status !== null): ?>

        <div class="tracking-info">

            <strong>Order ID:</strong>
            <?php echo e($order_id); ?>

            <br>

            <strong>Status:</strong>
            <span class="status">
                <?php echo e($status); ?>
            </span>

            <div class="tracking-actions">

                <button
                    type="button"
                    class="btn btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#updateStatusModal"
                    data-order-id="<?php echo e($order_id); ?>"
                    data-status="<?php echo e($status); ?>"
                >
                    Update Status
                </button>

            </div>

        </div>

    <?php endif; ?>

</div>


<!--
|--------------------------------------------------------------------------
| Update Status Modal
|--------------------------------------------------------------------------
-->
<div
    class="modal fade"
    id="updateStatusModal"
    tabindex="-1"
    aria-labelledby="updateStatusModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="updateStatusModalLabel"
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
                        value="<?php echo e($csrf_token); ?>"
                    >

                    <input
                        type="hidden"
                        id="update-order-id"
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
                        class="btn btn-primary"
                    >
                        Update Status
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const updateStatusModal =
        document.getElementById("updateStatusModal");

    if (!updateStatusModal) {
        return;
    }

    updateStatusModal.addEventListener(
        "show.bs.modal",
        function (event) {

            const button = event.relatedTarget;

            if (!button) {
                return;
            }

            const orderId =
                button.getAttribute("data-order-id");

            const currentStatus =
                button.getAttribute("data-status");

            document.getElementById(
                "update-order-id"
            ).value = orderId || "";

            const statusSelect =
                document.getElementById("delivery-status");

            if (currentStatus) {

                const optionExists =
                    Array.from(statusSelect.options)
                    .some(function (option) {
                        return option.value === currentStatus;
                    });

                if (optionExists) {
                    statusSelect.value = currentStatus;
                }
            }
        }
    );
});
</script>

