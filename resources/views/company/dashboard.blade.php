@extends('company.master')
@section('title', 'Dashboard Perusahaan | JobRich')

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

    .warning {
        background-color: #e4d96f;
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

                <!-- Card Kandidat Pelamar -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto pr-3">
                                    <img src="{{asset('assets/icon/diproses.svg')}}" alt="Kandidat Pelamar" class="img-fluid"
                                        style="width: 50px" />
                                </div>
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kandidat Pelamar</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800">120</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Lowongan Aktif -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto pr-3">
                                    <img src="{{asset('assets/icon/diproses.svg')}}" alt="Lowongan Aktif" class="img-fluid"
                                        style="width: 50px" />
                                </div>
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Lowongan Aktif</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800">10</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Color System -->
            <div class="row">
                <!-- Tabel Informasi Kandidat -->
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Header Card -->
                        <div class="card-header py-3 text-center">
                            <h6 class="m-0 font-weight-bold text-dark">INFORMASI KANDIDAT</h6>
                        </div>
                        <!-- Body Card -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTables" class="table table-bordered table-striped" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Kandidat</th>
                                            <th>Posisi Dilamar</th>
                                            <th>Pendidikan</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="assets/Dashboard/informasi.png" alt="Foto" class="rounded-circle mr-2"
                                                        style="width: 30px; height: 30px" />
                                                    <span>Kelvin Erlangga</span>
                                                </div>
                                            </td>
                                            <td>Senior Sysadmin Linux</td>
                                            <td>S1 Networking</td>
                                            <td>Laki - Laki</td>
                                            <td><button class="btn btn-primary btn-sm">Selengkapnya</button></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="assets/Dashboard/informasi.png" alt="Foto" class="rounded-circle mr-2"
                                                        style="width: 30px; height: 30px" />
                                                    <span>Abrar</span>
                                                </div>
                                            </td>
                                            <td>Senior Sysadmin Linux</td>
                                            <td>S1 Networking</td>
                                            <td>Laki - Laki</td>
                                            <td><button class="btn btn-primary btn-sm">Selengkapnya</button></td>
                                        </tr>
                                    </tbody>
                                </table>
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

                    @if($user->personalCompany)
                    @if($user->personalCompany->status_personal_company == 'active')
                    <span class="success">Aktif</span>
                    @elseif($user->personalCompany->status_personal_company == 'inactive')
                    <span class="danger">Nonaktif</span>
                    @else
                    <span class="warning">Pending</span>
                    @endif
                    @else
                    <span class="warning">Pending</span>
                    @endif
                </div>

                <div class="card-body text-center">
                    <!-- Logo Perusahaan -->
                    @if($user->personalCompany && $user->personalCompany->avatars_company)
                    <img src="{{ Storage::url($user->personalCompany->avatars_company) }}" alt="Logo Perusahaan" class="mb-3"
                        style="width: 100px; height: auto;">
                    @else
                    <img src="{{ asset('assets/icon/icon-user.png') }}" alt="Logo Perusahaan" class="mb-3"
                        style="width: 100px; height: auto;">
                    @endif

                    <!-- Nama & Kota -->
                    @if($user->personalCompany)
                    <h5 class="font-weight-bold">{{ $user->personalCompany->name_company }}</h5>
                    <p>{{ $user->personalCompany->city_company }}</p>
                    @else
                    <h5 class="font-weight-bold">{{ $user->name }}</h5>
                    <p>-</p>
                    @endif

                    @if($user->personalCompany)
                    <!-- Deskripsi -->
                    <p class="mt-3">
                        {!!$user->personalCompany->description_company!!}
                    </p>

                    <hr>

                    <!-- Informasi Tambahan -->
                    <div class="text-left px-3">
                        <p><strong>Email:</strong> {{ $user->personalCompany->email_company }}</p>
                        <p><strong>No. Telepon:</strong> {{ $user->personalCompany->phone_company ?? '-' }}</p>
                        <p><strong>Tipe Perusahaan:</strong> {{ $user->personalCompany->type_of_company ?? '-' }}</p>
                        <p><strong>Alamat Perusahaan:</strong> {!! $user->personalCompany->address_company ?? '-' !!}</p>
                    </div>
                    @endif

                    <a href="{{route('company.profile.edit', $user->personalCompany->slug_company)}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Ubah Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection