<?php
$errors = [];
$success = false;

function validateName($name, $field)
{
    $name = trim($name);
    if (empty($name)) {
        return "$field is required.";
    }
    if (strlen($name) < 8) {
        return "$field must be at least 8 characters long.";
    }
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        return "$field can only contain letters and spaces.";
    }
    return "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = filter_var($_POST['first-name'], FILTER_SANITIZE_STRING);
    $firstNameError = validateName($firstName, "First Name");
    if (!empty($firstNameError)) {
        $errors[] = $firstNameError;
    }

    $lastName = filter_var($_POST['last-name'], FILTER_SANITIZE_STRING);
    $lastNameError = validateName($lastName, "Last Name");
    if (!empty($lastNameError)) {
        $errors[] = $lastNameError;
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    $requiredFields = [
        'address-1' => "Address 1",
        'address-2' => "Address 2",
        'city' => "City",
        'state' => "State",
        'zip-code' => "Zip Code",
        'country' => "Country",
        'donation' => "Donation Amount"
    ];

    foreach ($requiredFields as $field => $label) {
        $value = trim($_POST[$field]);
        if (empty($value) || $value == "select") {
            $errors[] = "$label is required.";
        }
    }

    if (isset($_POST['donation']) && $_POST['donation'] === "other") {
        $otherAmount = filter_var($_POST['other-amount'], FILTER_SANITIZE_STRING);
        if (empty($otherAmount) || !is_numeric($otherAmount) || $otherAmount <= 0) {
            $errors[] = "Please enter a valid amount for Other Donation.";
        }
    }

    if (empty($errors)) {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Form Processing</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="process_form.php" method="POST">
        <div class="whole">
            <div class="first">
                <small><span class="asteric">*</span> - Denotes Required Information</small><br>
                <p>> <strong>1 Donation</strong> > 2 Confirmation > Thank You!</p>
            </div>
            <?php if (!empty($errors)): ?>
                <div style="color: red;">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php elseif ($success): ?>
                <div style="color: green;">
                    <p>Form submitted successfully!</p>
                </div>
            <?php endif; ?>
            <h1>Donor Information</h1>
            <div>
                <div class="container">
                    <div class="label">
                        <label for="first-name">First Name <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="first-name" name="first-name"
                            value="<?php echo isset($firstName) ? htmlspecialchars($firstName) : ''; ?>">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="last-name">Last Name <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="last-name" name="last-name"
                            value="<?php echo isset($lastName) ? htmlspecialchars($lastName) : ''; ?>">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="company">Company</label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="company" name="company">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="address-1">Address 1 <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="address-1" name="address-1">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="address-2">Address 2 <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="address-2" name="address-2">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="city">City <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="city" name="city">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="state">State <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <select name="state" id="state">
                            <option value="select">Select a state</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="USA">USA</option>
                        </select>
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="zip-code">Zip Code <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="zip-code" name="zip-code">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="country">Country <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <select name="country" id="country">
                            <option value="select">Select a country</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="USA">USA</option>
                        </select>
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="phone">Phone</label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="phone" name="phone">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="fax">Fax</label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="fax" name="fax">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="email">Email <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="email" id="email" name="email"
                            value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="donation">Donation Amount <span class="important">*</span></label>
                    </div>
                    <div class="parent-wrapper">
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="none" name="donation" value="none">
                            </div>
                            <div class="radio-label">
                                <label for="none">None</label>
                            </div>
                        </div>
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="$50" name="donation" value="50">
                            </div>
                            <div class="radio-label">
                                <label for="$50">$50</label>
                            </div>
                        </div>
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="$75" name="donation" value="75">
                            </div>
                            <div class="radio-label">
                                <label for="$75">$75</label>
                            </div>
                        </div>
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="$100" name="donation" value="100">
                            </div>
                            <div class="radio-label">
                                <label for="$100">$100</label>
                            </div>
                        </div>
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="$250" name="donation" value="250">
                            </div>
                            <div class="radio-label">
                                <label for="$250">$250</label>
                            </div>
                        </div>
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="other" name="donation" value="other">
                            </div>
                            <div class="radio-label">
                                <label for="other">Other</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-donation">
                    <div class="small-text">
                        <small>(Check a button or type in your amount)</small>
                    </div>
                    <div class="container custom-container">
                        <div class="label">
                            <label for="other-amount">Other Amount $</label>
                        </div>
                        <div class="text-box">
                            <input type="text" id="other-amount" name="other-amount">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="recurring-donation">Recurring Donation</label>
                        <small>(Check if yes)</small><br>
                    </div>
                    <div>
                        <input type="checkbox" id="recurring-donation" name="recurring-donation">
                        <label for="recurring-donation">I am interested in giving on a regular basis.</label>
                    </div>
                </div>
                <div class="credit-card">
                    <small>Monthly Credit Card $</small>
                    <input type="text" name="credit-card-amount">
                    <small>For</small>
                    <input type="text" name="credit-card-months">
                    <small>Months</small>
                </div>
            </div>
            <h1>Honorarium and Memorial Donation Information</h1>
            <div>
                <div class="container">
                    <div class="label">
                        <label for="like-donation">I would like to make this donation</label>
                    </div>
                    <div class="donation-wrap">
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="none-memorial" name="like-donation" value="none">
                            </div>
                            <div class="radio-label">
                                <label for="none-memorial">None</label>
                            </div>
                        </div>
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="$50-memorial" name="like-donation" value="50">
                            </div>
                            <div class="radio-label">
                                <label for="$50-memorial">$50</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="memorial-name">Name</label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="memorial-name" name="memorial-name">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="acknowledge-donation">Acknowledge Donation to</label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="acknowledge-donation" name="acknowledge-donation">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="memorial-address">Address</label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="memorial-address" name="memorial-address">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="memorial-city">City</label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="memorial-city" name="memorial-city">
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="memorial-state">State</label>
                    </div>
                    <div class="text-box">
                        <select name="memorial-state" id="memorial-state">
                            <option value="select">Select a state</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="USA">USA</option>
                        </select>
                    </div>
                </div>
                <div class="container">
                    <div class="label">
                        <label for="memorial-zip-code">Zip Code</label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="memorial-zip-code" name="memorial-zip-code">
                    </div>
                </div>
            </div>
            <h1>Additional Information</h1>
            <p>Please enter your name, company or organization as you would like it to appear in our publications:</p>
            <div class="container">
                <div class="label">
                    <label for="publication-name">Name</label>
                </div>
                <div class="text-box">
                    <input type="text" id="publication-name" name="publication-name">
                </div>
            </div>
            <div class="selection-box">
                <div>
                    <input type="checkbox" id="anonymous" name="anonymous">
                    <label for="anonymous">I would like my gift to remain anonymous.</label>
                </div>
                <div>
                    <input type="checkbox" id="matching-gift" name="matching-gift">
                    <label for="matching-gift">My employer offers a matching gift program. I will mail the matching gift
                        form.</label>
                </div>
                <div>
                    <input type="checkbox" id="no-thank-you" name="no-thank-you">
                    <label for="no-thank-you">Please save the cost of acknowledging this gift by not mailing a thank you
                        letter.</label>
                </div>
            </div>
            <div class="container area">
                <div class="comments">
                    <div class="line comment-label"><strong>Comments</strong></div>
                    <div class="line comment-help">(Please type any questions or feedback here)</div>
                </div>
                <div class="rx">
                    <textarea id="text-area" name="comments" rows="5" cols="38"></textarea>
                </div>
            </div>
            <div class="container">
                <div class="label">
                    <label for="contact">How may we contact you?</label>
                </div>
                <div>
                    <div>
                        <input type="checkbox" id="contact-email" name="contact_method[]" value="email">
                        <label for="contact-email"><small>E-mail</small></label>
                    </div>
                    <div>
                        <input type="checkbox" id="contact-postal" name="contact_method[]" value="postal">
                        <label for="contact-postal"><small>Postal Mail</small></label>
                    </div>
                    <div>
                        <input type="checkbox" id="contact-phone" name="contact_method[]" value="telephone">
                        <label for="contact-phone"><small>Telephone</small></label>
                    </div>
                    <div>
                        <input type="checkbox" id="contact-fax" name="contact_method[]" value="fax">
                        <label for="contact-fax"><small>Fax</small></label>
                    </div>
                </div>
            </div>
            <p>I would like to receive newsletters and information about special events by:</p>
            <div class="additional">
                <input type="checkbox" id="newsletter-email" name="newsletter[]" value="email">
                <label for="newsletter-email"><small>Email</small></label><br>
                <input type="checkbox" id="newsletter-postal" name="newsletter[]" value="postal">
                <label for="newsletter-postal"><small>Postal Mail</small></label>
            </div>
            <div class="selection-box">
                <input type="checkbox" id="volunteer" name="volunteer">
                <label for="volunteer">I would like information about volunteering with the organization.</label>
            </div>
            <div class="btn">
                <div>
                    <input type="submit" value="Submit">
                </div>
                <div>
                    <input type="reset" value="Reset">
                </div>
            </div>
            <p>
                <small>
                    You are on a secure server.<br>
                    If you have any issues, please contact .
                </small>
            </p>
        </div>
    </form>
</body>

</html>