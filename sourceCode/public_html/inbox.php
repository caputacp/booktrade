<?php
SESSION_START();
$count5 = 0;
$messageCount = 0;

connectToDatabase();

try{
  $temp = $_SESSION["username"];
  $inboxQuery = $connectionToDatabase->prepare ("SELECT * FROM messages WHERE toUsername= '$temp' ");
  $inboxQuery->execute();
  $messages = $inboxQuery->fetchall();

  foreach($messages as $msg){
    if($msg['read'] === 0){
      $messageCount += 1;
    }
  }



  abortDatabaseConnection();
}catch (PDOException $e) {
  echo $e;
}

if(isset($_POST["sendReply"])){

  $getMsg = array();
  $getMsg = getMessage($_POST['sendReply']);

  foreach($getMsg as $msg){
    $toUsername = $msg['fromUsername'];
    $fromUsername = $_SESSION['username'];
    $message = $_POST['replyMessage'];
  }

    connectToDatabase();
    try{
      $addMessageQuery =
      "INSERT INTO messages (toUsername, fromUsername, message)
      VALUES ('$toUsername','$fromUsername','$message')";
      $connectionToDatabase->exec($addMessageQuery);

      abortDatabaseConnection();
      header('Location: #inbox');

    }catch(PDOException $e){
      echo "Something went wrong";

    }

}

if(isset($_POST["readMessage"])){
    try{
      connectToDatabase();
      $temp = 1;
      $updateQuery = $connectionToDatabase->prepare("UPDATE `booktrade`.`messages` SET `read` =? WHERE `messageID` =?");
      $updateQuery->bindParam(1, $temp);
      $updateQuery->bindParam(2, $_POST['readMessage']);
      $updateQuery->execute();
      abortDatabaseConnection();

      header('Location: #inbox');

    }catch(PDOException $e){
      echo $e;

    }

}


?>
