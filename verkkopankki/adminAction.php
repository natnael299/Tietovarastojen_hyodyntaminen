<?php 
include("conn.php");
$id = (int) $_GET["id"];
$action = $_GET["action"];

$r = fetchUserByAccountId($conn, $id);

//update user info
if(isset($_POST["edit"])){
  $username = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $accountNo = trim($_POST["account_no"]);

  $conn->begin_transaction();

  try {
    $query = "UPDATE users SET username=?, email=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $username, $email, $r["user_id"]);
    $stmt->execute();

    $query = "UPDATE accounts SET account_no=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $accountNo, $id);
    $stmt->execute();

    $conn->commit();
    header("Location: ./dashboard.php");
    exit;
  } catch (mysqli_sql_exception $exception) {
    $conn->rollback();
    die("Update failed.");
  }
}

//update user info
if(isset($_POST["delete"]))
  {
  $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
  $stmt->bind_param("i", $r["user_id"]);
   if($stmt->execute()){
      header("Location: ./dashboard.php");
   };
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    form {
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

    form input[type="text"] {
      border: 1px solid black;
      width: 400px;
      padding-left: 10px;
      height: 45px;
      border-radius: 10px;
    }

    form input[type="submit"] {
      padding: 8px 40px;
      border-radius: 10px;
      background-color: #252525;
      color: #fff;
      margin: 17px 0 30px 0;
    }
  </style>
</head>
<body>
  <?php if($action=="edit"): ?>
  <!-- Update From -->
  <form action="#" method="post">
    <h3>Update a users info </h3>
    <input type="text" name="name" placeholder="username" value="<?= htmlspecialchars($r["username"]) ?>">
    <input type="text" name="email" placeholder="email@example.com" value="<?= htmlspecialchars($r["email"]) ?>">
    <input type="text" name="account_no" placeholder="account number" value="<?= htmlspecialchars($r["account_no"]) ?>">
    <input type="submit" name="edit" value="Edit">
  </form>
  <?php else: ?>
    <!-- Delete Form -->
  <form action="#" method="post">
    <h3>Delete a user</h3>
    <input type="text" name="name" placeholder="username" value="<?= htmlspecialchars($r["username"]) ?>" disabled>
    <input type="text" name="email" placeholder="email@example.com" value="<?= htmlspecialchars($r["email"]) ?>" disabled>
    <input type="text" name="account_no" placeholder="account number" value="<?= htmlspecialchars($r["account_no"]) ?>" disabled>
    <input type="submit" name="delete" value="Delete">
  </form>
<?php endif; ?>
  
</body>
</html>