<?php
if (isset($_POST["submit"])) {
    require 'dbh.inc.php';

    $uid = $_POST['uid'];
    $email = $_POST['mail'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwd-repeat'];
    $status = "active";

    if (empty($uid) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        header("Location: ../User Management.php?error=emptyfields&uid=".$uid."&mail=".$email);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header("Location: ../User Management.php?error=invalidmailuid");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../User Management.php?error=invalidmail&uid=".$uid);
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
        header("Location: ../User Management.php?error=invaliduid&mail=".$email);
        exit();
    } elseif ($pwd !== $pwdRepeat) {
        header("Location: ../User Management.php?error=passwordcheck&uid=".$uid."&mail=".$email);
        exit();
    } else {
        $sql = "SELECT username FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../User Management.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../User Management.php?error=usertaken&mail=".$email);
                exit();
            } else {
                $sql = "INSERT INTO users (username, email, password , status) VALUES (?, ?, ? , ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../User Management.php?error=sqlerror");
                    exit();
                } else {
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ssss", $uid, $email, $hashedPwd,$status);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../User Management.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../User Management.php");
    exit();
}
?>
