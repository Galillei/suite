<html>
<body>
<h3>Welcome!</h3>
<?php
use Model\PageNavigator;
$view = '';
$i = 0;
$totalcount = count($result);
$pagename ='index';
$numpages = ceil($totalcount/PERPAGE);
$offset = (int)$numberPage-1;
$count = PERPAGE*(int)$numberPage;
$result = cutResult($count,$result);
$i += PERPAGE*((int)$numberPage-1);
//var_dump($totalcount);
if($numpages>1){
    $nav = new \Model\PageNavigator($pagename,$totalcount,PERPAGE,$count-5);

}

foreach($result as $files)
{
    if($i>=$count)
        break;
    $row = '';
    $i++;
//    $row = $i.'<a href='.'user/'.$files->getType().'/dir'.DIRECTORY_SEPARATOR.$files->getPath().DIRECTORY_SEPARATOR.'file/'.$files->getNameOfFileNew().'/filename/'.$files->getNameOfFileOld().'>'.$files->getNameOfFileOld().    '</a></br>';
//    var_dump( $files->getPath());
    $row = $i.'.<a href=/FILES'.DIRECTORY_SEPARATOR.$files->getPath().DIRECTORY_SEPARATOR.$files->getNameOfFileNew().'>'.$files->getNameOfFileOld().    '</a></br>';
    $view .=$row;
}
echo $view;
echo $nav->getNavigator();
function cutResult($count,$result)
{
    $i = 0;
//    $count =$count*PERPAGE;
    while($i<((int)$count-5))
    {
        array_shift($result);
        $i++;
    }
//                var_dump($count);

    return $result;
}
?>
<form  method="post" action = "/index/files/number/1" enctype="multipart/form-data">
    <input type="file" name="filename"><br>
    <input type="submit" value="Загрузить"><br>
</form>

</body>
</html>