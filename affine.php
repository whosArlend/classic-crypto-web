<?php

function modInverse($a, $m = 26) {
    $a = $a % $m;

    for ($x = 1; $x < $m; $x++) {
        if (($a * $x) % $m == 1) {
            return $x;
        }
    }

    return false;
}

function gcd($a, $b) {
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

function affineEncrypt($text, $a, $b) {
    if (gcd($a, 26) !== 1) {
        return false;
    }

    $cipherText = '';

    for ($i = 0; $i < strlen($text); $i++) {
        $x = ord($text[$i]) - ord('A');
        $y = ($a * $x + $b) % 26;
        $cipherText .= chr($y + ord('A'));
    }

    return $cipherText;
}

function affineDecrypt($text, $a, $b) {
    $inversA = modInverse($a, 26);
    if ($inversA === false) {
        return false;
    }

    $plainText = '';

    for ($i = 0; $i < strlen($text); $i++) {
        $y = ord($text[$i]) - ord('A');
        $x = ($inversA * ($y - $b + 26)) % 26;
        $plainText .= chr($x + ord('A'));
    }

    return $plainText;
}
