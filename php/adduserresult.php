<?php


class adduserresult extends core
{
    public function get_body()
    {
        parent::get_body(); // TODO: Change the autogenerated stub

        $rolelink=mysqli_connect( HOST, USER, PASSWORD, DB );
        $userrole=$_SESSION['role'];
        $rolequery="SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=4";
        $roleres=mysqli_query($rolelink,$rolequery,MYSQLI_STORE_RESULT);

        if (mysqli_num_rows($roleres)>0){
            $uname=trim(strip_tags($_POST['uname']));

            $urlsearch='http://albiondb.net/search/'.$uname;
            $text = file_get_contents( $urlsearch );
            if (preg_match( '/No Players Found/' , $text ))
            {
                echo 'Такого игрока не существует.';
            }
            else {
                $urluser='http://albiondb.net/player/'.$uname;
                $text2 = file_get_contents( $urluser );
                preg_match_all( '#<div class="well">(.+?)</div>#su' , $text2, $res );
                $r=$res[0][0];

                if (!preg_match( '/War Gods/' , $r))
                {
                    echo 'Игрок не состоит в гильдии.';
                }
                else {
                    $checklink = mysqli_connect(HOST, USER, PASSWORD, DB);
                    $checkquery = "SELECT Id FROM autoriation WHERE UserName='$uname'";
                    $checkres = mysqli_query($checklink, $checkquery, MYSQLI_STORE_RESULT);
                    if (mysqli_num_rows($checkres) > 0) {
                        echo 'Этот пользователь уже существует.';
                    } else {
                        $userlink = mysqli_connect(HOST, USER, PASSWORD, DB);
                        $userquery = "INSERT INTO autoriation (UserName,Password) VALUES('$uname','$uname')";
                        $userres = mysqli_query($userlink, $userquery, MYSQLI_STORE_RESULT);
                        $id = mysqli_insert_id($userlink);

                        $userquery = "INSERT INTO bank (UserId) VALUES ($id)";
                        $userres = mysqli_query($userlink, $userquery, MYSQLI_STORE_RESULT);

                        $userquery = "INSERT INTO userroles (UserId,RoleId) VALUES ($id,1)";
                        $userres = mysqli_query($userlink, $userquery, MYSQLI_STORE_RESULT);
                        echo 'Пользователь успешно добавлен.';
                    }
                }
            }
        }
        else{
            echo 'У вас нет доступа для просмотра этой страницы.';
        }
    }
}