<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * The service instance
     */
    private SettingService $settingService;

    /**
     * Constructor
     */
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('list', Setting::class);

        return $this->settingService->index($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettingRequest $request)
    {
        $this->authorize('setting-create', Setting::class);

        $input = $request->validated();
        $record = $this->settingService->create($input);
        if (! is_null($record)) {
            return $this->responseStoreSuccess(['record' => $record]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     *  Show the form for editing the specified resource.
     *
     *
     * @return SettingResource|JsonResponse
     *
     * @throws AuthorizationException
     */
    public function show(Setting $settingad)
    {
        $this->authorize('setting-view', Setting::class);

        $model = $this->settingService->get($settingad);

        return $this->responseDataSuccess(['model' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $settingad)
    {
        $this->authorize('edit', Setting::class);

        $data = $request->validated();
        if ($this->settingService->update($settingad, $data)) {
            return $this->responseUpdateSuccess(['record' => $settingad->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $settingad)
    {
        $this->authorize('delete', Setting::class);

        if ($this->settingService->delete($settingad)) {
            return $this->responseDeleteSuccess(['record' => $settingad]);
        }

        return $this->responseDeleteFail();
    }

    /**
     * Render properties
     *
     * @return array
     */
    public function properties()
    {
        return [];
    }
}
