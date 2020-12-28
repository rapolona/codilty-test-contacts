<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Log;
use App\Services\ContactService;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{

    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    Public function index()
    {
        return view('csvmapper');
    }

    Public function upload(Request $request)
    {

        $validator = Validator::make(['name' => $request->groupName], [
            'name' => 'required|unique:contact_group', 
        ]);

        if ($validator->fails()) {
            return Response::json([ 'error' => $validator->errors()->first() ], 422);
        }

        $csv = $this->contactService->sanitizeCsv($request->origCsv, $request->csvHeader);

        //validate each row
        foreach ($csv as $key => $value) {
            
            $validator = Validator::make($value, [
                'phone' => 'required|numeric', 
                'sticky_phone_number_id' => 'numeric'
            ]);

            if ($validator->fails()) {
                return Response::json(['error' => $validator->errors()->first() . " Check line " . ($key + 1)], 422);
            }
        }

        $upload = $this->contactService->uploadContacts($csv, $request->groupName, $request->updateStartegy);

        return Response::json(['data' => $upload ], 201);
    }

    Public function validateMappedCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json([ 'error' => $validator->errors()->first()], 422);
        }

        $csv = $request->csv;

        //validate each row
        foreach ($csv as $key => $value) {
            
            if($key > 0){
                $validator = Validator::make($value, [
                    'phone' => 'required|numeric', 
                    'sticky_phone_number_id' => 'numeric',
                    'email' => 'email'
                ]);

                if ($validator->fails()) {
                    return Response::json([ 'error' => $validator->errors()->first() . " Check line " . ($key + 1)], 422);
                }
            }
            
        }

        return Response::json([ 'success' => 'success'], 200);
    }

    Public function groupList(Request $request)
    {
        return Response::json(['data' => $this->contactService->getGroupList() ], 200);
    }

    public function contactList($id)
    {
        return Response::json(['data' => $this->contactService->getContactList($id) ], 200);
    }
}