<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>

 <div id="content"><?php echo $content_top; ?>
        <div class="container">
            <div class="col-md-12">
                <p><?=$heading_title?></p>
            </div>
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-4">
                            <img src="/" alt="<?=$budget?>">
                         <div class="StandartPrice"><?=$from?> <span><?=$budgetPrice;?></span> <?=$UAH?></div>
      </div>
      <div class="col-md-4">
      <img src="/" alt="<?=$business?>">
                         <div class="BusinesPrice"><?=$from?> <span><?=$businessPrice;?></span> <?=$UAH?></div>
      </div>
      <div class="col-md-4">
      <img src="/" alt="<?=$premium?>">
                         <div class="PremiumPrice"><?=$from?> <span><?=$premiumPrice;?></span> <?=$UAH?></div>    
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
                                 <div class="col-md-12">
                                     <div class="col-md-12">
                                             <p><?=$where_to_go_from?></p>
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                           <input type="text" name="whenceCity" class="form-control" style="width:90%;" placeholder="<?=$city?>">
                                       </div>         
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                           <input type="text" name="whenceStreet" class="form-control" style="width:90%;" placeholder="<?=$street?>">
                                       </div>     
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                           <input type="text" name="whenceHouse" class="form-control" style="width:90%;" placeholder="<?=$house?>">
                                       </div>
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                           <input type="text" name="whenceExtr" class="form-control" style="width:90%;" placeholder="<?=$extr?>">
                                       </div>    
                                     </div> 
                                </div>
                                <div class="col-md-12 focus_load">
                                    <div class="col-md-12">
                                            <p><?=$where_to_go?></p>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <input type="text" name="whereCity" class="form-control" style="width:90%;" placeholder="<?=$city?>">
                                       </div>         
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                          <input type="text" name="whereStreet" class="form-control" style="width:90%;" placeholder="<?=$street?>">
                                       </div>     
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                          <input type="text" name="whereHouse" class="form-control" style="width:90%;" placeholder="<?=$house?>">
                                       </div>
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                          <input type="text" name="whereExtr" class="form-control" style="width:90%;" placeholder="<?=$extr?>">
                                       </div>    
                                     </div> 
                                </div>
       
      </div>
    </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <p><?=$to_whom?></p>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="to_whomName" class="form-control" style="width:70%;" placeholder="<?=$to_whomName?>">
                            </div>    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="to_whomPhone" class="form-control" style="width:70%;" placeholder="<?=$to_whomPhone?>">
                            </div>    
                        </div>
                    </div>
                </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <p><?=$total?></p>
        </div>
        <div class="col-md-12">
          <div class="row">
            <p>#TODO общая сумма</p>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-12">
      <div clas="row">
        <div class="col-md-12">
          <p><?=$payment_method?></p>
        </div> 

        <div class="col-md-12">
   
        <?php
          $i = 0;

          foreach($payment as $paym){
 
            switch($paym["code"]){

             case "cheque":
              echo "
                <div class='col-md-3'>
                  <div class='cheque'>
                    <p><?=$checkque?></p>
                  </div>
                </div>
              ";
              break;

              case "liqpay":
                echo"
                  <div class='col-md-3'>
                    <div class='liqpay'>
                      <p>liqpay</p>
                    </div>
                 </div>
                ";
              break;
             }
             
           }


        ?>
        </div>
      </div>
    </div>
    <div class="col-md-12">
                                    <center><button type="submit" form="form-category"  style="margin-top:40px;" data-toggle="tooltip" title="<?=$pay; ?>" class="btn btn-primary"><?=$pay; ?></button></center>
                                </div>
  </div>
    </div>
      
      <?php echo $content_bottom; ?>
    </div>
 
    <?php echo $column_right; ?></div>
</div>
<script>
    #TODO сделать проверку на город, что бы был обязателен для заполнения
  //focus_load  если фокус пропадает  то тогда начинается подсчет суммы
  //надо еще делать проверку если поле не заполнено то просто поставить пробел или не учитывать параметр в запросе
  //если гугл не нашел такой маршрут или произошла какая то ошибка на стороне гугл надо выводить ошибку от 
  //гугла, получить с помощью API гугла
  
  $(document).ready(function(){
    //откуда  
    var whenceCity = $("input[name='whenceCity']").val();
    var whenceStreet = $("input[name='whenceStreet']").val();
    var whenceHouse = $("input[name='whenceHouse']").val();
    var whenceExtr = $("input[name='whenceExtr']").val();
    
    //куда
    var whereCity = $("input[name='whereCity']").val();
    var whereStreet = $("input[name='whereStreet']").val();
    var whereHouse = $("input[name='whereHouse']").val();
    var whereExtr = $("input[name='whereExtr']").val();
    
    
    //кому
    var to_whomName = $("input[name='to_whomName']").val();
    var to_whomPhone = $("input[name='to_whomPhone']").val();
      
    });
</script>
<?php echo $footer; ?>
