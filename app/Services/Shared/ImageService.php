<?php

namespace App\Services\Shared;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Upload an image and return its stored path.
     */
    public function uploadImage(UploadedFile $image, string $folder): string
    {
        return $image->store($folder, 'public');
    }

    /**
     * Delete an image from the public disk.
     * Accepts either a raw storage path or a URL containing 'storage/'.
     */
    public function deleteImage(string $imageUrl): bool
    {
        $imagePath = str_replace('storage/', '', $imageUrl);

        return Storage::disk('public')->delete($imagePath);
    }
}
