<?php
session_start();
include("include/dbconnect.php");
extract($_POST);

$msg = "";

if (isset($btn)) {
    if ($uname == "admin") {
        $qry = mysqli_query($con, "SELECT * FROM admin WHERE username='" . mysqli_real_escape_string($con, $uname) . "' AND password='" . mysqli_real_escape_string($con, $pass) . "'");
        $rs = mysqli_fetch_array($qry);
        $unamee = $rs['username'] ?? '';

        if ($unamee == $uname) {
            $_SESSION['uname'] = $uname;
            header("location:home_ms.php");
            exit();
        } else {
            $msg = "Invalid User!";
        }
    } else {
        $msg = "Invalid User!";
    }
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
<script language="javascript">
  function validate() {
    if (document.form1.uname.value == "") {
        alert("Enter the Username");
        document.form1.uname.focus();
        return false;
    }
    if (document.form1.pass.value == "") {
        alert("Enter the Password");
        document.form1.pass.focus();
        return false;
    }
    return true;
  }
</script>
</head>
<body style="background-color:white">
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
          <li><a href="index.php">Home</a></li>
          <li><a href="index_ds.php">Data Server</a></li>
          <li class="active"><a href="index_ms.php">Meta Server</a></li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>

  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 style="margin-left:130px;"><span style="style=color:rgb(4, 128, 185);font-size:25px;">Meta Server</span></h2>
          <form id="form1" name="form1" method="post" action="" style="margin-left:220px;">
            <table width="361" border="0" align="center" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" class="red" style="color:#FF0000"><?php echo $msg ?? ''; ?></td>
              </tr>
              <tr>
                <td width="141" align="left" style="color:white;font-size:22px;">Username</td>
                <td width="200" align="left"><input type="text" name="uname" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Password</td>
                <td align="left"><input type="password" name="pass" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input type="submit" name="btn" value="Login" style="background-color:rgb(4, 128, 185); color:white;" onclick="return validate()" /></td>
              </tr>
            </table>
          </form>
        </div>
<div class="article">
          <p>&nbsp;</p>
        </div>
      </div>
     
  <div class="fbg">
    <div class="fbg_resize"><div class="clr"></div></div>
  </div>
  <div class="footer">
    <div class="footer_resize">
      <p class="lf">&copy; Deduplication</p>
      <ul class="fmenu">
        <li><a href="index.php">Home</a></li>
        <li><a href="index_ds.php">Data Server</a></li>
        <li class="active"><a href="index_ms.php">Meta Server</a></li>
      </ul>
      <div class="clr"></div>
    </div>
  </div>
</div>
</body>
</html>
