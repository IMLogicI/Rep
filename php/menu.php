<?php
echo '<div id="menu"><table width="100%">
        <tr>
            <td>
            ';
echo '    <a href="?option=main">Главная</a>
            </td><td>';

if(!isset($_SESSION['UserId']))
{
    echo '<a href="?option=autorisation">Войти</a>';
}
else
{
    echo ' <a href="?option=makerequest">Создание заявки</a>
            </td>
            <td>
                <a href="?option=requests">Просмотр заявок</a>';

    $rolelink=mysqli_connect( HOST, USER, PASSWORD, DB );
    $userrole=$_SESSION['role'];
    /*$rolequery="SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=4";
    $roleres=mysqli_query($rolelink,$rolequery,MYSQLI_STORE_RESULT);

    if(mysqli_num_rows($roleres)>0){*/
        echo '</td><td><a href="?option=adduser">Добавить участника</a>';
        $rolequery2="SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=3";
        $roleres2=mysqli_query($rolelink,$rolequery2,MYSQLI_STORE_RESULT);

        if(mysqli_num_rows($roleres2)>0){
            echo '</td><td><a href="?option=rolered">Изменить роль</a>';
        }
    //}
    $rolequery2="SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=2";
    $roleres2=mysqli_query($rolelink,$rolequery2,MYSQLI_STORE_RESULT);

    if (mysqli_num_rows($roleres2)>0){
        echo'</td><td><a href="?option=givecash">Выдать деньги</a>';
    }
    $rolequery2="SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=5";
    $roleres2=mysqli_query($rolelink,$rolequery2,MYSQLI_STORE_RESULT);

    if (mysqli_num_rows($roleres2)>0){
        echo'</td><td><a href="?option=logs">Транзакции</a>';
    }

    echo '</td>
            <td>
            <a href="?option=userexit">Выйти</a>';


}
echo'</td>
         </tr>
      </table>';
      
      if(isset($_SESSION['UserId'])){
          echo '<table width="100%"><tr><td><a href="?option=passwrenew">Сменить пароль</a></td><td style="text-align: right;">';
          $link=mysqli_connect( HOST, USER, PASSWORD, DB );
          $uid=$_SESSION['UserId'];
          $query="SELECT Sum FROM bank WHERE UserId=$uid";
          $res=mysqli_query($link,$query,MYSQLI_STORE_RESULT);
          $a=mysqli_fetch_array($res, MYSQLI_ASSOC);
          echo '<b> Ваш балланс: '.$a['Sum'].'</b></td></tr></table>';
      }
      echo '</div><div id="main">';