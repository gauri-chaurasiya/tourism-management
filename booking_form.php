<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tour Booking Form</title>
    <link rel="stylesheet" type="text/css" href="css/booking.css">
    <style>
        .success-box {
            display: none;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            margin: 20px auto;
            width: 50%;
            text-align: center;
            border-radius: 5px;
            font-size: 18px;
        }
        
        label {
            color: #ffffff; 
            font-weight: bold;
        }

        input[readonly] {
            background-color: #e0e0e0;
            font-weight: bold;
            background: rgba(251, 204, 78, 0.5);
        }
    </style>
    <script>
        let destinationPrices = {};

        function validateForm() {
            if (!validateDates()) {
                alert('End date must be after start date!');
                return false;
            }
            if (document.getElementById('total_payment').value === "" || document.getElementById('total_payment').value == 0) {
                alert('Please select destination and valid dates to calculate payment.');
                return false;
            }
            return true;
        }

        function validateDates() {
            let startDate = new Date(document.getElementById('startDate').value);
            let endDate = new Date(document.getElementById('endDate').value);
            return startDate < endDate;
        }

        function calculatePayment() {
            let destination = document.getElementById('fdesti').value;
            let pricePerDay = destinationPrices[destination] || 0;
            let startDate = new Date(document.getElementById('startDate').value);
            let endDate = new Date(document.getElementById('endDate').value);

            if (startDate && endDate && startDate < endDate && pricePerDay > 0) {
                let diffTime = endDate.getTime() - startDate.getTime();
                let diffDays = diffTime / (1000 * 3600 * 24);
                let totalPayment = diffDays * pricePerDay;
                document.getElementById('total_payment').value = totalPayment;
            } else {
                document.getElementById('total_payment').value = "";
            }
        }

        window.onload = function () {
            const params = new URLSearchParams(window.location.search);
            if (params.has("success")) {
                document.getElementById("success-message").style.display = "block";
            }
        };
    </script>
</head>
<body>
    <h1>Tour Booking</h1>

    <div id="success-message" class="success-box">
        ✅ Your tour has been booked successfully!
    </div>

    <div class="container">
        <form method="POST" action="booking.php" onsubmit="return validateForm()" autocomplete="off">
            <div class="textbox">
                <input type="text" id="ffirst" placeholder="First Name" name="ffirst" required>
            </div>

            <div class="textbox">
                <input type="text" id="flast" placeholder="Last Name" name="flast" required>
            </div>

            <div class="textbox">
                <input type="email" id="femail" placeholder="Email" name="femail" required>
            </div>

            <div class="textbox">
                <input type="text" placeholder="City" name="city" required>
            </div>

            <div class="textbox">
                <input type="tel" placeholder="Phone" name="fphone" maxlength="10" pattern="[0-9]{10}" required title="Enter a valid 10-digit phone number">
            </div>

            <div class="textbox">
                <label for="fdesti">Select Destination:</label>
                <select id="fdesti" name="fdesti" onchange="calculatePayment()" required>
                    <option value="">-- Select Destination --</option>
                    <?php
                        $con = mysqli_connect('localhost', 'root', '', 'travel');
                        $res = mysqli_query($con, "SELECT pname, package FROM information WHERE package > 0");
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo '<option value="' . $row['pname'] . '">' . $row['pname'] . '</option>';
                        }
                        mysqli_close($con);
                    ?>
                </select>
            </div>

            <div class="textbox">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="startDate" required onchange="calculatePayment()">
            </div>

            <div class="textbox">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="endDate" required onchange="calculatePayment()">
            </div>

            <div class="textbox">
                <input type="text" id="total_payment" name="total_payment" placeholder="Total Payment" readonly>
            </div>

            <div class="btn">
                <input name="submit" value="Submit" type="submit">
            </div>
        </form>      
    </div>

    <script>
        <?php
        $con = mysqli_connect('localhost', 'root', '', 'travel');
        $res = mysqli_query($con, "SELECT pname, package FROM information WHERE package > 0");
        echo "destinationPrices = {}\n";
        while ($row = mysqli_fetch_assoc($res)) {
            $pname = addslashes($row['pname']);
            $package = $row['package'];
            echo "destinationPrices['$pname'] = $package;\n";
        }
        mysqli_close($con);
        ?>
    </script>
</body>
</html>