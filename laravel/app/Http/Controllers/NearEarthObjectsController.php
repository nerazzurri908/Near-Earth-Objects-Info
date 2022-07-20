<?php

namespace App\Http\Controllers;

use App\Models\NearEarthObject;

use Illuminate\Http\Request;

class NearEarthObjectsController extends Controller
{
    public function hazardous()
    {
        $models = NearEarthObject::where('is_hazardous', 1)->get();
        return $models;
    }

    public function fastest(Request $request)
    {
        $query = NearEarthObject::query();

        $is_hazardous = $request->input('hazardous') == "true"
            ? 1
            : 0;

        $query->when($is_hazardous, function ($query, $hazardous) {
            return $query->where('is_hazardous', $hazardous);
        })
            ->orderByDesc('speed');

        $models = $query->get();

        return $models;
    }

}
