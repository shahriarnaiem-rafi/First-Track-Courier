<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier System Financial Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    header h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }

    h2 {
        color: #007bff;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        padding: 12px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background-color: #218838;
    }

    .analytics {
        margin-top: 20px;
        padding: 10px;
        background-color: #e9ecef;
        border-radius: 5px;
        font-size: 16px;
    }

    .analytics div {
        margin-bottom: 10px;
    }

    span {
        font-weight: bold;
        color: #333;
    }
</style>

<body>
    <div class="container">
        <header>
            <h1>Courier System Financial Management</h1>
        </header>

        <!-- Payment History Section -->
        <section class="payment-history">
            <h2>Payment History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="payment-history">
                    <!-- Data will be added dynamically -->
                </tbody>
            </table>
        </section>

        <!-- Driver Payments Section -->
        <section class="driver-payments">
            <h2>Driver Payments</h2>
            <table>
                <thead>
                    <tr>
                        <th>Driver Name</th>
                        <th>Completed Deliveries</th>
                        <th>Commission</th>
                        <th>Total Payment</th>
                    </tr>
                </thead>
                <tbody id="driver-payments">
                    <!-- Data will be added dynamically -->
                </tbody>
            </table>
        </section>

        <!-- Revenue & Expense Section -->
        <section class="revenue-expense">
            <h2>Revenue and Expenses</h2>
            <div class="analytics">
                <div>Total Revenue: $<span id="total-revenue">0</span></div>
                <div>Total Expenses: $<span id="total-expenses">0</span></div>
                <div>Net Profit: $<span id="net-profit">0</span></div>
            </div>
        </section>

        <!-- Generate Invoice Section -->
        <section class="generate-invoice">
            <h2>Generate Invoice</h2>
            <form id="invoice-form">
                <div class="form-group">
                    <label for="order-id">Order ID</label>
                    <input type="text" id="order-id" name="order_id" placeholder="Enter Order ID" required>
                </div>
                <button type="submit">Generate Invoice</button>
            </form>
        </section>
    </div>

    <script src="script.js"></script>
    <script>
        // Sample data for payment history and driver payments
        const paymentHistoryData = [{
                payment_id: 'PMT001',
                order_id: 'OID001',
                customer_name: 'John Doe',
                amount: '$100',
                payment_method: 'Credit Card',
                date: '2023-12-25'
            },
            {
                payment_id: 'PMT002',
                order_id: 'OID002',
                customer_name: 'Jane Smith',
                amount: '$50',
                payment_method: 'PayPal',
                date: '2023-12-26'
            },
            {
                payment_id: 'PMT003',
                order_id: 'OID003',
                customer_name: 'Alice Brown',
                amount: '$75',
                payment_method: 'Debit Card',
                date: '2023-12-27'
            }
        ];

        const driverPaymentsData = [{
                driver_name: 'John Doe',
                deliveries: 120,
                commission: '10%',
                total_payment: '$1,200'
            },
            {
                driver_name: 'Jane Smith',
                deliveries: 95,
                commission: '10%',
                total_payment: '$950'
            }
        ];

        const revenueAndExpenses = {
            total_revenue: 15000,
            total_expenses: 5000
        };

        // Render Payment History
        function renderPaymentHistory() {
            const tbody = document.getElementById('payment-history');
            paymentHistoryData.forEach(payment => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
            <td>${payment.payment_id}</td>
            <td>${payment.order_id}</td>
            <td>${payment.customer_name}</td>
            <td>${payment.amount}</td>
            <td>${payment.payment_method}</td>
            <td>${payment.date}</td>
        `;
                tbody.appendChild(tr);
            });
        }

        // Render Driver Payments
        function renderDriverPayments() {
            const tbody = document.getElementById('driver-payments');
            driverPaymentsData.forEach(driver => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
            <td>${driver.driver_name}</td>
            <td>${driver.deliveries}</td>
            <td>${driver.commission}</td>
            <td>${driver.total_payment}</td>
        `;
                tbody.appendChild(tr);
            });
        }

        // Render Revenue and Expenses
        function renderRevenueExpenses() {
            document.getElementById('total-revenue').textContent = revenueAndExpenses.total_revenue;
            document.getElementById('total-expenses').textContent = revenueAndExpenses.total_expenses;
            document.getElementById('net-profit').textContent = revenueAndExpenses.total_revenue - revenueAndExpenses.total_expenses;
        }

        // Handle Invoice Generation
        document.getElementById('invoice-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const orderId = document.getElementById('order-id').value;
            alert(`Invoice for Order ID ${orderId} has been generated! (This could be a download in a real application.)`);
        });

        // Initialize
        function init() {
            renderPaymentHistory();
            renderDriverPayments();
            renderRevenueExpenses();
        }

        init();
    </script>
</body>

</html>