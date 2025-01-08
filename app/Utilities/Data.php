<?php

namespace App\Utilities;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Nnjeim\World\World;

class Data
{
    /**
     * Formats collection ROLE for select field
     *
     * @return Collection
     */
    public static function formatRoleCollectionForSelect(Collection $collection, $value = 'id', $label = 'trans')
    {
        return $collection->map(function ($entry) use ($value, $label) {
            $id = $entry->$value ?? null;
            $label = $label === 'trans' ? trans('frontend.users.roles.' . $id) : ($entry->$label ?? $entry->$id);

            return [
                'id' => $id,
                'name' => $label,
            ];
        });
    }

    /**
     * Formats any for select field
     *
     * @return Collection
     */
    public static function formatCollectionForSelect(Collection $collection, $value = 'id', $label = 'name', $extra = null)
    {
        $result = $collection->map(function ($entry) use ($value, $label, $extra) {
            $id = $entry[$value] ?? null;
            $label = $entry[$label] ?? $entry[$id];

            $data = [
                'id' => $id,
                'name' => $label,
            ];
            if ($extra) {
                $data[$extra] = $entry[$extra] ?? null;
            }
            return $data;
        });

        return $result;
    }

    /**
     * Formats any for select field. Para los seleccionados. Solo uno
     *
     * @return Collection
     */
    public static function formatCollectionForSelected(Collection $collection, $value = 'id', $label = 'name')
    {
        $result = $collection->map(function ($entry) use ($value, $label) {
            $id = $entry[$value] ?? null;
            $label = $entry[$label] ?? $entry[$id];

            return [
                'id' => $id,
                'name' => $label,
            ];
        });

        return $result->first();
    }

    /**
     * Take value form array
     *
     * @return mixed|null
     */
    public static function take(&$arr, $key)
    {
        if (isset($arr[$key])) {
            $value = $arr[$key];
            unset($arr[$key]);

            return $value;
        }

        return null;
    }

    public static function getSelectedLocation($data, $selected, $typeValue = 'id', $typelabel = 'name')
    {
        $result = [];
        $result = collect($data)->firstWhere($typeValue, $selected);

        if ($typeValue !== 'id') {
            $result = self::formatCollectionForSelected(collect([$result]), $typeValue, $typelabel);
        }
        return $result;
    }

    /*
    * Request: String
    * Response: Object
    */
    public static function getFilenameByFolder($path)
    {
        // Todos los archivos
        $files = File::allFiles($path);
        // Lista con los nombres de los archivos, incluyendo sus rutas relativas
        $fileFolderNames = collect($files)->map(function ($file) use ($path) {
            return ['name' => str_replace($path . DIRECTORY_SEPARATOR, '', $file->getRelativePathname())];
        });

        return $fileFolderNames;
    }
}
