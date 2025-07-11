<?php

namespace BabeRuka\SystemRoles\Http\Controllers\SystemRoles;

use BabeRuka\SystemRoles\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use BabeRuka\SystemRoles\Models\SystemMenus; 
use BabeRuka\SystemRoles\Models\SystemMenusIn;
use BabeRuka\SystemRoles\Models\SystemRoutes; 
use BabeRuka\SystemRoles\Models\SystemRoutesIn;
use BabeRuka\SystemRoles\Models\SystemRoles; 
use BabeRuka\SystemRoles\Models\SystemClasses;
use BabeRuka\SystemRoles\Models\SystemClassesIn; 
use BabeRuka\SystemRoles\Services\SystemRouteScanner; 
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;

class SystemRoutesController extends Controller
{
    public function __construct()
    { 
        $this->controllerInit(); 
    }
     
    public function index()
    {
        $all_routes = SystemRoutes::all();
        $all_roles = SystemRoles::all();
        $route_roles = SystemRoutesIn::all();
        return view('vendor.systemroles.roles.routes.index', compact('all_routes', 'route_roles', 'all_roles'));
    }

    public function manage(Request $request)
    {
        $route_id = $request->input('route_id');
        if (!$route_id) {
            return redirect()->route('systemroles.admin.roles.routes.index')->with('error', 'Route ID is required.');
        }
        $route = SystemRoutes::findOrFail($route_id);
        $route_roles = SystemRoutesIn::where('route_id', $route_id)->get();
        $all_roles = SystemRoles::all(); 

        return view('vendor.systemroles.roles.routes.manage', compact('route', 'route_roles', 'all_roles'));
    }

    /**
     * Initialize the controller by scanning routes and storing them.
     *
     * @return void
     */
    public function store(Request $request)
    { 
        $route_id = $request->input('route_id');
        $role_id = $request->input('role_id'); 
        if (!$route_id || !$role_id) {
            return redirect()->route('systemroles.admin.roles.routes.index')->with('error', 'Route ID and Role ID are required.');
        }
        $num = 0; 
        foreach ($request->post('role_id') as $role_id => $role_val) {
            $SystemRoutesIn = new SystemRoutesIn();
            $foundRoute = $SystemRoutesIn->where(['route_id' => $route_id, 'role_id' => $role_id])->first();
            $in_route = $request->post('in_route')[$role_id] ?? 0; 
            if ($foundRoute) { 
                $foundRoute->role_id = $role_id;
                $foundRoute->route_id = $route_id;
                $foundRoute->in_route = $in_route;  
                $foundRoute->save();
                $in_id = $foundRoute->in_id;
            }else{
                $SystemRoutesIn->role_id = $role_id;
                $SystemRoutesIn->route_id = $route_id;
                $SystemRoutesIn->in_route = $in_route;
                $SystemRoutesIn->save();
                $in_id = $SystemRoutesIn->in_id;
            }
            if($in_id) {
                $num++;
            }
           
        }
        if($num > 0) {
            return redirect()->back()->with('success', 'Roles assigned to Route successfully.');
        } else {
            return redirect()->back()->with('error', 'No roles were assigned to the Route.');
        }
    }
     

    function controllerInit()
    {
        $scanner = new SystemRouteScanner();
        $all_routes = $scanner->scanRoutes(); 
        foreach ($all_routes as $route) {
            try {
                $route_data = json_encode($route);                 
                $SystemRoute = SystemRoutes::firstOrNew(['route_name' => $route['name'], 'route_prefix' => $route['prefix']]);
                //check if its a middleware
                $middleware = $route['middleware'] ?? '';
                if (is_array($middleware) && !empty($middleware)) {
                    $filtered = array_filter($middleware, function ($mw) {
                        return !$mw instanceof \Closure;
                    });
                    $middleware = implode(', ', $filtered);
                }
                $SystemRoute->route_name = $route['name'];
                $SystemRoute->route_prefix = $route['prefix'];
                $SystemRoute->route_method = $route['methods'];
                $SystemRoute->route_url = $route['uri'];
                $SystemRoute->route_middleware = $middleware;
                $SystemRoute->route_data = $route_data;
                $SystemRoute->route_action = $route['controller']; 
                $SystemRoute->route_desc = 'This is the '.$route['name'].', namespace '.$route['prefix'];
                $SystemRoute->save();
            } catch (\Exception $e) { 
                $msg = "Failed to synchronize route: " . ($route['name'] ?? $route['uri'] ?? 'Unknown Route') . " Error: " . $e->getMessage();
                Log::error($msg);
            }
        } 
        return true;
    }
}
