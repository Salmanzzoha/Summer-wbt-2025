<?php
// 1
$length = 10;
$width = 5;
$area = $length * $width;
$perimeter = 2 * ($length + $width);
echo "1. Rectangle Area: $area, Perimeter: $perimeter <br><br>";

// 2
$amount = 1000;
$vat = 0.15 * $amount;
echo "2. VAT on $amount is: $vat <br><br>";

// 3
$number = 7;
if ($number % 2 == 0) {
    echo "3. $number is Even <br><br>";
} else {
    echo "3. $number is Odd <br><br>";
}

// 4
$a = 25;
$b = 40;
$c = 30;
if ($a > $b && $a > $c) {
    $largest = $a;
} elseif ($b > $a && $b > $c) {
    $largest = $b;
} else {
    $largest = $c;
}
echo "4. Largest Number is: $largest <br><br>";

// 5
echo "5. Odd Numbers from 10 to 100: <br>";
for ($i = 10; $i <= 100; $i++) {
    if ($i % 2 != 0) {
        echo $i . " ";
    }
}
echo "<br><br>";

// 6
$numbers = array(5, 10, 15, 20, 25);
$search = 15;
$found = false;
foreach ($numbers as $n) {
    if ($n == $search) {
        $found = true;
        break;
    }
}
if ($found) {
    echo "6. Number $search found in array <br><br>";
} else {
    echo "6. Number $search not found in array <br><br>";
}

// 7
echo "7. Shapes: <br>";

// Shape 1
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "* ";
    }
    echo "<br>";
}
echo "<br>";

// Shape 2
$num = 1;
for ($i = 3; $i >= 1; $i--) {
    for ($j = 1; $j <= $i; $j++) {
        echo $num . " ";
        $num++;
    }
    echo "<br>";
}
echo "<br>";

// Shape 3
$char = 'A';
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo $char . " ";
        $char++;
    }
    echo "<br>";
}
?>