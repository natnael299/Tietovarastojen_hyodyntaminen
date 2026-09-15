<?php
 include("yhteys.php");

 $stmt = "SELECT * from Customers";
 $result = $conn-> query($stmt);
 $data[] = $result->fetch_assoc()
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
        <th>name</th>
        <th>price</th>
      </tr>
    </thead>
    <tbody>
     <?php foreach($data as $d): ?>
          <tr>
            <td><?= $d["name"]; ?></td>
            <td><?= $d["price"]; ?></td>
          </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  
 </body>
 </html>