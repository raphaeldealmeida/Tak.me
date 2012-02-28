<?php
// Configuração do classloader PSR-0
require '../vendor/SplClassLoader.php';
$classLoader = new SplClassLoader('Mini', '../vendor/');
$classLoader->register();

//Arquivo com funções que não são carregadas por classloader
use \Mini\Mini,
    \Mini\Encurtador,
    \Mini\Helper;
 

$url_request = $_SERVER['REQUEST_URI'];
define('APPLICATION_PATH', $_SERVER['APPLICATION_PATH']);
define('APPLICATION_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');


$url = substr_replace($url_request, '', 0, strlen(APPLICATION_PATH));

$mini = new Mini();

//Utilização de funções anônimas 
$mini->get('/', function (){
    require '../app/view/home.php';
});

$mini->post('/', function(){
    $encurtador = new Encurtador();
    $encurtador->setUrl($_POST['url']);
    $recurso = $encurtador->getRecurso();
    $recurso->salvar();
    header('Location: ' . APPLICATION_URL . $recurso->getShorten(). '+');
});

$mini->get('/{hash}+', function($shorten){
    $recurso = new \Mini\Recurso();
    $recurso->setShorten($shorten);
    $recurso->buscar();
    $acessos = $recurso->getAcessos();
    include '../app/view/shorten.php';
});

$mini->get('/{hash}/{hash2}', function($hash, $hash2){
    
    echo $hash, $hash2;
    
});

$mini->get('/{hash}', function($shorten){
    $recurso = new \Mini\Recurso();
    $recurso->setShorten($shorten);
    $recurso->buscar();
    
    $origem = (isset($_SERVER['HTTP_REFERER']))? $_SERVER['HTTP_REFERER'] : null;
    
    $recurso->addAcesso($origem);
    header('Location: ' . $recurso->getUrl());
});

$mini->get('/{hash}.qrcode', function ($shorten){
    require_once 'Image/QRCode.php';
    header('Content-Type = image/png');
    $qrcode = new \Image_QRCode();
    $im = $qrcode->makeCode(APPLICATION_URL . $shorten, array(
        'image_type' => 'png',
    ));
});

$mini->run($url);