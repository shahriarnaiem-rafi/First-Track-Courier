<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
    }

    .settings-container {
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

    .form-section {
        margin-bottom: 30px;
    }

    .form-section h3 {
        margin-bottom: 15px;
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
</style>
<div class="settings-container">
    <h2>Settings</h2>

    <!-- Admin Profile -->
    <div class="form-section">
        <h3>Admin Profile</h3>
        <form action="#" method="post">
            <div class="form-group">
                <label for="admin-name">Name</label>
                <input type="text" id="admin-name" name="admin_name" placeholder="Enter your name">
            </div>
            <div class="form-group">
                <label for="admin-email">Email</label>
                <input type="email" id="admin-email" name="admin_email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="admin-password">Password</label>
                <input type="password" id="admin-password" name="admin_password" placeholder="Enter new password">
            </div>
            <div class="form-actions">
                <button type="submit">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- Service Zones -->
    <div class="form-section">
        <h3>Service Zones</h3>
        <form action="#" method="post">
            <div class="form-group">
                <label for="zone-name">Zone Name</label>
                <input type="text" id="zone-name" name="zone_name" placeholder="Enter zone name">
            </div>
            <div class="form-group">
                <label for="zone-details">Zone Details</label>
                <textarea id="zone-details" name="zone_details" rows="3" placeholder="Enter zone details"></textarea>
            </div>
            <div class="form-actions">
                <button type="submit">Add Zone</button>
            </div>
        </form>
    </div>

    <!-- Delivery Charges -->
    <div class="form-section">
        <h3>Delivery Charges</h3>
        <form action="#" method="post">
            <div class="form-group">
                <label for="pricing-model">Pricing Model</label>
                <select id="pricing-model" name="pricing_model">
                    <option value="flat_rate">Flat Rate</option>
                    <option value="per_km">Per Kilometer</option>
                </select>
            </div>
            <div class="form-group">
                <label for="charge-rate">Charge Rate</label>
                <input type="number" id="charge-rate" name="charge_rate"
                    placeholder="Enter rate (e.g., $5 for flat rate, $2 per km)">
            </div>
            <div class="form-actions">
                <button type="submit">Set Charges</button>
            </div>
        </form>
    </div>

    <!-- Notification Settings -->
    <div class="form-section">
        <h3>Notification Settings</h3>
        <form action="#" method="post">
            <div class="form-group">
                <label for="email-notifications">Email Notifications</label>
                <select id="email-notifications" name="email_notifications">
                    <option value="enabled">Enabled</option>
                    <option value="disabled">Disabled</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sms-notifications">SMS Notifications</label>
                <select id="sms-notifications" name="sms_notifications">
                    <option value="enabled">Enabled</option>
                    <option value="disabled">Disabled</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit">Save Notifications</button>
            </div>
        </form>
    </div>
</div>