<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Fence;

class FenceController extends Controller
{
    //
    public function getFenceData(Request $request)
    {
        $this->validate($request, [
            'imei' => 'required'
        ]);
        return Fence::where('imei', $request->imei)->get();
    }

    public function createFenceData(Request $request)
    {
        $this->validate($request, [
            'imei' => 'required',
            'fenceName' => 'required',
            'fenceType' => 'required',
            'location' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Fence::create([
            'imei' => $request->imei,
            'fenceName' => $request->fenceName,
            'fenceType' => $request->fenceType,
            'location' => $request->location,
            'userId' => $userId
        ]);
    }

    public function updateFenceData(Request $request)
    {
    }

    public function deleteFenceData(Request $request)
    {
    }
}
