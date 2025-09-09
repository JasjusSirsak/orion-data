<?php
header('Content-Type: application/json; charset=utf-8');

// Lokasi file CSV
$csvFile = __DIR__ . '/biznetbekasi.csv';

// Ambil raw input body
$input = file_get_contents("php://input");
$params = json_decode($input, true);

// Kalau ada "limit" di body
$limit = isset($params['limit']) ? intval($params['limit']) : 0;

if (!file_exists($csvFile)) {
    echo json_encode(["error" => "File CSV tidak ditemukan"]);
    exit;
}

if (($handle = fopen($csvFile, "r")) !== false) {
    $headers = fgetcsv($handle);
    $rows = [];
    $count = 0;

    while (($row = fgetcsv($handle)) !== false) {
        $rows[] = array_combine($headers, $row);

        if ($limit > 0 && ++$count >= $limit) break;
    }
    fclose($handle);

    echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "Gagal membuka file CSV"]);
}
