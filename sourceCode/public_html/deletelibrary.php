<?php

if(isset($_POST['adminDeleteBook'])){

    $temp1 = $_POST['adminDeleteBook'];
    $username = $library[$temp1][0];
    $bookname = $library[$temp1][1];

  connectToDatabase();

  $deleteLibraryQuery = "DELETE FROM bookList WHERE userName = '$username' and bookName = '$bookname'";
  $connectionToDatabase -> exec($deleteLibraryQuery);



  abortDatabaseConnection();
  header("Location: #libraryContent");
}

 ?>
