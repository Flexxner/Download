<?php
$ordner = 'downloads'; // Ordner mit den Bildern
$zipDatei = 'bilder.zip';

$zip = new ZipArchive;
if ($zip->open($zipDatei, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    if (isset($_POST['bilder'])) {
        foreach ($_POST['bilder'] as $datei) {
            $zip->addFile($ordner . '/' . $datei, $datei);
        }
    } elseif (isset($_GET['alle'])) {
        $dateien = scandir($ordner);
        foreach ($dateien as $datei) {
            if ($datei != "." && $datei != "..") {
                $zip->addFile($ordner . '/' . $datei, $datei);
            }
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
