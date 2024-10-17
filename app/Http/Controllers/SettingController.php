<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Models\User;
use App\Services\Setting\SettingService;

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
        $this->authorize('edit_setting', User::class);

        $model = $this->settingService->get($settingad);

        return $this->responseDataSuccess(['model' => $model, 'properties' => $this->properties()]);
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
