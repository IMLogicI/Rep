<?php


class logs extends core
{
    public function get_body()
    {
        parent::get_body(); // TODO: Change the autogenerated stub

        $rolelink=mysqli_connect( HOST, USER, PASSWORD, DB );
        $userrole=$_SESSION['role'];
        $rolequery2="SELECT FlagId FROM rolesflags WHERE RoleId=$userrole AND FlagId=5";
        $roleres2=mysqli_query($rolelink,$rolequery2,MYSQLI_STORE_RESULT);

        if (mysqli_num_rows($roleres2)>0){
            echo '<table><tr><td>Операци</td><td>От кого</td><td>Кому</td><td>Сколько</td><td>Дата</td></tr>';
            $link=mysqli_connect( HOST, USER, PASSWORD, DB );
            $query="SELECT * FROM Logs ORDER BY DateTime DESC";
            $res=mysqli_query($link,$query,MYSQLI_STORE_RESULT);
            for ($i=0;$i<mysqli_num_rows($res);$i++){
                $ops=mysqli_fetch_array($res,MYSQLI_ASSOC);
                $opid=$ops['Id'];
                $oplink=mysqli_connect( HOST, USER, PASSWORD, DB );
                $opquery="Select OperationName FROM operations WHERE Id=$opid";
                $opres=mysqli_query($oplink,$opquery,MYSQLI_STORE_RESULT);
                $op=mysqli_fetch_array($opres,MYSQLI_ASSOC);

                $fromid=$ops['ById'];
                $fromquery= "SELECT UserName FROM autoriation WHERE Id=$fromid";
                $fromres=mysqli_query($oplink,$fromquery,MYSQLI_STORE_RESULT);
                $from = mysqli_fetch_array($fromres,MYSQLI_ASSOC);

                $toid=$ops['AdresantId'];
                $toquery= "SELECT UserName FROM autoriation WHERE Id=$toid";
                $tores=mysqli_query($oplink,$toquery,MYSQLI_STORE_RESULT);
                $to = mysqli_fetch_array($tores,MYSQLI_ASSOC);
                echo'<tr><td>'.$op['OperationName'].'</td><td>'.$from['UserName'].'</td><td>'.$to['UserName'].'</td><td>'.$ops['Sum'].'</td><td>'.$ops['DateTime'].'</td></tr>';
            }
        }
        else{
            echo 'Войдите, чтобы просматривать эту страницу';
        }
    }
}