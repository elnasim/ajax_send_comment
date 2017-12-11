<?php

include_once 'db_connect.php';

$comments = mysqli_query($connection, "SELECT * FROM `comments`");

while ($comment = mysqli_fetch_assoc($comments)) {
  print json_encode($comment);
};