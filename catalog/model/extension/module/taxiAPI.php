<?php
class ModelExtensionModuleTaxiAPI extends Model {
    
    //добавляем данные о заказе, что бы их видеть в админке
    public function addOrderHistory($data){
        $this->load->language('extension/module/taxiAPI');
        
        if(!empty($data)){
           $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$data['order_id']. "', order_status_id = '" . (int)$data['status'] . "', notify = '" . (int)$data['notify'] . "', comment = '" . $this->db->escape($data['comment']) . "', date_added = NOW()"); 
        
           $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$data['status'] . "', date_modified = NOW() WHERE order_id = '" . (int)$data['order_id'] . "'");
           
           $this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET value = '" . (int)$data['price'] . "' WHERE order_id = '" . (int)$data['order_id'] . "' AND code = 'sub_total'");
            
           
           return $data['order_id'];
        }
    }
    
}
