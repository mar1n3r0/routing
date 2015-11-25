<?php
require 'inc/config.php';
if (isset($_SESSION['isLogged'])) {
    header('Location: index.php');
    exit;
}
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($con, trim($_POST['username']));
    $password = mysqli_real_escape_string($con, trim($_POST['password']));
    if (mb_strlen($username, 'UTF-8') < 3) {
        $error_array['username_short'] = 'The username is too short';
    }
    if (mb_strlen($username, 'UTF-8') > 12) {
        $error_array['username_long'] = 'The username is too long';
    }
    if (!preg_match('/^[a-z\d_]{3,12}$/i', $username)) {
        $error_array['username_invalid'] = 'Invalid username';
    }
    if (mb_strlen($password, 'UTF-8') < 5) {
        $error_array['password_short'] = 'The password is too short';
    }

    if (!isset($error_array)) {
        // Database check if the username and email are free
        $sql = 'SELECT username FROM users 
                WHERE username="'.$username.'"';
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            $error_array['username_email_Exists'] = 'The username/email is already taken!';
        }
    }

    if (!isset($error_array)) {
        // There are no more errors
        // Record the new user to the database
        $sql = 'INSERT INTO users (user_id, username, password) 
                VALUES (NULL, "'.$username.'", "'.$password.'");';
        if (mysqli_query($con, $sql)) {
            $_SESSION['isLogged'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = mysqli_insert_id($con);
            header('Location: index.php?succreg=1');
            exit;
        }
    }
}
?>
<?php
require 'inc/header.php';
?>
<div class="navigation" style="width: 350px;">
    <ul id="menu" >
        <li>
            <a href="login.php">You already have an account ? <span style="color: #ffc000;">Login Here!</span></a>
        </li>
    </ul>
</div>
<div id="add">
    <form action="register.php" method="POST">
        <table style="width: 350px;">
            <?php
            if (isset($error_array)) {
                if (count($error_array) > 0) {
                    echo '<tr><td colspan="2" style="color: #dd7200; text-align:center;">';
                    foreach ($error_array as $v) {
                        echo $v . '<br/>';
                    }
                    echo '</td></tr>';
                }
            }
            if (isset($succreg)) {
                echo '<tr><td colspan="2" style="color: #93c72e;">';
                echo 'Successfull Registration!';
                echo '</td></tr>';
            }
            ?>
            <tr>
                <td><label for="username">Username</label></td>
                <td><input type="text" name="username" id="username" value="" /></td>
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td><input type="password" name="password" id="password" value="" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" name="register" value="Register"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php
include 'inc/footer.php';
?>
