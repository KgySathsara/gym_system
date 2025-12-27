<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function uploadFile(UploadedFile $file, $folder = 'uploads', $disk = 'public')
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, $disk);

        return $path;
    }

    public function deleteFile($path, $disk = 'public')
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    public function getFileUrl($path, $disk = 'public')
    {
        if (!$path) {
            return null;
        }

        return Storage::disk($disk)->url($path);
    }
}
