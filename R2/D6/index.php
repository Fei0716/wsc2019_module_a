<?php

$image = imagecreatefrompng("./image.png");
$width = imagesx($image);
$height = imagesy($image);

$colors = [];

// Loop through each of the pixels and add the color of the pixels to the colors array
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        // Get the color index at this pixel
        $colorIndex = imagecolorat($image, $x, $y);

        // If the color is already in the array, increment its count
        if (isset($colors[$colorIndex])) {
            $colors[$colorIndex]++;
        } else {
            // Otherwise, add it to the array with a count of 1
            $colors[$colorIndex] = 1;
        }
    }
}

// Sort the colors array by count (frequency)
arsort($colors);

// Get the top 3 colors
$topColors = array_slice($colors, 0, 3, true);

// Print the top 3 colors
foreach ($topColors as $colorIndex => $count) {
    $rgb = imagecolorsforindex($image, $colorIndex);
    echo sprintf("Color: #%02x%02x%02x - Count: %d\n", $rgb['red'], $rgb['green'], $rgb['blue'], $count);
}

imagedestroy($image);
?>
