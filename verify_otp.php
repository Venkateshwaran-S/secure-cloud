<?php
session_start();

if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_time']) || !isset($_SESSION['uname'])) {
    header("Location: index.php");
    exit();
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp_time = $_SESSION['otp_time'];
    $current_time = time();

    if (($current_time - $otp_time) > 300) { // 5 minutes expiry
        $msg = "OTP has expired. Please login again.";
        session_unset();
        session_destroy();
    } elseif ($_POST['otp'] == $_SESSION['otp']) {
        unset($_SESSION['otp']);
        unset($_SESSION['otp_time']);
        header("Location: userhome.php");
        exit();
    } else {
        $msg = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            background-color: #0a1a2e;
            font-family: Arial, sans-serif;
            color: white;
        }
        .otp-box {
            width: 400px;
            margin: 100px auto;
            background: #132f4c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        .otp-box h2 {
            text-align: center;
            color: #04a0c9;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
        }
        input[type="submit"] {
            padding: 10px 30px;
            margin-top: 15px;
            background: #0480b9;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="main">
    <div class="header" style="text-align:center; padding:30px;">
        <h1 style="color:white;">SECURE CLOUD STORAGE WITH DEDUPLICATION</h1>
    </div>

    <div class="otp-box">
        <h2>Verify OTP</h2>
        <form method="post">
            <label for="otp">Enter OTP sent to your registered email:</label>
            <input type="text" name="otp" id="otp" required />
            <input type="submit" value="Verify OTP" />
        </form>
        <?php if ($msg != "") { echo "<div class='error'>$msg</div>"; } ?>
    </div>
</div>
</body>
</html>

