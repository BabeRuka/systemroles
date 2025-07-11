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
use BabeRuka\SystemRoles\Models\SystemMenuItems;
use BabeRuka\SystemRoles\Services\SystemRouteScanner; 
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;

class SystemMenusController extends Controller
{
    public function __construct()
    { 
    }
     
    public function index()
    {
        $all_menus = SystemMenus::all();
        $all_menus_in = SystemMenusIn::all(); 
        $all_items = SystemMenuItems::all();
        $all_roles = SystemRoles::all();
        $all_roles_in = SystemRoutesIn::all();
        $items = SystemMenuItems::all();
        return view('vendor.systemroles.menus.index', compact('all_menus','all_items', 'all_menus_in', 'all_roles','all_roles_in'));
    }

    public function items(Request $request)
    {
        $menu_id = $request->input('menu_id') ? $request->input('menu_id') : 0;
        $menu = SystemMenus::find($menu_id);
        $all_menus_in = SystemMenusIn::where(['menu_id' => $menu_id])->get(); 
        $all_items = SystemMenuItems::where(['menu_id' => $menu_id])->get(); 
        $all_items_in = SystemMenuItems::all();
        $all_roles = SystemRoles::all();
        $all_routes = SystemRoutes::all();
        $all_roles_in = SystemRoutesIn::all();
        return view('vendor.systemroles.menus.items', compact('menu', 'all_routes', 'all_items_in', 'all_items', 'all_menus_in', 'all_roles','all_roles_in'));
    }

    public function manage(Request $request)
    {
        $menu_id = $request->input('menu_id') ? $request->input('menu_id') : 0;
        $menu = SystemMenus::find($menu_id);
        $all_menus_in = SystemMenusIn::where(['menu_id' => $menu_id])->get(); 
        $all_roles = SystemRoles::all();
        $all_roles_in = SystemRoutesIn::all();
        return view('vendor.systemroles.menus.manage', compact('menu', 'all_menus_in', 'all_roles','all_roles_in'));
    }
    /*
     

    */
    public function store(Request $request)
    {
        $menu_id = $request->input('menu_id') ? $request->input('menu_id') : 0;
            $SystemMenus = new SystemMenus();
            $foundMenu = $SystemMenus->find($menu_id); 
            if ($foundMenu) { 
                $foundMenu->menu_name = $request->input('menu_name');
                $foundMenu->menu_type = $request->input('menu_type');
                $foundMenu->menu_desc = $request->input('menu_desc');  
                $foundMenu->save(); 
            }else{
                $SystemMenus->menu_name = $request->input('menu_name');
                $SystemMenus->menu_type = $request->input('menu_type');
                $SystemMenus->menu_desc = $request->input('menu_desc');
                $SystemMenus->save();
                $menu_id = $SystemMenus->menu_id;
            } 
        
        if($menu_id > 0) {
            return redirect()->back()->with('success', 'Roles assigned to Route successfully.');
        } else {
            return redirect()->back()->with('error', 'No roles were assigned to the Route.');
        }
    }


    public function assign(Request $request)
    {

    }

    public function itemsStore(Request $request)
    {
        $menu_id = $request->input('menu_id') ? $request->input('menu_id') : 0;
        $item_name = $request->input('item_name') ? $request->input('item_name') : '';
        $item_icon = $request->input('item_icon') ? $request->input('item_icon') : '';
        $item_type = $request->input('item_type') ? $request->input('item_type') : '';
        $route_id = $request->input('route_id') ? $request->input('route_id') : 0;
        

        $SystemMenuItems = new SystemMenuItems();
        $SystemMenuItems->menu_id = $menu_id;
        $SystemMenuItems->item_name = $item_name;
        $SystemMenuItems->item_icon = $item_icon;
        $SystemMenuItems->item_type = $item_type;
        $SystemMenuItems->route_id = $route_id;
        $SystemMenuItems->save();

        /*
          
        */
        foreach($request->input('roles') as $role_id) {
            $SystemMenuItemsIn = new SystemMenusIn();
            $foundMenuItem = $SystemMenuItemsIn->where(['menu_id' => $menu_id, 'route_id' => $route_id, 'role_id' => $role_id])->first();
            $in_role = $role_id > 0 ? '1' : '0';
            if($foundMenuItem) {
                $foundMenuItem->menu_id = $menu_id;
                $foundMenuItem->route_id = $route_id;
                $foundMenuItem->role_id = $role_id;
                $foundMenuItem->in_role = $in_role;
                $foundMenuItem->save();
            }else{
                $SystemMenuItemsIn->menu_id = $menu_id;
                $SystemMenuItemsIn->route_id = $route_id;
                $SystemMenuItemsIn->role_id = $role_id;
                $SystemMenuItemsIn->in_role = $in_role;
                $SystemMenuItemsIn->save();
            }
        }
        return redirect()->back()->with('success', 'Item added successfully.');
        
    }
    public function menuDestroy(Request $request)
    {
        $menu_id = $request->input('menu_id') ? $request->input('menu_id') : 0;
        $menu = SystemMenus::find($menu_id);
        $menu->delete();
        return redirect()->back()->with('success', 'Menu deleted successfully.');
    }

    public function menuItemDestroy(Request $request)
    {
        $item_id = $request->input('item_id') ? $request->input('item_id') : 0;
        $menuItem = SystemMenuItems::find($item_id);
        $menuItem->delete();
        return redirect()->back()->with('success', 'Menu item deleted successfully.');
    }

}
