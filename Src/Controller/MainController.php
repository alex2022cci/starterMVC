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
        $Post = $this->Post->findFirst(
            array(
                'conditions' => 'id=1'
                )
        );
        $this->set('post', $Post);
      
    }
    
    /*  public function index()
    {
        $this->render('index');
    }*/
}