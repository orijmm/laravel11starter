<?php

namespace App\Http\Controllers;

use App\Services\Media\MediaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MediaGalleryController extends Controller
{
    /**
     * The service instance
     *
     * @var MediaService
     */
    protected $mediaService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaService = new MediaService();
    }

    /**
     * Display a listing of the resource.
     */
    public function iconSvg(Request $request)
    {
        try {
            $basePath = public_path('assets/img/icons');

            $folders = ['solid', 'lineal'];
            $data = [];

            foreach ($folders as $folder) {
                $path = $basePath . '/' . $folder;
                $icons = [];

                if (File::exists($path)) {
                    foreach (File::files($path) as $file) {
                        if ($file->getExtension() === 'svg') {
                            $icons[] = '/assets/img/icons/' . $folder . '/' . $file->getFilename();
                        }
                    }
                }

                $data[$folder] = $icons;
            }

            return response()->json($data);
        } catch (Exception $e) {
            return $this->responseFail($e);
        }
    }
}
