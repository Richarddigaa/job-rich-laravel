@extends('admin.master')
@section('title', 'Detail Pelamar | JobRich')

@push('style')
<link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Detail Pelamar</h5>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-dark">INFORMASI PELAMAR</h6>
            </div>

            <div class="card-body">
                <div class="text-center mb-4">
                    @if ($personalApplicant->avatars_applicant)
                    <img src="{{Storage::url($personalApplicant->avatars_applicant)}}" alt="Foto Pelamar" class="rounded-circle" width="120" height="120">
                    @else
                    <img src="{{ asset('assets/icon/icon-user.png') }}" alt="Default Foto" class="rounded-circle" width="120" height="120">
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <div class="mb-3">
                        <h5 class="text-dark font-weight-bold mb-1">{{ $personalApplicant->name_applicant }}</h5>
                        <p class="text-muted mb-0">
                            {{ \Carbon\Carbon::parse($personalApplicant->date_of_birth_applicant)->age }} tahun
                        </p>

                    </div>

                    <div class="mb-3">
                        @php
                        $status = $personalApplicant->status_personal_applicant;
                        $label = [
                        'active' => 'Aktif',
                        'inactive' => 'Nonaktif',
                        ];
                        $classMap = [
                        'active' => 'success',
                        'inactive' => 'danger',
                        ];
                        @endphp

                        <h5 class="text-dark font-weight-bold mb-1">Status Pelamar :</h5>
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
                                <form action="{{ route('admin.applicants.profile.update.status', $personalApplicant->slug_applicant) }}" method="POST" class="px-3 py-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_personal_applicant" value="{{ $key }}">
                                    <button type="submit" class="btn btn-link p-0 text-dark">{{ $value }}</button>
                                </form>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row align-items-center mb-3">
                        <a href="{{ route('admin.applicants.profile.edit', $personalApplicant->slug_applicant) }}" class="btn btn-outline-primary mb-2 mb-sm-0 mr-sm-2">
                            <i class="far fa-fw fa-edit"></i> Edit
                        </a>
                        <form id="delete-form" action="{{ route('admin.applicants.destroy', $personalApplicant->user_id) }}" method="POST">
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
                        <p class="text-muted mb-0">Email :</p>
                        <h5 class="text-dark font-weight-bold">{{ $personalApplicant->email_applicant }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-0">Nomor Telepon :</p>
                        <h5 class="text-dark font-weight-bold">{{ $personalApplicant->phone_applicant }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-0">Kota :</p>
                        <h5 class="text-dark font-weight-bold">{{ $personalApplicant->city_applicant }}</h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-0">Jenis Kelamin :</p>
                        <h5 class="text-dark font-weight-bold">
                            @if ($personalApplicant->gender == 'male')
                            Pria
                            @elseif ($personalApplicant->gender == 'female')
                            Perempuan
                            @else
                            Tidak diketahui
                            @endif</h5>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="text-dark font-weight-bold mb-2">Ringkasan Diri:</h5>
                    <div>{!! $personalApplicant->sumary_applicant !!}</div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Yakin ingin menghapus profil pelamar ini?',
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
@endpush