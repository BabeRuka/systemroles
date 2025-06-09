@inject('roles', 'BabeRuka\SystemRoles\Models\SystemRoles')
@extends('vendor.systemroles.layouts.admin')
@section('title', 'Roles')
@section('breadcrumbs')
<ol class="breadcrumb my-0">
    <li class="breadcrumb-item"><a href="{{ route('systemroles.admin.roles') }}">Dashboard</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('systemroles.admin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('systemroles.admin.roles.classes.index') }}">Classes</a></li>
    <li class="breadcrumb-item active"><span>Manage Class Access</span></li>
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
                        <h5 class="card-title fw-bold">
                            <i class="fa fa-solid fa-align-justify"></i> {{ $class->class_name }} [{{ $class->class_namespace }}] 
                        </h5>
                        <div> 
                        </div>
                    </div>
                    <form id="ManageClassAccessForm" method="POST" action="{{ route('systemroles.admin.roles.classes.in.store') }}" class="form-horizontal needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->class_id }}">
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <div id="error-message" class="alert alert-danger d-none" role="alert">
                                <i class="fa fa-exclamation-triangle"></i>
                                Please select at least one option for each role.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <table class="table table-responsive-sm table-condensed table-striped js-exportable" id="roles-in-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Guardname</th>
                                        <th>Manage</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($all_roles as $role)
                                    <?php
                                        $found = $class_roles->where('role_id', $role->role_id);
                                        if($found!= null && $found->count() > 0) {
                                            $in_role = $found->first()->in_role;
                                        } else {
                                            $in_role = 0; // Default value if not found
                                        }
                                    ?>
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->role_name }}</td>
                                        <td><badge class="badge bg-info p-2">{{ $role->role_guard_name }}</badge></td>  
                                        <td class="text-center">
                                            <input type="hidden" name="role_id[{{ $role->role_id }}]" value="{{ $role->role_id }}">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="in_role[{{ $role->role_id }}]" value="1" id="role_{{ $role->role_id }}_1" {{ $in_role == 1 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="role_{{ $role->role_id }}_1">Grant Access</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="in_role[{{ $role->role_id }}]" value="0" id="role_{{ $role->role_id }}_0" {{ $in_role == 0 ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="role_{{ $role->role_id }}_0">Revoke Access</label>
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
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary float-end mt-1 mb-3" value="Save Class Access">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 
@endsection
@section('javascript')
<script src="{{ asset('vendor/systemroles/addons/datatables/bootstrap5/js/datatables.min.js') }} "></script>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("ManageClassAccessForm").addEventListener("submit", function (event) {
            let isValid = true;
            let errorMessage = "Please select at least one option for each role.";
            const errorMessageElement = document.getElementById('error-message');
            errorMessageElement.classList.add('d-none'); // Hide error message initially
            errorMessageElement.textContent = errorMessage; // Set the error message text
            const roleRows = document.querySelectorAll("#roles-table tbody tr");
            roleRows.forEach(row => {
                const radioGroupName = row.querySelector("input[type='radio']").name; // Get name attribute
                const checkedRadio = row.querySelector(`input[name='${radioGroupName}']:checked`);

                if (!checkedRadio) {
                    isValid = false;
                    row.classList.add("table-danger"); 
                } else {
                    row.classList.remove("table-danger"); 
                    document.getElementById('ManageClassAccessForm').submit();
                }
            });

            if (!isValid) {
                event.preventDefault();
                errorMessageElement.classList.remove('d-none'); 
            }
        });
    });
    
    $(document).ready(function() {
        $('#roles-in-table').DataTable();
    });
</script>
@endsection
