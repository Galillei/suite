<?php

namespace Controller;
use \Model\User; //использование глобального имени Model\Article как Article т.е при вызове Article вызывается класс Model/Article
use \Model\Security; // хранятся все коды генерации и проверок на подлинность тех или иных данных
use \Model\FILES; // обрабатываются, записываются загружаемые файлы

class IndexController extends \Library\Controller
{

       public function registerUserAction(){
        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            $error ='';
			$createUser = new User();
            $doctorWeb = new Security();
            $post_pass = $doctorWeb->trimPass($_POST['password']);
            if($doctorWeb->checkLogin($_POST['login']))
            {//проверяем мыло на валидность, если мыло прошло валидность, то обрезаем его и добавляем в сreateUser
                $post_login = $doctorWeb->trimLogin($_POST['login']);
                $createUser->setLogin($post_login);
                if($createUser->checkUser())
                {//проверяем есть ли такой пользователь в базе данных, если нет - поехали дальше
                    if($doctorWeb->checkPass($post_pass))
                    {//проверяем на валидность пароль, если все проверки юзер прошел успешно - заносим его в базу данных
                        $newPass = $doctorWeb->generationPassToDB($post_pass);
                        $createUser->setPassword($newPass);
                        unset($newPass);//после загрузки пароля в createUser  - удаляем переменную
                        $createUser->createUserDir();// создаём папку для хранения данных юзером

                        $createUser->saveInsert();
                        $nameTable = $createUser->getNameOfUserTable();
                        $_SESSION['nameTable'] = $nameTable;
                        $_SESSION['dir'] = $createUser->getPathDir();
                        $_SESSION['name'] = $post_login;

                    }
                    else
                    {
                        $error = 'This password is invalid';
                    }

                }
                else
                {
                    $error= 'This email is busy';
                }
            }
            else
            {
                $error = 'This email is invalid';
            }
//            var_dump($error);
            if(strlen($error)>0)
            {
                $this->renderView(array('error'=>$error),'createUser.php');
            }
            else
            {
            $this->renderView(array(),'userPage.php');
            }
        }
        else
        {
            $this->renderView(array(),'createUser.php');
        }


}
    public function indexAction(){
               $error ='';
        if  (($_SERVER['REQUEST_METHOD']=='POST')and (!isset($_SESSION['name'])))
        {
            if(!isset ($_SESSION['name']))
            {
            $createUser = new User();
            $doctorWeb = new Security();
            $post_pass = $doctorWeb->trimPass($_POST['password']);
            if($doctorWeb->checkLogin($_POST['login']))
            {//проверяем мыло на валидность, если мыло прошло валидность, то обрезаем его и добавляем в сreateUser

                $post_login = $doctorWeb->trimLogin($_POST['login']);
                $createUser->setLogin($post_login);
                  if($doctorWeb->checkPass($post_pass))
                    {//проверяем на валидность пароль, если все проверки юзер прошел успешно - проверяем есть ли такой юзер

                        $newPass = $doctorWeb->generationPassToDB($post_pass);
                        $createUser->setPassword($newPass);

                        if($createUser->loginIn()){

                        unset($newPass);//после загрузки пароля в createUser  - удаляем переменную

                        $_SESSION['name'] = $post_login;
                            //передаём путь к папке и имя таблицы юзера в контроллер FILES, который будет обделывать файл как нам нужно и будет формировать нам данные для отображения

                            //заносим путь к папке в переменную
                            $dir = $createUser->getPathDir();
                            //заносим в сессию данные о пути к папке
                            $_SESSION['dir'] = $dir;

                            $nameTable = $createUser->getNameOfUserTable();
                            $_SESSION['nameTable'] = $nameTable;
                            $this->renderView(array(),'userToFile.php');
                        }
                      else{
                          $error = 'Mail or password is wrong';
                      }

                    }


                    else
                    {
                        $error = 'Mail or password is wrong';
                    }

                }
                else
                {
                    $error = 'Mail or password is wrong';
                }
            }
        }
            elseif((isset($_SESSION['name'])) && (isset($_SESSION['nameTable']))&& (isset($_SESSION['dir'])))
            {


                $this->renderView(array(),'userToFile.php');
            }




//            var_dump($error);
            if(strlen($error)>0)
            {
                $this->renderView(array('error'=>$error),'login.php');
            }
            else{
                $this->renderView(array(),'login.php');
            }

        }

    public function filesAction($numberPage)
    {

        if((isset($_SESSION['name'])) && (isset($_SESSION['nameTable']))&& (isset($_SESSION['dir']) && !isset($_FILES['filename'])))
        {
//        var_dump($numberPage['number']);
        $user = new User();
        $file = new FILES();
        $user->setLogin($_SESSION['name']);


        $file->setGetDir($_SESSION['dir']);
        $file->setGetTable($_SESSION['nameTable']);

        $dir = $file->getDirRoot();
        $result = $file->allFilesView();
//            var_dump($result);
//        $result = $this->cutResult($numberPage['number'],$result);
        $this->renderView(array('result'=>$result,'dir'=>$dir,'numberPage'=>$numberPage['number']),'loginTrue.php');
        }
        elseif((isset($_SESSION['name'])) && (isset($_SESSION['nameTable']))&& (isset($_SESSION['dir']) && isset($_FILES['filename'])))
        {
//            var_dump($_FILES['filename']);
            $user = new User();
            $file = new FILES();
            $user->setLogin($_SESSION['name']);
            $arrayDataFiles = $user->returnData();
//                die(var_dump($arrayDataFiles));


            $file->setGetDir($_SESSION['dir']);
            $file->setGetTable($_SESSION['nameTable']);
            $file->checkDownloadsFile($arrayDataFiles);
//            var_dump($_SESSION['filename']);

//            die();
//            $dir = $file->getDirRoot();
            $result = $file->allFilesView();
//            die(var_dump($result));
//            $result = $this->cutResult($numberPage['number'],$result);
            unset($_FILES['filename']);
//            var_dump($numberPage['number']);
            $this->renderView(array('result'=>$result,'numberPage'=>'1'),'loginTrue.php');
        }
        else{
//            var_dump($numberPage['number']);
            $this->renderView(array(),'toLogin.php');
        }
        }


    public function logOutAction(){
            $createUser = User::getInstance();
         //die( var_dump($createUser->getLogin()));
            $createUser->logOut();
            $this->renderView(array(),'userDelete.php');
        }

    private function cutResult($count,$result)
    {
        $i = 0;
        $count =$count*PERPAGE;
        while($i<((int)$count-1))
        {
            array_shift($result);
            $i++;
        }
//                var_dump($count);

        return $result;
    }

    public function userAction($type)
    {
//        if((isset($_SESSION['dir'])) and ($_SESSION['dir'] == $type['dir']))
//        {


        $types = array_keys($type);
        $fileType = $types[0];
        $contentType = $fileType.'/'.$type[$fileType];
//        $first = array_keys($types);
        //формируем путь к файлу
        $pathFile = 'FILES'.DIRECTORY_SEPARATOR.$type['dir'].DIRECTORY_SEPARATOR.$type['file'];
//        var_dump($pathFile);

        if(file_exists($pathFile))
        {
//        header('Location:');
            $filename = $type['filename'];
//            header("Pragma: public");
//            header("Cache-Control: no-store, max-age=0, no-cache, must-revalidate");
//            header("Cache-Control: post-check=0, pre-check=0", false);
//            header("Cache-Control: private");

            header('Content-type: application/save');
            header("Content-Type: $contentType; name=$filename");
            header("Content-Disposition: attachment; filename=$filename");
        readfile($pathFile);}
        }
}
