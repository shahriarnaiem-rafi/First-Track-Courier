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
</style>

<div class="support-container">
    <h2>Support</h2>

    <!-- Query List -->
    <h3>Customer Queries</h3>
    <table>
        <thead>
            <tr>
                <th>Query ID</th>
                <th>Customer Name</th>
                <th>Query</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>QRY001</td>
                <td>John Doe</td>
                <td>Delivery delayed</td>
                <td>2023-12-25</td>
                <td>Pending</td>
                <td><button onclick="respondToQuery('QRY001')">Respond</button></td>
            </tr>
            <tr>
                <td>QRY002</td>
                <td>Jane Smith</td>
                <td>Incorrect invoice</td>
                <td>2023-12-26</td>
                <td>Resolved</td>
                <td><button onclick="viewResponse('QRY002')">View Response</button></td>
            </tr>
        </tbody>
    </table>

    <!-- Respond to Query -->
    <h3>Respond to Query</h3>
    <form action="#" method="post">
        <div class="form-group">
            <label for="query-id">Query ID</label>
            <input type="text" id="query-id" name="query_id" placeholder="Enter Query ID">
        </div>
        <div class="form-group">
            <label for="response">Response</label>
            <textarea id="response" name="response" rows="4" placeholder="Type your response"></textarea>
        </div>
        <div class="form-actions">
            <button type="submit">Send Response</button>
        </div>
    </form>

    <!-- Customer Query Response -->
    <div class="response" id="response-display" style="display: none;">
        <h4>Response to Query</h4>
        <p id="response-content">No response available.</p>
    </div>
</div>

<script>
    // Function to display the response area for a specific query
    function respondToQuery(queryId) {
        document.getElementById('query-id').value = queryId;
        document.getElementById('response-display').style.display = 'none';
    }

    // Function to show an existing response
    function viewResponse(queryId) {
        document.getElementById('response-display').style.display = 'block';
        document.getElementById('response-content').textContent =
            queryId === 'QRY002' ? 'Your invoice has been corrected. Please check your email for the updated version.' : 'No response available.';
    }
</script>