<?php
ini_set('display_errors',1);
error_reporting(E_ALL ^E_NOTICE);

class ControllerextensionmoduletaxiAPI extends Controller {
    
    public function index(){
        $this->load->language('extension/module/taxiAPI');
        $this->load->model('tool/image');

         $this->document->setTitle($this->language->get('heading_title'));
         
         $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->request->post['taxiAPI_GOOGLE_KEY'] = $this->config->get('taxiAPI_GOOGLE_KEY');
            $this->model_setting_setting->editSetting('taxiAPI', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }
        
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_api_google'] = $this->language->get('text_api_google');
        $data['text_key_api'] = $this->language->get('text_key_api');
        $data['text_price_taxi'] = $this->language->get('text_price_taxi');
        $data['text_price_standart'] = $this->language->get('text_price_standart');
        $data['text_price_business'] = $this->language->get('text_price_business');
        $data['text_price_miniven'] = $this->language->get('text_price_miniven');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['text_edit'] = $this->language->get('text_edit'); 
        $data['text_extension'] = $this->language->get('text_extension');
        
        
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        }
        else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = '';
        }
        
        if (isset($this->error['apiKey'])) {
            $data['apiKey'] = $this->error['apiKey'];
        }
        else {
            $data['apiKey'] = '';
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
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/taxiAPI', 'token=' . $this->session->data['token'], true)
        );
        $data['token'] = $this->session->data['token'];

        $data['action'] = $this->url->link('extension/module/taxiAPI', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
   
        
        if (isset($this->request->post['apiKey'])) {
            $data['apiKey'] = $this->request->post['apiKey'];
        }
        else {
            $data['apiKey'] = $this->config->get('apiKey');
        }
        
        if (isset($this->request->post['standartPrice'])) {
            $data['standartPrice'] = $this->request->post['standartPrice'];
        }
        else {
            $data['standartPrice'] = $this->config->get('standartPrice');
        }
        
        
        if (isset($this->request->post['businessPrice'])) {
            $data['businessPrice'] = $this->request->post['businessPrice'];
        }
        else {
            $data['businessPrice'] = $this->config->get('businessPrice');
        }
        
        
        if (isset($this->request->post['minivenPrice'])) {
            $data['minivenPrice'] = $this->request->post['minivenPrice'];
        }
        else {
            $data['minivenPrice'] = $this->config->get('minivenPrice');
        }
        
        
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

        return !$this->error;

    }

    public function install() {}

    public function uninstall() {}
    
}