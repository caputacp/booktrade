<?php
SESSION_START();

if(isset($_POST["sendProposal"])){
  if(isset($_SESSION['username'])){

    $userMustLogIn = FALSE;
    $getBook = array();
    $getBook = getBook($_POST['sendProposal']);

    foreach($getBook as $book){
      $toUsername = $book['userName'];
      $fromUsername = $_SESSION['username'];
      $message = $_POST["proposalMessage"];
      $forBook = $book['bookName'];
    }

      try{
        connectToDatabase();
        $proposalQuery = $connectionToDatabase->prepare("INSERT INTO messages (toUsername, fromUsername, message, forBook) VALUES (:toUsername, :fromUserame, :message, :forBook)");
        $proposalQuery->bindParam(':toUsername', $toUsername);
        $proposalQuery->bindParam(':fromUserame', $fromUsername);
        $proposalQuery->bindParam(':message', $message);
        $proposalQuery->bindParam(':forBook', $forBook);
        $proposalQuery->execute();
        abortDatabaseConnection();


        header('Location: #libraryContent');

      }catch(PDOException $e){
        echo $e;
      }

  }else{
    $userMustLogIn = TRUE;
  }
}

 ?>
