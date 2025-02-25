<?php
$ordner = 'downloads'; // Der Ordner mit den Bildern
$zipDatei = 'bilder.zip';

$zip = new ZipArchive;

if ($zip->open($zipDatei, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    if (isset($_GET['images'])) {
        $bilder = explode(',', $_GET['images']);
        if ($bilder[0] === 'all') {
            // Alle Bilder hinzufügen
            $dateien = scandir($ordner);
            foreach ($dateien as $datei) {
                if ($datei != "." && $datei != "..") {
                    $zip->addFile($ordner . '/' . $datei, $datei);
                }
            }
        } else {
            // Ausgewählte Bilder hinzufügen
            foreach ($bilder as $bild) {
                $zip->addFile($bild);
            }
        }
    }
    $zip->close();
}

// ZIP-Datei zum Download anbieten
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipDatei . '"');
header('Content-Length: ' . filesize($zipDatei));
readfile($zipDatei);

// ZIP-Datei nach Download löschen
unlink($zipDatei);
?>
