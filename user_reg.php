<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("include/dbconnect.php");

// Include PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['btn'])) {
    $dserver = $_POST['dserver'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $cdate = date("d-m-Y");

    if ($pass !== $cpass) {
        echo "<script>alert('Passwords do not match'); window.history.back();</script>";
        exit;
    }

    // Check if username already exists
    $stmt_check = $con->prepare("SELECT id FROM user_reg WHERE username = ?");
    $stmt_check->bind_param("s", $uname);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different one.'); window.history.back();</script>";
        exit;
    }

    // Continue with signature generation
    $res = mysqli_query($con, "SELECT MAX(id) AS maxid FROM user_reg");
    $row = mysqli_fetch_assoc($res);
    $id2 = $row['maxid'] + 1;

    $sign = $uname . $id2;
    $sign2 = sha1($sign);
    $sign3 = substr($sign2, 0, 8);
    $code1 = $sign3;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'secure.redunx.cloudstorage@gmail.com';
        $mail->Password = 'ensc anls sppn aaxk'; // Use App Password (not your actual Gmail password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('secure.redunx.cloudstorage@gmail.com', 'Secure Cloud Signature');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Signature Confirmation';
        $mail->Body    = 'Your Signature is: ' . $code1;

        if ($mail->send()) {
            $stmt = $con->prepare("INSERT INTO user_reg(id, dserver, name, contact, email, signature, username, password, rdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssssss", $id2, $dserver, $name, $contact, $email, $sign3, $uname, $pass, $cdate);
            $stmt->execute();

            echo "<script>alert('Registered Successfully, Signature sent to your email.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Email sending failed');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Mailer Error: " . $mail->ErrorInfo . "');</script>";
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
<script>
function validate() {
    if (document.form1.uname.value === "") {
        alert("Enter the Username");
        document.form1.uname.focus();
        return false;
    }
    if (document.form1.pass.value === "") {
        alert("Enter the Password");
        document.form1.pass.focus();
        return false;
    }
    if (document.form1.pass.value !== document.form1.cpass.value) {
        alert("Passwords do not match");
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
          <h2 style="margin-left:130px;"><span style="style=color:rgb(4, 128, 185);font-size:25px;">New Client Registration</span></h2>
          <form id="form1" name="form1" method="post" enctype="multipart/form-data"  style="margin-left:220px;" action="" onsubmit="return validate();">
            <table width="420" border="0" align="center" cellpadding="5" cellspacing="0" class="bg2">
              <tr>
                <td align="left" style="color:white;font-size:22px;">Data Server</td>
                <td align="left">
                  <select name="dserver">
                    <?php
                    $query2 = mysqli_query($con, "SELECT * FROM register");
                    while ($rs2 = mysqli_fetch_assoc($query2)) {
                        echo "<option>" . htmlspecialchars($rs2['uname']) . "</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Name</td>
                <td><input type="text" name="name" style="margin-right:30px; width:250px;" required /></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Contact No.</td>
                <td><input type="text" name="contact" style="margin-right:30px; width:250px;" required /></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">E-mail</td>
                <td align="left"><input type="text" name="email" style="margin-right:30px; width:250px;"/></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Username</td>
                <td><input type="text" name="uname" style="margin-right:30px; width:250px;" required /></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Password</td>
                <td><input type="password" name="pass" style="margin-right:30px; width:250px;" required /></td>
              </tr>
              <tr>
                <td align="left" style="color:white;font-size:22px;">Confirm Password</td>
                <td><input type="password" name="cpass" style="margin-right:30px; width:250px;" required /></td>
              </tr>
              <tr>
                <td></td>
                <td><input type="submit" style="background-color:rgb(4, 128, 185); color:white;" name="btn" value="Register" /></td>
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
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="index_ds.php">Data Server</a></li>
        <li><a href="index_ms.php">Meta Server</a></li>
      </ul>
      <div class="clr"></div>
    </div>
  </div>
</div>
</body>
</html>
