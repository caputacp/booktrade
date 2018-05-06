<?php
SESSION_START();
$count2 = 0;
connectToDatabase();
try{
  $admin = $_SESSION["username"];
  if($admin === 'Admin'){
  $usersQuery = $connectionToDatabase->prepare ("SELECT userName FROM user");
  $usersQuery->execute();
  $users = $usersQuery->fetchall();
  }
  abortDatabaseConnection();
}catch (PDOException $e) {
  echo "HAHAHAHAHA";
}



 ?>
