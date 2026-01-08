<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GusetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.home');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// We have to protect theses route so we using middleware


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//Redircting dashboard based on the role


// Admin group middle ware
Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])
        ->name('admin.dashboard');

    Route::post('/admin/logout', [AdminController::class, 'AdminLogout'])
        ->name('admin.logout');

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])
        ->name('admin.profile');

    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])
        ->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])
        ->name('admin.change.password');

    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])
        ->name('admin.update.password');

    Route::get('/enquiries', [AdminController::class, 'GetEnquiries'])
        ->name('dashboard.contact');

    // AJAX – fetch full message
    Route::get('/enquiries/{contact}/message', [ContactController::class, 'message'])
        ->name('enquiries.message');
}); //End Group andmin modular


// Agent Group Modular
Route::middleware(['auth', 'roles:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])
        ->name('agent.dashboard');

    Route::post('/agent/logout', [AdminController::class, 'AdminLogout'])
        ->name('agent.logout');

    Route::get('/about', [AdminController::class, 'AdminDashboard'])
        ->name('agent.dashboard');
}); //End Group agent modular


// User Group Modular
Route::middleware(['auth', 'roles:user'])->group(function () {
    Route::get('user/dashboard', [UserController::class, 'UserDashboard'])->name('user.dashboard');
});


Route::get('/login', [AdminController::class, 'AdminLogin'])
    ->middleware('guest')
    ->name('login');





// Admin group middle ware
Route::middleware(['auth', 'roles:admin'])->group(function () {

    // Property Type all ROute
    Route::controller(PropertyTypeController::class)->group(function () {
        Route::get('/all/type', 'AllType')
            ->name('all.type')->middleware('permission:all.type');

        Route::get('/add/type', 'AddType')->name('add.type')->middleware('permission:add.type');

        Route::post('/store/type', 'StoreType')->name('store.type')->middleware('permission:edit.type');

        Route::get('/edit/type/{id}', 'EditType')->name('edit.type')->middleware('permission:edit.type');

        Route::post('/update/type', 'UpdateType')->name('update.type')->middleware('permission:edit.type');

        Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type')->middleware('permission:delete.type');


        //For pagignation
        Route::post('/get-type', 'getType')->name('type.getType');
    });

    //  Route::get('/dashboard',[DashboardController::class,'index'])
    //  ->middleware('auth')
    //  ->name('dashboard');




    // Amenities all Routes
    Route::controller(PropertyTypeController::class)->group(function () {

        Route::get('/all/amenitie', 'AllAmenitie')->name('all.amenitie');


        Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie');

        Route::post('/store/amenitie', 'StoreAmenitie')->name('store.amenitie');

        Route::get('/edit/amenitie/{id}', 'EditAmenitie')->name('edit.amenitie');

        Route::post('/update/amenitie', 'UpdateAmenitie')->name('update.amenitie');

        Route::get('/delete/amenitie/{id}', 'DeleteAmenitie')->name('delete.amenitie');
    });


    // Permision All Routes
    Route::controller(RoleController::class)->group(function () {

        Route::get('/all/permission', 'AllPermission')->name('all.permission');

        Route::get('/add/permission', 'AddPermission')->name('add.permission');

        Route::post('/store/permission', 'StorePermission')->name('store.permission');

        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');

        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');

        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');

        // Exporting Pdf
        Route::get('/amenities/export-pdf', 'ExportPdf')->name('amenities.export.pdf');

        // import and export functionalities
        Route::get('/import/permission', 'ImportPermission')->name('import.permission');

        // Route::get('/export','Export')->name('export');
        Route::get('/export', 'Export')->name('export');

        Route::post('/import', 'Import')->name('import');

        // Route for Amenties export
        Route::get('/export/amenities', 'ExportAmenities')->name('amenities.export.excel');
    });

    // Roles All Routes
    Route::controller(RoleController::class)->group(function () {

        Route::get('/all/role', 'AllRole')->name('all.roles');

        Route::get('/add/role', 'AddRole')->name('add.roles');

        Route::post('/store/role', 'StoreRole')->name('store.roles');

        Route::get('/edit/roles/{id}', 'EditRole')->name('edit.roles');

        Route::post('/update/roles', 'UpdateRole')->name('update.roles');

        Route::get('/delete/roles/{id}', 'DeleteRole')->name('delete.roles');


        //Roles And permission given here
        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');


        Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');


        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');

        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');

        Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');

        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');
    }); //End

    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/admin', 'AllAdmin')->name('all.admin');

        Route::get('/add/admin', 'AddAdmin')->name('add.admin');

        Route::post('/store/admin', 'StoreAdmin')->name('store.admin');

        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');

        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');

        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');
    });
}); //End Group andmin modular

Route::controller(GusetController::class)->group(function () {
    Route::get('/', 'Home')->name('frontend.home');
    Route::get('about', 'AboutUs')->name('about.us');
    Route::get('service', 'Service')->name('service');
    Route::get('property', 'Property')->name('property');
    Route::get('property-single', 'PropertySingle')->name('property.single');
    Route::get('agent', 'Agent')->name('agent.page');
    Route::get('contact', 'Contact')->name('contact');
    Route::post('contact/store', [ContactController::class, 'ContactStore'])->name('contact.store');
});
