<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Donation Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <?php
    $firstName = $lastName = $company = $address1 = $address2 = $city = $state = $zip = $country = "";
    $phone = $fax = $email = $amount = $otherAmount = $tributeType = $honorName = $acknowledgeTo = "";
    $honorAddress = $honorCity = $honorState = $honorZip = $pubName = $comments = $volunteer = "";
    $firstNameErr = $lastNameErr = $address1Err = $cityErr = $stateErr = $zipErr = $countryErr = "";
    $phoneErr = $emailErr = $amountErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // First Name
        if (empty($_POST["firstName"])) {
            $firstNameErr = "First Name is required";
        } else {
            $firstName = $_POST["firstName"];
            if (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
                $firstNameErr = "Only letters and white space allowed in First Name";
            }
        }

        // Last Name
        if (empty($_POST["lastName"])) {
            $lastNameErr = "Last Name is required";
        } else {
            $lastName = $_POST["lastName"];
            if (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
                $lastNameErr = "Only letters and white space allowed in Last Name";
            }
        }

        // Address 1
        if (empty($_POST["address 1"])) {
            $address1Err = "Address 1  is required";
        } else {
            $address1 = $_POST["address 1"];
        }

        // City
        if (empty($_POST["city"])) {
            $cityErr = "City is required";
        } else {
            $city = $_POST["city"];
        }

        // State
        if (empty($_POST["state"])) {
            $stateErr = "State is required";
        } else {
            $state = $_POST["state"];
        }

        // Zip
        if (empty($_POST["zip"])) {
            $zipErr = "Zip is required";
        } else {
            $zip = $_POST["zip"];
        }

        // Country
        if (empty($_POST["country"])) {
            $countryErr = "country is required";
        } else {
            $country = $_POST["country"];
            if (!preg_match("/^[a-zA-Z ]*$/", $country)) {
                $countryErr = "Only letters and white space allowed in country";
            }
        }

        // Phone
        if (!empty($_POST["phone"])) {
            $phone = $_POST["phone"];
            if (!preg_match("/^[0-9]{11}$/", $phone)) {
                $phoneErr = "Phone must be exactly 11 digits";
            }
        }

        // Email
        if (!empty($_POST["email"])) {
            $email = $_POST["email"];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        // Donation Amount
        if (empty($_POST["amount"])) {
            $amountErr = "Donation Amount is required";
        } else {
            $amount = $_POST["amount"];
            if ($amount == "Other") {
                $otherAmount = $_POST["otherAmount"];
            }
        }

        // optional fields
        $company = $_POST["company"] ?? "";
        $address2 = $_POST["address2"] ?? "";
        $fax = $_POST["fax"] ?? "";
        $tributeType = $_POST["tribute"] ?? "";
        $honorName = $_POST["honorName"] ?? "";
        $acknowledgeTo = $_POST["acknowledgeTo"] ?? "";
        $honorAddress = $_POST["honorAddress"] ?? "";
        $honorCity = $_POST["honorCity"] ?? "";
        $honorState = $_POST["honorState"] ?? "";
        $honorZip = $_POST["honorZip"] ?? "";
        $pubName = $_POST["pubName"] ?? "";
        $comments = $_POST["comments"] ?? "";
        $volunteer = $_POST["volunteer"] ?? "";
    }
    ?>

    <h2>Donation Form</h2>
    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        First Name*: <input type="text" name="firstName" value="<?php echo $firstName; ?>">
        <span class="error"><?php echo $firstNameErr; ?></span><br><br>

        Last Name*: <input type="text" name="lastName" value="<?php echo $lastName; ?>">
        <span class="error"><?php echo $lastNameErr; ?></span><br><br>

        Company: <input type="text" name="company" value="<?php echo $company; ?>"><br><br>

        Address 1*: <input type="text" name="address1" value="<?php echo $address1; ?>">
        <span class="error"><?php echo $address1Err; ?></span><br><br>

        Address 2: <input type="text" name="address2" value="<?php echo $address2; ?>"><br><br>

        City*: <input type="text" name="city" value="<?php echo $city; ?>">
        <span class="error"><?php echo $cityErr; ?></span><br><br>

        State*: <input type="text" name="state" value="<?php echo $state; ?>">
        <span class="error"><?php echo $stateErr; ?></span><br><br>

        Zip Code*: <input type="text" name="zip" value="<?php echo $zip; ?>">
        <span class="error"><?php echo $zipErr; ?></span><br><br>

        Country*: <input type="text" name="country" value="<?php echo $country; ?>">
        <span class="error"><?php echo $countryErr; ?></span><br><br>

        </Phone>*: <input type="text" name="phone" value="<?php echo $phone; ?>">
        <span class="error"><?php echo $phoneErr; ?></span><br><br>

        Fax: <input type="text" name="fax" value="<?php echo $fax; ?>"><br><br>

        Email: <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error"><?php echo $emailErr; ?></span><br><br>

        Donation Amount*:
        <input type="radio" name="amount" value="500"> $500
        <input type="radio" name="amount" value="750"> $750
        <input type="radio" name="amount" value="1000"> $1000
        <input type="radio" name="amount" value="2500"> $2500
        <input type="radio" name="amount" value="Other"> Other
        <input type="text" name="otherAmount" style="width:90px;" value="<?php echo $otherAmount; ?>">
        <span class="error"><?php echo $amountErr; ?></span><br><br>

        <h3>Honorarium / Memorial Donation</h3>
        <input type="radio" name="tribute" value="Honor"> To Honor
        <input type="radio" name="tribute" value="Memory"> In Memory of <br><br>
        Name: <input type="text" name="honorName" value="<?php echo $honorName; ?>"><br><br>
        Acknowledge Donation to: <input type="text" name="acknowledgeTo" value="<?php echo $acknowledgeTo; ?>"><br><br>
        Address: <input type="text" name="honorAddress" value="<?php echo $honorAddress; ?>"><br><br>
        City: <input type="text" name="honorCity" value="<?php echo $honorCity; ?>"><br><br>
        State: <input type="text" name="honorState" value="<?php echo $honorState; ?>"><br><br>
        Zip: <input type="text" name="honorZip" value="<?php echo $honorZip; ?>"><br><br>

        <h3>Additional Information</h3>
        Publication Name: <input type="text" name="pubName" value="<?php echo $pubName; ?>"><br><br>
        Comments:<br>
        <textarea name="comments" rows="3" cols="40"><?php echo $comments; ?></textarea><br><br>

        I would like information about volunteering with:
        <input type="text" name="volunteer" value="<?php echo $volunteer; ?>"><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (
            $firstNameErr == "" && $lastNameErr == "" && $address1Err == "" && $cityErr == "" &&
            $stateErr == "" && $zipErr == "" && $countryErr == "" && $phoneErr == "" &&
            $emailErr == "" && $amountErr == ""
        ) {

            echo "<h3>✅ Form Submitted Successfully</h3>";
            echo "First Name: $firstName <br>";
            echo "Last Name: $lastName <br>";
            echo "Phone: $phone <br>";
            echo "Donation Amount: " . ($amount == "Other" ? $otherAmount : $amount) . "<br>";
        }
    }
    ?>

</body>

</html>