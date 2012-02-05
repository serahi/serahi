<?php

function check_access($located){
    $module = '';
    $action = '';
    if( !$located )
        return;
    
    if( isset ($located[0]) )
        $module = $located[0];
    if( isset ( $located[1]) )
        $action = $located[1];  
//    echo "module = " . $module . "<br/>";
//    echo "action = " . $action ;
    
//    $user_id = session->userdata('user_id');
    
    
    
    
}

?>
