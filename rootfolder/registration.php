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

     //empty chek 
     if (empty($name)) $errors['name'] = " Name is required.";
     if (empty($email)) $errors['email'] = "email is required.";
     if (empty($mobail)) $errors['mobail'] = "mobail is required.";
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
        }
        else {
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
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: left;
        }

        fieldset {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
        }

        legend {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            padding: 0 10px;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        small {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        input[type="submit"],
        input[type="reset"] {
            width: 48%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #45a049;
        }

        input[type="reset"] {
            background-color: #f44336;
        }

        input[type="reset"]:hover {
            background-color: #d32f2f;
        }

        .btn-div {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        select {
            background-color: #f9f9f9;
            padding: 12px;
        }

        select option {
            padding: 10px;
        }

        p {
            margin-bottom: 10px;
        }

        @media (max-width: 600px) {
            form {
                padding: 20px;
                width: 100%;
            }

            input[type="submit"],
            input[type="reset"] {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
    
</head>

<body>

    <form action="#" method="post">
        <fieldset>
            <legend> Registration Form</legend>
            <label for="">Name: </label><br>
            <input type="text" name="name" placeholder="Please enter your name"><br>
            <small class="text-red-500"><?= $errors['name'] ?? '' ?></small><br>

            <label for="">Email: </label><br>
            <input type="email" name="email" placeholder="Please enter your email"><br>
            <small class="text-red-500"><?= $errors['email'] ?? '' ?></small><br>
            <label for="">Mobail: </label><br>
            <input type="number" name="mobail" placeholder="Please enter your mobail"><br>
            <small class="text-red-500"><?= $errors['mobail'] ?? '' ?></small><br>
            <label for="">Password: </label><br>
            <input type="password" name="password" placeholder="Please enter your password"><br>
            <small class="text-red-500"><?= $errors['password'] ?? '' ?></small><br>
            <input type="password" name="confirm" placeholder="Please re-enter your password"><br>
            <small class="text-red-500"><?= $errors['confirm'] ?? '' ?></small><br>
            <input type="file"  name="image"><br>
            <small class="text-red-500"><?= $errors['image'] ?? '' ?></small><br>


            <p>
                <label for="">Gender: </label>
                <select name="gendarp">
                    
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </p>
            <small class="text-red-500"><?= $errors['gendarp'] ?? '' ?></small>


            <label for="">Country</label>
            <select name="country" id="">
                <option value="Bangladesh">Bangladesh</option>
                <option value="Iran">Iran</option>
                <option value="Afganistan">Afganistan</option>
                <option value="Soudi">Soudi</option>
                
            </select>
            

            <br><br>
            <div class="btn-div">
                <input type="submit" value="Submit" class="btn" name="submit">
                <input type="reset" value="Reset" class="btn">
            </div>


        </fieldset>
    </form>


</body>

</html>