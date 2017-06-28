<div class="col-lg-12 col-md-12">
              <h1><?=$choise;?> <span style="color: #d1a36f;"><?=$tarif;?></span></h1>
              <p>Maecenas vitae turpis dapibus neque mollis mattis. Nam pretium <br> libero sit amet feugiat pretium. Morbi ut fringilla urna.</p>
              <div class="col-lg-4 col-md-4">
                <div class="StandartPrice">  
                    <p style="margin-top: 0px;"><img src="catalog/view/theme/TaxiTemplateOc2.3/images/first.png" height="160" width="300" alt=""></p>
                    <h5><?=$budget;?></h5>
                    <p><?=$from?> <?=$budgetPrice;?> <?=$currency?></p>
                </div>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="BusinesPrice">
                    <p><img src="catalog/view/theme/TaxiTemplateOc2.3/images/second.png" alt=""></p>
                    <h5><?=$business;?></h5>
                    <p><?=$from?> <?=$businessPrice;?> <?=$currency?></p>
                </div>    
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="PremiumPrice">  
                    <p><img src="catalog/view/theme/TaxiTemplateOc2.3/images/third.png" alt=""></p>
                    <h5><?=$premium;?></h5>
                    <p><?=$from?> <?=$premiumPrice;?> <?=$currency?></p>
                </div>
              </div>


 </div>
         </section>
        <p style="text-align: center;padding-bottom: 50px;color: #000;"><?=$minimum_fare;?></p>
       <form id="form_taxiAPI" action="" method="post"> 
        <section class="inputs">
         <div class="col-lg-12 col-md-12">
           <h1 class="count"><?=$counting_cost;?> <span style="color: #d1a36f;"><?=$travel;?></span></h1>
           <p>Pellentesque congue volutpat enim in fringilla.</p>
           <h4 style="padding: 20px;"><?=$where_to_go_from?></h4>
           <div class="tarif">
                <input type="text" name="tarif" class="form-control" required>
           </div>
           <p>
             <input type="text" name="whenceCity" placeholder="<?=$city?>" required>
             <input type="text" name="whenceStreet" placeholder="<?=$street?>">
             <input type="text" name="whenceHouse" placeholder="<?=$house?>">
             <input type="text" name="whenceExtr" placeholder="<?=$extr?>">
           </p>
           <h4 style="padding: 20px;"><?=$where_to_go?></h4>
           <p>
             <input type="text" name="whereCity" placeholder="<?=$city?>" required>
             <input type="text" name="whereStreet" placeholder="<?=$street?>">
             <input type="text" name="whereHouse" placeholder="<?=$house?>">
             <input type="text" name="whereExtr" placeholder="<?=$extr?>">
           </p>
           <h4><?=$when;?><h4>
           <p>
           <label for="r1"><?=$now;?></label>
           <input type="radio" name="radio" value="radio1"  style="width:20px; height:20px;" checked="checked" id="r1">
            <label for="r2"><?=$choise_date;?></label>
           <input type="radio" name="radio" value="radio2"  style="width:20px; height:20px;" id="r2">
           <br>
           <center><input type="text" style="display:none;" name="when" id="dateTaxi" ></center>
           </p>
           <h4><?=$to_whom?></h4>
           <p>
             <input type="text" name="to_whomName" placeholder="<?=$to_whomName?>" required>
             <input type="text" name="to_whomPhone" placeholder="<?=$to_whomPhone?>" required>
           </p>
           <h4><?=$total?></h4>
           <div class="total">
                <span></span>
             </div>
           <p><?=$payment_method?></p>
           <p class="payment">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              
              <!--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 master"><img src="catalog/view/theme/TaxiTemplateOc2.3/images/mastercard.png" alt=""></div> !-->
              <!--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 privat"><img src="catalog/view/theme/TaxiTemplateOc2.3/images/privat.png" alt=""></div> !-->
                <?php
                    $i = 0;

                    foreach($payment as $paym){
                        switch($paym["code"]){
                            case "cheque":
                                echo "
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 cheque'>
                                        <img src='/' alt='$checkque'>
                                    </div>
                                ";
                            
                            break;

                             case "cod":
                                echo "
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 cod'>
                                        <img src='/' alt='$checkque'>
                                    </div>
                                ";
                            
                            break;
                            
                            case "liqpay":
                                echo"
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6 liqpay'>   
                                        <img src='catalog/view/theme/TaxiTemplateOc2.3/images/liqpay.png' alt='liqpay'>
                                    </div>
                                ";
                                break;
                        }
                    }

                ?>
             </div>
           <input type="text" name="payment" class="form-control" style="display:none;">
           <p class="lead">
              <button type="submit" class="btn btn-lg btn-info confirm_button"><?=$confirm;?> <img src="catalog/view/theme/TaxiTemplateOc2.3/images/ofotmit.png" alt=""></button>
              
          </p>
          </div>
        </div>
      </section>
    </form> 
