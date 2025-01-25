<?php
$database = mysqli_connect("localhost", "root", "", "fasttrack");

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $sql = "DELETE FROM customer_section WHERE id=$id";
    if (mysqli_query($database, $sql) === TRUE) {
        header("location:index.php");
    }
}

$search_query = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_order'])) {
    $search_query = mysqli_real_escape_string($database, $_POST['search_order']);
}
?>
<?php
// Database connection
$database = mysqli_connect("localhost", "root", "", "fasttrack");

// Handle the form submission from the modal for status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delivery_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['delivery_status'];

    // Update the status in the customer_section table
    $update_query = "UPDATE customer_section SET status = '$new_status' WHERE id = $order_id";
    if ($database->query($update_query)) {
        echo "Order status updated successfully!";
    } else {
        echo "Error updating status: " . $database->error;
    }
}
?>

<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
<style>
    thead {
        background-color: #007bff;
        color: #fff;
    }

    th,
    td {
        padding: 5px;
        border: 1px solid #ddd;
    }

    th {
        font-weight: bold;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }

    .status {
        font-weight: bold;
        padding: 5px 5px;
        border-radius: 4px;
    }

    .status.in_transit {
        color: #0d6efd;
        background-color: #cce5ff;
    }

    .status.delivered {
        color: #155724;
        background-color: #d4edda;
    }

    .status.cancelled {
        color: #721c24;
        background-color: #f8d7da;
    }
</style>
</head>

<body>
    <form action="" method="post">
        <input type="search" name="search_order" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search by Order ID" class="p-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php
    $query = "SELECT * FROM customer_section";
    if ($search_query !== "") {
        $query .= " WHERE id LIKE '%$search_query%'";
    }
    $ns = $database->query($query);

    echo "<div class='table-container'> 
    <h3>Order List</h3>  
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Service Type</th>
                <th>Sender Name</th>
                <th>Pickup Location</th>
                <th>Sender Phone</th>
                <th>Receiver Name</th>
                <th>Delivery Location</th>
                <th>Receiver Phone</th>
                <th>Product</th>
                <th>Weight (gm)</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>";

    while ($row = $ns->fetch_assoc()) {
        echo " 
        <tbody>
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['service_type']}</td>
                <td>{$row['sender_name']}</td>
                <td>{$row['sender_address']}</td>
                <td>{$row['sender_phone']}</td>
                <td>{$row['receiver_name']}</td>
                <td>{$row['receiver_address']}</td>
                <td>{$row['receiver_phone']}</td>
                <td>{$row['product']}</td>
                <td>{$row['weight']}<br>( <i class='fa-solid fa-bangladeshi-taka-sign'></i>{$row['money']})</td>
                <td><span class='status {$row['status']}'>{$row['status']}</span></td>
                <td>
                    <a href='#' style='color:green; font-size:20px;' 
                        type='button' 
                        data-bs-toggle='modal' 
                        data-bs-target='#exampleModal' 
                        data-id='{$row['id']}' 

                        data-status='{$row['status']}'>
                        <i class='fa-solid fa-pen-to-square'></i>
                    </a>
                    <a href='index.php?deleteid={$row['id']}' style='color:red; font-size:20px;'>
                        <i class='fa-solid fa-trash'></i>
                    </a>
                    <a href='#' 
                        class='print-id' 
                        data-service='{$row['service_type']}' 
                        data-sendername='{$row['sender_name']}' 
                        data-senderaddress='{$row['sender_address']}' 
                        data-senderphone='{$row['sender_phone']}' 
                        data-receivername='{$row['receiver_name']}' 
                        data-receiveraddress='{$row['receiver_address']}' 
                        data-receiverphone='{$row['receiver_phone']}' 
                        data-weight='{$row['weight']}' 
                        data-money='{$row['money']}' 
                        data-date='{$row['date_of_order']}' 
                        data-id='{$row['id']}' 
                        style='color:blue; font-size:20px;'>
                        <i class='fa-solid fa-print'></i>
                    </a>
                </td>
            </tr>
        </tbody>";
    }

    echo " </table> </div>";
    ?>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateStatusForm" method="POST" action="">
                        <input type="hidden" id="order-id" name="order_id" value="">
                        <div class="mb-3">
                            <label for="delivery-status" class="form-label">Delivery Status</label>
                            <select class="form-select" id="delivery-status" name="delivery_status">
                                <option value="In Transit">In Transit</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const exampleModal = document.getElementById('exampleModal');
            exampleModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const orderId = button.getAttribute('data-id');
                const currentStatus = button.getAttribute('data-status');

                document.getElementById('order-id').value = orderId;
                document.getElementById('delivery-status').value = currentStatus;
            });
        });
    </script>

    <script>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Attach click event to all elements with class 'print-id'
            document.querySelectorAll('.print-id').forEach(function(printButton) {
                printButton.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default action

                    // Retrieve data from the clicked button
                    const service = this.getAttribute('data-service');
                    const senderName = this.getAttribute('data-sendername');
                    const senderAddress = this.getAttribute('data-senderaddress');
                    const senderPhone = this.getAttribute('data-senderphone');
                    const receiverName = this.getAttribute('data-receivername');
                    const receiverAddress = this.getAttribute('data-receiveraddress');
                    const receiverPhone = this.getAttribute('data-receiverphone');
                    const weight = this.getAttribute('data-weight');
                    const money = this.getAttribute('data-money');
                    const date = this.getAttribute('data-date');
                    const orderId = this.getAttribute('data-id');

                    // Call generatePDF() with the retrieved data
                    generatePDF(service, senderName, senderAddress, senderPhone, receiverName, receiverAddress, receiverPhone, weight, money, date, orderId);
                });
            });
        });

        // Updated generatePDF function
        function generatePDF(service, senderName, senderAddress, senderPhone, receiverName, receiverAddress, receiverPhone, weight, money, date, orderId) {
            const doc = open('', '', 'height=400px; width=600px;');
            with(doc.document) {
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
                write("<h1>Fast-Track-Courier Receipt</h1>");
                write("<h2>Order ID: " + orderId + "</h2>");
                write("<h2>Date: " + date + "</h2>");
                write("<table>");
                write("<tr><th colspan='2'>Sender Information</th></tr>");
                write("<tr><td><strong>Service Type:</strong></td><td>" + service + "</td></tr>");
                write("<tr><td><strong>Name:</strong></td><td>" + senderName + "</td></tr>");
                write("<tr><td><strong>Address:</strong></td><td>" + senderAddress + "</td></tr>");
                write("<tr><td><strong>Phone:</strong></td><td>" + senderPhone + "</td></tr>");
                write("<tr><th colspan='2'>Receiver Information</th></tr>");
                write("<tr><td><strong>Name:</strong></td><td>" + receiverName + "</td></tr>");
                write("<tr><td><strong>Address:</strong></td><td>" + receiverAddress + "</td></tr>");
                write("<tr><td><strong>Phone:</strong></td><td>" + receiverPhone + "</td></tr>");
                write("<tr><td><strong>Weight:</strong></td><td>" + weight + " grams</td></tr>");
                write("<tr><td><strong>Cost:</strong></td><td>" + money + "<i class='fa-solid fa-bangladeshi-taka-sign'></i></td></tr>");
                write("</table>");
                write("<div class='button'>");
                write("<button onclick='self.close()'>Close</button>");
                write("<button onclick='self.print()'>Print</button>");
                write("</div>");
                write("</div>");
                write("</body></html>");
            }
        }
    </script>

</body>

</html>