<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\Currency;
use App\Models\Amenities;
use App\Models\BookAmenity;
use Illuminate\Http\Request;
use App\Exports\AmenitiesExport;
use App\Models\AssetManagement;
use Maatwebsite\Excel\Facades\Excel;

class AssetsManagementController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Assets', society_role_modules()), 403);
        abort_if((!user_can('Show Assets')) && (isRole() == 'Owner') && (isRole() == 'Tenant'), 403);
        return view('assets.index');
    }


    public function show($id)
    {
        abort_if(!in_array('Assets', society_role_modules()), 403);
        abort_if((!user_can('Show Assets')) && (isRole() != 'Owner') && (isRole() != 'Tenant'), 403);
        $asset = AssetManagement::findOrFail($id);
        return view('assets.show', compact('asset'));

    }
}
