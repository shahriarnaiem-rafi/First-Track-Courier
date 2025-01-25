<?php
$database = mysqli_connect("localhost", "root", "", "fasttrack");

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $sql = "DELETE FROM customer_section WHERE id=$id";
    if (mysqli_query($database, $sql) === TRUE) {
        header("location:index.php");
    }
}

$search_query = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_order'])) {
    $search_query = mysqli_real_escape_string($database, $_POST['search_order']);
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Our Branch</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .table-container {
            margin: 20px auto;
            padding: 20px;
            max-width: 800px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #007bff;
            color: #ffffff;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <?php
    $query = "SELECT * FROM branch";
    if ($search_query !== "") {
        $query .= " WHERE id LIKE '%$search_query%'";
    }
    $ns = $database->query($query);

    echo "<div class='table-container'> 
    <h3>Branch List</h3>  
    <table>
        <thead>
            <tr>
                <th>SL NO</th> <!-- Serial Number Column -->
                
                <th>Branch Name</th>
                <th>Branch Code</th>
                <th>Branch ID</th>
            </tr>
        </thead>";

    // Initialize serial number counter
    $serial = 1;

    while ($row = $ns->fetch_assoc()) {
        echo " 
        <tbody>
            <tr>
                <td>{$serial}</td> <!-- Display Serial Number -->
                <td>{$row['branch_name']}</td>
                <td>{$row['branch_code']}</td>
                <td>{$row['branch_id']}</td>
            </tr>
        </tbody>";
        $serial++; // Increment serial number for next row
    }

    echo " </table> </div>";
    ?>

</body>

</html>
