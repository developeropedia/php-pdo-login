<?php

session_start();

include('connection.php');
global $pdo;
$conn = $pdo->open();
$message = '';

function login() {
    global $conn;
    global $message;

    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = 'SELECT * FROM users WHERE username = ? LIMIT 1';
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        //Check if username is correct
        if($user){
            // Check if password is correct
            if(password_verify($password, $user->password)){
                //Storing user in session
                $_SESSION['user'] = $username;
                $message = 'Success';
            }else{
                $message = "Username or password is wrong!";
            }
        }else{
            $message = "Username or password is wrong!";
        }
    }
}

?>