<?php
$database = mysqli_connect("localhost", "root", "", "fasttrack");
if (isset($_POST["loggedin"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];  // Get the selected role

    try {
        if ($role === "Admin") {
            // Admin Login Logic
            $check = $database->prepare("SELECT * FROM registration WHERE email= ?");
            $check->bind_param("s", $email);
        } else if ($role === "Staff") {
            // Staff Login Logic
            $check = $database->prepare("SELECT * FROM register_staf WHERE email= ?");
            $check->bind_param("s", $email);
        }

        if ($check->execute()) {
            $output = $check->get_result();
            $user = $output->fetch_assoc();
        }

        if ($user) { // Check if user exists
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user-id'] = $user['id'];
                $_SESSION['email'] = $user['email'];

                // Redirect to the correct dashboard based on role
                if ($role === "Admin") {
                    header("Location:../home_dashboard.php");
                } else if ($role === "Staff") {
                    header("Location:../../userpannel/index.php");
                }
                exit();
            } else {
                $error_massage = "Invalid password. Try again.";
            }
        } else {
            $error_massage = "No account found. Try again.";
        }
    } catch (Exception $e) {
        $error_massage = "Error: " . $e->getMessage();
    }
}
?>
<style>
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

    .error-message {
        color: #e74c3c;
        font-size: 14px;
        text-align: center;
        margin-top: 10px;
    }
</style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>

        <!-- Display error message if exists -->
        <?php if (isset($error_massage)): ?>
            <div class="error-message"><?php echo $error_massage; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="Admin">Admin</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="form-actions">
                <button type="submit" name="loggedin">Login</button>
                <div>
                    <a href="#">Forgot password?</a>
                </div>
            </div>
        </form>
    </div>