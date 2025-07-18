<div class="modal fade" id="addPermissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <form id="permForm" action="{{ route('systemroles.admin.roles.permissions.store') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="role_id" id="role_id" value="{{ $systemRole->role_id }}"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModalById('addPermissionModal')"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="in_name" class="form-label">Permission Name</label>
                        <input type="text" name="in_name" id="in_name" class="form-control" required onmouseout="updateGuardName()">
                    </div>
                    <div class="mb-3">
                        <label for="in_guard_name" class="form-label">Guard Name</label>
                        <input type="text" name="in_guard_name" id="in_guard_name" class="form-control" required onmouseout="updateGuardName()">
                    </div>
                    <div class="mb-3">
                        <label for="in_role" class="form-label">Permission</label>
                        <select name="in_role" id="in_role" class="form-control">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>   
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success float-end">Save</button> 
                </div>
            </div>
        </form>
    </div>
</div>