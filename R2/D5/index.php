<?php
// Load the main image
$image = imagecreatefromjpeg("./image.jpg");
if (!$image) {
    die("Failed to load image.jpg");
}

// Load the watermark image
$watermark = imagecreatefrompng("./logo.png");
if (!$watermark) {
    die("Failed to load logo.png");
}

// Get the width and height of both images
$imageWidth = imagesx($image);
$imageHeight = imagesy($image);

$watermarkWidth = imagesx($watermark);
$watermarkHeight = imagesy($watermark);

// Calculate the position where the watermark will be placed
$xPosition = $imageWidth - $watermarkWidth - 10; // 10 pixels from the right edge
$yPosition = $imageHeight - $watermarkHeight - 10; // 10 pixels from the bottom edge

// Copy the watermark onto the main image
imagecopy($image, $watermark, $xPosition, $yPosition, 0, 0, $watermarkWidth / 3, $watermarkHeight / 3);

// Save the image with watermark
if (imagejpeg($image, 'image_with_watermark.jpg')) {
    echo "Image saved successfully as image_with_watermark.jpg";
} else {
    echo "Failed to save image_with_watermark.jpg";
}

// Free up memory
imagedestroy($image);
imagedestroy($watermark);
?>