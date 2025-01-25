<?php
$database = mysqli_connect("localhost", "root", "", "fasttrack");

if (isset($_POST["submitted"])) {
    // Collect form data
    $service_type = $_POST['service'];
    $sender_name = $_POST['senderName'];
    $sender_address = $_POST['senderAddress'];
    $sender_phone = $_POST['senderPhone'];
    $receiver_name = $_POST['receiverName'];
    $receiver_address = $_POST['receiverAddress'];
    $receiver_phone = $_POST['receiverPhone'];
    $product = $_POST['receiverProduct'];
    $date = $_POST['date'];
    $status = 'pending';
    $weight = $_POST['weight'];
    $money = 0; // Initialize money

    // Calculate money based on weight
    if ($weight <= 1000) {
        $money = 150;
    } else if ($weight <= 5000) {
        $money = 750;
    } else if ($weight <= 7000) {
        $money = 1050;
    } else if ($weight <= 10000) {
        $money = 1800;
    } else if ($weight <= 15000) {
        $money = 2500;
    } else if ($weight <= 20000) {
        $money = 3500;
    }

    // Insert data into database
    $sql = $database->query("INSERT INTO customer_section(service_type, sender_name, sender_address, sender_phone, receiver_name, receiver_address, receiver_phone, product, weight, date_of_order, money, status) 
                             VALUES('$service_type','$sender_name','$sender_address','$sender_phone','$receiver_name','$receiver_address','$receiver_phone','$product','$weight','$date',$money, '$status')");

    // Redirect to index.php after successful submission
    header("Location: index.php");
    exit();
}
?>

<div class="form-section"
    style="max-width: 1100px; margin: 30px auto; padding: 40px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); color: #333;">
    <h3 style="text-align: center; font-size: 2.2rem; color: #555; margin-bottom: 30px; font-weight: 700;">Customer
        Details</h3>
    <!-- onsubmit="return generatePDF(); -->
    <form id="myForm" method="post" name="form">
        <div class="form-row" style="display: flex; justify-content: space-between; gap: 20px;">
            <!-- Sender Section -->
            <div class="sender-section"
                style="width: 48%; background-color: #f9f9f9; border-radius: 10px; padding: 20px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                <h2 style="color: #444; margin-bottom: 15px; font-size: 1.6rem; font-weight: 600;">Sender</h2>
                <label for="service" style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;">Service
                    Type</label>
                <select id="service" name="service"
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">
                    <option value="Standard">Standard</option>
                    <option value="Express">Express</option>
                </select>

                <labe for="senderName" style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;">Name
                </labe>
                <input type="text" id="senderName" placeholder="Enter sender name" name="senderName" required
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">

                <label for="senderAddress"
                    style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;">Address</label>
                <select name="senderAddress" id="senderAddress"
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">
                    <option value="">Select Address</option>
                    <?php
                    $ns = $database->query("select * from branch");
                    while (list($id, $branch_name, $branch_code) = $ns->fetch_row()) {
                        echo "<option value='$id $branch_name'>$branch_name</option>";
                    }
                    ?>
                </select>

                <label for="senderPhone"
                    style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;">Phone</label>
                <input type="tel" id="senderPhone" placeholder="Enter sender phone" name="senderPhone" required
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">

                <label for="receiverProduct"
                    style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;">Product</label>
                <input type="text" id="receiverProduct" name="receiverProduct" placeholder="Enter your product" required
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">
            </div>

            <!-- Receiver Section -->
            <div class="receiver-section"
                style="width: 48%; background-color: #f9f9f9; border-radius: 10px; padding: 20px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                <h2 style="color: #444; margin-bottom: 15px; font-size: 1.6rem; font-weight: 600;">Receiver</h2>
                <label for="receiverName"
                    style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;">Name</label>
                <input type="text" id="receiverName" placeholder="Enter receiver name" name="receiverName" required
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">

                <label for="receiverAddress"
                    style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;">Address</label>
                <select name="receiverAddress" id="receiverAddress"
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">
                    <option value="">Select Address</option>
                    <?php
                    $ns = $database->query("select * from branch");
                    while (list($id, $branch_name, $branch_code) = $ns->fetch_row()) {
                        echo "<option value='$id $branch_name'>$branch_name</option>";
                    }
                    ?>
                </select>

                <label for="receiverPhone"
                    style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;">Phone</label>
                <input type="tel" id="receiverPhone" name="receiverPhone" placeholder="Enter your Phone" required
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">

                <label for="date" style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;">Date</label>
                <input type="text" id="date" name="date" placeholder="Enter date of received product from customer"
                    required
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">

                <label for="weight" style="display: block; font-size: 1rem; margin-bottom: 8px; color: #666;" title="1kg=150; 5kg=750; 7kg=1500; 10kg=1800; 15kg=2500; 20kg=3500; ">Weight
                    (max:20kg)</label>
                <input type="text" id="weight" name="weight" placeholder="Weight will be shown received in grams"
                    required
                    style="width: 100%; padding: 14px; margin-bottom: 18px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; color: #333; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s ease, box-shadow 0.3s ease;">
            </div>
        </div>

        <input type="submit" value="Submit" id="submitBtn" class="button" name="submitted"
            style="padding: 12px 20px; font-size: 1.1rem; color: white; background-color: #6c63ff; border: none; border-radius: 8px; cursor: pointer; width: 100%; transition: background-color 0.3s ease;">
    </form>
</div>

<!-- <script>
    function calculateMoney(weight) {
        weight = parseInt(weight);
        if (weight < 1000) return 150;
        else if (weight <= 5000) return 300;
        else if (weight <= 7000) return 500;
        else if (weight <= 10000) return 1000;
        else if (weight <= 15000) return 1800;
        else if (weight <= 20000) return 3500;
        return 0; // Handle case where weight exceeds 20kg
    }
    function generatePDF() {
    var service = document.form.service.value;
    var sendername = document.form.senderName.value;
    var senderAddress = document.form.senderAddress.value;
    var senderPhone = document.form.senderPhone.value;

    var receivername = document.form.receiverName.value;
    var receiveraddress = document.form.receiverAddress.value;
    var receiverphone = document.form.receiverPhone.value;
    var weight = document.form.weight.value;
    var money = calculateMoney(weight); // Call the function to calculate money
    var date = document.form.date.value;

    var doc = open('', '', 'height=400px; width=600px;');
    with (doc.document) {
        write("<html><head><title>Fast-Track-courier</title>");
        write("<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css'>");
        write("<style>");
        write("body { font-family: Arial, sans-serif; margin: 20px; }");
        write(".receipt { border: 2px solid #ccc; padding: 20px; border-radius: 10px; background-color: lightblue; box-shadow: 0 4px 10px rgba(180, 133, 133, 0.1); }");
        write("h1 { text-align: center; color: #333; font-size: 24px; margin-bottom: 10px; }");
        write("h2 { color: #555; font-size: 20px; margin-bottom: 5px; }");
        write("h3 { color: #666; font-size: 18px; margin-bottom: 5px; }");
        write("p { margin: 5px 0; font-size: 16px; }");
        write("strong { color: #333; }");
        write("table { width: 100%; border-collapse: collapse; margin: 20px 0; }");
        write("table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }");
        write("th { background-color: #f2f2f2; font-weight: bold; }");
        write(".button { margin-top: 20px; text-align: center; }");
        write(".button button { margin-right: 10px; padding: 10px 15px; border: none; border-radius: 5px; background-color: #007BFF; color : white; cursor: pointer; font-size: 16px; transition: background-color 0.3s; }");
        write(".button button:hover { background-color: #0056b3; }");
        write("</style></head><body>");

        write("<div class='receipt'>");
        write("<h1>First-Track-courier Receipt</h1>");
        write("<h2>Date: " + date + "</h2>");

        write("<table>");
        write("<tr><th colspan='2'>Sender Information</th></tr>");
        write("<tr><td><strong>Service Type:</strong></td><td>" + service + "</td></tr>");
        write("<tr><td><strong>Name:</strong></td><td>" + sendername + "</td></tr>");
        write("<tr><td><strong>Address:</strong></td><td>" + senderAddress + "</td></tr>");
        write("<tr><td><strong>Phone:</strong></td><td>" + senderPhone + "</td></tr>");

        write("<tr><th colspan='2'>Receiver Information</th></tr>");
        write("<tr><td><strong>Name:</strong></td><td>" + receivername + "</td></tr>");
        write("<tr><td><strong>Address:</strong></td><td>" + receiveraddress + "</td></tr>");
        write("<tr><td><strong>Phone:</strong></td><td>" + receiverphone + "</td></tr>");
        write("<tr><td><strong>Weight:</strong></td><td>" + weight + " grams</td></tr>");
        write("<tr><td><strong>Cost:</strong></td><td>" + money + " <i class='fa-solid fa-bangladeshi-taka-sign'></i> </td></tr>");
        write("</table>");

        write("<div class='button'>");
        write("<button onclick='self.close()'>Close</button>");
        write("<button onclick='self.print()'>Print</button>");
        write("</div>");
        write("</div>");
        write("http://localhost/Fast-Track/Fast-Track-I/home.php");

        write("</body></html>");
    }
}


</script> -->