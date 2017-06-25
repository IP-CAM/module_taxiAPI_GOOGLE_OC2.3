$(document).ready(function(){
	
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
             
              $.ajax({
                    url : 'index.php?route=extension/module/taxiAPI/getDataPriceConfirm',
                    type : 'POST',
                    dataType:'text',
                    data :{
                        dataTaxiConfirm: $("#form_taxiAPI").serialize(),
                    },
                    success:function(data){
                        
                        console.log(data);
                        //location.href = data;
                        
               
                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(thrownError); //выводим ошибку
                    }
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
            
            //при смене тарифа проверяем стоимость
            getUpdate();
        
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
            //при смене тарифа проверяем стоимость
            getUpdate();
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
            
            //при смене тарифа проверяем стоимость
            getUpdate();
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
            $("input[name='payment']").val("liqpay");
            $(this).css("border","1px solid #337ab7");
            $(this).css("padding","5px 10px 5px 10px");
            $(this).css("width","170px");
            $(".cheque").css("border","none");
            $(".cheque").css("padding","0");
            
        }
    });
    
    //при каждом редактировании поля проверяем стоимость
    $("#form_taxiAPI input").change(function(){
      getUpdate();
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