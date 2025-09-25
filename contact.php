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
}
?>
