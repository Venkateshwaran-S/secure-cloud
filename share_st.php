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
<body style="background-color:white">
<?php
$uname = $_SESSION['uname'];
extract($_POST);

if ($_REQUEST['act'] == "ok") {
    $rid = $_REQUEST['rid'];
    mysqli_query($con, "UPDATE share SET status='2' WHERE id=$rid");
    echo "<script>window.location.href='share_st.php';</script>";
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
          <form name="form1" method="post" action="">
            <table width="533" border="1" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <th style="color:white;font-size:22px;">Sno</th>
                <th style="color:white;font-size:22px;">Client</th>
                <th style="color:white;font-size:22px;">File</th>
                <th v>Date</th>
                <th style="color:white;font-size:22px;">Status</th>
              </tr>
			  <?php
			  $i = 0;
			  $q2 = mysqli_query($con, "SELECT * FROM share WHERE uname='$uname'");
			  while ($r2 = mysqli_fetch_array($q2)) {
				  $i++;
				  $fid = $r2['fid'];
				  $q3 = mysqli_query($con, "SELECT * FROM user_files WHERE id=$fid");
				  $r3 = mysqli_fetch_array($q3);
			  ?>
              <tr>
                <td style="color:white;font-size:22px;"><?php echo $i; ?></td>
                <td style="color:white;font-size:22px;"><?php echo $r2['cname']; ?></td>
                <td style="color:white;font-size:22px;"><?php echo $r3['upload_file']; ?></td>
                <td style="color:white;font-size:22px;"><?php echo $r2['rdate']; ?></td>
                <td style="color:white;font-size:22px;">
                <?php
				if ($r2['status'] == 0) {
					echo "Verification";
				} else if ($r2['status'] == 1) {
					echo '<a href="share_st.php?act=ok&rid='.$r2['id'].'">Send File</a>';
				} else if ($r2['status'] == 2) {
					echo 'Sent';
				}
				?>
                </td>
              </tr>
			  <?php } ?>
            </table>
          </form>

          <h3 style="color:white;font-size:22px;">Received Files </h3>
          <table width="558" border="1" align="center" cellpadding="5" cellspacing="0">
            <tr>
              <th style="color:white;font-size:22px;">Sno</th>
              <th style="color:white;font-size:22px;">Received From</th>
              <th style="color:white;font-size:22px;">File</th>
              <th style="color:white;font-size:22px;">Date</th>
              <th style="color:white;font-size:22px;">Action</th>
            </tr>
            <?php
			  $i = 0;
			  $q2 = mysqli_query($con, "SELECT * FROM share WHERE cname='$uname'");
			  while ($r2 = mysqli_fetch_array($q2)) {
				  $i++;
				  $fid = $r2['fid'];
				  $q3 = mysqli_query($con, "SELECT * FROM user_files WHERE id=$fid");
				  $r3 = mysqli_fetch_array($q3);
			?>
            <tr>
              <td style="color:white;font-size:22px;"><?php echo $i; ?></td>
              <td style="color:white;font-size:22px;"><?php echo $r2['uname']; ?></td>
              <td style="color:white;font-size:22px;"><?php echo $r3['upload_file']; ?></td>
              <td style="color:white;font-size:22px;"><?php echo $r2['rdate']; ?></td>
              <td style="color:white;font-size:22px;">
              <a href="download.php?file1=<?php echo $r3['upload_file']; ?>&folder1=upload">Download</a>
              </td>
            </tr>
            <?php } ?>
          </table>
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
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="register.php">Data Server</a></li>
        <li><a href="index_ms.php">Meta Server</a></li>
      </ul>
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
  </div>
  <!-- Footer unchanged -->
</div>
</body>
</html>
