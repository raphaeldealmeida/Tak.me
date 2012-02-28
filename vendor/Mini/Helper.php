<?php
namespace Mini;
use \DateTime;

class Helper{
    static function dateIntervalHumanFriendly(DateTime $PastDate, DateTime $currentDate = null){
        //Utilização do novo operador ternario ?:
        $currentDate = $currentDate ?: new DateTime('now'); 

        $interval = $currentDate->diff($PastDate); 
        $years = $interval->format('%y'); 
        $months = $interval->format('%m'); 
        $days = $interval->format('%d'); 
        $hours = $interval->format('%H');
        $minutes = $interval->format('%i');
        $seconds = $interval->format('%s');

        if($interval->invert == 0){
            $ago = false;
        }elseif($years!=0){ 
            $ago = $years.' ano(s)'; 
        }elseif($months!=0){
            $ago = $months.' mês(es)'; 
        }elseif($days!=0){
            $ago = $days.' dia(s)'; 
        }elseif($hours!=0){
            $ago = $hours.' hora(s)';        
        }else{
            $ago = ($minutes == 0) ? $seconds.' segundo(s)' : $minutes.' minuto(s)'; 
        } 

        return ($ago)? $ago.' atrás': 'inválido'; 
    }
}