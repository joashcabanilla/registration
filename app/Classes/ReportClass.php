<?php

namespace App\Classes;
use Illuminate\Support\Facades\Auth;

//Model
use App\Models\User;
use App\Models\MemberModel;
use App\Models\TimedepositModel;

class ReportClass
{

    protected $userModel, $memberModel;

    function __construct()
    {
        $this->userModel = new User();
        $this->memberModel = new MemberModel();
    }

    function generateReport($data){
        $data = (object) $data;
        switch($data->report){
            case "staffShareCapitalGiveaway":
                return $this->shareCapitalGiveaway("sharecapital",$data);
            break;

            case "staffTimeDepositGiveaway":
                return $this->shareCapitalGiveaway("timedeposit",$data);
            break;

            case "sharecapitalsummary":
                return $this->giveawaySummary("sharecapital",$data);
            break;

            case "timedepositsummary":
                return $this->giveawaySummary("timedeposit",$data);
            break;

            case "summary":
                return $this->summaryReport($data);
            break;
        }
    }

    private function shareCapitalGiveaway($category){
        $var = array();
        $receivedList = array();
        $summaryList = array();

        $staffName = $this->userModel->find(Auth::user()->id)->name;

        if($category =="sharecapital"){
            $var["title"] = "Share Capital Giveaway";
            $var["category"] = "Share Capital";
            $data = $this->memberModel->where("registered_by", Auth::user()->id);
        }
        else{
            $var["title"] = "Time Deposit Giveaway";
            $var["category"] = "Time Deposit";
            $data = $this->timedepositModel->where("registered_by", Auth::user()->id);   
        }
        
        $data = $data->orderBy("received_at","ASC")->get();

        foreach($data as $member){
            $memberData = [
                "memid" => $member->memid,
                "pbno" => $member->pbno,
                "branch" => $member->branch,
                "rice" => $member->rice." KLS",
                "giftcheck" => number_format($member->giftcheck, 0, '.', ','),
                "updatedBy" => strtoupper(strtolower($staffName)),
                "dataReceived" => date("m/d/Y h:i A", strtotime($member->received_at))
            ];
            
            $receivedDate = date("m/d/Y",strtotime($member->received_at));

            if(isset($summaryList[$receivedDate]["rice"])){
                $summaryList[$receivedDate]["rice"] += $member->rice;    
            }else{
                $summaryList[$receivedDate]["rice"] = $member->rice;   
            }

            if(isset($summaryList[$receivedDate]["giftcheck"])){
                $summaryList[$receivedDate]["giftcheck"] += $member->giftcheck;    
            }else{
                $summaryList[$receivedDate]["giftcheck"] = $member->giftcheck;   
            }
            

            if($category =="sharecapital"){
                $memberData["name"] = strtoupper(strtolower($member->lastname.", ".$member->firstname." ".$member->middlename));
                $memberData["sharecapital"] = number_format($member->sharecapital, 2, '.', ',');
            }else{
                $memberData["name"] = strtoupper(strtolower($member->name));
                $memberData["timedeposit"] = number_format($member->timedeposit, 2, '.', ',');
                $memberData["tshirt"] = $member->tshirt > 0 ? $member->tshirt. " pc" : 0;
                if(isset($summaryList[$receivedDate]["tshirt"])){
                    $summaryList[$receivedDate]["tshirt"] += $member->tshirt;    
                }else{
                    $summaryList[$receivedDate]["tshirt"] = $member->tshirt;   
                }
            }
          
            $receivedList[] = $memberData; 
        }

        $var["giveawayList"] = $receivedList;
        ksort($summaryList);
        $var["summaryList"] = $summaryList;

        return response()->make(view("Report.ShareCapitalGiveaway",$var), '200'); 
    }

    private function giveawaySummary($category, $reportData){
        $var = array();
        $userList = array();
        $giveawayList = array();
        $staffSummary = array();

        $users = $this->userModel->get();
        foreach($users as $user){
            $userList[$user->id] = strtoupper(strtolower($user->name));
        }

        if($category =="sharecapital"){
            $var["title"] = "Share Capital Giveaway";
            $var["category"] = "Share Capital";
            $data = $this->memberModel->whereNotNull("registered_by");
            $totalMembers = $this->memberModel->where("status", "MIGS")->count();
        }
        else{
            $var["title"] = "Time Deposit Giveaway";
            $var["category"] = "Time Deposit";
            $data = $this->timedepositModel->whereNotNull("registered_by");  
            $totalMembers = $this->timedepositModel->count();
        }

        if(!empty($reportData->dateFrom) && !empty($reportData->dateTo)){
            $data = $data->whereBetween("received_at", [date("Y-m-d", strtotime($reportData->dateFrom))." 00:00:00", date("Y-m-d", strtotime($reportData->dateTo))." 23:59:59"]);
        }

        $data = $data->orderBy("received_at","ASC")->get();
        foreach($data as $member){
            $memberData = [
                "memid" => $member->memid,
                "pbno" => $member->pbno,
                "branch" => $member->branch,
                "rice" => $member->rice." KLS",
                "giftcheck" => number_format($member->giftcheck, 0, '.', ','),
                "updatedBy" => $userList[$member->registered_by],
                "dataReceived" => date("m/d/Y", strtotime($member->received_at))
            ];

            $receivedDate = date("m/d/Y",strtotime($member->received_at));

            if(isset($staffSummary[$receivedDate][$userList[$member->registered_by]]["rice"])){
                $staffSummary[$receivedDate][$userList[$member->registered_by]]["rice"] += $member->rice;    
            }else{
                $staffSummary[$receivedDate][$userList[$member->registered_by]]["rice"] = $member->rice;   
            }

            if(isset($staffSummary[$receivedDate][$userList[$member->registered_by]]["giftcheck"])){
                $staffSummary[$receivedDate][$userList[$member->registered_by]]["giftcheck"] += $member->giftcheck;    
            }else{
                $staffSummary[$receivedDate][$userList[$member->registered_by]]["giftcheck"] = $member->giftcheck;   
            }

            if($category =="sharecapital"){
                $memberData["name"] = strtoupper(strtolower($member->lastname.", ".$member->firstname." ".$member->middlename));
                $memberData["sharecapital"] = number_format($member->sharecapital, 2, '.', ',');
            }else{
                $memberData["name"] = strtoupper(strtolower($member->name));
                $memberData["timedeposit"] = number_format($member->timedeposit, 2, '.', ',');
                $memberData["tshirt"] = $member->tshirt > 0 ? $member->tshirt. " pc" : 0;
                if(isset($staffSummary[$receivedDate][$userList[$member->registered_by]]["tshirt"])){
                    $staffSummary[$receivedDate][$userList[$member->registered_by]]["tshirt"] += $member->tshirt;    
                }else{
                    $staffSummary[$receivedDate][$userList[$member->registered_by]]["tshirt"] = $member->tshirt;   
                }
            }

            $giveawayList[] = $memberData;
        }

        $var["giveawayList"] = $giveawayList;
        $var["totalMembers"] = $totalMembers;
        $var["totalRegistered"] = count($giveawayList);
        $var["percentage"] = number_format(($var["totalRegistered"]/$var["totalMembers"]) * 100,2, '.', ',') . "%";
        $var["staffSummary"] = $staffSummary;
        return response()->make(view("Report.GiveawaySummary",$var), '200');
    }

    private function summaryReport($reportData){
        $var = array();
        $userList = array();
        $summaryList = array();
        $staffSummary = array();
        $branchSummary = array();

        $users = $this->userModel->get();
        foreach($users as $user){
            $userList[$user->id] = strtoupper(strtolower($user->name));
        }

        $data = $this->memberModel->whereNotNull("registered_by");
        if(!empty($reportData->dateFrom) && !empty($reportData->dateTo)){
            $data = $data->whereBetween("received_at", [date("Y-m-d", strtotime($reportData->dateFrom))." 00:00:00", date("Y-m-d", strtotime($reportData->dateTo))." 23:59:59"]);
        }

        $data = $data->orderBy("received_at","ASC")->get();
        foreach($data as $member){
            $memberData = [
                "memid" => $member->memid,
                "pbno" => $member->pbno,
                "name" => strtoupper(strtolower($member->lastname.", ".$member->firstname." ".$member->middlename)),
                "branch" => $member->branch,
                "updatedBy" => $userList[$member->registered_by],
                "dataReceived" => date("m/d/Y", strtotime($member->received_at))
            ];

            $summaryList[] = $memberData;
            $staffSummary[$userList[$member->registered_by]][] = $memberData;
            $branchSummary[$member->branch][] = $memberData;
        }

        ksort($branchSummary);
        $var["title"] = "Summary Report";
        $var["summaryList"] = $summaryList;
        $var["staffSummary"] = $staffSummary;
        $var["branchSummary"] = $branchSummary;

        return response()->make(view("Report.SummaryReport",$var), '200');
    }
}
