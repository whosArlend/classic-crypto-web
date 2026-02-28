<?php

function buatMatriksPlayfair($key) {
    $alfabet = 'ABCDEFGHIKLMNOPQRSTUVWXYZ';
    $digunakan = [];
    $matriks = [];
    $idx = 0;
    
    for ($i = 0; $i < strlen($key); $i++) {
        $huruf = $key[$i];
        if ($huruf === 'J') $huruf = 'I';
        if (!isset($digunakan[$huruf])) {
            $digunakan[$huruf] = true;
            $matriks[(int)($idx / 5)][$idx % 5] = $huruf;
            $idx++;
        }
    }
    
    for ($i = 0; $i < 25; $i++) {
        $huruf = $alfabet[$i];
        if (!isset($digunakan[$huruf])) {
            $matriks[(int)($idx / 5)][$idx % 5] = $huruf;
            $idx++;
        }
    }
    
    return $matriks;
}

function cariPosisi($matriks, $huruf) {
    if ($huruf === 'J') $huruf = 'I';
    
    for ($r = 0; $r < 5; $r++) {
        for ($c = 0; $c < 5; $c++) {
            if ($matriks[$r][$c] === $huruf) {
                return [$r, $c];
            }
        }
    }
    return false;
}

function pecahDigraph($text) {
    $pasangan = [];
    $i = 0;
    
    while ($i < strlen($text)) {
        $h1 = $text[$i];
        $h2 = ($i + 1 < strlen($text)) ? $text[$i + 1] : 'X';
        
        if ($h1 === $h2) {
            $pasangan[] = [$h1, 'X'];
            $i++;
        } else {
            $pasangan[] = [$h1, $h2];
            $i += 2;
        }
    }
    
    return $pasangan;
}

function playfairEncrypt($text, $key) {
    $matriks = buatMatriksPlayfair($key);
    $pasangan = pecahDigraph($text);
    $hasil = '';
    
    foreach ($pasangan as $p) {
        $pos1 = cariPosisi($matriks, $p[0]);
        $pos2 = cariPosisi($matriks, $p[1]);
        
        if ($pos1 === false || $pos2 === false) continue;
        
        list($r1, $c1) = $pos1;
        list($r2, $c2) = $pos2;
        
        if ($r1 === $r2) {
            $hasil .= $matriks[$r1][($c1 + 1) % 5];
            $hasil .= $matriks[$r2][($c2 + 1) % 5];
        } elseif ($c1 === $c2) {
            $hasil .= $matriks[($r1 + 1) % 5][$c1];
            $hasil .= $matriks[($r2 + 1) % 5][$c2];
        } else {
            $hasil .= $matriks[$r1][$c2];
            $hasil .= $matriks[$r2][$c1];
        }
    }
    
    return $hasil;
}

function playfairDecrypt($text, $key) {
    $matriks = buatMatriksPlayfair($key);
    $pasangan = [];
    
    for ($i = 0; $i < strlen($text); $i += 2) {
        $h1 = $text[$i];
        $h2 = ($i + 1 < strlen($text)) ? $text[$i + 1] : 'X';
        $pasangan[] = [$h1, $h2];
    }
    
    $hasil = '';
    
    foreach ($pasangan as $p) {
        $pos1 = cariPosisi($matriks, $p[0]);
        $pos2 = cariPosisi($matriks, $p[1]);
        
        if ($pos1 === false || $pos2 === false) continue;
        
        list($r1, $c1) = $pos1;
        list($r2, $c2) = $pos2;
        
        if ($r1 === $r2) {
            $hasil .= $matriks[$r1][($c1 + 4) % 5];
            $hasil .= $matriks[$r2][($c2 + 4) % 5];
        } elseif ($c1 === $c2) {
            $hasil .= $matriks[($r1 + 4) % 5][$c1];
            $hasil .= $matriks[($r2 + 4) % 5][$c2];
        } else {
            $hasil .= $matriks[$r1][$c2];
            $hasil .= $matriks[$r2][$c1];
        }
    }
    
    $hasil_bersih = '';
    for ($i = 0; $i < strlen($hasil); $i++) {
        $c = $hasil[$i];
        if ($c === 'X' && $i > 0 && $i < strlen($hasil) - 1) {
            if ($hasil[$i - 1] === $hasil[$i + 1]) {
                continue;
            }
        }
        $hasil_bersih .= $c;
    }
    
    return $hasil_bersih;
}
