@extends('company.master')
@section('title', 'Ubah Lowongan | JobRich')

@push('style')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Ubah Lowongan Pekerjaan</h5>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-dark">UBAH LOWONGAN PEKERJAAN</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('company.jobs.update', [$personalCompany->slug_company, $jobVacancy->slug_job_position])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="job_position">Posisi Yang Dibutuhkan :</label>
                                <input type="text"
                                    class="form-control @error('job_position') is-invalid @enderror"
                                    name="job_position"
                                    value="{{ $jobVacancy->job_position }}"
                                    placeholder="Masukkan Posisi Yang Dibutuhkan">

                                @error('job_position')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="job_salary_first">Kisaran Gaji Awal :</label>
                                <input type="text"
                                    class="form-control @error('job_salary_first') is-invalid @enderror"
                                    name="job_salary_first"
                                    value="{{ $jobVacancy->job_salary_first }}"
                                    placeholder="Masukkan Kisaran Gaji Awal"
                                    oninput="formatRupiah(this)">

                                @error('job_salary_first')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="job_deadline">Batas Lowongan :</label>
                                <input type="date"
                                    class="form-control @error('job_deadline') is-invalid @enderror"
                                    name="job_deadline"
                                    value="{{ $jobVacancy->job_deadline }}">

                                @error('job_deadline')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <label for="job_description">Deskripsi Pekerjaan :</label>
                                <textarea name="job_description" id="job_description" class="d-none">
                                {{ $jobVacancy->job_description }}
                                </textarea>

                                <div id="quill_editor_job_description"
                                    class="form-control @error('job_description') is-invalid @enderror"
                                    style="height: 300px;"></div>

                                @error('job_description')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="job_city">Kota Penempatan :</label>
                                <input type="text"
                                    class="form-control @error('job_city') is-invalid @enderror"
                                    name="job_city"
                                    value="{{ $jobVacancy->job_city }}"
                                    placeholder="Masukkan Kota Penempatan">

                                @error('job_city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="job_salary_last">Kisaran Gaji Akhir :</label>
                                <input type="text"
                                    class="form-control @error('job_salary_last') is-invalid @enderror"
                                    name="job_salary_last"
                                    value="{{ $jobVacancy->job_salary_last }}"
                                    placeholder="Masukkan Kisaran Gaji Akhir"
                                    oninput="formatRupiah(this)">

                                @error('job_salary_last')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="job_status">Status Lowongan :</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="job_status" id="open" value="open"
                                            {{ $jobVacancy->job_status == 'open' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="open">Buka</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="job_status" id="closed" value="closed"
                                            {{ $jobVacancy->job_status == 'closed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="closed">Tutup</label>
                                    </div>
                                </div>
                                @error('job_status')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="form-group mt-4">
                                <label for="job_address">Alamat Penempatan :</label>
                                <textarea name="job_address" id="job_address" class="d-none">
                                {{ $jobVacancy->job_address }}
                                </textarea>

                                <div id="quill_editor_job_address"
                                    class="form-control @error('job_address') is-invalid @enderror"
                                    style="height: 200px;"></div>

                                @error('job_address')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Ubah Lowongan</button>
                        <a href="{{route('company.jobs.show', [$personalCompany->slug_company, $jobVacancy->slug_job_position])}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

<!-- textarea deskripsi pekerjaan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Quill
        var quill = new Quill('#quill_editor_job_description', {
            theme: 'snow',
            placeholder: 'Tulis deskripsi pekerjaan...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'], // Bold, Italic, Underline
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }] // Ordered & Unordered List
                ]
            }
        });

        // Set Font Poppins for Quill Editor
        quill.root.style.fontFamily = 'Poppins, sans-serif';
        quill.root.style.color = '#343a40';

        // Simpan data Quill ke input hidden
        var summaryInput = document.querySelector('textarea#job_description');
        if (summaryInput.value) {
            quill.clipboard.dangerouslyPasteHTML(summaryInput.value); // Mengatur konten awal editor
        }

        quill.on('text-change', function() {
            summaryInput.value = quill.root.innerHTML;
        });
    });
</script>

<!-- textarea alamat penempatan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Quill
        var quill = new Quill('#quill_editor_job_address', {
            theme: 'snow',
            placeholder: 'Tulis alamat penempatan...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'], // Bold, Italic, Underline
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }] // Ordered & Unordered List
                ]
            }
        });

        // Set Font Poppins for Quill Editor
        quill.root.style.fontFamily = 'Poppins, sans-serif';
        quill.root.style.color = '#343a40';

        // Simpan data Quill ke input hidden
        var summaryInput = document.querySelector('textarea#job_address');
        if (summaryInput.value) {
            quill.clipboard.dangerouslyPasteHTML(summaryInput.value); // Mengatur konten awal editor
        }

        quill.on('text-change', function() {
            summaryInput.value = quill.root.innerHTML;
        });
    });
</script>

<script>
    function formatRupiah(input) {
        // Hapus karakter selain angka
        let value = input.value.replace(/[^0-9]/g, '');
        // Format ke Rupiah
        let formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);

        input.value = formatted.replace('IDR', 'Rp').trim(); // Ubah ke format Rp
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('form').addEventListener('submit', function(e) {
            let input_job_salary_first = document.getElementById('job_salary_first');
            let input_job_salary_last = document.getElementById('job_salary_last');

            // Hapus karakter selain angka
            input_job_salary_first.value = input_job_salary_first.value.replace(/[^0-9]/g, '');
            input_job_salary_last.value = input_job_salary_last.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endpush