@extends('admin.master')
@section('title', 'Buat Profil Pelamar | JobRich')

@push('style')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Profil Pelamar</h5>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body px-4 py-5">
                    <h4 class="mb-4 text-center font-weight-bold">Profil Akun</h4>
                    <form method="POST" action="{{ route('admin.applicants.profile.store', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Kolom Kiri: Avatar -->
                            <div class="col-md-4 text-center">
                                <label for="avatars_company" class="form-label font-weight-bold">Avatar Pelamar :</label>
                                <input type="file" class="form-control mb-3" name="avatars_company">
                                <img src="{{ asset('assets/icon/icon-user.png') }}" class="img-thumbnail mt-2" width="150" alt="{{ $user->name }}">
                            </div>

                            <!-- Kolom Kanan: Informasi Pelamar -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name_applicant">Nama Pelamar :</label>

                                    <input type="text" class="form-control @error('name_applicant') is-invalid @enderror" id="name_applicant" name="name_applicant" value="{{ $user->name }}" />

                                    @error('name_applicant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email_applicant">Email Pelamar :</label>

                                    <input type="email" class="form-control @error('email_applicant') is-invalid @enderror" id="email_applicant" name="email_applicant" value="{{ $user->email }}" />

                                    @error('email_applicant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone_applicant">Nomor Handphone Pelamar :</label>

                                    <input type="text" class="form-control @error('phone_applicant') is-invalid @enderror" id="phone_applicant" name="phone_applicant" value="{{ old('phone_applicant') }}" placeholder="+628123456789" />

                                    @error('phone_applicant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="city_applicant">Kota Domisili Pelamar :</label>

                                    <input type="text" class="form-control @error('city_applicant') is-invalid @enderror" id="city_applicant" name="city_applicant" value="{{ old('city_applicant') }}" placeholder="Kota Bekasi" />

                                    @error('city_applicant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="date_of_birth_applicant">Tanggal Lahir :</label>
                                    <input type="date"
                                        class="form-control @error('date_of_birth_applicant') is-invalid @enderror"
                                        name="date_of_birth_applicant"
                                        value="{{ old('date_of_birth_applicant') }}">

                                    @error('date_of_birth_applicant')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin :</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                                                {{ old('gender', 'male') == 'male' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="male">Pria</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                                                {{ old('gender') == 'female' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="female">Perempuan</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Baris Baru: Deskripsi & Alamat -->
                        <div class="form-group mt-4">
                            <label for="sumary_applicant">Ringkasan Diri :</label>

                            <!-- Hidden textarea -->
                            <textarea name="sumary_applicant" id="sumary_applicant" class="d-none">
                            {{ old('sumary_applicant') }}
                            </textarea>

                            <!-- Quill Editor Container -->
                            <div id="quill_editor_sumary_applicant"
                                class="form-control @error('sumary_applicant') is-invalid @enderror"
                                style="height: 200px;"></div>

                            @error('sumary_applicant')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary d-block mx-auto mt-4 px-4">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

<!-- textarea deskripsi Pelamar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Quill
        var quill = new Quill('#quill_editor_sumary_applicant', {
            theme: 'snow',
            placeholder: 'Tulis ringkasan diri...',
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
        var summaryInput = document.querySelector('textarea#sumary_applicant');
        if (summaryInput.value) {
            quill.clipboard.dangerouslyPasteHTML(summaryInput.value); // Mengatur konten awal editor
        }

        quill.on('text-change', function() {
            summaryInput.value = quill.root.innerHTML;
        });
    });
</script>

@endpush