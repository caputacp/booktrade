<?php
if(isset($_POST['goToBookButton'])){
  $_SESSION['getBookID'] = $_POST['goToBookButton'];
  $_SESSION['getBook'] = array();
  $_SESSION['getBook'] = getBook($_SESSION['getBookID']);
  goToBookPage();
  }

?>
