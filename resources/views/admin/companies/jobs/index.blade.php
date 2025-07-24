@extends('admin.master')
@section('title', 'Lowongan Pekerjaan | JobRich')

@push('style')
<link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Lowongan Pekerjaan</h5>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-dark">DAFTAR LOWONGAN PEKERJAAN</h6>
            </div>
            <div class="card-body">
                <div class="widget">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Perusahaan</th>
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
                                    <td>{{$jobs->personalCompany->name_company}}</td>
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
                                        <a href="{{route('admin.companies.jobs.show', [$jobs->personalCompany->slug_company, $jobs->slug_job_position])}}" class="btn btn-outline-primary">
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
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush