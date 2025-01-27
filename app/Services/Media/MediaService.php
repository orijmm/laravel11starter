<?php

namespace App\Services\Media;

use App\Models\User;
use Arr;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaService
{
    /**
     * Handles a file upload to the storage
     *
     *
     * @return Media
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function replace(UploadedFile $file, HasMedia $model, string $collection): Media
    {
        $media = $model->getMedia($collection);
        foreach ($media as $media_item) {
            $media_item->delete();
        }

        return $this->store($file, $model, $collection);
    }

    /**
     * Handles a file upload to the storage
     * @return Media
     *
     */
    public function replaceMany(HasMedia $model, string $collection, array $urlImg, $files = [])
    {
        try {
            if(count($urlImg)){
                $fileNames = Arr::map($urlImg, function ($img) {
                    return basename($img);
                });
        
                // Obtener los medios no existentes
                $nonExistingMedia = $model->getMedia($collection)->filter(function ($media) use ($fileNames) {
                    return !in_array($media->file_name, $fileNames); // Invertimos la lógica con `!`
                })->pluck('id')->toArray();
                
                // Eliminar las imágenes que no están en el array de preservación
                $getMedia = $model->getMedia($collection);
        
                foreach ($getMedia as $value) {
                    if (in_array($value->id, $nonExistingMedia)) {
                        $value->delete();
                    }
                }
            }
    
            // Agregar las nuevas imágenes que vienen como `UploadedFile`
            foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                    $this->store($file, $model, $collection);
                }
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Handles a file upload to the storage
     *
     *
     * @return Media
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(UploadedFile $file, HasMedia $model, string $collection): Media
    {
        return $model->addMedia($file)->toMediaCollection($collection);
    }
}
