<?php
session_start();
$database = mysqli_connect("localhost", "root", "", "fasttrack");
if (isset($_POST["loggedin"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];
    try {
        $check = $database->prepare("SELECT * FROM registration WHERE email= ?");
        $check->bind_param("s", $email);
        if ($check->execute()) {
            $output = $check->get_result();
            $user = $output->fetch_assoc();
        }
        if ($user) { // Check if user exists
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user-id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header("Location:../adminpannel/home_dashboard.php");
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
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50;
            font-size: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #2575fc;
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }

        select {
            font-size: 16px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
    </style>

</head>

<body>

    <form action="" method="post">
        <h2>Login</h2>
        <!-- Display error message if exists -->
        <?php if (isset($error_massage)): ?>
            <div class="error-message"><?php echo $error_massage; ?></div>
        <?php endif; ?>
        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="Admin">Admin</option>
            <option value="Staf">Staf</option>
        </select>

        <label for="email">Email</label>
        <input type="text" placeholder="Enter your email" name="email" required><br>

        <label for="password">Password</label>
        <input type="password" placeholder="Enter your password" name="password" required><br>
       

        <input type="submit" name="loggedin" value="Log in">
        <a href="./registration.php">Registar</a>
    </form>

</body>

</html>