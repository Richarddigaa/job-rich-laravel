@extends('admin.master')
@section('title', 'Daftar Pelamar | JobRich')

@push('style')
<link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Daftar Pelamar</h5>
    </div>

    <!-- Data Tabel Pelamar -->
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-dark">DAFTAR PELAMAR</h6>
            </div>
            <div class="card-body">
                <div class="widget">
                    <div class="table-responsive">

                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahPelamarModal">
                            <i class="fas fa-fw fa-plus"></i> Tambah pelamar
                        </button>

                        <table id="dataTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelamar</th>
                                    <th>Status Pelamar</th>
                                    <th>Tanggal Daftar Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userRoleApplicant as $index => $applicant)
                                <tr>
                                    <td>{{$index + 1}}.</td>
                                    <td>{{$applicant->name}}</td>
                                    <td>
                                        @php $status = optional($applicant->personalApplicant)->status_personal_applicant; @endphp

                                        @if ($status == 'active')
                                        <span class="success">Aktif</span>
                                        @elseif ($status == 'inactive')
                                        <span class="danger">Nonaktif</span>
                                        @else
                                        <span class="text-muted">Belum Isi Profil</span>
                                        @endif
                                    </td>
                                    <td>{{\Carbon\Carbon::parse($applicant->created_at)->format('d F Y')}}</td>
                                    <td>
                                        @if ($applicant->personalApplicant == null)
                                        <a href="{{route('admin.applicants.profile.create', $applicant->id)}}" class="btn btn-outline-primary">
                                            <i class="fas fa-fw  fa-plus-circle"></i> Buat Profile
                                        </a>
                                        @else
                                        <a href="{{route('admin.applicants.profile.show', $applicant->personalApplicant->slug_applicant)}}" class="btn btn-outline-primary">
                                            <i class="fas fa-fw fa-search-plus"></i> Lihat Detail
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah Pelamar -->
    <div class="modal fade" id="tambahPelamarModal" tabindex="-1" role="dialog" aria-labelledby="tambahPelamarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPelamarModalLabel">Tambah Pelamar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Register Pelamar -->
                    <form method="POST" action="{{ route('admin.applicants.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Pelamar</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="JobRich" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email Pelamar</label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="email@example.com" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="********">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="********">
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="role" value="applicant">

                        <button type="submit" class="btn btn-primary w-100">Tambah Pelamar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

        // Toggle form show/hide
        $('#toggleFormBtn').on('click', function() {
            $('#formContainer').slideToggle();
        });
    });
</script>
@endpush