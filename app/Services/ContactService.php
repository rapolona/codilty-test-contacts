<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use App\Repositories\CustomAttributeRepository;
use App\Repositories\GroupRepository;

class ContactService 
{

    protected $contactRepository;

    protected $customRepository;

    protected $groupRepository;

    protected $contactFields = [
        'team_id',
        'name', 
        'phone',
        'email', 
        'sticky_phone_number_id'
    ];

    public function __construct(
    	ContactRepository $contactRepository, 
    	CustomAttributeRepository $customRepository, 
    	GroupRepository $groupRepository
    )
    {
        $this->contactRepository = $contactRepository;
        $this->customRepository = $customRepository;
        $this->groupRepository = $groupRepository;
    }

    public function sanitizeCsv($csv, $mapperHeaders){
        $csv = explode(PHP_EOL, $csv);
        $csvArray = []; 
        $csvHeader = [];
        $crudableCsv = [];
        
        // CSV to ARRAY
        foreach ($csv as $row) {
            array_push($csvArray, str_getcsv($row, ","));
        }

        // GET MAIN HEADERS KEYS
        foreach ($csvArray[0] as $hKey => $cHeader) {
            $csvHeader[$hKey] = $cHeader;
            foreach($mapperHeaders as $mapperKey => $mapperHeader){
                if($mapperHeader==$cHeader){
                    $csvHeader[$hKey] = $mapperKey;
                }
            }
        }

        // BUILD CRUDABLE CSV
        foreach ($csvArray as $cKey => $csvCrud) {
            if($cKey > 0){
                //return $csvCrud;
                $newLine = [];
                foreach ($csvHeader as $key => $value) {
                    $newLine[$value] = $csvCrud[$key];
                }
                array_push($crudableCsv, $newLine);
            }
        }

    	return $crudableCsv;
    }

    public function getGroupList(){
    	return $this->groupRepository->getAll();
    }

    public function uploadContacts($data, $groupName, $updateStartegy)
    {
        $group = $this->groupRepository->create([ 'name' => $groupName, 'contact_count' => 0]);
        if(isset($group->id)){
            foreach($data as $line){
                // SINGLE INSERT
                $contactArray = [
                    'team_id' => $group->id,
                    'name' => isset($line['name'])? $line['name'] : null, 
                    'phone' => $line['phone'],
                    'email'  => isset($line['email'])? $line['email'] : null, 
                    'sticky_phone_number_id' => isset($line['sticky_phone_number_id'])? $line['sticky_phone_number_id']: null
                ];
 
                if($updateStartegy==3){
                    $contact = $this->contactRepository->create($contactArray);
                }else{
                    $contact = $this->contactRepository->firstOrCreate($contactArray);
                }
                

                //BULK INSERT
                $custom = [];
                foreach($line as $unmappedKey => $unmapped){
                    if(!in_array($unmappedKey, $this->contactFields)){
                        array_push($custom, [
                            'contact_id' => $contact->id, 
                            'key' => $unmappedKey, 
                            'value' => $unmapped
                        ]);
                    }
                }

                if(count($custom) > 0){
                    $this->customRepository->bulkInsert($custom);
                }
            }
        }
        return $custom;
    }

    public function getContactList($id){
        return $this->contactRepository->getContactListByGroupId($id);
    }

}
