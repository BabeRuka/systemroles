@extends('vendor.systemroles.layouts.admin')
@section('title', 'Users')
@section('breadcrumbs')
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{ route('systemroles.admin.roles') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><span>Users</span></li>
    </ol>    
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/systemroles/addons/datatables/bootstrap5/css/datatables.min.css') }}">

@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-uppercase fw-bold">
                                <i class="fa fa-solid fa-align-justify"></i> All Users
                            </h5> 
                        </div> 
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-responsive-sm table-condensed table-striped js-exportable"
                                        id="datatables">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>E-mail</th>
                                                <th>Role</th> 
                                                <th>Register Date</th> 
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('vendor.systemroles.modals.assign-permission-modal')
    @endsection


    @section('javascript')
        <script src="{{ asset('vendor/systemroles/addons/datatables/bootstrap5/js/datatables.min.js') }} "></script>
        <script src="{{ asset('vendor/systemroles/addons/dropify/js/dropify.min.js') }}"></script>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function() {
                $('#datatables').DataTable({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    ajax: ({
                        type: "POST",
                        url: '{{ route('systemroles.admin.roles.users.userdata') }}'
                    }),
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    dom: 'Blfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    serverSide: true,
                    processing: true,
                    orderable: false,
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role_name',
                            name: 'role_name',
                            render: function(data, type, row) { 
                                try { 
                                    let parsed = JSON.parse(row.role_name);
                                    return parsed.role_name;  
                                } catch (e) { 
                                    return row.role_name;
                                }
                            }
                        },
                        
                        
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        }, 
                         
                        {
                            data: 'perm',
                            name: 'perm',
                            render: function(data, type, row) { 
                                var role_id = parseInt(row.role_id) || 0; 
                                var user_id = parseInt(row.id) || 0;
                                var user_permissions = row.user_permissions;
                                var updatePermission = user_permissions.Update;
                                var managePermission = user_permissions.Manage;
                                if(user_id==1){
                                    managePermission = 1; // Super Admin always has manage permission
                                }
                                console.log(role_id+' '+row.id+' '+updatePermission+' '+managePermission);
                                var manage_user = '<a href="https://dev.tradewave.cloud/profilehub/admin/users/user?id='+row.id+'" class="" data-toggle="tooltip" data-placement="top" title="View"> <i class="ri-cursor-fill"></i> </a>';
                                var assign_permission = '<a data-bs-toggle="modal" href="#AssignPermissionModal" data-bs-target="#AssignPermissionModal" title="Assign Permission"  onClick="addInputToElement(\'role_id_assign\', \'' + role_id + '\'),addInputToElement(\'user_id_assign\', \'' + row.id + '\'),addTextToElement(\'AssignPermissionModalHeading\', \'Assign Permission for ' + row.name + '\')" type="button"  class="tooltip-trigger"> <i class="ri-lock-unlock-line text-primary"></i> </a>';
                                return managePermission == 1 ? manage_user + ' ' + assign_permission : '';
                            }
                        } 
                          
                    ]
                });
            });

             
            function changePerm(id, title) {
                document.getElementById('perm_user').value = id;
                document.getElementById('permModalTitle').innerHTML = "Change " + title + "'s Password";
            }
            
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

            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            $('#pwdId, #cPwdId').on('keyup', function() {
                                if ($('#pwdId').val() != '' && $('#cPwdId').val() != '' &&
                                    $('#pwdId').val() == $('#cPwdId').val()) {
                                    $("#saveProfile").attr("disabled", false);
                                    $('#cPwdValid').show();
                                    $('#cPwdInvalid').hide();
                                    $('#cPwdValid').html('Valid').css('color', 'green');
                                    $('.pwds').removeClass('is-invalid')
                                } else {
                                    $("#saveProfile").attr("disabled", true);
                                    $('#cPwdValid').hide();
                                    $('#cPwdInvalid').show();
                                    $('#cPwdInvalid').html('Not Matching').css('color',
                                        'red');
                                    $('.pwds').addClass('is-invalid');
                                    //event.preventDefault();
                                    //event.stopPropagation();
                                }
                            });
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
            function editUserDetails(details_id, user_id, name, username, firstname, lastname, middle_name,
                user_bio, profile_pic, user_avatar) {

                const decodedUserBio = decodeURIComponent(user_bio);
                const decodedUserName = decodeURIComponent(name);
                document.getElementById('addUserDetailsTitle').innerHTML = 'Edit User Details - ' + decodedUserName;

                const new_details_id = parseInt(details_id);
                console.log(new_details_id);
                if (isZeroOrLess(new_details_id)) {
                    document.getElementById('details_id').value = '';
                    document.getElementById('user_id_details_id').value = '';
                    document.getElementById('username').value = '';
                    document.getElementById('firstname').value = '';
                    document.getElementById('lastname').value = '';
                    document.getElementById('middle_name').value = '';
                    document.getElementById('user_bio').value = '';
                    return true;
                }else{
                    document.getElementById('details_id').value = details_id;
                    document.getElementById('user_id_details_id').value = user_id;
                    document.getElementById('username').value = username;
                    document.getElementById('firstname').value = firstname;
                    document.getElementById('lastname').value = lastname;
                    document.getElementById('middle_name').value = middle_name;
                    document.getElementById('user_bio').value = decodedUserBio;
                    //document.getElementById('profile_pic').value = profile_pic;
                    //document.getElementById('user_avatar').value = user_avatar;
                }
            }
            function isZeroOrLess(number) {
                return number <= 0;
            }
            $('#addUserField').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var fieldname = button.data('fieldname');
                var fieldid = button.data('fieldid');
                var typefield = button.data('typefield');
                var group_name = button.data('groupname');
                document.getElementById('field_id').value = (fieldid === undefined || fieldid === null) ? '' : fieldid;
                document.getElementById('translation').value = (fieldname === undefined || fieldname === null) ? '' :
                    fieldname;
                document.getElementById('type_field').value = (typefield === undefined || typefield === null) ? '' :
                    typefield;
                document.getElementById('group_id').value = (typefield === undefined || typefield === null) ? '' :
                    group_name;

                var modal = $(this);
                var title_msg = (fieldname === undefined || fieldname === null) ? 'Add user field name' : 'Editing ' +
                    fieldname + '';
                document.getElementById('addUserFieldTitle').innerHTML = title_msg;
            });
            $('#addUserFieldSon').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var fieldname = button.data('fieldname');
                var fieldid = button.data('fieldid');
                var son_id = button.data('sonid');
                document.getElementById('son_id').value = (son_id === undefined || son_id === null) ? '' : son_id;
                document.getElementById('field_id').value = (fieldid === undefined || fieldid === null) ? '' : fieldid;
                document.getElementById('translation').value = (fieldname === undefined || fieldname === null) ? '' :
                    fieldname;
                var modal = $(this);
                document.getElementById('modalTitle').innerHTML = (fieldname === undefined || fieldname === null) ?
                    'Add user field name' : 'Editing ' + fieldname + '';
            });
            $('#addUserGroup').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var fieldname = button.data('fieldname');
                var fieldid = button.data('fieldid');
                var typefield = button.data('typefield');
                document.getElementById('group_id').value = (fieldid === undefined || fieldid === null) ? '' : fieldid;
                document.getElementById('group_name').value = (fieldname === undefined || fieldname === null) ? '' :
                    fieldname;
                var modal = $(this);
                var title_msg = (fieldname === undefined || fieldname === null) ? 'Add user field name' : 'Editing ' +
                    fieldname + '';
                document.getElementById('addUserGroupTitle').innerHTML = title_msg;
            });
            $('#addCategory').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var categoryid = button.data('categoryid');
                var categorypath = button.data('categorypath');
                var categoryparent = button.data('categoryparent');
                var categoryname = button.data('categoryname');
                var categorydesc = button.data('categorydesc');
                var categorylevel = button.data('categorylevel');
                document.getElementById('category_name').value = (categoryname === undefined || categoryname === null) ?
                    '' : categoryname;
                document.getElementById('category_id').value = (categoryid === undefined || categoryid === null) ? '' :
                    categoryid;
                document.getElementById('category_parent').value = (categoryparent === undefined || categoryparent ===
                    null) ? '' : categoryparent;
                document.getElementById('category_level').value = (categorylevel === undefined || categorylevel ===
                    null) ? '' : categorylevel;
                document.getElementById('category_description').value = (categorydesc === undefined || categorydesc ===
                    null) ? '' : categorydesc;
                var modal = $(this);
                var title_msg = (categoryid === undefined || categoryid === null) ? 'Add Category' : 'Editing ' +
                    categoryname + '';
                document.getElementById('addCatTitle').innerHTML = title_msg;
            });
            $('#all_user_id').click(function(event) {
                if (this.checked) {
                    // Iterate each checkbox
                    $(':checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });
            $(document).on("click", ".routeGo", function(e) {
                var button = $(e.relatedTarget);
                var url = $(this).data('url');
                var msg = $(this).data('msg');
                bootbox.confirm({
                    message: (msg ? '' + msg + '' : 'Please confirm delete!'),
                    centerVertical: true,
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success active ml-3'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger active'
                        }
                    },
                    callback: function(result) {
                        console.log(result);
                        if (result == true) {
                            routeGo('' + url + '');
                        }
                    }
                });
            });
            //DeleteAnything
            $(document).on("click", ".DeleteAnything", function(e) {
                var button = $(e.relatedTarget);
                var fieldid = $(this).data('fieldid');
                var formid = $(this).data('formid');
                var rowid = $(this).data('rowid');
                var msg = $(this).data('msg');
                document.getElementById('' + rowid + '').value = fieldid;
                bootbox.confirm({
                    message: (msg ? '' + msg + '' : 'Please confirm delete!'),
                    centerVertical: true,
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success active ml-3'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger active'
                        }
                    },
                    callback: function(result) {
                        console.log(result);
                        if (result == true) {
                            document.getElementById('' + formid + '').submit();
                        }
                    }
                });
            });
            $(document).on("click", ".upAnything", function(e) {
                var button = $(e.relatedTarget);
                var key_id = $(this).data('key_id');
                //var formid = $(this).data('formid');
                var key_name = $(this).data('key_name');
                var group_key = $(this).data('group_key');
                var group_key1 = $(this).data('group_key1');
                document.getElementById('' + group_key + '').value = key_name;
                document.getElementById('' + group_key1 + '').value = key_id;
            });
            $(document).on("click", ".DeleteUserField", function(e) {
                var button = $(e.relatedTarget);
                var fieldid = $(this).data('fieldid');
                var msg = $(this).data('msg');
                bootbox.confirm({
                    message: (msg ? '' + msg + '' : 'Please confirm delete!'),
                    centerVertical: true,
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success active ml-3'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger active'
                        }
                    },
                    callback: function(result) {
                        console.log(result);
                        if (result == true) {
                            document.getElementById('' + fieldid + '').submit();
                        }
                    }
                });
            });
            $(document).on("click", ".courseUserSub", function(e) {
                var button = $(e.relatedTarget);
                var fieldid = $(this).data('fieldid');
                var msg = $(this).data('msg');
                var courseid = $(this).data('courseid');
                var userid = $(this).data('userid');
                var level = $(this).data('level');

                if (level == 700) {
                    bootbox.confirm({
                        message: (msg ? '' + msg + '' : 'Please confirm delete!'),
                        centerVertical: true,
                        buttons: {
                            confirm: {
                                label: 'Yes',
                                className: 'btn-success active ml-3'
                            },
                            cancel: {
                                label: 'No',
                                className: 'btn-danger active'
                            }
                        },
                        callback: function(result) {
                            console.log(result);
                            if (result == true) {
                                document.getElementById('' + fieldid + '').submit();
                            }
                        }
                    });
                } else if (level == 700) {
                    bootbox.prompt({
                        title: 'Course Role',
                        message: msg,
                        inputType: 'select',
                        className: 'selectpicker form-control',
                        buttons: {
                            confirm: {
                                label: 'Yes',
                                className: 'btn-success active ml-3'
                            },
                            cancel: {
                                label: 'No',
                                className: 'btn-danger active'
                            }
                        },
                        value: level,
                        inputOptions: [{
                                text: 'Choose one...',
                                value: '',
                            },
                            {
                                text: 'Guest',
                                value: '1',
                            }, {
                                text: 'Ghost',
                                value: '2',
                            }, {
                                text: 'Student',
                                value: '3',
                            },
                            {
                                text: 'Tutor',
                                value: '4',
                            }, {
                                text: 'Mentor',
                                value: '5',
                            }, {
                                text: 'Instructor',
                                value: '6',
                            },
                            {
                                text: 'Administrator',
                                value: '7',
                            }, {
                                text: 'Manager',
                                value: '8',
                            }
                        ],
                        callback: function(result) {
                            if (result != null) {
                                document.getElementById('role_id').value = result;
                                document.getElementById('sub_user_id').value = userid;
                                document.getElementById('subUserForm').submit();
                            } else {
                                //do nothing
                            }
                        }
                    });
                    $('.bootbox-input-select').addClass("selectpicker form-control");
                } else if (level == 701) {
                    bootbox.confirm({
                        message: (msg ? '' + msg + '' : 'Please confirm!'),
                        centerVertical: true,
                        buttons: {
                            confirm: {
                                label: 'Yes',
                                className: 'btn-success active ml-3'
                            },
                            cancel: {
                                label: 'No',
                                className: 'btn-danger active'
                            }
                        },
                        callback: function(result) {
                            console.log(result);
                            if (result == true) {
                                document.getElementById('role_id').value = 3;
                                document.getElementById('sub_user_id').value = userid;
                                document.getElementById('subUserForm').submit();
                            }
                        }

                    });
                } else if (level == 702) {
                    bootbox.confirm({
                        message: (msg ? '' + msg + '' : 'Please confirm!'),
                        centerVertical: true,
                        buttons: {
                            confirm: {
                                label: 'Yes',
                                className: 'btn-success active ml-3'
                            },
                            cancel: {
                                label: 'No',
                                className: 'btn-danger active'
                            }
                        },
                        callback: function(result) {
                            console.log(result);
                            if (result == true) {
                                document.getElementById('role_id_removed').value = 3;
                                document.getElementById('user_id_removed').value = userid;
                                document.getElementById('delUserForm').submit();
                            }
                        }

                    });
                }
            });

            function stringify(x) {
                console.log(Object.prototype.toString.call(x));
            }
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })

            function routeGo(url) {
                location.href = url;
            }
            $(document).ready(function() {
                $('#assignRolestable').DataTable({
                    "scrollX": false
                });
                $('.dropify').dropify();
            });
        </script>
    @endsection
