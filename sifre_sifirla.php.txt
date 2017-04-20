<?php 

/*ini_set('display_errors', 1);

error_reporting(E_ALL);*/

header('Content-Type: text/html; charset=utf-8');

$dbhost ="localhost";

$dbveritabani = "minyy";

$dbkullanici = "root";

$dbsifre = "";

$dbadi = "minyy";

 $baglanti = mysql_connect($dbhost,$dbkullanici,$dbsifre);

 $dbsec = mysql_select_db('minyy');

 mysql_query("SET NAMES UTF8");  // veri tabanından türkçe yazıları bozmadan çekme işlemi yapması için

 $length = 32;

$string = "";

$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=+"; // istedğin karakateri değiştir.

while ($length > 0) {

    $string .= $characters[mt_rand(0,strlen($characters)-1)];

    $length -= 1;

}

 $sifirlama_anahtar = $string;

if (true === isset($_POST['email'])) {

  $sifirlama_anahtar = sha1($_POST['email'] . $sifirlama_anahtar);

  $email = $_POST['email'];

} else {

    echo 'email girilmedi';

    return;

}

$host = $_SERVER['HTTP_HOST'];

$emailSorgu = mysql_query("SELECT * FROM uyelik WHERE email = '" . $email . "'");

// Eğer email sistemde mevcut ise parola sıfırlama maili gönnder

if (mysql_num_rows($emailSorgu) > 0) {

    require 'PHPMailerAutoload.php';

    $emailBilgileri = mysql_fetch_assoc($emailSorgu);

    $isim            = $emailBilgileri['isim'];

    $soyisim        = $emailBilgileri['soyisim'];

    $sifirlamaAdres = 'sifre_yenile.php?anahtar=' . $sifirlama_anahtar;

    $konu            = 'Şifre Hatırlatma';

    $mesaj            = '<p>Sayın&nbsp;' . $isim . ' ' . $soyisim . ',</p>

                        <p>Şifremi sıfırlama adresi aşağıdadır...</p>

                        <p>Şifre sıfırlama adresi:&nbsp; 
                        <a href="http://' . $host . '/deneme/sifre_yenile.php?anahtar=' . $sifirlama_anahtar . '">Tıklayınız</a></p>

                        ';

    $headers  = 'MIME-Version: 1.0' . "rn";

    $headers .= 'Content-type: text/html; charset=utf-8' . "rn";

    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Postayı SMTP kullanacak şekilde ayarla

    $mail->Host = 'smtp.gmail.com';  // Ana ve yedek SMTP sunucularını belirtin

    $mail->SMTPAuth = true;    

    //$mail->SMTPDebug = 1;// (Enable SMTP authentication) yani tramsfer protokolü aktif ise

    $mail->Username = 'mehmetonatbm@gmail.com';                 // SMTP kullanıcı

    $mail->Password = 'mehmet12345';                           // SMTP sifre

    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

    $mail->Port = 587;

    $mail->CharSet = 'UTF-8';

    $mail->From = 'mehmetonatbm@gmail.com';

    $mail->FromName = 'Mehmet ONAT';

    $mail->addAddress('mehmetonatbm@gmail.com');     // Bir alıcı ekle

    //$mail->addCC('m5821575@gmail.com');     // Bir alıcı ekle
    $mail->addReplyTo('mehmetonatbm@gmail.com');

    $mail->isHTML(true);                                  // E-posta biçimini HTML olarak ayarla

    $mail->Subject = $konu;

    $mail->Body    = $mesaj;

    if(!$mail->send()) {

        echo 'Message could not be sent.';

        echo 'Mailer Error: ' . $mail->ErrorInfo;

    } else {

        $simdi = new DateTime();

        $simdi = $simdi->format('Y-m-d H:i:s');

        mysql_query("UPDATE `uyelik` SET `sifirlama_anahtar` = '" . $sifirlama_anahtar . "' , 
        sifirlama_tarihi = '" . $simdi . ", onay_durum = 0' WHERE `email` = '" . $email . "'");

        echo 'Mail gönderildi.';

    }

} else {

    echo 'email sistemde mevcut değil';

    return;

}

    ?> 
