<?php

class main extends core
{
    public function get_body()
    {
        $link=mysqli_connect( HOST, USER, PASSWORD, DB );
        parent::get_body(); // TODO: Change the autogenerated stub
        $query="SELECT UserId,Sum FROM `bank`";
        $res=mysqli_query( $link,$query,MYSQLI_USE_RESULT);
        echo '<table>';

        while ($cash=mysqli_fetch_array($res, MYSQLI_ASSOC))
        {
            $link2=mysqli_connect( HOST, USER, PASSWORD, DB );
            $UserId=$cash['UserId'];
            $ures=mysqli_query($link2,"SELECT UserName FROM `autoriation` WHERE Id=$UserId",MYSQLI_USE_RESULT);
            $user=mysqli_fetch_array($ures, MYSQLI_ASSOC);
            echo '<tr><td>'.$user['UserName'].'</td><td>'.$cash['Sum'].'</td>';

            $rolelink=mysqli_connect( HOST, USER, PASSWORD, DB );
            $userrole=$_SESSION['role'];
            $rolequery2="SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=6";
            $roleres2=mysqli_query($rolelink,$rolequery2,MYSQLI_STORE_RESULT);

            if(mysqli_num_rows($roleres2)>0){

                echo '<td>';
                $urlsearch='http://albiondb.net/search/'.$user['UserName'];
                $text = file_get_contents( $urlsearch );
                if (preg_match( '/No Players Found/' , $text ))
                {
                    echo '<p style="color:red">Такого игрока не существует.</p><br>';
                }
                else {
                    $urluser = 'http://albiondb.net/player/' . $user['UserName'];
                    $text2 = file_get_contents($urluser);
                    preg_match_all('#<div class="well">(.+?)</div>#su', $text2, $reslt);
                    $r = $reslt[0][0];

                    if (!preg_match('/War Gods/', $r)) {
                        echo '<p style="color: red;">Игрок не состоит в гильдии.</p><br>';
                    }
                }
                echo '<form method="post" action="?option=deleteuser">
                        <input type="text" value="' . $cash['UserId'] . '" name="id" hidden="hidden">
                        <input type="submit" name="go" value="X"> 
                    </form></td>';
            }

            echo '</tr>';
        }

        mysqli_close($link2);
        echo '</table>';
        mysqli_close($link);
    }
}