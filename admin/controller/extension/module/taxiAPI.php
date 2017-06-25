<?php
ini_set('display_errors',1);
error_reporting(E_ALL ^E_NOTICE);

class ControllerExtensionModuleTaxiAPI extends Controller {
    private $error = array();
    
    public function index(){
        $this->load->language('extension/module/taxiAPI');
 
         $this->document->setTitle($this->language->get('heading_title'));
         $this->load->model('extension/module');
         $this->load->model('setting/setting');
 
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('taxiAPI', $this->request->post);
                $this->model_setting_setting->editSetting('taxiAPI', $this->request->post);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
                $this->model_setting_setting->editSetting('taxiAPI', $this->request->post);
            }
              $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }
        
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_api_google'] = $this->language->get('text_api_google');
        $data['text_key_api'] = $this->language->get('text_key_api');
        $data['text_price_standart'] = $this->language->get('text_price_standart');
        $data['text_price_business'] = $this->language->get('text_price_business');
        $data['text_price_miniven'] = $this->language->get('text_price_miniven');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['text_edit'] = $this->language->get('text_edit'); 
        $data['text_extension'] = $this->language->get('text_extension');
        $data['text_tarif_taxi'] = $this->language->get('text_tarif_taxi');
        $data['text_price_taxi'] = $this->language->get('text_price_taxi');
        $data['text_price'] = $this->language->get('text_price');
        $data['entry_name'] = $this->language->get('entry_name');
        
        
        
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        }
        else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }
  
        
       $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/taxiAPI', 'token=' . $this->session->data['token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/taxiAPI', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }


        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/taxiAPI', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/taxiAPI', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

       if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/taxiAPI', 'token=' . $this->session->data['token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/taxiAPI', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        



        if (isset($this->request->post['taxiAPI_apiKey'])) {
            $data['taxiAPI_apiKey'] = $this->request->post['taxiAPI_apiKey'];
        }
        else {
            $data['taxiAPI_apiKey'] = $this->config->get('taxiAPI_apiKey');
        }

        
        if (isset($this->request->post['taxiAPI_standartPrice'])) {
            $data['taxiAPI_standartPrice'] = $this->request->post['taxiAPI_standartPrice'];
        }
        else {
            $data['taxiAPI_standartPrice'] = $this->config->get('taxiAPI_standartPrice');
        }
        
        
        if (isset($this->request->post['businessPrice'])) {
            $data['taxiAPI_businessPrice'] = $this->request->post['taxiAPI_businessPrice'];
        }
        else {
            $data['taxiAPI_businessPrice'] = $this->config->get('taxiAPI_businessPrice');
        }
        
        
        if (isset($this->request->post['taxiAPI_minivenPrice'])) {
            $data['taxiAPI_minivenPrice'] = $this->request->post['taxiAPI_minivenPrice'];
        }
        else {
            $data['taxiAPI_minivenPrice'] = $this->config->get('taxiAPI_minivenPrice');
        }
        
        /* цена за 1км
        if (isset($this->request->post['taxiAPI_price'])) {
            $data['taxiAPI_price'] = $this->request->post['taxiAPI_price'];
        }
        else {
            $data['taxiAPI_price'] = $this->config->get('taxiAPI_price');
        }
        */
        
        // Группы
        $this->load->model('customer/customer_group');
        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
        
        
        
        $this->template = 'extension/module/taxiAPI.tpl';
        $this->children = array(
            'common/header',
            'common/footer' 
        );

        $data['heading_title'] = $this->language->get('heading_title');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        $this->response->setOutput($this->load->view('extension/module/taxiAPI.tpl', $data));

     }
      
  
    private function validate() {

        if (!$this->user->hasPermission('modify', 'extension/module/taxiAPI')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;

    }
 
    
}
