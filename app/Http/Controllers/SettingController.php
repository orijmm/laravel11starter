<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateLogoRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Models\User;
use App\Services\Setting\SettingService;
use Exception;

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
     *  Show the form for editing the specified resource.
     *
     *
     * @return SettingResource|JsonResponse
     *
     * @throws AuthorizationException
     */
    public function show(Setting $settingad)
    {
        try {

            $resource = $this->settingService->get($settingad);
            $array = $resource->toArray(request()); // fuerza el error aquí si lo hay
            return response()->json(['model' => $array]);
        } catch (\Throwable $e) {
            \Log::error('Error en settingad.show: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Error interno', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return JsonResponse|\Illuminate\Http\Response
     *
     * @throws AuthorizationException
     */
    public function edit(Setting $settingad)
    {
        $this->authorize('edit_setting', User::class);

        return $this->show($settingad);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $settingad)
    {
        $this->authorize('edit_setting', User::class);

        $data = $request->validated();
        $nullableFields = [
            'address',
            'googlemaps',
            'description',
            'phone',
            'email',
            'instagram',
            'facebook',
            'twitter',
            'tiktok',
        ];

        foreach ($nullableFields as $field) {
            if (!array_key_exists($field, $data) || $data[$field] === '') {
                $data[$field] = null;
            }
        }
        \Log::info($data);
        if ($this->settingService->update($settingad, $data)) {
            return $this->responseUpdateSuccess(['record' => $settingad->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Update logo in for specified user
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function updateLogo(UpdateLogoRequest $request, Setting $setting)
    {
        $this->authorize('edit-profile', User::class);

        $data = $request->validated();
        if ($this->settingService->updateLogo($setting, $data)) {
            return $this->responseUpdateSuccess(['record' => $setting->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $settingad)
    {
        $this->authorize('edit_setting', User::class);

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
