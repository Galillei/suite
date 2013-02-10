<?php
namespace Library;
/**
 * Base view class.
 */
class View
{
    /**
     * @var string View script name.
     */
    private $viewScript;

    /**
     * @var array View script variables.
     */
    private $viewVariables = array();

    /**
     * @var string Layout script name.
     */
    private $layout;

    /**
     * @var array Layout variables.
     */
    private $layoutVariables = array();

    /**
     * Sets view script to view object.
     *
     * @param string $viewScript View script name.
     */
    public  function setViewScript($viewScript)
    {
        $this->viewScript = $viewScript;
//        echo "setViewScript";
//            var_dump($viewScript);
    }

    /**
     * Sets layout script to view object.
     *
     * @param string $layout Layout script name.
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Sets view script variables.
     *
     * @param array $viewVariables New view script variables.
     */
    public function setViewVariables($viewVariables)
    {
        $this->viewVariables = $viewVariables;
       // $this->layoutVariables = $viewVariables;
//        echo "setViewVariables";
//             var_dump($viewVariables);
    }

    /**
     * Adds new view script variable.
     *
     * @param string $key Variable name.
     * @param mixed $value Variable value.
     */
    public function addViewVariable($key, $value)
    {
        $this->viewVariables[$key] = $value;
    }

    /**
     * Sets layout variables.
     *
     * @param array $layoutVariables Layout variables.
     */
    public function setLayoutVariables($layoutVariables)
    {
        $this->viewVariables = $layoutVariables;

    }

    /**
     * Adds new layout variable.
     *
     * @param string $key Variable name.
     * @param mixed $value Variable value.
     */
    public function addLayoutVariable($key, $value)
    {
        $this->layoutVariables[$key] = $value;
    }

    /**
     * Renders view.
     */
    public function render()
    {

        extract($this->layoutVariables);
//        echo 'layout -line 103 Library\View-><br>';
//        var_dump($this->layoutVariables);
        require_once($this->layout);
    }

    /**
     * Renders only view script.
     */
    public function renderContent()
    {
        extract($this->viewVariables);
        require_once($this->viewScript);
    }




}
