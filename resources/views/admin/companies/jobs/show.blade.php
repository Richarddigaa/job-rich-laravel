@extends('admin.master')
@section('title', 'Detail Lowongan | JobRich')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Detail Lowongan Pekerjaan {{ $personalCompany->name_company }}</h5>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-dark">DETAIL LOWONGAN PEKERJAAN</h6>
            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <!-- Kolom Kiri: Judul  -->
                    <div class="mb-3">
                        <h5 class="text-dark font-weight-bold mb-1">{{ $jobVacancy->job_position }}</h5>
                    </div>

                    <!-- Kolom Tengah: Status -->
                    <div class="mb-3">
                        @if ($jobVacancy->job_status == 'open')
                        <span class="success">Buka</span>
                        @else
                        <span class="danger">Tutup</span>
                        @endif
                    </div>

                    <!-- Kolom Kanan: Aksi -->
                    <div class="d-flex flex-column flex-sm-row align-items-center mb-3">
                        <a href="{{ route('admin.companies.jobs.edit', [$personalCompany->slug_company, $jobVacancy->slug_job_position]) }}" class="btn btn-outline-primary mb-2 mb-sm-0 mr-sm-2">
                            <i class="far fa-fw fa-edit"></i> Edit
                        </a>
                        <form id="delete-form-{{ $jobVacancy->id }}" action="{{ route('admin.companies.jobs.destroy', [$personalCompany->slug_company, $jobVacancy->slug_job_position]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('{{ $jobVacancy->id }}')" class="btn btn-outline-danger">
                                <i class="fas fa-fw fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>


                <hr>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-0">Kisaran Gaji :</p>
                        <h5 class="text-dark font-weight-bold">Rp {{ number_format($jobVacancy->job_salary_first, 0, ',', '.') }} - Rp {{ number_format($jobVacancy->job_salary_last, 0, ',', '.') }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-0">Batas Lowongan :</p>
                        <h5 class="text-dark font-weight-bold">{{ \Carbon\Carbon::parse($jobVacancy->job_deadline)->format('d M Y') }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-0">Kota Penempatan :</p>
                        <h5 class="text-dark font-weight-bold">{{ $jobVacancy->job_city }}</h5>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <h5 class="text-dark font-weight-bold mb-2">Deskripsi Pekerjaan :</h5>
                    <div>{!! $jobVacancy->job_description !!}</div>
                </div>

                <div class="mb-4">
                    <h5 class="text-dark font-weight-bold mb-2">Alamat Penempatan :</h5>
                    <div>{!! $jobVacancy->job_address !!}</div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus lowongan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endpush