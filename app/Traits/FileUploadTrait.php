<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function uploadImage(Request $request, $inputName, $path = "uploads", $oldPath = null)
    {
        if ($request->hasFile($inputName)) {
            try {
                // delete old file if has
                if ($oldPath && Storage::disk('public')->exists($oldPath)&& $oldPath !== 'uploads/avatar-user-default.png') {
                    Storage::disk('public')->delete($oldPath);
                }

                // get file request
                $image = $request->file($inputName);
                $this->validateImage($image);

                $imageName = 'media_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs($path, $imageName, 'public');

                return $imagePath;
            } catch (\Exception $e) {

                return null;
            }
        }
        return null;
    }

    private function validateImage($image)
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxSize = 2048; // Kích thước tối đa (2MB)

        $extension = $image->getClientOriginalExtension();
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception('Invalid file type');
        }

        if ($image->getSize() > $maxSize * 1024) {
            throw new \Exception('File size exceeds maximum limit');
        }
    }

    public function removeImage(string $path)
    {
        if (Storage::disk('public')->exists($path) && $path !== 'uploads/avatar-user-default.png') {
            Storage::disk('public')->delete($path);
        }
    }
}
