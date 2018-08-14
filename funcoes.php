<?php

//funçao que aplica mascara em textos
function mask($val, $mask){
 $maskared = '';
 $k = 0;
 for($i = 0; $i<=strlen($mask)-1; $i++){
    if($mask[$i] == '#'){
        if(isset($val[$k]))
            $maskared .= $val[$k++];
    }else{
        if(isset($mask[$i]))
            $maskared .= $mask[$i];
    }
 }
return $maskared;
}

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234567890';
$simb = '!@#$%*-';
$retorno = '';
$caracteres = '';
$caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
            if ($simbolos) $caracteres .= $simb;
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }
return $retorno;
}
function validaCpf($cpf){
            $j=0;
            for($i=0; $i<(strlen($cpf)); $i++){
                    if(is_numeric($cpf[$i])){
                            $num[$j]=$cpf[$i];
                            $j++;
                        }
                }
            if(count($num)!=11){
                    $isCpfValid=false;
                }else{
                    for($i=0; $i<10; $i++){
                            if ($num[0]==$i && $num[1]==$i && $num[2]==$i && $num[3]==$i && $num[4]==$i && $num[5]==$i && $num[6]==$i && $num[7]==$i && $num[8]==$i){
                                    $isCpfValid=false;
                                    break;
                                }
                        }
                }
            if(!isset($isCpfValid)){
                    $j=10;
                    for($i=0; $i<9; $i++){
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica);    
                    $resto = $soma%11;            
                    if($resto<2){
                            $dg=0;
                        }else{
                            $dg=11-$resto;
                        }
                    if($dg!=$num[9]){
                            $isCpfValid=false;
                        }
                }
            if(!isset($isCpfValid)){
                    $j=11;
                    for($i=0; $i<10; $i++){
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica);
                    $resto = $soma%11;
                    if($resto<2){
                            $dg=0;
                        }else{
                            $dg=11-$resto;
                        }
                    if($dg!=$num[10]){
                            $isCpfValid=false;
                        }else{
                            $isCpfValid=true;
                        }
                }
            return $isCpfValid;                    
        }

?>