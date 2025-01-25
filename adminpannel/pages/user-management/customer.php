<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .form-container {
        max-width: 400px;
        margin: 50px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        background-color: #28a745;
        color: #fff;
    }
</style>

<div class="form-container">
    <h2>Customer Form</h2>
    <form action="#" method="post">
        <div class="form-group">
            <label for="customer-id">Customer ID</label>
            <input type="text" id="customer-id" name="customer_id" placeholder="Auto-generated" disabled>
        </div>
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" placeholder="Enter phone number">
        </div>
        <div class="form-group">
            <label for="payment-method">Payment Method</label>
            <select id="payment-method" name="payment_method">
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="cash">Cash</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit">Save Customer</button>
            <button type="button" class="receipt-btn">Generate Receipt</button>

        </div>
    </form>
</div>
<script src="https://cdn.tailwindcss.com"></script>