<?php
    session_start();
    require_once 'connect.php';
    $connect = mysqli_connect('localhost','root','','test');

    $full_name= $_POST['full_name'];
    $login= $_POST['login'];
    $email= $_POST['email'];
    $password= $_POST['password '];
    $password_confirm= $_POST['password_confirm'];

    $check_login=mysqli_query($connect,"SELECT * FROM `user` WHERE `login`= `$login`");
    if (mysqli_num_rows($check_login)>0){
        $response = [
            "status"=>false,
            "type"=>1,
            "message"=>"логин занят",
            "fields"=>['login']
        ];
        echo json_encode($response);
        die();
    }

$erroe_fields=[];

if ($login === ''){
    $erroe_fields[] ='login';
}

if ($password === ''){
    $erroe_fields[] ='password';
}
if ($full_name === ''){
    $erroe_fields[] ='full_name';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
    $erroe_fields[] ='email';
}
if (!$_FILES['avatar']){
    $erroe_fields[] ='avatar';
}
if ($password_confirm === ''){
    $erroe_fields[] ='$password_confirm';
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

    if ($password === $password_confirm){

        //$_FILES['avatar']['name'];
        $path='uploads/' . time() .$_FILES['avatar']['name'];
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'],'../' . $path)){
            $response = [
                "status"=>false,
                "type"=>2,
                "message"=>"КАртинка калл меняй",
            ];

            echo json_encode($response);
        }
        $password=md5($password);
        mysqli_query($connect, "INSERT INTO `users` (`id`, `full_name`, `login`, `email`, `password`, `avatar`) VALUES ('', $full_name, $login, $email, $password, $path)");

        $response = [
            "status"=>true,
            "message"=>"регистрация прошла успешно",
        ];

        echo json_encode($response);

    }else{
        $response = [
            "status"=>false,
            "message"=>"пороли не совпадают",
        ];

        echo json_encode($response);
    }


    ?>



