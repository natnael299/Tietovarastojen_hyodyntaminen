<?php
 include("yhteys.php");

 $stmt = "SELECT * from Customers";
 $result = $conn-> query($stmt);
 $data = $result->fetch_all(MYSQLI_ASSOC);
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
  background-color: rgba(140, 12, 12, 0.66);
  margin-top: 30px;
  margin-bottom: 30px;
color: #fff;
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
  <table>
    <thead>
      <tr>
        <th>first name</th>
        <th>last name</th>
        <th>address</th>
      </tr>
    </thead>
    <tbody>
     <?php foreach($data as $d): ?>
          <tr>
            <td><?= $d["first_name"]; ?></td>
            <td><?= $d["last_name"]; ?></td>
            <td><?= $d["address"]; ?></td>
          </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  
 </body>
 </html>