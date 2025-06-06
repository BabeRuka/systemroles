<div class="modal fade" id="AssignPermissionModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="AssignPermissionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase fw-bold">
                    <span id="AssignPermissionModalIcon"><i class="ri-book-open-fill text-primary text-secondary"></i></span>
                    <span id="AssignPermissionModalTitle">Assign Permission</span>
                </h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close" onclick="closeModalById('AssignPermissionModal')"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <div class="col-12">
                        <form action="{{ route('admin.roles.user.assign') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <input type="hidden" name="user_id" id="user_id_assign" value="0">   
                            @csrf
                            @method('POST')
                            <div class="row"> 
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_id" class="form-label"><h3 class="text-primary fs-6 fw-bold " id="AssignPermissionModalHeading"></h3></label>
                                        <select class="form-control" id="role_id_assign" name="role_id" required>  
                                            <option value="0">Select Role...</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->role_id }}">{{ strtoupper($role->role_name) }} Role</option>
                                            @endforeach
                                        </select>
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