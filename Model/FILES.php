<?php
namespace Model;
class FILES extends \Library\Model
{
    private $file_id;
    private $nameOfFileOld;
    private $path;
    private $date;
    private $nameOfFileNew;
    protected static $mapping = array(
        'file_id' => 'file_id',
        'nameOfFileOld' => 'nameOfFileOld',
        'type'=>'type',
        'path' => 'path',
        'date' => 'date',
        'nameOfFileNew'=>'nameOfFileNew',

    );
    private  $getDir;
    private  $getTable;
    private $type;

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setGetDir($getDir)
    {
        $this->getDir = $getDir;
    }

    public function getGetDir()
    {
        return $this->getDir;
    }

    public function setGetTable($getTable)
    {
        $this->getTable = $getTable;
    }

    public function getGetTable()
    {
        return $this->getTable;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setFileId($file_id)
    {
        $this->file_id = $file_id;
    }

    public function getFileId()
    {
        return $this->file_id;
    }

    public function setNameOfFileNew($nameOfFileNew)
    {
        $this->nameOfFileNew = $nameOfFileNew;
    }

    public function getNameOfFileNew()
    {
        return $this->nameOfFileNew;
    }

    public function setNameOfFileOld($nameOfFileOld)
    {
        $this->nameOfFileOld = $nameOfFileOld;
    }

    public function getNameOfFileOld()
    {
        return $this->nameOfFileOld;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public  function allFilesView()
    {
        $table = $this->getGetTable();
        $statement = self::getDBConnection()->prepare("SELECT*FROM .$table ORDER BY DATE DESC");
        $statement->execute();
        $result = self::fillFromDB($statement->fetchall(\PDO::FETCH_ASSOC));
//        die(var_dump($result));
        return $result;


    }

    public function checkDownloadsFile($arrayDate)
    {
        $file = $_FILES['filename'];
//     die(var_dump($_FILES['filename']));
        $tmp = $file['tmp_name'];
        if((file_exists($tmp))&&($_FILES['filename']['error']==0))
        {
            $fileDir = ROOT.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'FILES'.DIRECTORY_SEPARATOR.$arrayDate['pathDir'];
            $newNameFile = md5($file['name'].time());
            $nameFile = "$fileDir".DIRECTORY_SEPARATOR.$newNameFile;
            move_uploaded_file($tmp,$nameFile);
//            уничтожаем файлы, которые храняться в массиве $_FILES

            //загружаем в базу данных информация о файлах пользователя
            $this->downloadToDBFile($file['name'],$file['type'],$newNameFile,$arrayDate['nameOfUserTable'],$arrayDate['pathDir']);

        }
    }

    public function downloadToDBFile($oldNameFile,$type,$newNameFile, $nameTable,$path)
    {
        $now = new \DateTime;
        $format_data = $now->format("Y-m-d h:i:s");
        $statement = self::getDBConnection()->prepare("INSERT INTO $nameTable (`nameOfFileOld`,`type`,`path`,`date`,`nameOfFileNew`) VALUES(:nameOfFileOld,:type,:path,:dates,:nameOfFileNew)");
//        var_dump($oldNameFile);
        $statement->execute(array('nameOfFileOld'=>$oldNameFile,'type'=>$type,'path'=>$path,'dates'=>$format_data,'nameOfFileNew'=>$newNameFile));
    }
    /**
     * Saves object instance into db.
     */
    public function getDirRoot()
    {
        return ROOT.DIRECTORY_SEPARATOR.'FILES'.DIRECTORY_SEPARATOR;
    }
    public function save()
    {
        if ($this->getId())
            $this->saveUpdate();
        else
            $this->saveInsert();
    }

    /**
     * Object update.
     *
     * @abstract
     * @return mixed
     */
    protected  function saveUpdate()
    {

    }

    /**
     * New object creation.
     *
     * @abstract
     * @return mixed
     */
    protected function saveInsert()
    {

    }
    /**
     * Object update.
     *
     * @abstract
     * @return mixed
     */
    protected   function delete()
    {

    }
    public  function getId()
    {

    }



}
