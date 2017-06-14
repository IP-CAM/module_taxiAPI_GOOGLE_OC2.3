<?php
ini_set('display_errors',1);
error_reporting(E_ALL ^E_NOTICE);
?>
<?php echo $header; ?>
 <?php echo $column_left;?>
<link href="view/stylesheet/taxiAPI.css" rel="stylesheet">

<script type="text/javascript" src="view/javascript/jquery/tabs.js"></script>
<div id="content" style="margin-left:50px;">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?=$text_edit;?></h3>
      </div>
      <div class="panel-body">
         <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <center><h2><?=$text_api_google?></h2></center>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 10px;">
                              <div class="col-md-1">
                                <span class="label label-success" style="font-size: 15px; position: relative; top: 10px;"><?=$text_key_api?></span>
                              </div>
                              <div class="col-md-11">
                                <input  type="text" name="apiKey" class="form-control" style="width:30%;" value="<?=$apiKey?>">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 20px;">
                                 <center><h2><?=$text_price_taxi?></h2></center>
                            </div>
                            <div class="col-md-12">
                              <div class="col-md-1">
                                <span class="label label-primary" style="font-size: 15px; position: relative; top: 10px;"><?=$text_price_standart?></span>
                               </div>
                              <div class="col-md-11">
                                <input  type="text" name="standartPrice" class="form-control" style="width:30%;" value="<?=$standartPrice?>">
                              </div>
                            </div>


                            <div class="col-md-12" style="margin-top:20px;">
                              <div class="col-md-1">
                                <span class="label label-primary" style="font-size: 15px; position: relative; top: 10px;"><?=$text_price_business?></span>
                              </div>
                              <div class="col-md-11">
                                <input  type="text" name="businessPrice" class="form-control" style="width:30%;" value="<?=$businessPrice?>">
                              </div>
                            </div>


                            <div class="col-md-12" style="margin-top:20px;">
                              <div class="col-md-1">
                                <span class="label label-primary" style="font-size: 15px; position: relative; top: 10px;"><?=$text_price_miniven?></span>
                              </div>
                              <div class="col-md-11">
                                <input  type="text" name="minivenPrice" class="form-control" style="width:30%;" value="<?=$minivenPrice?>">
                              </div>  
                            </div>


                        </div>
                    </div>

                </div>
            </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
