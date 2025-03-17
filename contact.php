<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    if (!$email) {
        // Prikazivanje greške ako email nije validan
        echo '
        <div style="text-align: center; color: #ff1100; background-color: #ffe000;">
            <h3>Neispravan email. Molimo unesite važeći email!</h3>
            <button style="color:  #ffe000; background-color: #198754; cursor:pointer;" onclick="window.location.href = document.referrer;">Vrati se</button>
        </div>';
        exit;  // Prekidamo dalje izvršavanje ako je email neispravan
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP konfiguracija
        $mail->isSMTP();
        $mail->Host = 'mail.mirazeca.com'; // Proveri u cPanelu za tačan SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@mirazeca.com'; 
        $mail->Password = 'u}Fn{PJEpCvh'; // Zameni pravom lozinkom
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; // Proveri u cPanelu da li je port 465 (SSL) ili 587 (TLS)

        // Podešavanje email-a
        $mail->setFrom('contact@mirazeca.com', 'Mira Zeca'); 
        $mail->addAddress('contact@mirazeca.com'); 
        $mail->addReplyTo($email, $name); 

        $mail->isHTML(true);
        $mail->Subject = "Nova poruka sa sajta";
        $mail->Body = "<strong>Ime:</strong> $name <br> <strong>Email:</strong> $email <br> <strong>Poruka:</strong> $message";

        $mail->send();
        
        // Prikazivanje odgovora i dugmeta
        echo '
        <div style="text-align: center; color: #198754; background-color: #ffe000;">
            <h3>Poruka je uspešno poslata!</h3>
             <button style="color: #ffe000; background-color: #198754; cursor:pointer;" onclick="window.location.href = document.referrer;">Vrati se</button>
        </div>';
    } catch (Exception $e) {
        echo "Greška pri slanju: {$mail->ErrorInfo}";
    }
}
?>
