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
                
                
                
                //получаем цены на тарифы и стоимость за 1 км
                $data['budgetPrice'] = $this->config->get('taxiAPI_standartPrice');
                $data['businessPrice'] = $this->config->get('taxiAPI_businessPrice');
                $data['premiumPrice'] = $this->config->get('taxiAPI_minivenPrice');
                //$data['1kmPrice'] = $this->config->get('taxiAPI_price');
                
                
                #TODO при расчете по АПИ км надо вывести общую стоимость заказа
                
            
          if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error_warning'] = '';
        }
                
            // Payment Methods
            $this->load->model('extension/extension');
            $data['payment'] =  $this->model_extension_extension->getExtensions('payment');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
                
                $this->response->setOutput($this->load->view('extension/module/taxiAPI', $data));
                
 
    }
    
    //получаем данные по ajax СТОИМОСТЬ
    public function getDataPriceButton(){
        
        //получаем массив данных
        $dataPriceButton = $this->getDataTaxi($this->request->post['dataTaxi']);
        
        //получаем сколько км по маршруту
        $km = $this->setDataGoogleAPI($dataPriceButton);
        
        echo  $km;
    }
    
    //получаем данные по ajax ОФОРМИТЬ
    public function getDataPriceConfirm(){
        
        //получаем массив данных
        $dataPriceConfirm = $this->getDataTaxi($this->request->post['dataTaxiConfirm']);
        
        //получаем сколько км по маршруту
        $km = $this->setDataGoogleAPI($dataPriceConfirm);
        
        
        /*
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
         * 
         *          */
        
        //если все гуд и мы получаем сумму то мы  начинаем оформлять заказ
        if(!empty((int)$km)){
                
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
        
        
        #TODO надо создать switch  где ловить по классу методы оплаты и только тогда в этом же методе 
        #осуществлять функцию оплаты по методу, если нету отплаты то ничего не делать 
        #посмотреть API ликпея и обычной оплаты и в модели модуля сделать аналогию просто отдав данные 
        #и по примеру сделать расчет и перенаправление и оформление заказа 
        
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

}