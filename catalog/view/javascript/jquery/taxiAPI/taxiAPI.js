$(document).ready(function(){
	//#TODO надо сделать проверку выбран ли тариф по клику на картинку и ее как то выделить, что она 
	//выбрана+надо сделать когда сериалайз отправили по ajax и все гуд присылаем ответ и меняем кнопку оформить и меняем ей класс
 
	//отправляем на сервер для получения км
    $("#form_taxiAPI").validate({
    	rules:{

            whenceCity:{
                required: true,
                minlength: 2,
             },

            whereCity:{
                required: true,
                minlength: 2,
             },
             /* в другую такую же функцию
             to_whomName:{
                required: true,
                minlength: 4,
             },

            to_whomPhone:{
                required: true,
                minlength: 10,
                number: true,
             },
             */
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

             /*
             to_whomName:{
                required: "Это поле обязательно для заполнения",
                minlength: "Имя должно быть минимум 4 символа",
             },

            to_whomPhone:{
                required: "Это поле обязательно для заполнения",
                minlength: "Телефон должен быть минимум 10 символа",
                number: "Только цифры",
                
             },
             */

       }
    });

    $(".price_button").click(function(e){
    	e.preventDefault();

    	//получаем данные с формы
    	var dataTaxi = $("#form_taxiAPI").serialize();

    	$.ajax({

           url : 'index.php?route=extension/module/taxiAPI/getDataTaxi',
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
    });

});