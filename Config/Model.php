<?php

class Model
{
    static $connections = [];

    public $conf = 'default' ;
    public $table = false;
    public $db;
    public function __construct()
    {
        
        $conf = ConnectionDB::$database[$this->conf] ;
        if(isset(Model::$connections[$this->conf]))
        {
            $this->db = Model::$connections[$this->conf];
            return TRUE;
        }
        try
        {
            $pdo = new PDO(
                'mysql:dbname=' . $conf['database'] . ';host=' . $conf['host'] . ';',
                $conf['login'],
                $conf['password'],
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8')
            );
       
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            Model::$connections[$this->conf] = $pdo;
            $this->db = $pdo;


        } catch (PDOException $e){
            if(ConnectionDB::$debug >=1 )
            {
                die($e->getMessage());
            }
            else
            {
                die('Impossible de se connecter à la base de données');
            }
        }
        // initialisation des variables pour nos tables
        if($this->table === false)
        {
            $this->table = strtolower(get_class($this)).'s';
            // regex pour synchroniser notre classe avec notre table => Post <=> posts
        }
    }

    public function find($req)
    {
      //  $sql = 'SELECT * FROM posts ';
  
            $sql = 'SELECT * FROM '.$this->table.' AS '.get_class($this).' ';
            if(isset($req['conditions']))
            {
            $sql .= ' WHERE ';
            if(!is_array($req['conditions']))
            {
                $sql .= $req['conditions'];
            }
            else 
            {
                $cond = [];
                foreach($req['conditions'] as $k => $v)
                {
                    if(!is_numeric($v))
                    {
                        $v = '"'. ($v) .'"';
                        echo $v;
                    }
                    $cond[] = "$k = $v";
                }
                $sql .= implode(' AND ', $cond);
            }
            }
            $pre = $this->db->prepare($sql);
            $pre->execute();

            return $pre->fetchAll(PDO::FETCH_OBJ);
    }

    public function findFirst($req)
    {
        return current($this->find($req));

    }
}