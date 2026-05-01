<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ApartmentExport;
use Maatwebsite\Excel\Facades\Excel;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(!in_array('Apartment', society_modules()) || !in_array('Apartment', society_role_modules()), 403);
        abort_if((!user_can('Show Apartment')) && (isRole() == 'Owner') && (isRole() == 'Tenant') && (isRole() == 'Guard'), 403);
        return view('apartments.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(!in_array('Apartment', society_modules()), 403);
        abort_if(!in_array('Apartment', society_role_modules()), 403);
        abort_if((!user_can('Show Apartment')) && (isRole() == 'Owner') && (isRole() == 'Tenant') && (isRole() == 'Guard'), 403);
        return view('apartments.show', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
