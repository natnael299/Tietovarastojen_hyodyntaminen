<?php
 include("yhteys.php");

 $stmt = "SELECT * from products";
 $result = $conn-> query($stmt);
 $data[] = $result->fetch_assoc();
?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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