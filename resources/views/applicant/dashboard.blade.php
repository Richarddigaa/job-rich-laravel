@extends('applicant.master')
@section('title', 'Dashboard Pelamar | JobRich')

@push('style')
<style>
    .success {
        background-color: #198754;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        display: inline-block;
    }

    .danger {
        background-color: #F90101;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Dashboard</h5>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-8">

            <!-- Row for Cards -->
            <div class="row">

                <!-- Card Riwayat Lamaran -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto pr-3">
                                    <img src="{{asset('assets/icon/diproses.svg')}}" alt="Riwayat Lamaran" class="img-fluid"
                                        style="width: 50px" />
                                </div>
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Riwayat Lamaran</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800">120</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Lowongan Tersimpan -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto pr-3">
                                    <img src="{{asset('assets/icon/diproses.svg')}}" alt="Lowongan Tersimpan" class="img-fluid"
                                        style="width: 50px" />
                                </div>
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Lowongan Tersimpan</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800">10</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-lg-4 mb-4">

            <!-- Profil -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark">PROFILE</h6>

                    @if($user->personalApplicant)
                    @if($user->personalApplicant->status_personal_applicant == 'active')
                    <span class="success">Aktif</span>
                    @else
                    <span class="danger">Nonaktif</span>
                    @endif
                    @else
                    <span class="danger">Nonaktif</span>
                    @endif
                </div>

                <div class="card-body text-center">
                    <!-- avatar pelamar -->
                    @if($user->personalApplicant && $user->personalApplicant->avatars_applicant)
                    <img src="{{ Storage::url($user->personalApplicant->avatars_applicant) }}" alt="avatar pelamar" class="mb-3"
                        style="width: 100px; height: auto;">
                    @else
                    <img src="{{ asset('assets/icon/icon-user.png') }}" alt="avatar pelamar" class="mb-3"
                        style="width: 100px; height: auto;">
                    @endif

                    <!-- Nama & Kota -->
                    @if($user->personalApplicant)
                    <h5 class="font-weight-bold">{{ $user->personalApplicant->name_applicant }}</h5>
                    <p>{{ $user->personalApplicant->city_applicant }}</p>
                    @else
                    <h5 class="font-weight-bold">{{ $user->name }}</h5>
                    <p>-</p>
                    @endif

                    @if($user->personalApplicant)
                    <hr>

                    <!-- Informasi Tambahan -->
                    <div class="text-left px-3">
                        <p><strong>Email:</strong> {{ $user->personalApplicant->email_applicant}}</p>
                        <p><strong>No. Telepon:</strong> {{ $user->personalApplicant->phone_applicant?? '-' }}</p>
                        <p><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($user->personalApplicant->date_of_birth_applicant)->format('d M Y') }}</p>

                        @if($user->personalApplicant->gender == 'male')
                        <p><strong>Jenis Kelamin:</strong> Pria</p>
                        @else
                        <p><strong>Jenis Kelamin:</strong> Perempuan</p>
                        @endif

                        <p><strong>Ringkasan Diri:</strong> {!! $user->personalApplicant->sumary_applicant?? '-' !!}</p>
                    </div>
                    @endif

                    <a href="{{route('applicant.profile.edit', $user->personalApplicant->slug_applicant)}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Ubah Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection