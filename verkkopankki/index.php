<?php 
include("conn.php");
//checkStatus();

//logged in user's id
$_SESSION["user_id"] = 1;
$userId = (int)$_SESSION["user_id"];

//users account info
$loggedInUserAccountInfo = getLoggedInUserInfo($conn, $userId);

//track errors
$error= null;

$result = null;
//fetch logged in user's data
try{
  $query = "SELECT transactions.*, users.username AS counterparty_name FROM transactions JOIN users ON users.id=transactions.counterparty_id WHERE transactions.user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();
}catch(mysqli_sql_exception  $e){
  $error = "error while fetching data";
}

function fetchUserByAccountNo($conn, $reciverAccountNo){
    $query = "SELECT * FROM accounts WHERE account_no=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $reciverAccountNo);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

//when a user sends money
if(isset($_POST["send"])){
  $reciverName = $_POST["reciverName"];
  $reciverAccountNo = $_POST["reciverNo"];
  $amount = $_POST["amount"];
  if(!empty($reciverName) && !empty($reciverAccountNo) && !empty($amount) && $amount > 0 && $loggedInUserAccountInfo["amount"] >= $amount){

    //fetch important data for the queries
    $counterParty_info = fetchUserByAccountNo($conn, $reciverAccountNo);

    if( $counterParty_info){
      //add the transaction to the sender
      addTransactionToDB($conn, $userId, $loggedInUserAccountInfo["id"], $counterParty_info["user_id"], "-", $amount );
      
      //update the senders amount
      updateAmount($conn, $amount, "-", $userId);
      
      //add the transaction to the reciver 
      addTransactionToDB($conn, $counterParty_info["user_id"],$counterParty_info["id"], $userId, "+", $amount );
      
      //update the recivers amount
      updateAmount($conn, $amount, "+", $counterParty_info["user_id"]);

      //set error back to null
      $error = null;
    }else{
      $error = "Tilli ei löydetty";
    }
}else{
  $error = "virhe tarkista syöttämäsi tiedot!!";
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./style/index.css">
</head>

<body>
  <div class="container">
    <h2 class="title">Verkko Pankki</h2>
    <div class="balanceGrid">
      <h2>Sinun Tietosi</h2>
      <span class="netbalance"></span>
      <div class="balance">
        <div class="income">
          <p>Tilli numero</p>
          <span class="totalIncome">
            <?= $loggedInUserAccountInfo["account_no"] ?>
          </span>
        </div>
        
        <div class="expense">
          <p>Summa</p>
          <span class="totalExpense">
            <?= $loggedInUserAccountInfo["amount"].' €' ?>
          </span>
        </div>
      </div>
    </div>

    <div class="transactionGrid">
      <div class="transaction">
        <p class="title">Transactions</p>
        <div class="detailAll">
          <?php if($result): ?>
          <?php while($r = $result->fetch_assoc()): ?>
            <div class="detail <?= $r["type"]== "+" ?"income" :"expense";  ?>">
              <div>
                <p><?= $r["counterparty_name"] ?></p>
                <?= (new DateTime($r["date"]))->format("Y-m-d") ?>
              </div>
              <span>
                  <p><?= $r["type"].$r["amount"] ?></p>
              </span>
            </div> 
          <?php endwhile; ?>
          <?php endif;  ?>
        </div>
      </div>

      <form class="newTransaction" method="post">
        <p class="title">Lähettä raha</p>
        <input type="text" placeholder="Saajan Tilli numero..." class="description" name="reciverNo">
        <input type="text" placeholder="Saajan nimi..." class="description" name="reciverName">

        <input type="number" placeholder="Enter amount..." class="amountInput" name="amount">
        <?php if($error): ?>
          <p><?= $error ?></p>
        <?php endif; ?>
        <button class="addBtn" name="send" type="submit">Lähettää</button>
      </form>
    </div>
  </div>
</body>

</html>