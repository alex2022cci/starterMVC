<?php


Class Dispatcher
{
    /**
     * Summary of request
     * @var \Request $request
     */
    var $request;

    public function __construct()
    {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();
        
        if(!in_array($this->request->action, get_class_methods($controller)))
        {
            $this->error('Le controller ' . $this->request->controller . ' n\'a pas de méthode ' . $this->request->action);
        }
        call_user_func_array(array($controller, $this->request->action), $this->request->params);
        $controller->render($this->request->action);
    }
    
    function loadController()
    {
        //fetch all controller dynamicaly from src/controller
        $name = ucfirst($this->request->controller). 'Controller';
        $file = __ROOT__ . __DS__ . 'Src/Controller' . __DS__ . $name . '.php';
        require $file;
        return new $name($this->request);
    }
    /**
     * Renvoi vers la page 404 si les ressources ne sont pas trouvées
     * @param mixed $message
     * @return never
     */
    function error($message)
    {
       
        $controller = new Controller($this->request);
        $controller->e404($message);
       
    }
}
