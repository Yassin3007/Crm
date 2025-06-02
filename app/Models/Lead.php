<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'phone', 'whatsapp_number', 'email', 'national_id', 'branch_id', 'city_id', 'district_id', 'location_link'];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */

//     public function getNameAttribute()
//     {
//         return $this->attributes['name_'.app()->getLocale()];
//     }

     public function scopeActive($query)
     {
         return $query->where('is_active', 1);
     }


    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function district()
    {
        return $this->belongsTo(\App\Models\District::class);
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }
    public function actions()
    {
        return $this->hasMany(LeadAction::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the latest action for the lead.
     */
    public function latestAction()
    {
        return $this->hasOne(LeadAction::class)->latestOfMany();
    }

    /**
     * Get actions count for the lead.
     */
    public function getActionsCountAttribute()
    {
        return $this->actions()->count();
    }

    /**
     * Get the last contact date.
     */
    public function getLastContactDateAttribute()
    {
        $latestAction = $this->latestAction;
        return $latestAction ? $latestAction->created_at : null;
    }

    public function media(): HasMany
    {
        return $this->hasMany(LeadMedia::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(LeadMedia::class)->where('file_type', 'image');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(LeadMedia::class)->where('file_type', 'document');
    }
}
