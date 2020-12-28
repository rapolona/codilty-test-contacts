<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contacts;

class CustomAttribute extends Model
{	

    protected $table = 'custom_attributes';

    protected $fillable = [
    	'contact_id', 
        'key', 
        'value'
    ];


    /**
     * Relationships
     */

    public function contacts()
    {
        return $this->belongsTo(Contacts::class, 'contact_id');
    }

}
