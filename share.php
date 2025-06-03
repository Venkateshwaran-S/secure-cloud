<?php 
session_start();
include("include/dbconnect.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php include("include/title.php"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/arial.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
</head>

<body>

<?php
$uname = $_SESSION['uname'];
extract($_POST);
$fid = $_REQUEST['fid'];
//$rdate = date("d-m-Y");

// Get file details
$q1 = $con->query("SELECT * FROM user_files WHERE id='$fid'");
$r1 = $q1->fetch_assoc();
$owner = $r1['dserver'];

if (isset($btn)) {
    // Check if client exists
    $query = $con->query("SELECT * FROM user_reg WHERE username='$cname'");
    if ($query->num_rows == 1) {
        $mq1 = $con->query("SELECT MAX(id) AS maxid FROM share");
        $mr1 = $mq1->fetch_assoc();
        $mid = $mr1['maxid'] + 1;

        $stmt = $con->prepare("INSERT INTO share(id, owner, uname, cname, fid) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $mid, $owner, $uname, $cname, $fid);
        $stmt->execute();

        echo "<script>alert('Shared Successfully'); window.location.href='viewfiles.php';</script>";
    } else {
        echo "<script>alert('Invalid Client!');</script>";
    }
}
?>  

<div class="main" >
<div class="header" style="background-image:none;  width:1655px; font-family:'Times New Roman', Times, serif;">
  <div class="logo" style="background-color:rgb(3, 23, 31);padding:20px 50px;margin-top:10px;">
       <h1 style="style=color:rgb(253, 244, 244); font-family:'Times New Roman', Times, serif; margin-left:235px;">
      <b>SECURE CLOUD STORAGE WITH DEDUPLICATION </b><br />
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
      <div class="searchform"></div>
      <div class="clr"></div>
      
    </div>
  </div>

  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 style="margin-left:130px;"><span style="style=color:rgb(4, 128, 185);font-size:25px;">Share File </span></h2>
          <form name="form1" method="post" action="" style="margin-left:220px;">
            <p>&nbsp;</p>
            <table width="277" border="0" align="center" cellpadding="5" cellspacing="0">
              <tr>
                <th align="left" style="color:white;font-size:22px;">File</th>
                <th align="left" style="color:white;font-size:22px;"><?php echo $r1['upload_file']; ?></th>
              </tr>
              <tr>
                <td style="color:white;font-size:22px;">Client</td>
                <td><input type="text" name="cname" style="margin-right:30px; width:250px;"></td>
              </tr>
              <br>
              <tr>
                <td>&nbsp;</td>
                
                <td ><input type="submit" name="btn" value="Submit" style="background-color:rgb(4, 128, 185); color:white; font-size:17px;"></td>
              </tr>
            </table>
            <p>&nbsp;</p>
          </form>
          <p align="center" class="hd2">&nbsp;</p>
        </div>
      </div>
      <div class="clr"></div>
    </div>
  </div>

  <div class="fbg">
    <div class="fbg_resize"><div class="clr"></div>
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
</body>
</html>
