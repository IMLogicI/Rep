<?php

function get_requests($statusid){

}

class requests extends core
{
    public function get_body()
    {
        parent::get_body(); // TODO: Change the autogenerated stub

        if (isset($_SESSION['role'])) {
            $rolelink = mysqli_connect(HOST, USER, PASSWORD, DB);
            $userrole = $_SESSION['role'];
            $rolequery = "SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=1";
            $roleres = mysqli_query($rolelink, $rolequery, MYSQLI_STORE_RESULT);
            $cantrade = false;

            if (mysqli_num_rows($roleres) > 0) {
                $cantrade = true;
            }

            echo '<b>Созданные лоты</b><br><br><table><tr><td>N</td><td>Место хранения лота</td><td>Участники</td><td>Создатель</td>';

            if ($cantrade) {
                echo '<td>Взять лот</td>';
            }

            $redlink = mysqli_connect(HOST, USER, PASSWORD, DB);
            $redquery = "SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=7";
            $redres = mysqli_query($redlink, $redquery, MYSQLI_STORE_RESULT);
            $canred = false;

            if (mysqli_num_rows($redres) > 0) {
                $canred = true;
            }

            if ($canred){
                echo '<td>Удалить</td>';
            }

            echo '</tr>';

            $link = mysqli_connect(HOST, USER, PASSWORD, DB);
            $query = "SELECT Id,CreatedById,ChestId FROM loot WHERE StatusId=1";
            $result = mysqli_query($link, $query, MYSQLI_STORE_RESULT);

            for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                $n = $i + 1;
                echo '<tr><td>' . $n . '</td>';
                $loot = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $lootid = $loot['ChestId'];
                $id = $loot['Id'];
                $link2 = mysqli_connect(HOST, USER, PASSWORD, DB);
                $query2 = "SELECT * FROM lootchests WHERE Id=$lootid";
                $res2 = mysqli_query($link2, $query2, MYSQLI_STORE_RESULT);
                $lootchest = mysqli_fetch_array($res2, MYSQLI_ASSOC);
                echo '<td>' . $lootchest['LootName'] . '</td><td>';
                $link3 = mysqli_connect(HOST, USER, PASSWORD, DB);
                $query3 = "SELECT UserId FROM userloot WHERE LootId=$id";
                $res3 = mysqli_query($link3, $query3, MYSQLI_STORE_RESULT);

                for ($j = 0; $j < mysqli_num_rows($res3); $j++) {
                    $user = mysqli_fetch_array($res3, MYSQLI_ASSOC);
                    $userid = $user['UserId'];
                    $link4 = mysqli_connect(HOST, USER, PASSWORD, DB);
                    $query4 = "SELECT UserName FROM autoriation WHERE Id=$userid";
                    $res4 = mysqli_query($link4, $query4, MYSQLI_STORE_RESULT);
                    $username = mysqli_fetch_array($res4, MYSQLI_ASSOC);
                    echo $username['UserName'] . ' ';
                }

                $creatorid=$loot['CreatedById'];
                $linkcreator = mysqli_connect(HOST, USER, PASSWORD, DB);
                $querycreator = "SELECT UserName FROM autoriation WHERE Id=$creatorid";
                $rescreator = mysqli_query($linkcreator, $querycreator, MYSQLI_STORE_RESULT);
                $creator=mysqli_fetch_array($rescreator,MYSQLI_ASSOC);
                echo '</td>'.$creator['UserName'].'<td>';

                if ($cantrade) {
                    echo '</td><td><form method="post" action="?option=takelot">
                        <input type="text" value="' . $id . '" name="lot" hidden="hidden">
                        <input type="submit" name="take" value="Взять"> 
                    </form>';
                }

                if ($canred) {
                    echo '<td><form method="post" action="?option=deletrequest">
                        <input type="text" value="' . $id . '" name="id" hidden="hidden">
                        <input type="submit" name="go" value="X"> 
                    </form></td>';
                }

                echo '</td></tr>';
            }

            echo '</table>';

            echo '<b>На продаже</b><br><br><table><tr><td>N</td><td>Место хранения лота</td><td>Участники</td><td>Создатель</td><td>Трейдер</td>';

            if ($cantrade) {
                echo '<td>Сдать лот</td>';
            }

            if ($canred){
                echo '<td>Удалить</td>';
            }

            echo '</tr>';

            $link1 = mysqli_connect(HOST, USER, PASSWORD, DB);
            $query1 = "SELECT Id,CreatedById,ChestId,TraderId FROM loot WHERE StatusId=2";
            $result1 = mysqli_query($link1, $query1, MYSQLI_STORE_RESULT);

            for ($i = 0; $i < mysqli_num_rows($result1); $i++) {
                $n = $i + 1;
                echo '<tr><td>' . $n . '</td>';
                $loot = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                $lootid = $loot['ChestId'];
                $id = $loot['Id'];
                $link2 = mysqli_connect(HOST, USER, PASSWORD, DB);
                $query2 = "SELECT * FROM lootchests WHERE Id=$lootid";
                $res2 = mysqli_query($link2, $query2, MYSQLI_STORE_RESULT);
                $lootchest = mysqli_fetch_array($res2, MYSQLI_ASSOC);
                echo '<td>' . $lootchest['LootName'] . '</td><td>';
                $link3 = mysqli_connect(HOST, USER, PASSWORD, DB);
                $query3 = "SELECT UserId FROM userloot WHERE LootId=$id";
                $res3 = mysqli_query($link3, $query3, MYSQLI_STORE_RESULT);

                for ($j = 0; $j < mysqli_num_rows($res3); $j++) {
                    $user = mysqli_fetch_array($res3, MYSQLI_ASSOC);
                    $userid = $user['UserId'];
                    $link4 = mysqli_connect(HOST, USER, PASSWORD, DB);
                    $query4 = "SELECT UserName FROM autoriation WHERE Id=$userid";
                    $res4 = mysqli_query($link4, $query4, MYSQLI_STORE_RESULT);
                    $username = mysqli_fetch_array($res4, MYSQLI_ASSOC);
                    echo $username['UserName'] . ' ';
                }

                $creatorid=$loot['CreatedById'];
                $linkcreator = mysqli_connect(HOST, USER, PASSWORD, DB);
                $querycreator = "SELECT UserName FROM autoriation WHERE Id=$creatorid";
                $rescreator = mysqli_query($linkcreator, $querycreator, MYSQLI_STORE_RESULT);
                $creator=mysqli_fetch_array($rescreator,MYSQLI_ASSOC);
                echo '</td>'.$creator['UserName'].'<td>';

                $trader = $loot['TraderId'];
                echo '</td><td>';
                $link5 = mysqli_connect(HOST, USER, PASSWORD, DB);
                $query5 = "SELECT UserName FROM autoriation WHERE Id=$trader";
                $res5 = mysqli_query($link5, $query5, MYSQLI_STORE_RESULT);
                $tradername = mysqli_fetch_array($res5, MYSQLI_ASSOC);
                echo $tradername['UserName'];

                if ($cantrade) {
                    echo '</td><td>';

                    if ($_SESSION['UserId'] == $loot['TraderId']) {
                        echo '<form method="post" action="?option=sellot">
                        <input type="text" value="' . $id . '" name="lot" hidden="hidden">
                        <label>Введите стоимость продажи</label><br> <label>(за вычетом починки и своих 10 %)</label><br>
                        <input type="number" name="cost"> <br>
                        <input type="submit" name="take" value="Закрыть"> 
                    </form>';
                    }
                }

                if ($canred) {
                    echo '<td><form method="post" action="?option=deletrequest">
                        <input type="text" value="' . $id . '" name="id" hidden="hidden">
                        <input type="submit" name="go" value="X"> 
                    </form></td>';
                }

                echo '</td></tr>';
            }

            echo '</table>';

            echo '<b>Продано</b><br><br><table><tr><td>N</td><td>Место хранения лота</td><td>Участники</td><td>Создатель</td><td>Трейдер</td><td>Сумма</td></tr>';

            $link6 = mysqli_connect(HOST, USER, PASSWORD, DB);
            $query6 = "SELECT Id,CreatedById,ChestId,TraderId,Cost FROM loot WHERE StatusId=3";
            $result6 = mysqli_query($link6, $query6, MYSQLI_STORE_RESULT);

            for ($i = 0; $i < mysqli_num_rows($result6); $i++) {
                $n = $i + 1;
                echo '<tr><td>' . $n . '</td>';
                $loot = mysqli_fetch_array($result6, MYSQLI_ASSOC);
                $lootid = $loot['ChestId'];
                $id = $loot['Id'];
                $link2 = mysqli_connect(HOST, USER, PASSWORD, DB);
                $query2 = "SELECT * FROM lootchests WHERE Id=$lootid";
                $res2 = mysqli_query($link2, $query2, MYSQLI_STORE_RESULT);
                $lootchest = mysqli_fetch_array($res2, MYSQLI_ASSOC);
                echo '<td>' . $lootchest['LootName'] . '</td><td>';
                $link3 = mysqli_connect(HOST, USER, PASSWORD, DB);
                $query3 = "SELECT UserId FROM userloot WHERE LootId=$id";
                $res3 = mysqli_query($link3, $query3, MYSQLI_STORE_RESULT);

                for ($j = 0; $j < mysqli_num_rows($res3); $j++) {
                    $user = mysqli_fetch_array($res3, MYSQLI_ASSOC);
                    $userid = $user['UserId'];
                    $link4 = mysqli_connect(HOST, USER, PASSWORD, DB);
                    $query4 = "SELECT UserName FROM autoriation WHERE Id=$userid";
                    $res4 = mysqli_query($link4, $query4, MYSQLI_STORE_RESULT);
                    $username = mysqli_fetch_array($res4, MYSQLI_ASSOC);
                    echo $username['UserName'] . ' ';
                }

                $creatorid=$loot['CreatedById'];
                $linkcreator = mysqli_connect(HOST, USER, PASSWORD, DB);
                $querycreator = "SELECT UserName FROM autoriation WHERE Id=$creatorid";
                $rescreator = mysqli_query($linkcreator, $querycreator, MYSQLI_STORE_RESULT);
                $creator=mysqli_fetch_array($rescreator,MYSQLI_ASSOC);
                echo '</td>'.$creator['UserName'].'<td>';

                $trader = $loot['TraderId'];
                echo '</td><td>';
                $link5 = mysqli_connect(HOST, USER, PASSWORD, DB);
                $query5 = "SELECT UserName FROM autoriation WHERE Id=$trader";
                $res5 = mysqli_query($link5, $query5, MYSQLI_STORE_RESULT);
                $tradername = mysqli_fetch_array($res5, MYSQLI_ASSOC);
                echo $tradername['UserName'] . '</td><td>' . $loot['Cost'] . '</td></tr>';
            }

            echo '</table>';

        }
        else {
            echo 'Войдите, чтобы просматривать эту страницу';
        }
    }
}