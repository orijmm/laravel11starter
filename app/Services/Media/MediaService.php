<?php

namespace App\Services\Media;

use App\Models\User;
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
    public function replaceMany(array $files, HasMedia $model, string $collection): void
    {
        // Obtener las URLs actuales del modelo
        $existingMediaUrls = $model->getMedia($collection)->pluck('file_name')->toArray();

        // Filtrar las imágenes que vienen como texto (URLs) y ya existen
        $preservedMedia = array_filter($files, function ($file) use ($existingMediaUrls) {
            return is_string($file) && in_array(basename($file), $existingMediaUrls);
        });

        // Eliminar las imágenes que no están en el array de preservación
        $model->getMedia($collection)->each(function ($media) use ($preservedMedia) {
            if (!in_array($media->getFullUrl(), $preservedMedia)) {
                $media->delete();
            }
        });

        // Agregar las nuevas imágenes que vienen como `UploadedFile`
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $this->store($file, $model, $collection);
            }
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
