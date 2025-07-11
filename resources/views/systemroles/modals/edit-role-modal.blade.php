<div class="modal fade" id="EditRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditRoleModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase fw-bold">
                    <span id="EditRoleModalIcon"><i class="ri-book-open-fill text-primary text-secondary"></i></span>
                    <span id="EditRoleModalTitle">Edit Role</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModalById('EditRoleModal')"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h3 class="text-primary fs-6 fw-bold" id="EditRoleModalHeading"></h3>
                    <div class="col-12">
                        <form action="{{ route('systemroles.admin.roles.update') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('POST')
                            <input type="hidden" name="role_id" id="role_id_edit" value="0">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_name" class="form-label">Role Name</label>
                                        <input type="text" class="form-control" id="role_name_edit" name="role_name" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_guard_name" class="form-label">Guard Name</label>
                                        <input type="text" class="form-control" id="role_guard_name_edit" name="role_guard_name" readonly disabled required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_sequence" class="form-label">Sequence</label>
                                        <input type="number" class="form-control" id="role_sequence_edit" name="role_sequence" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="role_description_edit" name="role_description" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-end">Update Role</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>