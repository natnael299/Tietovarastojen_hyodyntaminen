<?php 
include("conn.php");
$query = "SELECT requests.*, users.username, users.email FROM requests JOIN users on requests.user_id=users.id WHERE requests.completed=0";
$stmt=$conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
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
  <h1>Open Requests</h1>
    <!-- the table of users -->
     <table class="desktop">
      <thead>
        <tr>
          <th>users</th>
          <th>email</th>
          <th>request type</th>
          <th>complete action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($r = $result->fetch_assoc()):  ?>
          <tr>
            <th><?= $r["username"]?></th>
            <th><?= $r["email"]?></th>
            <th><?= $r["type"]?> </th>
            <th>
              <?php if($r["type"]=="deletion"): ?>
                <a href="./adminAction.php?id=<?= $r["user_id"]   ?>&action=delete&account=<?= $r["id"] ?>">To Delete</a>
                <?php else: ?>
                <a href="./adminAction.php?id=<?= $r["user_id"]   ?>&action=create">To Create</a>
              <?php endif; ?>
            </th>
          </tr>
        <?php endwhile;  ?>
      </tbody>
    </table>  
</body>
</html>