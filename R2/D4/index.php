<?php
// Create an image
$imageWidth = 150;
$imageHeight = 50;
$image = imagecreatetruecolor($imageWidth, $imageHeight);

// Define colors
$backgroundColor = imagecolorallocate($image, 255, 255, 255); // White background
$textColor = imagecolorallocate($image, 0, 0, 0); // Black text
$lineColor = imagecolorallocate($image, 150, 150, 150); // Light grey lines
$noiseColor = imagecolorallocate($image, 200, 200, 200); // Light grey noise

// Fill the background
imagefill($image, 0, 0, $backgroundColor);

// Load the font
$fontPath = './arial.ttf'; // Path to a TrueType font file. Adjust as needed.

if (!file_exists($fontPath)) {
    die('Font file not found.');
}

// Generate random characters
$characters = array_merge(range('A', 'Z'), range(0, 9));
shuffle($characters);
$code = implode('', array_slice($characters, 0, 4));

// Function to generate random angles
function randomAngle() {
    return rand(-15, 15);
}

// Function to generate random vertical positions
function randomY($height) {
    return rand(20, $height - 30);
}

// Add characters to image
for ($i = 0, $iMax = strlen($code); $i < $iMax; $i++) {
    $char = $code[$i];
    $angle = randomAngle();
    $size = 20;
    $x = 25 + ($i * 30); // Adjust x position to space characters out
    $y = randomY($imageHeight);

    imagettftext($image, $size, $angle, $x, $y, $textColor, $fontPath, $char);
}

// Add random lines
for ($i = 0; $i < 3; $i++) {
    imageline($image, rand(0, $imageWidth), rand(0, $imageHeight), rand(0, $imageWidth), rand(0, $imageHeight), $lineColor);
}

// Add noise points
for ($i = 0; $i < 30; $i++) {
    imagesetpixel($image, rand(0, $imageWidth), rand(0, $imageHeight), $noiseColor);
}

// Output the image
header('Content-Type: image/png');
imagepng($image);

// Free memory
imagedestroy($image);
?>