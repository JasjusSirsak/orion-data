<?php
// Nama file CSV
$csvFile = __DIR__ . '/myrepublic.csv';

// Nama output JSON
$jsonFile = __DIR__ . '/myrepublicbekasi.json';

if (!file_exists($csvFile)) {
    echo "File CSV tidak ditemukan.\n";
    exit;
}

$rows = [];
if (($handle = fopen($csvFile, "r")) !== false) {
    $headers = fgetcsv($handle); // ambil header baris pertama
    while (($data = fgetcsv($handle)) !== false) {
        if (count($data) === count($headers)) {
            $rows[] = array_combine($headers, $data);
        }
    }
    fclose($handle);
}

// simpan ke file JSON
file_put_contents(
    $jsonFile,
    json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
);

echo "File JSON berhasil dibuat: $jsonFile\n";