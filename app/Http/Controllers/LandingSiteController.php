<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalSetting;

class LandingSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = GlobalSetting::first();
        return view('landing-sites.index', compact('settings'));
    }

}
