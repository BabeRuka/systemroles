<?php

namespace BabeRuka\SystemRoles\Http\SystemRoles;

use BabeRuka\SystemRoles\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Auth;
use Session;
use BabeRuka\Models\SystemRoles;
use BabeRuka\Models\SystemRolesIn;
use BabeRuka\Models\UserRoles;
use BabeRuka\Models\UserRolesIn;
use BabeRuka\Models\User;
use Illuminate\Support\Facades\DB; 
use App\Repository\UserFunctions; 

class SystemRolesController extends Controller
{
    protected $module_id;
    protected $module;
    public $module_name;
    public $module_slug;
    public $page_title;
    protected $lms_group;
    protected $recipients;
    public $request;
    protected $eventClass;
    protected $user;

    public function __construct()
    {

        $this->recipients = array('admin', 'superadmin');
        $this->module_name = 'Roles';
        $this->module_slug = '_ROLES';
        $this->module = 'roles';
        $this->page_title = $this->module_name;
    }
    public function index()
    {
        $SystemRoles = new SystemRoles();
        $systemRoles = $SystemRoles->all();
        $user_roles = UserRoles::all();
        return view('systemroles.roles.index', compact('systemRoles', 'user_roles'));
    }

    // Store a new role
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:system_roles,role_name',
            'role_guard_name' => 'required',
        ]);

        SystemRoles::create($request->all());
        return response()->json(['status' => 'success', 'message' => 'Role created successfully.']);
    }

    // Update a role
    public function update(Request $request, $id)
    {
        $role = SystemRoles::findOrFail($id);

        $request->validate([
            'role_name' => 'required|unique:system_roles,role_name,' . $role->role_id . ',role_id',
            'role_guard_name' => 'required',
        ]);

        $role->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Role updated successfully.']);
    }

    // Manage permissions for a specific role
    public function manage(Request $request)
    {
        $role_id = $request->input('role_id');
        $systemRole = SystemRoles::findOrFail($role_id);
        $systemRolesIn = SystemRolesIn::where('role_id', $role_id)->get();
        $all_permissions = SystemRolesIn::all();
        if (count($systemRolesIn) < count($all_permissions)) {
            $this->init_permissions($role_id);
            $systemRolesIn = SystemRolesIn::where('role_id', $role_id)->get();
        }
        $all_roles = SystemRoles::all();
        $permissions = $systemRole->permissions()->get();
        $user_roles = $systemRole->userRoles()->get();
        return view('systemroles.roles.manage', compact('systemRole', 'permissions', 'user_roles', 'systemRolesIn', 'all_roles', 'all_permissions'));
    }

    // View all permissions
    public function permissionsIndex()
    {
        $permissions = SystemRolesIn::with('role')->with('userPermissions')->get();
        return view('systemroles.roles.permissions', compact('permissions'));
    }

    public function users()
    {
        $users = User::all();
        $roles = SystemRoles::all();
        $user_roles = UserRoles::all();
        return view('systemroles.roles.users', compact('users', 'roles', 'user_roles'));
    }

    function userData(Request $request)
    {
        $params = $columns = $totalRecords = $data = array();
        $params = $request->input();
 

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'created_at',
            4 => 'updated_at',
        );
        $where = $sqlTot = $sqlRec = "";
        $where = " WHERE id > 0 ";
        if ($request->input('search')) {
            $where .= " OR `name` LIKE  '%" . $params['search']['value'] . "%' ";
            $where .= " OR `email` LIKE  '%" . $params['search']['value'] . "%' ";
        }
        $sql = "SELECT * FROM users ";
        $sqlTot .= $sql;
        $sqlRec .= $sql;
        if (isset($where) && $where != '') {
            $sqlTot .= $where;
            $sqlRec .= $where;
        }
        $start = ($params['start'] ? $params['start'] : 0);
        $end = ($params['length'] ? $params['length'] : 1000);

        $order_collumn_name = 'id';
        $order_collumn_dir = 'ASC';
        if ($params['order'][0]['column']) {
            $order_collumn = $params['order'][0]['column'];
            $order_collumn = $order_collumn + 1;
            $order_collumn_name = $columns[$order_collumn];
            $order_collumn_dir = $params['order'][0]['dir'];
        }
        $order_collumn_dir = 'ASC';
        $sqlRec .=  " ORDER BY `" . $order_collumn_name . "` " . $order_collumn_dir . " LIMIT " . $start . " ," . $end . " ";
        $all_records = DB::select($sqlTot);
        $data = DB::select($sqlRec); 

        $queryRecords = $data;
        $recordsFiltered = count($data);
        $data = array();
        $filtered_records = array();
        if ($params['search']['value'] != '') {
            $filtered_records = DB::select(' SELECT u.id, `name`, email, email_verified_at,updated_at AS lastlogin, updated_at  FROM users ' . $where);
        }
        
        foreach ($queryRecords as $key => $row) {
            $UserRoles = new UserRoles();
            $SystemRoles = new SystemRoles();
            $data[$key]['id'] = $row->id;
            $data[$key]['name'] = $row->name;
            $data[$key]['email'] = $row->email;
            $data[$key]['email_verified_at'] = $row->email_verified_at ? date('Y-m-d H:i:s', strtotime($row->email_verified_at)) : 'Not Verified';
            $data[$key]['created_at'] = date('Y-m-d H:i:s', strtotime($row->created_at));
            $data[$key]['updated_at'] = date('Y-m-d H:i:s', strtotime($row->updated_at));
            $userRole = $UserRoles->where('user_id',$row->id)->first();
            $role_id = $userRole->role_id ?? 0;
            $role = $SystemRoles->where('role_id', $role_id)->first();
            if (!$role) {
                $role_name = '<span class="badge badge-secondary p-2">No Role</span>';
                $role_guard_name = 'no_role';
            } else {
                $role_name = '<span class="badge badge-secondary p-2">'.$role->role_name.'</span>';
                $role_guard_name = $role->role_guard_name;
            }
            $data[$key]['role_id'] = $role_id;
            $data[$key]['role_name'] = $role_name;
            $data[$key]['role_guard_name'] = $role_guard_name;
            $data[$key]['user_permissions'] = Session::get('user_permissions') ?? [];
        }
        $num_pages = $recordsFiltered / 10;
        $json_data = array(
            "draw"            => intval($params['draw']),   //intval($num_pages), //
            "recordsTotal"    => intval(count($data)),
            "recordsFiltered" => intval(($params['search']['value'] != '' ? count($filtered_records) : count($all_records))),
            "data"            => $data   // total data array
        );
        $res = json_encode($json_data);
        echo $res;  

    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:system_roles,role_id',
        ]);
        //SELECT role_id,user_id,user_role,role_admin,role_type,updated_at,created_at FROM user_roles;
        $has_role = UserRoles::where('user_id', $request->input('user_id'))->where('role_id', $request->input('role_id'))->first();
        if (!$has_role) {
            $role_admin = $request->input('role_id') == 1 ? 1 : 0;    
            $role_type = $request->input('role_id') == 1 ? 1 : 0;
            $user_role = new UserRoles();
            $user_role->user_id = $request->input('user_id');
            $user_role->user_role = $request->input('role_id');
            $user_role->role_admin = $role_admin;
            $user_role->role_type = $role_type;
            $user_role->save();
            $role_id = $user_role->role_id;
            if($role_id){
                $this->init_user_permissions($request->input('user_id'), $role_id);
                return redirect()->back()->with('success', 'Role assigned successfully and all permissions added.');  
            }else{
                return redirect()->back()->with('error', 'Role assigned but permissions not added.');   
            }
        }else{
            $role_id = $request->input('role_id');
            $this->init_user_permissions($request->input('user_id'), $role_id);
            return redirect()->back()->with('success', 'Role assigned successfully and all permissions added.');
        }
    }
    // Store permission
    public function permissionsStore(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:system_roles,role_id',
            'in_name' => 'required|unique:system_roles_in,in_name',
            'in_guard_name' => 'required|unique:system_roles_in,in_guard_name',
            'in_role' => 'required',
        ]);
        //check if the permission is already in the role table user_roles
        //role_id	user_id	user_role	role_admin	role_type	updated_at	created_at
        $has_permission = UserRoles::where('user_id', $request->input('user_id'))->where('role_id', $request->input('role_id'))->first();
        if (!$has_permission) {
            $UserRoles = new UserRoles();
            $role_admin = $request->input('user_role') == 1 ? 1 : 0;
            $role_type = $request->input('role_type') == 1 ? 1 : 0;
            $UserRoles->user_id = $request->input('user_id'); 
            $UserRoles->user_role = $request->input('role_id');
            $UserRoles->role_admin = $role_admin;
            $UserRoles->role_type = $role_type;
            $UserRoles->save();
            $role_id = $UserRoles->role_id; 
            return redirect()->back()->with('success', 'Permission added successfully.');
        }
        return redirect()->back()->with('error', 'Permission already exists.');
    }

    // Update permission
    public function permissionsUpdate(Request $request)
    {
        $in_id = $request->input('in_id');
        $role_id = $request->input('role_id');
        $permission = SystemRolesIn::where('in_id', $in_id)->where('role_id', $role_id)->first();
        if (!$permission) {
            return redirect()->back()->with('error', 'Permission not found.');
        }
        $request->validate([
            'in_name' => 'required|unique:system_roles_in,in_name,' . $permission->in_id . ',in_id',
            'in_guard_name' => 'required|unique:system_roles_in,in_guard_name,' . $permission->in_id . ',in_id',
            'in_role' => 'required|in:1,0',
        ]);
        $in_sequence = $this->nextInSequence();
        $request->input('in_guard_name', strtolower($request->input('in_name')));
        if (!$request->input('in_sequence') || $request->input('in_sequence') == 0) {
            $request->input('in_sequence', $in_sequence);
        }
        $permission->update($request->all());
        return redirect()->back()->with('success', 'Permission updated successfully.');
    }
    public static function nextInSequence()
    {
        return (SystemRolesIn::max('in_sequence') ?? 0) + 1;
    }
    public function moveInUp(Request $request)
    {
        $in_id = $request->input('in_id');
        $current = SystemRolesIn::findOrFail($in_id);
        $above = SystemRolesIn::where('in_sequence', '<', $current->in_sequence)
            ->orderBy('in_sequence', 'desc')
            ->first();

        if ($above) {
            $temp = $current->in_sequence;
            $current->in_sequence = $above->in_sequence;
            $above->in_sequence = $temp;

            $current->save();
            $above->save();
        }

        return redirect()->back()->with('success', 'Permission moved up.');
    }

    public function moveInDown(Request $request)
    {
        $in_id = $request->input('in_id');
        $current = SystemRolesIn::findOrFail($in_id);
        $below = SystemRolesIn::where('in_sequence', '>', $current->in_sequence)
            ->orderBy('in_sequence', 'asc')
            ->first();

        if ($below) {
            $temp = $current->in_sequence;
            $current->in_sequence = $below->in_sequence;
            $below->in_sequence = $temp;

            $current->save();
            $below->save();
        }

        return redirect()->back()->with('success', 'Permission moved down.');
    }
    function init_permissions($role_id)
    {
        $permissions = SystemRolesIn::where('role_id', 1)->get();
        //check if the permission is already in the role
        //dd($permissions);
        $count = 0;
        foreach ($permissions as $permission) {
            $has_permission = SystemRolesIn::where('role_id', $role_id)->where('in_name', $permission->in_name)->first();
            if (!$has_permission) {
                $systemRolesIn = new SystemRolesIn();
                $systemRolesIn->role_id = $role_id;
                $systemRolesIn->in_name = $permission->in_name;
                $systemRolesIn->in_guard_name = strtolower($permission->in_name);
                $systemRolesIn->in_role = 0;
                $systemRolesIn->in_sequence = $this->nextInSequence();
                $systemRolesIn->save();
                $count++;
            }
        }
        return $count;
    }

    function init_user_permissions($user_id, $role_id)
    {
        $permissions = SystemRolesIn::where('role_id', $role_id)->get();
        //check if the permission is already in the role
        //SELECT perm_id,user_id,in_id,in_role,updated_at,created_at FROM user_roles_in;
        $count = 0;
        foreach ($permissions as $permission) {
            $in_role = SystemRolesIn::where('in_id', $permission->in_id)->where('role_id', $role_id)->first();
            $has_permission = UserRolesIn::where('user_id', $user_id)->where('in_id', $permission->in_id)->first();
            if (!$has_permission) {
                $systemRolesIn = new UserRolesIn();
                $systemRolesIn->user_id = $user_id;
                $systemRolesIn->in_id = $permission->in_id;
                $systemRolesIn->in_role = $in_role->in_role;
                $systemRolesIn->save();
                $perm_id = $systemRolesIn->perm_id;
                if($perm_id){
                    $count++;
                }
            }else{
                //update the permission
                $has_permission->in_role = $in_role->in_role; 
                $has_permission->save();
            }
        }
        return $count;
    }
    function checkRole(){
        $user = Auth::user();
        $UserRoles = new UserRoles();
        $userRole = $UserRoles->where('user_id',$user->id)->first();
        $role_id = $userRole ? $userRole->role_id : 0;
        return $role_id;
    }
    function userRole()
    {
        $role_id = $this->checkRole();
        $user_role = [];
        if($role_id==1){
            $user_role['role_id'] = 1;
            $user_role['role_name'] = 'Super Admin';
            $user_role['role_guard_name'] = 'super_admin';
            Session::put('user_role', $user_role);
            return $user_role;
        }
        $role = SystemRoles::where('role_id', $role_id)->first();
        if($role){
            $user_role['role_id'] = $role->role_id;
            $user_role['role_name'] = $role->role_name;
            $user_role['role_guard_name'] = $role->role_guard_name;
            Session::put('user_role', $user_role);
            return $user_role;
        }
        $user_role['role_id'] = 0;
        $user_role['role_name'] = 'No Role';
        $user_role['role_guard_name'] = 'no_role';
        Session::put('user_role', $user_role);
        return $user_role;
    }
    function userPermissions($role_id, $force = false)
    {
        if (Session::has('user_permissions') && !$force) {
            return true;
        }
        $perm = [];
        $SystemRolesIn = new SystemRolesIn();
        $default_permissions = $SystemRolesIn->groupBy('in_name')->get();
        if($role_id==1){
            foreach ($default_permissions as $permission) {
                $perm[$permission->in_name] = 1;
            }
            Session::put('user_permissions', $perm);
            return $perm;
        }
        $all_permissions = $SystemRolesIn->where(['role_id' => $role_id])->get();
        
        foreach($all_permissions as $permission) {
            $perm[$permission->in_name] = $permission->in_role;
        } 
        Session::put('user_permissions', $perm);
        return $perm;
    }
     
}
