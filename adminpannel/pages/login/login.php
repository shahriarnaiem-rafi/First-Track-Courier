<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .login-container {
        max-width: 400px;
        margin: 100px auto;
        background: #fff;
        padding: 30px;
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

    .form-group input {
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

    .form-actions a {
        color: #007bff;
        text-decoration: none;
        margin-top: 10px;
        display: inline-block;
    }

    .form-actions a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-container">
    <h2>Login</h2>
    <form action="#" method="post">
        <div class="form-group">
            <label for="username">Username/Email</label>
            <input type="text" id="username" name="username" placeholder="Enter username or email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>
        </div>
        <div class="form-actions">
            <button type="submit">Login</button>
            <div>
                <a href="#">Forgot password?</a>
            </div>
        </div>
    </form>
</div>