<?php
declare(strict_types=1);

/**
 * Update favicon.ico using logotab.source.png
 */

if (php_sapi_name() !== 'cli') {
    fwrite(STDERR, "Run this script via CLI: php tools/update_favicon.php\n");
    exit(1);
}

$root = realpath(__DIR__ . '/..');
if ($root === false) {
    fwrite(STDERR, "Could not resolve project root.\n");
    exit(1);
}

$imagesDir = $root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images';
$logotabSourcePath = $imagesDir . DIRECTORY_SEPARATOR . 'logotab.source.png';

if (!is_file($logotabSourcePath)) {
    fwrite(STDERR, "ERROR: Missing file: {$logotabSourcePath}\n");
    exit(1);
}

function loadPng(string $path): GdImage
{
    $im = @imagecreatefrompng($path);
    if (!$im) {
        throw new RuntimeException("Failed to load PNG: {$path}");
    }
    imagealphablending($im, false);
    imagesavealpha($im, true);
    return $im;
}

function resizeToFit(GdImage $src, int $maxW, int $maxH): GdImage
{
    $sw = imagesx($src);
    $sh = imagesy($src);
    $scale = min($maxW / $sw, $maxH / $sh);
    $tw = max(1, (int)round($sw * $scale));
    $th = max(1, (int)round($sh * $scale));

    $dst = imagecreatetruecolor($tw, $th);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
    imagefilledrectangle($dst, 0, 0, $tw, $th, $transparent);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $tw, $th, $sw, $sh);
    return $dst;
}

function sharpen(GdImage $im): void
{
    $kernel = [
        [0, -1, 0],
        [-1, 5, -1],
        [0, -1, 0],
    ];
    imageconvolution($im, $kernel, 1, 0);
}

function pngBytes(GdImage $im, int $compression = 6): string
{
    ob_start();
    imagepng($im, null, $compression);
    return (string)ob_get_clean();
}

function writeIco(array $images, string $outPath): void
{
    ksort($images);
    $count = count($images);
    if ($count < 1) {
        throw new RuntimeException("No images provided for ICO.");
    }

    $header = pack('vvv', 0, 1, $count);
    $dirEntries = '';
    $data = '';

    $offset = 6 + (16 * $count);
    foreach ($images as $size => $bytes) {
        $w = $size === 256 ? 0 : $size;
        $h = $size === 256 ? 0 : $size;
        $bytesLen = strlen($bytes);

        $dirEntries .= pack('CCCCvvVV', $w, $h, 0, 0, 1, 32, $bytesLen, $offset);
        $data .= $bytes;
        $offset += $bytesLen;
    }

    $ico = $header . $dirEntries . $data;
    if (file_put_contents($outPath, $ico) === false) {
        throw new RuntimeException("Failed to write ICO: {$outPath}");
    }
}

try {
    // Load logotab.source.png
    $source = loadPng($logotabSourcePath);
    
    // Create 512x512 canvas for scaling
    $canvas = imagecreatetruecolor(512, 512);
    imagealphablending($canvas, false);
    imagesavealpha($canvas, true);
    $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
    imagefilledrectangle($canvas, 0, 0, 512, 512, $transparent);
    
    // Resize source to fit 512x512
    $resized = resizeToFit($source, 512, 512);
    $sw = imagesx($resized);
    $sh = imagesy($resized);
    $dx = (int)floor((512 - $sw) / 2);
    $dy = (int)floor((512 - $sh) / 2);
    imagecopy($canvas, $resized, $dx, $dy, 0, 0, $sw, $sh);
    imagedestroy($resized);
    imagedestroy($source);
    
    // favicon.png (32x32)
    $faviconPng = $root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'favicon.png';
    $fav32 = resizeToFit($canvas, 32, 32);
    sharpen($fav32);
    imagepng($fav32, $faviconPng, 9);
    imagedestroy($fav32);
    
    // favicon.ico (multi-size)
    $faviconIco = $root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'favicon.ico';
    $sizes = [16, 32, 48, 64, 128, 256];
    $icoImages = [];
    foreach ($sizes as $s) {
        $im = resizeToFit($canvas, $s, $s);
        sharpen($im);
        $icoImages[$s] = pngBytes($im, 9);
        imagedestroy($im);
    }
    writeIco($icoImages, $faviconIco);
    
    imagedestroy($canvas);
    
    fwrite(STDOUT, "OK: Updated favicon.png and favicon.ico from logotab.source.png\n");
    exit(0);
} catch (Throwable $e) {
    fwrite(STDERR, "ERROR: " . $e->getMessage() . "\n");
    exit(1);
}
