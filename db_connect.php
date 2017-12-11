<?php

$connection = mysqli_connect(
    'localhost',
    'root',
    'root',
    'test_honey'
);

if ($connection==false) {
  echo 'Ошибка соединения с базой данных';
  exit();
}



