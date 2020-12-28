<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contacts;

class ContactGroup extends Model
{	

    protected $table = 'contact_group';

    protected $fillable = [
        'name', 
        'contact_count'
    ];


    /**
     * Relationships
     */
    public function contacts()
    {
        return $this->hasMany(Contacts::class, 'id', 'team_id');
    }

}
