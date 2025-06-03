<?php
session_start();
include("include/dbconnect.php");

// Fix: Secure extraction of GET parameters
$act = isset($_GET['act']) ? $_GET['act'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fix: Use mysqli for DB query
if ($act == "ok" && $id > 0) {
    $qry = "UPDATE register SET status='1' WHERE id=$id";
    mysqli_query($con, $qry);
    header("Location: home_ms.php");
    exit();
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
  	if(document.form1.uname.value=="")
	{
	alert("Enter the Username");
	document.form1.uname.focus();
	return false;
	}
	if(document.form1.pass.value=="")
	{
	alert("Enter the Password");
	document.form1.pass.focus();
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
          <h2 style="margin-left:130px;"><span style="style=color:rgb(4, 128, 185);font-size:25px;">Data Server </span></h2>
          <form id="form1" name="form1" method="post" action="" style="margin-left:220px;width:700px;">
            <h2>&nbsp;</h2>
            <table width="860" border="1" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <th width="51" class="bg3" style="color:white;font-size:22px;">Sno</th>
                <th width="145" class="bg3" style="color:white;font-size:22px;">Data Server </th>
                <th width="145" class="bg3" style="color:white;font-size:22px;">Name</th>
                <th width="116" class="bg3" style="color:white;font-size:22px;">E-mail</th>
                <th width="103" class="bg3" style="color:white;font-size:22px;">Date</th>
                <th width="142" class="bg3" style="color:white;font-size:22px;">Files</th>
                <th width="142" class="bg3" style="color:white;font-size:22px;">Permission</th>
              </tr>
              <?php
$query1 = mysqli_query($con, "SELECT * FROM register ORDER BY id DESC");
$i = 0;

while ($rs = mysqli_fetch_array($query1)) {
    $i++;
?>
<tr>
    <td class="bg4" style="color:white;font-size:22px;"><?php echo $i; ?></td>
    <td class="bg4" style="color:white;font-size:22px;"><?php echo $rs['uname']; ?></td>
    <td class="bg4" style="color:white;font-size:22px;"><?php echo $rs['name']; ?></td>
    <td class="bg4" style="color:white;font-size:22px;"><?php echo $rs['email']; ?></td>
    <td class="bg4" style="color:white;font-size:22px;"><?php echo $rs['rdate']; ?></td>
    <td class="bg4" style="color:white;font-size:22px;"><a href="viewfiles3.php?ds=<?php echo $rs['uname']; ?>">Click</a></td>
    <td class="bg4" style="color:white;font-size:22px;">
        <?php if ($rs['status'] == 1) {
            echo "Accepted";
        } else { ?>
            <a href="home_ms.php?act=ok&amp;id=<?php echo $rs['id']; ?>">Accept</a>
        <?php } ?>
    </td>
</tr>
<?php
}
?>

            </table>
          </form>
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
        <li class="active"><a href="home_ms.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
  </div>
</div>
</body>
</html>
