<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IFSC Code Finder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .result {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>IFSC Code Finder</h2>
        
        <!-- Form to enter IFSC code -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="ifsc">Enter IFSC Code:</label><br>
            <input type="text" id="ifsc" name="ifsc" required><br><br>
            <input type="submit" value="Find Bank Details">
        </form>

        <!-- Display bank details based on IFSC code -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $ifsc_code = $_POST['ifsc'];

            // API URL for fetching bank details based on IFSC code
            $api_url = "https://ifsc.razorpay.com/$ifsc_code";

            // Using cURL to fetch data from API
            $curl = curl_init($api_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);

            if ($response) {
                $bank_details = json_decode($response, true);

                if (!empty($bank_details)) {
                    echo '<div class="result">';
                    echo '<h3>Bank Details</h3>';
                    echo '<p><strong>Bank Name:</strong> ' . $bank_details['BANK'] . '</p>';
                    echo '<p><strong>Branch:</strong> ' . $bank_details['BRANCH'] . '</p>';
                    echo '<p><strong>IFSC Code:</strong> ' . $bank_details['IFSC'] . '</p>';
                    echo '<p><strong>Address:</strong> ' . $bank_details['ADDRESS'] . '</p>';
                    echo '</div>';
                } else {
                    echo '<div class="result">';
                    echo '<p>No bank details found for the entered IFSC code.</p>';
                    echo '</div>';
                }
            } else {
                echo '<div class="result">';
                echo '<p>Error fetching bank details. Please try again later.</p>';
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>
