<?php


class passrenewres extends core
{
    public function get_body()
    {
        parent::get_body(); // TODO: Change the autogenerated stub

        if (isset($_SESSION['UserId']))
        {
            $oPass=trim(strip_tags($_POST['oPass']));
            $pass=trim(strip_tags($_POST['password']));
            $uid=$_SESSION['UserId'];
            $link=mysqli_connect( HOST, USER, PASSWORD, DB );
            $query="SELECT Id FROM autoriation WHERE Id=$uid AND Password='$oPass'";
            $res=mysqli_query($link,$query,MYSQLI_STORE_RESULT);
            if (mysqli_num_rows($res)>0){
                $l=mysqli_connect( HOST, USER, PASSWORD, DB );
                $q="UPDATE autoriation SET Password='$pass' WHERE Id=$uid";
                $r=mysqli_query($l,$q,MYSQLI_STORE_RESULT);
                echo 'Пароль изменен';
            }
            else{
                echo 'Неверно введен пароль!';
            }
        }
        else
            {
            echo 'Войдите, чтобы просматривать эту страницу.';
        }
    }
}