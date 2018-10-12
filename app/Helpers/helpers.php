<?php
//app/Helpers/Envato/User.php
namespace App\Helpers;
use Exception;
class General {
    public static function dia($num_dia){
        /**
         * Numero del día comienza por Domingo 1
        * @param int $num_dia numero del día
        * 
        * @return string Nombre del día
        */
        if ($num_dia <= 0 || $num_dia > 7) {
            throw new Exception('Los Días deben estar entre 1 y 7.');
        }
        else{
            $dias = array(1 => "Domingo", 2 => "Lunes", 3 => "Martes", 4 => "Miercoles", 5 => "Jueves", 6 => "Viernes", 7 => "Sábado");
            return $dias[$num_dia];
        }
    }

    public static function dias(){
        /**
         * Días de la Semana
        * 
        * @return array Nombres de los días
        */
        $dias = array(1 => "Domingo", 2 => "Lunes", 3 => "Martes", 4 => "Miercoles", 5 => "Jueves", 6 => "Viernes", 7 => "Sábado");
        return $dias;
    }

    public static function mes($num_mes){
        /**
        * Numero del mes comienza por Enero 1
        * @param int $num_mes numero del mes
        * 
        * @return string Nombre del mes
        */
        if ($num_mes <= 0 || $num_mes > 12) {
            throw new Exception('Los Meses deben estar entre 1 y 12.');
        }
        else{
            $meses = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");

            return $meses[$num_mes];
        }
    }

    public static function meses(){
        /**
         * Meses del año
        * 
        * @return array Nombres de los meses
        */
        $meses = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");

        return $meses;
    }
}