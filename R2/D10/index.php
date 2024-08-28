<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_GET["file"])) {
    $file = $_GET["file"];
    $top = (int)$_GET["top"];
    $left = (int)$_GET["left"];
    $width = (int)$_GET["width"];
    $height = (int)$_GET["height"];

    // Debugging: Print the file path
    echo "Trying to access file: $file<br>";

    // Check if the file exists
    if (!file_exists($file)) {
        echo "Error: File does not exist.<br>";
        echo "Full file path: " . realpath($file) . "<br>";
        exit();
    }

    // Rest of your code to process the image...
    $fileInfo = pathinfo($file);
    $extension = strtolower($fileInfo['extension']);
    $img = null;

    switch($extension) {
        case 'jpeg':
        case 'jpg':
            $img = imagecreatefromjpeg($file);
            break;
        case 'png':
            $img = imagecreatefrompng($file);
            break;
        case 'webp':
            $img = imagecreatefromwebp($file);
            break;
        default:
            echo "Unsupported file format!";
            exit();
    }

    if ($img === false) {
        echo "Error: Failed to create an image resource from the file.";
        exit();
    }

    $cropImage = imagecreatetruecolor($width, $height);
    imagecopyresampled($cropImage, $img, 0, 0, $left, $top, $width, $height, imagesx($img), imagesy($img));

    $cropImagePath = 'crop_image' . "." . $extension;
    switch($extension) {
        case 'jpeg':
        case 'jpg':
            imagejpeg($cropImage, $cropImagePath);
            break;
        case 'png':
            imagepng($cropImage, $cropImagePath);
            break;
        case 'webp':
            imagewebp($cropImage, $cropImagePath);
            break;
    }

    imagedestroy($cropImage);
    imagedestroy($img);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        #img-crop, img {
            display: block;
            width: 500px;
            height: auto;
            object-fit: contain;
        }
        #img-wrapper {
            position: relative;
            width: fit-content;
        }
        #rect {
            display: none;
            position: absolute;
            width: 100px;
            height: 100px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 2px solid black;
            background-color: rgba(216, 216, 216, 0.26);
            resize: both;
            overflow: auto;
        }
        #rect::after {
            position: absolute;
            content: "";
            bottom: 0;
            right: 0;
            width: 10px;
            height: 10px;
            background-color: #6f6f6f;
            border: 2px solid black;
        }
        .hide {
            display: none;
        }
    </style>
</head>
<body>
<form action="#" id="form-image" enctype="multipart/form-data">
    <div>
        <input type="file" name="file" id="file" required>
    </div>
    <button type="button" id="btn-submit">Submit</button>

    <div id="img-wrapper">
        <div id="rect"></div>
        <img id="img-crop" alt="Image to be Cropped">
    </div>

    <div class="hide">
        <input type="number" name="top" id="top" hidden>
        <input type="number" name="left" id="left" hidden>
        <input type="number" name="width" id="width" hidden>
        <input type="number" name="height" id="height" hidden>
        <button type="button" id="btn-crop">Crop</button>
    </div>
</form>
<?php if (isset($cropImagePath)): ?>
    <div>
        <img src="<?= $cropImagePath ?>" alt="Cropped Image">
        <a href="<?= $cropImagePath ?>" download="crop_image.<?= $extension ?>">Download Cropped Image</a>
    </div>
<?php endif; ?>

<script>
    const formImage = document.querySelector('#form-image');
    const topInput = document.querySelector('#top');
    const leftInput = document.querySelector('#left');
    const widthInput = document.querySelector('#width');
    const heightInput = document.querySelector('#height');
    const fileInput = document.querySelector('#file');
    const btnCrop = document.querySelector('#btn-crop');
    const btnSubmit = document.querySelector('#btn-submit');
    const img = document.querySelector('#img-crop');
    const rect = document.querySelector('#rect');

    let imageFile;
    fileInput.addEventListener("change", (e) => {
        imageFile = e.target.files[0];
    });

    btnSubmit.addEventListener("click", (e) => {
        e.preventDefault();
        let fileReader = new FileReader();
        fileReader.onload = (e) => {
            img.src = e.target.result;
            initRect();
        };
        fileReader.readAsDataURL(imageFile);
    });

    btnCrop.addEventListener("click", function () {
        topInput.value = parseFloat(getComputedStyle(rect).top);
        leftInput.value = parseFloat(getComputedStyle(rect).left);
        widthInput.value = parseFloat(getComputedStyle(rect).width);
        heightInput.value = parseFloat(getComputedStyle(rect).height);

        formImage.submit();
    });

    function initRect() {
        rect.style.display = "block";
        formImage.querySelector("div.hide").classList.remove("hide");
    }

    let startX, startY, initialLeft, initialTop;
    rect.addEventListener("pointerdown", (e) => {
        if (e.offsetX >= parseFloat(getComputedStyle(rect, '::after').left) && e.offsetY >= parseFloat(getComputedStyle(rect, '::after').top)) {
            return;
        }
        e.preventDefault();
        startX = e.clientX;
        startY = e.clientY;
        initialLeft = parseFloat(getComputedStyle(e.target).left);
        initialTop = parseFloat(getComputedStyle(e.target).top);

        e.target.setPointerCapture(e.pointerId);
        moveRect(e);

        e.target.addEventListener("pointermove", moveRect);
        e.target.addEventListener("pointerup", (e) => {
            e.target.releasePointerCapture(e.pointerId);
            e.target.removeEventListener("pointermove", moveRect);
        });
    });

    function moveRect(e) {
        let dx = e.clientX - startX;
        let dy = e.clientY - startY;
        e.target.style.left = `${initialLeft + dx}px`;
        e.target.style.top = `${initialTop + dy}px`;
    }
</script>
</body>
</html>
