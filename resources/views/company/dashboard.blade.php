@extends('company.master')
@section('title', 'Dashboard Perusahaan | JobRich')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2 bg-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                                Perusahaan
                            </div>
                            <div class="h1 mb-0 font-weight-bold text-white">

                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="">
                                <i class="fas fa-list fa-3x text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2 bg-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                                Pelamar
                            </div>
                            <div class="h1 mb-0 font-weight-bold text-white">

                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="">
                                <i class="fas fa-donate fa-3x text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection