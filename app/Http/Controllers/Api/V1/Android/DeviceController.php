<?php

namespace App\Http\Controllers\Api\V1\Android;

use App\DataAccess\Eloquent\AndroidDevice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function store(Request $request)
    {
        $device = AndroidDevice::create([
            'registration_id' => $request->registrationId
        ]);

        return response()->json([
            'id' => $device->id,
            'registrationId' => $device->registration_id,
        ], 201);
    }
}
