<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        /* Resetting styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        form {
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: left;
        }

        fieldset {
            border: none;
            padding: 0;
        }

        legend {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
            font-size: 14px;
            color: #333;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="password"]:focus,
        select:focus,
        input[type="file"]:focus {
            border-color: #007bff;
            outline: none;
        }

        small {
            color: #e74c3c;
            font-size: 12px;
            margin-top: -15px;
            display: block;
            margin-bottom: 10px;
        }

        .btn-div {
            display: flex;
            justify-content: space-between;
        }

        input[type="submit"],
        input[type="reset"] {
            padding: 12px 20px;
            width: 48%;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        input[type="reset"] {
            background-color: #e74c3c;
            color: #fff;
        }

        input[type="reset"]:hover {
            background-color: #c0392b;
        }

        select,
        input[type="file"] {
            background-color: #fff;
            border: 1px solid #ddd;
        }

        @media (max-width: 600px) {
            form {
                padding: 20px;
            }

            input[type="submit"],
            input[type="reset"] {
                width: 100%;
            }

            .btn-div {
                flex-direction: column;
            }

            input[type="submit"],
            input[type="reset"] {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    <form action="#" method="post">
        <fieldset>
            <legend>Registration Form</legend>

            <label for="name">Name:</label>
            <input type="text" name="name" placeholder="Enter your name" id="name">
            <small class="text-red-500"><?= $errors['name'] ?? '' ?></small>

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Enter your email" id="email">
            <small class="text-red-500"><?= $errors['email'] ?? '' ?></small>

            <label for="mobail">Mobail:</label>
            <input type="number" name="mobail" placeholder="Enter your mobile number" id="mobail">
            <small class="text-red-500"><?= $errors['mobail'] ?? '' ?></small>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter your password" id="password">
            <small class="text-red-500"><?= $errors['password'] ?? '' ?></small>

            <label for="confirm">Confirm Password:</label>
            <input type="password" name="confirm" placeholder="Re-enter your password" id="confirm">
            <small class="text-red-500"><?= $errors['confirm'] ?? '' ?></small>

            <label for="image">Upload Image:</label>
            <input type="file" name="image" id="image">
            <small class="text-red-500"><?= $errors['image'] ?? '' ?></small>

            <label for="gendarp">Gender:</label>
            <select name="gendarp" id="gendarp">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <small class="text-red-500"><?= $errors['gendarp'] ?? '' ?></small>

            <label for="country">Country:</label>
            <select name="country" id="country">
                <option value="Bangladesh">Bangladesh</option>
                <option value="Iran">Iran</option>
                <option value="Afghanistan">Afghanistan</option>
                <option value="Saudi">Saudi Arabia</option>
            </select>

            <div class="btn-div">
                <input type="submit" value="Submit" name="submit">
                <input type="reset" value="Reset">
            </div>

        </fieldset>
    </form>

</body>

</html>
