<?php
namespace Mini;

class Encurtador{
    
    private $recurso;

    public function setUrl($url) {
        if($this->isValid($url)){
            $shorten = $this->shorten($url);
            $this->recurso = new Recurso();
            $this->recurso->setShorten($shorten);
            $this->recurso->setUrl($url);
            return $shorten;
        }else{
            throw new \InvalidArgumentException();
        }
    }
    
    public function isValid($url) {
        return preg_match(
                '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i',
                $url);
    }
    public function shorten($url){
        return md5($url);
    }
    
    /**
     *
     * @return Mini\Recurso
     */
    public function getRecurso() {
        return $this->recurso;
    }

    public function setRecurso($recurso) {
        $this->recurso = $recurso;
    }
}