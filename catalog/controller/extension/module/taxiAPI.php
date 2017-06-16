<?php
ini_set('display_errors',1);
error_reporting(E_ALL ^E_NOTICE);

class ControllerExtensionModuleTaxiAPI extends Controller {
    public function index() {
		$this->load->language('extension/module/taxiAPI');
                $this->document->setTitle($this->language->get('heading_title'));
                
                $data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
 
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/taxiAPI', '', true)
		);
                
  
		$data['heading_title'] = $this->language->get('heading_title');
                $data['from'] = $this->language->get('from');
                $data['UAH'] = $this->language->get('UAH');
                $data['budget'] = $this->language->get('budget');
                $data['business'] = $this->language->get('business');
                $data['premium'] = $this->language->get('premium');
                $data['where_to_go_from'] = $this->language->get('where_to_go_from');
                $data['city'] = $this->language->get('city');
                $data['street'] = $this->language->get('street');
                $data['house'] = $this->language->get('house');
                $data['extr'] = $this->language->get('extr');
                $data['pay'] = $this->language->get('pay');
                $data['where_to_go_from'] = $this->language->get('where_to_go_from');
                $data['total'] = $this->language->get('total');
                $data['to_whom'] = $this->language->get('to_whom');
                $data['to_whomName'] = $this->language->get('to_whomName');
                $data['to_whomPhone'] = $this->language->get('to_whomPhone');
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                #TODO надо создать функцию которая будет вытягивать цены по 3 тарифам и вывести 
                #вполе где цены. Вытянуть цены нужено юзать setting/setting  и ключь по какому сохранял
                
                #TODO при расчете по АПИ км надо вывести общую стоимость заказа
                
                #TODO  способы оплаты сколько включили сколько и выводим
                
  		 
                
                if ($this->cart->hasShipping()) {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 5);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 6);
		} else {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 3);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 4);	
		}
                
                if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}
                
                $data['shipping_required'] = $this->cart->hasShipping();

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
                
                $this->response->setOutput($this->load->view('extension/module/taxiAPI', $data));
                
 
 	}
}