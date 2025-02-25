<?php
$ordner = 'downloads'; // Der Ordner mit den Dateien
$zipDatei = 'downloads.zip';

$zip = new ZipArchive;
if ($zip->open($zipDatei, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    $dateien = scandir($ordner);
    foreach ($dateien as $datei) {
        if ($datei != "." && $datei != "..") {
            $zip->addFile($ordner . '/' . $datei, $datei);
        }
    }
    $zip->close();
}

// iPhone-kompatible Header setzen
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipDatei . '"');
header('Content-Length: ' . filesize($zipDatei));
header("Pragma: no-cache");
header("Expires: 0");
readfile($zipDatei);

// ZIP-Datei nach Download löschen
unlink($zipDatei);
?>
