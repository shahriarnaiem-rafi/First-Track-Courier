<?php
require_once __DIR__ . "/../../../rootfolder/database.php";
require_once __DIR__ . "/../../connect/admin_auth.php";

if (isset($_POST['send_response'])) {

    $query_id = $_POST['query_id'];
    $response = $_POST['response'];

    $sql = $database->query("
        UPDATE customersupport
        SET response='$response', status='Resolved'
        WHERE id=$query_id
    ");

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['add_query'])) {

    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $customer_query = $_POST['customer_query'];

    $sql = $database->query("
        INSERT INTO customersupport
        (customer_name, customer_phone, customer_query)
        VALUES
        ('$customer_name', '$customer_phone', '$customer_query')
    ");

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$db = $database->query("
    SELECT * FROM customersupport
    ORDER BY id DESC
");
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
    }

    .support-container {
        max-width: 1000px;
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

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-actions {
        text-align: center;
        margin-top: 20px;
    }

    .form-actions button {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #28a745;
        color: #fff;
    }

    .response {
        background-color: #e9ecef;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }

    .response h4 {
        margin-bottom: 5px;
    }

    .response p {
        margin: 0;
    }

    .respond-btn {
        padding: 7px 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .view-btn {
        padding: 7px 12px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<div class="support-container">

    <h2>Support</h2>

    <!-- Add Customer Query -->
    <h3>Add Customer Query</h3>

    <form method="post">

        <div class="form-group">
            <label for="customer-name">Customer Name</label>
            <input
                type="text"
                id="customer-name"
                name="customer_name"
                placeholder="Enter customer name"
                required>
        </div>

        <div class="form-group">
            <label for="customer-phone">Customer Phone</label>
            <input
                type="text"
                id="customer-phone"
                name="customer_phone"
                placeholder="Enter customer phone"
                required>
        </div>

        <div class="form-group">
            <label for="customer-query">Query</label>
            <textarea
                id="customer-query"
                name="customer_query"
                rows="4"
                placeholder="Enter customer query"
                required></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" name="add_query">
                Add Query
            </button>
        </div>

    </form>

    <!-- Query List -->

    <h3>Customer Queries</h3>

    <table>

        <thead>
            <tr>
                <th>Query ID</th>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Query</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php

        if ($db && $db->num_rows > 0) {

            while ($row = $db->fetch_assoc()) {

                echo "<tr>";

                echo "<td>" . $row['id'] . "</td>";

                echo "<td>" . $row['customer_name'] . "</td>";

                echo "<td>" . $row['customer_phone'] . "</td>";

                echo "<td>" . $row['customer_query'] . "</td>";

                echo "<td>" . $row['query_date'] . "</td>";

                echo "<td>" . $row['status'] . "</td>";

                echo "<td>";

                if ($row['status'] == 'Pending') {

                    echo "
                    <button
                        class='respond-btn'
                        onclick=\"respondToQuery(
                            '" . $row['id'] . "',
                            '" . htmlspecialchars($row['customer_query'], ENT_QUOTES) . "'
                        )\">
                        Respond
                    </button>
                    ";

                } else {

                    echo "
                    <button
                        class='view-btn'
                        onclick=\"viewResponse(
                            '" . $row['id'] . "',
                            '" . htmlspecialchars($row['response'], ENT_QUOTES) . "'
                        )\">
                        View Response
                    </button>
                    ";
                }

                echo "</td>";

                echo "</tr>";
            }

        } else {

            echo "
            <tr>
                <td colspan='7' style='text-align:center;'>
                    No customer queries found.
                </td>
            </tr>
            ";
        }

        ?>

        </tbody>

    </table>

    <!-- Respond to Query -->

    <h3>Respond to Query</h3>

    <form method="post">

        <div class="form-group">

            <label for="query-id">
                Query ID
            </label>

            <input
                type="text"
                id="query-id"
                name="query_id"
                placeholder="Enter Query ID"
                readonly
                required>

        </div>

        <div class="form-group">

            <label for="response">
                Response
            </label>

            <textarea
                id="response"
                name="response"
                rows="4"
                placeholder="Type your response"
                required></textarea>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                name="send_response">
                Send Response
            </button>

        </div>

    </form>

    <!-- Customer Query Response -->

    <div
        class="response"
        id="response-display"
        style="display: none;">

        <h4>Response to Query</h4>

        <p id="response-content">
            No response available.
        </p>

    </div>

</div>

<script>

function respondToQuery(queryId, queryText) {

    document.getElementById('query-id').value = queryId;

    document.getElementById('response').value = '';

    document.getElementById('response-display').style.display = 'none';

    document.getElementById('response').focus();
}


function viewResponse(queryId, responseText) {

    document.getElementById('response-display').style.display = 'block';

    document.getElementById('response-content').textContent =
        responseText || 'No response available.';
}

</script>