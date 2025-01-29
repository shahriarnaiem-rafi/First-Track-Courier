<?php
$database = mysqli_connect("localhost", "root", "", "fasttrack");
$errors = [];
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobail = $_POST["mobail"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    $gendar = $_POST["gendarp"];
    $country = $_POST["country"];

    // Empty check
    if (empty($name)) $errors['name'] = " Name is required.";
    if (empty($email)) $errors['email'] = "Email is required.";
    if (empty($mobail)) $errors['mobail'] = "Mobile is required.";
    if (empty($password)) $errors['password'] = "Password is required.";
    if ($password !== $confirm) $errors['confirm'] = "Passwords do not match.";

    if (empty($errors)) {
        // Check if email already exists
        $select = "SELECT * FROM registration WHERE email = '$email'";
        $result = mysqli_query($database, $select);

        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = "Email already registered.";
        } else {
            // Hash password before saving to the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO registration(name,email,mobail,password,gendar,country) VALUES('$name','$email','$mobail','$hashedPassword','$gendar','$country')";
            if (mysqli_query($database, $sql) == TRUE) {
                header("location:login.php");
            } else {
                $errors['general'] = "Error: " . mysqli_error($database);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
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
            max-width: 600px;
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
        input[type="email"],
        input[type="number"],
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
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="password"]:focus,
        select:focus {
            border: 1px solid #ff6347;
            outline: none;
        }

        input[type="submit"],
        input[type="reset"] {
            width: 48%;
            padding: 15px;
            background-color: #ff6347;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #e5533e;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        .btn-div {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
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
        <h2>Registration Form</h2>

        <!-- Display error messages -->
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="#" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Enter your name" value="<?php echo $_POST['name'] ?? ''; ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Enter your email" value="<?php echo $_POST['email'] ?? ''; ?>" required>

            <label for="mobail">Mobile</label>
            <input type="number" name="mobail" placeholder="Enter your mobile number" value="<?php echo $_POST['mobail'] ?? ''; ?>" required>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <label for="confirm">Confirm Password</label>
            <input type="password" name="confirm" placeholder="Re-enter your password" required>

            <label for="gendar">Gender</label>
            <select name="gendarp">
                <option value="Male" <?php echo ($_POST['gendarp'] ?? '') == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($_POST['gendarp'] ?? '') == 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>

            <label for="country">Country</label>
            <select name="country">
                <option value="Bangladesh" <?php echo ($_POST['country'] ?? '') == 'Bangladesh' ? 'selected' : ''; ?>>Bangladesh</option>
                <option value="Iran" <?php echo ($_POST['country'] ?? '') == 'Iran' ? 'selected' : ''; ?>>Iran</option>
                <option value="Afganistan" <?php echo ($_POST['country'] ?? '') == 'Afganistan' ? 'selected' : ''; ?>>Afganistan</option>
                <option value="Soudi" <?php echo ($_POST['country'] ?? '') == 'Soudi' ? 'selected' : ''; ?>>Soudi</option>
            </select>

            <div class="btn-div">
                <input type="submit" value="Register" name="submit">
                <input type="reset" value="Reset">
            </div>
        </form>

        <div class="form-footer">
            <p>&copy; 2025 FastTrack. All Rights Reserved.</p>
        </div>
    </div>

</body>
</html>