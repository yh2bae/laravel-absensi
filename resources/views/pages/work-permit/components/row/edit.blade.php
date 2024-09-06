<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit" aria-labelledby="offcanvasEditLabel"
    data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasEditLabel">
            <div>
                <h5 class="fs-16 fw-bold">
                    Edit Status
                </h5>
                <small class="fs-12 text-muted">
                    Edit Status izin kerja
                </small>
            </div>
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Loading Indicator -->
        <div id="loadingIndicator"
            style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <form action="javascript:void(0)" id="formEdit">
            @csrf
            <input type="hidden" name="id" id="id">
            <div class="mb-3">
                <label class="form-label">
                    Status
                </label>
                <select class="js-example-basic-single" name="status" id="status">
                    <option></option>
                    @php
                        // Definisikan array status di luar foreach
                        $statusMap = [
                            'approved' => 'disetujui',
                            'pending' => 'diproses',
                            'rejected' => 'ditolak',
                        ];
                    @endphp
                    @foreach ($statuses as $statusKey)
                        @php
                            // Ambil nilai status dari array statusMap
                            $statusValue = $statusMap[$statusKey] ?? $statusKey;
                        @endphp
                        <option value="{{ $statusKey }}"
                            {{ old('status', $workPermit->status ?? '') == $statusKey ? 'selected' : '' }}>
                            {{ ucfirst($statusValue) }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback mt-2"></div>
            </div>
        </form>
    </div>
    <div class="offcanvas-foorter border p-3 text-center">
        <div class="gap-2 d-flex align-items-center">
            <button type="submit" id="submitUpdate" class="btn btn-primary w-50">
                Simpan
            </button>
            <a href="javascript:void(0);" class="btn btn-danger w-50" data-bs-dismiss="offcanvas">
                Batal
            </a>
        </div>
    </div>
</div>

@push('css')
    <link href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).on('click', '[data-bs-target="#offcanvasEdit"]', function() {
            var offcanvasEdit = document.getElementById('offcanvasEdit');

            $('#offcanvasEdit').find('#status').select2({
                dropdownParent: $('#offcanvasEdit'),
                placeholder: 'Pilih Status',
            });

            $('#loadingIndicator').show();
            $('#formEdit').hide();
            $('#submitUpdate').attr('disabled', true);

            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('work-permit.show', '') }}" + '/' + id,
                type: 'GET',
                success: function(response) {
                    let data = response.data;

                    $('#offcanvasEdit').find('#id').val(data.id);
                    $('#offcanvasEdit').find('#status').val(data.status).trigger(
                        'change');

                    $('#loadingIndicator').hide();
                    $('#formEdit').show();
                    $('#submitUpdate').attr('disabled', false);
                },
                error: function(xhr) {
                    let error = xhr.responseJSON;
                    Swal.fire({
                        title: 'Error!',
                        text: error.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('#submitUpdate').off('click').on('click', function() {
            var formData = {
                id: $('#offcanvasEdit').find('#id').val(),
                status: $('#offcanvasEdit').find('#status').val(),
                _token: $('input[name="_token"]').val()
            };

            var resetForm = () => {
                $('#offcanvasEdit').find('#status').val('').trigger('change').removeClass('is-invalid')
                    .siblings('.invalid-feedback').html('');
            };

            $.ajax({
                url: "{{ route('work-permit.update', '') }}" + '/' + formData.id,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
                        buttonsStyling: false,
                        showCloseButton: true
                    });

                    resetForm();
                    $('#offcanvasEdit').offcanvas('hide');
                    $('#datatables').DataTable().ajax.reload();
                },
                error: function(response) {
                    let error = response.responseJSON;

                    if (error.errors) {
                        if (error.errors.status) {
                            $('#offcanvasEdit').find('#status').addClass('is-invalid').siblings(
                                '.invalid-feedback').html(error.errors.status);
                        }
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: error.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    </script>
@endpush
