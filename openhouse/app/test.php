<?php
    $json = array();
    $json['first'] = 12;
    $json['second'] = 13;
    $json['third'] = 'yang';
    $arrx['yang'] = 1;
    $arrx['yi'] = 2;
    $json['forth'] = $arrx;

    foreach ($json as $key=>$value){
        echo '$key is '.$key.'<br>';
        echo '$value is '.$value.'<br>';
    }

    echo json_encode($json);
?>
