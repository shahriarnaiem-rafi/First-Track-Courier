<?php
$database = mysqli_connect("localhost", "root", "", "fasttrack");
if (isset($_POST["saved"])) {
    $branch_name = $_POST['branch_name'];
    $branch_code = $_POST['branch_code'];
    $sql = $database->query("INSERT INTO branch(branch_name,branch_code) VALUES('$branch_name','$branch_code')");
    header("location:$_SERVER[PHP_SELF]");
}
// if (isset($_GET['deleteid'])) {
//     $id = $_GET['deleteid'];
//     $sql = "DELETE FROM branch WHERE id=$id";
//     if (mysqli_query($database, $sql) === TRUE) {
//         header("location:index.php");
//     }
// }
?>
<style>
    .form-container {
        max-width: 400px;
        margin: 50px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
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
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .form-group textarea {
        resize: vertical;
    }

    .form-group button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .form-group button:hover {
        background-color: #0056b3;
    }
</style>

<div class="form-container">

    <form method="post">
        <h2>Branch Information Form</h2>
        <div class="form-group">
            <label for="">Branch ID</label>
            <input type="text" id="" name="branch_id" placeholder="Auto-generated" disabled>
        </div>

        <div class="form-group">
            <label for="branch-name">Branch Name</label>
            <input type="text" id="branch-name" name="branch_name" required>
        </div>

        <div class="form-group">
            <label for="branch-code">Branch Code</label>
            <input type="text" id="branch-code" name="branch_code" required>
        </div>
        <div class="form-group">
            <button type="submit" name="saved">Save</button>
        </div>
    </form>
</div>
<div>
    <?php
    $db = $database->query("select * from branch");

    echo "<h3>Branch List</h3>
    <table>
        <thead>
            <tr>
                <th>Branch Id</th>
                <th>Branch Name</th>
                <th>Branch Code</th>
                <th>Action</th>
            </tr>
        </thead>";
    while (list($id, $branch_name,$branch_code) = $db->fetch_row()) {
        echo "<tbody>
            <tr>
                <td>$id</td>
                <td>$branch_name</td>
                <td>$branch_code</td>
                <td style='color:red; font-size:20px;'>Delete</td>
            </tr>
            </tbody>";
    }
    echo "</table>";
    ?>
</div>