<?php
// 8. Simple Interest
echo "8. Simple Interest Calculation:<br>";
$principal = 1000;
$rate = 5;  // in percent
$time = 3;  // in years

$simple_interest = ($principal * $rate * $time) / 100;
echo "Simple Interest = " . $simple_interest . "<br><br>";

// 9. Swap Two Numbers Without Third Variable
echo "9. Swap Two Numbers Without Using a Third Variable:<br>";
$a = 10;
$b = 20;

echo "Before swapping: a = $a, b = $b<br>";

$a = $a + $b;
$b = $a - $b;
$a = $a - $b;

echo "After swapping: a = $a, b = $b<br><br>";

// 10. Check Leap Year
echo "10. Leap Year Check:<br>";
$year = 2024;

if (($year % 400 == 0) || (($year % 4 == 0) && ($year % 100 != 0))) {
    echo "$year is a leap year.<br><br>";
} else {
    echo "$year is not a leap year.<br><br>";
}

// 11. Factorial of a Number
echo "11. Factorial Calculation:<br>";
$number = 5;
$factorial = 1;

for ($i = 1; $i <= $number; $i++) {
    $factorial *= $i;
}

echo "Factorial of $number is $factorial<br><br>";

// 12. Print Prime Numbers Between 1 and 50
echo "12. Prime Numbers Between 1 and 50:<br>";
for ($num = 2; $num <= 50; $num++) {
    $isPrime = true;

    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            $isPrime = false;
            break;
        }
    }

    if ($isPrime) {
        echo $num . " ";
    }
}
echo "<br><br>";

// 13. Print Patterns
echo "13. Patterns:<br>";

// Pattern 1
echo "Pattern 1:<br>";
for ($i = 3; $i >= 1; $i--) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>";
}
for ($i = 2; $i <= 3; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>";
}
echo "<br>";

// Pattern 2
echo "Pattern 2:<br>";
for ($i = 1; $i <= 4; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo $j . " ";
    }
    echo "<br>";
}
echo "<br>";

// Pattern 3
echo "Pattern 3:<br>";
for ($i = 0; $i < 4; $i++) {
    $char = chr(65 + $i);
    for ($j = 0; $j <= $i; $j++) {
        echo $char . " ";
    }
    echo "<br>";
}
?>
