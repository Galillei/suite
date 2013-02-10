<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artsem
 * Date: 11/10/12
 * Time: 8:23 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Model;
class User extends \Library\Model
{

    private $id;
    private $login;
    private $password;
    private $createdAt;
    private $nameDir;
    private $pathDir;
    private $nameOfUserTable;

    public function setPathDir($pathDir)
    {
        $this->pathDir = $pathDir;
    }

    public function getPathDir()
    {
        return $this->pathDir;
    }

    public function setNameOfUserTable($nameOfUserTable)
    {
        $this->nameOfUserTable = $nameOfUserTable;
    }

    public function getNameOfUserTable()
    {
        return $this->nameOfUserTable;
    }

    public function setNameDir($namedir)
    {
        $this->nameDir = $namedir;
    }

    public function getNameDir()
    {
        return $this->nameDir;
    }
    private static $instance;


    protected static $mapping = array(
        'id' => 'id',
        'login' => 'login',
        'password' => 'password',
        'created_at' => 'created_at',
        'pathDir'=>'pathDir',
        'nameOfUserTable'=>'nameOfUserTable',
    );

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getLogin()
    {
        return $this->login;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

//    private $text;

//    private $methodError;
    /**
     * Gets object unique id.
     *
     * @return mixed
     */
    public function setId($id){
        $this->id=$id;
    }
    public function getId()
    {
        return $this->id;
            }

     /**
     * Object update.
     *
     * @return mixed
     */
    protected function saveUpdate()
    {
        // TODO: Implement saveUpdate() method.
//        die(var_dump($this->getId()));
        $statement = self::getDBConnection()->prepare("UPDATE :users SET login = :login,password=:password WHERE id = :id");
        $statement->execute(array('login'=> $this->getLogin(),'password'=>$this->getPassword(),'id'=>$this->getId()));
    }
	public function checkUser(){
			$statement = self::getDBConnection()->prepare("SELECT * FROM users WHERE login = :login LIMIT 1");
			$statement->execute(array('login'=>$this->getLogin()));
			
			//echo ($this->getLogin());
			if($result = $statement->fetch(\PDO::FETCH_ASSOC)){
				return false;
			}
			else{
			return true;
			}

        	}

    public function createTableUser()
    {
        $users = $this->getNameOfUserTable();
//        var_dump($users);
        $statement = self::getDBConnection()->prepare("CREATE TABLE .$users LIKE user_files");
        $statement->execute();
    }
    /**
     * New object creation.
     *
     * @return mixed
     */

    public  function saveInsert()
    {
//        DIE(var_dump($this));
        // TODO: Implement saveInsert() method.
        $now = new \DateTime;
        $format_data = $now->format("Y-m-d h:i:s");
        $this->generateNameOfUserTable();
        $statement = self::getDBConnection()->prepare("INSERT into users(`login`, `password`,`created_at`,`pathDir`,`nameOfUserTable`) VALUES (:login, :password, :dateday, :pathDir, :nameOfUserTable)");
        $statement->execute(array('login'=> $this->getLogin(),'password'=>$this->getPassword(),'dateday'=>$format_data,'pathDir'=>$this->getPathDir(),'nameOfUserTable'=>$this->getNameOfUserTable()));
        $this->createTableUser();
     }

    public function delete(){
        $statement = self::getDBConnection()->prepare("DELETE FROM users WHERE id=:id");
        $statement->execute(array('id'=>$this->getId()));
    }
    public function logOut(){
        session_destroy();
    }
    public static function getInstance(){
        if (!self::$instance){
            self::$instance = new User();
        }
        return self::$instance;
    }

    private function generateNameOfUserTable()
    {
        $ignoreSymbol = array('.','@','<','>',',','!','"','+','/','?','|','\'');

        $name = $this->getLogin();
        $newName = str_replace($ignoreSymbol,'_',$name);
//        $newName = str_replace('@','_',$newName);
        if(substr($newName,0,1)=='_')
        {
            $newName = 'T'.$newName;
        }
        $newName = $newName.'Table';
        $this->setNameOfUserTable($newName);
    }

    private function generationNameForDir(){//генерирует имя папки, к которой потом будет обращаться пользователь сайта

        $pass = md5($this->getLogin());
        $pass = $pass."FILES";
        return $pass;

    }
    public function loginIn()
    {

        $pass = $this->getPassword();
        $login = $this->getLogin();

        $statement = self::getDBConnection()->prepare("SELECT*FROM users WHERE login=:login AND password = :password");
        $statement->execute(array('login'=>$login,'password'=>$pass));

        if ($result=$statement->fetch(\PDO::FETCH_ASSOC))
        {


            $this->setNameOfUserTable($result['nameOfUserTable']);
            $this->setPathDir($result['pathDir']);
        }
        else
        {
            return false;
        }
            return true;

    }
    public function returnData()
    {
        $login = $this->getLogin();
        $statement = self::getDBConnection()->prepare("SELECT id,created_at,pathDir,nameOfUserTable FROM users  WHERE login = :login ");
        $statement->bindParam('login',$login);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function createUserDir(){
        $rootDir =ROOT.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'FILES';;//имя папки где будут храниться все подкаталоги пользователей
        $nameDir = $this->generationNameForDir();
        $this->setPathDir($nameDir);
        $fullPathForDir = $rootDir.DIRECTORY_SEPARATOR.$nameDir;// формируем имя паки для данного пользователя
        if(!is_dir($rootDir)){
            mkdir($rootDir,0777);
        }
        if(!is_dir($fullPathForDir)){
            mkdir($fullPathForDir,0777);
        }
        $this->setNameDir($nameDir);

    }
}
