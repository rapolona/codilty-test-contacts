<?php

namespace App\Repositories;

use App\Models\CustomAttribute;

class CustomAttributeRepository extends Repository
{
	protected $model;

    public function __construct(CustomAttribute $customAttribute)
    {
        parent::__construct($customAttribute);
        $this->model = $customAttribute;
    }

    public function bulkInsert($data)
    {

        foreach ($data as $key => $value) {
            $this->firstOrCreate($value);
        }
        
    	return true; //CustomAttribute::insert($data);
    }

}
