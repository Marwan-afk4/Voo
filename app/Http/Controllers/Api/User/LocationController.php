<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class LocationController extends Controller
{


    public function GetCity(){
        $cities = City::with('country')->get();
        $data = $cities->map(function ($city) {
            return [
                'id' => $city->id,
                'name' => $city->name,
                'country_id' => $city->country_id,
                'country_name' => $city->country->name,
            ];
        });
        return response()->json(['cities'=>$data],200);
    }

    public function GetCountry(){
        $countries = Country::all();
        $data =[
            'countries' => $countries,
        ];
        return response()->json($data,200);
    }
}
