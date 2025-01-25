<?php
// Connect to the database
$database = mysqli_connect("localhost", "root", "", "fasttrack");

// Fetch status based on the selected Order ID
$order_id = null;
$status = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customer_id1'])) {
    $order_id = $_POST['customer_id1'];
    $query = "SELECT status FROM customer_section WHERE id = ?";
    $stmt = $database->prepare($query);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();
}

// Handling status update from the modal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delivery_status'])) {
    $new_status = $_POST['delivery_status'];
    $update_query = "UPDATE customer_section SET status = ? WHERE id = ?";
    $stmt = $database->prepare($update_query);
    $stmt->bind_param('si', $new_status, $order_id);
    $stmt->execute();
    $stmt->close();
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
    }

    .tracking-container {
        max-width: 500px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-actions {
        text-align: center;
    }

    .form-actions button {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
    }

    .tracking-info {
        margin-top: 20px;
        padding: 15px;
        background-color: #e9ecef;
        border-radius: 5px;
        font-size: 14px;
    }
</style>

<div class="tracking-container">
    <h2>Tracking Info</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="order-id">Order ID</label>
            <select name="customer_id1" id="order-id">
                <option value="">Select Order ID</option>
                <?php
                $ns = $database->query("SELECT id FROM customer_section");
                while ($row = $ns->fetch_assoc()) {
                    $selected = ($row['id'] == $order_id) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['id']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit">View Tracking</button>
        </div>
    </form>

    <?php if ($order_id && $status): ?>
        <div id="tracking-info" class="tracking-info">
            <strong>Order ID:</strong> <?php echo $order_id; ?><br>
            <strong>Status:</strong> <?php echo $status; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal for updating status -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm" method="POST" action="">
                    <input type="hidden" id="order-id" name="order_id" value="">
                    <div class="mb-3">
                        <label for="delivery-status" class="form-label">Delivery Status</label>
                        <select class="form-select" id="delivery-status" name="delivery_status">
                            <option value="In Transit">In Transit</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Modal functionality to pre-populate the fields for order status update
    document.addEventListener('DOMContentLoaded', function() {
        const exampleModal = document.getElementById('exampleModal');
        exampleModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const orderId = button.getAttribute('data-id');
            const currentStatus = button.getAttribute('data-status');
            document.getElementById('order-id').value = orderId;
            document.getElementById('delivery-status').value = currentStatus;
        });
    });
</script>

