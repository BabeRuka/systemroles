<?php

namespace BabeRuka\SystemRoles\Http\Controllers\SystemRoles;

use BabeRuka\SystemRoles\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use BabeRuka\SystemRoles\ModelsSystemRoles; 
use BabeRuka\SystemRoles\ModelsSystemClasses;
use BabeRuka\SystemRoles\ModelsSystemClassesIn; 
use App\Services\SystemClassesScanner; 
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class SystemClassesController extends Controller
{
    public function __construct()
    { 
        $this->controllerInit(); 
    }
    public function index()
    {
        $all_classes = SystemClasses::all();
        $all_roles = SystemRoles::all();
        $class_roles = SystemClassesIn::all();
        return view('systemroles.roles.classes.index', compact('all_classes', 'all_roles', 'class_roles'));
    }

    public function manage(Request $request)
    {
        $class_id = $request->input('class_id');
        if (!$class_id) {
            return redirect()->route('admin.roles.classes.index')->with('error', 'Class ID is required.');
        }
        $class = SystemClasses::findOrFail($class_id);
        $class_roles = SystemClassesIn::where('class_id', $class_id)->get();
        $all_roles = SystemRoles::all(); 

        return view('systemroles.roles.classes.manage', compact('class', 'all_roles', 'class_roles'));
    }

     

    function controllerInit()
    {
        $scanner = new SystemClassesScanner();
        $controllers = $scanner->scanControllers();
        /*
        class_id
        class_name
        class_filename
        class_description
        class_namespace
        */
        foreach ($controllers as $controller) {
            $class = SystemClasses::firstOrNew(['class_name' => $controller['classname']]);
            $class->class_name = $controller['classname'];
            $class->class_filename = $controller['filename'];
            $class->class_namespace = $controller['namespace'];
            $class->class_description = 'This is the '.$controller['classname'].', namespace '.$controller['namespace'];
            $class->save();
        }

        return true;
    }
    public function store(Request $request)
    { 
        $class_id = $request->input('class_id');
        $role_id = $request->input('role_id');
        if (!$class_id || !$role_id) {
            return redirect()->route('admin.roles.classes.index')->with('error', 'Class ID and Role ID are required.');
        }
        $num = 0; 
        foreach ($request->post('role_id') as $role_id => $role_val) {
            $SystemClassesIn = new SystemClassesIn();
            $foundClass = $SystemClassesIn->where(['class_id' => $class_id, 'role_id' => $role_id])->first();
            $in_role = $request->post('in_role')[$role_id] ?? 0; 
            if ($foundClass) { 
                $foundClass->role_id = $role_id;
                $foundClass->class_id = $class_id;
                $foundClass->in_role = $in_role;  
                $foundClass->save();
                $in_id = $foundClass->in_id;
            }else{
                $SystemClassesIn->role_id = $role_id;
                $SystemClassesIn->class_id = $class_id;
                $SystemClassesIn->in_role = $in_role;
                $SystemClassesIn->save();
                $in_id = $SystemClassesIn->in_id;
            }
            if($in_id) {
                $num++;
            }
           
        }
        if($num > 0) {
            return redirect()->back()->with('success', 'Roles assigned to class successfully.');
        } else {
            return redirect()->back()->with('error', 'No roles were assigned to the class.');
        }
    }
    public function systemClassesInit(Request $request)
    {
        $all_classes = SystemClasses::all();
        foreach ($all_classes as $class) {
            $this->addSystemClassIn($class->class_id);
        }  
        return redirect()->back()->with('success', 'System classes initialized successfully.');
    }
    function addSystemClassIn($class_id){
        $alll_roles = SystemRoles::all();
        if ($alll_roles->count() == 0) {
            return 0;
        }
        $num = 0;
        $in_id = 0;
        foreach($alll_roles as $role) { 
            $SystemClassesIn = new SystemClassesIn(); 
            $role_id = $role->role_id;
            // Check if the class already exists for the role
            $foundClass = $SystemClassesIn->where(['class_id' => $class_id, 'role_id' => $role_id])->first(); 
            if (!$foundClass) {  
                $SystemClassesIn->role_id = $role_id;
                $SystemClassesIn->class_id = $class_id;
                $SystemClassesIn->in_role = 0;  
                $SystemClassesIn->save();
                $in_id = $SystemClassesIn->in_id;
            }
            if($in_id) {
                $num++;
            }
        }
        return $num;
    }
    function checkSystemClassesInit($role_id, $classname)
    {
        $foundClass = SystemClasses::where('class_name', $classname)->first();
        $class_perm = [];
        if (!$foundClass) {
            $class_perm['access'] = 0;
        }
        $class_id = $foundClass->class_id; 
        $in_class = SystemClassesIn::where(['role_id' => $role_id, 'class_id' => $class_id])->first();
        return $class_perm['access'] = $in_class ? $in_class->in_role : 0;
    }
    function chechAccess($role_id, $classname)
    {
        $access = $this->checkSystemClassesInit($role_id, $classname);
        if (!$access || $access['access'] == 0) {
            return abort(403, 'Access denied to this class.');
        }
        return true;
    }
    
}
