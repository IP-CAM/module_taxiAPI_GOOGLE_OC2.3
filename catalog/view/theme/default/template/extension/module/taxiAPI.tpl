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
                            <img src="/" alt="<?=budget?>">
                         <div class="StandartPrice"><?=$from?><span>47</span><?=$UAH?></div>
			</div>
			<div class="col-md-4col-md-4">
			<img src="/" alt="<?=business?>">
                         <div class="BusinesPrice"><?=$from?><span>61</span><?=$UAH?></div>
			</div>
			<div class="col-md-4">
			<img src="/" alt="<?=premium?>">
                         <div class="PremiumPrice"><?=$from?><span>75</span><?=$UAH?></div>		
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
                            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-taxiAPI" class="form-horizontal">
                                <div class="col-md-12">
                                     <div class="col-md-12">
                                             <p><?=$where_to_go_from?></p>
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                           <input type="text" name="whenceCity" class="form-control" placeholder="<?=$city?>">
                                       </div>					
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                           <input type="text" name="whenceStreet" class="form-control" placeholder="<?=$street?>">
                                       </div>     
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                           <input type="text" name="whenceHouse" class="form-control" placeholder="<?=$house?>">
                                       </div>
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                           <input type="text" name="whenceExtr" class="form-control" placeholder="<?=$extr?>">
                                       </div>    
                                     </div> 
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                            <p><?=$where_to_go_from?></p>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                          <input type="text" name="whereCity" class="form-control" placeholder="<?=$city?>">
                                       </div>					
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                          <input type="text" name="whereStreet" class="form-control" placeholder="<?=$street?>">
                                       </div>     
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                          <input type="text" name="whereHouse" class="form-control" placeholder="<?=$house?>">
                                       </div>
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                          <input type="text" name="whereExtr" class="form-control" placeholder="<?=$extr?>">
                                       </div>    
                                     </div> 
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" form="form-category" data-toggle="tooltip" title="<?=$pay; ?>" class="btn btn-primary"></button>
                                </div>

				
                            </form>

			</div>
		</div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <p><?=$to_whom?></p>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="to_whomName" class="form-control" placeholder="<?=$to_whomName?>">
                            </div>    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="to_whomPhone" class="form-control" placeholder="<?=$to_whomPhone?>">
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
                            #TODO  способы оплаты сколько включили сколько и выводим
				<div class="col-md-12">
					<div class="col-md-3">
                                            <div class="liqpay">
                                                <p>LIQPAY</p>
                                            </div>
                                        </div>
					<div class="col-md-3">
                                            <div class="visa">
                                                <p>VISA</p>
                                            </div>    
                                        </div>
					<div class="col-md-3">
                                            <div class="mastercard">
                                                <p>MASTERCARD</p>
                                            </div>
                                        </div>
					<div class="col-md-3">
                                            <div class="privat24">
                                                <p>ПРИВАТ24</p>
                                            </div>
                                        </div>
				</div>
			</div>
		</div>
	</div>
    </div>
      
      <?php echo $content_bottom; ?>
    </div>
 
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
