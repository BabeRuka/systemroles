<div class="modal fade" id="ConfirmModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="ConfirmModalTitle" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase fw-bold">
                    <span id="ConfirmModalIcon"><i class="ri-book-open-fill text-primary text-secondary"></i></span>
                    <span id="ConfirmModalTitle">Add Class Access</span>
                </h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close" onclick="closeModalById('ConfirmModal')"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h3 class="text-primary fs-6 fw-bold" id="ConfirmModalHeading"></h3>
                    <div class="col-12">
                        <form action="{{ route('admin.roles.classes.in.init') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-12 mb-3">
                                     <p>
                                        Are you sure you want to add class access? This will add a permission to all the classes.
                                    </p>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <button type="submit" class="btn btn-primary float-end">Add Class Access</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>