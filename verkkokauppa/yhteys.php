<?php
  if($_SERVER["HTTP_HOST"]=="localhost"){
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "25p_1735";
  }else{
    $host = "localhost";
    $user = "25p_1735";
    $password = "jEk_BcvQ57/IAU)4";
    $database = "25p_1735";
    }
  $conn = new mysqli($host, $user, $password, $database);

  if($conn){echo "Yhteys onnistui";}
  else {echo "Yhteys epäonnistui";}
