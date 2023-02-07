<?php


class Controller
{
    /**
     * Summary of request
     * @var mixed
     */
    public $request;
    public $vars = array();
    public $layout = 'base';
    private $rendered = false;
    function __construct($request)
    {
        $this->request = $request;
    }
    public function render($view)
    {
        if($this->rendered)
        {
            return false;
        }
        extract($this->vars);
        if(strpos($view, '/') === 0)
        {
            $view = __ROOT__ . __DS__ . 'Template'.$view.'.php';

        }
        else
        {
            $view = __ROOT__ . __DS__ . 'Template' . __DS__ . $this->request->controller .__DS__. $view . '.php';
        }
        ob_start();
        require $view; 
        $content_for_layout = ob_get_clean();
        require __ROOT__ . __DS__ . 'Template' . __DS__ .$this->layout. '.php';
        $this->rendered = true;

    }
    public function set($key, $value = null)
    {
        //on teste la validité de la clé
        if(is_array($key))
        {
            $this->vars += $key;
        }
        else
        {
            $this->vars[$key] = $value;
        }
    }

    function loadModel($name)
    {
        if(!isset($this->$name))
        {
            $file = __ROOT__ . __DS__ . 'Src' . __DS__ . 'Model' . __DS__ . $name . '.php';
            require_once($file);
            $this->$name = new $name;
        }
        else
        {
            echo 'Le model n\'est pas chargé ou n\'existe pas';
         }
    }

    function e404($message)
    {
        header("HTTP/1.0 404 Not found ");
     //   $controller = new Controller($this->request);
        $this->set('message', $message);
        $this->render('/error/404');
        die();
    }
}