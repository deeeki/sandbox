<?php
if (isset($argv[1])) {
	$src_f = $argv[1];
}
else {
	exit('Usage: php shrink_image.php original.jpg');
}

$tgt_w = 120;//幅
$tgt_h = 160;//高さ

$src = load_image($src_f);
$dst = imagecreate($tgt_w, $tgt_h);
imagefill($dst, 0, 0, imagecolorallocatealpha($dst, 0, 0, 0, 127));//R,G,B,Alpha

shrink_image($src, $dst, $tgt_w, $tgt_h);

header('Content-type: image/gif');
write_image($dst, IMAGETYPE_GIF);

/**
 * 画像を読み込みます。
 */
function load_image($file) {
	$image_info = getimagesize($file);
	$type = $image_info[2];

	if ($type == IMAGETYPE_JPEG) {
		$image = imagecreatefromjpeg($file);
	}
	else if ($type == IMAGETYPE_GIF) {
		$image = imagecreatefromgif($file);
	}
	else if ($type == IMAGETYPE_PNG) {
		$image = imagecreatefrompng($file);
	}
	return $image;
}

/**
 * 画像を書き出します。
 */
function write_image($image, $type = IMAGETYPE_GIF) {
	if ($type == IMAGETYPE_JPEG) {
		Imagejpeg($image);
	}
	else if ($type == IMAGETYPE_GIF) {
		Imagegif($image);
	}
	else if ($type == IMAGETYPE_PNG) {
		Imagepng($image);
	}

	imagedestroy($image);
}

/**
 * 画像を指定サイズに縮小します。
 */
function shrink_image($src, $dst, $tgt_w, $tgt_h) {
	$x = 0;
	$y = 0;

	$src_w = ImageSX($src);
	$src_h = ImageSY($src);

	if ($tgt_w > $src_w || $tgt_h > $src_h) {
		$dst_w = $src_w;
		$dst_h = $src_h;
		$x = ($tgt_w - $src_w) / 2;
		$y = ($tgt_h - $src_h) / 2;
	}
	else if ($src_w / $tgt_w > $src_h / $tgt_h) {
		$dst_w = $tgt_w;
		$dst_h = $src_h * ($dst_w / $src_w);
		$y = ($tgt_h - $dst_h) / 2;
	}
	else {
		$dst_h = $tgt_h;
		$dst_w = $src_w * ($dst_h / $src_h);
		$x = ($tgt_w - $dst_w) / 2;
	}

	ImageCopyResampled($dst, $src, $x, $y, 0, 0, $dst_w ,$dst_h, $src_w, $src_h);

	return $dst;
}
