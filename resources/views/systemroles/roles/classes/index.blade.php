@inject('roles', 'BabeRuka\SystemRoles\Models\SystemRoles')
@extends('vendor.systemroles.layouts.admin')
@section('title', 'Roles')
@section('breadcrumbs')
<ol class="breadcrumb my-0">
    <li class="breadcrumb-item"><a href="{{ route('systemroles.admin.roles') }}">Dashboard</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('systemroles.admin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active"><span>Classes</span></li>
</ol>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('vendor/systemroles/addons/datatables/bootstrap5/css/datatables.min.css') }}">

@endsection
@php
@endphp
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-uppercase fw-bold">
                            <i class="fa fa-solid fa-align-justify"></i> All Classes
                        </h5>
                        <div>

                            <a class="btn btn-primary text-light waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#ConfirmModal">
                                <i class="fa fa-plus"></i> <span class="ms-1">Add Class Access</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-sm table-condensed table-striped js-exportable" id="roles-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Namespace</th>
                                        <th>Filename</th>
                                        <th>Description</th>
                                        <th># of Class Access</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($all_classes as $class)
                                    <?php
                                        $class_role = $class_roles->where('class_id',$class->class_id);
                                        if($class_role != null && $class_role->count() > 0) {
                                            $class_access = $class_role->count();
                                        } else {
                                            $class_access = 0; // Default to 0 if not found
                                        }
                                    ?>
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $class->class_name }}</td>
                                        <td><badge class="badge bg-info p-2">{{ $class->class_namespace }}</badge></td> 
                                        <td>{{ $class->class_filename }}</td>
                                        <td>{{ $class->class_description }}</td>
                                        <td>{{ $class_access }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="{{ route('systemroles.admin.roles.classes.manage', ['class_id' => $class->class_id]) }}" class="float-start" title="Manage {{ $class->class_name }} Roles">
                                                    <i class="ri-add-circle-fill text-primary"></i>
                                                </a> 
                                            </div>
                                        </td>
                                    </tr>
                                    @empty 
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
@include('vendor.systemroles.modals.confirm-modal') 

@endsection
@section('javascript')
<script src="{{ asset('vendor/systemroles/addons/datatables/bootstrap5/js/datatables.min.js') }} "></script>
<script>
    window.closeModalById = function(modalId) {
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            // Get or create the Bootstrap Modal instance for the given ID
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide(); // Hide the modal
            } else {
                console.warn(`Bootstrap Modal instance not found for ID: ${modalId}`);
            }
        } else {
            console.warn(`Modal element not found for ID: ${modalId}`);
        }
    };
 


    $(document).ready(function() {
        $('#roles-table').DataTable();
    });
</script>
@endsection