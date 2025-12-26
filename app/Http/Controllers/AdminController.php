<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//Classes
use App\Classes\DataTableClass;
use App\Classes\ReportClass;

//Model
use App\Models\User;
use App\Models\MemberModel;

class AdminController extends Controller
{
    protected $data, $datatable, $userModel, $memberModel, $reportClass;

    public function __construct()
    {
        $this->middleware('auth');
        $this->data = array();
        $this->userModel = new User();
        $this->datatable = new DataTableClass();
        $this->memberModel = new MemberModel();
        $this->reportClass = new ReportClass();
    }

    function Dashboard(){
        $this->data["titlePage"] = "Registration | Dashboard";
        $this->data["tab"] = "dashboard";
        return view('Components.Dashboard',$this->data);
    }

    function getDashboardData(){
        $result = array();
        $summaryList = array();
        $branchList = $this->memberModel->branchList();

        $memberList = $this->memberModel->get();
        $totalMembers = $totalMIGS = $totalNONMIGS = 0;
        foreach($memberList as $member){
            $totalMembers++;
            if($member->status == "MIGS"){
                $totalMIGS++;
            } else {
                $totalNONMIGS++;
            }
        }
        $result["totalMembers"] = number_format($totalMembers,0, '.', ',');
        $result["totalMigs"] = number_format($totalMIGS,0, '.', ',');
        $result["totalNONMIGS"] = number_format($totalNONMIGS,0, '.', ',');

        $data = $this->memberModel->whereNotNull("registered_by")->get();
        $totalReceived = 0;
        $shareCapitalSummary = array();
        foreach($data as $member){
            $totalReceived++;
            $shareCapitalSummary[strtoupper(strtolower($member->branch))][] = $member->id;
        }
        $result["totalReceived"] = number_format($totalReceived,0, '.', ',');
        $result["migsReceived"] = number_format(($totalReceived/$totalMembers) * 100,2, '.', ',') . "%";

        foreach($branchList as $branch){
            $branchName = strtoupper(strtolower($branch->branch));
            $summaryList[] = [
                "branch" => $branchName,
                "migsReceived" => isset($shareCapitalSummary[$branchName]) ? number_format(count($shareCapitalSummary[$branchName]),0,'.', ',') : 0,
            ];
        }
        $result["summaryList"] = $summaryList;
        return $result;
    }

    function Users(){
        $this->data["titlePage"] = "Registration | Users";
        $this->data["tab"] = "users"; 
        return view('Components.Users',$this->data);
    }

    function Maintenance(){
        $this->data["titlePage"] = "Registration | Maintenance";
        $this->data["tab"] = "maintenance";

        $tableArray = $this->datatable->getAllDatabaseTable();
        $tableList = array();
        foreach($tableArray as $table){
            foreach($table as $tablename){
                $tableList[] = trim($tablename);
            }
        }
        $this->data["tables"] = $tableList;

        $this->data['reportList'] = [
            "summary" => "Summary Report",
        ];

        $userList = $this->userModel->getUser();
        foreach($userList as $user){
            $this->data['userList'][$user->id] = $user->name;
        }
        
        return view('Components.Maintenance',$this->data);
    }

    function Members(){
        $this->data["titlePage"] = "Registration | Members";
        $this->data["tab"] = "members";
        $this->data["branchList"] = $this->memberModel->branchList();
        return view('Components.Members',$this->data);
    }

    function Timedeposit(){
        $this->data["titlePage"] = "GIVEAWAY | Time Deposit";
        $this->data["tab"] = "Time Deposit";
        $this->data["branchList"] = $this->memberModel->branchList();
        return view('Components.Timedeposit',$this->data);
    }

    function Logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response('logout',200); 
    }

    function UserTable(Request $request){
        return $this->datatable->userTable($request->all());
    }

    function createUpdateUser(Request $request){
        return $this->userModel->createUpdateUser($request->all());
    }

    function getUser(Request $request){
        return $this->userModel->getUser($request->id);
    }

    function deactivateUser(Request $request){
        if(!empty($request->status)){
            return $this->userModel->deactivateUser($request->id, $request->status);
        }else{
            return $this->userModel->deactivateUser($request->id);
        }
    }

    function batchInsertData(Request $request){
        $table = $request->table;
        $data = $request->insert;
        $result = array();
    
        if(!empty($data)){
            foreach($data as $rowData){
                foreach($rowData as $key => $row){
                    $dbData[trim($key)] = !empty($row) ? trim($row) : NULL;
                }
                $insertData[] = $dbData;
            }
            $dbInsert = DB::table(trim($table))->insert($insertData);
            if($dbInsert){
                $result["status"] = "success";
            }else{
                $result["status"] = "failed";
                $result["error"] = $insertData;
            }
        }else{
            $result["status"] = "failed";
            $result["error"] = $data;
        }

        return $result;
    }

    function memberTable(Request $request){
        return $this->datatable->memberTable($request->all());
    }

    function createUpdateMember(Request $request){
        return $this->memberModel->createUpdateMember($request->all());
    }

    function deleteMember(Request $request){
        return $this->memberModel->find($request->id)->delete();
    }

    function getMember(Request $request){
        $result = array();
        $result["member"] = $this->memberModel->getMember($request->id);
        return $result;
    }

    function generateReport(Request $request){
        return $this->reportClass->generateReport($request->all());
    }

    function receivedGiveaway(Request $request){
        if($request->category ==  "sharecapital"){
            return $this->memberModel->receivedGiveaway($request->all());
        }else{
            return $this->timeDepositModel->receivedGiveaway($request->all());
        }
        
    }

    function timedepositTable(Request $request){
        return $this->datatable->timedepositTable($request->all());        
    }

    function addTimedepositMember(Request $request){
        return $this->timeDepositModel->addTimedepositMember($request->all());
    }

    function getTimedepositMember(Request $request){
        $result = array();
        $result["member"] = $this->timeDepositModel->getMember($request->id);
        return $result;
    }

    function updateMemberStatus(Request $request){
        return $this->memberModel->find($request->id)->update(["status" => $request->status, "updated_status_by" => Auth::user()->id]);
    }

    function updateShareCapital(Request $request){
        return $this->memberModel->updateShareCapital($request->all());
    }

    function updateTimeDeposit(Request $request){
        return $this->timeDepositModel->updateTimeDeposit($request->all());
    }
}
