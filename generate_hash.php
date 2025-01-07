<?php
// Password yang ingin di-hash
$password = 'password123'; // Ganti dengan password yang ingin Anda hash

// Menghasilkan hash dari password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menampilkan hash
echo "Hash dari password '$password' adalah: $hashed_password";
?>