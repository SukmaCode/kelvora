<?php

namespace Core;

/**
 * ImageUploader Utility
 * 
 * Handles secure image uploads, validation, resizing, and cropping.
 */
class ImageUploader
{
    private string $uploadPath;
    private array $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
    private int $maxFileSize = 2 * 1024 * 1024; // 2MB

    public function __construct(string $uploadPath)
    {
        $this->uploadPath = rtrim($uploadPath, '/');
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }

    /**
     * Delete an image from the server.
     */
    public function deleteImage(string $filename): bool
    {
        $filePath = $this->uploadPath . '/' . $filename;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    /**
     * Process, validate and save an uploaded image file with optional crop data.
     */
    public function uploadImage(array $file, ?string $cropDataJson, $prefix = 'profile'): string
    {
        $this->validateFile($file);

        // Generate a new unique file name
        $extension = 'jpg'; // We always save as JPEG to optimize size
        $filename = $prefix . '_' . uniqid() . '_' . time() . '.' . $extension;
        $destination = $this->uploadPath . '/' . $filename;

        // Process Image (crop -> resize -> compress)
        $this->processImage($file['tmp_name'], $destination, $cropDataJson);

        return $filename;
    }

    /**
     * Valiate file type, size and errors
     */
    private function validateFile(array $file): void
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new \Exception('Parameter salah.');
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new \Exception('Tidak ada file yang diupload.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \Exception('Ukuran file terlalu besar (maks 2MB).');
            default:
                throw new \Exception('Terjadi kesalahan saat upload.');
        }

        if ($file['size'] > $this->maxFileSize) {
            throw new \Exception('Ukuran file melebihi batas (maks 2MB).');
        }

        // Check accurate MIME type
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $ext = $finfo->file($file['tmp_name']);
        
        if (!in_array($ext, $this->allowedMimeTypes, true)) {
            throw new \Exception('Format file tidak didukung. Gunakan JPG, PNG, atau WebP.');
        }
    }

    /**
     * Create image resource from MIME
     */
    private function createImageResource(string $sourcePath, string $mimeType)
    {
        switch ($mimeType) {
            case 'image/jpeg':
                return imagecreatefromjpeg($sourcePath);
            case 'image/png':
                return imagecreatefrompng($sourcePath);
            case 'image/webp':
                return imagecreatefromwebp($sourcePath);
            default:
                throw new \Exception('Format gambar tidak dikenali.');
        }
    }

    /**
     * Process the uploaded image using GD Library
     */
    private function processImage(string $sourcePath, string $destination, ?string $cropDataJson): void
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($sourcePath);
        
        $sourceImage = $this->createImageResource($sourcePath, $mimeType);
        
        if (!$sourceImage) {
            throw new \Exception('Gagal memproses gambar file.');
        }

        // Get original dimensions
        $origWidth = imagesx($sourceImage);
        $origHeight = imagesy($sourceImage);

        // If crop data is provided, apply cropping
        if ($cropDataJson && $cropData = json_decode($cropDataJson, true)) {
            $cropX = (int) round($cropData['x']);
            $cropY = (int) round($cropData['y']);
            $cropWidth = (int) round($cropData['width']);
            $cropHeight = (int) round($cropData['height']);

            // Boundaries check
            $cropX = max(0, $cropX);
            $cropY = max(0, $cropY);
            if (($cropX + $cropWidth) > $origWidth) $cropWidth = $origWidth - $cropX;
            if (($cropY + $cropHeight) > $origHeight) $cropHeight = $origHeight - $cropY;

            $croppedImage = imagecreatetruecolor($cropWidth, $cropHeight);
            
            // Handle transparency for intermediate PNG processing
            imagealphablending($croppedImage, false);
            imagesavealpha($croppedImage, true);
            $transparent = imagecolorallocatealpha($croppedImage, 255, 255, 255, 127);
            imagefilledrectangle($croppedImage, 0, 0, $cropWidth, $cropHeight, $transparent);

            imagecopy($croppedImage, $sourceImage, 0, 0, $cropX, $cropY, $cropWidth, $cropHeight);
            
            imagedestroy($sourceImage);
            $sourceImage = $croppedImage;
            $origWidth = $cropWidth;
            $origHeight = $cropHeight;
        }

        // Target avatar resolution is 400x400 max, but proportionally.
        // Actually, since we cropped 1:1, it will be square. Let's force 400x400 if it's larger.
        $targetDim = 400;
        
        if ($origWidth > $targetDim || $origHeight > $targetDim) {
            $newWidth = $targetDim;
            $newHeight = $targetDim;
        } else {
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        }

        $finalImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Fill pure white background for PNG/WebP transparency converted to JPG
        $white = imagecolorallocate($finalImage, 255, 255, 255);
        imagefill($finalImage, 0, 0, $white);

        imagecopyresampled($finalImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Save as JPEG with 85% compression
        if (!imagejpeg($finalImage, $destination, 85)) {
            imagedestroy($sourceImage);
            imagedestroy($finalImage);
            throw new \Exception('Gagal menyimpan gambar final.');
        }

        imagedestroy($sourceImage);
        imagedestroy($finalImage);
    }
}
