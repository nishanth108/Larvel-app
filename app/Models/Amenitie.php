<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Amenitie extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($amenity) {
            $baseSlug = Str::slug($amenity->amenities_name); //creating slag using name and removes space kind of things
            $slug = $baseSlug; // storing base slug inside of slug
            $counter = 1; // using counter to check the repetation of same kind of slag

            while (static::where('slug', $slug)->exists()) {  //checking if same kind of slag exists or not
                $slug = "{$baseSlug}-{$counter}"; //append that with the base slag and store it in slug
                $counter++; //increase the counter
            } //Checks until we get a unique slug

            $amenity->slug = $slug; //storing the slug in the amenties
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
