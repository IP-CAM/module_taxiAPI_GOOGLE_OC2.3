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
                
                
                
                //получаем цены на тарифы и стоимость за 1 км
                $data['budgetPrice'] = $this->config->get('taxiAPI_standartPrice');
                $data['businessPrice'] = $this->config->get('taxiAPI_businessPrice');
                $data['premiumPrice'] = $this->config->get('taxiAPI_minivenPrice');
                $data['1kmPrice'] = $this->config->get('taxiAPI_price');
                
                
                #TODO при расчете по АПИ км надо вывести общую стоимость заказа
                
                #TODO  способы оплаты сколько включили сколько и выводим
           
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
    
    //получаем данные по ajax  подсчитываем км (стоимость) и если все гуд то выводим общую стоимость
    public function getDataTaxi(){
         
        //цена за 1 км
        //$price1km = $this->config->get('taxiAPI_price');
        
        //ключ от API гугл
        //Обязательное для заполнения поле
        if(!empty($this->config->get('taxiAPI_apiKey'))){
            $keyAPI = $this->config->get('taxiAPI_apiKey');
        }else{
            $keyAPI = "";
        }
        
        
        //тариф который выбрали (3 тарифа такси)
        //Обязательное для заполнения поле
        if(!empty($this->request->post['tariff'])){
            $tariff = $this->request->post['tariff'];
        }
        
        //Данные откуда ехать
        
       //Обязательное для заполнения поле
        if(!empty($this->request->post['whenceCity'])){
            $whenceCity = $this->request->post['whenceCity'];
        }
        
        if(!empty($this->request->post['whenceStreet'])){
            $whenceStreet = $this->request->post['whenceStreet']; 
        }else{
            $whenceStreet = " ";
        }
        
        if(!empty($this->request->post['whenceHouse'])){
            $whenceHouse = $this->request->post['whenceHouse'];
        }else{
            $whenceHouse = " ";
        }
        
        if(!empty($this->request->post['whenceExtr'])){
            $whenceExtr = $this->request->post['whenceExtr'];
        }else{
            $whenceExtr = " ";
        }
        
        //создаем массив по даным откуда
        $arrayDataWhence = array($whenceCity,$whenceStreet,$whenceHouse,$whenceExtr);
        
        
        //Данные куда ехать
        
       //Обязательное для заполнения поле
        if(!empty($this->request->post['whereCity'])){
            $whereCity = $this->request->post['whereCity'];
        }
        
        if(!empty($this->request->post['whereStreet'])){
            $whereStreet = $this->request->post['whereStreet']; 
        }else{
            $whereStreet = " ";
        }
        
        if(!empty($this->request->post['whereHouse'])){
           $whereHouse = $this->request->post['whereHouse'];
        }else{
            $whereHouse = " ";
        }
        
        if(!empty($this->request->post['whereExtr'])){
            $whereExtr = $this->request->post['whereExtr'];
        }else{
            $whereExtr = " ";
        }
        
        //создаем массив по даным куда
        $arrayDataWhere = array($whereCity,$whereStreet,$whereHouse,$whereExtr);
        
         //создаем массив данных по маршруту
        $dataArrayTaxi = array($keyAPI,$arrayDataWhence,$arrayDataWhere);
        
        
        //получаем сколько км по маршруту
        $km = $this->setDataTaxi($dataArrayTaxi);
        
        //считаем стоимость проезда
        //$summa = $tariff*$km;
        $summa = 1*$km;
        
        return $summa;
 
        #TODO тут надо расчитать по формуле стоимость и отправить return  на view и дальше с помощью 
        #ajax получить это значение уже и вида и  отправить на оформление заказа или же для 
        #безопасности сохранить значение в перменной, что бы не было возможности отредактировать и 
        #вставить свою сумму
        
    }
    
    //метод для получения км по маршруту
    public function setDataGoogleAPI($dataArrayTaxi){
        //ключ гугл
        $key = $dataArrayTaxi['key'];
        
        //получаем данные откуда
        $whence = urlencode($dataArrayTaxi["arrayDataWhence"]['whenceCity']." ".$dataArrayTaxi["arrayDataWhence"]['whenceStreet']." ".$dataArrayTaxi["arrayDataWhence"]['whenceHouse']." ".$dataArrayTaxi["arrayDataWhence"]['whenceExtr']);
        
        //получаем данные куда
        $where = urlencode($dataArrayTaxi["arrayDataWhere"]['whereCity']." ".$dataArrayTaxi["arrayDataWhere"]['whereStreet']." ".$dataArrayTaxi["arrayDataWhere"]['whereHouse']." ".$dataArrayTaxi["arrayDataWhere"]['whereExtr']);
        
        
        //формируем строку для получения данных
        $maps = "https://maps.googleapis.com/maps/api/directions/json?origin=$whence&destination=$where&units=metric&key=$key";

        //декодируем строку с JSON
        $getJsonMaps = json_decode(file_get_contents($maps));

        //получаем км (только саму цыфру)
        $km = (int)$getJsonMaps->routes[0]->legs[0]->distance->text;

         return $km;
    }
    
    //получаем все данные для  оформления заказа
    public function checkoutTaxi(){
         //Данные кому
 
        //Обязательное для заполнения поле
        if(!empty($this->request->post['to_whomName'])){
            $to_whomName = $this->request->post['to_whomName'];
        }
        
        
        //Обязательное для заполнения поле
        if(!empty($this->request->post['to_whomPhone'])){
            $to_whomPhone = $this->request->post['to_whomPhone']; 
        }
    }
}