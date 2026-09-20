<?php 
include("conn.php");
$id = $_GET["id"] ?? "";
$action = $_GET["action"] ?? "";
$accountId = $_GET["account"] ?? "";
$role = $_GET["role"] ?? "";

$r = fetchUserByAccountId($conn, $id);

//create a new user
if(isset($_POST["createUser"])){
  $username = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);
  $accountNo = trim($_POST["account_no"]);
  $amount = trim($_POST["amount"]);

  $conn->begin_transaction();

  try {
    $query = "INSERT INTO users (username, email, password, role) VALUES(?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    $stmt->execute();

     $userId = $conn->insert_id;

    $query = "INSERT INTO accounts (account_no, user_id, amount) VALUES(?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sid", $accountNo,$userId, $amount);
    $stmt->execute();

    $conn->commit();
    header("Location: ./dashboard.php");
    exit;
  } catch (mysqli_sql_exception $exception) {
    $conn->rollback();
    die("Update failed.");
  }
}

//delete a user
if(isset($_POST["delete"]))
  {
  $stmt = $conn->prepare("DELETE FROM accounts WHERE id=?");
  $stmt->bind_param("i", $accountId);
   if($stmt->execute()){
      header("Location: ./dashboard.php");
   };
  }

  //create a new account
  if(isset($_POST["createAccount"])){
    $query = "INSERT INTO accounts (id, user_id, account_no, amount) VALUES(?,?,?,?)";
    $account_no = $_POST["account_no"];
    $amount = $_POST["amount"];
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisd", $accountId, $id, $account_no, $amount);
    if($stmt->execute()){
      header("Location: ./dashboard.php");
    };
  }

  //create an admin
  if(isset($_POST["createUser"])){
    $username = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $accountNo = trim($_POST["account_no"]);
    $amount = trim($_POST["amount"]);

    $query = "INSERT INTO users (username, email, password, role) VALUES(?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    $stmt->execute();
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

    form input[type="text"],
    form input[type="number"] {
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
  <?php if($action=="create" && $role == ""): ?>
  <!-- Create a new user -->
  <form action="#" method="post">
    <h3>Create a new account </h3>
    <input type="text" name="name" placeholder="username" value="<?= htmlspecialchars($r["username"]) ?>" disabled>
    <input type="text" name="email" placeholder="email@example.com" value="<?= htmlspecialchars($r["email"]) ?>" disabled>
    <input type="text" name="account_no" placeholder="new account number">
    <input type="number" name="amount" min="0" placeholder="starting amount eg. 200 €">
    <input type="submit" name="createAccount" value="Create Account">
  </form>
  <?php elseif($action=="create" && $role == "user"): ?>
    <!-- the form to add new users -->
  <form action="#" method="post" class="form">
    <h3>Create a New User </h3>
    <input type="text" name="name" placeholder="username" >
    <input type="text" name="email" placeholder="email@example.com" >
    <input type="text" name="account_no" placeholder="account number" >
    <input type="text" name="password" placeholder="password eg.0101">
    <input type="number" name="amount" placeholder="starting amount eg.0001" min="0">
    <input type="submit" name="createUser" value="Create A new User" >
  </form>
  <?php elseif($action=="create" && $role == "admin"): ?>
    <!-- the form to add new users -->
  <form action="#" method="post" class="form">
    <h3>Add a New Admin </h3>
    <input type="text" name="name" placeholder="username" >
    <input type="text" name="email" placeholder="email@example.com" >
    <input type="text" name="password" placeholder="password eg.0101">
   <input type="submit" name="createAdmin" value="Create Admin" >
  </form>

  <?php else: ?>
    <!-- Delete Form -->
  <form action="#" method="post">
    <h3>Delete an account</h3>
    <input type="text" name="name" placeholder="username" value="<?= htmlspecialchars($r["username"]) ?>" disabled>
    <input type="text" name="email" placeholder="email@example.com" value="<?= htmlspecialchars($r["email"]) ?>" disabled>
    <input type="text" name="account_no" placeholder="account number" value="<?= htmlspecialchars($r["account_no"]) ?>"  disabled>
    <input type="submit" name="delete" value="Delete">
  </form>
<?php endif; ?>
  
</body>
</html>