<?php


class uservalidation extends core
{
    public function get_body()
    {
        parent::get_body(); // TODO: Change the autogenerated stub

        $rolelink = mysqli_connect(HOST, USER, PASSWORD, DB);
        $userrole = $_SESSION['role'];
        $rolequery2 = "SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=6";
        $roleres2 = mysqli_query($rolelink, $rolequery2, MYSQLI_STORE_RESULT);

        if (mysqli_num_rows($roleres2) > 0) {
            $link = mysqli_connect(HOST, USER, PASSWORD, DB);
            $query = "SELECT Id,UserName FROM autoriation";
            $res = mysqli_query($link, $query, MYSQLI_USE_RESULT);
            echo '<table>';

            while ($user = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

                $urlsearch = 'http://albiondb.net/search/' . $user['UserName'];
                $text = file_get_contents($urlsearch);

                $lable=false;
                if (preg_match('/No Players Found/', $text)) {
                    echo '<tr><td><p style="color:red">Такого игрока не существует.</p><br>';
                    $lable=true;
                } else {
                    $urluser = 'http://albiondb.net/player/' . $user['UserName'];
                    $text2 = file_get_contents($urluser);
                    preg_match_all('#<div class="well">(.+?)</div>#su', $text2, $res);
                    $r = $res[0][0];

                    if (!preg_match('/War Gods/', $r)) {
                        echo '<tr><td><p style="color: red;">Игрок не состоит в гильдии.</p><br>';
                        $lable=true;
                    }
                }
                if ($lable) {
                    echo '<form method="post" action="?option=deleteuser">
                        <input type="text" value="' . $user['Id'] . '" name="id" hidden="hidden">
                        <input type="submit" name="go" value="X"> 
                    </form></td>';
                    echo '<td>' . $user['UserName'] . '</td>';

                    echo '</tr>';
                }
        }

        echo '</table>';
        mysqli_close($link);
    }
    }
}