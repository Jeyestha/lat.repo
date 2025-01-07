<?php
$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'secret' => '6LdcabAqAAAAAIMxu9rsfPAR4szBAUcBFluBb9rk',
    'response' => $_POST['g-recaptcha-response'],

]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$result = json_decode($response);
if ($result->success) {
    echo "validasi berhasil";
    return;
}

echo 'apakah kamu robot?';

?>