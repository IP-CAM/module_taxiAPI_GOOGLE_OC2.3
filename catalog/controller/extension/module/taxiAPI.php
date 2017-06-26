<?php
ini_set('display_errors',1);
error_reporting(E_ALL ^E_NOTICE);

class ControllerExtensionModuleTaxiAPI extends Controller {
    public function index() {
        //добавляем свои скрипты
        $this->document->addStyle('catalog/view/css/taxiAPI/taxiAPI.css');
        $this->document->addScript('catalog/view/javascript/jquery/taxiAPI/jquery.validate.min.js');
        $this->document->addScript('catalog/view/javascript/jquery/taxiAPI/taxiAPI.js');
        
        $this->load->language('extension/module/taxiAPI');
  
                
 
                $data['from'] = $this->language->get('from');
                $data['currency'] = $this->session->data['currency'];
                $data['budget'] = $this->language->get('budget');
                $data['business'] = $this->language->get('business');
                $data['premium'] = $this->language->get('premium');
                $data['where_to_go_from'] = $this->language->get('where_to_go_from');
                $data['where_to_go'] = $this->language->get('where_to_go');
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
                $data['payment_method'] = $this->language->get('payment_method');
                $data['checkque'] = $this->language->get('checkque');
                $data['price_button'] = $this->language->get('price_button');
                $data['confirm'] = $this->language->get('confirm');
                $data['choise'] = $this->language->get('choise');
                $data['tarif'] = $this->language->get('tarif');
                
                
                
                //получаем цены на тарифы и стоимость за 1 км
                $data['budgetPrice'] = $this->config->get('taxiAPI_standartPrice');
                $data['businessPrice'] = $this->config->get('taxiAPI_businessPrice');
                $data['premiumPrice'] = $this->config->get('taxiAPI_minivenPrice');
                //$data['1kmPrice'] = $this->config->get('taxiAPI_price');
                
                
            // Payment Methods
            $this->load->model('extension/extension');
            $data['payment'] =  $this->model_extension_extension->getExtensions('payment');
                
                //$this->response->setOutput($this->load->view('extension/module/taxiAPI', $data));
                
                return $this->load->view('extension/module/taxiAPI', $data);
 
    }

    //получаем данные по ajax ОФОРМИТЬ
    public function getDataPriceConfirm(){
                
        //получаем массив данных
        $dataPriceConfirm = $this->getDataTaxi($this->request->post['dataTaxiConfirm']);
        
        //получаем сколько км по маршруту
        $km = $this->setDataGoogleAPI($dataPriceConfirm);
                
        #расчет  по ликпею если все гуд то перекидывать на success. Так же сделать  по оплате 
        #наличными.
        
        //если все гуд и мы получаем сумму то мы  начинаем оформлять заказ
        if(!empty((int)$km)){
            $this->load->model('checkout/order');
            $this->load->language('extension/payment/cheque');
            $comment  = $this->language->get('text_payable') . "\n";
            $comment .= $this->config->get('cheque_payable') . "\n\n";
            $comment .= $this->language->get('text_address') . "\n";
            $comment .= $this->config->get('config_address') . "\n\n";
            $comment .= $this->language->get('text_payment') . "\n";
          
            $dataInfo = array(
                'price'                 => (int)$km,
                'to_whomName'           => $dataPriceConfirm["dataInfoOrder"]["to_whomName"],
                'to_whomPhone'          => $dataPriceConfirm["dataInfoOrder"]["to_whomPhone"],
                'dataWhence'            => $dataPriceConfirm["arrayDataWhence"]["whenceCity"]." ".$dataPriceConfirm["arrayDataWhence"]["whenceStreet"]." ".$dataPriceConfirm["arrayDataWhence"]["whenceHouse"]." ".$dataPriceConfirm["arrayDataWhence"]["whenceExtr"],
                'dataWhere'             => $dataPriceConfirm["arrayDataWhere"]["whereCity"]." ".$dataPriceConfirm["arrayDataWhere"]["whereStreet"]." ".$dataPriceConfirm["arrayDataWhere"]["whereHouse"]." ".$dataPriceConfirm["arrayDataWhere"]["whereExtr"],
                'dataWhenceCity'        => $dataPriceConfirm["arrayDataWhence"]["whenceCity"],
                'payment_method_code'   => $dataPriceConfirm['dataInfoOrder']['payment'],
                
            
            );
            //оформляем заказ в соответствии со способом заказа
            
            switch($dataPriceConfirm['dataInfoOrder']['payment']){
                
                case "cheque":
                    
                    $this->load->model('extension/module/taxiAPI');
                    
                   //получаем данные для оформления ордера (массив) 
                   $order_data = $this->addOrderTaxi($dataInfo);
                    
                
                   //получили ордер id
                   $this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

                   $dataOrderSet = array(
                        'order_id' => $this->session->data['order_id'],
                        'status'   => $this->config->get('cheque_order_status_id'),
                        'comment'  => $comment,
                        'notify'   => true,
                        'price'    => $dataInfo['price'],

                    );
                    
                   //создаем заказ в админке
                $result =  (int)$this->model_extension_module_taxiAPI->addOrderHistory($dataOrderSet);
                    
                
                
                if(!empty($result)){
                    echo "index.php?route=checkout/success";
                }
                
                break;
                
                case "cod":
                    
                    $this->load->model('extension/module/taxiAPI');
                    
                   //получаем данные для оформления ордера (массив) 
                   $order_data = $this->addOrderTaxi($dataInfo);
                    
                
                   //получили ордер id
                   $this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

                   $dataOrderSet = array(
                        'order_id' => $this->session->data['order_id'],
                        'status'   => "2",
                        'comment'  => $comment,
                        'notify'   => true,
                        'price'    => $dataInfo['price'],

                    );
                    
                   //создаем заказ в админке
                $result =  (int)$this->model_extension_module_taxiAPI->addOrderHistory($dataOrderSet);
                    
                
                
                if(!empty($result)){
                    echo "index.php?route=checkout/success";
                }
                
                break;
            
                case "liqpay":
                $this->load->model('extension/module/taxiAPI');

                 //получаем данные для оформления ордера (массив) 
                   $order_data = $this->addOrderTaxi($dataInfo);
                    
                
                   //получили ордер id
                   $this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);
                   
                   $dataOrderSet = array(
                        'order_id' => $this->session->data['order_id'],
                        'status'   => 2,
                        'comment'  => $comment,
                        'notify'   => true,
                        'price'    => $dataInfo['price'],

                    );
                    
                    $result =  (int)$this->model_extension_module_taxiAPI->addOrderHistory($dataOrderSet);
                    
                   
                   //ключи liqpay
		    $public_key  = "i95396534003";
		    $private_key = "XQn4j31AmB6eKMKlCjm3oFXa7Z80L2lpT8qPKSAX";
		    
                   
                   $params = array(
                    'action'         => 'pay',
                    'amount'         => $dataInfo['price'],
                    'currency'       => $this->session->data['currency'],
                    'description'    => 'taxi',
                    'order_id'       => $this->session->data['order_id'],
                    'version'        => '3',
                    'result_url'    => $_SERVER['SERVER_NAME']."/"."index.php?route=checkout/success",
                    'sender_first_name' => $dataInfo['to_whomName'],
                   // 'sandbox'	=> 1,
                    
                    
                    );
                   
                   $data        = base64_encode(json_encode(array_merge(compact('public_key'), $params)));
		   $signature   = base64_encode(sha1($private_key.$data.$private_key, 1));
		 
                
		    if(!empty($result)){
			echo "https://www.liqpay.com/api/3/checkout?data=".$data."&"."signature=".$signature;
		    }
                    
                   
                   
                    
                break;
                
                
            }
        }
        
 
        
        
    }
    
    
    //метод формирования массива данных с формы (тариф, откуда и куда)
    public function getDataTaxi($data){
        
        //получаем данные по сериализации
     $dataTaxi = $this->unserializeTaxiForm($data);
                   
        //цена за 1 км
        //$price1km = $this->config->get('taxiAPI_price');
        
        //ключ от API гугл
        //Обязательное для заполнения поле
        if(!empty($this->config->get('taxiAPI_apiKey'))){
            $keyAPI = $this->config->get('taxiAPI_apiKey');
        }else{
            $keyAPI = "";
        }


        //Данные откуда ехать
        
       //Обязательное для заполнения поле
        if(!empty($dataTaxi['whenceCity'])){
            $whenceCity = urldecode($dataTaxi['whenceCity']);
        }else{
            $whenceCity = " ";
        }
        
        if(!empty($dataTaxi['tarif'])){
            $tarif = urldecode($dataTaxi['tarif']);
        }else{
            $tarif = " ";
        }
        
        if(!empty($dataTaxi['whenceStreet'])){
            $whenceStreet = urldecode($dataTaxi['whenceStreet']); 
        }else{
            $whenceStreet = " ";
        }
        
        if(!empty($dataTaxi['whenceHouse'])){
            $whenceHouse = urldecode($dataTaxi['whenceHouse']);
        }else{
            $whenceHouse = " ";
        }
        
        if(!empty($dataTaxi['whenceExtr'])){
            $whenceExtr = urldecode($dataTaxi['whenceExtr']);
        }else{
            $whenceExtr = " ";
        }
        
        //создаем массив по даным откуда
        $arrayDataWhence = array(
            "whenceCity"    =>$whenceCity,
            "whenceStreet"  =>$whenceStreet,
            "whenceHouse"   =>$whenceHouse,
            "whenceExtr"    =>$whenceExtr,
            "tarif"         =>$tarif,
            
        );
        
        
        //Данные куда ехать
        
       //Обязательное для заполнения поле
        if(!empty($dataTaxi['whereCity'])){
            $whereCity = urldecode($dataTaxi['whereCity']);
        }else{
            $whereCity = " ";
        }
        
        if(!empty($dataTaxi['whereStreet'])){
            $whereStreet = urldecode($dataTaxi['whereStreet']); 
        }else{
            $whereStreet = " ";
        }
        
        if(!empty($dataTaxi['whereHouse'])){
           $whereHouse = urldecode($dataTaxi['whereHouse']);
        }else{
            $whereHouse = " ";
        }
        
        if(!empty($dataTaxi['whereExtr'])){
            $whereExtr = urldecode($dataTaxi['whereExtr']);
        }else{
            $whereExtr = " ";
        }
        
        //создаем массив по даным куда
        $arrayDataWhere = array(
            "whereCity"     =>$whereCity,
            "whereStreet"   =>$whereStreet,
            "whereHouse"    =>$whereHouse,
            "whereExtr"     =>$whereExtr
        );
        
        
        //информация о покупателе
        if(!empty($dataTaxi['to_whomName'])){
            $to_whomName = urldecode($dataTaxi['to_whomName']);
        }else{
            $to_whomName = " ";
        }
        
        if(!empty($dataTaxi['to_whomPhone'])){
            $to_whomPhone = urldecode($dataTaxi['to_whomPhone']);
        }else{
            $to_whomPhone = " ";
        }
        
        if(!empty($dataTaxi['payment'])){
            $payment = urldecode($dataTaxi['payment']);
        }else{
            $payment = " ";
        }
        
        //формируем массив с данными о покупателе
        $dataInfoOrder = array(
            "to_whomName"    =>$to_whomName,
            "to_whomPhone"   =>$to_whomPhone,
            "payment"        =>$payment
        );
        
        
        
         //создаем массив данных по маршруту
        $dataArrayTaxi = array(
            "keyAPI"            =>$keyAPI,
            "arrayDataWhence"   =>$arrayDataWhence,
            "arrayDataWhere"    =>$arrayDataWhere,
            "dataInfoOrder"     =>$dataInfoOrder,
        );
        
        
        return $dataArrayTaxi;      
    }
    
    //получаем нормальный массив (после сериализации)
     public function unserializeTaxiForm($str){
        $returndata = array();
        $strArray = explode("&amp;", $str);
        $i = 0;
        foreach ($strArray as $item) {
            $array = explode("=", $item);
            $returndata[$array[0]] = $array[1];
        }

        return $returndata;
    }
    
    //метод для получения км по маршруту
    public function setDataGoogleAPI($dataArrayTaxi){
          $this->load->language('extension/module/taxiAPI');
       
        //ключ гугл
        $key = $dataArrayTaxi['keyAPI'];
         //получаем данные откуда
        $whence = urlencode($dataArrayTaxi["arrayDataWhence"]['whenceCity']." ".$dataArrayTaxi["arrayDataWhence"]['whenceStreet']." ".$dataArrayTaxi["arrayDataWhence"]['whenceHouse']." ".$dataArrayTaxi["arrayDataWhence"]['whenceExtr']);
        
        //получаем данные куда
        $where = urlencode($dataArrayTaxi["arrayDataWhere"]['whereCity']." ".$dataArrayTaxi["arrayDataWhere"]['whereStreet']." ".$dataArrayTaxi["arrayDataWhere"]['whereHouse']." ".$dataArrayTaxi["arrayDataWhere"]['whereExtr']);
        
        
        //формируем строку для получения данных
        $maps = "https://maps.googleapis.com/maps/api/directions/json?origin=$whence&destination=$where&units=metric&key=$key";

        //декодируем строку с JSON
        $getJsonMaps = json_decode(file_get_contents($maps));

        
        //ловим ошибки (если ввели неправильно адресс или результат пустой)
        $error = $getJsonMaps->status;
        
        //если в запросе  ошибка то прекращаем работу скрипта
        if($error == "NOT_FOUND" || $error == "ZERO_RESULTS"){
            $km = $this->language->get('error_message');
        }else{

    //получаем км (только саму цыфру)
        $km = (int)$getJsonMaps->routes[0]->legs[0]->distance->text;
        
        //определяем какой тариф используется
          switch($dataArrayTaxi["arrayDataWhence"]['tarif']){
                case "StandartPrice":
                  $tarif = $this->config->get('taxiAPI_standartPrice');
                break;

                case "BusinesPrice":
                    $tarif = $this->config->get('taxiAPI_businessPrice');
                break;

                case "PremiumPrice":
                    $tarif = $this->config->get('taxiAPI_minivenPrice');
                break;

                default:
                   $tarif = 0;

            }
        
         //если тариф больше 0 то считаем стоимость иначе выводит сообщение о ошибке
         if(!empty($tarif)){
             
             //считаем стоимость проезда
             $summa = $tarif*$km;
             $km = $summa." ".$this->session->data['currency'];
         }else{
            $km = "Ошибка, возможно не выбран тариф!!!"; 
         }
        
  

    }

         return $km;
    }
    
    //подготавливаем данные для создания ордера и получение его id
    public function addOrderTaxi($data){
        
        
        //используется API опенкарта
        $order_data = array();
        
        // Validate cart has products and has stock.
	if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
		$redirect = $this->url->link('checkout/cart');
	}
        // Gift Voucher
			$order_data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$order_data['vouchers'][] = array(
						'description'      => $voucher['description'],
						'code'             => token(10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],
						'amount'           => $voucher['amount']
					);
				}
			}
                        
        
        $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
        $order_data['store_id'] = $this->config->get('config_store_id');
        $order_data['store_name'] = $this->config->get('config_name');
        
        $totals = array();
    $taxes = $this->cart->getTaxes();
    $total = $data['price'];
                
    // Because __call can not keep var references so we put them into an array.
    $total_data = array(
            'totals' => &$totals,
            'taxes'  => &$taxes,
            'total'  => &$total
    );
        
        $this->load->model('extension/extension');
        $sort_order = array();
        
        $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
    }
          
        array_multisort($sort_order, SORT_ASC, $results);
        
        foreach ($results as $result) {
            if ($this->config->get($result['code'] . '_status')) {
        $this->load->model('extension/total/' . $result['code']);

        // We have to put the totals in an array so that they pass by reference.
        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
    }
        
        $sort_order = array();
        
        foreach ($totals as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
    }
        
        array_multisort($sort_order, SORT_ASC, $totals);
        
        $order_data['totals'] = $totals;
                
        
        if ($order_data['store_id']) {
            $order_data['store_url'] = $this->config->get('config_url');
        } else {
            if ($this->request->server['HTTPS']) {
                $order_data['store_url'] = HTTPS_SERVER;
            } else {
                            $order_data['store_url'] = HTTP_SERVER;
            }
    }
        
        $this->load->model('account/customer');
        $order_data['customer_id'] = 0;
    $order_data['customer_group_id'] = 0;
    $order_data['firstname'] = $data["to_whomName"];
    $order_data['lastname'] = "user";
    $order_data['email'] = "not found";
    $order_data['telephone'] = $data["to_whomPhone"];
    $order_data['fax'] = 0000;
    $order_data['custom_field'] = 0000;
        
        $order_data['payment_firstname'] = $data["to_whomName"];
    $order_data['payment_lastname'] = "user";
    $order_data['payment_company'] = "not found";
    $order_data['payment_address_1'] = $data["dataWhence"];
    $order_data['payment_address_2'] = $data["dataWhere"];
    $order_data['payment_city'] = $data["dataWhenceCity"];
    $order_data['payment_postcode'] = 0000;
    $order_data['payment_zone'] = 0000;
    $order_data['payment_zone_id'] = 0000;
    $order_data['payment_country'] = "not found";
    $order_data['payment_country_id'] = 0000;
    $order_data['payment_address_format'] = 0000;
    $order_data['payment_custom_field'] = 0000;
        $order_data['affiliate_id'] = 0;
    $order_data['commission'] = 0;
        $order_data['marketing_id'] = 0;
        $order_data['tracking'] = '';
        
        $order_data['payment_method'] = $this->language->get('checkque');
        
        if($data["payment_method_code"] == "liqpay"){
        
        $order_data['payment_method'] = "liqpay";
	  
        }
        
        $order_data['payment_code'] = $data["payment_method_code"];            
                
            $order_data['shipping_firstname'] = '';
            $order_data['shipping_lastname'] = '';
            $order_data['shipping_company'] = '';
            $order_data['shipping_address_1'] = '';
            $order_data['shipping_address_2'] = '';
            $order_data['shipping_city'] = '';
            $order_data['shipping_postcode'] = '';
            $order_data['shipping_zone'] = '';
            $order_data['shipping_zone_id'] = '';
            $order_data['shipping_country'] = '';
            $order_data['shipping_country_id'] = '';
            $order_data['shipping_address_format'] = '';
            $order_data['shipping_custom_field'] = array();
            $order_data['shipping_method'] = '';
            $order_data['shipping_code'] = '';
            
            $option_data = array();
            
            $option_data[] = array(
        'product_option_id'       => " ",
        'product_option_value_id' => " ",
        'option_id'               => " ",
        'option_value_id'         => " ",
        'name'                    => " ",
        'value'                   => " ",
        'type'                    => " "
            );
                

        $order_data['products'][] = array(
            'product_id' => substr(time(),-5),
            'name'       => $data["dataWhence"]."-".$data["dataWhere"],
            'model'      => "not found",
            'option'     => $option_data,
            'download'   => 0000,
            'quantity'   => 1,
            'subtract'   => 0000,
            'price'      =>  $data["price"],
            'total'      =>  $data["price"],
            'tax'        => 0000,
            'reward'     => 0000
    );
        
    $order_data['comment'] = "not found";
    $order_data['total'] = $data["price"];
    
    $order_data['language_id'] = $this->config->get('config_language_id');
        
        // Gift Voucher
	$data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
		foreach ($this->session->data['vouchers'] as $voucher) {
                    $data['vouchers'][] = array(
                        'description' => $voucher['description'],
                        'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
                    );
		}
            }
                
    $order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
    $order_data['currency_code'] = $this->session->data['currency'];
    $order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
        
    $order_data['ip'] = $this->request->server['REMOTE_ADDR'];        
        
        if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
            $order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
            $order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
    } else {
            $order_data['forwarded_ip'] = '';
    }

    if (isset($this->request->server['HTTP_USER_AGENT'])) {
            $order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
    } else {
            $order_data['user_agent'] = '';
    }

    if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
            $order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
    } else {
            $order_data['accept_language'] = '';
        }
        
        return $order_data;
    }
    
    //функция которая подтягивает данные (обновление данных без ведома пользователей)
    public function getDataPriceButton(){
        
        //получаем массив данных
        $dataPriceButton = $this->getDataTaxi($this->request->post['dataTaxi']);
        
        //получаем сколько км по маршруту
        $km = $this->setDataGoogleAPI($dataPriceButton);
        
        echo  $km;
    }

}