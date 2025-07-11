<?php

function sendResponse($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function sendError($message, $code = 400) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(["error" => $message]);
    exit;
}

function getJsonInput() {
    $input = json_decode(file_get_contents("php://input"), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        sendError("Données JSON invalides", 400);
    }
    return $input;
}

function getQueryParam($key, $default = null) {
    return isset($_GET[$key]) ? $_GET[$key] : $default;
}

function getHeader($name) {
    $headers = getallheaders();
    foreach ($headers as $key => $value) {
        if (strcasecmp($key, $name) === 0) {
            return $value;
        }
    }
    return null;
}