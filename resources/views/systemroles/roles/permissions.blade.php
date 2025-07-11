@inject('roles', 'BabeRuka\SystemRoles\Models\SystemRoles')
@extends('vendor.systemroles.layouts.admin')
@section('title', 'Roles')
@section('breadcrumbs')
<ol class="breadcrumb my-0">
    <li class="breadcrumb-item"><a href="{{ route('systemroles.admin.roles') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('systemroles.admin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active"><span>Permissions</span></li>
</ol>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('vendor/systemroles/addons/datatables/bootstrap5/css/datatables.min.css') }}">
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
                            <i class="fa fa-solid fa-align-justify"></i> All Permissions
                        </h5>
                        <div>

                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="body">
                            <table class="table table-responsive-sm table-condensed table-striped js-exportable" id="roles-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role</th>   
                                        <th>Permission Name</th>
                                        <th>Permission Key</th>
                                        <th>Permission</th>
                                        <th>Sequence</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($permissions as $role)
                                    @php
                                    $user_roles = $role->systemRoles;
                                    @endphp 
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->role->role_name }}</td>
                                        <td>{{ $role->in_name }}</td>
                                        <td><badge class="badge bg-info p-2">{{ strtoupper($role->in_guard_name) }}</badge></td>
                                        <td><badge class="badge {{ $role->in_role=='1' ? 'bg-success' : 'bg-danger' }} p-2">{{ strtoupper($role->in_role=='1' ? 'Yes' : 'No') }}</badge></td>
                                        <td>{{ $role->in_sequence }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-3">
                                                @if($loop->iteration > 1)   
                                                <a class="float-end" href="{{ route('systemroles.admin.roles.permissions.up', ['in_id' => $role->in_id]) }}" >
                                                    <i class="ri-arrow-up-circle-fill text-success"></i>
                                                </a>
                                                @endif
                                                @if($loop->iteration < count($permissions))
                                                <a class="float-end" href="{{ route('systemroles.admin.roles.permissions.down', ['in_id' => $role->in_id]) }}" >
                                                    <i class="ri-arrow-down-circle-fill text-success"></i>
                                                </a>
                                                @endif  
                                                 
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
            url: "{{ route('systemroles.admin.roles.permissions.up') }}",
            type: "POST",
            data: { in_id: in_id },
            success: function(response) {
                console.log(response);
            }
        });
    }   
    function moveInDown(in_id) {
        $.ajax({
            url: "{{ route('systemroles.admin.roles.permissions.down') }}",
            type: "POST",
            data: { in_id: in_id },
            success: function(response) {
                console.log(response);
            }
        });
    }       
    
</script>
@endsection