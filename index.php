<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilder Galerie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        .gallery img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .gallery img:hover {
            transform: scale(1.05);
            border-color: #007BFF;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Bilder Galerie</h2>
    <div class="gallery" id="gallery">
        <?php
            $ordner = 'downloads'; // Pfad zum Ordner mit den Bildern
            $bilder = glob($ordner . '/*.jpg'); // Alle .jpg-Dateien im Ordner abrufen
            
            foreach ($bilder as $bild) {
                echo '<img src="' . $bild . '" alt="' . basename($bild) . '" onclick="toggleSelection(this)" data-selected="false">';
            }
        ?>
    </div>
    <div class="button-container">
        <button onclick="downloadSelected()">Ausgewählte Bilder herunterladen</button>
        <button onclick="downloadAll()">Alle Bilder herunterladen</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>
        function toggleSelection(img) {
            const isSelected = img.dataset.selected === 'true';
            img.dataset.selected = !isSelected;
            img.style.border = isSelected ? '2px solid #ccc' : '2px solid #007BFF';
        }

        function downloadSelected() {
            const selectedImages = [...document.querySelectorAll('.gallery img[data-selected="true"]')].map(img => img.src);
            if (selectedImages.length > 0) {
                createZip(selectedImages, 'selected_images.zip');
            } else {
                alert('Bitte wählen Sie mindestens ein Bild aus!');
            }
        }

        function downloadAll() {
            const allImages = [...document.querySelectorAll('.gallery img')].map(img => img.src);
            createZip(allImages, 'all_images.zip');
        }

        function createZip(images, zipFileName) {
            const zip = new JSZip();
            const imgPromises = images.map(src => fetch(src).then(res => res.blob()).then(blob => {
                const fileName = src.split('/').pop();
                zip.file(fileName, blob);
            }));

            Promise.all(imgPromises).then(() => {
                zip.generateAsync({ type: 'blob' }).then(content => {
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(content);
                    link.download = zipFileName;
                    link.click();
                });
            });
        }
    </script>
</body>
</html>
