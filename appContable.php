<?php

if (!isset($argv[1]))
{
    print ("No hay ID de sesión"); 
    die ();
}
else
{
    $sesionID=$argv[1];
    session_id($sesionID);
    session_start();
    print "Bienvenido ".session_id();

    $registro= [];
    $codMemory=[];
    $codMemoryBorrar= [];
    $codMontos= [];
    $codMontoEgreso = [];
    $codMontoIngreso = [];
    $existe= [];
    $fechaRegistros= [];
    $fechasConsultadas= [];
    $codMontoEgresoNew=[];
    $codMontoIngresoNew=[];
    $montosFechasConsultadas= [];

    if(isset($_SESSION[$sesionID]))
      $registro= $_SESSION[$sesionID];
    
        $operacion= isset($argv[2]) ?? null;
    if ($operacion == null || $operacion != 'registro' || $operacion != 'consulta' || $operacion != 'borrar' || $operacion != 'limpiar' || $operacion != 'exportar')
        echo "\nA continuación de tu ID, debes escribir una de las palabras clave para operaciones:\nregistro\nconsulta, \nborrar,\nlimpiar,\nexportar."; 
         
    if ($operacion == 'registro')
    {
    
        if (!(isset($argv[3])))
        {
            print ("\r\nA continuación de registro, debe ingresar un código.");
            die();
        }

        else
        {    
            if (isset($registro[$argv[3]]))
            {
                echo "\r\nEl código que has ingresado, ya existe. Para realizar un nuevo registro debes ingresar un código diferente a los existentes.";
            }

            else
            {
                if (!isset($argv[4]))   
                {
                    echo "\r\nA continuación del código, debes ingresar una fecha en formato AAAA-MM-DD";
                }
                
                else
                {
                    $fecha = new DateTime($argv[4]);

                    if ((isset($argv[5])) && $argv[5] != 0)
                    {
                        $codigo= $argv[3];
                        $fechaReg= $fecha ->format('Y-m-d');
                        $monto= $argv[5];         
                    
                        $registro[$codigo]= 
                        [
                            'fecha'=>$fechaReg,
                            'monto'=> $monto,
                        ];
                        

                        $_SESSION[$sesionID]= $registro;

                        if ($monto <0)
                        {
                            print "\r\nHas registrado un egreso de " .$monto; print " del día " .$fechaReg; print "\nEl código único es ".$codigo;
                        }

                        else
                        {
                            print "\r\nHas registrado un ingreso de " .$monto; print " del día " .$fechaReg; print "\nEl código único es ".$codigo;
                        }
                    }    

                    else 
                    {
                        echo ("\r\nA continuación de la fecha, debes ingresar un monto distinto de 0.\r\nMenor que 0 para egresos.\r\nMayor que cero para ingresos.\r\n");
                    }   

                    file_put_contents("$sesionID.txt", print_r($_SESSION,true));
                }
            }
        }
    }
}
       
