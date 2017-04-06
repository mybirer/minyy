<?php 

include 'baglanti.php';

$sifre1 = $_POST["parola"]; // 1. sifreyi cek --

$sifre2 = $_POST["parolaonay"]; // 2. sifreyi cek --

$sifirlama_anahtar = $_POST['anahtar'];

if ($sifre1 != $sifre2){

    echo "İki şifre birbirine uyuşmuyor"; 

    header("Location: sifre_yenile.php?anahtar=" . $sifirlama_anahtar);

}

$sifre1 = sha1($sifre1);

$sorgu = "UPDATE uyelik SET sifre = '" . $sifre1.  "', onay_durum = '1', sifirlama_anahtar = '', sifirlama_tarihi = '0000-00-00 00:00:00' WHERE  sifirlama_anahtar = '" . $sifirlama_anahtar . "' ";

$dogrulama  = mysql_query($sorgu);

?>
