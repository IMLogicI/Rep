<?php


class takelot extends core
{
    public function get_body()
    {
        parent::get_body(); // TODO: Change the autogenerated stub
        $rolelink=mysqli_connect( HOST, USER, PASSWORD, DB );
        $userrole=$_SESSION['role'];
        $rolequery="SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=1";
        $roleres=mysqli_query($rolelink,$rolequery,MYSQLI_STORE_RESULT);

        if(mysqli_num_rows($roleres)>0){
            $lotid=$_POST['lot'];
            $userid=$_SESSION['UserId'];
            $link=mysqli_connect( HOST, USER, PASSWORD, DB );
            $query="UPDATE loot SET TraderId=$userid, StatusId=2 WHERE Id=$lotid";
            $res=mysqli_query($link,$query,MYSQLI_STORE_RESULT);
            echo 'Лот записан на вас.';
        }
        else{
            echo 'У вас недостаточно прав дл просмотра этой страницы.';
        }
    }
}