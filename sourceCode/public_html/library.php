<?php
SESSION_START();
$count1 = 0;
$count3 = 0;

try{

  $_SESSION['library'] = array();
$_SESSION['library'] = showLibrary();
if(isset($_POST['searchButton'])){
  connectToDatabase();
  $searchQuery = stripslashes($_POST['searchQuery']);
  $libraryQuery = $connectionToDatabase->prepare ("SELECT * FROM bookList WHERE (bookName = :bookName) OR (bookAuthor = :bookAuthor) OR (bookISBN = :bookISBN) OR (userName = :userName) ");
  $libraryQuery->bindParam(':bookName', $searchQuery);
  $libraryQuery->bindParam(':bookAuthor', $searchQuery);
  $libraryQuery->bindParam(':bookISBN', $searchQuery);
  $libraryQuery->bindParam(':userName', $searchQuery);

  $libraryQuery->execute();
  $library = $libraryQuery->fetchall();
  $_SESSION['library'][] = array();
  $_SESSION['library'] = $library;
  abortDatabaseConnection();
  $_SESSION['filterPosted'] = TRUE;

}
if(isset($_POST['sortAll'])){
  $library = showLibrary();
  $_SESSION['library'] = $library;

}
if(isset($_POST['sortName'])){
  usort($_SESSION['library'], 'sortName');

}
if(isset($_POST['sortAuthor'])){
  usort($_SESSION['library'], 'sortAuthor');

}
if(isset($_POST['sortISBN'])){
  usort($_SESSION['library'], 'sortISBN');
}

}catch (PDOException $e) {
  echo $e;
}

?>
