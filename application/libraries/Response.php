<?php

class Response{

    public function __construct(){
    }
    
    public function send($data, $status_code = 200){
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($status_code);
        $result = array();

        if($status_code < 400){
            $result["result"] = $data;
        }
        else{
            $result["error"] = $data;
        }

        echo json_encode( $result );
        die();
    }

    public function readParams($param_name = null){

        $parsed_data = json_decode( file_get_contents('php://input') );
        
        if(!isset($parsed_data)){
            return NULL;
        }

        if(!$param_name){
            return $parsed_data;
        }

        if( !property_exists( $parsed_data, $param_name ) ){
            return NULL;
        }
        return $parsed_data->{$param_name};
    }
    

}

?>