<?php
include_once 'globalVars.php';
include_once 'functions.php';
include_once 'login.php';
include_once 'register.php';
include_once 'logout.php';
include_once 'booklist.php';
include_once 'addbooks.php';
include_once 'deletebook.php';
include_once 'library.php';
include_once 'adminusers.php';
include_once 'deleteuser.php';
include_once 'deletelibrary.php';
include_once 'sendproposal.php';
include_once 'inbox.php';
include_once 'deleteMessage.php';
include_once 'updateCurrentBook.php';
include_once 'home.php';
include_once 'bookPage.php';

/*Out of Scope - To be Added in future if the website is successful, THAT IS A RALLY RALLY BIG IF,*/
/* include_once 'shoppingCart.php'; */

SESSION_START();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name = "viewport" content = "user-scalable = yes, width = device-width, maximum-scale = 2" />
  <meta name = "apple-mobile-web-app-capable" content = "yes" />
  <meta name = "description" content = "Book trading platform for students, book-lovers and bookworms. Trading books are in physical form, not an E-Book.">
  <meta name = "keywords" content = "Book, trade, book trade, Physical Books, Buy Books, Sell Books, Trade Books">
  <link rel="stylesheet" media="screen and (min-width: 900px)" href="data/css/style.css" />
  <link rel="stylesheet" media="screen and (max-width: 900px)" href="data/css/style1.css" />
  <title>Book.trade</title>
</head>

<body <?php if($visited === FALSE):?> onload=' location.href="#home" '<?php endif; ?>>
  <?php $_SESSION['visited'] = TRUE; ?>
  <!--Top Bar-->
  <div id="topBarMenu" class="topBarMenu">

      <a id="title" active="active" href="#home">Book Trade   </a>
      <ul>
      <li><p><a href="#libraryContent" >Library</a></p></li>
      <?php if(isset($_SESSION["userLoggedin"]) && $_SESSION["userLoggedin"] == TRUE):?>

        <li><p><a href="#userBooks">My books</a></p></li>
        <li><p><a href="#newBooks">Add book</a></p></li>
        <li><p><a href="#inbox">Inbox <?php if($messageCount>0){echo "(".$messageCount.")";}?></a></p></li>
            <?php if(isset($_SESSION["username"])):?>
              <?php if($_SESSION["username"] === "Admin"):?>
                <li><p><a href ="#adminPage">Admin Tool</a></p></li>
              <?php endif; ?>
            <?php endif; ?>
            <li><p><a href="#logoutContent">Log out</a></p></li>
        <!-- <li><p><a href="#shoppingCart">CART</a></p></li> -->
      <?php else:?>
            <li><p><a href="#registerContent">Register</a></p></li>
            <li><p><a href="#loginContent">Sign in</a></p></li>
        <!-- <li><p><a href="#shoppingCart">CART</a></p></li> -->
      <?php endif;?>
    </ul>
  </div>

  <!--Scrollable Page-->
  <div id="content" class="content">


    <!--Admin's control page-->
    <div id="adminPage" class="adminPage">
      <form method = "post" >
        <table class="listTable">
          <thead>
            <th>Username</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php if(isset($_SESSION['username'])):?>
              <?php if($_SESSION['username'] === "Admin"):?>
                <?php foreach ($users as $user){ ?>
                  <tr>
                    <td ><?php echo $user['userName'];?></td>
                    <td ><button type="submit" name="deleteUser" id="deleteUser" value='<?php echo htmlspecialchars($count2)?>'>Remove</button></td>
                  </tr>
                  <?php $count2 = $count2 + 1; }?>
                <?php endif;?>
              <?php endif;?>
            </tbody>
          </table>
        </form>
      </div>




      <!--Library Content-->
      <div id="libraryContent" class="libraryContent">
        <!--SideBar-->
        <div id="toolbar" class="toolbar">
          <div id="toolbarHandle">

          <!--Library filter-->
          <div id="toolbarWrapper" class="toolbarWrapper">
            <!-- Search Library -->
            <form method = "post">
                  Search:
                  <input id="search" type="text" name="searchQuery" />
                  <button type="submit" name="searchButton" > Search</button>
                  || Sort Books By:
                  <button type="submit" name="sortName"  >Title</button>
                  <button type="submit" name="sortAuthor"  >Author</button>
                  <button type="submit" name="sortISBN"  >ISBN</button>
                  <button type="submit" name="sortAll" >Clear Search</button>
            </form>
          </div>
        </div>
        </div>

          <div id="libraryTable">

            <?php if($isBookAlreadyInCart === TRUE):?>
              <p class = "warning">Item Already In Cart</p>
            <?php endif;?>
            <table class="listTable">
              <thead>
                <th>Book</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Uploaded by</th>
                <th></th>
              </thead>

              <tbody>
                <form method="post">
                  <?php foreach ($_SESSION['library'] as $library1){ ?>
                    <tr>
                      <td><p id="libraryBookName"><?php echo $library1['bookName'];?></p></td>
                      <td ><p id="libraryBookAuthor"><?php echo $library1['bookAuthor'];?></p></td>
                      <td ><p id="libraryBoookISBN"><?php echo $library1['bookISBN'];?></p></td>
                      <td ><p id="libraryBookUploader"><?php echo $library1['userName'];?></p></td>
                      <td>
                        <button type = "submit" class="goToBookButton" id="goToBookButton" name ="goToBookButton" value= '<?php echo $library1['bookId'];?>'>View</button>
                      </td>
                    </tr>
                  <?php }?>
                </form>
              </tbody>
            </table>
          </div>

      </div>

      <!-- Inbox -->
      <div id="inbox" class="inbox">
        <p class="titleLine">Inbox</p>
        <table class="listTable">

          <form method="post">
            <thead>
              <th colspan="4"></th>
            </thead>
            <tbody>
              <?php foreach ($messages as $msg) {?>
                <tr <?php if($msg['read'] === 0){?> style="background-color:lightcyan" <?php }else{?>style="background-color:white"<?php } ?> >
                  <td ><?php echo $msg['fromUsername'];?> says:</td>
                  <td ><?php echo $msg['message'];?></td>
                  <td >
                    <input type="text" name="replyMessage" />
                  </td>
                  <td >
                    <button type="submit" name="sendReply" value='<?php echo htmlspecialchars($msg['messageID'])?>'>Reply</button>
                    <button type="submit" name="readMessage"   value='<?php echo htmlspecialchars($msg['messageID'])?>'  <?php if($msg['read'] === 1){?> style="color:#aaa;background-color:rgba(90,90,90,0.1)" disabled <?php }?>>Read</button>
                    <button type="submit" name="deleteMessage" value='<?php echo htmlspecialchars($msg['messageID'])?>'>Delete</button>
                  </td>

                  </tr>
                <?php }?>
              </tbody>
            </form>
          </table>
        </div>



        <!--Adding New Books-->
        <div id="newBooks" class="newBooks">
          <form  method="post" enctype="multipart/form-data">
            <table class="flexibleTable">
              <p class="titleLine">Add New Books</p>
              <tbody>
                <tr>
                  <td align="right">Book Name:</td>
                  <td align="left"><input id="newBookName"type="text" name="newBookName" /></td>
                </tr>

                <tr>
                  <td align="right">Book Author:</td>
                  <td align="left"><input id="bookAuthor" type="text"  name="bookAuthor" /></td>
                </tr>

                <tr>
                  <td align="right">Book Trade Condition:</td>
                  <td align="left"><input id="bookTradeCondition" type="text"  name="bookTradeCondition" /></td>
                </tr>

                <tr>
                  <td rowspan="2" align="right">Book Condition:</td>
                  <td align="left">
                    <input style="width:auto;" id="bookCondition" type="radio"  name="bookCondition" value="0"/>Used
                  </td>
                  <tr>
                    <td align="left">
                    <input style="width:auto;" id="bookCondition" type="radio"  name="bookCondition" value="1"/>New
                  </td>
                </tr>
                </tr>
                <tr>
                  <td align="right">Book Description:</td>
                  <td align="left"><input id="bookDescription" type="text"  name="bookDescription" /></td>
                </tr>


                <tr>
                  <td align="right">Book ISBN:</td>
                  <td align="left"><input id="bookISBN" type="text"  name="bookISBN" /></td>
                </tr>

                <tr>
                  <td align="right">Upload Book Image:</td>
                  <td align="left">
                    <input type="file" class="inputFile" name="newBookImage"/>
                  </td>
                </tr>

                <tr>
                  <td align="right"></td>
                  <td align="left"><button id="addBook" type="submit" name="addBook" />Add Book</button></td>
                </tr>
              </tbody>
            </table>

          </form>
        </div>

        <!--Update Books-->
        <a href="updateBooks"></a>
        <div id="updateBooks" class="updateBooks">
          <form  method="post" enctype="multipart/form-data">
            <table class="flexibleTable">
              <p class="titleLine">Update Book</p>
              <tbody>
                <?php foreach($_SESSION['targetBook'] as $book){?>
                  <tr>
                    <td align="right">Book Name:</td>
                    <td align="left"><input type="text" name="updateBookName" value='<?php echo $book['bookName']; ?>' /></td>
                  </tr>

                  <tr>
                    <td align="right">Book Author:</td>
                    <td align="left"><input id="bookAuthor" value='<?php echo $book['bookAuthor']; ?>'  type="text"  name="updateBookAuthor" /></td>
                  </tr>

                  <tr>
                    <td align="right">Book Trade Condition:</td>
                    <td align="left"><input type="text"  name="updateBookTradeCondition" value='<?php echo $book['tradeCondition']; ?>' /></td>
                  </tr>

                  <tr>
                    <td align="right">Book Condition:</td>
                    <td align="left">
                      <a>Used</a><input id="bookCondition" <?php if($book['bookCondition']===0){ ?> checked="checked" <?php } ?> type="radio"  name="updateBookCondition" value="0"/>
                      <a>New</a><input id="bookCondition" <?php if($book['bookCondition']===1){ ?> checked="checked" <?php } ?> type="radio"  name="updateBookCondition" value="1"/>
                    </td>
                  </tr>

                  <tr>
                    <td align="right">Book Description:</td>
                    <td align="left"><input type="text" value='<?php echo $book['bookDescription']; ?>'  name="updateBookDescription" /></td>
                  </tr>


                  <tr>
                    <td align="right">Book ISBN:</td>
                    <td align="left"><input id="bookISBN" value='<?php echo $book['bookISBN']; ?>'  type="text"  name="updateBookISBN" /></td>
                  </tr>

                  <tr>
                    <td align="right">Upload Book Image:</td>
                    <td align="left">
                      <input type="file" class="inputFile" name="updateBookImage"/>
                    </td>
                  </tr>

                  <tr>
                    <td align="right"></td>
                    <td align="left"><button value='<?php echo $book['bookId']; ?>' type="submit" name="updateCurrentBook" />Update Book</button></td>
                  </tr>
                </tbody>
              <?php }?>
            </table>

          </form>
        </div>


        <!--Login-->
        <div id="loginContent" class="loginContent">
          <form method="post">
            <p id="titleLine" class="titleLine">Login</p>
            <?php if($loginFailed===true):?><p class = "warning">Invalid credentials!</p><?php endif;?>
            <table class="flexibleTable">
              <thead>
              </thead>
              <tbody>
                <tr>
                  <td >Username:</td>
                  <td><input id="username"type="text" name="username" /></td>
                </tr>

                <tr>
                  <td >Password:</td>
                  <td><input id="password" type="password" name="password" /></td>
                </tr>

                <tr>
                  <td ></td>
                  <td><button type="submit" name="submit" value="Submit" >Submit</button></td>
                </tr>
              </tbody>
            </table>

          </form>
        </div>

        <!--Shopping Cart
        <div id="shoppingCart" class="shoppingCart">
        <form method="post">
        <p id="titleLine" class="titleLine">Cart</p>
        <table>
        <?php if(isset($_SESSION['cartArray']) and isset($_SESSION['cartPriceCount'])): ?>
        <thead>
        <th >Book </th>
        <th >Price</th>
      </thead>
      <tbody>
      <?php foreach($_SESSION['cartArray'] as $cartContent){?>
      <?php if(!empty($cartContent['cartBookName']) AND !empty($cartContent['cartBookPrice'])): ?>
      <tr>
      <td ><?php echo $cartContent['cartBookName']; ?></td>
      <td ><?php echo $cartContent['cartBookPrice']; ?></td>
      <td ><button type="submit" name="removeCartBook" id="removeCartBook" value='<?php echo $cartCount;?>'>Remove</button>
    </tr>
  <?php endif; ?>
  <?php $cartCount = $cartCount + 1;}?>
  <tr>
  <td style="color:red;font-weight:bold"> Total amount:</td>
  <td style="color:red;font-weight:bold"><?php echo $_SESSION['cartPriceCount']; ?></td>
</tr>
<tr>
<td align="right"><button type="submit" name="resetCart" id="resetCart" >Reset</button></td>
<td align="left"><button type="submit" name="payForCartItems" id="payForCartItems"> Pay </button></td>
<?php endif;?>
</tr>
</tbody>
</table>


</form>
</div>
Cart Finished -->




<!--register content-->
<div id="registerContent" class="registerContent" >
  <form method="post">
    <p class="titleLine">Register</p>

    <?php if($emptyRegisterFields === TRUE):?>
      <p class = "warning">All fields are required</p>
    <?php endif;?>

    <?php if($userNameLengthValid === FALSE):?>
      <p class = "warning">Username must be between 4 to 12 characters<br></p>
    <?php endif;?>

    <?php if($userFirstCharValid === FALSE):?>
      <p class = "warning">Username should not start with a number nor with a space</p>
    <?php endif;?>

    <?php if($passwordMatched === FALSE):?>
      <p class = "warning">Password did not match</p>
    <?php endif;?>

    <?php if($passwordValid === FALSE):?>
      <p class = "warning">
        Password must be alphanumeric containing at least one symbol<br>
      </p><?php endif;?>

      <?php if($passwordLengthValid === FALSE):?>
        <p class = "warning">Password must be between 6 to 12 characters</p>
      <?php endif;?>

      <?php if($userNameExists === TRUE):?>
        <p class = "warning">Username already exists<br></p>
      <?php endif;?>

      <?php if($userNameInvalid === TRUE):?>
        <p class = "warning">Invalid Username: Spcial characters not allowed<br></p>
      <?php endif;?>

      <?php if($emailExists === TRUE):?>
        <p class = "warning">Email already exists<br></p>
      <?php endif;?>

      <?php if($registrationSuccessful === TRUE):?>
        <p style="color:#262;font-weight:bold;text-align:center">Regisrtation successful!<br></p>
      <?php endif;?>

      <?php if($isMailDone === TRUE):?>
        <p style="color:#262;font-weight:bold;text-align:center">An email is sent to your account please check to verify your registration.<br></p>
      <?php elseif($isMailDone === FALSE):?>
        <p class = "warning">Email not valid!<br></p>
      <?php endif;?>

      <table class="flexibleTable">
        <thead></thead>
        <tbody>
          <tr>
            <td>Username:</td>
            <td><input id="usernamesignup"type="text" name="usernamesignup" /></td>
          </tr>

          <tr>
            <td >Email:</td>
            <td align="left"> <input id="emailsignup"type="text" name="emailsignup" /></td>
          </tr>

          <tr>
            <td >Password:</td>
            <td><input id="passwordsignup" type="password" name="passwordsignup" /></td>
          </tr>

          <tr>
            <td >Confirm Password:</td>
            <td><input id="passwordsignup_confirm" type="password" name="passwordsignup_confirm" /></td>
          </tr>

          <tr>
            <td ></td>
            <td><button type="submit" name="register" id="register"/>Register</button></td>
          </tr>
        </tbody>
      </table>

    </form>
  </div>



  <!--Logout-->
  <div id="logoutContent" class="logoutContent">

    <form method="post">
      <p class="titleLine">Log Out</p>
      <table class="flexibleTable">
        <thead>
        </thead>
        <tbody>
          <tr>
            <td><button type="submit" id="logoutYes" name="logoutYes" >Yes!</button></td>
            <td><button type="submit" id="logoutNo" name="logoutNo" >No!</button></td>
          </tr>
          </form>
        </tbody>
      </table>

    </div>

    <!--Current Books-->
    <div id="userBooks" class="userBooks">
      <form method="post">
        <table class="listTable">
          <thead>
            <th></th>
            <th>Book Name</th>
            <th>Trade Condition</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php foreach ($bookList as $book):?>
              <tr>
                <td><img src="<?php echo "book_images/".$book['bookImageID']?>" alt="N/A<?php /*echo $library1['bookName'];*/?>" style="width:50px;height:50px;border-radius:50%;"></td>
                <td><p id="libraryBookName"><?php echo $book['bookName'];?></p></td>
                <td ><p id="libraryBookTradeCondition"><?php echo $book['tradeCondition'];?></p></td>
                <td >
                  <button type="submit" name="editBookButton" id="editBookButton" value='<?php echo $book['bookId'];?>'>Edit</button>
                  <button type="submit" name="deleteBook" id="deleteBook" value='<?php echo $book['bookId'];?>'>Delete</button>
                </td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </form>
    </div>


    <!-- bookPage -->
    <div id="bookPage">
      <div id="bookPageWrapper">
        <form method="post">
          <?php if($userMustLogIn === TRUE):?>
            <p class = "warning">You need to Log In in order to trade</p>
          <?php endif;?>
          <table class="flexibleTable">
            <?php foreach ($_SESSION['getBook'] as $book):?>
              <p id="bookPageImage"><img src="<?php echo "book_images/".$book['bookImageID']?>" alt="Book Image" style="min-width:80px;min-height:100px;max-width:200px;max-height:400px;"></p>
              <tbody>
                  <tr>
                    <td > Book Name: </td>
                    <td><?php echo $book['bookName'];?></td>
                  </tr>
                  <tr>
                    <td> Author: </td>
                    <td><?php echo $book['bookAuthor'];?></td>
                  </tr>
                  <tr>
                    <td> BookISBN: </td>
                    <td><?php echo $book['bookISBN'];?></td>
                  </tr>
                  <tr>
                    <td> Book Description: </td>
                    <td><?php echo $book['bookDescription'];?></td>
                  </tr>
                  <tr>
                    <td> Uploaded by: </td>
                    <td><?php echo $book['userName'];?></td>
                  </tr>
                  <tr>
                    <td> Trade Condition:</td>
                    <td><?php echo $book['tradeCondition'];?></td>
                  </tr>
                  <tr>
                    <td> Send Trade Proposal:</td>
                    <td><input type="text" name="proposalMessage" />
                      <button type="submit" name="sendProposal" value="<?php echo htmlspecialchars($book['bookId']);?>">Send</button></td>
                    </tr>
                  </tbody>
                <?php endforeach;?>
              </table>
            </form>
          </div>
        </div>

        <!--Welcome Page-->
        <div id="home" class="home">
          <div id="homedv1" class="homediv">
            <p class="typingText">Join the community :)<br><br></p>
          </div>
          <div id="homedv2" class="homediv">
            <p  class="typingText">Trade books...</p>
          </div>
          <div id="homedv3" class="homediv">
            <p  class="typingText">Trade thoughts</p>
          </div>
          <div id="homedv4" class="homediv">
            <p class="typingText">Explore books</p>
          </div>
          <div id="homedv5" class="homediv">
            <p class="typingText">Share love <3</p>
          </div>

        </div>


      </div>
    </body>
    </html>
