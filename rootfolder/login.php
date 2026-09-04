
<?php

session_start();
require_once "./database.php";
/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
*/

$database = mysqli_connect("localhost", "root", "", "fasttrack");

if (!$database) {
    die("Database connection failed.");
}


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

$error_massage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["loggedin"])) {

    /*
    |--------------------------------------------------------------------------
    | GET FORM VALUES
    |--------------------------------------------------------------------------
    */

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $selected_role = $_POST["role"] ?? "";


    /*
    |--------------------------------------------------------------------------
    | VALIDATE INPUT
    |--------------------------------------------------------------------------
    */

    if ($email === "" || $password === "") {

        $error_massage = "Please enter your email and password.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error_massage = "Please enter a valid email address.";

    } elseif (!in_array($selected_role, ["Admin", "Staff"], true)) {

        $error_massage = "Please select a valid role.";

    } else {

        try {

            $user = null;
            $actual_role = null;


            /*
            |--------------------------------------------------------------------------
            | ADMIN LOGIN
            |--------------------------------------------------------------------------
            */

            if ($selected_role === "Admin") {

                $sql = "
                    SELECT id, name, email, password
                    FROM registration
                    WHERE email = ?
                    LIMIT 1
                ";

                $check = $database->prepare($sql);

                if (!$check) {
                    throw new Exception("Unable to prepare Admin login.");
                }

                $check->bind_param("s", $email);

                $check->execute();

                $result = $check->get_result();

                $user = $result->fetch_assoc();

                $check->close();

                if ($user) {
                    $actual_role = "Admin";
                }
            }


            /*
            |--------------------------------------------------------------------------
            | STAFF LOGIN
            |--------------------------------------------------------------------------
            */

            elseif ($selected_role === "Staff") {

                $sql = "
                    SELECT id, name, email, password
                    FROM register_staf
                    WHERE email = ?
                    LIMIT 1
                ";

                $check = $database->prepare($sql);

                if (!$check) {
                    throw new Exception("Unable to prepare Staff login.");
                }

                $check->bind_param("s", $email);

                $check->execute();

                $result = $check->get_result();

                $user = $result->fetch_assoc();

                $check->close();

                if ($user) {
                    $actual_role = "Staff";
                }
            }


            /*
            |--------------------------------------------------------------------------
            | CHECK ACCOUNT
            |--------------------------------------------------------------------------
            */

            if (!$user || !$actual_role) {

                $error_massage = "No account found. Please check your email and selected role.";

            } else {


                /*
                |--------------------------------------------------------------------------
                | VERIFY PASSWORD
                |--------------------------------------------------------------------------
                */

                if (!password_verify($password, $user["password"])) {

                    $error_massage = "Invalid password. Please try again.";

                } else {


                    /*
                    |--------------------------------------------------------------------------
                    | REGENERATE SESSION ID
                    |--------------------------------------------------------------------------
                    */

                    session_regenerate_id(true);


                    /*
                    |--------------------------------------------------------------------------
                    | STORE SESSION DATA
                    |--------------------------------------------------------------------------
                    */

                    $_SESSION["user-id"] = (int)$user["id"];

                    $_SESSION["email"] = $user["email"];

                    $_SESSION["name"] = $user["name"];

                    $_SESSION["role"] = $actual_role;


                    /*
                    |--------------------------------------------------------------------------
                    | REDIRECT USER
                    |--------------------------------------------------------------------------
                    */

                    if ($actual_role === "Admin") {

                        header("Location: ../adminpannel/pages/index.php");
                        exit();

                    } elseif ($actual_role === "Staff") {

                        header("Location: ../userpannel/index.php");
                        exit();

                    }
                }
            }

        } catch (Exception $e) {

            $error_massage = "Unable to login. Please try again later.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>FastTrack - Login</title>


    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap"
        rel="stylesheet"
    >


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }


        body {

            background:
                linear-gradient(
                    180deg,
                    rgba(15, 15, 15, 0.8),
                    rgba(0, 0, 0, 0.6)
                ),
                url('background.jpg')
                no-repeat
                center center / cover;

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

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.3);

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

            margin-bottom: 15px;

            line-height: 1.5;
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

            background-image:
                url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22none%22%3E%3Cpath fill-rule=%22evenodd%22 clip-rule=%22evenodd%22 d=%22M6 8C6 7.44772 6.44772 7 7 7H13C13.5523 7 14 7.44772 14 8V12C14 12.5523 13.5523 13 13 13H7C6.44772 13 6 12.5523 6 12V8ZM7 9V11H13V9H7Z%22 fill=%22%23FFFFFF%22/%3E%3C/svg%3E');

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

        <h2>
            Login
        </h2>


        <?php if ($error_massage !== ""): ?>

            <div class="error-message">

                <?php
                echo htmlspecialchars(
                    $error_massage,
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>

            </div>

        <?php endif; ?>


        <form action="" method="post">


            <!-- Role -->

            <label for="role">
                Role
            </label>

            <select
                name="role"
                id="role"
                required
            >

                <option value="">
                    Select Role
                </option>

                <option value="Admin">
                    Admin
                </option>

                <option value="Staff">
                    Staff
                </option>

            </select>


            <!-- Email -->

            <label for="email">
                Email
            </label>

            <input
                type="text"
                id="email"
                name="email"
                placeholder="Enter your email"
                autocomplete="email"
                required
            >


            <!-- Password -->

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                autocomplete="current-password"
                required
            >


            <!-- Login -->

            <input
                type="submit"
                name="loggedin"
                value="Log in"
            >


            <!-- Registration -->

            <a href="./registration.php">
                Don't have an account?
                Register here
            </a>

        </form>


        <div class="form-footer">

            <p>
                &copy; 2026 FastTrack.
                All Rights Reserved.
            </p>

        </div>

    </div>

</body>

</html>

