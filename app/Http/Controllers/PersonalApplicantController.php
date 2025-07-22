<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProfileApplicantRequest;
use App\Models\PersonalApplicant;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersonalApplicantController extends Controller
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

        return view('applicant.profile.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateProfileApplicantRequest $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            $validated = $request->validated();

            // mengambil id user yang login
            $validated['user_id'] = $user->id;

            // buat slug applicant
            $validated['slug_applicant'] = Str::slug($validated['name_applicant'] . '-' . $user->id);

            // status perusahaan
            $validated['status_personal_applicant'] = 'active';

            // cek apakah user input avatar jika input maka proses upload
            if ($request->hasFile('avatars_applicant')) {
                $avatarsApplicant = $request->file('avatars_applicant')->store('avatars_applicant', 'public');
                $validated['avatars_applicant'] = $avatarsApplicant;
            }

            $personalApplicant = PersonalApplicant::create($validated);
        });

        return redirect()->route('applicant.dashboard')->with('alert', [
            'title' => 'Data Profile Berhasil di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalApplicant $personalApplicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalApplicant $personalApplicant)
    {
        return view('applicant.profile.edit', compact('personalApplicant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateProfileApplicantRequest $request, PersonalApplicant $personalApplicant)
    {
        DB::transaction(function () use ($request, $personalApplicant) {
            $validated = $request->validated();

            // buat slug applicant
            $validated['slug_applicant'] = Str::slug($validated['name_applicant'] . '-' . $personalApplicant->id);

            // cek apakah user input avatar jika input maka proses upload
            if ($request->hasFile('avatars_company')) {
                $avatarsCompany = $request->file('avatars_company')->store('avatars_company', 'public');
                $validated['avatars_company'] = $avatarsCompany;
            }

            $personalApplicant->update($validated);
        });

        return redirect()->route('applicant.dashboard')->with('alert', [
            'title' => 'Data Profile Berhasil di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalApplicant $personalApplicant)
    {
        //
    }
}
