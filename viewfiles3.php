<?php
session_start();
include("include/dbconnect.php");

$uname = isset($_SESSION['uname']) ? $_SESSION['uname'] : '';
$ds = isset($_REQUEST['ds']) ? $_REQUEST['ds'] : '';
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$did = isset($_REQUEST['did']) ? intval($_REQUEST['did']) : 0;

// Handle delete action safely
if ($act == "del" && $did > 0) {
    $query = "DELETE FROM user_files WHERE id = $did";
    mysqli_query($conn, $query);
    header("Location: viewfiles3.php?ds=" . urlencode($ds));
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
          <li class="active"><a href="home_ms.php">Home</a></li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>

  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 style="margin-left:130px;"><span style="style=color:rgb(4, 128, 185);font-size:25px;">File Details </></h2>
          <form id="form1" name="form1" method="post" action="" style="margin-left:220px;">
            <table width="537" border="1" align="center" cellpadding="5" cellspacing="0">
              <tr>
                <th width="43" align="center" class="bg3" style="color:white;font-size:22px;">Sno</th>
                <th width="146" align="center" class="bg3" style="color:white;font-size:22px;">Client</th>
                <th width="146" align="center" class="bg3" style="color:white;font-size:22px;">Content</th>
                <th width="152" align="center" class="bg3" style="color:white;font-size:22px;">Uploaded File</th>
              </tr>
              <?php 
              $ds_safe = mysqli_real_escape_string($con, $ds);
              $query2 = mysqli_query($con, "SELECT * FROM user_files WHERE dserver = '$ds_safe'");
              $i = 0;
              while ($rs = mysqli_fetch_array($query2)) {
                  $i++;
              ?>
              <tr>
                <td class="bg4" style="color:white;font-size:22px;"><?php echo $i; ?></td>
                <td class="bg4" style="color:white;font-size:22px;"><?php echo htmlspecialchars($rs['uname']); ?></td>
                <td class="bg4" style="color:white;font-size:22px;"><?php echo htmlspecialchars($rs['file_content']); ?></td>
                <td class="bg4" style="color:white;font-size:22px;"><?php echo htmlspecialchars($rs['upload_file']); ?></td>
              </tr>
              <?php 
              }
              ?>
            </table>
          </form>
          <p>&nbsp;</p>
        </div>
        <div class="article">
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
  <div class="footer">
    <div class="footer_resize">
      <p class="lf">&copy; Deduplication</p>
      <ul class="fmenu">
        <li><a href="home_ms.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
  </div>
</div>
</body>
</html>
