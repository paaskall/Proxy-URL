<?php
// proxy.php

// URL ICS yang dikirim lewat parameter
$icalUrl = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($icalUrl)) {
    http_response_code(400);
    echo "Error: Parameter 'url' tidak ada.";
    exit;
}

// Ambil data ICS dari Google Calendar
$context = stream_context_create([
    "http" => [
        "header" => "User-Agent: PHP Proxy\r\n"
    ]
]);

$data = @file_get_contents($icalUrl, false, $context);

if ($data === FALSE) {
    http_response_code(500);
    echo "Error: Gagal mengambil data dari $icalUrl";
    exit;
}

// Izinkan diakses dari frontend
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/calendar; charset=UTF-8");

echo $data;
