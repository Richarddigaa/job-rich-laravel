@extends('admin.master')
@section('title', 'Detail Perusahaan | JobRich')

@push('style')
<link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Detail Perusahaan</h5>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-dark">INFORMASI PERUSAHAAN</h6>
            </div>

            <div class="card-body">
                <div class="text-center mb-4">
                    @if ($personalCompany->avatars_company)
                    <img src="{{Storage::url($personalCompany->avatars_company)}}" alt="Logo Perusahaan" class="rounded-circle" width="120" height="120">
                    @else
                    <img src="{{ asset('assets/icon/icon-user.png') }}" alt="Default Logo" class="rounded-circle" width="120" height="120">
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <div class="mb-3">
                        <h5 class="text-dark font-weight-bold mb-1">{{ $personalCompany->name_company }}</h5>
                        <p class="text-muted mb-0">{{ $personalCompany->type_of_company }}</p>
                    </div>

                    <div class="mb-3">
                        @php
                        $status = $personalCompany->status_personal_company;
                        $label = [
                        'active' => 'Aktif',
                        'inactive' => 'Nonaktif',
                        'pending' => 'Pending',
                        ];
                        $classMap = [
                        'active' => 'success',
                        'inactive' => 'danger',
                        'pending' => 'warning',
                        ];
                        @endphp

                        <h5 class="text-dark font-weight-bold mb-1">Status Perusahaan :</h5>
                        <div class="dropdown">
                            <button class="dropdown-toggle {{ $classMap[$status] ?? 'text-muted' }}"
                                type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="all: unset; cursor: pointer;">
                                <span class="{{ $classMap[$status] ?? 'text-muted' }}">
                                    {{ $label[$status] ?? 'Tidak diketahui' }}
                                </span>
                            </button>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach($label as $key => $value)
                                @if ($key !== $status)
                                <form action="{{ route('admin.companies.profile.update.status', $personalCompany->slug_company) }}" method="POST" class="px-3 py-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_personal_company" value="{{ $key }}">
                                    <button type="submit" class="btn btn-link p-0 text-dark">{{ $value }}</button>
                                </form>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row align-items-center mb-3">
                        <a href="{{ route('admin.companies.profile.edit', $personalCompany->slug_company) }}" class="btn btn-outline-primary mb-2 mb-sm-0 mr-sm-2">
                            <i class="far fa-fw fa-edit"></i> Edit
                        </a>
                        <form id="delete-form" action="{{ route('admin.companies.destroy', $personalCompany->user_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete()" class="btn btn-outline-danger">
                                <i class="fas fa-fw fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-0">Email Perusahaan :</p>
                        <h5 class="text-dark font-weight-bold">{{ $personalCompany->email_company }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-0">Nomor Telepon :</p>
                        <h5 class="text-dark font-weight-bold">{{ $personalCompany->phone_company }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-0">Kota :</p>
                        <h5 class="text-dark font-weight-bold">{{ $personalCompany->city_company }}</h5>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="text-dark font-weight-bold mb-2">Alamat Lengkap :</h5>
                    <div>{!! $personalCompany->address_company !!}</div>
                </div>

                <div class="mb-4">
                    <h5 class="text-dark font-weight-bold mb-2">Deskripsi Perusahaan :</h5>
                    <div>{!! $personalCompany->description_company !!}</div>
                </div>

                <!-- informasi lowongan pekerjaan -->
                @if($personalCompany->status_personal_company == 'active' || $personalCompany->status_personal_company == 'inactive')
                <div class="card">
                    <div class="card-header py-3 text-center">
                        <h6 class="m-0 font-weight-bold text-dark text-uppercase">LOWONGAN PEKERJAAN {{ $personalCompany->name_company }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="widget">
                            <div class="table-responsive">
                                <a href="{{route('admin.companies.jobs.create', $personalCompany->slug_company)}}" class="btn btn-primary mt-1 mb-2">
                                    <i class="fas fa-fw fa-plus"></i>
                                    Tambah Lowongan
                                </a>

                                <table id="dataTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Posisi Pekerjaan</th>
                                            <th>Kota Pekerjaan</th>
                                            <th>Kisaran Gaji</th>
                                            <th>Batas Lowongan</th>
                                            <th>Status Pekerjaan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jobVacancies as $index => $jobs)
                                        <tr>
                                            <td>{{$index + 1}}.</td>
                                            <td>{{$jobs->job_position}}</td>
                                            <td>{{$jobs->job_city}}</td>
                                            <td>Rp {{number_format($jobs->job_salary_first, 0, ',', '.')}} - Rp {{number_format($jobs->job_salary_last, 0, ',', '.')}}</td>
                                            <td>{{\Carbon\Carbon::parse($jobs->job_deadline)->format('d F Y')}}</td>
                                            <td>
                                                @if ($jobs->job_status == 'open')
                                                <span class="success">Buka</span>
                                                @else
                                                <span class="danger">Tutup</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('admin.companies.jobs.show', [$personalCompany->slug_company, $jobs->slug_job_position])}}" class="btn btn-outline-primary">
                                                    <i class="fas fa-fw fa-search-plus"></i>
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Yakin ingin menghapus profil perusahaan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>

<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush