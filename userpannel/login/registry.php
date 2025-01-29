<?php
$database = mysqli_connect("localhost", "root", "", "fasttrack");
$errors = [];

if (isset($_POST['registar'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobail = $_POST['mobail'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $gendar = $_POST['gendarp'];
    $country = $_POST['country'];
    $role = $_POST['role'];

    // Empty check
    if (empty($name)) $errors['name'] = "Name is required.";
    if (empty($email)) $errors['email'] = "Email is required.";
    if (empty($mobail)) $errors['mobail'] = "Mobile is required.";
    if (empty($password)) $errors['password'] = "Password is required.";
    if ($password !== $confirm) $errors['confirm'] = "Passwords do not match.";

    if (empty($errors)) {
        // Check if email already exists
        $select = "SELECT * FROM register_staf WHERE email = '$email'";
        $result = mysqli_query($database, $select);

        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = "Email already registered.";
        } else {
            // Hash password before saving to the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO register_staf(name,email,mobail,password,role,gendar,country) 
                    VALUES('$name','$email','$mobail','$hashedPassword','$role','$gendar','$country')";
            if (mysqli_query($database, $sql)) {
                header("Location:index.php");
            } else {
                $errors['general'] = "Error: " . mysqli_error($database);
            }
        }
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .register-container {
        max-width: 500px;
        margin: 50px auto;
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
        background-color: #007bff;
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

<div class="register-container">
    <h2>Register</h2>

    <!-- Display error messages -->
    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="#" method="post">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo $_POST['name'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="mobail">Mobile</label>
            <input type="number" id="mobail" name="mobail" placeholder="Enter your mobile number" value="<?php echo $_POST['mobail'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>
        </div>

        <div class="form-group">
            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your password" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="user" <?php echo ($_POST['role'] ?? '') == 'user' ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo ($_POST['role'] ?? '') == 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="gendar">Gender</label>
            <select id="gendar" name="gendarp">
                <option value="Male" <?php echo ($_POST['gendarp'] ?? '') == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($_POST['gendarp'] ?? '') == 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="country">Country</label>
            <select id="country" name="country">
                <option value="Bangladesh" <?php echo ($_POST['country'] ?? '') == 'Bangladesh' ? 'selected' : ''; ?>>Bangladesh</option>
                <option value="Iran" <?php echo ($_POST['country'] ?? '') == 'Iran' ? 'selected' : ''; ?>>Iran</option>
                <option value="Afganistan" <?php echo ($_POST['country'] ?? '') == 'Afganistan' ? 'selected' : ''; ?>>Afganistan</option>
                <option value="Soudi" <?php echo ($_POST['country'] ?? '') == 'Soudi' ? 'selected' : ''; ?>>Soudi</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" name="registar">Register</button>
            <div>
                <a href="login.html">Already have an account? Login</a>
            </div>
        </div>
    </form>
</div>
