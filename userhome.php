<?php
session_start();
include("include/dbconnect.php");

$uname = $_SESSION['uname'] ?? '';
$key = $_POST['key'] ?? '';
$content2 = $_POST['content2'] ?? '';
$a = $b = $d = $e = $bb = $cc = $vd = 0;

if(isset($_POST['btn'])) {
    // Get user info
    $query = mysqli_query($con, "SELECT * FROM user_reg WHERE username='".mysqli_real_escape_string($con, $uname)."'");
    $res2 = mysqli_fetch_array($query);
    $skey = $res2['signature'];
    $owner = $dserver = $res2['dserver'];
    $email = $res2['email'];

    // File info
    $ftype = $_FILES['file']['type'];
    $fsize = $_FILES['file']['size'];
    $fileName = mysqli_real_escape_string($con, $_FILES['file']['name']);

    // Get next file ID
    $query4 = mysqli_query($con, "SELECT MAX(id) as maxid FROM user_files");
    $ns = mysqli_fetch_array($query4);
    $id2 = $ns['maxid'] + 1;

    // Create directories if needed
    if(!is_dir("upload/$uname")) mkdir("upload/$uname", 0755, true);
    if(!is_dir("test/$uname")) mkdir("test/$uname", 0755, true);

    // IMAGE PROCESSING
    $pos = strpos($ftype, "image");
    if($pos !== false) {
        $a = 1;
        $q2 = mysqli_query($con, "SELECT * FROM user_files WHERE fsize='".mysqli_real_escape_string($con, $fsize)."' 
                                  AND file_type='".mysqli_real_escape_string($con, $ftype)."' 
                                  AND uname='".mysqli_real_escape_string($con, $uname)."'");
        $n2 = mysqli_num_rows($q2);
        
        if($n2 > 0) {
            @move_uploaded_file($_FILES['file']['tmp_name'], "test/$uname/".$fileName);
            
            while($r2 = mysqli_fetch_array($q2)) {
                $cfile = $r2['upload_file'];
                
                include_once("colors.inc.php");
                try {
                    // Process original file
                    $ex = new GetMostCommonColors();
                    $ex->image = "upload/$uname/$cfile";
                    if(!file_exists($ex->image)) continue;
                    
                    $colors = $ex->Get_Color();
                    $how_many = 12;
                    $colors_key = array_keys($colors);
                    for($i = 0; $i <= $how_many; $i++) {
                        $a_color[$i] = $colors[$colors_key[$i]];
                    }
                    
                    // Process test file
                    $ex2 = new GetMostCommonColors();
                    $ex2->image = "test/$uname/$fileName";
                    if(!file_exists($ex2->image)) continue;
                    
                    $colors2 = $ex2->Get_Color();
                    $how_many2 = 12;
                    $colors_key2 = array_keys($colors2);
                    for($i = 0; $i <= $how_many2; $i++) {
                        $b_color[$i] = $colors2[$colors_key2[$i]];
                    }
                    
                    // Compare colors
                    $x = ($a_color[0] == $b_color[0]) ? 1 : 0;
                    $y = ($a_color[1] == $b_color[1]) ? 1 : 0;
                    $z = ($a_color[2] == $b_color[2]) ? 1 : 0;
                    $d += $x + $y + $z;
                } catch(Exception $e) {
                    error_log("Image processing error: ".$e->getMessage());
                    continue;
                }
            }
        }
    }

    // TEXT PROCESSING (unchanged except for mysqli)
    $pos2 = strpos($ftype, "text");
    if($pos2 !== false) {
        $a = 2;
        $q3 = mysqli_query($con, "SELECT * FROM user_files WHERE fsize='".mysqli_real_escape_string($con, $fsize)."' 
                                  AND file_type='".mysqli_real_escape_string($con, $ftype)."' 
                                  AND uname='".mysqli_real_escape_string($con, $uname)."'");
        $n3 = mysqli_num_rows($q3);
        
        if($n3 > 0) {
            @move_uploaded_file($_FILES['file']['tmp_name'], "test/$uname/".$fileName);
            
            while($r3 = mysqli_fetch_array($q3)) {
                $tfile = $r3['upload_file'];
                $fp = file("test/$uname/$fileName");
                $fp2 = file("upload/$uname/$tfile");
                $fnt = count($fp);
                
                for($i = 0; $i < $fnt; $i++) {
                    if(isset($fp2[$i]) && $fp[$i] == $fp2[$i]) {
                        $b++;
                    }
                }
                
                if($fnt == $b) {
                    $bb++;
                }
            }
        }
    }

    // APPLICATION PROCESSING (unchanged except for mysqli)
    $pos3 = strpos($ftype, "application");
    if($pos3 !== false) {
        $a = 3;
        $q4 = mysqli_query($con, "SELECT * FROM user_files WHERE fsize='".mysqli_real_escape_string($con, $fsize)."' 
                                  AND file_type='".mysqli_real_escape_string($con, $ftype)."' 
                                  AND uname='".mysqli_real_escape_string($con, $uname)."'");
        $n4 = mysqli_num_rows($q4);
        
        if($n4 > 0) {
            $cc = 1;
            @move_uploaded_file($_FILES['file']['tmp_name'], "test/$uname/".$fileName);
            
            $filename = "test/$uname/$fileName";
            $line = @file_get_contents($filename);
            $lines = explode(chr(0x0D), $line);
            $outtext = array_filter($lines, function($l) {
                return strpos($l, chr(0x00)) === false && strlen($l) > 0;
            });
            
            while($r4 = mysqli_fetch_array($q4)) {
                $dfile = $r4['upload_file'];
                $line2 = @file_get_contents("upload/$uname/$dfile");
                $lines2 = explode(chr(0x0D), $line2);
                $outtext2 = array_filter($lines2, function($l) {
                    return strpos($l, chr(0x00)) === false && strlen($l) > 0;
                });
                
                if(count($outtext) == count($outtext2)) {
                    foreach($outtext as $index => $val) {
                        if($val != $outtext2[$index]) $cc++;
                    }
                }
            }
        }
    }

    // VIDEO PROCESSING (unchanged except for mysqli)
    $pos4 = strpos($ftype, "video");
    if($pos4 !== false) {
        $vv = 1;
        $vd = 0;
        $file_path = "video/".basename($_FILES['file']['name']);
        
        if($_FILES['file']['name']) {
            // ... [rest of video processing code remains the same]
        }
    }

    // DUPLICATE CHECK
    if($a == 0) {
        $query3 = mysqli_query($con, "SELECT * FROM user_files WHERE upload_file='".mysqli_real_escape_string($con, $fileName)."' 
                                     AND uname='".mysqli_real_escape_string($con, $uname)."'");
        $num3 = mysqli_num_rows($query3);
        $res3 = mysqli_fetch_array($query3);
        $fsize2 = $res3['fsize'] ?? 0;
        $ftype2 = $res3['file_type'] ?? '';
        
        $a = 4;
        if($num3 >= 1 || ($fsize == $fsize2 && $ftype == $ftype2)) {
            $e = 1;
        } else {
            $e = 0;
        }
    }

    // UPLOAD LOGIC
    if($d < 3 && $b == 0 && $e == 0 && $cc == 0 && $vd == 0) {
        if($skey == $key) {
            $parts_num = ($fsize > 10000) ? ceil($fsize / 10000) : 2;
            
            $qq = mysqli_query($con, "INSERT INTO user_files(id, dserver, uname, file_type, fsize, file_content, upload_file, num_chunk, status) 
                                     VALUES('".$id2."', '".mysqli_real_escape_string($con, $dserver)."', 
                                     '".mysqli_real_escape_string($con, $uname)."', '".mysqli_real_escape_string($con, $ftype)."', 
                                     '".mysqli_real_escape_string($con, $fsize)."', '".mysqli_real_escape_string($con, $content2)."', 
                                     '".mysqli_real_escape_string($con, $fileName)."', $parts_num, '0')");
            
            move_uploaded_file($_FILES['file']['tmp_name'], "upload/$uname/".$fileName);
            
            // Split file if not video
            if($vv == 0) {
                require_once('split_merge.inc.php');
                $w = new split_merge();
                $w->split_file($id2, "upload/$uname/", $fileName, $parts_num) or die('Error splitting file');
            }
            
            // Send email notification
            $subject = "Signature Key Confirmation - File Uploaded";
            $message = "Hello $uname,\n\nYour file '$fileName' was successfully uploaded.\n\nYour signature key is:\n$skey\n\nIf this wasn't you, please contact support.";
            $headers = "From: proxyware01@gmail.com\r\n";
            @mail($email, $subject, $message, $headers);
            
            echo "<script>alert('Uploaded Successfully..'); window.location.href='viewfiles.php';</script>";
        } else {
            echo "<script>alert('Invalid Signature!');</script>";
        }
    } else {
        if(!is_dir("duplicate/$uname")) mkdir("duplicate/$uname", 0755, true);
        
        if(!file_exists("duplicate/$uname/$fileName")) {
            @copy("upload/$uname/$fileName", "duplicate/$uname/$fileName");
        }
        
        echo "<script>alert('Duplicate File!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php include("include/title.php"); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/cufon-yui.js"></script>
    <script type="text/javascript" src="js/arial.js"></script>
    <script type="text/javascript" src="js/cuf_run.js"></script>
    <style>
        /* Adjust main content area */
        .content_resize {
            margin-bottom: 20px; 
        }
    </style>
    <script>
    function validate() {
        if(document.form1.key.value === "") {
            alert("Enter the Signature");
            document.form1.key.focus();
            return false;
        }
        if(document.form1.content2.value === "") {
            alert("Enter the Content");
            document.form1.content2.focus();
            return false;
        }
        return true;
    }
    </script>
</head>
<body style="background-color:white">
<div class="main">
    <div class="header" style="background-image:none; width:1655px; font-family:'Times New Roman', Times, serif;">
        <div class="logo" style="background-color:rgb(3, 23, 31);padding:20px 50px;margin-top:10px;">
            <h1 style="style=color:rgb(253, 244, 244); font-family:'Times New Roman', Times, serif; margin-left:235px;">
                <b>SECURE CLOUD STORAGE WITH DEDUPLICATION </b><br />
            </h1>
        </div>
        <hr>
        <div class="clr"></div><br><br>
        <div class="menu_nav" style="margin-left:150px;">
            <ul>
                <li class="active"><a href="userhome.php">Home</a></li>
                <li><a href="viewfiles.php">Files</a></li>
            </ul>
        </div>
        <div class="clr"></div>
    </div>

    <div class="content">
        <div class="content_resize">
            <div class="mainbar">
                <div class="article">
                    <h2 style="margin-left:130px;"><span style="style=color:rgb(4, 128, 185);font-size:25px;">Upload File</span></h2>
                    <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data" style="margin-left:220px;">
                        <table width="362" border="0" align="center" cellpadding="5" cellspacing="0" class="bg2">
                            <tr>
                                <td style="color:white;font-size:22px;">Signature</td>
                                <td><input type="password" style="margin-right:30px; width:250px;" name="key" value="<?php echo htmlspecialchars($key); ?>"></td>
                            </tr>
                            <tr>
                                <td style="color:white;font-size:22px;">Content</td>
                                <td><input type="text" style="margin-right:30px; width:250px;" name="content2" value="<?php echo htmlspecialchars($content2); ?>" /></td>
                            </tr>
                            <tr>
                                <td style="color:white;font-size:22px;">Select File</td>
                                <td><input type="file" name="file" /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" name="btn" value="Upload" onclick="return validate()" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
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