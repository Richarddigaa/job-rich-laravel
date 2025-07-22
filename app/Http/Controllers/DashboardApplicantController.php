<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardApplicantController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->personalApplicant == null) {
            session()->flash('alert', [
                'title' => 'Isi Data Profile Anda Terlebih Dahulu',
                'type' => 'info', // 'success', 'error', 'warning', 'info'
            ]);
            return view('applicant.profile.create', compact('user'));
        } else {
            return view('applicant.dashboard', compact('user'));
        }
    }
}
