<?php
session_start();
if($_SERVER["HTTP_HOST"] == "localhost"){
  $host = "localhost";
  $user = "root";
  $password = "";
  $database = "verkkopankki";
}else{
  $host = "localhost";
  $user = "25p_1735";
  $password = "jEk_BcvQ57/IAU)4";
  $database = "25p_1735";
}

$conn = new mysqli($host, $user, $password, $database);

//check if a user is logged in or not for redirect
function checkStatus(){
  if(!isset($_SESSION["user_id"])){
    header("Location: ./login.php");
  }
}

function getLoggedInUserInfo($conn, $id){
  $query = "SELECT * FROM accounts WHERE user_id=?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  return $result;
}

function fetchUserByAccountId($conn, $id){
  $query = "SELECT accounts.*,users.username, users.email FROM accounts JOIN users ON users.id=accounts.user_id WHERE accounts.id=?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  return $stmt->get_result()->fetch_assoc();
}

 function addTransactionToDB($conn, $targetId, $accountId, $counterPartId, $sign, $amount ){
    $query = "INSERT INTO transactions (user_id, account_id, counterparty_id, type, amount) VALUES(?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiisd", $targetId, $accountId, $counterPartId , $sign, $amount);
    $stmt-> execute();
    }

 function updateAmount($conn, $amount, $operation, $id){
    if($operation=="+"){
      //update the recivers amount
      $query = "UPDATE accounts
        SET amount = amount + ?
        WHERE user_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("di", $amount, $id);
      $stmt->execute();
      }else{
      //update the senders amount
      $query = "UPDATE accounts
        SET amount = amount - ?
        WHERE user_id = ? AND amount >= ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("did", $amount, $id, $amount);
      $stmt->execute();
    }
   }
?>