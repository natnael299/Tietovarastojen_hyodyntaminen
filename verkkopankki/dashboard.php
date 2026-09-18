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

    $conn->begin_transaction();

    try {
        $query = "INSERT INTO users (username, email, password, role)
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        $stmt->execute();

        $userId = $conn->insert_id;

        if($role=="user"){ 
          $query = "INSERT INTO accounts (user_id, account_no)
                    VALUES (?, ?)";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("is", $userId, $accountNo);
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
    table {
  border-collapse: collapse;
  background-color: rgba(128, 128, 128, 0.084);
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
          <th>edit</th>
          <th>delete</th>
        </tr>
      </thead>
      <tbody>
        <?php while($r = $result->fetch_assoc()):  ?>
          <tr>
            <th><?= $r["id"]?></th>
            <th><?= $r["username"]?></th>
            <th><?= $r["email"]?></th>
            <th><?= $r["account_no"]?> </th>
            <th>
              <form action="#" method="post">
                <button type="submit" value="<?= $r["id"]  ?>" name="edit">Edit</button>
              </form>
            </th>
            <th>
              <form action="#" method="post">
                <button type="submit" value="<?= $r["id"]  ?>" name="delete">Delete</button>
              </form>
            </th>
          </tr>
        <?php endwhile;  ?>
      </tbody>
    </table>  


  <!-- the form to add new users -->
  <form action="#" method="post">
    <h3>Add a user </h3>
    <input type="text" name="name" placeholder="username" >
    <input type="text" name="email" placeholder="email@example.com" >
      <input type="text" name="account_no" placeholder="account number" >
      <select name="role">
        <option value="">Select role</option>
        <option value="user">user</option>
        <option value="admin">admin</option>
      </select>
    <input type="text" name="password" placeholder="password eg.0101">
    <input type="text" name="email" placeholder="email@example.com" >
  
    <input type="submit" name="insert" value="INSERT">
  </form>
</body>
</html>