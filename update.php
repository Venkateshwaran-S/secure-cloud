<?php
session_start();
include("include/dbconnect.php");

$uname = $_SESSION['uname'];
extract($_POST);

$query = $con->query("SELECT * FROM user_reg WHERE username='$uname'");
$res2 = $query->fetch_assoc();
$skey = $res2['signature'];
$owner = $res2['dserver'];

if (isset($btn) && $btn == "Upload") {
    $query = $con->query("SELECT * FROM user_reg WHERE username='$uname'");
    $res2 = $query->fetch_assoc();
    $skey = $res2['signature'];
    $dserver = $res2['dserver'];

    $ftype = $_FILES['file']['type'];
    $fileName = $_FILES['file']['name'];

    $query3 = $con->query("SELECT * FROM user_files WHERE upload_file='$fileName'");
    $res3 = $query3->fetch_assoc();
    $fn = isset($res3['upload_file']) ? $res3['upload_file'] : '';

    if ($fn == $fileName) {
        if ($skey == $key) {
            $query4 = $con->query("SELECT MAX(id) AS maxid FROM user_files");
            $ns = $query4->fetch_assoc();
            $id2 = $ns['maxid'] + 1;

            // Ensure user directory exists
            if (!file_exists("upload/" . $uname)) {
                mkdir("upload/" . $uname, 0777, true);
            }

            move_uploaded_file($_FILES['file']['tmp_name'], "upload/" . $uname . "/" . $fileName);
            header("location:viewfiles.php");
            exit;
        } else {
            echo "<script>alert('Invalid Signature!');</script>";
        }
    } else {
        echo "<script>alert('Invalid File!');</script>";
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php include("include/title.php"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section -->
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/arial.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
<!-- CuFon ends -->

</head>

<body>

<div class="main">

  <div class="header" style="background-image:none;  width:1655px; font-family:'Times New Roman', Times, serif;">
    
      <div class="logo" style="background-color:rgb(3, 23, 31);padding:20px 50px;margin-left:1px; margin-top:10px;">
        <h1 style="style=color:rgb(242, 247, 249); font-family:'Times New Roman', Times, serif; margin-left:235px;">
          <b>
            SECURE CLOUD STORAGE WITH DEDUPLICATION </b><br />
           </h1></div>
            <hr>
      <div class="clr"></div><br><br>
      
      <div class="menu_nav" style="margin-left:150px;">
        <ul>
          <li><a href="userhome.php">Home</a></li>
          <li class="active"><a href="viewfiles.php">Files</a></li>
        </ul>
        <div class="clr"></div>
      </div>
      
      <div class="clr"></div>
     
    </div>
  </div>

  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 style="margin-left:130px;"><span style="style=color:rgb(4, 128, 185);font-size:25px;">Update File  </span></h2>
          <form name="form1" method="post" action="" enctype="multipart/form-data" style="margin-left:220px;">
            <table width="362" height="137" border="0" align="center" cellpadding="5" cellspacing="0" class="bg2">
              <tr>
                <td style="color:white;font-size:22px;">Signature</td>
               <td> <input type="password" style="margin-right:30px; width:250px;" name="key" value=""> </td>
              </tr>
              <tr>
                <td style="color:white;font-size:22px;">Select File </td>
                <td><input type="file" name="file" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="btn" value="Upload" /></td>
              </tr>
            </table>
     </form>
          <p align="center" class="hd2">&nbsp;</p>
          <p>&nbsp;</p>
        </div>
        
      </div>
      <div class="clr"></div>
    </div>
  </div>

  <div class="fbg">
    <div class="fbg_resize">
      <div class="clr"></div>
    </div>
  </div>
  <div class="footer" style="margin-top:100px;">
    <div class="footer_resize">
      <p class="lf">&copy; Deduplication</p>
      <ul class="fmenu">
        <li class="active"><a href="userhome.php">Home</a></li>
        <li><a href="viewfiles.php">Files</a></li>
          <li><a href="logout.php">Logout</a></li>
      </ul>
      <div class="clr"></div>
    </div>
  </div>
</div>
</body>
</html>

