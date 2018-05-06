<?php
SESSION_START();
if(isset($_POST['editBookButton'])){
  $_SESSION['updateBookID'] = $_POST['editBookButton'];
  $_SESSION['targetBook'] = array();
  $_SESSION['targetBook'] = getBook($_SESSION['updateBookID']);
  goToUpdateBooks();

  }

  if(isset($_POST['updateCurrentBook'])){

    $updateBookTime = date(dmYhms);
    $updateBookErrors = array();

    connectToDatabase();
    if($_POST['updateBookName'] === ''){
      $updateBookName = "none";
    }else{
      $updateBookName = stripslashes($_POST['updateBookName']);
    }

    if($_POST['bookDescription'] === ''){
      $updateBookDescription = "none";
    }else{
      $updateBookDescription = stripslashes($_POST['updateBookDescription']);
    }

    if($_POST['updateBookTradeCondition'] === ''){
      $updateBookTradeCondition = "none";
    }else{
      $updateBookTradeCondition = $_POST['updateBookTradeCondition'];
    }

    if($_POST['updateBookISBN'] === ''){
      $updateBookISBN = "none";
    }else{
      $updateBookISBN = $_POST['updateBookISBN'];
    }
    if($_POST['updateBookAuthor'] === ''){
      $updateBookAuthor = "none";
    }else{
      $updateBookAuthor = $_POST['updateBookAuthor'];
    }
    $updateBookUserName = $_SESSION["targetBook"][0]['userName'];

    if(!empty($_FILES['updateBookImage']['size'])){
      $errors = array();
      $file_name = $_FILES['updateBookImage']['name'];
      $file_size = $_FILES['updateBookImage']['size'];
      $file_tmp =$_FILES['updateBookImage']['tmp_name'];
      $file_type=$_FILES['updateBookImage']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['updateBookImage']['name'])));

      $expensions= array("jpeg","jpg","png", "JPEG", "JPG", "PNG");

      if(in_array($file_ext,$expensions)=== false){
        $uploadErrors[]="filetype";
      }

      if($file_size > 2097152){
        $errors[]='filesize';
      }

      if(file_exists("book_images/".$file_name)){
        $errors[]='filename';
      }

      if(empty($errors) === TRUE){
        echo "uploading!!!";
        move_uploaded_file($file_tmp,"book_images/".$file_name);
        $newBookImageUploaded=TRUE;
      }else{
        $newBookImageUploaded=FALSE;
        print_r($errors);
      }
    }else{
      foreach($_SESSION['targetBook'] as $book){
        $file_name = $book['bookImageID'];
      }
    }




    try{
      connectToDatabase();
      $updateBookQuery = $connectionToDatabase->prepare("UPDATE bookList SET userName =?, bookName=?, tradeCondition=?, bookISBN=?, bookAuthor=?, bookImageID=?, bookDescription=?, bookCondition=?, dateTimeAdded=?  WHERE bookId =?");
      $updateBookQuery->bindParam(1, $updateBookUserName);
      $updateBookQuery->bindParam(2, $updateBookName);
      $updateBookQuery->bindParam(3, $updateBookTradeCondition);
      $updateBookQuery->bindParam(4, $updateBookISBN);
      $updateBookQuery->bindParam(5, $updateBookAuthor);
      $updateBookQuery->bindParam(6, $file_name);
      $updateBookQuery->bindParam(7, $updateBookDescription);
      $updateBookQuery->bindParam(8, $_POST['updateBookCondition']);
      $updateBookQuery->bindParam(9, $updateBookTime);
      $updateBookQuery->bindParam(10, $_POST['updateCurrentBook']);
      $updateBookQuery->execute();
      abortDatabaseConnection();
      goToUserBooks();

    }catch (PDOException $e) {
      echo "Oops Something went wrong...";
    }
  }
  ?>
