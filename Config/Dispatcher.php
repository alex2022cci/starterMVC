<?php


Class Dispatcher
{
    /**
     * Summary of request
     * @var \Reponse $request
     */
    var $request;

    public function __construct()
    {
        $this->request = new Reponse();
        
        Router::parse($this->request->url, $this->request);

        $controller = $this->loadController();
        call_user_func_array(array($controller, $this->request->action), $this->request->params);
    }

    function loadController()
    {
        //fetch all controller dynamicaly depuis src/controller
        $name = ucfirst($this->request->controller). 'Controller';
        $file = __ROOT__ . __DS__ . 'Src/Controller' . __DS__ . $name . '.php';
        require $file;
        return new $name($this->request);
    }
}
