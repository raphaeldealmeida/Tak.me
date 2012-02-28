<?php
namespace Mini;

class Recurso{
    
    private $conection = null;
    private $url;
    //private $id;
    
    public function setUrl($url) {
        $this->url = $url;
    }

    public function setShorten($shorten) {
        $shorten = str_replace('/', '', $shorten);
        $this->shorten = $shorten;
    }

        private $shorten;
    
    public function getUrl() {
        return $this->url;
    }

    public function getShorten() {
        return $this->shorten;
    }
    
    public function salvar(){
        $con = $this->getConection();
        $con->exec("INSERT INTO recurso (url, shorten) 
            VALUES ('".$this->url."', '".$this->shorten."')");
         $conn = null;
    }
    
    public function buscar(){
        $con = $this->getConection();
        $query = "SELECT id, url, shorten FROM recurso 
                              WHERE 1=1 ";
        
        if(!is_null($this->shorten)){
                $query .= "AND shorten = '$this->shorten' ";
        }
        
        if(!is_null($this->url)){
                $query .= "AND url = '$this->url' ";
        }
        
        $result = $con->query($query);
        
        if($result){
            foreach ($result as $linha) {
                $this->url = $linha['url'];
                $this->shorten =  $linha['shorten'];
                $this->id =  $linha['id'];
            }
         $con = null;   
        }else{
            throw new \InvalidArgumentException();
        }
    }
    
    private function getConection() {
        if(is_null($this->conection)){
            $this->conection = new \PDO('mysql:host=localhost;port=3306;dbname=shorten',
                'root', 'root');
        }
        return $this->conection;
    }
    public function getAcessos(){
        $conn = $this->getConection();
        $result = $conn->query("SELECT origem, acessado_em FROM visita
                              WHERE recurso_id  = '$this->id'");        
        
        $acessos = array();
        if($result){
            foreach ($result as $linha) {
                $acessos[] = array('acessado_em' => $linha['acessado_em'],
                                   'origem'      => $linha['origem']);
            }
         $conn = null;   
         return $acessos;
        }else{
            throw new \InvalidArgumentException();
        }
    }
    
    public function addAcesso($origem = null) {
        $date = new \DateTime('now');
        $now = $date->format('Y/m/d h:i:s');
        
        
        //Insert usando binding
        
        $con = $this->getConection();
        $query = $con->prepare("INSERT INTO visita (recurso_id, acessado_em, origem) 
            VALUES (:id, :acessado_em, :origem)");
        
        $query->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $query->bindParam(':acessado_em', $now, \PDO::PARAM_STR);
        $query->bindParam(':origem', $origem, \PDO::PARAM_STR);
        $result = $query->execute();
        
        if(!$result)
            throw new \Exception ('Não foi possível registrar o acesso.');
        $con = null;
    }
}