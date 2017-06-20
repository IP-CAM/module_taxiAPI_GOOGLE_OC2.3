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
</div>
<div class="container-taxi">
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
                        <form id="form_taxiAPI" action="" method="post">
                              <div class="col-md-12" style="margin-bottom:20px;">
                                <div class="col-md-4">
                                      <div class="StandartPrice">
                                          <img src="http://www.segodnya.ua/img/forall/users/2366/236660/462316_chernaya_mashina_pered_audi_1680x1050_www.gdefon.ru__01.jpg" alt="<?=$budget?>" width="250" height="250">
                                          <div class="price_img">
                                             <?=$from?> <span><?=$budgetPrice;?></span> <?=$currency?> 
                                          </div>
                                          
                                      </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="BusinesPrice">
                                      <img src="https://look.com.ua/pic/201209/1600x900/look.com.ua-19447.jpg" alt="<?=$business?>" width="250" height="250">
                                        <div class="price_img">
                                            <?=$from?> <span><?=$businessPrice;?></span> <?=$currency?>  
                                        </div>
                                      
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="PremiumPrice">
                                      <img src="https://i.ytimg.com/vi/CES6J6c7zHQ/maxresdefault.jpg" alt="<?=$premium?>" width="250" height="250">
                                      <div class="price_img">
                                           <?=$from?> <span><?=$premiumPrice;?></span> <?=$currency?>   
                                       </div>
                                      
                                  </div>    
                                </div>
                                  <div class="tarif">
                                      <input type="text" name="tarif" class="form-control" required>
                                  </div>
                              </div>
                              <div class="col-md-12" style="margin-bottom:20px;">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="col-md-12">
                                              <p><?=$where_to_go_from?></p>
                                          </div>
                                          <div class="col-md-3">
                                              <div class="form-group">
                                                  <input type="text" name="whenceCity" class="form-control" style="width:90%;" placeholder="<?=$city?>" required>
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
                                                  <input type="text" name="whereCity" class="form-control" style="width:90%;" placeholder="<?=$city?>" required>
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
                              <div class="col-md-12" style="margin-bottom:20px;">
                                  <div class="col-md-12">
                                      <p><?=$to_whom?></p>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <input type="text" name="to_whomName" class="form-control" style="width:70%;" placeholder="<?=$to_whomName?>" required>
                                          </div>    
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <input type="text" name="to_whomPhone" class="form-control" style="width:70%;" placeholder="<?=$to_whomPhone?>" required>
                                          </div>    
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-12" style="margin-bottom:20px;">
                                <center>  
                                <div class="row">
                                  <div class="col-md-12">
                                    <p><?=$total?></p>
                                  </div>
                                    <div class="col-md-12">
                                           <div class="total">
                                              <span></span>
                                              <img src="./catalog/view/img/update.png">
                                           </div>
                                     </div>
                                </div>
                                </center> 
                              </div>

                              <div class="col-md-12" style="margin-bottom:20px;">
                                  <center>
                                    <div class="row payment_method">
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
                                                  <p>$checkque</p>
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
                                     <input type="text" name="payment" class="form-control" style="display:none;">   
                                    </center>
                                </div>
                                <div class="col-md-12">
                                    <span class="confirm"><?=$confirm;?></span>
                                    <center><input type="submit" name="enter" style="margin-top:40px;" class="btn btn-primary price_button" value="<?=$price_button; ?>" /></center>
                                    
                                </div>    
                        </form>      
                    </div>
                    
                </div>
        </div>

              <?php echo $content_bottom; ?>
    </div>
 
    <?php echo $column_right; ?>
</div>

<?php echo $footer; ?>
