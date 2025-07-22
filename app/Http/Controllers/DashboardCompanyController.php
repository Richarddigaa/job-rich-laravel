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

        if ($user->personalCompany == null) {
            session()->flash('alert', [
                'title' => 'Isi Data Profile Anda Terlebih Dahulu',
                'type' => 'info', // 'success', 'error', 'warning', 'info'
            ]);
            return view('company.profile.create', compact('user'));
        } else {
            return view('company.dashboard', compact('user'));
        }
    }
}
