<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditAmenities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;
use App\Models\Amenitie;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class PropertyTypeController extends Controller
{
    public function AllType()
    {

        $types = PropertyType::latest()->get();
        return view('backend.type.all_type', compact('types'));
    }

    public function AddType()
    {
        return view('backend.type.add_type');
    }

    public function StoreType(Request $request)
    {

        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required'
        ]);

        PropertyType::insert([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);

        $notification = array(
            'message' => 'Property Type created Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.type')->with($notification);
    } //EndMethod

    public function EditType($id)
    {
        $types = PropertyType::findOrFail($id);
        return view('backend.type.edit_type', compact('types'));
    } //End Method

    public function UpdateType(EditAmenities $request)
    {

        $validated = $request->validated();

        $pid = $request->id;

        PropertyType::findOrFail($pid)->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);


        // $notification = array(
        //     'message' => 'Property Type updated Succesfully',
        //     'alert-type' => 'success'
        // );
        return response()->json([
            'status' => 'success',
            'message' => 'Property type updated successfully',
        ]);
    }

    public function DeleteType($id)
    {
        PropertyType::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Property Type Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } //End method


    ///////////////==========Amenitie all methods  //////////////////////////

    public function AllAmenitie()
    {

        $amenities = Amenitie::latest()->get();
        return view('backend.amenities.all_amenities', compact('amenities'));
    } //End method

    public function AddAmenitie()
    {
        return view('backend.amenities.add_amenities');
    } //End Method



    public function StoreAmenitie(Request $request)
    {

        Amenitie::create([
            'amenities_name' => $request->amenities_name,
            'description' => $request->amenities_description,
            'icon_name' => $request->amenities_icon,
        ]);

        $notification = array(
            'message' => 'Amenitie  created Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.amenitie')->with($notification);
    } //EndMethod


    public function EditAmenitie(Amenitie $amenities)
    {
        // $amenities = Amenitie::findOrFail($id);
        // $amenities = Amenitie::findOrFail($id); No need of id anymore using slug even laravel handels the 404 error
        $this->authorize('update', $amenities);

        // $amenities = $amenities->where('slug', $amenities->slug);
        return view('backend.amenities.edit_amenities', compact('amenities'));
    } //End Method

    public function UpdateAmenitie(Request $request, Amenitie $amenities)
    {
        $request->validate([
            'amenities_name' => 'required|string|max:255',
            'description'    => 'nullable|string',
            'icon_name'      => 'nullable|string|max:255',
        ]);

        $amenities->update([
            'amenities_name' => $request->amenities_name,
            'description' => $request->description,
            'icon_name' => $request->icon_name,
        ]);



        $notification = array(
            'message' => 'Amenitie Updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.amenitie')->with($notification);
    } //EndMethod


    public function DeleteAmenitie($id)
    {
        $amenitie = Amenitie::findOrFail($id);

        $this->authorize('delete', $amenitie);

        $amenitie->delete();

        return redirect()->back()->with([
            'message' => 'Amenitie Deleted Successfully',
            'alert-type' => 'success'
        ]);
        return redirect()->back()->with($notification);
    } //End method

    // Doing Pagination for Types
    public function getType(Request $request)
    {
        // DataTables params
        $pageLength = $request->length ?? 10;
        $skip       = $request->start ?? 0;

        $orderColumnIndex = $request->order[0]['column'] ?? 0;
        $orderBy          = $request->order[0]['dir'] ?? 'desc';

        // Column mapping (must match DataTable columns)
        $columns = ['type_name', 'type_icon'];
        $orderByName = $columns[$orderColumnIndex] ?? 'type_name';

        // Base query
        $query = DB::table('property_types');

        // TOTAL records (NO search)
        $recordsTotal = DB::table('property_types')->count();

        // SEARCH (IMPORTANT FIX)
        $searchValue = $request->search['value'] ?? null;

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('type_name', 'like', "%{$searchValue}%")
                    ->orWhere('type_icon', 'like', "%{$searchValue}%");
            });
        }

        // FILTERED records
        $recordsFiltered = $query->count();

        // ORDER & PAGINATION
        $data = $query
            ->orderBy($orderByName, $orderBy)
            ->skip($skip)
            ->take($pageLength)
            ->get();

        // RESPONSE
        return response()->json([
            "draw" => intval($request->draw),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
    }

    // public function  AllService()
    // {
    //     $serviceData = Amenitie::all();
    //     return view('backend.services.all_services', compact('serviceData'));
    // }

    // public function AddService(Request $request)
    // {
    //     return view('backend.services.add_service');
    // }

    // public function editService(Request $request, $id)
    // {
    //     $amenities = Amenitie::findOrFail($id);
    //     $this->authorize('update', $amenities);

    //     return view('backend.services.edit_services', compact('amenities'));
    // }
}
