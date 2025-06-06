@inject('roles', 'BabeRuka\SystemRoles\Models\SystemRoles')
@extends('layouts.admin')
@section('title', 'Roles')
@section('breadcrumbs')
<ol class="breadcrumb my-0">
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active"><span>{{ $systemRole->role_name }}</span></li>
</ol>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('addons/datatables/bootstrap5/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('addons/datatables/bootstrap5/css/datatables.min.css') }}">

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
                            <i class="fa fa-solid fa-align-justify"></i> {{ $systemRole->role_name }}
                        </h5>
                        <div>

                            <a class="btn btn-primary text-light waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                                <i class="fa fa-plus"></i> <span class="ms-1">Add Permission</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="body">
                            <table class="table table-responsive-sm table-condensed table-striped js-exportable" id="roles-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Permission Name</th>
                                        <th>Permission Key</th>
                                        <th>Permission</th>
                                        <th>Sequence</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permissions as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->in_name }}</td>
                                        <td><badge class="badge bg-info p-2">{{ strtoupper($role->in_guard_name) }}</badge></td>
                                        <td><badge class="badge {{ $role->in_role=='1' ? 'bg-success' : 'bg-danger' }} p-2">{{ strtoupper($role->in_role=='1' ? 'Yes' : 'No') }}</badge></td>
                                        <td>{{ $role->in_sequence }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-3">
                                                @if($loop->iteration > 1)   
                                                <a class="float-end" href="{{ route('admin.roles.permissions.up', ['in_id' => $role->in_id]) }}" >
                                                    <i class="ri-arrow-up-circle-fill text-success"></i>
                                                </a>
                                                @endif
                                                @if($loop->iteration < count($permissions))
                                                <a class="float-end" href="{{ route('admin.roles.permissions.down', ['in_id' => $role->in_id]) }}" >
                                                    <i class="ri-arrow-down-circle-fill text-success"></i>
                                                </a>
                                                @endif  
                                                <a class="float-end"
                                                    onclick="addInputToElement('in_id_edit', '{{ $role->in_id }}'),
                                                    addInputToElement('role_id_in_edit', '{{ $role->role_id }}'),
                                                    addInputToElement('in_name_edit', '{{ $role->in_name }}'),
                                                    addInputToElement('in_guard_name_edit', '{{ $role->in_guard_name }}'),
                                                    addInputToElement('in_role_edit', '{{ $role->in_role }}'),
                                                    addInputToElement('in_sequence_edit', '{{ $role->in_sequence }}')"
                                                    data-id="{{ $role->in_id }}"
                                                    data-name="{{ $role->in_name }}"
                                                    data-guard="{{ $role->in_guard_name }}"
                                                    data-sequence="{{ $role->in_sequence }}"
                                                    data-bs-toggle="modal" data-bs-target="#editPermissionModal" href="#editPermissionModal">
                                                    <i class="ri-edit-circle-fill text-primary"></i>
                                                </a>
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
@include('systemroles.modals.add-permission-modal')
@include('systemroles.modals.edit-permission-modal')
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
    function updateGuardName() {
        const inName = document.getElementById('in_name').value;
        const inGuardName = document.getElementById('in_guard_name');
        inGuardName.value = inName.toLowerCase().replace(/ /g, '_');
    }
    $(document).ready(function() {
        $('#roles-table').DataTable();
    });
    function moveInUp(in_id) {
        $.ajax({
            url: "{{ route('admin.roles.permissions.up') }}",
            type: "POST",
            data: { in_id: in_id },
            success: function(response) {
                console.log(response);
            }
        });
    }   
    function moveInDown(in_id) {
        $.ajax({
            url: "{{ route('admin.roles.permissions.down') }}",
            type: "POST",
            data: { in_id: in_id },
            success: function(response) {
                console.log(response);
            }
        });
    }       
    
</script>
@endsection