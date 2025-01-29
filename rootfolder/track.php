<?php
header("location:");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking</title>
    <link rel="shortcut icon" href="../img/logo2.png" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Daisy UI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        #home-login:hover {
            color: white;
        }

        .my-btn:hover {
            background-color: black;
        }

        /* Make the tracking container background transparent */
        /* Updated tracking-container design */
.tracking-container {
    width: 500px;
    margin: 20px auto;
    background-color: rgba(255, 255, 255, 0.9); /* Slightly opaque white background */
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
    backdrop-filter: blur(10px); /* Adds a blur effect to the background */
    border: 1px solid rgba(0, 0, 0, 0.1); /* Light border to define container */
    overflow: hidden;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 2rem;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 1.1rem;
    color: #555;
}

.form-group input {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

.form-group input:focus {
    border-color: #007bff;
    background-color: #fff;
    outline: none;
}

.form-actions {
    text-align: center;
}

.form-actions button {
    padding: 12px 30px;
    font-size: 1.2rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    background-color: #007bff;
    color: #fff;
    transition: all 0.3s ease;
}

.form-actions button:hover {
    background-color: #0056b3;
}

.tracking-info {
    margin-top: 30px;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 8px;
    font-size: 1rem;
    color: #333;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.tracking-info strong {
    font-weight: bold;
    color: #007bff;
}

    </style>
</head>

<body>
    <nav>
        <div class="navbar bg-base-100 container">
            <div class="navbar-start">
                <a class="text-xl" href=""><img src="../img/logo2.png" alt="Logo" style="width:120px; border-radius: 50px;"></a>
                <a href="" class="text-2xl" style="color:orange;">Fast-track Courier <br> Service (Pvt.) Ltd.</a>
            </div>
            <div class="flex-none">
                <button class="btn btn-primary w-24 text-xl my-btn" style="margin-right: 100px;"> <a href="../home.php" id="home-login">Home</a></button>
                <button class="btn btn-success w-24 my-btn"><a href="login.php" id="login-btn"><i class="fa-solid fa-lock"></i> Log in</a></button>
            </div>
        </div>
    </nav>
    <br>
    <section>
        <div class="hero">
            
            <div class="hero bg-opacity-90">

                <?php
                // Connect to the database
                $database = mysqli_connect("localhost", "root", "", "fasttrack");

                // Fetch status based on the entered Order ID
                $order_id = null;
                $status = null;
                $error_message = null;
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
                    $order_id = $_POST['order_id'];
                    $query = "SELECT status FROM customer_section WHERE id = ?";
                    $stmt = $database->prepare($query);
                    $stmt->bind_param('i', $order_id);
                    $stmt->execute();
                    $stmt->bind_result($status);
                    $stmt->fetch();
                    $stmt->close();

                    if (!$status) {
                        $error_message = "No data found for the provided Order ID.";
                    }
                }
                ?>

                <div class="tracking-container" id="tracking-container">
                    <h2 style="font-weight: bold; font-size: 30px;">Tracking Info</h2>
                    <form action="" method="post" id="tracking-form">
                        <div class="form-group">
                            <label for="order-id-search">Enter Order ID</label>
                            <input type="text" name="order_id" id="order-id-search" class="form-control" placeholder="Search by Order ID" value="<?php echo htmlspecialchars($order_id); ?>" />
                        </div>
                        <div class="form-actions">
                            <button type="submit" id="view-tracking-btn">Search</button>
                        </div>
                    </form>

                    <?php if ($order_id && $status): ?>
                        <div id="tracking-info" class="tracking-info">
                            <strong>Order ID:</strong> <?php echo $order_id; ?><br>
                            <strong>Status:</strong> <?php echo $status; ?>
                        </div>
                    <?php elseif ($error_message): ?>
                        <div id="tracking-info" class="tracking-info">
                            <strong><?php echo $error_message; ?></strong>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Bootstrap JS Bundle -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

            </div>
        </div>
    </section>

    <br>

    <section style="height:200px; background-color:aqua;">
        <div class="container"><br>
            <div class="text-center">
                <h1 class="mb-5 text-2xl font-bold">To see your bookings, please visit the Customer Dashboard.</h1>
                <button class="btn btn-success" id="customer-dashboard-btn" style="margin-top:-25px">Click Here</button>
            </div><br>
        </div>
    </section>

    <section class="container">
        <div class="hero">
            <div class="hero-content flex-col lg:flex-row">
                <img src="../img/tracking.jpg" class="rounded-lg shadow-2xl" style="width:500px;" alt="Tracking Image"/>
                <div>
                    <h1 class="text-3xl font-bold">Download our tracking app</h1>
                    <p class="py-6">Download now & avail all of our services through the app</p>
                    <button class="btn btn-primary">
                        <a href="https://play.google.com/store/games?hl=en&pli=1" target="_blank">
                            <i class="fa-solid fa-gamepad"></i>Download
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <footer class="footer footer-center bg-base-300 text-base-content p-4">
            <aside>
                <p class="text-xl">© 2024 <a href="" style="color: Orange;" class="text-xl">Fast-track</a>. All rights Reserved</p>
            </aside>
        </footer>
    </footer>

    <!-- Daisy UI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>
