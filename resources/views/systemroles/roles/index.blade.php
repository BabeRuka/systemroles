@inject('roles', 'BabeRuka\SystemRoles\Models\SystemRoles')
@extends('vendor.systemroles.layouts.admin')
@section('title', 'Roles')
@section('breadcrumbs')
<ol class="breadcrumb my-0">
    <li class="breadcrumb-item"><a href="{{ route('systemroles.admin.roles') }}">Dashboard</a></li>
    <li class="breadcrumb-item active"><span>Roles</span></li>
</ol>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('addons/datatables/bootstrap5/css/datatables.min.css') }}">

@endsection
@php
//dd($systemRoles);
@endphp
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-uppercase fw-bold">
                            <i class="fa fa-solid fa-align-justify"></i> All Roles
                        </h5>
                        <div>

                            <a class="btn btn-primary text-light waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#AddRoleModal">
                                <i class="fa fa-plus"></i> <span class="ms-1">Add Role</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="body">
                            <table class="table table-responsive-sm table-condensed table-striped js-exportable" id="roles-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
                                        <th>Guard</th>
                                        <th># of Users</th>
                                        <th>Permissions</th>
                                        <th>Sequence</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($systemRoles as $role)
                                    <?php
                                    $user_role_num = $user_roles->where('role_id', $role->role_id);
                                    if($user_role_num!==null){
                                        $user_role_count = count($user_role_num);
                                    }else{
                                        $user_role_count = 0;
                                    }
                                    ?>
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->role_name }}</td>
                                        <td><badge class="badge bg-info p-2">{{ $role->role_guard_name }}</badge></td>
                                        <td><span class="badge bg-info p-2">{{ $user_role_count }} users</span>  </td>
                                        <td>
                                            @foreach($role->permissions as $permission)
                                            <badge class="badge badge-pill {{ $permission->in_role == 1 ? 'bg-success' : 'bg-danger' }} p-1">{{ $permission->in_name }}</badge>
                                            @endforeach
                                        </td>
                                        <td>{{ $role->role_sequence }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="{{ route('systemroles.admin.roles.manage', ['role_id' => $role->role_id]) }}" class="float-start">
                                                    <i class="ri-add-circle-fill text-primary"></i>
                                                </a>

                                                <a class="float-end"
                                                onclick="addInputToElement('role_id_edit', '{{ $role->role_id }}'),
                                                    addInputToElement('role_name_edit', '{{ $role->role_name }}'),
                                                    addInputToElement('role_guard_name_edit', '{{ $role->role_guard_name }}'),
                                                    addInputToElement('role_sequence_edit', '{{ $role->role_sequence }}')"
                                                    data-id="{{ $role->role_id }}"
                                                    data-name="{{ $role->role_name }}"
                                                    data-guard="{{ $role->role_guard_name }}"
                                                    data-sequence="{{ $role->role_sequence }}"
                                                    data-bs-toggle="modal" data-bs-target="#EditRoleModal" href="#EditRoleModal"><i class="ri-edit-circle-fill text-primary"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No roles found</td>
                                    </tr>
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
@include('vendor.systemroles.modals.add-role-modal')
@include('vendor.systemroles.modals.edit-role-modal')

@endsection
@section('javascript')
<script src="{{ asset('addons/datatables/bootstrap5/js/datatables.min.js') }} "></script>
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