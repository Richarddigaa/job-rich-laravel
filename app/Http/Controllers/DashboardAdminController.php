<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicantAndCompanyRequest;
use App\Http\Requests\StoreUpdateProfileApplicantRequest;
use App\Http\Requests\StoreUpdateProfileCompanyRequest;
use App\Models\JobVacancy;
use App\Models\PersonalApplicant;
use App\Models\PersonalCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class DashboardAdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function companyIndex()
    {
        $userRoleCompany = User::getAllUserRoleCompany();

        return view('admin.companies.index', compact('userRoleCompany'));
    }

    public function companyStore(StoreApplicantAndCompanyRequest $request)
    {

        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $newUserCompany = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $newUserCompany->assignRole($request->role);
        });

        return redirect()->route('admin.companies.index')->with('alert', [
            'title' => 'Perusahaan Berhasil Di Tambahkan',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    public function companyProfileCreate(User $user)
    {
        return view('admin.companies.profile.create', compact('user'));
    }

    public function companyProfileStore(StoreUpdateProfileCompanyRequest $request, User $user)
    {

        $company = DB::transaction(function () use ($request, $user) {
            $validated = $request->validated();

            // mengambil id user perusahaan
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

            // Update nama user dengan nama perusahaan
            $user->update(['name' => $validated['name_company']]);

            // Simpan profil perusahaan dan return instansinya
            return $user->personalCompany()->create($validated);
        });

        return redirect()->route('admin.companies.profile.show', $company->slug_company)->with('alert', [
            'title' => 'Data Profile Berhasil di Tambahkan',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    public function companyDestroy(User $user)
    {
        DB::transaction(function () use ($user) {
            // Ambil data personalCompany
            $company = $user->personalCompany;

            // Hapus semua lowongan pekerjaan dan hapus personal perusahaan
            if ($company) {
                $company->jobVacancies()->delete();
                $company->delete();
            }

            // Terakhir, hapus user
            $user->delete();
        });

        return redirect()->route('admin.companies.index')->with('alert', [
            'title' => 'Data perusahaan berhasil dihapus',
            'type' => 'success',
        ]);
    }

    public function companyProfileShow(PersonalCompany $personalCompany)
    {
        $jobVacancies = JobVacancy::getAllJobsByCompany($personalCompany->id);

        return view('admin.companies.profile.show', compact('personalCompany', 'jobVacancies'));
    }

    public function companyProfileEdit(PersonalCompany $personalCompany)
    {
        return view('admin.companies.profile.edit', compact('personalCompany'));
    }

    public function companyProfileUpdate(StoreUpdateProfileCompanyRequest $request, PersonalCompany $personalCompany)
    {
        DB::transaction(function () use ($request, $personalCompany) {
            $validated = $request->validated();

            $validated['slug_company'] = Str::slug($validated['name_company'] . '-' . $personalCompany->id);

            // cek apakah user input avatar jika input maka proses upload
            if ($request->hasFile('avatars_company')) {
                $avatarsCompany = $request->file('avatars_company')->store('avatars_company', 'public');
                $validated['avatars_company'] = $avatarsCompany;
            }

            // Update perusahaan
            $personalCompany->update($validated);

            // Update juga nama user-nya
            $personalCompany->user()->update(['name' => $validated['name_company']]);
        });

        return redirect()->route('admin.companies.profile.show', $personalCompany->slug_company)->with('alert', [
            'title' => 'Data Perusahaan Berhasil di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    public function companyProfileUpdateStatus(Request $request, PersonalCompany $personalCompany)
    {
        $request->validate([
            'status_personal_company' => 'required|in:active,inactive,pending',
        ]);

        // Update status perusahaan
        $personalCompany->update([
            'status_personal_company' => $request->status_personal_company,
        ]);

        // Jika status perusahaan menjadi 'inactive', ubah semua lowongan 'open' menjadi 'closed'
        if ($request->status_personal_company === 'inactive') {
            $personalCompany->jobVacancies()
                ->where('job_status', 'open')
                ->update(['job_status' => 'closed']);
        }

        return redirect()->route('admin.companies.profile.show', $personalCompany->slug_company)->with('alert', [
            'title' => 'Status Perusahaan Berhasil di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    public function applicantIndex()
    {
        $userRoleApplicant = User::getAllUserRoleApplicant();

        return view('admin.applicants.index', compact('userRoleApplicant'));
    }

    public function applicantStore(StoreApplicantAndCompanyRequest $request)
    {

        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $newUserCompany = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $newUserCompany->assignRole($request->role);
        });

        return redirect()->route('admin.applicants.index')->with('alert', [
            'title' => 'Pelamar Berhasil Di Tambahkan',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }


    public function applicantProfileCreate(User $user)
    {
        return view('admin.applicants.profile.create', compact('user'));
    }

    public function applicantProfileStore(StoreUpdateProfileApplicantRequest $request, User $user)
    {

        $applicant = DB::transaction(function () use ($request, $user) {
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

            // Update nama user dengan nama pelamar
            $user->update(['name' => $validated['name_applicant']]);

            // Simpan profil perusahaan dan return instansinya
            return $user->personalApplicant()->create($validated);
        });

        return redirect()->route('admin.applicants.profile.show', $applicant->slug_applicant)->with('alert', [
            'title' => 'Data Profile Berhasil di Tambahkan',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    public function applicantDestroy(User $user)
    {
        DB::transaction(function () use ($user) {

            // Ambil data personalApplicant
            $applicant = $user->personalCompany;

            // Hapus personal pelamaar
            if ($applicant) {
                $applicant->delete();
            }

            // hapus user pelamar
            $user->delete();
        });

        return redirect()->route('admin.applicants.index')->with('alert', [
            'title' => 'Data Pelamar berhasil dihapus',
            'type' => 'success',
        ]);
    }

    public function applicantProfileShow(PersonalApplicant $personalApplicant)
    {
        return view('admin.applicants.profile.show', compact('personalApplicant'));
    }

    public function applicantProfileEdit(Personalapplicant $personalApplicant)
    {
        return view('admin.applicants.profile.edit', compact('personalApplicant'));
    }

    public function applicantProfileUpdate(StoreUpdateProfileApplicantRequest $request, PersonalApplicant $personalApplicant)
    {
        DB::transaction(function () use ($request, $personalApplicant) {
            $validated = $request->validated();

            $validated['slug_applicant'] = Str::slug($validated['name_applicant'] . '-' . $personalApplicant->id);

            // cek apakah user input avatar jika input maka proses upload
            if ($request->hasFile('avatars_applicant')) {
                $avatarsapplicant = $request->file('avatars_applicant')->store('avatars_applicant', 'public');
                $validated['avatars_applicant'] = $avatarsapplicant;
            }

            // Update perusahaan
            $personalApplicant->update($validated);

            // Update juga nama user-nya
            $personalApplicant->user()->update(['name' => $validated['name_applicant']]);
        });

        return redirect()->route('admin.applicants.profile.show', $personalApplicant->slug_applicant)->with('alert', [
            'title' => 'Data Pelamar Berhasil di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }

    public function applicantProfileUpdateStatus(Request $request, PersonalApplicant $personalApplicant)
    {
        $request->validate([
            'status_personal_applicant' => 'required|in:active,inactive',
        ]);

        // Update status pelamar
        $personalApplicant->update([
            'status_personal_applicant' => $request->status_personal_applicant,
        ]);

        return redirect()->route('admin.applicants.profile.show', $personalApplicant->slug_applicant)->with('alert', [
            'title' => 'Status Pelamar Berhasil di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }
}
