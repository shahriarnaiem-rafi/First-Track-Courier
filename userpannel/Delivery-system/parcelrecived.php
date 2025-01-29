<?php
ob_start();
$database = mysqli_connect("localhost", "root", "", "fasttrack");

if (isset($_POST['received'])) {
    $order_id = $_POST['customer_id1'];
    $branch_id = $_POST['receiverAddress'];
    $status = $_POST['status'];

    // Insert into received table
    $sql = $database->query("INSERT INTO received(order_id, recived_location, status) 
                             VALUES('$order_id', '$branch_id', '$status')");

    // Update the status in customer_section table
    $update_query = "UPDATE customer_section SET status = '$status' WHERE id = $order_id";
    if ($database->query($update_query)) {
        header("Location: index.php");
    } else {
        echo "Error updating status in customer_section: " . $database->error;
    }
}
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $sql = "DELETE FROM received WHERE id=$id";
    if (mysqli_query($database, $sql) === TRUE) {
        header("location:index.php");
    }
}
?>
<div class="container"
    style="max-width: 600px; margin: 0 auto; padding: 30px; background-color: #f7f9fc; border-radius: 12px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);">
    <h1 style="text-align: center; color: #1e2a3a; font-size: 2.4rem; font-weight: 700; margin-bottom: 20px;">Order
        Details</h1>
    <form action="#" method="post">
        <!-- Order ID Field -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="order-id"
                style="display: block; font-weight: 600; margin-bottom: 8px; color: #4a4a4a; font-size: 1rem;">Order
                ID</label>
            <select name="customer_id1" id="order-id"
                style="width: 100%; padding: 12px; font-size: 16px; border: 1px solid #e2e2e2; border-radius: 6px; background-color: #fff; color: #333;">
                <?php
                $ns = $database->query("SELECT * FROM customer_section");
                while (list($id) = $ns->fetch_row()) {
                    echo "<option value='$id'>$id</option>";
                }
                ?>
            </select>
        </div>

        <!-- Receiver Address Field -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="receiverAddress"
                style="display: block; font-weight: 600; margin-bottom: 8px; color: #4a4a4a; font-size: 1rem;">Current
                Address</label>
            <select name="receiverAddress" id="receiverAddress"
                style="width: 100%; padding: 12px; font-size: 16px; border: 1px solid #e2e2e2; border-radius: 6px; background-color: #fff; color: #333;">
                <option value="">Select Address</option>
                <?php
                $ns = $database->query("SELECT * FROM branch");
                while (list($id, $branch_name, $branch_code) = $ns->fetch_row()) {
                    echo "<option value='$id'>$branch_name</option>";
                }
                ?>
            </select>
        </div>

        <!-- Status Field -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="status"
                style="display: block; font-weight: 600; margin-bottom: 8px; color: #4a4a4a; font-size: 1rem;">Status</label>
            <select name="status" id="status"
                style="width: 100%; padding: 12px; font-size: 16px; border: 1px solid #e2e2e2; border-radius: 6px; background-color: #fff; color: #333;">
                <option value="">Select Status</option>
                <option value="Received">Received</option>
                <option value="Returned">Returned</option>
            </select>
        </div>

        <!-- Submit Button -->
        <input type="submit" name="received" value="Received"
            style="width: 100%; padding: 14px; font-size: 18px; border: none; border-radius: 6px; background-color: #27ae60; color: white; cursor: pointer; transition: background-color 0.3s ease-in-out; font-weight: 700;">

    </form>
</div>

<?php
$query = "SELECT * FROM received";
if ($search_query !== "") {
    $query .= " WHERE id LIKE '%$search_query%'";
}
$ns = $database->query($query);

echo "<div class='table-container'> 
   <h3 style='text-align: center; font-size: 1.8rem; color: #333; font-weight: 600; margin-bottom: 20px;'>Received Details</h3>  
<table style='width: 100%; border-collapse: collapse; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
    <thead style='background-color: #1e2a3a; color: #fff; font-size: 1rem; font-weight: bold;'>
        <tr>
            <th style='padding: 12px 15px; text-align: left;'>Id</th>
            <th style='padding: 12px 15px; text-align: left;'>Order ID</th>
            <th style='padding: 12px 15px; text-align: left;'>Received Location</th>
            <th style='padding: 12px 15px; text-align: left;'>Status</th>
            <th style='padding: 12px 15px; text-align: left;'>Action</th>
        </tr>
    </thead>";
while ($row = $ns->fetch_assoc()) {
    echo " 
        <tbody>
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['order_id']}</td>
                <td>{$row['recived_location']}</td>
                <td><span class='status {$row['status']}'>{$row['status']}</span></td>
                <td>  <a href='index.php?deleteid={$row['id']}' style='color:red; font-size:20px;'><i class='fa-solid fa-trash'></i></a></td>
              
            </tr>
        </tbody>";
}
echo " </table> </div>";
ob_end_flush();
?>
