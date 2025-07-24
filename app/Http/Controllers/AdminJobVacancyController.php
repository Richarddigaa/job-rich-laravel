<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateJobVacancyRequest;
use App\Models\JobVacancy;
use App\Models\PersonalCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminJobVacancyController extends Controller
{
    public function index(PersonalCompany $personalCompany)
    {
        $jobVacancies = JobVacancy::getAllJobs();

        return view('admin.companies.jobs.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PersonalCompany $personalCompany)
    {
        return view('admin.companies.jobs.create', compact('personalCompany'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateJobVacancyRequest $request, PersonalCompany $personalCompany)
    {
        $jobVacancy = DB::transaction(function () use ($request, $personalCompany) {
            $validated = $request->validated();

            // mengambil id personal company yang login
            $validated['personal_company_id'] = $personalCompany->id;

            $validated['slug_job_position'] = Str::slug($validated['job_position'] . '-' . $personalCompany->name_company);

            return JobVacancy::create($validated);
        });

        return redirect()->route('admin.companies.jobs.show', [$personalCompany->slug_company, $jobVacancy->slug_job_position])->with('alert', [
            'title' => 'Data Lowongan Berhasil Di Tambahkan',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalCompany $personalCompany, JobVacancy $jobVacancy)
    {
        return view('admin.companies.jobs.show', compact('jobVacancy', 'personalCompany'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalCompany $personalCompany, JobVacancy $jobVacancy)
    {
        return view('admin.companies.jobs.edit', compact('jobVacancy', 'personalCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateJobVacancyRequest $request, PersonalCompany $personalCompany, JobVacancy $jobVacancy)
    {

        DB::transaction(function () use ($request, $personalCompany, $jobVacancy) {
            $validated = $request->validated();

            $validated['slug_job_position'] = Str::slug($validated['job_position'] . '-' . $personalCompany->name_company);

            $jobVacancy->update($validated);
        });

        return redirect()->route('admin.companies.jobs.show', [$personalCompany->slug_company, $jobVacancy->slug_job_position])->with('alert', [
            'title' => 'Data Lowongan Berhasil Di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalCompany $personalCompany, JobVacancy $jobVacancy)
    {
        DB::transaction(function () use ($jobVacancy) {
            $jobVacancy->delete();
        });

        return redirect()->route('admin.companies.profile.show', $personalCompany->slug_company)->with('alert', [
            'title' => 'Data Lowongan ' . $jobVacancy->job_position . ' Berhasil Dihapus',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }
}
