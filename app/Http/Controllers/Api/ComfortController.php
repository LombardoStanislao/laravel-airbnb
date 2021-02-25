<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comfort;

class ComfortController extends Controller
{
    public function getAllComforts() {
        return response()->json([
            'success' => true,
            'results' => Comfort::all()
        ]);
    }
}
