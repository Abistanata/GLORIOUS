<?php
declare(strict_types=1);

/**
 * Brand asset processor (GD only).
 *
 * - Trims transparent padding on public/images/Logo2.png (no resampling).
 * - Extracts the orange star shape from public/images/logotab.png (removes black "G"),
 *   centers it in a square 512x512 canvas, boosts clarity, and exports:
 *     - public/images/logotab.png (512x512)
 *     - public/favicon.png (32x32)
 *     - public/favicon.ico (multi-size, PNG-compressed)
 */

if (php_sapi_name() !== 'cli') {
    fwrite(STDERR, "Run this script via CLI: php tools/process_brand_assets.php\n");
    exit(1);
}

$root = realpath(__DIR__ . '/..');
if ($root === false) {
    fwrite(STDERR, "Could not resolve project root.\n");
    exit(1);
}

$imagesDir = $root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images';
$logo2Path = $imagesDir . DIRECTORY_SEPARATOR . 'Logo2.png';
$logotabPath = $imagesDir . DIRECTORY_SEPARATOR . 'logotab.png';

function loadPng(string $path): GdImage
{
    if (!is_file($path)) {
        throw new RuntimeException("Missing file: {$path}");
    }
    $im = @imagecreatefrompng($path);
    if (!$im) {
        throw new RuntimeException("Failed to load PNG: {$path}");
    }
    imagealphablending($im, false);
    imagesavealpha($im, true);
    return $im;
}

function savePng(GdImage $im, string $path, int $compression = 6): void
{
    imagesavealpha($im, true);
    imagealphablending($im, false);
    if (!imagepng($im, $path, $compression)) {
        throw new RuntimeException("Failed to save PNG: {$path}");
    }
}

function rgbaAt(GdImage $im, int $x, int $y): array
{
    $rgba = imagecolorat($im, $x, $y);
    $a = ($rgba & 0x7F000000) >> 24; // 0..127
    $r = ($rgba >> 16) & 0xFF;
    $g = ($rgba >> 8) & 0xFF;
    $b = $rgba & 0xFF;
    return [$r, $g, $b, $a];
}

function ensureBackup(string $path, string $backupSuffix): void
{
    $backup = preg_replace('/\.png$/i', $backupSuffix . '.png', $path) ?? ($path . $backupSuffix . '.png');
    if (!is_file($backup)) {
        if (!copy($path, $backup)) {
            throw new RuntimeException("Failed to create backup: {$backup}");
        }
    }
}

/**
 * Find bounding box for pixels matching predicate.
 * Returns [minX, minY, maxX, maxY] inclusive, or null if none.
 */
function findBBox(GdImage $im, callable $matches): ?array
{
    $w = imagesx($im);
    $h = imagesy($im);

    $minX = $w;
    $minY = $h;
    $maxX = -1;
    $maxY = -1;

    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $w; $x++) {
            [$r, $g, $b, $a] = rgbaAt($im, $x, $y);
            if ($matches($r, $g, $b, $a)) {
                if ($x < $minX) $minX = $x;
                if ($y < $minY) $minY = $y;
                if ($x > $maxX) $maxX = $x;
                if ($y > $maxY) $maxY = $y;
            }
        }
    }

    if ($maxX < $minX || $maxY < $minY) {
        return null;
    }

    return [$minX, $minY, $maxX, $maxY];
}

function cropToBBox(GdImage $im, array $bbox): GdImage
{
    [$minX, $minY, $maxX, $maxY] = $bbox;
    $cw = $maxX - $minX + 1;
    $ch = $maxY - $minY + 1;

    $out = imagecreatetruecolor($cw, $ch);
    imagealphablending($out, false);
    imagesavealpha($out, true);
    $transparent = imagecolorallocatealpha($out, 0, 0, 0, 127);
    imagefilledrectangle($out, 0, 0, $cw, $ch, $transparent);

    imagecopy($out, $im, 0, 0, $minX, $minY, $cw, $ch);
    return $out;
}

function trimAlpha(GdImage $im): ?GdImage
{
    $bbox = findBBox($im, fn($r, $g, $b, $a) => $a < 127);
    if ($bbox === null) return null;
    return cropToBBox($im, $bbox);
}

function allocColorAlpha(GdImage $im, int $r, int $g, int $b, int $a): int
{
    static $cache = [];
    $key = imagesx($im) . 'x' . imagesy($im) . "|{$r},{$g},{$b},{$a}";
    if (!isset($cache[$key])) {
        $cache[$key] = imagecolorallocatealpha($im, $r, $g, $b, $a);
    }
    return $cache[$key];
}

function recolorKeepingAlpha(GdImage $im, int $r, int $g, int $b): void
{
    $w = imagesx($im);
    $h = imagesy($im);
    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $w; $x++) {
            [, , , $a] = rgbaAt($im, $x, $y);
            if ($a >= 127) continue;
            imagesetpixel($im, $x, $y, allocColorAlpha($im, $r, $g, $b, $a));
        }
    }
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

function pasteCentered(GdImage $canvas, GdImage $layer): void
{
    $cw = imagesx($canvas);
    $ch = imagesy($canvas);
    $lw = imagesx($layer);
    $lh = imagesy($layer);
    $dx = (int)floor(($cw - $lw) / 2);
    $dy = (int)floor(($ch - $lh) / 2);
    imagecopy($canvas, $layer, $dx, $dy, 0, 0, $lw, $lh);
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

/**
 * Write an .ico with PNG-compressed images (modern ICO).
 * $images: array of [size => pngBytes] where size <= 256.
 */
function writeIco(array $images, string $outPath): void
{
    ksort($images);
    $count = count($images);
    if ($count < 1) {
        throw new RuntimeException("No images provided for ICO.");
    }

    $header = pack('vvv', 0, 1, $count); // reserved, type, count
    $dirEntries = '';
    $data = '';

    $offset = 6 + (16 * $count);
    foreach ($images as $size => $bytes) {
        $w = $size === 256 ? 0 : $size;
        $h = $size === 256 ? 0 : $size;
        $bytesLen = strlen($bytes);

        // width, height, colorCount, reserved, planes, bitCount, bytesInRes, imageOffset
        $dirEntries .= pack('CCCCvvVV', $w, $h, 0, 0, 1, 32, $bytesLen, $offset);
        $data .= $bytes;
        $offset += $bytesLen;
    }

    $ico = $header . $dirEntries . $data;
    if (file_put_contents($outPath, $ico) === false) {
        throw new RuntimeException("Failed to write ICO: {$outPath}");
    }
}

function isStarPixel(int $r, int $g, int $b, int $a): bool
{
    if ($a >= 127) return false;
    $brightness = ($r + $g + $b) / 3.0;
    if ($brightness < 45) return false; // exclude black "G"

    // Orange-ish heuristic (works for the current asset): red dominant, green medium, blue low.
    if ($r < 140) return false;
    if ($g < 70) return false;
    if ($b > 170) return false;
    if ($r < $g) return false;
    return true;
}

function isWarmBrandPixel(int $r, int $g, int $b, int $a): bool
{
    if ($a >= 127) return false;
    // Warm yellows/oranges (star region in Logo2.png)
    if ($r < 170 || $g < 90) return false;
    if ($b > 130) return false;
    if (($r - $b) < 70) return false;
    if (($g - $b) < 35) return false;
    return true;
}

function buildStarFromLogo2(string $logo2Path): GdImage
{
    $logo = loadPng($logo2Path);
    $w = imagesx($logo);
    $h = imagesy($logo);
    $searchLimitX = (int)floor($w * 0.55); // ignore right-side text

    // Connected-components over warm pixels; pick the largest component (the star).
    $warm = array_fill(0, $w * $h, false);
    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $searchLimitX; $x++) {
            [$r, $g, $b, $a] = rgbaAt($logo, $x, $y);
            if (isWarmBrandPixel($r, $g, $b, $a)) {
                $warm[$y * $w + $x] = true;
            }
        }
    }

    $visited = array_fill(0, $w * $h, false);
    $q = new SplQueue();
    $best = null;
    $bestSize = 0;

    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $searchLimitX; $x++) {
            $startIdx = $y * $w + $x;
            if (!$warm[$startIdx] || $visited[$startIdx]) continue;

            $minX = $x; $maxX = $x; $minY = $y; $maxY = $y; $size = 0;
            $visited[$startIdx] = true;
            $q->enqueue([$x, $y]);

            while (!$q->isEmpty()) {
                [$cx, $cy] = $q->dequeue();
                $size++;
                if ($cx < $minX) $minX = $cx;
                if ($cx > $maxX) $maxX = $cx;
                if ($cy < $minY) $minY = $cy;
                if ($cy > $maxY) $maxY = $cy;

                $neighbors = [
                    [$cx - 1, $cy],
                    [$cx + 1, $cy],
                    [$cx, $cy - 1],
                    [$cx, $cy + 1],
                ];
                foreach ($neighbors as [$nx, $ny]) {
                    if ($nx < 0 || $ny < 0 || $nx >= $searchLimitX || $ny >= $h) continue;
                    $nIdx = $ny * $w + $nx;
                    if ($visited[$nIdx] || !$warm[$nIdx]) continue;
                    $visited[$nIdx] = true;
                    $q->enqueue([$nx, $ny]);
                }
            }

            if ($size > $bestSize) {
                $bestSize = $size;
                $best = [$minX, $minY, $maxX, $maxY];
            }
        }
    }

    if ($best === null) {
        imagedestroy($logo);
        throw new RuntimeException("Could not detect star component in Logo2.png");
    }

    // Pad slightly to keep antialias edges.
    $pad = 3;
    [$minX, $minY, $maxX, $maxY] = $best;
    $minX = max(0, $minX - $pad);
    $minY = max(0, $minY - $pad);
    $maxX = min($w - 1, $maxX + $pad);
    $maxY = min($h - 1, $maxY + $pad);

    $cropped = cropToBBox($logo, [$minX, $minY, $maxX, $maxY]);
    imagedestroy($logo);

    $cw = imagesx($cropped);
    $ch = imagesy($cropped);
    $out = imagecreatetruecolor($cw, $ch);
    imagealphablending($out, false);
    imagesavealpha($out, true);
    $transparent = imagecolorallocatealpha($out, 0, 0, 0, 127);
    imagefilledrectangle($out, 0, 0, $cw, $ch, $transparent);

    $br = 0xFF; $bg = 0x6B; $bb = 0x00;
    for ($y = 0; $y < $ch; $y++) {
        for ($x = 0; $x < $cw; $x++) {
            [, , , $a] = rgbaAt($cropped, $x, $y);
            if ($a >= 127) continue;
            imagesetpixel($out, $x, $y, allocColorAlpha($out, $br, $bg, $bb, $a));
        }
    }

    imagedestroy($cropped);
    return $out;
}

function buildStarSilhouette(GdImage $src): GdImage
{
    $bbox = findBBox($src, fn($r, $g, $b, $a) => isStarPixel($r, $g, $b, $a));
    if ($bbox === null) {
        // fallback: any non-transparent
        $bbox = findBBox($src, fn($r, $g, $b, $a) => $a < 127);
        if ($bbox === null) {
            throw new RuntimeException("No visible pixels found in logotab image.");
        }
    }

    // Add a tiny padding so antialiased edges aren't clipped.
    $pad = 2;
    $sw = imagesx($src);
    $sh = imagesy($src);
    $bbox[0] = max(0, $bbox[0] - $pad);
    $bbox[1] = max(0, $bbox[1] - $pad);
    $bbox[2] = min($sw - 1, $bbox[2] + $pad);
    $bbox[3] = min($sh - 1, $bbox[3] + $pad);

    $cropped = cropToBBox($src, $bbox);
    $w = imagesx($cropped);
    $h = imagesy($cropped);

    $out = imagecreatetruecolor($w, $h);
    imagealphablending($out, false);
    imagesavealpha($out, true);
    $transparent = imagecolorallocatealpha($out, 0, 0, 0, 127);
    imagefilledrectangle($out, 0, 0, $w, $h, $transparent);

    // Brand orange
    $br = 0xFF; $bg = 0x6B; $bb = 0x00;

    // Build an orange mask (star), then "close" it (dilate then erode) to remove
    // the overlaid letter while restoring a clean star silhouette.
    $orange = array_fill(0, $w * $h, false);
    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $w; $x++) {
            [$r, $g, $b, $a] = rgbaAt($cropped, $x, $y);
            if (isStarPixel($r, $g, $b, $a)) {
                $orange[$y * $w + $x] = true;
            }
        }
    }

    $radius = 18;
    $dilate = static function (array $mask) use ($w, $h, $radius): array {
        $outMask = $mask;
        for ($y = 0; $y < $h; $y++) {
            for ($x = 0; $x < $w; $x++) {
                if (!$mask[$y * $w + $x]) continue;
                for ($dy = -$radius; $dy <= $radius; $dy++) {
                    $ny = $y + $dy;
                    if ($ny < 0 || $ny >= $h) continue;
                    $span = $radius - abs($dy);
                    for ($dx = -$span; $dx <= $span; $dx++) {
                        $nx = $x + $dx;
                        if ($nx < 0 || $nx >= $w) continue;
                        $outMask[$ny * $w + $nx] = true;
                    }
                }
            }
        }
        return $outMask;
    };

    $erode = static function (array $mask) use ($w, $h, $radius): array {
        $outMask = $mask;
        for ($y = 0; $y < $h; $y++) {
            for ($x = 0; $x < $w; $x++) {
                $idx = $y * $w + $x;
                if (!$mask[$idx]) { $outMask[$idx] = false; continue; }
                for ($dy = -$radius; $dy <= $radius; $dy++) {
                    $ny = $y + $dy;
                    if ($ny < 0 || $ny >= $h) { $outMask[$idx] = false; break; }
                    $span = $radius - abs($dy);
                    for ($dx = -$span; $dx <= $span; $dx++) {
                        $nx = $x + $dx;
                        if ($nx < 0 || $nx >= $w) { $outMask[$idx] = false; break 2; }
                        if (!$mask[$ny * $w + $nx]) { $outMask[$idx] = false; break 2; }
                    }
                }
            }
        }
        return $outMask;
    };

    $closed = $erode($dilate($orange));

    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $w; $x++) {
            $idx = $y * $w + $x;
            if (!$closed[$idx]) continue;
            [, , , $a] = rgbaAt($cropped, $x, $y);
            $a = ($a < 127) ? $a : 0; // keep antialias where available, fill occluded parts solid
            imagesetpixel($out, $x, $y, allocColorAlpha($out, $br, $bg, $bb, $a));
        }
    }

    imagedestroy($cropped);

    // Fill interior transparent "holes" (e.g. the inner areas of the old letter overlay)
    // while keeping the outside transparency intact.
    $isTransparent = static function (int $x, int $y) use ($out): bool {
        [, , , $a] = rgbaAt($out, $x, $y);
        return $a >= 127;
    };

    $visited = array_fill(0, $w * $h, false);
    $q = new SplQueue();

    $enqueue = static function (int $x, int $y) use (&$visited, $w, $q): void {
        $idx = $y * $w + $x;
        if ($visited[$idx]) return;
        $visited[$idx] = true;
        $q->enqueue([$x, $y]);
    };

    // Seed: all border transparent pixels (background).
    for ($x = 0; $x < $w; $x++) {
        if ($isTransparent($x, 0)) $enqueue($x, 0);
        if ($isTransparent($x, $h - 1)) $enqueue($x, $h - 1);
    }
    for ($y = 0; $y < $h; $y++) {
        if ($isTransparent(0, $y)) $enqueue(0, $y);
        if ($isTransparent($w - 1, $y)) $enqueue($w - 1, $y);
    }

    // Flood fill background over transparent pixels connected to border.
    while (!$q->isEmpty()) {
        [$x, $y] = $q->dequeue();
        $n = [
            [$x - 1, $y],
            [$x + 1, $y],
            [$x, $y - 1],
            [$x, $y + 1],
        ];
        foreach ($n as [$nx, $ny]) {
            if ($nx < 0 || $ny < 0 || $nx >= $w || $ny >= $h) continue;
            if (!$isTransparent($nx, $ny)) continue;
            $enqueue($nx, $ny);
        }
    }

    // Any remaining transparent pixels are holes -> fill with solid brand orange.
    $solidOrange = allocColorAlpha($out, $br, $bg, $bb, 0);
    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $w; $x++) {
            if (!$isTransparent($x, $y)) continue;
            $idx = $y * $w + $x;
            if ($visited[$idx]) continue; // background
            imagesetpixel($out, $x, $y, $solidOrange);
        }
    }

    return $out;
}

try {
    // 1) Trim Logo2.png transparent padding (no resampling).
    if (is_file($logo2Path)) {
        ensureBackup($logo2Path, '.source');
        $logo2 = loadPng($logo2Path);
        $trimmed = trimAlpha($logo2);
        if ($trimmed) {
            savePng($trimmed, $logo2Path, 6);
            imagedestroy($trimmed);
        }
        imagedestroy($logo2);
        fwrite(STDOUT, "OK: Cropped Logo2.png tightly.\n");
    } else {
        fwrite(STDERR, "WARN: {$logo2Path} not found, skipping.\n");
    }

    // 2) Extract star icon (from Logo2 star), export 512 + favicon.
    if (!is_file($logotabPath)) {
        throw new RuntimeException("Missing file: {$logotabPath}");
    }

    ensureBackup($logotabPath, '.source');
    $star = buildStarFromLogo2($logo2Path);

    // Make a bold outline layer behind (slightly larger + darker).
    $outline = resizeToFit($star, (int)round(imagesx($star) * 1.10), (int)round(imagesy($star) * 1.10));
    recolorKeepingAlpha($outline, 0xB6, 0x45, 0x00);

    // Scale into 512 canvas.
    $canvas = imagecreatetruecolor(512, 512);
    imagealphablending($canvas, false);
    imagesavealpha($canvas, true);
    $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
    imagefilledrectangle($canvas, 0, 0, 512, 512, $transparent);

    $maxInner = 420; // ~82% of canvas for small-size readability
    $outlineScaled = resizeToFit($outline, $maxInner, $maxInner);
    $starScaled = resizeToFit($star, $maxInner, $maxInner);

    pasteCentered($canvas, $outlineScaled);
    pasteCentered($canvas, $starScaled);
    sharpen($canvas);

    // Overwrite logotab.png as the final 512x512 extracted icon.
    savePng($canvas, $logotabPath, 6);

    // favicon.png (32x32)
    $faviconPng = $root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'favicon.png';
    $fav32 = resizeToFit($canvas, 32, 32);
    sharpen($fav32);
    savePng($fav32, $faviconPng, 9);

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

    imagedestroy($outlineScaled);
    imagedestroy($starScaled);
    imagedestroy($outline);
    imagedestroy($star);
    imagedestroy($canvas);
    imagedestroy($fav32);

    fwrite(STDOUT, "OK: Exported logotab.png (512x512), favicon.png, favicon.ico.\n");
    exit(0);
} catch (Throwable $e) {
    fwrite(STDERR, "ERROR: " . $e->getMessage() . "\n");
    exit(1);
}

