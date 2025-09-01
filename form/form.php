<?php
// ---------- Helper ----------
function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }

// Collect values (sticky form)
$V = [
    // Donor information
    'first_name' => '',
    'last_name'  => '',
    'company'    => '',
    'address1'   => '',
    'address2'   => '',
    'city'       => '',
    'state'      => '',
    'zip_code'   => '',
    'country'    => '',
    'phone'      => '',
    'fax'        => '',
    'email'      => '',
    // Donation
    'donation_amount' => '',
    'other_amount'    => '',
    'recurring_donation' => '',
    'cc_monthly_amount'  => '',
    'cc_for'             => '',
    'cc_month'           => '',
    // Honorarium section
    'honor_choice'        => '',
    'honor_name'          => '',
    'acknowledge_to'      => '',
    'honor_address'       => '',
    'honor_city'          => '',
    'honor_state'         => '',
    'honor_zip'           => '',
    // Additional info
    'publication_name'    => '',
    'comments'            => '',
    'gift_anonymous'      => '',
    'employer_match'      => '',
    'no_thank_you_letter' => '',
    // Contact method (multiple)
    'contact_method'      => [],
    // Newsletter
    'newsletter_email'    => '',
    'newsletter_postal'   => '',
    // Volunteer
    'volunteer_info'      => '',
];

$errors = [];
$submitted_ok = false;

// Map for nicer field names in error messages
$label = [
    'first_name'=>'First Name', 'last_name'=>'Last Name', 'company'=>'Company',
    'address1'=>'Address 1', 'address2'=>'Address 2', 'city'=>'City', 'state'=>'State',
    'zip_code'=>'Zip Code', 'country'=>'Country', 'phone'=>'Phone', 'fax'=>'Fax', 'email'=>'Email',
    'donation_amount'=>'Donation Amount', 'other_amount'=>'Other Amount',
];

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fill values safely
    foreach ($V as $k => $_) {
        if ($k === 'contact_method') {
            $V[$k] = isset($_POST[$k]) && is_array($_POST[$k]) ? array_map('strip_tags', $_POST[$k]) : [];
        } else {
            $V[$k] = trim((string)($_POST[$k] ?? ''));
        }
    }

    // Required fields (based on your * markers)
    $required = [
        'first_name','last_name','address1','address2','city','state','zip_code','country','email','donation_amount'
    ];

    foreach ($required as $r) {
        if ($r === 'state' && ($V['state']==='' || $V['state']==='select')) {
            $errors[] = "{$label[$r]} is required.";
        } elseif ($r === 'country' && ($V['country']==='' || $V['country']==='select')) {
            $errors[] = "{$label[$r]} is required.";
        } elseif ($V[$r] === '') {
            $errors[] = "{$label[$r]} is required.";
        }
    }

    // Email format
    if ($V['email'] && !filter_var($V['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format is invalid.";
    }

    // Zip basic check (optional: make sure it's alphanumeric to allow non-US)
    if ($V['zip_code'] && !preg_match('/^[A-Za-z0-9\- ]+$/', $V['zip_code'])) {
        $errors[] = "Zip Code looks invalid.";
    }

    // Donation logic: if "other" chosen, require other_amount numeric > 0
    if ($V['donation_amount'] === 'other') {
        if ($V['other_amount'] === '') {
            $errors[] = "Other Amount is required when 'Other' is selected.";
        } elseif (!is_numeric($V['other_amount']) || (float)$V['other_amount'] <= 0) {
            $errors[] = "Other Amount must be a positive number.";
        }
    }

    $submitted_ok = empty($errors);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Form</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8" />
</head>
<body>

    <!-- Errors -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$submitted_ok): ?>
        <div style="color:#b00020; border:1px solid #b00020; padding:10px; margin:10px 0;">
            <strong>Please fix the following:</strong>
            <ul style="margin:8px 16px;">
                <?php foreach ($errors as $err): ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?php echo e($_SERVER['PHP_SELF']); ?>">

        <div class="whole">
            <div class="first">
                <small>
                    <span class="asteric">*</span>
                    - Denotes Required Information
                </small><br>
                <p>&gt; <strong>1 Donation</strong> &gt; 2 Confirmation &gt; Thank You!</p>
            </div>

            <h1>Donor Information</h1>
            <div>
                <div class="container">
                    <div class="label">
                        <label for="first-name">First Name <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="first-name" name="first_name" value="<?php echo e($V['first_name']); ?>" required>
                    </div>
                </div>

                <div class="container">
                    <div class="label">
                        <label for="last-name">Last Name <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="last-name" name="last_name" value="<?php echo e($V['last_name']); ?>" required>
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="company">Company</label></div>
                    <div class="text-box">
                        <input type="text" id="company" name="company" value="<?php echo e($V['company']); ?>">
                    </div>
                </div>

                <div class="container">
                    <div class="label">
                        <label for="address-1">Address 1 <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="address-1" name="address1" value="<?php echo e($V['address1']); ?>" required>
                    </div>
                </div>

                <div class="container">
                    <div class="label">
                        <label for="address-2">Address 2 <span class="important">*</span></label>
                    </div>
                    <div class="text-box">
                        <input type="text" id="address-2" name="address2" value="<?php echo e($V['address2']); ?>" required>
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="city">City <span class="important">*</span></label></div>
                    <div class="text-box">
                        <input type="text" id="city" name="city" value="<?php echo e($V['city']); ?>" required>
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="state">State <span class="important">*</span></label></div>
                    <div class="text-box">
                        <select name="state" id="state" required>
                            <option value="select" <?php echo $V['state']==='select'?'selected':''; ?>>Select a state</option>
                            <option value="Bangladesh" <?php echo $V['state']==='Bangladesh'?'selected':''; ?>>Bangladesh</option>
                            <option value="USA" <?php echo $V['state']==='USA'?'selected':''; ?>>USA</option>
                        </select>
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="zip-code">Zip Code <span class="important">*</span></label></div>
                    <div class="text-box">
                        <input type="text" id="zip-code" name="zip_code" value="<?php echo e($V['zip_code']); ?>" required>
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="country">Country <span class="important">*</span></label></div>
                    <div class="text-box">
                        <select name="country" id="country" required>
                            <option value="select" <?php echo $V['country']==='select'?'selected':''; ?>>Select a country</option>
                            <option value="Bangladesh" <?php echo $V['country']==='Bangladesh'?'selected':''; ?>>Bangladesh</option>
                            <option value="USA" <?php echo $V['country']==='USA'?'selected':''; ?>>USA</option>
                        </select>
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="phone">Phone</label></div>
                    <div class="text-box">
                        <input type="text" id="phone" name="phone" value="<?php echo e($V['phone']); ?>">
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="fax">Fax</label></div>
                    <div class="text-box">
                        <input type="text" id="fax" name="fax" value="<?php echo e($V['fax']); ?>">
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="email">Email <span class="important">*</span></label></div>
                    <div class="text-box">
                        <input type="email" id="email" name="email" value="<?php echo e($V['email']); ?>" required>
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label>Donation Amount <span class="important">*</span></label></div>
                    <div class="parent-wrapper">
                        <?php
                        $opts = [
                            'none' => 'None',
                            '50'   => '$50',
                            '75'   => '$75',
                            '100'  => '$100',
                            '250'  => '$250',
                            'other'=> 'Other',
                        ];
                        foreach ($opts as $val=>$text):
                            $id = 'amt_' . $val;
                        ?>
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="<?php echo $id; ?>" name="donation_amount" value="<?php echo $val; ?>"
                                    <?php echo ($V['donation_amount']===$val)?'checked':''; ?> required>
                            </div>
                            <div class="radio-label">
                                <label for="<?php echo $id; ?>"><?php echo $text; ?></label>
                            </div>
                        </div>
                        <?php endforeach; ?>
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
                            <input type="text" id="other-amount" name="other_amount" value="<?php echo e($V['other_amount']); ?>"
                                   <?php echo ($V['donation_amount']==='other')?'required':''; ?>>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="label">
                        <label for="re-donation">Recurring Donation</label>
                        <small>(Check if yes)</small><br>
                    </div>
                    <div>
                        <input type="checkbox" id="re-donation" name="recurring_donation" value="1" <?php echo $V['recurring_donation']?'checked':''; ?>>
                        <label for="re-donation">I am interested in giving on a regular basis.</label>
                    </div>
                </div>

                <div class="credit-card">
                    <small>Monthly Credit Card $</small>
                    <input type="text" name="cc_monthly_amount" value="<?php echo e($V['cc_monthly_amount']); ?>">
                    <small>For</small>
                    <input type="text" name="cc_for" value="<?php echo e($V['cc_for']); ?>">
                    <small>Month</small>
                    <input type="text" name="cc_month" value="<?php echo e($V['cc_month']); ?>">
                </div>
            </div>

            <!-- ----------------------------Second section------------------------------------------- -->
            <h1>Honorarium and Memorial Donation Information</h1>
            <div>
                <div class="container">
                    <div class="label">
                        <label>I would like to make this donation</label>
                    </div>
                    <div class="donation-wrap">
                        <?php
                        $hopts = ['none'=>'None','50'=>'$50'];
                        foreach ($hopts as $val=>$text):
                            $hid = 'hon_' . $val;
                        ?>
                        <div class="wrapper">
                            <div class="radio">
                                <input type="radio" id="<?php echo $hid; ?>" name="honor_choice" value="<?php echo $val; ?>"
                                    <?php echo ($V['honor_choice']===$val)?'checked':''; ?>>
                            </div>
                            <div class="radio-label">
                                <label for="<?php echo $hid; ?>"><?php echo $text; ?></label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="honor-name">Name</label></div>
                    <div class="text-box">
                        <input type="text" id="honor-name" name="honor_name" value="<?php echo e($V['honor_name']); ?>">
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="acknowledge-donation">Acknowledge Donation to</label></div>
                    <div class="text-box">
                        <input type="text" id="acknowledge-donation" name="acknowledge_to" value="<?php echo e($V['acknowledge_to']); ?>">
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="honor-address">Address</label></div>
                    <div class="text-box">
                        <input type="text" id="honor-address" name="honor_address" value="<?php echo e($V['honor_address']); ?>">
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="honor-city">City</label></div>
                    <div class="text-box">
                        <input type="text" id="honor-city" name="honor_city" value="<?php echo e($V['honor_city']); ?>">
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="honor-state">State</label></div>
                    <div class="text-box">
                        <select name="honor_state" id="honor-state">
                            <option value="">Select a state</option>
                            <option value="Bangladesh" <?php echo $V['honor_state']==='Bangladesh'?'selected':''; ?>>Bangladesh</option>
                            <option value="USA" <?php echo $V['honor_state']==='USA'?'selected':''; ?>>USA</option>
                        </select>
                    </div>
                </div>

                <div class="container">
                    <div class="label"><label for="honor-zip">Zip Code</label></div>
                    <div class="text-box">
                        <input type="text" id="honor-zip" name="honor_zip" value="<?php echo e($V['honor_zip']); ?>">
                    </div>
                </div>
            </div>

            <!-- --------------------------------------Third section----------------------------------------------- -->
            <h1>Additional Information</h1>
            <p>Please enter your name, company or organization as you would like it to appear in our publications:</p>

            <div class="container">
                <div class="label"><label for="publication-name">Name</label></div>
                <div class="text-box">
                    <input type="text" id="publication-name" name="publication_name" value="<?php echo e($V['publication_name']); ?>">
                </div>
            </div>

            <div class="selection-box">
                <div>
                    <input type="checkbox" id="gift-anon" name="gift_anonymous" value="1" <?php echo $V['gift_anonymous']?'checked':''; ?>>
                    <label for="gift-anon">I would like my gift to remain anonymous.</label>
                </div>
                <div>
                    <input type="checkbox" id="employer-match" name="employer_match" value="1" <?php echo $V['employer_match']?'checked':''; ?>>
                    <label for="employer-match">My employer offers a matching gift program. I will mail the matching gift form.</label>
                </div>
                <div>
                    <input type="checkbox" id="no-thanks" name="no_thank_you_letter" value="1" <?php echo $V['no_thank_you_letter']?'checked':''; ?>>
                    <label for="no-thanks">Please save the cost of acknowledging this gift by not mailing a thank you letter.</label>
                </div>
            </div>

            <div class="container area">
                <div class="comments">
                    <div class="line comment-label"><strong>Comments</strong></div>
                    <div class="line comment-help">(Please type any question and feedback</div>
                    <div class="line comment-here">here)</div>
                </div>
                <div class="rx">
                    <textarea id="text-area" name="comments" rows="5" cols="38"><?php echo e($V['comments']); ?></textarea>
                </div>
            </div>

            <div class="container">
                <div class="label"><label>How may we contact you?</label></div>
                <div>
                    <div>
                        <input type="checkbox" id="contact-email" name="contact_method[]" value="email"
                            <?php echo in_array('email',$V['contact_method'],true)?'checked':''; ?>>
                        <label for="contact-email"><small>E-mail</small></label>
                    </div>
                    <div>
                        <input type="checkbox" id="contact-postal" name="contact_method[]" value="postal"
                            <?php echo in_array('postal',$V['contact_method'],true)?'checked':''; ?>>
                        <label for="contact-postal"><small>Postal Mail</small></label>
                    </div>
                    <div>
                        <input type="checkbox" id="contact-phone" name="contact_method[]" value="telephone"
                            <?php echo in_array('telephone',$V['contact_method'],true)?'checked':''; ?>>
                        <label for="contact-phone"><small>Telephone</small></label>
                    </div>
                    <div>
                        <input type="checkbox" id="contact-fax" name="contact_method[]" value="fax"
                            <?php echo in_array('fax',$V['contact_method'],true)?'checked':''; ?>>
                        <label for="contact-fax"><small>Fax</small></label>
                    </div>
                </div>
            </div>

            <p>I would like to receive newsletters and information about special events by:</p>
            <div class="additional">
                <input type="checkbox" id="nw-email" name="newsletter_email" value="1" <?php echo $V['newsletter_email']?'checked':''; ?>>
                <label for="nw-email"><small>Email</small></label><br>
                <input type="checkbox" id="nw-postal" name="newsletter_postal" value="1" <?php echo $V['newsletter_postal']?'checked':''; ?>>
                <label for="nw-postal"><small>Postal Mail</small></label>
            </div>

            <div class="selection-box">
                <input type="checkbox" id="volunteer" name="volunteer_info" value="1" <?php echo $V['volunteer_info']?'checked':''; ?>>
                <label for="volunteer">I would like information about volunteering with the</label>
            </div>

            <div class="btn">
                <div>
                    <input type="submit" value="submit">
                </div>
                <div>
                    <input type="reset" value="Reset">
                </div>
            </div>

            <p>
                <small>
                    🔒 Donate online with confidence. You are on a secure server. <br>
                    If you have any problems or questions, please contact support.
                </small>
            </p>

        </div>
    </form>

    <!-- Show submitted data under the form -->
    <?php if ($submitted_ok): ?>
        <div style="margin-top:24px; padding:16px; border:1px solid #ccc; border-radius:8px;">
            <h3>Submitted Data</h3>
            <div style="display:grid; grid-template-columns: 220px 1fr; gap:6px 14px;">
                <?php
                // helper to print rows
                function row($k,$v){ if($v!=='' && $v!=='0'){ echo '<div><strong>'.e($k).'</strong></div><div>'.(is_array($v)?e(implode(', ',$v)):e($v)).'</div>'; } }
                row('First Name', $V['first_name']);
                row('Last Name', $V['last_name']);
                row('Company', $V['company']);
                row('Address 1', $V['address1']);
                row('Address 2', $V['address2']);
                row('City', $V['city']);
                row('State', $V['state']);
                row('Zip Code', $V['zip_code']);
                row('Country', $V['country']);
                row('Phone', $V['phone']);
                row('Fax', $V['fax']);
                row('Email', $V['email']);
                row('Donation Amount', $V['donation_amount']==='other' ? 'Other: $'.$V['other_amount'] : ($V['donation_amount'] ? '$'.$V['donation_amount'] : ''));
                row('Recurring Donation', $V['recurring_donation'] ? 'Yes' : 'No');
                row('Monthly CC $', $V['cc_monthly_amount']);
                row('For (months)', $V['cc_for']);
                row('Month', $V['cc_month']);
                // Honorarium
                row('Honorarium Choice', $V['honor_choice'] ? ($V['honor_choice']==='none'?'None':'$'.$V['honor_choice']) : '');
                row('Honor Name', $V['honor_name']);
                row('Acknowledge Donation to', $V['acknowledge_to']);
                row('Honor Address', $V['honor_address']);
                row('Honor City', $V['honor_city']);
                row('Honor State', $V['honor_state']);
                row('Honor Zip', $V['honor_zip']);
                // Additional
                row('Publication Name', $V['publication_name']);
                row('Anonymous Gift', $V['gift_anonymous'] ? 'Yes' : 'No');
                row('Employer Match', $V['employer_match'] ? 'Yes' : 'No');
                row('No Thank You Letter', $V['no_thank_you_letter'] ? 'Yes' : 'No');
                row('Comments', $V['comments']);
                row('Contact Method(s)', $V['contact_method']);
                row('Newsletter Email', $V['newsletter_email'] ? 'Yes' : 'No');
                row('Newsletter Postal', $V['newsletter_postal'] ? 'Yes' : 'No');
                row('Volunteer Info', $V['volunteer_info'] ? 'Yes' : 'No');
                ?>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>