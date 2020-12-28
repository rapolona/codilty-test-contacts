<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomAttributes;

class Contacts extends Model
{	
    
    protected $table = 'contacts';

    protected $fillable = [
        'id',
    	'team_id',
        'name', 
        'phone',
        'email', 
        'sticky_phone_number_id'
    ];


    /**
     * Relationships
     */
    public function customAttributes()
    {
        return $this->hasMany('App\Models\CustomAttribute', 'contact_id', 'id');
    }

}
