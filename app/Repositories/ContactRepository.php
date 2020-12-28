<?php

namespace App\Repositories;

use App\Models\Contacts;

class ContactRepository extends Repository
{
	protected $model;

    public function __construct(Contacts $contacts)
    {
        parent::__construct($contacts);
        $this->model = $contacts;
    }

    public function getContactListByGroupId($id)
    {
    	return $this->model->with('customAttributes')->where('team_id', $id)->get();
    }

}
