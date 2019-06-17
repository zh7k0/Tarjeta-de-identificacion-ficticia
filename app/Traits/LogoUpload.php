<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;



trait LogoUpload
{
    /**
     * Up
     * load a file from forms and gives it the specified $filename
     * argument passed
     * @param Illuminate\Http\UploadedFile $uploadedFile
     * @param string $name
     * @param string $folder
     * @return string|false
     */
    public function uploadLogo(UploadedFile $uploadedFile, string $name, string $folder = 'images')
    {
        if ( ! isset($name)){
            return false;
        }
        /**
         * Reemplazamos los espacios por guiones bajos. Ej: nombre_con_espacios
         */
        $filename = Str::snake($name);
        $extension = $uploadedFile->extension();
        $path = $uploadedFile->storeAs($folder, $filename.'.'.$extension, 'public');
        return $path;
    }

    public function deleteLogo(string $filePath, string $disk = 'public' )
    {
        $success = true;
        if ( ! Storage::disk($disk)->exists($filePath)){
            return $success;
        }

        $success = Storage::disk($disk)->delete($filePath);
        return $success;
    }

    /**
     * Mueve el archivo a la nueva ubicación.
     */
    public function renameLogo(string $newName, string $filePath, $extension = 'png', string $disk = 'public')
    {
        $dirname = dirname($filePath).'/';
        $extension = array_last(explode('.', $filePath));
        $newName = $dirname.Str::snake($newName).'.'.$extension;
        
        $wasRenamed = Storage::disk($disk)->move($filePath, $newName);
        if ($wasRenamed){
            return $newName;
        }
        return false;
    }
}
