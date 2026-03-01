<?php
require_once 'vigenere.php';
require_once 'affine.php';
require_once 'playfair.php';
require_once 'hill.php';
require_once 'enigma.php';

$hasil = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $algoritma  = $_POST['algoritma'] ?? '';
    $input_teks = $_POST['input_teks'] ?? '';
    $input_key  = $_POST['input_key'] ?? '';
    $aksi       = $_POST['aksi'] ?? '';

    $input_teks = strtoupper(preg_replace('/[^a-zA-Z]/', '', $input_teks));

    if (empty($input_teks)) {
        $error = 'Masukkan teks huruf A-Z saja.';
    } elseif (empty($algoritma)) {
        $error = 'Pilih algoritma terlebih dahulu.';
    } else {

        switch ($algoritma) {

            case 'vigenere':
                $key = strtoupper(preg_replace('/[^a-zA-Z]/', '', $input_key));
                if (empty($key)) {
                    $error = 'Key Vigenere harus berupa huruf.';
                } else {
                    $hasil = ($aksi === 'encrypt')
                        ? vigenereEncrypt($input_teks, $key)
                        : vigenereDecrypt($input_teks, $key);
                }
                break;

            case 'affine':
                $parts = array_map('trim', explode(',', $input_key));
                if (count($parts) !== 2) {
                    $error = 'Format key Affine: a,b (contoh 5,8)';
                } else {
                    $a = (int)$parts[0];
                    $b = (int)$parts[1];
                    $hasil = ($aksi === 'encrypt')
                        ? affineEncrypt($input_teks, $a, $b)
                        : affineDecrypt($input_teks, $a, $b);

                    if ($hasil === false) {
                        $error = 'Nilai a harus relatif prima dengan 26.';
                    }
                }
                break;

            case 'playfair':
                $key = strtoupper(preg_replace('/[^a-zA-Z]/', '', $input_key));
                if (empty($key)) {
                    $error = 'Key Playfair tidak boleh kosong.';
                } else {
                    $hasil = ($aksi === 'encrypt')
                        ? playfairEncrypt($input_teks, $key)
                        : playfairDecrypt($input_teks, $key);
                }
                break;

            case 'hill':
                $parts = array_map('trim', explode(',', $input_key));
                if (count($parts) !== 4) {
                    $error = 'Format key Hill: 3,3,2,5';
                } else {
                    $matrix = [
                        [(int)$parts[0] % 26, (int)$parts[1] % 26],
                        [(int)$parts[2] % 26, (int)$parts[3] % 26]
                    ];

                    $hasil = ($aksi === 'encrypt')
                        ? hillEncrypt($input_teks, $matrix)
                        : hillDecrypt($input_teks, $matrix);

                    if ($hasil === false) {
                        $error = 'Determinan matriks tidak memiliki invers modulo 26.';
                    }
                }
                break;

            case 'enigma':
                $key = strtoupper(preg_replace('/[^a-zA-Z]/', '', $input_key));
                $key = strlen($key) >= 3 ? substr($key, 0, 3) : 'AAA';

                $hasil = enigmaEncrypt($input_teks, $key);
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kalkulator Kriptografi Klasik</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Kalkulator Kriptografi Klasik</h1>
        <p class="subtitle">
            Implementasi Algoritma Kriptografi Klasik Berbasis Web Menggunakan PHP
        </p>

        <div class="student-info">
            <span class="student-name">Alif Arlendi Putra Priyanto</span>
        </div>
    </header>

    <form method="POST" class="crypto-form">

        <div class="form-group">
            <label>Pilih Algoritma</label>
            <select name="algoritma" id="algoritma" required>
                <option value="">-- Pilih Algoritma --</option>
                <option value="vigenere">Vigenere Cipher</option>
                <option value="affine">Affine Cipher</option>
                <option value="playfair">Playfair Cipher</option>
                <option value="hill">Hill Cipher (2x2)</option>
                <option value="enigma">Enigma Cipher</option>
            </select>
        </div>

        <div class="form-group">
            <label>Input Teks</label>
            <textarea name="input_teks" rows="4"
                oninput="this.value = this.value.toUpperCase();"
                placeholder="Masukkan teks di sini..."><?php echo $_POST['input_teks'] ?? ''; ?></textarea>
        </div>

        <div class="form-group">
            <label>Key</label>
            <input type="text" name="input_key" id="input_key"
                placeholder="Masukkan key sesuai algoritma"
                value="<?php echo $_POST['input_key'] ?? ''; ?>">
            <small class="key-hint" id="keyHint">
                Pilih algoritma untuk melihat format key.
            </small>
        </div>

        <div class="button-group">
            <button type="submit" name="aksi" value="encrypt" class="btn btn-encrypt">Encrypt</button>
            <button type="submit" name="aksi" value="decrypt" class="btn btn-decrypt">Decrypt</button>
        </div>

        <p class="note">
            Catatan: Program hanya memproses huruf A–Z dan mengabaikan karakter lain.
        </p>

    </form>

    <?php if (!empty($error)): ?>
        <div class="output-box error">
            <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($hasil)): ?>
        <div class="output-box success">
            <strong>Hasil:</strong>
            <p class="result"><?php echo htmlspecialchars($hasil); ?></p>
        </div>
    <?php endif; ?>

</div>

<footer>
    © 2026 - Tugas Mata Kuliah Kriptografi | Alif Arlendi Putra Priyanto
</footer>

<script>
const algoritmaSelect = document.getElementById("algoritma");
const keyHint = document.getElementById("keyHint");

algoritmaSelect.addEventListener("change", function() {
    switch (this.value) {
        case "vigenere":
            keyHint.textContent = "Gunakan kata huruf saja. Contoh: KUNCI.";
            break;
        case "affine":
            keyHint.textContent = "Gunakan dua angka dipisah koma. Contoh: 5,8.";
            break;
        case "playfair":
            keyHint.textContent = "Gunakan kata huruf saja. Huruf I/J digabung.";
            break;
        case "hill":
            keyHint.textContent = "Gunakan 4 angka dipisah koma. Contoh: 3,3,2,5.";
            break;
        case "enigma":
            keyHint.textContent = "Gunakan 3 huruf posisi awal rotor. Contoh: ABC.";
            break;
        default:
            keyHint.textContent = "Pilih algoritma untuk melihat format key.";
    }
});
</script>

</body>
</html>