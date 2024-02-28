<?php

if(!$_POST) exit;

// Email address verification, do not edit.
function isEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$form_name       = $_POST['form_name'];
$email           = $_POST['email'];
$phone           = $_POST['phone'];
$no_of_persons   = $_POST['no_of_persons'];
$preferred_food  = $_POST['preferred_food'];
$occasion        = $_POST['occasion'];

if(trim($form_name) == '') {
    echo '<div class="error_message">¡Atención! Debes ingresar tu nombre.</div>';
    exit();
} elseif(trim($email) == '') {
    echo '<div class="error_message">¡Atención! Por favor ingresa una dirección de correo electrónico válida.</div>';
    exit();
} elseif(!isEmail($email)) {
    echo '<div class="error_message">¡Atención! Has ingresado una dirección de correo electrónico inválida, por favor inténtalo de nuevo.</div>';
    exit();
}

// Configure recipient email address.
$address = "example@yourdomain.com";

// Email subject.
$e_subject = 'Has sido contactado por ' . $form_name . '.';

// Email body.
$e_body = "Has sido contactado por $form_name para hacer una reserva." . PHP_EOL . PHP_EOL;
$e_content = "Detalles de la reserva:" . PHP_EOL;
$e_content .= "Número de personas: $no_of_persons" . PHP_EOL;
$e_content .= "Comida preferida: $preferred_food" . PHP_EOL;
$e_content .= "Ocasión: $occasion" . PHP_EOL . PHP_EOL;
$e_content .= "Puedes contactar a $form_name a través de su correo electrónico: $email o por teléfono: $phone" . PHP_EOL;

$msg = wordwrap($e_body . $e_content, 70);

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

if(mail($address, $e_subject, $msg, $headers)) {

    // Email has been sent successfully.
    echo "<fieldset>";
    echo "<div id='success_page'>";
    echo "<h1>Correo enviado exitosamente.</h1>";
    echo "<p>Gracias <strong>$form_name</strong>, tu mensaje ha sido enviado correctamente.</p>";
    echo "</div>";
    echo "</fieldset>";

} else {
    // Error sending email.
    echo '<div class="error_message">¡Error al enviar el correo electrónico! Por favor inténtalo de nuevo más tarde.</div>';
}
?>