<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MemberModel extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'memid',
        'pbno',
        'firstname',
        'middlename',
        'lastname',
        'branch',
        'status',
        'updated_status_by',
        'registered_by',
        'received_at',
        'note'
    ];

    function memberTable($data){
        $query = $this->select(
            "id",
            "memid",
            "pbno",
            "branch",
            DB::raw("UPPER(CONCAT(COALESCE(lastname, ''), ', ', COALESCE(firstname, ''), ' ', COALESCE(middlename, ''))) as name"),
            "status",
            "received_at",
        );

        if(!empty($data->filterSearch)){
            $search = $data->filterSearch;
            $query->where(function($q) use($search){
                $q->orWhereRaw("UPPER(CONCAT(COALESCE(lastname, ''), ', ', COALESCE(firstname, ''), ' ', COALESCE(middlename, ''))) LIKE '%".strtoupper($search)."%'");
                $q->orWhereRaw("memid LIKE '%".$search."%'");
                $q->orWhereRaw("pbno LIKE '%".$search."%'");
            });
        }

        $query = !empty($data->filterBranch) ? $query->where("branch", $data->filterBranch) : $query;

        if(!empty($data->filterStatus)){
            if($data->filterStatus == "received"){
                $query = $query->whereNotNull("registered_by");
            }else{
                $query = $query->whereNull("registered_by");
            }
        }
        $query = $query->orderBy("id", "ASC");

        return $query;
    }

    function createUpdateMember($data){
        $result = array();
        $result["status"] = "success";
        $rules = [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'branch' => ['required']
        ];

        $validator = Validator::make($data,$rules); 
        if($validator->fails()){
            $result["error"] = $validator->errors();
            $result["status"] = "failed";
        }else{
            $this->updateOrCreate([
                "id" => !empty($data["id"]) ? $data["id"] : 0
            ],$data);
        }
    }

    function getMember($id){
        $member = $this->find($id);
        $member["name"] = trim(strtoupper($member->lastname . ", " . $member->firstname . " " . $member->middlename));
        return $member;
    }

    function branchList(){
        $result = array();
        $branchList = $this->select("branch")->distinct()->get();
        if(!empty($branchList)){
            $result = $branchList;
        }
        return $result;
    }

    function receivedGiveaway($data){
        $data = (object) $data;
        $result["status"] = "success";
        $result["message"] = "Successfully Saved.";
        $this->find($data->id)->update([
            "rice" => $data->rice,
            "giftcheck" => $data->giftcheck,
            "registered_by" => Auth::user()->id,
            "received_at" => Carbon::now(),
            "note" => $data->note
        ]);
        return $result;
    }

    function updateShareCapital($data){
        $result = array();
        $result["status"] = "success";
        $data = (object) $data;
        $memberData = [
            "registered_by" => null,
            "received_at" => null,
            "note" => null
        ];
        
        if(!empty($data->sharecapital)){
            $memberData["sharecapital"] = $data->sharecapital;
        }

        $this->find($data->id)->update($memberData);
        
        return $result;
    }

    private function getGiftCheckAmount($sharecapital){
        $gift = array();

        if($sharecapital >= 3000 && $sharecapital < 6001){
           $gift["rice"] = 2; 
        }
        elseif($sharecapital >= 6001 && $sharecapital < 10001){
            $gift["rice"] = 3;
            $gift["giftCheck"] = 100;
        }
        elseif($sharecapital >= 10001 && $sharecapital < 50001){
            $gift["rice"] = 4;
            $gift["giftCheck"] = 100;
        }
        elseif($sharecapital >= 50001 && $sharecapital < 300001){
            $gift["rice"] = 4;
            $gift["giftCheck"] = 200;
        }
        elseif($sharecapital >= 300001 && $sharecapital < 1000000){
            $gift["rice"] = 6;
            $gift["giftCheck"] = 200;
        }
        elseif($sharecapital >= 1000000 && $sharecapital < 2000100){
            $gift["rice"] = 8;
            $gift["giftCheck"] = 200;
        }
        elseif($sharecapital >= 2000100){
            $gift["rice"] = 10;
            $gift["giftCheck"] = 200;
        }
        return $gift;
    }
}