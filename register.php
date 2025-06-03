<?php
session_start();
include("include/dbconnect.php"); // Make sure this uses mysqli internally

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn']) && $_POST['btn'] == "Register") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $location = $_POST['location'];
    $company = $_POST['company'];
    $desig = $_POST['desig'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $rdate = date("d-m-Y");

    // Get next ID (not recommended for production, better to use AUTO_INCREMENT)
    $qry = mysqli_query($con, "SELECT MAX(id) AS maxid FROM register");
    $rs = mysqli_fetch_array($qry);
    $id2 = $rs['maxid'] + 1;

    $stmt = mysqli_prepare($con, "INSERT INTO register (id, name, email, contact, location, company, desig, uname, pass, rdate, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0')");
    mysqli_stmt_bind_param($stmt, "isssssssss", $id2, $name, $email, $contact, $location, $company, $desig, $uname, $pass, $rdate);
    $ins = mysqli_stmt_execute($stmt);

    if ($ins) {
        echo "<script>alert('Registered Successfully...'); window.location.href='index_ds.php';</script>";
    } else {
        echo "<script>alert('Registration failed: " . mysqli_error($con) . "');</script>";
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
      <script language="javascript">
function validate()
{
	if(document.form1.name.value=="")
	{
	alert("Enter the Name");
	document.form1.name.focus();
	return false;
	}
	if(document.form1.email.value=="")
	{
	alert("Enter the E-mail");
	document.form1.email.focus();
	return false;
	}
	if(document.form1.contact.value=="")
	{
	alert("Enter the Contatc No.");
	document.form1.contact.focus();
	return false;
	}
	if(document.form1.location.value=="")
	{
	alert("Enter your Location / City");
	document.form1.location.focus();
	return false;
	}
	if(document.form1.email.value=="")
	{
	alert("Enter the E-mail");
	document.form1.email.focus();
	return false;
	}
	if(document.form1.company.value=="")
	{
	alert("Enter the Company");
	document.form1.company.focus();
	return false;
	}
	if(document.form1.desig.value=="")
	{
	alert("Enter the Designation");
	document.form1.desig.focus();
	return false;
	}
	if(document.form1.pass.value=="")
	{
	alert("Enter the Password");
	document.form1.pass.focus();
	return false;
	}
	if(document.form1.pass.value!=document.form1.cpass.value)
	{
	alert("Both password are not equals!");
	document.form1.cpass.select();
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
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="index_ds.php">Data Server</a></li>
          <li><a href="index_ms.php">Meta Server</a></li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>

  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 style="margin-left:130px;"><span style="style=color:rgb(4, 128, 185);font-size:25px;">Data Server </span></h2>
          <form id="form1" name="form1" method="post" action="" style="margin-left:220px;">
            <table width="337" border="0" align="center" cellpadding="5" cellspacing="0">
              <tr>
                <td colspan="2" align="center" class="hd3" style="color:white;font-size:24px;"><strong>Registration</strong></td>
              </tr>
              <br>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Name</td>
                <td align="left"><input type="text" name="name" style="margin-right:30px; width:250px;" /></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">E-mail</td>
                <td align="left"><input type="text" name="email" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Contact No. </td>
                <td align="left"><input type="text" name="contact" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Location</td>
                <td align="left"><input type="text" name="location" style="margin-right:30px; width:250px;" /></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Company</td>
                <td align="left"><input type="text" name="company" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Designation</td>
                <td align="left"><input type="text" name="desig" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Username</td>
                <td align="left"><input type="text" name="uname" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Password</td>
                <td align="left"><input type="password" name="pass" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Confirm Password </td>
                <td align="left"><input type="password" name="cpass" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
                <td align="left"><input type="submit" name="btn" value="Register" onClick="return validate()" /></td>
              </tr>
            </table>
          </form>
          <p>&nbsp;</p>
        </div>
        <div class="article">
          <p>&nbsp;</p>
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
        <li><a href="index.php">Home</a></li>
        <li class="active"><a href="index_ds.php">Data Server</a></li>
        <li><a href="index_ms.php">Meta Server</a></li>
      </ul>
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
  </div>
</div>
</body>
</html>
