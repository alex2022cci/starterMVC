<?php


class MainController extends Controller
{
  
   public function view($id)
    {
       /* $this->set(array(
            'phrase' => 'Bonjour',
            'nom' => 'John Doe'
        ));
        $this->render('index');*/
        $this->loadModel('Post');
        $d['page'] = $this->Post->findFirst(
            array(
                'conditions' => array('id' => $id),
                'type'       => 'page' 
                )
        );

        if(empty($Post))
        {

            $this->e404('erreur 404, page not found');
        }
        $d['pages'] = $this->Post->find(array(
            'conditions' => array('type' => 'page') 
        ));
        $this->set($d);
    }
}
    /*  public function index()
    {
        $this->render('index');
    }*/
