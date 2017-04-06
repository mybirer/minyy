<?php  
include 'baglanti.php';
$sifirlama_anahtar   = $_GET['anahtar'];
$kayitvarmi = mysql_query('SELECT id FROM uyelik WHERE sifirlama_anahtar = "'. $sifirlama_anahtar. '"');
if (mysql_num_rows($kayitvarmi) == 0) {
    header('Location: index.php');
}
?> 
