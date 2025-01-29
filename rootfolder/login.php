<?php
session_start();
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
                    header("Location:../adminpannel/home_dashboard.php");
                } else if ($role === "Staff") {
                    header("Location:../userpannel/index.php");
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Reset and Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background: linear-gradient(180deg, rgba(15, 15, 15, 0.8), rgba(0, 0, 0, 0.6)), url('background.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #fff;
            font-size: 16px;
        }

        .form-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #ff6347;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #bbb;
            font-size: 14px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            border: 1px solid #ff6347;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #ff6347;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #e5533e;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #ff6347;
            font-size: 14px;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        select {
            font-size: 16px;
            height: 50px;
            background-color: #333;
            border-radius: 8px;
            border: 1px solid #444;
            color: #fff;
            padding-left: 15px;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22none%22%3E%3Cpath fill-rule=%22evenodd%22 clip-rule=%22evenodd%22 d=%22M6 8C6 7.44772 6.44772 7 7 7H13C13.5523 7 14 7.44772 14 8V12C14 12.5523 13.5523 13 13 13H7C6.44772 13 6 12.5523 6 12V8ZM7 9V11H13V9H7Z%22 fill=%22%23FFFFFF%22/%3E%3C/svg%3E');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 10px;
        }

        select:focus {
            border: 1px solid #ff6347;
        }

        .form-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #bbb;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Login</h2>
        <!-- Display error message if exists -->
        <?php if (isset($error_massage)): ?>
            <div class="error-message"><?php echo $error_massage; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <label for="role">Role</label>
            <select name="role" id="role">
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
            </select>

            <label for="email">Email</label>
            <input type="text" placeholder="Enter your email" name="email" required><br>

            <label for="password">Password</label>
            <input type="password" placeholder="Enter your password" name="password" required><br>

            <input type="submit" name="loggedin" value="Log in">
            <a href="./registration.php">Don't have an account? Register here</a>
        </form>

        <div class="form-footer">
            <p>&copy; 2025 FastTrack. All Rights Reserved.</p>
        </div>
    </div>
</body>

</html>
