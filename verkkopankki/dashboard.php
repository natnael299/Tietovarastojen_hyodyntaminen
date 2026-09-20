<?php 
include "conn.php";
$query = "SELECT accounts.*,users.username, users.email FROM accounts JOIN users ON users.id=accounts.user_id";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

//edit a users info
if(isset($_POST["edit"])){
  $id = $_POST["edit"];
  header("Location: ./adminAction.php?id=". $id . "&action=edit" );
  }

//delete a users info
if(isset($_POST["delete"])){
  $id = $_POST["delete"];
  header("Location: ./adminAction.php?id=". $id . "&action=delete");
}

//insert a new user 
if (isset($_POST["insert"])) {
    $username = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $accountNo = trim($_POST["account_no"]);
    $role = $_POST["role"];
    $password = $_POST["password"];
    $amount = $_POST["amount"];
    $conn->begin_transaction();

    try {
        $query = "INSERT INTO users (username, email, password, role)
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        $stmt->execute();

        $userId = $conn->insert_id;

        if($role=="user"){ 
          $query = "INSERT INTO accounts (user_id, account_no, amount)
                    VALUES (?, ?, ?)";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("isi", $userId, $accountNo, $amount);
          $stmt->execute();
        }

        $conn->commit();

        header("Location: ./dashboard.php");
        exit;
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        die("Insert failed.");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>

    body{
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    table {
  border-collapse: collapse;
  background-color: rgba(128, 128, 128, 0.084);
  margin-top: 30px;
  margin-bottom: 30px;
}

table td {
  padding: 10px;
  text-align: center;
  vertical-align: middle;
  border-bottom: 1px solid #80808081;
}

table th {
  padding: 15px;
  background-color: orange;
  color: #fff;
  text-align: center;
  vertical-align: middle;
}

 .form {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: fit-content;
      margin: 70px auto 20px auto;
      overflow-y: auto;
      border: 1px solid black;
      border-top: 4px solid black;
      border-radius: 20px;
      padding: 20px 20px 10px 20px;
      gap: 15px;
    }

    .form input[type="text"],
    .form input[type="number"],
    select {
      border: 1px solid black;
      width: 400px;
      padding-left: 10px;
      height: 45px;
      border-radius: 10px;
    }

    a {
      padding: 8px 40px;
      border-radius: 10px;
      background-color: #252525;
      color: #fff;
      margin: 17px 0 30px 0;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <h1>Dashboard</h1>

  <!-- the table of users -->
     <table class="desktop">
      <thead>
        <tr>
          <th>id</th>
          <th>users</th>
          <th>email</th>
          <th>account no</th>
          <th>amount</th>
        </tr>
      </thead>
      <tbody>
        <?php while($r = $result->fetch_assoc()):  ?>
          <tr>
            <th><?= $r["id"]?></th>
            <th><?= $r["username"]?></th>
            <th><?= $r["email"]?></th>
            <th><?= $r["account_no"]?> </th>
            <th><?= $r["amount"] . " €"?> </th>
          </tr>
        <?php endwhile;  ?>
      </tbody>
    </table>  

    <div class="links">
      <a href="./adminAction.php?action=create&role=user&type=new">Create a new user</a>
      <a href="./adminAction.php?action=create&role=admin">Create a new admin</a>
      <a href="./requests.php">Check requests</a>
    </div>
</body>
</html>-