<?php
session_start();
include("include/dbconnect.php");

$uname = $_SESSION['uname'];

if (isset($_POST['btn'])) {
    $key = $_POST['key'];
    $content2 = $_POST['content2'];
    $ftype = $_FILES['file']['type'];
    $fsize = $_FILES['file']['size'];
    $fileName = $_FILES['file']['name'];

    // Get signature
    $query = mysqli_query($con, "SELECT * FROM register WHERE uname='$uname'");
    $res2 = mysqli_fetch_array($query);
    $skey = $res2['signature'];

    if ($skey == $key) {
        $query4 = mysqli_query($con, "SELECT MAX(id) AS maxid FROM user_files");
        $ns = mysqli_fetch_array($query4);
        $id1 = $ns['maxid'];
        $id2 = $id1 + 1;

        // Escape string for content
        $contentEscaped = mysqli_real_escape_string($con, $content2);

        $qq = mysqli_query($conn, "INSERT INTO user_files(id, uname, file_type, fsize, file_content, upload_file, status) 
            VALUES($id2, '$uname', '$ftype', '$fsize', '$contentEscaped', '$fileName', '0')");

        move_uploaded_file($_FILES['file']['tmp_name'], "upload/" . $fileName);
        echo "<script>alert('Uploaded Successfully..'); window.location.href='viewfiles.php';</script>";
    } else {
        echo "<script>alert('Invalid Signature!');</script>";
    }
}
?>

<!-- The rest of your HTML is unchanged except query conversion -->

<!-- In the table section (just replace mysql_* with mysqli_*): -->



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
  	if(document.form1.key.value=="")
	{
	alert("Enter the Signature");
	document.form1.key.focus();
	return false;
	}
	if(document.form1.content2.value=="")
	{
	alert("Enter the Content");
	document.form1.content2.focus();
	return false;
	}
	
return true;
  }
  </script>
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
      <div class="menu_nav"  style="margin-left:150px;">
        <ul>
          <li class="active"><a href="home_ds.php">Home</a></li>
		  <li><a href="ds_lht.php">LHT</a></li>
		  <li><a href="ds_sht.php">SHT</a></li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>

  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 style="margin-left:130px;"><span style="style=color:rgb(4, 128, 185);font-size:25px;">Client Details </span></h2>
          <form id="form1" name="form1" method="post" action="" style="margin-left:220px;">
            <table width="606" border="1" align="center" cellpadding="5" cellspacing="0">
              <tr>
                <th width="77" align="center" class="bg3" style="color:white;font-size:22px;">Sno</th>
                <th width="135" align="center" class="bg3" style="color:white;font-size:22px;">Name</th>
                <th width="217" align="center" class="bg3" style="color:white;font-size:22px;">Email</th>
                <th width="127" align="center" class="bg3" style="color:white;font-size:22px;">Date</th>
              </tr>
              <?php
$query = mysqli_query($con, "SELECT * FROM user_reg WHERE dserver='$uname'");
$i = 0;
while ($rs = mysqli_fetch_array($query)) {
    $i++;
?>
<tr>
    <td class="bg4" style="color:white;font-size:22px;"><?php echo $i; ?></td>
    <td class="bg4" style="color:white;font-size:22px;"><?php echo $rs['name']; ?></td>
    <td class="bg4" style="color:white;font-size:22px;"><?php echo $rs['email']; ?></td>
    <td class="bg4" style="color:white;font-size:22px;"><?php echo $rs['rdate']; ?></td>
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
        <li class="active"><a href="home_ds.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
  </div>
</div>
</body>
</html>
