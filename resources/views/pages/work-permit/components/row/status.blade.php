@if($item['status'] == 'pending')
    <span class="badge rounded-pill bg-warning-subtle text-warning">SEDANG DI PROSES</span>
@elseif($item['status'] == 'approved')
    <span class="badge rounded-pill bg-success-subtle text-success">TELAH DISETUJUI</span>
@elseif($item['status'] == 'rejected')
    <span class="badge rounded-pill bg-danger-subtle text-danger">TIDAK DISETUJUI</span>
@endif