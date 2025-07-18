<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardApplicantController extends Controller
{
    public function index()
    {
        return view('applicant.dashboard');
    }
}
