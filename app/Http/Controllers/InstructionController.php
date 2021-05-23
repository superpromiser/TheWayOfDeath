<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instruction;
use Illuminate\Support\Facades\Auth;

class InstructionController extends Controller
{
    //
    public function getInstruction(Request $request)
    {
    }

    public function createInstruction(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required',
            'imei' => 'required',
            'familyData' => 'required'
        ]);
        $instruction = Instruction::where('userId', $request->userId);
        if (is_null($instruction)) {
            return Instruction::create([
                'familyData' => $request->familyData,
                'userId' => $request->userId,
                'imei' => $request->imei,
            ]);
        } else {
            return Instruction::where('userId', $request->userId)->update([
                'familyData' => $request->familyData
            ]);
        }
    }

    public function updateInstruction(Request $request)
    {
    }

    public function deleteInstruction(Request $request)
    {
    }
}
