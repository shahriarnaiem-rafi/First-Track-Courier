<?php
// ob_start();
// if(session_start() === PHP_SESSION_NONE){
//     session_start();
// }
$database = mysqli_connect("localhost", "root", "", "fasttrack");
if (isset($_POST["submitted"])) {
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
    $money = 0;
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
    $sql = $database->query("INSERT INTO customer_section(service_type, sender_name, sender_address, sender_phone, receiver_name, receiver_address, receiver_phone, product, weight, date_of_order, money, status) 
                             VALUES('$service_type','$sender_name','$sender_address','$sender_phone','$receiver_name','$receiver_address','$receiver_phone','$product','$weight','$date',$money, '$status')");
    // header("Location: index.php");
    // exit();
}
?>
<div class="form-section"
    style="max-width: 1100px; margin: 30px auto; padding: 40px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); color: #333;">
    <h3 style="text-align: center; font-size: 2.2rem; color: #555; margin-bottom: 30px; font-weight: 700;">Customer
        Details</h3>
    <form id="myForm" method="post" name="form">
        <div class="form-row" style="display: flex; justify-content: space-between; gap: 20px;">
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
