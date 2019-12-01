<?php
header("Content-type:text/html;charset=UTF-8");

require_once ("php/config.php");
require_once ("php/core.php");

session_start();

if(isset($_SESSION['UserId'])) {
    $linkin  = mysqli_connect(HOST, USER, PASSWORD, DB);
    $useridin  = $_SESSION['UserId'];
    $queryin = "SELECT RoleId FROM userroles WHERE UserId='$useridin'";
    $resin = mysqli_query($linkin, $queryin, MYSQLI_STORE_RESULT);
    $rolein = mysqli_fetch_array($resin, MYSQLI_ASSOC);
    $_SESSION['role'] = $rolein['RoleId'];
}

if ($_GET['option']) {
    $class =trim(strip_tags($_GET['option']));
}
else
{
    $class ='main';
}

if (file_exists("php/".$class.".php"))
{
    include ("html/header.html");
    include ("php/menu.php");
    include ("php/".$class.".php");

    if (class_exists($class))
    {
        $obj=new $class;
        $obj->get_body();
    }
    else{
        exit ("<p>Неверный путь</p>");
    }

    include("html/footer.html");
}
else
{
    exit ("<p>Неверный путь</p>");
}