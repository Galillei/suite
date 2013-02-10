<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 16.01.13
 * Time: 12:06
 * To change this template use File | Settings | File Templates.
 */
namespace Model;
class Security
{
    private $password;
    private $email;


    public function checkLogin($mail)
    {
//        записываем регулярное выражение для проверки мыла

        return (preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail));

    }
    public function trimLogin($mail){
        $mail = stripcslashes($mail);
        $mail = htmlspecialchars($mail);
        $mail = trim($mail);
        return $mail;
    }
    public function trimPass($pass)
    {
        $pass = stripcslashes($pass);
        $pass = htmlspecialchars($pass);
        $pass = trim($pass);
        return $pass;
    }
    public function checkPass($pass){
        if(strlen($pass)<8)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function generationPassToDB($pass)
    {
        $pass = md5(md5($pass));
        $pass = $pass."df453a";
        return $pass;
    }
}
