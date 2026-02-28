# Kalkulator Kriptografi Klasik

Implementasi Algoritma Kriptografi Klasik Berbasis Web Menggunakan PHP

Project ini dibuat untuk tugas kuliah mata kuliah Kriptografi. Mengimplementasikan 5 algoritma kriptografi klasik menggunakan **PHP murni** (tanpa framework dan tanpa library eksternal).

---

## Algoritma yang Diimplementasikan

### 1. Vigenere Cipher

Algoritma substitusi polialfabetik yang menggunakan tabel Vigenere. Setiap huruf plaintext dienkripsi dengan pergeseran berdasarkan huruf key yang berulang. Rumus enkripsi: **C = (P + K) mod 26**. Vigenere lebih aman daripada Caesar cipher karena satu huruf plaintext dapat menghasilkan huruf ciphertext yang berbeda tergantung posisinya.

### 2. Affine Cipher

Algoritma substitusi yang menggabungkan perkalian dan penjumlahan. Rumus enkripsi: **E(x) = (a*x + b) mod 26**. Agar dapat didekripsi, nilai **a** harus relatif prima dengan 26 (memiliki invers modulo 26). Key format: **a,b** (contoh: 5,8).

### 3. Playfair Cipher

Algoritma substitusi digraph yang menggunakan matriks 5x5. Huruf I dan J digabung dalam satu sel. Teks dipecah menjadi pasangan dua huruf; jika ada duplikasi atau panjang ganjil, digunakan filler 'X'. Aturan enkripsi berdasarkan posisi: baris sama→geser kanan, kolom sama→geser bawah, lain→bentuk persegi.

### 4. Hill Cipher (Matrix 2x2)

Algoritma substitusi polygraph menggunakan perkalian matriks. Setiap blok 2 huruf dikalikan dengan matriks key 2x2. Key berupa 4 angka dipisah koma: **a,b,c,d** untuk matriks [[a,b],[c,d]]. Determinan matriks harus memiliki invers modulo 26 agar dekripsi mungkin.

### 5. Enigma Cipher (Simulasi Sederhana)

Simulasi mesin Enigma dengan 3 rotor dan 1 reflector. Enigma bersifat simetris: proses encrypt dan decrypt identik. Key 3 huruf menentukan posisi awal rotor (misal: AAA, XYZ). Setiap karakter diproses, rotor pertama berputar; mirip mekanisme mesin Enigma asli.

---

## Cara Menjalankan

### Persyaratan

- PHP 7.4 atau lebih baru
- Web server (Apache, Nginx, atau PHP built-in server)

### Menjalankan di Localhost

**Opsi 1: PHP Built-in Server**

```bash
cd classic-crypto-web
php -S localhost:8000
```

Buka browser dan akses: **http://localhost:8000**

**Opsi 2: XAMPP / WAMP / Laragon**

1. Salin folder `classic-crypto-web` ke `htdocs` (XAMPP) atau folder web server Anda.
2. Akses melalui: **http://localhost/classic-crypto-web/**

---

## Contoh Input dan Output

### Vigenere Cipher
- **Plaintext:** HELLO  
- **Key:** KEY  
- **Ciphertext:** RIJVS  

### Affine Cipher
- **Plaintext:** HELLO  
- **Key:** 5,8  
- **Ciphertext:** RCLLA  

### Playfair Cipher
- **Plaintext:** HELLO  
- **Key:** MONARCHY  
- **Ciphertext:** CFSUPM  

### Hill Cipher
- **Plaintext:** HELLO  
- **Key:** 3,3,2,5  
- **Ciphertext:** SLBCY  

### Enigma Cipher
- **Plaintext:** HELLO  
- **Key:** AAA  
- **Ciphertext:** (berbeda setiap posisi rotor)  

---

## Struktur Folder

```
classic-crypto-web/
│
├── index.php      # Halaman utama dengan form
├── vigenere.php   # Implementasi Vigenere Cipher
├── affine.php     # Implementasi Affine Cipher
├── playfair.php   # Implementasi Playfair Cipher
├── hill.php       # Implementasi Hill Cipher 2x2
├── enigma.php     # Implementasi Enigma (simulasi 3 rotor)
├── style.css      # Styling halaman
└── README.md      # Dokumentasi
```

---

## Spesifikasi Teknis

- **PHP procedural** (tanpa OOP/framework)
- **Tidak ada library eksternal**
- Semua algoritma hanya memproses huruf **A-Z** (26 alfabet)
- Input otomatis diubah ke **uppercase**
- Karakter non-alfabet **diabaikan**
- Encrypt dan decrypt telah diverifikasi kebenarannya

---

## Catatan

Project ini dibuat untuk keperluan pembelajaran dan tugas mata kuliah Kriptografi. Algoritma yang diimplementasikan adalah algoritma klasik yang bersifat pendidikan; tidak disarankan untuk enkripsi data sensitif di lingkungan produksi.
