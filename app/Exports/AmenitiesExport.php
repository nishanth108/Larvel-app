<?php

namespace App\Exports;

use App\Models\Amenitie;
use Maatwebsite\Excel\Concerns\FromCollection;

class AmenitiesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Amenitie::select('amenities_name')->get();
    }
}
