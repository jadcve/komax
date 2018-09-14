<?php

namespace App;

/*
Clase Convert_to_csv
*/

class Convert_to_csv {
    public static function create($input_array, $output_file_name, $delimiter)
    {
        //abre la memoria como archivo, para no usar archivo temporal, estar atento si se queda sin memoria
        $archivo = fopen('php://memory', 'w');
        // recorre el array  
        foreach ($input_array as $line) {
            // coloca los elementos en el archivo
            fputcsv($archivo, $line, $delimiter);
        }
        // coloca el puntero en la primera linea
        fseek($archivo, 0);
        
        //crea los headers para el csv
        header('Content-Type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        
        // envia el archivo al navegador
        fpassthru($archivo);

        //termina la tarea
        exit();
    }
};