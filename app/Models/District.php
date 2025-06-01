<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_en', 'name_ar', 'city_id', 'is_active'];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */

     public function getNameAttribute()
     {
         return $this->attributes['name_'.app()->getLocale()];
     }

     public function scopeActive($query)
     {
         return $query->where('is_active', 1);
     }


    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }
}
