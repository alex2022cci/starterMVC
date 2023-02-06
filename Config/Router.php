<?php

class Router
{
    /**
     * @param string $url
     * @param mixed $request
     * @return array
     */
    static function parse($url, $request)
    {
        $url = trim($url, '/');
        $params = explode('/', $url);
        /*
        $r = array(
            'controller' => $params[0],
            'action'     => $params[1] ?? 'index' // isset($params[1]) ? Params[1] : 'index' 
        );
        $r['params'] = array_slice($params, 2);  // return controlleur / action / param
        return $r;
        */
        $request->controller = $params[0];
        $request->action = $params[1] ?? 'index';
        $request->params = array_slice($params, 2);
        return true;
    }
}