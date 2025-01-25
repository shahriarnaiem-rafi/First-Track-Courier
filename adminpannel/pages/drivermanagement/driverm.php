<?php
ob_start();
$database = mysqli_connect("localhost", "root", "", "fasttrack");
if (isset($_POST["add-driver"])) {
    $dname = $_POST['driver_name'];
    $dphone = $_POST['driver_phone'];
    $dstatus = $_POST['driver_status'];
    $sql = $database->query("INSERT INTO driver_management(driver_name,driver_phone,available) VALUES('$dname','$dphone','$dstatus')");
    if ($sql) {
        header("location: index.php");
    }
}
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $sql = "DELETE FROM driver_management WHERE id=$id";
    if (mysqli_query($database, $sql) === TRUE) {
        header("location:index.php");
    }
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
    }

    .drivers-container {
        max-width: 800px;
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

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-actions {
        text-align: center;
        margin-bottom: 20px;
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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: #fff;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }

    .status {
        font-weight: bold;
        color: #28a745;
    }

    .status.unavailable {
        color: #dc3545;
    }
</style>
<div class="drivers-container">
    <h2>Drivers Management</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="driver-name">Driver Name</label>
            <input type="text" id="driver-name" name="driver_name" placeholder="Enter driver name">
        </div>
        <div class="form-group">
            <label for="driver-phone">Phone Number</label>
            <input type="text" id="driver-phone" name="driver_phone" placeholder="Enter phone number">
        </div>
        <div class="form-group">
            <label for="driver-status">Availability Status</label>
            <select id="driver-status" name="driver_status">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" name="add-driver">Add Driver</button>
        </div>
    </form>
    <?php
    $db = $database->query("select * from driver_management");
    
    echo "<h3>Drivers List</h3>
    <table>
        <thead>
            <tr>
                <th>Driver ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Completed Deliveries</th>
                <th>Action</th>
            </tr>
        </thead>";
    while ($row= $db->fetch_assoc()) {
        echo "<tbody>
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['driver_name']} </td>
                <td>{$row['driver_phone']}</td>
                <td>{$row['available']}</td>
                <td>120</td>
                <td><a href='index.php?deleteid={$row['id']}' style='color:red; font-size:20px;'>Delete</a></td>
            </tr>
            </tbody>";
    }
    echo "</table>";
    ?>
</div>