<?php 
session_start();
include('./../../_system/database.php');
$db = new database();


if(isset($_POST['register'])){
    $usrname = $_POST['username'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $file = $_FILES['file'];

    $fileNew = $db -> uploadFile($file);

    $data = [
        'username_user' => $usrname,
        'password_user' => $password,
        'fname_user' => $fname,
        'lname_user' => $lname,
        'address_user' => $address,
        'tel_user' => $tel,
        'file_user' => $fileNew
    ];

    $db -> insertWhere("users",$data," (SELECT username_user FROM users WHERE username_user = '$usrname')");

    if($db -> mysqli -> affected_rows > 0){
        $_SESSION['alert'] = "Register Successfully"; 
        header('location:'.$_SERVER['REQUEST_URI']);
        return;
    }else{
        $_SESSION['alert'] = "Username already to use !"; 
        header('location:'.$_SERVER['REQUEST_URI']);
        return;
    }
}

if(isset($_POST['login'])){
    $db = new database();


    $username = $_POST['username_login'];
    $password = $_POST['password_login'];

    $db -> select("users,types","*"," username_user = '$username' AND password_user = '$password' AND type_user = id_type");
    if($db -> query -> num_rows > 0){
        $fetch = $db -> query -> fetch_object();
        $_SESSION['userid'] = $fetch -> id_user;
        $_SESSION['type'] = $fetch -> name_type;

        if($fetch -> status_user == 0){
            $_SESSION['alert'] = "Please wait active from administrator"; 
            header('location:'.$_SERVER['REQUEST_URI']);
            return;
        }else{
            if($_SESSION['type'] == 'user' && $fetch -> dept_user == ""){
                header('location:./../'.$_SESSION['type'].'/Homepage.php?table=1');
                return;
            }else{
                header('location:./../'.$_SESSION['type'].'/Homepage.php');
                return;
            }
        }
        
    }else{
        $_SESSION['alert'] = "Username or password incorrect !";
        header('location:'.$_SERVER['REQUEST_URI']);
        return;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="icon" href="./../../style/icon/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./../../style/css/login.css">
    <link rel="stylesheet" href="./../../style/css/alert_css.css">


</head>

<style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
    box-sizing: border-box;
}

body {
    background-image: url('./../../style/icon/background.jpg');
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-family: 'Montserrat', sans-serif;
    height: 100vh;
    margin: -20px 0 50px;
}

h1 {
    font-weight: bold;
    margin: 0;
}

h2 {
    text-align: center;
}

p {
    font-size: 14px;
    font-weight: 100;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin: 20px 0 30px;
}

span {
    font-size: 12px;
}

a {
    color: #333;
    font-size: 14px;
    text-decoration: none;
    margin: 15px 0;
}

button {
    border-radius: 20px;
    border: 1px solid #ffaa2b;
    background-color: #ffaa2b;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
}

button:active {
    transform: scale(0.95);
}

button:focus {
    outline: none;
}

button.ghost {
    background-color: transparent;
    border-color: #FFFFFF;
}

form {
    background-color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    text-align: center;
}

input {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
}

.container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
        0 10px 10px rgba(0, 0, 0, 0.22);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 480px;
}

.form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in-container {
    left: 0;
    width: 50%;
    z-index: 2;
}

.container.right-panel-active .sign-in-container {
    transform: translateX(100%);
}

.sign-up-container {
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.container.right-panel-active .sign-up-container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
}

@keyframes show {

    0%,
    49.99% {
        opacity: 0;
        z-index: 1;
    }

    50%,
    100% {
        opacity: 1;
        z-index: 5;
    }
}

.overlay-container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 100;
}

.container.right-panel-active .overlay-container {
    transform: translateX(-100%);
}

.overlay {
    background: #ffb341;
    background: -webkit-linear-gradient(to right, #ffaa2b, #ff7741);
    background: linear-gradient(to right, #ffaa2b, #ff7741);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 0 0;
    color: #FFFFFF;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
    transform: translateX(50%);
}

.overlay-panel {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    text-align: center;
    top: 0;
    height: 100%;
    width: 50%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.overlay-left {
    transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
    transform: translateX(0);
}

.overlay-right {
    right: 0;
    transform: translateX(0);
}

.container.right-panel-active .overlay-right {
    transform: translateX(20%);
}

.social-container {
    margin: 20px 0;
}

.social-container a {
    border: 1px solid #DDDDDD;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 5px;
    height: 40px;
    width: 40px;
}
</style>

<body>
    <h2 style="color:white">Restaurant</h2>
    <?php  include('./../components/error_alert.php'); ?>

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h1>Create Account</h1>
                <input type="text" name="username" placeholder="Username" required />
                <input type="text" name="fname" placeholder="Firstname" required />
                <input type="text" name="lname" placeholder="Lastname" required />
                <input type="text" name="tel" placeholder="Tel" required />
                <input type="text" name="address" placeholder="Address" required />
                <input type="file" name="file" id="">
                <input type="password" placeholder="Password" name="password" required />
                <button type="submit" name="register">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="" method="post">
                <h1>Sign in</h1>
                <input type="text" name="username_login" required placeholder="Username" />
                <input type="password" name="password_login" required placeholder="Password" />
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam culpa praesentium fugiat labore
                        omnis eum molestiae porro nobis nesciunt dolorem?</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello !</h1>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque, minus.</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
    </script>
</body>


</html>