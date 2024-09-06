<!-- Default Modals -->
<style>
    #modalDetail .modal-body {
        max-height: 500px;
        /* Atur sesuai tinggi maksimal modal */
        overflow-y: auto;
        /* Mengaktifkan scroll vertikal */
    }

    .profile-user img {
        max-width: 100px;
        /* Pastikan gambar avatar tidak terlalu besar */
        max-height: 100px;
    }

    table {
        width: 100%;
        /* Pastikan tabel menggunakan lebar penuh */
    }
</style>
<div id="modalDetail" class="modal zoomIn" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">
                    Detail Izin Kerja
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                {{-- avatar --}}
                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                    <img src="" class="rounded-circle avatar-xl img-thumbnail profile-img  shadow"
                        id="avatar" alt="profile-img">
                </div>
                <div style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="email"></td>
                        </tr>
                        <tr>
                            <th>No.Telp</th>
                            <td id="phone"></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td id="address"></td>
                        </tr>
                        <tr>
                            <th>Departemen</th>
                            <td id="departement"></td>
                        </tr>
                        <tr>
                            <th>Posisi</th>
                            <td id="position"></td>
                        </tr>
                        <tr>
                            <th>Tanggal Izin Kerja</th>
                            <td id="start_date"></td>
                        </tr>
                        <tr>
                            <th>Alasan Izin Kerja</th>
                            <td id="reason"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="status_lv"></td>
                        </tr>
                        <tr>
                            <th>Diajukan Pada Tanggal</th>
                            <td id="created_at"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#modalDetail').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                $.ajax({
                    url: "{{ route('work-permit.show', '') }}" + '/' + id,
                    type: 'GET',
                    success: function(response) {
                        let data = response.data;

                        console.log(data);

                        let status = data.status;
                        if (status == 'pending') {
                            status =
                                ' <span class="badge rounded-pill bg-warning-subtle text-warning">SEDANG DI PROSES</span>';
                        } else if (status == 'approved') {
                            status =
                                ' <span class="badge rounded-pill bg-success-subtle text-success">DISETUJUI</span>';
                        } else if (status == 'rejected') {
                            status =
                                ' <span class="badge rounded-pill bg-danger-subtle text-danger">DITOLAK</span>';
                        }
                        modal.find('#name').text(data.name);
                        modal.find('#email').text(data.email);
                        modal.find('#reason').text(data.reason);
                        modal.find('#phone').text(data.phone);
                        modal.find('#address').text(data.address);
                        modal.find('#departement').text(data.department);
                        modal.find('#position').text(data.position);
                        modal.find('#avatar').attr('src', data.avatar);
                        modal.find('#start_date').text(data.start_date + ' s/d ' + data
                            .end_date + ' (' + data.days + ' Hari )');
                        modal.find('#reason').text(data.reason);
                        modal.find('#status_lv').html(status);
                        modal.find('#created_at').text(data.created_at);
                    },
                    error: function(xhr) {
                        let error = response.responseJSON;
                        Swal.fire({
                            title: 'Error!',
                            text: error.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endpush
