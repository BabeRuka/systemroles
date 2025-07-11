<div class="modal fade" id="AddRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AddRoleModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase fw-bold">
                    <span id="AddRoleModalIcon"><i class="ri-book-open-fill text-primary text-secondary"></i></span>
                    <span id="AddRoleModalTitle">Add Role</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModalById('AddRoleModal')"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h3 class="text-primary fs-6 fw-bold" id="AddRoleModalHeading"></h3>
                    <div class="col-12">
                        <form action="{{ route('systemroles.admin.roles.store') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_name" class="form-label">Role Name</label>
                                        <input type="text" class="form-control" id="role_name" name="role_name" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_guard_name" class="form-label">Guard Name</label>
                                        <input type="text" class="form-control" id="role_guard_name" name="role_guard_name" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_sequence" class="form-label">Sequence</label>
                                        <input type="number" class="form-control" id="role_sequence" name="role_sequence" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="role_description" name="role_description" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-end">Save Role</button>
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