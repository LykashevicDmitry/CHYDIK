<?php
    session_start();
    require_once 'connect.php';
    $connect = mysqli_connect('localhost','root','','test');
    $login= $_POST['login'];
    $password= $_POST['password '];
    $erroe_fields=[];

    if ($login === ''){
        $erroe_fields[] ='login';
    }

    if ($password === ''){
        $erroe_fields[] ='password';
    }

    if (!empty($erroe_fields)) {
        $response = [
            "status"=>false,
            "type"=>1,
            "message"=>"Проверте правильность полей",
            "fields"=>$erroe_fields
            ];

        echo json_encode($response);

        die();

    }
    $password= md5($_POST['password ']);
    $check_user=mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password`= '$password'");
    echo  mysqli_num_rows($check_user);
    if (mysqli_num_rows($check_user)>0){
        $user=mysqli_fetch_assoc($check_user);
        $_SESSION['user']=[
        "id"=>$user['id'],
            "full_name"=>$user['full_name'],
            "avatar"=>$user['avatar'],
            "email"=>$user['eamil']
    ];
        $response=[
            "status"=>true
        ];
        //header('Location: ../profile.php');
        echo json_encode($response);
    }else{
        //$_SESSION['massge']= 'ты тупой';
        //header('Location:../authorization.php');
        $response=[
            "status"=>false,
            "message"=>'неверный логин или пороль'
        ];
        echo json_encode($response);
    }
?>
