<?php

include 'lib/Database.php';
include_once 'lib/Session.php';

class Applicants{

    private $applicantTable = 'table_applicant';
  	private $conn;


  // Db Property
  private $db;

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }

// Delete User by Id Method
    public function deleteApplicantById($remove){
      $sql = "DELETE FROM applicants WHERE id = :id ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $remove);
        $result =$stmt->execute();
        if ($result) {
          $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Success !</strong> User account Deleted Successfully !</div>';
            return $msg;
        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error !</strong> Data not Deleted !</div>';
            return $msg;
        }
    }
    ?>
