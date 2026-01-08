<?php

namespace App\Http\Controllers;

use App\Models\Amenitie;
use Illuminate\Http\Request;

class GusetController extends Controller
{
    public function Home() {
        return view('frontend.index');
    }
    public function AboutUs() {
        return view('frontend.guest_about');
    }
     public function Service() {
        $amenitie = Amenitie::all();
        return view('frontend.guest_service',compact('amenitie'));
    }

    public function Property() {
        return view('frontend.properties');
    }

    public function PropertySingle() {
        return view('frontend.property_single');
    }

     public function Agent() {
        return view('frontend.guest_agent');
    }

      public function Contact() {
        
        return view('frontend.contact');
    }



}
