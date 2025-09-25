<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $phone   = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    $to      = "info@laptoprepairshop.nl"; // <-- vervang met jouw e-mailadres
    $subject = "Nieuw contactformulier bericht van $name";
    $body    = "Naam: $name\nEmail: $email\nTelefoon: $phone\n\nBericht:\n$message";
    $headers = "From: $email";


    if (mail($to, $subject, $body, $headers)) {
        echo "Bedankt $name, uw bericht is verstuurd!";
    } else {
        echo "Er is iets misgegaan, probeer het later opnieuw.";
    }

    // reCAPTCHA verificatie
    $recaptcha_secret = "6LfjAdUrAAAAAE4_B4vopojoo--guR4R1CHt37-K"; // van Google
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret="
        . $recaptcha_secret . "&response=" . $recaptcha_response
    );
    $responseData = json_decode($verify);

    if ($responseData->success) {
        // Email naar jou
        $to      = "info@laptoprepairshop.nl"; // <-- vervang met jouw e-mailadres
        $subject = "Nieuw contactformulier bericht van $name";
        $body    = "Naam: $name\nEmail: $email\nTelefoon: $phone\n\nBericht:\n$message";
        $headers = "From: $email";

        // Email naar klant
        $confirm_subject = "Bevestiging: uw bericht is ontvangen";
        $confirm_body = "Beste $name,\n\nBedankt voor uw bericht. Wij nemen zo snel mogelijk contact met u op.\n\nUw bericht:\n$message\n\nMet vriendelijke groet,\nLaptopRepairShop.nl";
        $confirm_headers = "From: info@laptoprepairshop.nl";

        if (mail($to, $subject, $body, $headers) && mail($email, $confirm_subject, $confirm_body, $confirm_headers)) {
            echo "Bedankt $name, uw bericht is verstuurd en u ontvangt een bevestiging per e-mail.";
        } else {
            echo "Er is iets misgegaan bij het verzenden. Probeer het later opnieuw.";
        }
    } else {
        echo "❌ reCAPTCHA verificatie mislukt. Probeer opnieuw.";
    }
}
?>
