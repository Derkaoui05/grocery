<?php

class Image {
    private static $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    private static $maxFileSize = 5242880; // 5MB
    private static $uploadPath = __DIR__ . '/../public/images/products/originals/';
    private static $thumbnailPath = __DIR__ . '/../public/images/products/thumbnails/';

    public static function upload($file, $productId, $productName) {
        // Validate file
        if (!self::validateFile($file)) {
            return false;
        }

        // Create directories if they don't exist
        if (!file_exists(self::$uploadPath)) {
            mkdir(self::$uploadPath, 0777, true);
        }
        if (!file_exists(self::$thumbnailPath)) {
            mkdir(self::$thumbnailPath, 0777, true);
        }

        // Generate filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $productId . '-' . strtolower(str_replace(' ', '-', $productName)) . '.' . $extension;
        
        // Move uploaded file
        $targetPath = self::$uploadPath . $filename;
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return false;
        }

        // Create thumbnail
        self::createThumbnail($targetPath, $filename);

        return $filename;
    }

    private static function validateFile($file) {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return false;
        }

        // Check file type
        if (!in_array($file['type'], self::$allowedTypes)) {
            return false;
        }

        // Check file size
        if ($file['size'] > self::$maxFileSize) {
            return false;
        }

        return true;
    }

    private static function createThumbnail($sourcePath, $filename) {
        // Get image dimensions
        list($width, $height) = getimagesize($sourcePath);
        
        // Calculate thumbnail dimensions
        $thumbWidth = 200;
        $thumbHeight = floor($height * ($thumbWidth / $width));

        // Create new image
        $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);

        // Load source image
        $source = imagecreatefromstring(file_get_contents($sourcePath));

        // Resize
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

        // Save thumbnail
        $thumbPath = self::$thumbnailPath . $filename;
        imagejpeg($thumb, $thumbPath, 90);

        // Clean up
        imagedestroy($thumb);
        imagedestroy($source);
    }

    public static function getImageUrl($filename) {
        return '/ensa/ecommerce/public/images/products/' . $filename;
    }

    public static function getThumbnailUrl($filename) {
        return '/ensa/ecommerce/public/images/products/thumbnails/' . $filename;
    }

    public static function delete($filename) {
        $imagePath = self::$uploadPath . $filename;
        $thumbPath = self::$thumbnailPath . $filename;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
    }
} 