<?php
class Credit_model extends CI_Model {

    public function save_request_credit( $credit_request )
    {
        $result = $this->db->insert("credit_card_request", $credit_request);
        return $result;
    }


    public function check_identification_in_blacklist( $identification ){

        $result_query = $this->db->query("select * from identification_black_list where identification = ?", [$identification]);
        
        return $result_query ? $result_query->num_rows() > 0 : FALSE;

    }

}

?>