@extends('company.master')
@section('title', 'Ubah Profil Perusahaan | JobRich')

@push('style')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 font-weight-bold text-primary">Dashboard Perusahaan / <span class="text-dark">Profil Akun</span></h5>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body px-4 py-5">
                    <h4 class="mb-4 text-center font-weight-bold">Profil Akun</h4>
                    <form method="POST" action="{{ route('company.profile.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Kolom Kiri: Logo -->
                            <div class="col-md-4 text-center">
                                <label for="avatars_company" class="form-label font-weight-bold">Logo Perusahaan :</label>
                                <input type="file" class="form-control mb-3" name="avatars_company">
                                <img src="{{ asset('assets/icon/icon-user.png') }}" class="img-thumbnail mt-2" width="150" alt="{{ $user->name }}">
                            </div>

                            <!-- Kolom Kanan: Informasi Perusahaan -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name_company">Nama Perusahaan :</label>

                                    <input type="text" class="form-control @error('name_company') is-invalid @enderror" id="name_company" name="name_company" value="{{ $user->name }}" />

                                    @error('name_company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email_company">Email Perusahaan :</label>

                                    <input type="email" class="form-control @error('email_company') is-invalid @enderror" id="email_company" name="email_company" value="{{ $user->email }}" />

                                    @error('email_company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone_company">Nomor Handphone :</label>

                                    <input type="text" class="form-control @error('phone_company') is-invalid @enderror" id="phone_company" name="phone_company" value="{{ old('phone_company') }}" placeholder="+628123456789" />

                                    @error('phone_company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="city_company">Kota Perusahaan :</label>

                                    <input type="text" class="form-control @error('city_company') is-invalid @enderror" id="city_company" name="city_company" value="{{ old('city_company') }}" placeholder="Kota Bekasi" />

                                    @error('city_company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="type_of_company">Tipe Perusahaan :</label>

                                    <input type="text" class="form-control @error('type_of_company') is-invalid @enderror" id="type_of_company" name="type_of_company" value="{{ old('type_of_company') }}" placeholder="Teknologi Informasi" />

                                    @error('type_of_company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Baris Baru: Deskripsi & Alamat -->
                        <div class="form-group mt-4">
                            <label for="description_company">Deskripsi Perusahaan :</label>

                            <!-- Hidden textarea -->
                            <textarea name="description_company" id="description_company" class="d-none">
                            {{ old('description_company') }}
                            </textarea>

                            <!-- Quill Editor Container -->
                            <div id="quill_editor_description_company"
                                class="form-control @error('description_company') is-invalid @enderror"
                                style="height: 200px;"></div>

                            @error('description_company')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="address_company">Alamat Perusahaan :</label>

                            <textarea name="address_company" id="address_company" class="d-none">
                            {{ old('address_company') }}
                            </textarea>

                            <div id="quill_editor_address_company"
                                class="form-control @error('address_company') is-invalid @enderror"
                                style="height: 200px;"></div>

                            @error('address_company')
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

<!-- textarea deskripsi perusahaan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Quill
        var quill = new Quill('#quill_editor_description_company', {
            theme: 'snow',
            placeholder: 'Tulis deskripsi perusahaan...',
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
        var summaryInput = document.querySelector('textarea#description_company');
        if (summaryInput.value) {
            quill.clipboard.dangerouslyPasteHTML(summaryInput.value); // Mengatur konten awal editor
        }

        quill.on('text-change', function() {
            summaryInput.value = quill.root.innerHTML;
        });
    });
</script>

<!-- textarea alamat perusahaan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Quill
        var quill = new Quill('#quill_editor_address_company', {
            theme: 'snow',
            placeholder: 'Tulis alamat perusahaan...',
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
        var summaryInput = document.querySelector('textarea#address_company');
        if (summaryInput.value) {
            quill.clipboard.dangerouslyPasteHTML(summaryInput.value); // Mengatur konten awal editor
        }

        quill.on('text-change', function() {
            summaryInput.value = quill.root.innerHTML;
        });
    });
</script>
@endpush