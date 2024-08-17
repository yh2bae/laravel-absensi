@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">
                            Buat Password Baru
                        </h5>
                        <p class="text-muted">
                            Buat password baru untuk akun Anda dengan mengisi form di bawah ini.
                        </p>
                    </div>
                    <div class="p-2 mt-4">
                        @if (session('error'))
                            <h4 class="fs-14 fw-bold text-danger">{{ session('error') }}</h4>
                        @endif
                        <form action="{{ route('password.update', $token) }}"method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label" for="password-input">
                                    Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input"
                                        placeholder="Input Password" id="password-input" name="password">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                                @error('password')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password-input">
                                    Konfirmasi Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input"
                                        placeholder="Ulangi Password" id="password-input" name="password_confirmation">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                                @error('password_confirmation')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

        </div>
    </div>
@endsection
