<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileCompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardCompanyController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika profil perusahaan belum diisi
        if ($user->personalCompany == null) {
            session()->flash('alert', [
                'title' => 'Isi Data Profile Anda Terlebih Dahulu',
                'type' => 'info', // 'success', 'error', 'warning', 'info'
            ]);
            return view('company.profile.create', compact('user'));
        }

        // Jika perusahaan tidak aktif
        if ($user->personalCompany->status_personal_company === 'inactive') {
            session()->flash('alert', [
                'title' => 'Akun Perusahaan Anda Telah Di Nonaktifkan. Silakan hubungi admin.',
                'type' => 'warning', // 'success', 'error', 'warning', 'info'
            ]);
        }

        // Tampilkan dashboard
        return view('company.dashboard', compact('user'));
    }
}
