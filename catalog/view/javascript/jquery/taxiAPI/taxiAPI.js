$(document).ready(function(){
	//#TODO надо сделать проверку выбран ли тариф по клику на картинку и ее как то выделить, что она 
	//выбрана+надо сделать когда сериалайз отправили по ajax и все гуд присылаем ответ и меняем кнопку оформить и меняем ей класс
        //#TODO  надо повесить на главный див (всей формы) на инпут если был клик кнопка оформить меняется на класс
        // стоимость и надо будет нажимать еще раз.  Надо будет решить почему валидатор отвалился и не работает
        //После нажатия стоимости должен появлятся блок способ оплаты для выбора оплаты и дальше выбор и оформить
        //+ надо сделать выделение вокруг выбраной картинки (тарифа) в jquery прописать стили для своего блока
    
        //выбираем по дефолту
            $("input[name='payment']").val("cheque");
            $(".cheque").css("border","1px solid #337ab7");
            $(".cheque").css("padding","5px 10px 5px 10px");
            $(".cheque").css("width","170px");
            $(".liqpay").css("border","none");
            $(".liqpay").css("padding","0");
            
            
	//отправляем на сервер для получения сумму
    $("#form_taxiAPI").validate({
        //если все гуд срабатывает по клику
         submitHandler: function (){
                //получаем данные с формы
               var dataTaxi = $("#form_taxiAPI").serialize();
               
               //получаем текст и назначаем новое название кнопки
               var confirm = $(".confirm").text();
               

               $.ajax({

                  url : 'index.php?route=extension/module/taxiAPI/getDataPriceButton',
                   type : 'POST',
                   dataType:'text',
                   data :{
                       dataTaxi:dataTaxi,

                   },
                   success:function(data){
                       if(!!data){
                    
                           //получаю целое число суммы
                         var intTotal = Number(data.replace(/\D+/g,""));
                         
                         $(".total img").css("display","none");
                         
                         //если прилетает не ошибка а цена то выводим блок для оплаты
                         if(0<intTotal){
                             $(".payment_method").css("display","block");
                             $(".price_button").val(confirm);
                             $(".price_button").addClass("confirm_button");
                             $(".price_button").removeClass("price_button");
                             $(".total img").css("display","block");
                             
                             
                             $(".confirm_button").click(function(){
                                 $.ajax({
                                     url : 'index.php?route=extension/module/taxiAPI/getDataPriceConfirm',
                                     type : 'POST',
                                     dataType:'text',
                                     data :{
                                         dataTaxiConfirm: $("#form_taxiAPI").serialize(),

                                     },
                                     success:function(data){
                                            
                                            console.log(data);
                                     },
                                     error:function (xhr, ajaxOptions, thrownError){
                                         console.log(thrownError); //выводим ошибку
                                     }
                                 }); 
                             });
                                
                         }
                         
                         $(".total span").text(data);
               
                       }

                   },
                   error:function (xhr, ajaxOptions, thrownError){
                       console.log(thrownError); //выводим ошибку
                   }
               });
               
               $(".total img").click(function(){
                   getUpdate();
               });
         
         
        },
    	rules:{

            whenceCity:{
                required: true,
                minlength: 2,
             },

            whereCity:{
                required: true,
                minlength: 2,
             },
             tarif:{
                required: true, 
             },
 
             to_whomName:{
                required: true,
                minlength: 4,
             },

            to_whomPhone:{
                required: true,
                minlength: 10,
                number: true,
             },
              
       },

       messages:{

            whenceCity:{
                required: "Это поле обязательно для заполнения",
                minlength: "Город должен быть минимум 2 символа",
             },

            whereCity:{
                required: "Это поле обязательно для заполнения",
                minlength: "Город должен быть минимум 2 символа",
             },
             tarif:{
                required: "Выберите тариф", 
             },

              
             to_whomName:{
                required: "Это поле обязательно для заполнения",
                minlength: "Имя должно быть минимум 4 символа",
             },

            to_whomPhone:{
                required: "Это поле обязательно для заполнения",
                minlength: "Телефон должен быть минимум 10 символа",
                number: "Только цифры",
                
             },
            

       }
    });
 
    
    //вешаем  3 клика на 3 картинки по которой кликнули ту цену и приняли
    $(".StandartPrice").click(function(){
        var tarif = $(this).attr("class");
        
        if(!!tarif){
            $("input[name='tarif']").val(tarif);
            $(this).css("border","1px solid #337ab7");
            $(this).css("padding","15px 0px 0px 50px");
            $(".BusinesPrice").css("border","none");
            $(".BusinesPrice").css("padding","0");
            $(".BusinesPrice").css("right","0");
            $(".PremiumPrice").css("padding","0");
            $(".PremiumPrice").css("border","none");
        
         }
    });
    
    $(".BusinesPrice").click(function(){
        var tarif = $(this).attr("class");
        
        if(!!tarif){
            $("input[name='tarif']").val(tarif);
            $(this).css("border","1px solid #337ab7");
            $(this).css("padding","15px 0px 0px 50px");
            $(this).css("position","relative");
            $(this).css("right","40px");
            $(".StandartPrice").css("border","none");
            $(".StandartPrice").css("padding","0");
            $(".PremiumPrice").css("padding","0");
            $(".PremiumPrice").css("border","none");
            $(".PremiumPrice").css("right","0");
        }
    });
    
    $(".PremiumPrice").click(function(){
        var tarif = $(this).attr("class");
        
        if(!!tarif){
            $("input[name='tarif']").val(tarif);
            $(this).css("border","1px solid #337ab7");
            $(this).css("padding","15px 0px 0px 50px");
            $(this).css("position","relative");
            $(this).css("right","70px");
            $(".BusinesPrice").css("border","none");
            $(".BusinesPrice").css("padding","0");
            $(".StandartPrice").css("border","none");
            $(".StandartPrice").css("padding","0");
        }
    });
    
    
    $(".cheque").click(function(){
        var payment = $(this).attr("class");
        
        if(!!payment){
            $("input[name='payment']").val("cheque");
            $(this).css("border","1px solid #337ab7");
            $(this).css("padding","5px 10px 5px 10px");
            $(this).css("width","170px");
            $(".liqpay").css("border","none");
            $(".liqpay").css("padding","0");
  
        }
    });
    
    $(".liqpay").click(function(){
        var payment = $(this).attr("class");
        
        if(!!payment){
            $("input[name='payment']").val(payment);
            $(this).css("border","1px solid #337ab7");
            $(this).css("padding","5px 10px 5px 10px");
            $(this).css("width","170px");
            $(".cheque").css("border","none");
            $(".cheque").css("padding","0");
        }
    });
    
    
    

});

//автоматическое обновление данных
function getUpdate(){
    //получаем данные с формы
     var dataTaxi = $("#form_taxiAPI").serialize();
     $.ajax({

                  url : 'index.php?route=extension/module/taxiAPI/getDataPriceButton',
                   type : 'POST',
                   dataType:'text',
                   data :{
                       dataTaxi:dataTaxi,

                   },
                   success:function(data){
                       if(!!data){
                         
                        $(".total span").text(data);
               
                       }

                   },
                   error:function (xhr, ajaxOptions, thrownError){
                       console.log(thrownError); //выводим ошибку
                   }
               }); 
}