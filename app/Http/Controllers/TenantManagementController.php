<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TenantsExport;
use App\Models\Tenant;

class TenantManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(!in_array('Tenant', society_modules()) || !in_array('Tenant', society_role_modules()), 403);
        abort_if((!user_can('Show Tenant')) && (isRole() != 'Owner') && (isRole() != 'Tenant'), 403);

        return view('tenants.index');
    }

    public function show($id)
    {
        abort_if(!in_array('Tenant', society_modules()) || !in_array('Tenant', society_role_modules()), 403);
        abort_if((!user_can('Show Tenant')) && (isRole() != 'Owner') && (isRole() != 'Tenant'), 403);
        $tenant = Tenant::findOrFail($id);
        return view('tenants.show', compact('tenant'));
    }
}
