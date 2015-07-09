<?php

include("db.php");
$conn = dbh();


if (isset($_POST['submit'])){

  $tdate = date("d-m-y"); ;
  $br = $_POST['br'];
  $comment = $_POST['comment'];

  date_default_timezone_set('UTC');

  if (!empty($br) || !empty($comment)){
    $ins = $conn->prepare("INSERT INTO br (date, br, comment) VALUES(:tdate, :br, :comment)");
    $ins->bindParam(':tdate', $tdate);
    $ins->bindParam(':br', $br);
    $ins->bindParam(':comment', $comment);
    $ins->execute();
  }
}
?>

<!DOCTYPE html>
<html>
<body>
  <head>
    <title>My Battle Rating Progress</title>
    <link rel="Stylesheet" href="style.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:700italic,300,400' rel='stylesheet' type='text/css'>
  </head>

  <div id="main">

    <div id="h-content">

      <h1>My Wartune Progress</h1>
      <p>This website is personal website to keep track of my progress on a Browser Turn based MMO game called Wartune. It has something called "Battle Rating" which in essence is your "toons score" ie. Your combined gear score, your pets score etc. I want to track this on a day by day basis to see how I'm upgrading.</p>

    </div>

    <div id="contentarea">
        <table>
          <th>Todays Date</th>
          <th>Battle Rating</th>
          <th>Comments</th>

          <?php
          $sth = $conn->prepare("SELECT * FROM br ORDER BY id DESC");
          $sth->execute();
          $tbd = $sth->fetchAll();

          foreach ($tbd as $row) {

          echo "<tr>";
          echo "<td>" . $row['date'] . "</td>";
          echo "<td>" . $row['br'] . "</td>";
          echo "<td>" . $row['comment'] . "</td>";
        }
          ?>

        </table>

      </div>

    <div id="inputdata">
      <form action=<?php echo $_SERVER["PHP_SELF"]; ?> method="post">
        <input name="br" placeholder="BR..." type="text" name="newbr">
        <textarea name="comment" placeholder="Comments..." cols="65" rows="15"></textarea><br />
        <input name="submit" type="submit" value="Submit">
      </form>

    </div>

  </div>
