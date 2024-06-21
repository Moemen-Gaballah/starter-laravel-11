<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getImagePathAttribute()
    {
        if($this->image)
            return asset('uploads/car-brands/'. $this->image);

        return null;
    }
}
