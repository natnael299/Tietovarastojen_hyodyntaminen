<?php
include "conn.php" ;
$error = "";
try {
  if (isset($_POST["submit"])) {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if (!empty($email) && !empty($password)) {
      $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($r = $result->fetch_assoc()) {
          if ($password == $r["password"]) {
            $_SESSION["user_id"] = $r["id"];
            if ($r["role"] == "user") {
              header("Location: ./index.php");
              exit();
            } else {
              header("Location: ./dashboard.php");
              exit();
            }
          } else {
            $error = "Virheellinen salasana!!";
          }
        }
      } else {
        $error = "Käyttäjä ei löydy";
      }
    }
  };
} catch (mysqli_sql_exception  $e) {
  $error = "joku virhe on tapahtunut";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tietovisa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./style/general.css">
  <link rel="stylesheet" href="./style/login.css">
</head>

<body>
  <!-- login form -->
  <form class="body" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <h3>Verkko Pankki</h3>
    <input type="text" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="submit" name="submit" value="Kirjaudu">
    <?php if (!empty($error)): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  </form>
</body>

</html>