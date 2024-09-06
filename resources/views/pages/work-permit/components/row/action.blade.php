<div class="dropdown d-inline-block">
    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri-more-fill align-middle"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a href="javascript:void(0);" class="dropdown-item" data-id="{{ $item['id'] }}" data-bs-toggle="modal"
                data-bs-target="#modalDetail" aria-controls="modalDetail">
                <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                Detail
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="dropdown-item edit-item-btn" data-id="{{ $item['id'] }}"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasEdit" aria-controls="offcanvasEdit">
                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                Update
            </a>
        </li>
    </ul>
</div>
