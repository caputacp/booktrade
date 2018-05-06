<?php
SESSION_START();
if(isset($_POST['deleteMessage'])){
connectToDatabase();
$deleteQuery = $connectionToDatabase->prepare("DELETE FROM messages WHERE messageID = :messageID");
$deleteQuery->bindParam(':messageID', $_POST['deleteMessage']);
$deleteQuery->execute();
abortDatabaseConnection();
header('Location: #inbox');
}

 ?>
