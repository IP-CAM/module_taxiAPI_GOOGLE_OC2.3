$(document).ready(function(){
	
        //выбираем по дефолту
            $("input[name='payment']").val("cod");
            $(".cod").css("border","1px solid #337ab7");
            $(".cod").css("padding","5px 10px 5px 10px");
            $(".cod").css("width","170px");
            $(".liqpay").css("border","none");
            $(".liqpay").css("padding","0");
	    $(".cheque").css("border","none");
            $(".cheque").css("padding","0");
             
            
	
    
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
            $(".cod").css("border","none");
            $(".cod").css("padding","0");
            
            
  
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
	    $(".cod").css("border","none");
            $(".cod").css("padding","0");
	    
	    
            
        }
    });
    
    $(".cod").click(function(){
        var payment = $(this).attr("class");
        
        if(!!payment){
            $("input[name='payment']").val("cod");
            $(this).css("border","1px solid #337ab7");
            $(this).css("padding","5px 10px 5px 10px");
            $(this).css("width","170px");
            $(".liqpay").css("border","none");
            $(".liqpay").css("padding","0");
	    $(".cheque").css("border","none");
            $(".cheque").css("padding","0");
            
        }
    });
    
    
    //при каждом редактировании поля проверяем стоимость
    $("#form_taxiAPI input").change(function(){
      getUpdate();
    });
    
    $("input[name='radio']" ).click(function() {
      var select_date = $( "input[name='radio']:checked" ).val();
      
      if(select_date == "radio2"){
	$("input[name='when']").css("display","block");
      }else if(select_date == "radio1"){
	$("input[name='when']").css("display","none");
	$("input[name='when']").val(" ");
      }
      
  
 
    });
    
    //выбираем дату и время маршрута
    $.datetimepicker.setLocale('ru');
		$( "#dateTaxi" ).datetimepicker({
 			format:'H:i d-m-Y',
			step:5,
			minDate:'-1970/01/01', // yesterday is minimum date
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