<?php

function vigenereEncrypt($text, $key) {
    $teksHasil = '';
    $panjangKunci = strlen($key);

    for ($i = 0; $i < strlen($text); $i++) {
        $p = ord($text[$i]) - ord('A');
        $k = ord($key[$i % $panjangKunci]) - ord('A');
        $c = ($p + $k) % 26;
        $teksHasil .= chr($c + ord('A'));
    }

    return $teksHasil;
}

function vigenereDecrypt($text, $key) {
    $teksAsli = '';
    $panjangKunci = strlen($key);

    for ($i = 0; $i < strlen($text); $i++) {
        $c = ord($text[$i]) - ord('A');
        $k = ord($key[$i % $panjangKunci]) - ord('A');
        $p = ($c - $k + 26) % 26;
        $teksAsli .= chr($p + ord('A'));
    }

    return $teksAsli;
}
