<?php

namespace App\Services\Media;

use App\Models\User;
use Arr;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
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
            // dd($model,  $collection,  $urlImg, $files);
            if (count($urlImg)) {
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
            } else {
                $this->delete($model, $collection);
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
        try {
            $media = $model->addMedia($file)->toMediaCollection($collection);
            return $media;
        } catch (\Throwable $e) {
            \Log::error('Fallo al guardar media', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // para que también lo veas en el frontend
        }
    }


    /**
     * Handles a file upload to the storage Delete
     */
    public function delete(HasMedia $model, string $collection)
    {
        // Eliminar las imágenes que no están en el array de preservación
        $getMedia = $model->getMedia($collection);

        foreach ($getMedia as $value) {
            $value->delete();
        }
    }
}
