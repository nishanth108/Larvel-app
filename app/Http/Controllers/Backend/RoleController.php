<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PermissionImport;
use App\Exports\PermissionExport;
use App\Exports\AmenitiesExport;
use App\Models\Amenitie;
use Maatwebsite\Excel\Excel as MaatwebsiteExcel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class RoleController extends Controller
{

    public function AllPermission() {
        $permission = Permission::all();
        return view('backend.pages.permission.all_permission',compact('permission'));
    }//End Method



    public function AddPermission() {
        return view('backend.pages.permission.add_permission');
    }//End Method




    public function StorePermission(Request $request) {

        $permission = Permission::create([
            'name' => $request->name,
            'group_name' =>$request->group_name,
        ]);

        $notification = array(
                'message' => 'Permission Created Succesfully',
                'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);

    }

      public function EditPermission($id) {
        $permission = Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission',compact('permission'));
    }//End Method



    public function  UpdatePermission(Request $request) {
        $per_id = $request->id;
        Permission::findOrFail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name
        ]);

         $notification = array(
                'message' => 'Permission Updated Succesfully',
                'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }//End Method

      public function  DeletePermission(Request $request) {
        $per_id = $request->id;
        Permission::findOrFail($per_id)->delete();

         $notification = array(
                'message' => 'Permission deleted Succesfully',
                'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }//End Method


    public function ImportPermission() {

        return view('backend.pages.permission.import_permission');
    }//End Method


    public function Export() {

        return Excel::download(new PermissionExport, 'permission.xlsx');
    }


     public function Import(Request $request) {


          Excel::import(new PermissionImport, $request->file('import_file'));
           $notification = array(
                'message' => 'Permission Imported Succesfully',
                'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }// END METHOD



    // ===============Role all method=================////////////

    public function AllRole() {
        $roles = Role::all();
        return view('backend.pages.roles.all_role',compact('roles'));

    }

    public function AddRole() {
        return view('backend.pages.roles.add_role');

    }


    public function StoreRole(Request $request) {

        $role = Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
                'message' => 'Permission Updated Succesfully',
                'alert-type' => 'success'
        );

        return redirect('/all/role')->with($notification);

    }//End method


    public function EditRole($id) {
        $roles = Role::findOrFail($id);
        return view('backend.pages.roles.edit_roles',compact('roles'));
    }//End method

    public function UpdateRole(Request $request) {

        $role_id = $request->id;

       Role::findOrFail($role_id)->update([
            'name' => $request->name,
       ]);


        $notification = array(
                'message' => 'Role Updated Succesfully',
                'alert-type' => 'success'
        );

        return redirect()->route('all.roles')->with($notification);
    }

    public function DeleteRole($id) {

        $role_id = Role::findOrFail($id)->delete();

        $notification = array(
                'message' => 'Role Deleted Succesfully',
                'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);

    }


    // ===============Add Role Permission all method ======================== /////////////

    public function AddRolesPermission() {
        $roles = Role::all();
        $permission = Permission::all();
        $permission_groups = User::getPermissionGroups();
        return view('backend.pages.rolesetup.add_roles_permission',compact('roles','permission','permission_groups'));
    } //End Method

    public function RolePermissionStore(Request $request) {
        $data = array();

        $permission = $request->permission;

        foreach($permission as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;
            DB::table('role_has_permissions')->insert($data);
        }//End foreach

         $notification = array(
                'message' => 'Role permission added Succesfully',
                'alert-type' => 'success'
        );
        return redirect()->route('all.roles.permission')->with($notification);


    } //End Method

    public function AllRolesPermission() {
        $roles = Role::all();
        return view('backend.pages.rolesetup.all_roles_permission',compact('roles'));

    }//End method


    public function AdminEditRoles($id) {
        $role = Role::findOrFail($id);
        $permission = Permission::all();
        $permission_groups = User::getPermissionGroups();
        return view('backend.pages.rolesetup.edit_roles_permission',compact('role','permission','permission_groups'));
    }//End method

    public function AdminRolesUpdate(Request $request,$id) {
        $role = Role::findOrFail($id);
        $permissions = $request->permission;
        if(!empty($permissions)) {
            $permissionNames = Permission::whereIn('id', $permissions)->get();
            $role->syncPermissions($permissionNames);
        }

        $notification = array(
                'message' => 'Role permission Updated Succesfully',
                'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);


    }//End method

    public function AdminDeleteRoles($id) {
        $role = Role::findOrFail($id);
        if(!is_null($role)) {
            $role->delete();
        }


         $notification = array(
                'message' => 'Role permission Deleted Succesfully',
                'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }//End Method


// Get Export Type for Amenities
    public function GetExportType() {
        return view('backend.pages.export.export_type');
    }//End Method

    // Exporting the Amenities
    public function ExportAmenities() {
        $amenities = Amenitie::all();
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Assigning the value to the cell
        $sheet->setCellValue('A1', 'Sl');
        $sheet->setCellValue('B1', 'Amenity Name');
        // $sheet->setCellValue('C1', 'Created At');
        // $sheet->setCellValue('D1', 'Updated At');

        // Adjusting the rows
       foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

          // Add data starting from row 2
        $row = 2;
        $sl = 1;

        foreach ($amenities as $amenity) {
            $sheet->setCellValue('A' . $row, $sl);
            $sheet->setCellValue('B' . $row, $amenity->amenities_name);
            // $sheet->setCellValue('C' . $row, $amenity->created_at->format('Y-m-d H:i:s'));
            // $sheet->setCellValue('D' . $row, $amenity->updated_at->format('Y-m-d H:i:s'));
            $row++;
            $sl++;
        }

          $writer = new Xlsx($spreadsheet);

        //   /? Generate filename with timestamp
        $fileName = 'amenities_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Output directly to browser (user downloads to their laptop)
        $writer->save('php://output');
        exit;



    }//End Method

// Export in Pdf
    public function ExportPdf(Request $request) {
        $amenties = Amenitie::all();
        $pdf = Pdf::loadview('pdf.amenities',compact('amenties'))
        ->setPaper('a4', 'portrait');;
        return $pdf->download('amenities_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
