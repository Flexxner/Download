<?php
$ordner = 'downloads'; // Ordner mit den Dateien
$zipDatei = 'alle_dateien.zip';

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

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipDatei . '"');
header('Content-Length: ' . filesize($zipDatei));
readfile($zipDatei);

// ZIP-Datei nach Download löschen
unlink($zipDatei);
?>
