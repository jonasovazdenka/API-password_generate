<?php
    // získání vstupních parametrů z requestu
    $format = $_GET['format'];
    $length = $_GET['length'];


    // kontrola, zda byl zadán formát výstupu
    if (!$format) {
        $format = "json";
    }

    // kontrola, zda byla zadána délka hesla
    if (!$length) {
        $length = 12;
    }

    // generování hesla
    $password = generateRandomPassword($length);

    // sestavení odpovědi
    switch ($format) {
        case "json":
            header('Content-Type: application/json');
            echo json_encode(array('password' => $password));
            break;
        case "csv":
            header('Content-Type: text/csv');
            echo $password . ",\n";
            break;
        case "xml":
            header('Content-Type: application/xml');
            $xml = new SimpleXMLElement('<root/>');
            $xml->addChild('password', $password);
            echo $xml->asXML();
            break;
        default:
            echo "Invalid format specified";
            http_response_code(400);
    }

// funkce pro generování náhodného hesla
function generateRandomPassword($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr(str_shuffle($chars), 0, $length);
    return $password;
}