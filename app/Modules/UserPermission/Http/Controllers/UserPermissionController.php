<?php

namespace App\Modules\UserPermission\Http\Controllers;
use App\Modules\UserPermission\Models\Module;
use App\Modules\UserPermission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class UserPermissionController {

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['roles'] = Role::pluck( 'title', 'id' )->toArray();
        return view( "UserPermission::role_permission", $data );
    }

    /**
     * Load the module and module wise permission and role wise assign permission
     *
     *  @return \Illuminate\Http\Response
     */
    public function modulePermission( Request $request ) {
        $role_id = $request->get( 'role' );
        $role = Role::find( $role_id );
        $data['role'] = $role;
        $data['modules'] = Module::all();
        $modulesAssociativeArray = array();
        foreach ( $role->modules as $module ) {
            $modulesAssociativeArray[$module->id] = True;
        }
        $permissionAssociativeArray = array();
        foreach ( $role->permissions as $permission ) {
            $permissionAssociativeArray[$permission->id] = True;
        }
        $data['role_permissions'] = $permissionAssociativeArray;
        $data['module_permission'] = $modulesAssociativeArray;
        return view( "UserPermission::module_permission", $data );
    }

    public function store( Request $request ) {
        try {
            // $request->validate( array(
            //     'permissions' => 'required|array',
            //     'modules'     => 'required|array',
            // ));
    
            $role_id = $request->get( 'role_id' );
            $role = Role::findOrFail( $role_id );
            $role->permissions()->sync( $request->permissions );
            $role->modules()->sync( $request->modules );
            Session::flash( 'success', 'Permission Update Successfully !' );
            return redirect()->route( 'user-permission' )->with( 'status_color', 'success' );
        } catch ( \Exception $e ) {
            Session::flash( 'error', "Something went wrong during application data load [User-101]" );
            return response()->json( array( 'error' => $e->getMessage() ), Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
