<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProfileCompanyRequest;
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

    public function companyCreate()
    {
        return view('admin.companies.create');
    }

    public function companyStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'min:8', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:applicant,company'],
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 huruf.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Silakan pilih peran Anda.',
            'role.in' => 'Pilihan peran tidak valid.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

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
        return view('admin.companies.profile.show', compact('personalCompany'));
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

        $personalCompany->update([
            'status_personal_company' => $request->status_personal_company,
        ]);

        return redirect()->route('admin.companies.profile.show', $personalCompany->slug_company)->with('alert', [
            'title' => 'Status Perusahaan Berhasil di Ubah',
            'type' => 'success', // 'success', 'error', 'warning', 'info'
        ]);
    }
}
