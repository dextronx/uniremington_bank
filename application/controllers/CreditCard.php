<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreditCard extends CI_Controller {

   public function __construct(){
      parent::__construct();
      $this->load->model("credit_model");
   }
   
   public function create_request()
   {
      $params = $this->getParamsCreateRequestOrThrowError();

      if( $this->credit_model->check_identification_in_blacklist( $params["identification"] ) ){
         $this->response->send( "Actualmente no puedes generar una solicitud debido a tu puntaje crediticio" );
      }

      $result_save = $this->credit_model->save_request_credit($params);

      if(!$result_save){
         $this->response->send( "Hemos tenido un problema inesperado al intentar guardar tu solicitud" );
      }

      $this->response->send( "En el transcurso de 72 horas te estaremos notificando el resultado de tu solicitud" );
   }
   
   private function getParamsCreateRequestOrThrowError(){
      
      $request_params = $this->response->readParams("request");
      if(!isset($request_params)){
         $this->response->send( "No se ha especificado la información de la solicitud correctamente", 400);
      }
      
      if( !property_exists($request_params, "name") || 
         !is_string($request_params->name) ||   
         strlen($request_params->name) < 3 ||   
         strlen($request_params->name) > 50   
      ){
         $this->response->send( "El campo [nombres] debe de contener entre 3 y 50 caracteres", 400 );
      }

      if( !property_exists($request_params, "last_name") || 
         !is_string($request_params->last_name) ||   
         strlen($request_params->last_name) < 3 ||   
         strlen($request_params->last_name) > 50   
      ){
         $this->response->send( "El campo [apellidos] debe de contener entre 3 y 50 caracteres", 400 );
      }

      if( !property_exists($request_params, "identification_type_id") || 
         !is_string($request_params->identification_type_id) ||   
         (int)$request_params->identification_type_id < 1 ||   
         (int)$request_params->identification_type_id > 5   
      ){
         $this->response->send( "El campo [tipo de documento de identidad] no contiene un tipo valido", 400 );
      }

      if( !property_exists($request_params, "identification") || 
         !is_string($request_params->identification) ||   
         strlen($request_params->identification) < 3 ||   
         strlen($request_params->identification) > 20   
      ){
         $this->response->send( "El campo [numero de documento de identidad] debe de contener entre 3 y 20 caracteres", 400 );
      }

      if( !property_exists($request_params, "birthdate") || 
         !is_string($request_params->birthdate) ||
         !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $request_params->birthdate )  
      ){
         $this->response->send( "El campo [fecha de nacimiento] debe de contener entre 3 y 50 caracteres", 400 );
      }

      if( !property_exists($request_params, "city") || 
         !is_string($request_params->city) ||   
         strlen($request_params->city) < 3 ||   
         strlen($request_params->city) > 50   
      ){
         $this->response->send( "El campo [ciudad] debe de contener entre 3 y 50 caracteres", 400 );
      }

      if( !property_exists($request_params, "email") || 
         !is_string($request_params->email) ||   
         strlen($request_params->email) < 3 ||   
         strlen($request_params->email) > 50   
      ){
         $this->response->send( "El campo [correo electronico] debe de contener entre 3 y 50 caracteres", 400 );
      }

      if( !property_exists($request_params, "cellphone_number") || 
         !is_string($request_params->cellphone_number) ||   
         strlen($request_params->cellphone_number) != 10 ||
         !is_numeric($request_params->cellphone_number)
      ){
         $this->response->send( "El campo [telefóno celular] debe de contener 10 caracteres numericos", 400 );
      }

      if( !property_exists($request_params, "address") || 
         !is_string($request_params->address) ||   
         strlen($request_params->address) < 5 ||   
         strlen($request_params->address) > 100   
      ){
         $this->response->send( "El campo [dirección] debe de contener entre 3 y 100 caracteres", 400 );
      }

      if( !property_exists($request_params, "monthly_income") || 
         !is_string($request_params->monthly_income) ||   
         strlen($request_params->monthly_income) < 1 ||   
         strlen($request_params->monthly_income) > 10 ||
         !is_numeric($request_params->monthly_income)
      ){
         $this->response->send( "El campo [cuales son tus ingresos mensuales] debe de contener entre 5 y 10 caracteres", 400 );
      }

      return array(
         "name" => $request_params->name,
         "last_name" =>  $request_params->last_name,
         "identification_type_id"  =>  $request_params->identification_type_id,
         "identification"  =>  $request_params->identification,
         "birthdate"  =>  $request_params->birthdate,
         "city"  =>  $request_params->city,
         "address"  =>  $request_params->address,
         "monthly_income"  =>  $request_params->monthly_income,
         "email"  =>  $request_params->email,
         "cellphone_number"  =>  $request_params->cellphone_number
      );

      return $request_params;
   }
}
