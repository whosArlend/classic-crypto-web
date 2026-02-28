<?php

function hillDeterminan($matrix) {
    $det = $matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0];
    return (($det % 26) + 26) % 26;
}

if (!function_exists('modInverse')) {
    require_once 'affine.php';
}

function hillInversMatriks($matrix) {
    $det = hillDeterminan($matrix);
    $det_inv = modInverse($det, 26);
    
    if ($det_inv === false) {
        return false;
    }
    
    $adj = [
        [$matrix[1][1], (26 - $matrix[0][1]) % 26],
        [(26 - $matrix[1][0]) % 26, $matrix[0][0]]
    ];
    
    $invers = [
        [
            ($det_inv * $adj[0][0]) % 26,
            ($det_inv * $adj[0][1]) % 26
        ],
        [
            ($det_inv * $adj[1][0]) % 26,
            ($det_inv * $adj[1][1]) % 26
        ]
    ];
    
    return $invers;
}

function hillEncrypt($text, $matrix) {
    if (hillInversMatriks($matrix) === false) {
        return false;
    }
    
    if (strlen($text) % 2 !== 0) {
        $text .= 'X';
    }
    
    $hasil = '';
    
    for ($i = 0; $i < strlen($text); $i += 2) {
        $p1 = ord($text[$i]) - ord('A');
        $p2 = ord($text[$i + 1]) - ord('A');
        
        $c1 = ($matrix[0][0] * $p1 + $matrix[0][1] * $p2) % 26;
        $c2 = ($matrix[1][0] * $p1 + $matrix[1][1] * $p2) % 26;
        
        if ($c1 < 0) $c1 += 26;
        if ($c2 < 0) $c2 += 26;
        
        $hasil .= chr($c1 + ord('A')) . chr($c2 + ord('A'));
    }
    
    return $hasil;
}

function hillDecrypt($text, $matrix) {
    $invers = hillInversMatriks($matrix);
    if ($invers === false) {
        return false;
    }
    
    if (strlen($text) % 2 !== 0) {
        $text .= 'X';
    }
    
    $teksDekripsi = '';
    
    for ($i = 0; $i < strlen($text); $i += 2) {
        $c1 = ord($text[$i]) - ord('A');
        $c2 = ord($text[$i + 1]) - ord('A');
        
        $p1 = ($invers[0][0] * $c1 + $invers[0][1] * $c2) % 26;
        $p2 = ($invers[1][0] * $c1 + $invers[1][1] * $c2) % 26;
        
        if ($p1 < 0) $p1 += 26;
        if ($p2 < 0) $p2 += 26;
        
        $teksDekripsi .= chr($p1 + ord('A')) . chr($p2 + ord('A'));
    }

    if (substr($teksDekripsi, -1) === 'X') {
        $teksDekripsi = substr($teksDekripsi, 0, -1);
    }

    return $teksDekripsi;
}
