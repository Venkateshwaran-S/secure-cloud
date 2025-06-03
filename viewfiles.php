<?php
session_start();
include("include/dbconnect.php");

$uname = isset($_SESSION['uname']) ? $_SESSION['uname'] : '';

// Handle deletion (only own files)
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "del" && isset($_REQUEST['did'])) {
    $did = intval($_REQUEST['did']);
    $query = "DELETE FROM user_files WHERE id = $did AND uname = '$uname'";
    mysqli_query($con, $query);
    header("Location: viewfiles.php");
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
<script type="text/javascript">
function del() {
    return confirm("Are you sure you want to delete this file?");
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
      <div class="menu_nav" style="margin-left:150px;">
        <ul>
          <li><a href="userhome.php">Home</a></li>
          <li class="active"><a href="viewfiles.php">Files</a></li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>

  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 style="margin-left:130px;"><span style="color:rgb(4, 128, 185);font-size:25px;">File Details</span></h2>
          <form id="form1" name="form1" method="post" action="" style="margin-left:220px;">
            <table width="806" border="1" align="center" cellpadding="5" cellspacing="0">
              <tr>
                <th width="43" align="center" class="bg3" style="color:white;font-size:22px;">Sno</th>
                <th width="146" align="center" class="bg3" style="color:white;font-size:22px;">Content</th>
                <th width="152" align="center" class="bg3" style="color:white;font-size:22px;">Uploaded File</th>
                <th width="130" align="center" class="bg3" style="color:white;font-size:22px;">Shared By</th>
                <th width="215" align="center" class="bg3" style="color:white;font-size:22px;">Action</th>
              </tr>
              <?php 
              $i = 0;
              $uname_safe = mysqli_real_escape_string($con, $uname);

              $query2 = mysqli_query($con, "
                  SELECT uf.*, 'You' AS shared_by 
                  FROM user_files uf 
                  WHERE uf.uname = '$uname_safe'

                  UNION

                  SELECT uf.*, s.uname AS shared_by
                  FROM user_files uf
                  JOIN share s ON s.fid = uf.id
                  WHERE s.cname = '$uname_safe'
              ");

              while ($rs = mysqli_fetch_array($query2)) {
                  $i++;
              ?>
              <tr>
                <td class="bg4" style="color:white;font-size:22px;"><?php echo $i; ?></td>
                
                <td class="bg4" style="color:white;font-size:22px;"><?php echo htmlspecialchars($rs['file_content']); ?></td>
                
                <td class="bg4" style="color:white;font-size:22px;"><?php echo htmlspecialchars($rs['upload_file']); ?></td>
                
                <td class="bg4" style="color:white;font-size:22px;"><?php echo htmlspecialchars($rs['shared_by']); ?></td>
                
                <td class="bg4" style="color:white;font-size:22px;">
          
                  <?php if ($rs['shared_by'] == 'You') { ?>
                      <a href="upload/<?php echo urlencode($uname) . "/" . urlencode($rs['upload_file']); ?>" target="_blank">View</a>
                      / <a href="update.php?fid=<?php echo $rs['id']; ?>">Update</a>
                      / <a href="viewfiles.php?act=del&amp;did=<?php echo $rs['id']; ?>&amp;fname=<?php echo urlencode($rs['upload_file']); ?>" onclick="return del()">Delete</a>
                      / <a href="share.php?fid=<?php echo $rs['id']; ?>">Share</a>
                  <?php } else { ?>
                      <a href="upload/<?php echo urlencode($rs['shared_by']) . "/" . urlencode($rs['upload_file']); ?>" target="_blank">View</a>
                      / Shared file from <?php echo htmlspecialchars($rs['shared_by']); ?>
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
        <div class="article"><p>&nbsp;</p></div>
      </div>
      <div class="clr"></div>
    </div>
  </div>

  <div class="fbg">
    <div class="fbg_resize"><div class="clr"></div></div>
  </div>

  <div class="footer">
    <div class="footer_resize">
      <p class="lf">&copy; Deduplication</p>
      <ul class="fmenu">
        <li><a href="userhome.php">Home</a></li>
        <li class="active"><a href="viewfiles.php">Files</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
      <div class="clr"></div>
    </div>
  </div>
</div>
</body>
</html>
