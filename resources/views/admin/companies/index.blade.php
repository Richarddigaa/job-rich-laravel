@extends('admin.master')
@section('title', 'Daftar Perusahaan | JobRich')

@push('style')
<link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Daftar Perusahaan</h5>
    </div>

    <!-- Data Tabel Perusahaan -->
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-dark">DAFTAR PERUSAHAAN</h6>
            </div>
            <div class="card-body">
                <div class="widget">
                    <div class="table-responsive">

                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahPerusahaanModal">
                            <i class="fas fa-fw fa-plus"></i> Tambah Perusahaan
                        </button>

                        <table id="dataTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Status Perusahaan</th>
                                    <th>Tanggal Daftar Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userRoleCompany as $index => $company)
                                <tr>
                                    <td>{{$index + 1}}.</td>
                                    <td>{{$company->name}}</td>
                                    <td>
                                        @php $status = optional($company->personalCompany)->status_personal_company; @endphp

                                        @if ($status == 'active')
                                        <span class="success">Aktif</span>
                                        @elseif ($status == 'inactive')
                                        <span class="danger">Nonaktif</span>
                                        @elseif ($status == 'pending')
                                        <span class="warning">Pending</span>
                                        @else
                                        <span class="text-muted">Belum Isi Profil</span>
                                        @endif
                                    </td>
                                    <td>{{\Carbon\Carbon::parse($company->created_at)->format('d F Y')}}</td>
                                    <td>
                                        @if ($company->personalCompany == null)
                                        <a href="{{route('admin.companies.profile.create', $company->id)}}" class="btn btn-outline-primary">
                                            <i class="fas fa-fw  fa-plus-circle"></i> Buat Profile
                                        </a>
                                        @else
                                        <a href="{{route('admin.companies.profile.show', $company->personalCompany->slug_company)}}" class="btn btn-outline-primary">
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

    <!-- Modal Form Tambah Perusahaan -->
    <div class="modal fade" id="tambahPerusahaanModal" tabindex="-1" role="dialog" aria-labelledby="tambahPerusahaanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPerusahaanModalLabel">Tambah Perusahaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Register Perusahaan -->
                    <form method="POST" action="{{ route('admin.companies.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Perusahaan</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="JobRich" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email Perusahaan</label>
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

                        <input type="hidden" name="role" value="company">

                        <button type="submit" class="btn btn-primary w-100">Tambah Perusahaan</button>
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