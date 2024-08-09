<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Nnjeim\World\World;

class SettingController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        $world =  World::countries();

        if ($world->success) {

            $countries = $world->data;
        }

        return sendResponse([$countries, $setting], 'Usuario agregado exitosamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //gestionar
    }

}
