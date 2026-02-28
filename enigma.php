<?php

$ROTOR_I   = 'EKMFLGDQVZNTOWYHXUSPAIBRCJ';
$ROTOR_II  = 'AJDKSIRUXBLHWTMCQGZNPYFVOE';
$ROTOR_III = 'BDFHJLCPRTXVZNYEIWGAKMUSQO';

$REFLECTOR = 'YRUHQSLDPXNGOKMIEBFZCWVJAT';

function rotorSubstitusi($huruf, $rotor, $offset, $reverse = false) {
    $pos = ord($huruf) - ord('A');

    if ($reverse) {
        $target = chr(($pos + $offset) % 26 + ord('A'));
        $index = strpos($rotor, $target);

        if ($index === false) {
            return $huruf;
        }

        $hasil = ($index - $offset + 26) % 26;
        return chr($hasil + ord('A'));
    } else {
        $inputPos = ($pos + $offset) % 26;
        $mappedChar = $rotor[$inputPos];
        $mappedPos = (ord($mappedChar) - ord('A') - $offset + 26) % 26;

        return chr($mappedPos + ord('A'));
    }
}

function reflectorSubstitusi($huruf, $reflector) {
    $pos = ord($huruf) - ord('A');
    return $reflector[$pos];
}

function enigmaProsesHuruf($huruf, $posisi) {
    global $ROTOR_I, $ROTOR_II, $ROTOR_III, $REFLECTOR;

    $c = rotorSubstitusi($huruf, $ROTOR_I, $posisi[0], false);
    $c = rotorSubstitusi($c, $ROTOR_II, $posisi[1], false);
    $c = rotorSubstitusi($c, $ROTOR_III, $posisi[2], false);

    $c = reflectorSubstitusi($c, $REFLECTOR);

    $c = rotorSubstitusi($c, $ROTOR_III, $posisi[2], true);
    $c = rotorSubstitusi($c, $ROTOR_II, $posisi[1], true);
    $c = rotorSubstitusi($c, $ROTOR_I, $posisi[0], true);

    return $c;
}

function enigmaStep(&$posisi) {
    $posisi[0] = ($posisi[0] + 1) % 26;

    if ($posisi[0] === 0) {
        $posisi[1] = ($posisi[1] + 1) % 26;

        if ($posisi[1] === 0) {
            $posisi[2] = ($posisi[2] + 1) % 26;
        }
    }
}

function enigmaEncrypt($text, $key) {
    $text = strtoupper(preg_replace('/[^A-Z]/', '', $text));

    $posisi = [
        ord($key[0]) - ord('A'),
        ord($key[1]) - ord('A'),
        ord($key[2]) - ord('A')
    ];

    $hasil = '';

    for ($i = 0; $i < strlen($text); $i++) {
        $huruf = $text[$i];
        $hasil .= enigmaProsesHuruf($huruf, $posisi);
        enigmaStep($posisi);
    }

    return $hasil;
}

function enigmaDecrypt($text, $key) {
    return enigmaEncrypt($text, $key);
}