<?php

    $format = $_GET['format'];
    $length = $_GET['length'];

    if (!$format) {
        $format = "json";
    }

    if (!$length) {
        $length = 12;
    }

    $password = generateRandomPassword($length);

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

function generateRandomPassword($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr(str_shuffle($chars), 0, $length);
    return $password;
}
