<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProfileCompanyRequest;
use App\Models\PersonalCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersonalCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        return view('company.profile.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateProfileCompanyRequest $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            $validated = $request->validated();

            // mengambil id user yang login
            $validated['user_id'] = $user->id;

            // buat slug company
            $validated['slug_company'] = Str::slug($validated['name_company'] . '-' . $user->id);

            // status perusahaan
            $validated['status_personal_company'] = 'pending';

            // cek apakah user input avatar jika input maka proses upload
            if ($request->hasFile('avatars_company')) {
                $avatarsCompany = $request->file('avatars_company')->store('avatars_company', 'public');
                $validated['avatars_company'] = $avatarsCompany;
            }

            $personalCompany = PersonalCompany::create($validated);
        });

        return redirect()->route('company.dashboard')->with('alert', [
            'title' => 'Data Profile Berhasil di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalCompany $personalCompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalCompany $personalCompany)
    {
        return view('company.profile.edit', compact('personalCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateProfileCompanyRequest $request, PersonalCompany $personalCompany)
    {

        DB::transaction(function () use ($request, $personalCompany) {
            $validated = $request->validated();

            $validated['slug_company'] = Str::slug($validated['name_company'] . '-' . $personalCompany->id);

            // cek apakah user input avatar jika input maka proses upload
            if ($request->hasFile('avatars_company')) {
                $avatarsCompany = $request->file('avatars_company')->store('avatars_company', 'public');
                $validated['avatars_company'] = $avatarsCompany;
            }

            $personalCompany->update($validated);
        });

        return redirect()->route('company.dashboard')->with('alert', [
            'title' => 'Data Profile Berhasil di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalCompany $personalCompany)
    {
        //
    }
}
