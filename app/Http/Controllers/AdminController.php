<?php

namespace App\Http\Controllers;

// use App\Http\Middleware\Role;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Contact;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Amenitie;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Json;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        $contact = Contact::all();
        return view('admin.index', compact('contact'));
    } //End method

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    } //end method

    public function AdminLogin()
    {
        return view('admin.admin_login');
    } //end method



    public function AdminProfile()
    {
        $id = Auth::user()->id;

        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    } //end method

    public function AdminProfileStore(ProfileUpdateRequest $request)
    {

        $validate = $request->validated();
        $user = Auth::user();
        $user->update($validate);

        $id = Auth::user()->id;
        $data = User::find($id);
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            @unlink(public_path('upload/admin_images/' . $data->photo));
            // when u use the get client original name,u will get with the full name , example if u upload the image with aryan.jpg we will get it with full
            $file->move(public_path('upload/admin_images'), $filename);
            // Saving the name of the image in the data base
            $user->photo = $filename;
            $user->save();
        }

        // $notification = array(
        //     'message' => '',

        // );

        return response()->json([
            'message' => 'Updated successfully',
            'alertType' => 'success',
        ]);
    } //end method


    public function AdminChangePassword()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    } //end method

    public function AdminUpdatePassword(Request $request)
    {
        //validation
        $request->validate(
            [
                'old_password' => 'required',
                'new_password' => 'required|confirmed',
            ]
        );

        // Match the old password
        if (!Hash::check($request->old_password, Auth::user()->password)) {

            $notification = array(
                'message' => 'Old password Does not Match!',
                'alert-type' => 'error'

            );
            return back()->with($notification);
        }

        //another validation for updating new password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Changed Succesfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    } //End Method


    public function AllAdmin()
    {
        $alladmin = User::where('role', 'admin')->get();
        return view('backend.pages.admin.all_admin', compact('alladmin'));
    } //End method

    public function AddAdmin()
    {
        $roles = Role::all();
        return view('backend.pages.admin.add_admin', compact('roles'));
    } //End method

    public function StoreAdmin(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();
        $user->address = $request->address;

        if ($request->roles) {
            $roleByName = Role::find($request->roles);
            $user->assignRole($roleByName);
        }

        $notification = array(
            'message' => 'New Admin User Inserted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification);
    } //End method


    public function EditAdmin($id)
    {
        $users = User::findOrFail($id);
        $roles = Role::all();
        return view('backend.pages.admin.edit_admin', compact('users', 'roles'));
    }

    public function UpdateAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = 'admin';
        $user->status = 'active';
        $user->address = $request->address;

        $user->roles()->detach();

        if ($request->roles) {
            $role = Role::find($request->roles);
            $user->assignRole($role->name);
        }

        $user->save();



        $notification = array(
            'message' => ' Admin User Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification);
    } //End Method

    public function DeleteAdmin($id)
    {
        $user = User::findOrFail($id);
        if (!is_null($user)) {
            $user->delete();
        }

        $notification = array(
            'message' => ' Admin User Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } //End Method

    public function GetEnquiries()
    {
        $contact = Contact::all();
        return view('backend.contact.contact', compact('contact'));
    } //End Method

    public function GetSlugForAmenitie(Amenitie $amenities)
    {
        return view('backend.amenities.edit_amenitie_slug', compact('amenities'));
    } //End Method

    public function updateSlugForAmenitie(Request $request, Amenitie $amenities)
    {
        $request->validate([
            'amenities_name' => 'required|string|max:255',
            'slug' => 'required|string'
        ]);

        $amenities->update([
            'amenities_name' => $request->amenities_name,
            'slug' => $request->slug
        ]);
    } //End Method


}
