<?php

namespace App\Repositories;

use App\Models\ContactGroup;

class GroupRepository extends Repository
{
	protected $model;

    public function __construct(ContactGroup $contactGroup)
    {
        parent::__construct($contactGroup);
        $this->model = $contactGroup;
    }
}
