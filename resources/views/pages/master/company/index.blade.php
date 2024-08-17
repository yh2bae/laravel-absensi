@extends('layouts.app')

@section('content')
    <form action="{{ route('company.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Profil Perusahaan
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="input nama perusahaan"
                                        value="{{ $company->name ?? '-' }}">
                                    @error('name')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Input email" value="{{ $company->email ?? '' }}">
                                    @error('email')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" placeholder="Input alamat"
                                        value="{{ $company->address ?? '' }}">
                                    @error('address')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="radius_km" class="form-label">Radius KM</label>
                                    <input type="text" class="form-control @error('radius_km') is-invalid @enderror"
                                        id="radius_km" name="radius_km" placeholder="Input radius"
                                        value="{{ $company->radius_km ?? '' }}">
                                    @error('radius_km')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                        id="latitude" name="latitude" placeholder="Input latitude"
                                        value="{{ $company->latitude ?? '' }}">
                                    @error('latitude')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                        id="longitude" name="longitude" placeholder="Input longitude"
                                        value="{{ $company->longitude ?? '' }}">
                                    @error('longitude')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="time_in" class="form-label">Waktu Masuk</label>
                                    <input type="text" class="form-control @error('time_in') is-invalid @enderror"
                                        id="time_in" name="time_in" placeholder="Input waktu masuk"
                                        value="{{ $company->time_in ?? '' }}" data-provider="timepickr"
                                        data-time-hrs="true">
                                    @error('time_in')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="time_out" class="form-label">Waktu Keluar</label>
                                    <input type="text" class="form-control @error('time_out') is-invalid @enderror"
                                        id="time_out" name="time_out" placeholder="Input waktu keluar"
                                        value="{{ $company->time_out ?? '' }}" data-provider="timepickr"
                                        data-time-hrs="true">
                                    @error('time_out')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    Update
                                </button>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type='text/javascript' src='{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}'></script>
    <script>
        $(document).ready(function() {
            $('input[name="radius_km"]').on('input', function() {
                // this.value = this.value.replace(/[^0-9]/g, '');
                this.value = this.value.replace(/[^0-9.]/g, '');
            });

        });
    </script>
@endpush
