<?php

if( isset($_POST['username'])
and isset($_POST['password'])
and !is_null($_POST['username'])
and !is_null($_POST['password'])) {
  $loginTime = date(dmYhms);
  $loginUserName = $_POST['username'];
  $loginUserPassword = $_POST['password'];

  connectToDatabase();

  $loginQuery = $connectionToDatabase->query("SELECT * FROM `user` WHERE userName = '$loginUserName' AND userPassword = '$loginUserPassword'");
  $rowCount = $loginQuery -> rowCount();

  if($rowCount === 1){
    SESSION_START();
    $_SESSION["username"] = $loginUserName;
    $_SESSION["userLoggedin"] = TRUE;
    abortDatabaseConnection();
    goToHomePage();

    connectToDatabase();
    $loginTimeQuery = "UPDATE `booktrade`.`user`  SET `lastLogin`='$loginTime'  WHERE `userName`='$loginUserName'";
    $connectionToDatabase->exec($loginTimeQuery);
    abortDatabaseConnection();

  }else{
    $loginFailed = TRUE;
    $_SESSION["userLoggedin"] = FALSE;
  }

}
?>
