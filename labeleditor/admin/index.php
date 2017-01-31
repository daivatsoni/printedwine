<?php
    
	/*ini_set('max_execution_time', 300);
	//300 seconds = 5 minutes*/
	require("library/config.php");
  require("lock.php");
  // for pagination purpose	
  /*$results = mysql_query("SELECT COUNT(*) FROM adminuploads");
  $get_total_rows = mysql_fetch_array($results); //total records

  //break total records into pages
  $pages = ceil($get_total_rows[0]/$item_per_page);*/	
?>
<!DOCTYPE html>
<html class=''>
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Label</title>
      <meta name="robots" content="noindex">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
      <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <!--<link href="css/colorpicker.css" type="text/css" rel="stylesheet">-->
      <link href="css/spectrum.css" type="text/css" rel="stylesheet">
      <link href="css/bootstrap-slider.css" type="text/css" rel="stylesheet">
      <link rel="stylesheet" href="css/style.css">
      <!--<link href="css/pagination.css" type="text/css"/>-->
      <link href='http://fonts.googleapis.com/css?family=Alfa Slab One' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Droid Sans' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Cabin' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=PT Sans' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Cabin Sketch' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=PT Sans Narrow' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Allura' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Alex Brush' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Calligraffitti' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Crimson Text' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Bevan' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Dancing Script' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Gruppo' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Archivo Narrow' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Amatic SC' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Droid Serif' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=PT Serif' rel='stylesheet' type='text/css'>
      <link href='css/fonts/scriptina/stylesheet.css' rel='stylesheet' type='text/css'>
	<link href='css/fonts/isabella-script/stylesheet.css' rel='stylesheet' type='text/css'>
   </head>
   <body>

<!--
      <div class="se-pre-con"></div>
 -->
      <ul class='custom-menu'>
      	<li data-action="selectall">Select All</li>
        <li data-action="cut">Cut</li>
        <li data-action="copy">Copy</li>
        <li data-action="paste">Paste</li>
      </ul>
      <div id="loadingpage" class="modal" data-backdrop="static" data-keyboard="false" style="background:#2bbfbf; opacity:1; display:block;"><i class="fa fa-cog fa-spin" style="position: absolute; top: 50%; left: 50%; margin-top: -75px; margin-left: -75px; font-size: 150px; color:#fff;"></i></div>
      <div class="container" id="page-container">
                        <nav class="navbar navbar-inverse navbar-fixed-top">
                          <div class="container-fluid">
                              <!-- Brand and toggle get grouped for better mobile display -->
                              <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a href="">
                              <!--  <img src=""> -->
                                </a>
                              </div>
                              <!-- Collect the nav links, forms, and other content for toggling -->
                              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown">
                                    <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle" style="text-decoration:none;">File <b class="caret"></b></a>
                                      <ul class="dropdown-menu">
                                          <li>
											<form id="uploadtemplate" action="#">
												  <label for="templateselect" style="cursor: pointer; font-weight:normal; margin-bottom: 0px;">Open</label>
												  <input id="templateselect" type="file" name="templateselect[]" />
											</form>
                                          </li>
                                          <li><a id="newtemplate" href="index.php">New</a></li>
                                          <li><a id="savetemplate" href="#">Save</a></li>
                                          <li><a id="saveastemplate" href="#">Save As</a></li>
                                      </ul>
                                    </li>
                                </ul>
                                <span class="navbar-right">
                                   <button class="btn btn-info" type="button" style="background-color:#2bbfbf"><a href="logout.php" id="signout" style="color:#FFFFFF">Logout</a></button>
                                   <button class="btn btn-info" title="Undo" type="button" id="undo" style="background-color:#2bbfbf;"><i class="fa fa-undo"></i></button>
                                   <button class="btn btn-info" title="Redo" type="button" id="redo" style="background-color:#2bbfbf;"><i class="fa fa-repeat"></i></button>
                                    <!-- <button class="btn btn-info" type="button" id="saveTemplate"><i class="fa fa-cloud-download"></i> Save</button> -->
                                    <!-- <button class="btn btn-info" type="button" id="publishTemplate"><i class="fa fa-check"></i> Publish</button> -->
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-info dropdown-toggle" style="background-color:#2bbfbf;"><i class="fa fa-download"></i>&nbsp; Download<span class="caret" style="margin-left:10px;"></span></button>
										<ul class="dropdown-menu">
											<!--<li><a id="downloadAsPDF" href="javascript:void(0);">Save As PDF (For Print)</a></li> -->
											<li><a id="downloadAsJPEG" href="javascript:void(0);">Save As JPEG (For Web)</a></li> 
											<li class="divider"></li>
											<li class="dropdown-submenu">
											<a href="#">More Options<span class="caret" style="margin-left:10px;"></a>
												<ul class="dropdown-menu">
													<li><a href="#" class="noclose" data-value="option1" tabIndex="-1"><input type="checkbox" id="savecrop"/>&nbsp;Save with Crop Marks</a></li>
												</ul>
										</li>  
										</ul> 
									</div>
                                </span>
                              </div><!-- /.navbar-collapse -->
                          </div><!-- /.container-fluid -->
                        </nav>
                
         <!-- /row -->
         <div class="row">
            <div id="leftsection" style="padding-right: 0px; padding-left: 0px; position:fixed;z-index:1000;">
               <div class="tabs-left">
                  <ul class="nav nav-tabs">
                     <li class="active"><a href="#a" data-toggle="tab"><i class="fa fa-th-large"></i></br>Label</a></li>
                     <!--<li><a href="#b" data-toggle="tab" onClick="javascript:addText();"><i class="fa fa-font"></i></br>Text</a></li>-->
                     <li><a href="#b" data-toggle="tab"><i class="fa fa-font"></i></br>Text</a></li>
                     <li><a href="#c" data-toggle="tab"><i class="fa fa-picture-o"></i></br>Elements</a></li>
                     <li><a href="#e" data-toggle="tab"><i class="fa fa-circle"></i></br>Shapes</a></li>
                     <li><a href="#d" data-toggle="tab"><i class="fa fa-th"></i></br>Background</a></li>
                     <li><a href="javascript:void(0);" id="upload_image"><i class="fa fa-cloud-upload"></i></br>Add image</a></li>
									
                  </ul>
                  

                  <div class="tab-content" style="margin-left:80px; position:absolute;">
                     <div class="tab-pane active" id="a">
                        <div class="col-lg-12">
                                          <div class="dropdown" style="float:left;">
                                                <button class="btn btn-default dropdown-toggle btn-menu" type="button" id="templateMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="width:35px;">
                                                      <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="templateMenu">
                                                      <li><a href="#" id="addTemplateCategory">New Category</a></li>
                                                      <li><a href="#" onClick='javascript:location.href="index.php?newtemplate";'>New Label</a></li>
                                                      <li><a href="#" id="deletetempcat">Delete Category</a></li>
                                                      <li><a href="#" id="deleteTemp">Delete Label</a></li>
                                                </ul>
                                          </div>
                                          <select class="form-control" name="tempcat-select" id="tempcat-select" >
                                                  <option value="">Select Category</option>
                                          </select>
<!--
                           <select name="form-control" id="template-select">
                              <option value="">Select Template</option>
                           </select>
 -->
                        </div>
                        <div class="" id="template_container" style="text-align:center;margin-top:40px;">
                        </div>
                     </div>
                     <div class="tab-pane" id="b">
                        <div class="col-lg-12">
                                          <div class="dropdown" style="float:left;">
                                                <button class="btn btn-default dropdown-toggle btn-menu" type="button" id="textMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="width:35px;">
                                                      <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="textMenu">
                                                      <li><a href="#" id="addTextCategory">New Category</a></li>
                                                      <li><a href="#" id="saveText">Save from Selection</a></li>
                                                      <li><a href="#" id="deletetextcat">Delete Category</a></li>
                                                      <li><a href="#" id="deleteText">Delete Text</a></li>
                                                </ul>
                                          </div>
                                          <select class="form-control" name="textcat-select" id="textcat-select" >
                                                  <option value="">Select Category</option>
                                          </select>
                        </div>
                        <div id="addtextoptions" class="col-lg-12" style="text-align:center;">
							<div id="addheading" style="font-size:36px; font-weight:900;"><a href="#" onClick="javascript:addheadingText();">Add heading</a></div>
							<div id="addsubheading" style="font-size:24px; font-weight:bold;"><a href="#" onClick="javascript:addsubheadingText();">Add subheading</a></div>
							<div id="addsometext" style="font-size:18px; font-weight:bold; margin:5px 0 10px 0;"><a href="#" onClick="javascript:addText();">Add some regular text</a></div>
                        </div>
                        <div class="" id="text_container" style="text-align:center;">
                        </div>
                     </div>
                     <div class="tab-pane" id="c">
                        <div class="col-lg-12">
                                          <div class="dropdown" style="float:left;">
                                                <button class="btn btn-default dropdown-toggle btn-menu" type="button" id="elementMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="width:35px;">
                                                      <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="elementMenu">
                                                      <li><a href="#" id="addCategory">New Category</a></li>
                                                      <li><a href="#" id="addElement">New Element</a></li>
                                                      <li><a href="#" id="saveElement">Save from Selection</a></li>
                                                      <li><a href="#" id="deleteCategory">Delete Category</a></li>
                                                      <li><a href="#" id="deleteEle">Delete Element</a></li>
                                                </ul>
                                          </div>
                                          <select class="form-control" name="cat-select" id="cat-select" >
                              <option value="">Select Category</option>
                                             </select>
                        </div>
                        <div class="col-lg-12 col-xs-12" id="catimage_container" style="text-align:center;">
                        </div>
                     </div>
                     <div class="tab-pane" id="d">
                        <div class="col-lg-12">
                                          <div class="dropdown" style="float:left;">
                                                <button class="btn btn-default dropdown-toggle btn-menu" type="button" id="backgroundMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                      <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="backgroundMenu">
                                                      <li><a href="#" id="addBGCategory">New Category</a></li>
                                                      <li><a href="#" id="addBackground">New Background</a></li>
                                                      <li><a href="#" id="deleteBGCategory">Delete Category</a></li>
                                                      <li><a href="#" id="deleteBackground">Delete Background</a></li>
                                                </ul>
                                          </div>
                                          <select class="form-control" name="bgcat-select" id="bgcat-select" >
                                                              <option value="">Select Category</option>
                                          </select>
                           <button class="btn btn-default" type="button" id="bgImageRemove">Remove Background</button>
                           <button class="btn btn-default" type="button" id="bgcolorselect">Select Color</button>
                        </div>
                        <div class="col-lg-12 col-xs-12" style="text-align:center;">
						  <p>
							<label>Background Scale</label>
							<input type="range" min="25" max="100" value="100" id="img-width">
						  </p>
                        </div>
                        <div class="col-lg-12 col-xs-12" id="background_container" style="text-align:center;">
                        </div>
                     </div>
                     <div class="tab-pane" id="e">
				<div>
					<div id="shapeoption">
						<div class="row">
      						<div class="col-md-12" style="float:center;">
      							<select id='shapeselectdropdown' name="" onChange='javascript:addShape(this.value);' class="form-control">
      								<option value="">Select Shape</option>
      								<option value="rectangle">Rectangle</option>
      								<option value="triangle">Triangle</option>
      								<option value="square">Square</option>
      								<option value="circle">Circle</option>
      							</select>
      						</div>
						</div>
						<div class="row">
							<div class="col-md-12">
                                                Select Line Stroke Color
								<button id="strokeline" class="btn btn-small"><i class="fa fa-paint-brush"></i></button>
							</div>
						</div>
                                    <div class="row">
                                          <div class="col-md-12" style='display:inline-flex;'>
                                                Select Line Stroke Width  :
                                                <select name="" class="form-control" style="width:100px;"id="storkewidth">
                                                      <option value="0" selected>0</option>
                                                      <option value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                      <option value="5">5</option>
                                                      <option value="6">6</option>
                                                      <option value="7">7</option>
                                                      <option value="8">8</option>
                                                      <option value="9">9</option>
                                                      <option value="10">10</option>
                                                </select>
                                          </div>
                                    </div>
						<div class="row">
							<div class="col-md-12">
                                                Make it Transparent
								<input type="checkbox" id="nofill" />
							</div>
						</div>
					</div>
				</div>
			   </div>
			</div>
               
                  <!-- /tab-content -->
                  <ul class="list-unstyled hidden-xs" id="sidebar-footer">
                     <li>
                        <i class="fa fa-plus-circle fa-lg" id="btnZoomIn" style="cursor:pointer;"></i></br><span id="zoomperc">100%</span></br><i class="fa fa-minus-circle fa-lg" id="btnZoomOut" style="cursor:pointer;"></i>
                     </li>
                  </ul>
               </div>
            
            
               <!-- /tabbable -->
            </div>
            <div class="col-xs-12 col-md-8"  style="margin-top:60px; margin-left:420px;" id='rightsection'>
               <!-- tools-top -->
               <div class="tools-top" style="z-index:1000;position:fixed;visibility:hidden;margin-top:5px;">
                  <div class="toolbar-top">
                     <span class="textelebtns">
                     <div class="btn-group">
                        <a title="Select Font" id="font-selected" class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                           <span><span style="font-family: 'Averia Sans Libre'; font-size: 14px;">Averia Sans Libre</span>&nbsp;&nbsp;<span class="caret"></span></span>
                        </a>
                        <ul class="dropdown-menu fonts-dropdown" id="fonts-dropdown">
                           <li><a href="javascript:void(0);"><font face="Alfa Slab One" size="4">Alfa Slab One</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Droid Sans" size="4">Droid Sans</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Cabin" size="4">Cabin</font></a></li>
                           <li><a href="javascript:void(0);"><font face="PT Sans" size="4">PT Sans</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Cabin Sketch" size="4">Cabin Sketch</font></a></li>
                           <li><a href="javascript:void(0);"><font face="PT Sans Narrow" size="4">PT Sans Narrow</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Bitter" size="4">Bitter</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Allura" size="4">Allura</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Alex Brush" size="4">Alex Brush</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Calligraffitti" size="4">Calligraffitti</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Crimson Text" size="4">Crimson Text</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Open Sans" size="4">Open Sans</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Bevan" size="4">Bevan</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Dancing Script" size="4">Dancing Script</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Comfortaa" size="4">Comfortaa</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Gruppo" size="4">Gruppo</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Archivo Narrow" size="4">Archivo Narrow</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Amatic SC" size="4">Amatic SC</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Fjalla One" size="4">Fjalla One</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Cinzel" size="4">Cinzel</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Oswald" size="4">Oswald</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Montserrat" size="4">Montserrat</font></a></li>
                           <li><a href="javascript:void(0);"><font face="Droid Serif" size="4">Droid Serif</font></a></li>
                           <li><a href="javascript:void(0);"><font face="PT Serif" size="4">PT Serif</font></a></li>
                        </ul>
                     </div>
                              <div class="input-group" style="display:inline-block;">
                                    <input type="text" class="fontinput form-control" id="fontsize" name="fontsize" min="0" max="100" value="6" style="width:50px; display:inline-block;">
                                    <div class="input-group-btn" style="display:inline-block;">
                        <span id="fzbutton" title="Font Size" class="tools-top btn btn-default fzbutton-container" style="padding:2px 5px;"> <i id="fontsizeInc" class="fa fa fa-caret-up fzbutton" style="display:block;"></i> <i id="fontsizeDec" class="fa fa-caret-down fzbutton" style="display:block;"></i></span>
                                    </div>
                              </div>
                  </span>
                     <div class="btn-group" role="group" aria-label="...">
                     <a href="javascript:void(0);" id="objectalignleft" title="Align left" class="tools-top btn btn-default"><i class="fa fa-align-left"></i></a>
                     <a href="javascript:void(0);" id="objectaligncenter" title="Align center" class="tools-top btn btn-default"><i class="fa fa-align-center"></i></a>
                     <a href="javascript:void(0);" id="objectalignright" title="Align right" class="tools-top btn btn-default"><i class="fa fa-align-right"></i></a>
                     <a href="javascript:void(0);" id="objectalignjustify" title="Align justify" class="tools-top btn btn-default"><i class="fa fa-align-justify"></i></a>                                          
                     </div>
                     <a href="javascript:void(0);" id="colorSelector" title="Color Picker" class="tools-top btn btn-default" style="padding: 16px 19px;"><!-- <i id='colorbrush' class="fa fa-paint-brush"></i> --></a>
                         <span id='dynamiccolorpickers'></span>
                                <a href="javascript:void(0);" id="clone" title="Clone Object" class="tools-top btn btn-default"><i class="fa fa-clone"></i></a>
                                <span id="objectMoveOption">
                                	<div class="btn-group" role="group" aria-label="...">
                                      <a href="javascript:void(0);" id="sendbackward" title="Send Backward" class="tools-top btn btn-default"><img src="img/send-backward.svg" height="16" width="16"/></a>
                                      <a href="javascript:void(0);" id="bringforward" title="Bring Forward" class="tools-top btn btn-default"><img src="img/bring-forward.svg" height="16" width="16"/></a>
                                    </div>
                                </span>
                      <a href="javascript:void(0);" id="deleteitem" title="Delete Selected Item" class="tools-top btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                    <div id="showmoreoptions" class="btn-group" style="display:inline-block;">
                                      <button href="javascript:void(0);" id="showmore" data-toggle="dropdown" title="Show More Tools" class="tools-top btn btn-default dropdown-toggle"><span class="caret"></span></button>
                                          <ul class="dropdown-menu dropdown-menu-right">
                                                 <li><a href="javascript:void(0);" id="fontbold" title="Bold" class="tools-top more textelebtns"  style="font-weight:bolder;">Bold</a></li>
                                                 <li><a href="javascript:void(0);" id="fontitalic" title="Italic" class="tools-top more textelebtns" style="font-style: italic;">Italic</a></li>
                                                 <li><a href="javascript:void(0);" id="fontunderline" title="Underline" class="tools-top more textelebtns" style="text-decoration: underline;">Underline</a></li>
                                                 <li><a href="javascript:void(0);" id="lineheight" title="Line Height" class="tools-top more textelebtns noclose" ><img src="img/lineheight.svg" width="14">&nbsp; Line height</a></li>
                                                 <input id="changelineheight" data-slider-id='lineheightSlider' type="text" data-slider-min="0.5" data-slider-max="5" data-slider-step="0.1" data-slider-value="1.3"/>
<!--
                                                 <li><a href="javascript:void(0);" id="horizcenterindent" title="Horizontal center Indent" class="tools-top more" ><span class="glyphicon glyphicon-option-horizontal"></span> Align Horizontal Center</a></li>
                                                 <li><a href="javascript:void(0);" id="verticenterindent" title="Vertical center Indent" class="tools-top more" ><span class="glyphicon glyphicon-option-vertical"></span> Align Vertical Center</a></li>
                                                 <li><a href="javascript:void(0);" id="leftindent" title="Left Align" class="tools-top more" ><span class="glyphicon glyphicon-arrow-left"></span> Align To Left</a></li>
                                                 <li><a href="javascript:void(0);" id="rightindent" title="Right Align" class="tools-top more" ><span class="glyphicon glyphicon-arrow-right"></span> Align To Right</a></li>
 -->
                                                 <li><a href="javascript:void(0);" id="objectfliphorizontal" title="Flip Horizontal" class="tools-top more" ><img src="img/fliphorizontally.png" width="14">&nbsp; Flip Horizontally</a></li>
                                                 <li><a href="javascript:void(0);" id="objectflipvertical" title="Flip Vertical" class="tools-top more" ><img src="img/flipvertically.png" width="14">&nbsp; Flip Vertically</a></li>
                                                 <li><a href="javascript:void(0);" id="objectlock" title="Lock Object" class="tools-top more" ><i class="fa fa-lock"></i>&nbsp;&nbsp; Lock Object</a></li>
                                                 <li><a href="javascript:void(0);" id="objectopacity" title="Opacity" class="tools-top more noclose" ><img src="img/opacity.svg" width="13">&nbsp; Opacity</a></li>
                                                 <input id="changeopacity" data-slider-id='opacitySlider' type="text" data-slider-min="0.1" data-slider-max="1" data-slider-step=".1" data-slider-value="1"/>
                                          </ul>
                                    </div>
									<a href="javascript:void(0);" id="replace_image" title="Replace image" class="tools-top btn btn-default">Replace image</a>
                                <span id="imagecropOptions">
                                     <a href="javascript:zoomBy(0,0,10);" title="Zoom In" class="tools-top btn btn-default"><i class="fa fa-search-plus"></i></a>
                                     <a href="javascript:zoomBy(0,0,-10);" title="Zoom Out" class="tools-top btn btn-default"><i class="fa fa-search-minus"></i></a>
                                     <a href="javascript:zoomBy(-5,0,0);" title="Shift Left" class="tools-top btn btn-default"><i class="fa fa-arrow-left"></i></a>
                                     <a href="javascript:zoomBy(5,0,0);" title="Shift Right" class="tools-top btn btn-default"><i class="fa fa-arrow-right"></i></a>
                                     <a href="javascript:zoomBy(0,-5,0);" title="Shift Up" class="tools-top btn btn-default"><i class="fa fa-arrow-up"></i></a>
                                     <a href="javascript:zoomBy(0,5,0);" title="Shift Down" class="tools-top btn btn-default"><i class="fa fa-arrow-down"></i></a>
                                </span>
                  </span>
                  </div>
               </div>
               <!-- end tools-top -->
               <div class="tab-content" id='canvasbox-tab' style='margin-top:80px; text-align: -webkit-center; display: inline-block;' align="center">
                  <span id='infotext' style='font-size: 10px; opacity: 0.8; position: relative; left: 0px; top: 0px; z-index: 1000;'></span>
                     <div id='canvaspages' tabindex="0" style='outline:none;'>
                           <div class="page" id='page0'>
                           </div>
                     </div>
                        <!--
                              <div id='divcanvas0' class="divcanvas" onClick='javascript:selectCanvas(this.id);'>
                              </div>
                        -->
                       <div style="display:none; float:right; margin-top: -240px; margin-right: 112px; color:#ffffff;">
                  <!--     <i id='duplicatecanvas' class="fa fa-files-o fa-lg duplicatecanvas" style='z-index:1000; cursor:pointer; color:#ffffff;'></i></br></br> -->
                       <i id='deletecanvas' class="fa fa-trash-o fa-lg deletecanvas" style='z-index:1000; cursor:pointer; color:#ffffff;'></i>
                  </div>
             <!--     <button onClick='javascript:addNewCanvasPage();' id="addnewpagebutton" class="btn" type="button" style="width:150px; margin:20px 0; padding:10px; border:1px solid #555;"> + Add a New Page</button>  -->
                  <!--<button onClick='javascript:toSVG();' id="tosvgbtn" class="btn" type="button" style="width:150px; margin:20px 0; padding:10px; border:1px solid #555;"> + Check SVG</button>-->
                  <div style="display:none;">
                        <canvas id="outputcanvas" width="750" height="600" class="canvas"></canvas>
                  </div>
                  <div style="display:none;">
                        <canvas id="tempcanvas" width="100" height="100" class="canvas"></canvas>
                  </div>
               </div>
               <!-- /tab-content -->
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- Save Modal HTML -->
<!--
      <div id="templateSaveModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content" style="width:300px; margin:250px 0px 0px 125px;">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Save Template</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <button type="button" class="btn bg-orange btn-small" id="saveimage"><i class="fa fa-cloud-download"></i> Save Template for Editing Work</button><br>
                  </div>
                  <div class="footer">
                     <button type="submit" class="btn bg-orange btn-small" onClick="javascript:$('#templateSaveModal').modal('hide');"><i class="fa fa-close"></i> Cancel</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
 -->
      <!-- Publish Modal HTML -->
<!--
      <div id="publishModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content" style="width:300px; margin:250px 0px 0px 125px;">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Publish</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <button type="button" class="btn bg-orange btn-small" id="downloadAsPDF"><i class="fa fa-cloud-download"></i> Save as PDF</button>
                     <button type="button" class="btn bg-orange btn-small" id="downloadAsJPEG"><i class="fa fa-cloud-download"></i> Save as JPEG</button>
                  </div>
                  <div class="footer">
                     <button type="submit" class="btn bg-orange btn-small" onClick="javascript:$('#publishModal').modal('hide');"><i class="fa fa-close"></i> Cancel</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
 -->
      <!-- Success Modal HTML -->
      <div id="successModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-300">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Success</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span id="successMessage"></span>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
               </div>
            </div>
         </div>
      </div>
      <!-- Alert Modal HTML -->
      <div id="alertModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-300">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Alert</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span id="responceMessage"></span>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
               </div>
            </div>
         </div>
      </div>
      <!-- Add Category Modal HTML -->
      <div id="Addcategoryodal" class="modal fade">
         <div class="modal-dialog modal-content-400">
            <div class="modal-content">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Add Category</h4>
               </div>
               <form role="form" name="addcategoryform" id="addcategoryform">
                  <div class="modal-body" style="margin-top:-30px; ">
                     <div class="row">
                        <div class="form-group col-lg-12">
                           <label for="category">Category</label>
                           <input type="text" name="category" id="category" class="form-control" placeholder="Enter Category">
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="modal-footer clearfix">
                     <button type="reset" class="btn btn-default btn-small" data-dismiss="modal" >Cancel</button>
                     <button type="submit" class="btn btn-default btn-small" >Add</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Delete Template Category Modal HTML -->
      <div id="Del_templatecatmodal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-400">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Delete Category</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span>Are you sure you want to delete the category?</span>
                  </div>
               </div>
                  <div class="modal-footer clearfix">
                     <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_tempcatdelete();" >Yes</button>
                     <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                  </div>
            </div>
         </div>
      </div>
      <!-- Delete Category Modal HTML -->
      <div id="Del_catmodal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-400">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Delete Category</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span>Are you sure you want to delete the category?</span>
                  </div>
               </div>
                  <div class="modal-footer clearfix">
                     <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_catdelete();" >Yes</button>
                     <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                  </div>
            </div>
         </div>
      </div>
      <!-- Delete Bg Category Modal HTML -->
      <div id="Del_bgcatmodal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-400">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Delete Category</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span>Are you sure you want to delete the category?</span>
                  </div>
               </div>
                  <div class="modal-footer clearfix">
                     <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_Bgcatdelete();" >Yes</button>
                     <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                  </div>
            </div>
         </div>
      </div>
      <!-- Delete Text Category Modal HTML -->
      <div id="Del_textcatmodal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-400">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Delete Category</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span>Are you sure you want to delete the category?</span>
                  </div>
               </div>
                  <div class="modal-footer clearfix">
                     <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_textcatdelete();" >Yes</button>
                     <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                  </div>
            </div>
         </div>
      </div>
      <!-- Add Category Modal HTML -->
      <div id="AddTemplatecategoryModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-400">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Add Category</h4>
               </div>
               <form role="form" name="addtemplatecategoryform" id="addtemplatecategoryform">
                  <div class="modal-body" style="margin-top:-30px; ">
                     <div class="row">
                        <div class="form-group col-lg-12">
                           <label for="category">Category</label>
                           <input type="text" name="templatecategory" id="templatecategory" class="form-control" placeholder="Enter Category">
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="modal-footer clearfix">
                     <button type="reset" class="btn btn-default btn-small" data-dismiss="modal" >Cancel</button>
                     <button type="submit" class="btn btn-default btn-small" >Add</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Add Text Category Modal HTML -->
      <div id="AddTextcategoryModal" class="modal fade">
         <div class="modal-dialog modal-content-400">
            <div class="modal-content">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Add Text Category</h4>
               </div>
               <form role="form" name="addtextcategoryform" id="addtextcategoryform">
                  <div class="modal-body" style="margin-top:-30px; ">
                     <div class="row">
                        <div class="form-group col-lg-12">
                           <label for="category">Category</label>
                           <input type="text" name="textcategory" id="textcategory" class="form-control" placeholder="Enter Text Category">
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="modal-footer clearfix">
                     <button type="reset" class="btn btn-default btn-small" data-dismiss="modal" >Cancel</button>
                     <button type="submit" class="btn btn-default btn-small" >Add</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Save Template Modal HTML -->
      <div id="savetemplate_modal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-500">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Save Label</h4>
               </div>
               <form role="form" name="savetemplateform" id="savetemplateform">
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span><label for="template">Category :</label>
                           <select class="form-control" name="template_category" id="template_category" required>
                              <option value="">Select Category</option>
                           </select>
                              </span></br>
                     <span><label for="template">Label Name :</label>
                           <input type="text" name="templatename" id="templatename" class="form-control" placeholder="Enter Name"></span>
                  </div>
               </div>
                  <div class="modal-footer clearfix">
                     <button type="submit" class="btn btn-default" >Submit</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Download Template Modal HTML -->
   <!--   <div id="downloadtemplate_modal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-500">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Download Label</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span><label for="template">Label Name :</label>
                           <input type="text" name="downtemplatename" id="downtemplatename" class="form-control" placeholder="Enter Name"></span>
                  </div>
               </div>
                  <div class="modal-footer clearfix">
                     <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:downloadTemplateFile();" >Download</button>
                  </div>
            </div>
         </div>
      </div>  -->
      <!-- Save Text Modal HTML -->
      <div id="savetext_modal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-500">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Save Text</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span><label for="template">Category :</label>
                           <select class="form-control" name="text_category" id="text_category" >
                              <option value="">Select Category</option>
                           </select>
                              </span></br>
                     <span><label for="template">Text Name :</label>
                           <input type="text" name="textname" id="textname" class="form-control" placeholder="Enter Name"></span>
                  </div>
               </div>
                  <div class="modal-footer clearfix">
                     <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:savetextfromselection();" >Submit</button>
                  </div>
            </div>
         </div>
      </div>
      <!-- Save Element Modal HTML -->
      <div id="saveelement_modal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-500">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Save Element</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span><label for="template">Category :</label>
                           <select class="form-control" name="elmt_category" id="elmt_category" >
                              <option value="">Select Category</option>
                           </select>
                              </span></br>
                     <span><label for="template">Element Name :</label>
                           <input type="text" name="elmtname" id="elmtname" class="form-control" placeholder="Enter Name"></span>
                  </div>
               </div>
                  <div class="modal-footer clearfix">
                     <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:saveelementsfromselection();" >Submit</button>
                  </div>
            </div>
         </div>
      </div>
      <!-- Add Category Modal HTML -->
      <div id="AddBGcategoryodal" class="modal fade">
         <div class="modal-dialog modal-content-400">
            <div class="modal-content">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Add Category</h4>
               </div>
               <form role="form" name="addbgcategoryform" id="addbgcategoryform">
                  <div class="modal-body" style="margin-top:-30px; ">
                     <div class="row">
                        <div class="form-group col-lg-12">
                           <label for="category">Category</label>
                           <input type="text" name="bgcategory" id="bgcategory" class="form-control" placeholder="Enter Category">
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="modal-footer clearfix">
                     <button type="reset" class="btn btn-default btn-small" data-dismiss="modal" >Cancel</button>
                     <button type="submit" class="btn btn-default btn-small" >Add</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Canvas h/w Modal HTML -->
      <div id="canvaswh_modal" class="modal fade" data-keyboard="false" data-backdrop="static">
         <div class="modal-dialog">
            <div class="modal-content modal-content-400">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>-->
                  <h4 class="modal-title">Canvas Width / Height</h4>
               </div>
                   <form action="#" name="canvaswhForm" id="canvaswhForm" method="post">
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                     <span><label for="template">Canvas width (in inches):</label>
                           <input type="text" name="loadCanvasWid" id="loadCanvasWid" class="form-control" placeholder="Enter Width" value='5'>
                              </span></br>
                     <span><label for="template">Canvas height (in inches):</label>
                           <input type="text" name="loadCanvasHei" id="loadCanvasHei" class="form-control" placeholder="Enter Height" value='7'></span>
</br>
                     <span><label for="template">Number of Canvas rows</label>
                           <input type="text" name="numOfcanvasrows" id="numOfcanvasrows" class="form-control" value="1"></span>
</br>
                     <span><label for="template">Number of Canvas columns</label>
                           <input type="text" name="numOfcanvascols" id="numOfcanvascols" class="form-control" value="1"></span>
                  </div>
               </div>
                  <div class="modal-footer clearfix">
                     <button type="submit" class="btn btn-default">Submit</button>
                  </div>
                   </form>
            </div>
         </div>
      </div>
      <div id="spinnerModal" class="modal fade" data-backdrop="static" data-keyboard="false"><i class="fa fa-cog fa-spin" style="position: absolute; top: 50%; left: 50%; margin-top: -75px; margin-left: -75px; font-size: 150px;"></i></div>
      <!-- Imgae Alert Modal HTML -->
      <div id="imagealertModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-400">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">IMAGE FILE FORMAT / SIZE MISMATCH.</h4>
               </div>
               <div class="modal-body" style="margin-top:-30px; ">
                  <div class="body">
                    <label>Please upload your image format in JPG/PNG/GIF. Each file size is limited to 1000 KB.</label>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
               </div>
            </div>
         </div>
      </div>
      <!-- Add Element Modal HTML -->
      <div id="AddelementModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-500">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Add Element</h4>
               </div>
               <form role="form" name="addelementform" id="addelementform">
                  <div class="modal-body" style="margin-top:-30px; ">
                     <div class="row">
                        <div class="form-group col-lg-12">
                           <label for="element_category">Category</label>
                           <select class="form-control" name="element_category" id="element_category" >
                              <option value="">Select Category</option>
                           </select>
                        </div>
                        <div class="form-group col-lg-12">
                           <label for="element_name">Element Name</label>
                           <input type="text" name="element_name" id="element_name" class="form-control" placeholder="Enter Element">
                        </div>
                        <div class="form-group col-lg-12">
                           <label name="element">Element</label>
                        </div>
                        <div class="form-group element-upload col-lg-3">
                           <label for="element_img" class="btn btn-default btn-block"><i class="fa fa-cloud-upload"></i> Upload</label>
                           <input id="element_img" type="file" onchange="readIMG(this);" name="element_img" />
                        </div>
                                          <img id="previewImage" src="#" alt="Your image" style="display:none;" />
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="modal-footer clearfix">
                     <button type="reset" class="btn btn-default btn-small" data-dismiss="modal" >Cancel</button>
                     <button type="submit" class="btn btn-default btn-small" >Add</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Add Background Modal HTML -->
      <div id="AddbackgroundModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-500">
               <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                  <h4 class="modal-title">Add Background</h4>
               </div>
               <form role="form" name="addbackgroundform" id="addbackgroundform">
                  <div class="modal-body" style="margin-top:-30px; ">
                     <div class="row">
                        <div class="form-group col-lg-12">
                           <label for="element_category">Category</label>
                           <select class="form-control" name="bg_category" id="bg_category" >
                              <option value="">Select Category</option>
                           </select>
                        </div>
                        <div class="form-group col-lg-12">
                           <label for="element_name">Background Name</label>
                           <input type="text" name="bg_name" id="bg_name" class="form-control" placeholder="Enter Background Name">
                        </div>
                        <div class="form-group col-lg-12">
                           <label name="background">Background</label>
                        </div>
                        <div class="form-group bg-upload col-lg-3">
                           <label for="bg_img" class="btn btn-default btn-block"><i class="fa fa-cloud-upload"></i> Upload</label>
                           <input id="bg_img" type="file" onchange="readBGIMG(this);" name="bg_img" />
                        </div>
                                          <img id="previewBGImage" src="#" alt="Your image" style="display:none;" />
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="modal-footer clearfix">
                     <button type="reset" class="btn btn-default btn-small" data-dismiss="modal" >Cancel</button>
                     <button type="submit" class="btn btn-default btn-small" >Add</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
		<!-- Upload Image Popup -->
	<div id="AdduploadimageModal" class="modal fade edit-object" tabindex="-1" role="dialog" aria-labelledby="imageModalTitle" aria-hidden="true" data-editor-image-modal>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="imageModalTitle">Add Image</h4>
			</div>
			<div class="modal-body">
				<div class="images-insert">
					<div class="row">
						<div class="col-lg-5 imageBG-upload">
                                          <form id="upload" action="uploadimage.php" method="POST" enctype="multipart/form-data">
                                             <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="2000000" />
                                             <label for="fileselect" class="images-button btn btn-block btn-lg btn-primary"><i class="fa fa-cloud-upload"></i> Upload image</label>                                             
                                             <input id="fileselect" type="file" name="fileselect[]" />
                                          </form>
                                          <div id="progress"></div>
						</div>
						<!--<div class="col-lg-2 h1 text-center no-margin">
							or
						</div>
						<div class="col-lg-5">
							<input type="url" class="images-url form-control input-lg" placeholder="Paste image URL">
						</div>-->
					</div>
					<div id="image_container" style="position: relative;height:450px;">
					</div>
					<!-- // for pagination purpose	
					<div class="pagination"></div>-->
				</div>
			</div>
		</div>
	</div>
      <div style="position: absolute;width: 1px;height: 1px;overflow: hidden;">
        <p style="font-family: Alfa Slab One" >Alfa Slab One</p>
        <p style="font-family: Droid Sans" >Droid Sans</p>
        <p style="font-family: Cabin" >Cabin</p>
        <p style="font-family: PT Sans" >PT Sans</p>
        <p style="font-family: Cabin Sketch" >Cabin Sketch</p>
        <p style="font-family: PT Sans Narrow" >PT Sans Narrow</p>
        <p style="font-family: Bitter" >Bitter</p>
        <p style="font-family: Allura" >Allura</p>
        <p style="font-family: Alex Brush" >Alex Brush</p>
        <p style="font-family: Calligraffitti" >Calligraffitti</p>
        <p style="font-family: Crimson Text" >Crimson Text</p>
        <p style="font-family: Open Sans" >Open Sans</p>
        <p style="font-family: Bevan" >Bevan</p>
        <p style="font-family: Dancing Script" >Dancing Script</p>
        <p style="font-family: Comfortaa" >Comfortaa</p>
        <p style="font-family: Gruppo" >Gruppo</p>
        <p style="font-family: Archivo Narrow" >Archivo Narrow</p>
        <p style="font-family: Amatic SC" >Amatic SC</p>
        <p style="font-family: Fjalla One" >Fjalla One</p>
        <p style="font-family: Cinzel" >Cinzel</p>
        <p style="font-family: Oswald" >Oswald</p>
        <p style="font-family: Montserrat" >Montserrat</p>
        <p style="font-family: Droid Serif" >Droid Serif</p>
        <p style="font-family: PT Serif" >PT Serif</p>
      </div>      
	</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>
<!-- <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js"></script>
<script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="js/bootstrap-slider.js"></script>
<!-- Plugins for form validations -->
<script type="text/javascript" src="js/fabric1.6.js"></script>
<script type="text/javascript" src="js/aligning_guidelines.js"></script>
<script type="text/javascript" src="js/centering_guidelines.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/validation-methods.js"></script>
<script src="js/jquery-validate.bootstrap-tooltip.js"></script>
<script src="js/filedrag.js" type="text/javascript"></script>
<script type="text/javascript" src="js/spectrum.js"></script>
<script type="text/javascript" src="js/fileSaver.min.js"></script>
<!--<script src="js/pagination.js"></script>-->

<script type="text/javascript">
    var tempcanvas = new fabric.Canvas('tempcanvas');
    var canvas = new fabric.Canvas('canvas0');
    canvas.rotationCursor = 'url("img/rotatecursor2.png") 10 10, crosshair';
    canvas.backgroundColor = '#ffffff';
    var selectedFont = 'Tinos';
    var fillColor = 'Black';
</script>
<!-- our site js -->
<script>document.write("<script type='text/javascript' src='js/functions.js?v=" + Date.now() + "'><\/script>");</script>
<script>document.write("<script type='text/javascript' src='js/canvasevents.js?v=" + Date.now() + "'><\/script>");</script>
<script>

// Wait for window load
$(window).load(function() {
    // Animate loader off screen
    $("#loadingpage").fadeOut("slow");
    $("#canvaswh_modal").modal('show');
    if (window.location.href.indexOf('?newtemplate') != -1) {
        $("#canvaswh_modal").modal('show');
    }
    $('.deletecanvas').css('display', 'none');
});

var Istempselected = false;
var Iscatselected = false;
var IsBgselected = false;
var IsTextselected = false;
$(document).ready(function() {
    getTemplates('');
    setTimeout(function() {
        gettempcategory();
    }, 500);
    setTimeout(function() {
        getTemplatesName();
    }, 750);
    setTimeout(function() {
        getcategory();
    }, 1000);
    setTimeout(function() {
        getcatimages('');
    }, 1250);
    setTimeout(function() {
        getBgcategory();
    }, 1500);
    setTimeout(function() {
        getbgimages('');
    }, 1750);
    setTimeout(function() {
        getTextcategory();
    }, 2500);
    setTimeout(function() {
        getTexts('');
    }, 2750);
    setTimeout(function() {
        getuploadimages();
    }, 3000);
    //setCanvasWidthHeight(canvas.getWidth() * canvasScale, canvas.getHeight() * canvasScale);
    //initCanvasEvents();
    //initAligningGuidelines(canvas);
    //initCenteringGuidelines(canvas);
    //adjustIconPos(0);
    $('#cat-select').change(function() {
        var selectedID = $(this).val();
        Iscatselected = true;
        $('#catimage_container').empty();
        getcatimages(selectedID);
    });
    $('#tempcat-select').on('change', function() {
        Istempselected = true;
        $('#template_container').empty();
        getTemplates($(this).val());
    });
    $('#textcat-select').on('change', function() {
        Istextselected = true;
        $('#text_container').empty();
        getTexts($(this).val());
    });
    //    $('#template-select').on('change', function () {
    //        getTemplates($(this).val());
    //    });
    $('#bgcat-select').on('change', function() {
        IsBgselected = true;
        $('#background_container').empty();
        getbgimages($(this).val());
    });
});
//Do not close dropdown with checkbox
$('.noclose').on('click', function(e) {
    e.stopPropagation();
});
//Show/hide dropdown submenu
$(document).ready(function() {
    $(".dropdown-submenu").click(function(event) {
        // stop bootstrap.js to hide the parents
        event.stopPropagation();
        // hide the open children
        $(this).find(".dropdown-submenu").removeClass('open');
        // add 'open' class to all parents with class 'dropdown-submenu'
        $(this).parents(".dropdown-submenu").addClass('open');
        // this is also open (or was)
        $(this).toggleClass('open');
    });
});
//Show/hide more canvas buttons
//  function toggle_visibility(more) {
//  var e = document.getElementsByClassName(more);
//  for ( var i=0, len=e.length; i<len; ++i ){
//  if(e[i].style.display == 'inline-block')
//  e[i].style.display = 'none';
//  else
//  e[i].style.display = 'inline-block';
//  }
//  }
$(document).on("click", ".catImage", function() {
    var imagepath = $(this).data('imgsrc');
    addSVGToCanvas(imagepath);
    return false;
});

$(document).on("click", ".addImage", function() {
    var imgpath = $(this).data('imgsrc');
    addImage(imgpath);
    return false;
});


function addFileToCanvas(imagefile) {

    var actObj = canvas.getActiveObject();
    if (isReplaceImage && actObj && actObj.type == 'cropzoomimage') {
        //replace image
        var img = new Image();
        img.onload = function() {
            var w = actObj.width * actObj.scaleX;
            var h = actObj.height * actObj.scaleY;
            actObj.setElement(img);

            scalex = w / this.width;
            scaley = h / this.height;

            actObj.scaleX = scalex;
            actObj.scaleY = scalex;

            actObj.orgSrc = img.src;
            actObj.src = img.src;

            $("#spinnerModal").modal('hide');
            $("#AdduploadimageModal").modal('hide');
            actObj.setCoords();
            canvas.renderAll();
        }
        img.src = "./uploads/" + imagefile;
        isReplaceImage = false;
    } else {
        fabric.util.loadImage("./uploads/" + imagefile, function(img) {
            var object = new fabric.Cropzoomimage(img, {
                left: canvas.getWidth() / 2,
                top: canvas.getHeight() / 2,
                scaleX: canvasScale / 2,
                scaleY: canvasScale / 2
            });
            object.src = "uploads/" + imagefile;
            canvas.add(object);
            canvas.setActiveObject(object);
            object.center();
            object.setCoords();
            setControlsVisibility(object);

            $("#spinnerModal").modal('hide');
            $("#AdduploadimageModal").modal('hide');

            canvas.renderAll();
            saveState();
        }, {
            crossOrigin: ''
        });
    }
}

function addImage(imgpath) {

    var actObj = canvas.getActiveObject();
    if (isReplaceImage && actObj && actObj.type == 'cropzoomimage') {
        //replace image
        var img = new Image();
        img.onload = function() {

            w = actObj.width * actObj.scaleX;
            h = actObj.height * actObj.scaleY;

            actObj.setElement(img);
            actObj.src = imgpath;
            actObj.orgSrc = imgpath;

            actObj.cw = w;
            actObj.ch = h;
          
            actObj.scaleX = w/actObj.width;
            actObj.scaleY = h/actObj.height;

            var ih = img.naturalHeight;
            var iw = img.naturalWidth;
            
            //find the width/height for the aspect ratio.
            var fw, fh;

            var width_ratio  = w  / iw;
            var height_ratio = h / ih;
            if (width_ratio > height_ratio) {
                fw = iw * width_ratio;
                fh = ih*fw/iw;
            } else {
                fh = ih * height_ratio;
                fw = iw*fh/ih;    
            }

            if (width_ratio > height_ratio) {
                actObj.asw = actObj.cw = w / width_ratio;
                actObj.ash = actObj.ch = h / width_ratio;
            } else {
                actObj.asw = actObj.cw = w / height_ratio;
                actObj.ash = actObj.ch = h / height_ratio;                
            }          

            actObj.cx = 0;
            actObj.cy = 0;

            actObj.zoomBy(0, 0, 0, function() {
                
                actObj.setCoords();
                canvas.renderAll();

                $("#spinnerModal").modal('hide');
                $("#AdduploadimageModal").modal('hide');

            });
        }
        img.src = imgpath;
        isReplaceImage = false;
    } else {
        fabric.util.loadImage(imgpath, function(img) {
            var object = new fabric.Cropzoomimage(img, {
                left: canvas.getWidth() / 2,
                top: canvas.getHeight() / 2,
                scaleX: canvasScale / 2,
                scaleY: canvasScale / 2
            });
            object.src = imgpath;
            canvas.add(object);
            canvas.setActiveObject(object);
            object.center();
            object.setCoords();
            setControlsVisibility(object);

            $("#spinnerModal").modal('hide');
            $("#AdduploadimageModal").modal('hide');

            canvas.renderAll();
            saveState();
        }, {
            crossOrigin: ''
        });
    }
}

function addReplaceImage(object) {

    canvas.add(object);
    canvas.setActiveObject(object);
    canvas.renderAll();
}

$(document).on("click", ".bgImage", function() {
    var bgimagepath = $(this).data('imgsrc');
    setCanvasBg(canvas, bgimagepath);
    return false;
});
$(document).on("click", "#bgImageRemove", function() {
    deleteCanvasBg(canvas);
    return false;
});
$("#publishTemplate").click(function() {
    $("#publishModal").modal('show');
});
$(function() {
    $(".fzbutton").on("click", function() {
        var $button = $(this);
        var oldValue = $("#fontsize").val();
        if ($button.attr("id") == "fontsizeInc") {
            if (oldValue.toString().indexOf('.') != -1) {
                var newVal = Math.ceil(parseFloat(oldValue));
            } else {
                var newVal = parseFloat(oldValue) + 1;
            }
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                if (oldValue.toString().indexOf('.') != -1) {
                    var newVal = Math.floor(parseFloat(oldValue));
                } else {
                    var newVal = parseFloat(oldValue) - 1;
                }
            } else {
                newVal = 0;
            }
        }
        $("#fontsize").val(newVal);
        $("#fontsize").change();
    });
});
$("#colorSelector").spectrum({
    showAlpha: false,
    showPalette: true,
    //maxSelectionSize: 2,
    preferredFormat: "hex",
    hideAfterPaletteSelect: true,
    showInput: true,
    move: function(color) {
        var colorVal = color.toHexString(); // #ff0000
        changeObjectColor(colorVal);
        $('#colorSelector').css('backgroundColor', colorVal);
    },
});

$("#bgcolorselect").spectrum({
    //flat: true,
    hideAfterPaletteSelect: true,
    move: function(color) {
        var colorVal = color.toHexString(); // #ff0000
        deleteCanvasBg(canvas);
        setCanvasBg(canvas, false, colorVal);
    },
});

jQuery(function($) {
    $('#a').on('scroll', function() {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            if ($('#tempcat-select').val() != '') {
                getTemplates($('#tempcat-select').val());
            } else {
                getTemplates();
            }
        }
    });
    $('#c').on('scroll', function() {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            if ($('#cat-select').val() != '') {
                getcatimages($('#cat-select').val());
            } else {
                getcatimages();
            }
        }
    });
    $('#d').on('scroll', function() {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            if ($('#cat-select').val() != '') {
                getbgimages($('#bgcat-select').val());
            } else {
                getbgimages();
            }
        }
    });
});
var catoffset = 0;
// get Category Images
function getcatimages(id) {
    if (typeof id != 'undefined') {
        var catId = id;
    } else {
        var catId = '';
    }
    if (Iscatselected == false) {
        var lastelement = $('#catimage_container').children().last().attr('id');
        if (typeof lastelement != 'undefined') {
            catoffset = lastelement;
        }
    } else {
        catoffset = 0;
    }
    $.ajax({
        type: 'GET',
        url: 'get-catimages.php?offset=' + catoffset + '&limit=12&category=' + catId,
        success: function(data) {
            if (data != '') {
                $('#catimage_container').append(data);
                Iscatselected = false;
            } else {
                catoffset = 0;
            }
            //$('#catimage_container').empty();
        }
    });
}

var uploadimagesdata;
function getuploadimages() {

    var $grid = $('#image_container');
    $grid.empty();

    $grid.isotope({
        itemSelector: '.thumb',
        masonry: {
            columnWidth: '.thumb'
        }
    });

    $.ajax({
        type: 'GET',
        url: 'get_uploadimages.php',
        success: function(data) {
            if (data != '') {
                uploadimagesdata = $(data);
                var data = $(data);

                $grid.isotope()
                    .append(data)
                    .isotope('appended', data)
                    .isotope('layout');

                $grid.imagesLoaded().progress(function() {
                    $grid.isotope('layout');
                    $grid.isotope('reloadItems');
                });                
            }
        }
    });
}

var bgoffset = 0;
// get bg Images
function getbgimages(id) {
    if (typeof id != 'undefined') {
        var bgcatId = id;
    } else {
        var bgcatId = '';
    }
    if (IsBgselected == false) {
        var lastbackground = $('#background_container').children().last().attr('id');
        if (typeof lastbackground != 'undefined') {
            bgoffset = lastbackground;
        }
    } else {
        bgoffset = 0;
    }
    $.ajax({
        type: 'GET',
        url: 'get-bgimages.php?offset=' + bgoffset + '&limit=12&category=' + bgcatId,
        success: function(data) {
            if (data != '') {
                $('#background_container').append(data);
                IsBgselected = false;
            } else {
                bgoffset = 0;
            }
            //$('#background_container').empty();
        }
    });
}
var tempoffset = 0;
// get Template Images
var templatesloading = false;

function getTemplates(catid, refresh, tempid) {

    if (templatesloading) return;

    templatesloading = true;

    var $grid = $('#template_container');

    if (refresh) {
        $('#template_container').empty();
        tempoffset = 0;
    }

    $grid.isotope({
        itemSelector: '.thumb',
        masonry: {
            columnWidth: '.thumb'
        }
    });

    if (typeof catid === 'undefined') {
        catid = '';
        tempoffset = 0;
    }

    if (typeof tempid === 'undefined') {
        tempid = "";
    }

    if (Istempselected == false) {
        var lasttemplate = $grid.children().last().attr('id');
        if (typeof lasttemplate != 'undefined') {
            tempoffset = lasttemplate;
        }
    } else {
        tempoffset = 0;
    }

    $.ajax({
        type: 'GET',
        url: 'get_templates.php?offset=' + tempoffset + '&limit=12&catid=' + catid + '&refresh=' + refresh + '&tempid=' + tempid,
        cache: false,
        success: function(data) {
            if (data != '') {
                var data = $(data);

                $grid.isotope()
                    .append(data)
                    .isotope('appended', data)
                    .isotope('layout');

                $grid.imagesLoaded().progress(function() {
                    $grid.isotope('layout');
                    $grid.isotope('reloadItems');
                });

                Istempselected = false;
            } else {
                tempoffset = 0;
            }

            templatesloading = false;
        }
    });
}

var textoffset = 0;
// get Text Images
function getTexts(id) {

    var $grid = $('#text_container');

    $grid.isotope({
        itemSelector: '.thumb',
        masonry: {
            columnWidth: '.thumb'
        }
    });
    if (typeof id != 'undefined') {
        var textid = id;
    } else {
        var textid = '';
    }
    if (IsTextselected == false) {
        var lasttext = $('#text_container').children().last().attr('id');
        if (typeof lasttext != 'undefined') {
            textoffset = lasttext;
        }
    } else {
        textoffset = 0;
    }
    $.ajax({
        type: 'GET',
        url: 'get_texts.php?offset=' + textoffset + '&limit=12&textid=' + textid,
        success: function(data) {
            if (data != '') {

                $grid.isotope()
                    .append(data)
                    .isotope('appended', data)
                    .isotope('layout');

                IsTextselected = false;
            } else {
                textoffset = 0;
            }
            //$('#template_container').empty();
        }
    });
}
<!-- canvas Width and height Form Validation -->
$(document).ready(function() {
    $('#canvaswhForm').validate({
        rules: {
            loadCanvasWid: {
                required: true,
                number: true
            },
            loadCanvasHei: {
                required: true,
                number: true
            },
            numOfcanvasrows: {
                required: true,
                number: true
            },
            numOfcanvascols: {
                required: true,
                number: true
            },
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid')
                .closest('.form-group').removeClass('has-error').addClass('has-success');
            element.remove('label');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            addCanvasToPage();
            setCanvasSize();
        }
    });
});

function handleFileSelect(evt) {
    $("ul.navbar-nav>li.dropdown").removeClass("open");
    var files = evt.target.files; // FileList object
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {
        // Only process ype files.
        if (f.name.indexOf('.ype') == -1) {
            continue;
        }
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                // console.log(e.target.result);
                openTemplate(e.target.result);
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsText(f);
    }
}
document.getElementById('templateselect').addEventListener('change', handleFileSelect, false);
$("#showmoreoptions").click(function() {
    $("#opacitySlider").hide();
    $("#lineheightSlider").hide();
    $('#showmoreoptions ul li a').removeClass('temphide');
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        if (activeObject.lockMovementY == true) {
            $('#objectlock').html("<i class='fa fa-unlock'></i>&nbsp; Unlock Object");
        } else {
            $('#objectlock').html("<i class='fa fa-lock' style='font-size:16px;'></i>&nbsp;&nbsp; Lock Object");
        }
        var objectopacity = activeObject.getOpacity();
        $("#changeopacity").slider('setValue', objectopacity);
    }
});
$("#objectopacity").click(function() {
    $("#opacitySlider").toggle();
    $("#showmoreoptions ul li a").each(function() {
        if ($(this).css("display") == "block") {
            $(this).not("#objectopacity").addClass('temphide');
        }
    });
});
$("#lineheight").click(function() {
    $("#lineheightSlider").toggle();
    $("#showmoreoptions ul li a").each(function() {
        if ($(this).css("display") == "block") {
            $(this).not("#lineheight").addClass('temphide');
        }
    });
});
$('#changeopacity').slider({
    formatter: function(value) {
        return value * 100 + '%';
    }
});
$('#bgscale').slider({
    formatter: function(value) {
        return value * 100 + '%';
    }
});

function handleContextmenu(e) {
    // prevents the usual context from popping up
    e.preventDefault();
    // Show contextmenu
    $(".custom-menu").finish().toggle(100).
        // In the right position (the mouse)
    css({
        top: e.pageY + "px",
        left: e.pageX + "px"
    });
}
//Disable context menu
$("#canvasbox-tab").bind('contextmenu', function(e) {
    handleContextmenu(e);
    return false;
});
// If the menu element is clicked
$(".custom-menu li").click(function() {
    // This is the triggered action name
    switch ($(this).attr("data-action")) {
        // A case for each action. Your actions here
        case "selectall":
            selectallobjs();
            break;
        case "copy":
            copyobjs();
            break;
        case "cut":
            cutobjs();
            break;
        case "paste":
            pasteobjs();
            break;
    }
    // Hide it AFTER the action was triggered
    $(".custom-menu").hide(100);
});
//hide tab pane by clicking again
$(document).off('click.tab.data-api');
$(document).on('click.tab.data-api', '[data-toggle="tab"]', function(e) {
    e.preventDefault();
    var tab = $($(this).attr('href'));
    var activate = !tab.hasClass('active');
    $('div.tab-content>div.tab-pane.active').removeClass('active');
    $('ul.nav.nav-tabs>li.active').removeClass('active');
    if (activate) {
        $(this).tab('show')
    }
});

// Prevent the backspace key from navigating back.
$(document).unbind('keydown').bind('keydown', function(event) {
    var doPrevent = false;
    if (event.keyCode === 8) {
        var d = event.srcElement || event.target;
        if ((d.tagName.toUpperCase() === 'INPUT' &&
                (
                    d.type.toUpperCase() === 'TEXT' ||
                    d.type.toUpperCase() === 'PASSWORD' ||
                    d.type.toUpperCase() === 'FILE' ||
                    d.type.toUpperCase() === 'SEARCH' ||
                    d.type.toUpperCase() === 'EMAIL' ||
                    d.type.toUpperCase() === 'NUMBER' ||
                    d.type.toUpperCase() === 'DATE')
            ) ||
            d.tagName.toUpperCase() === 'TEXTAREA') {
            doPrevent = d.readOnly || d.disabled;
        } else {
            doPrevent = true;
        }
    }

    if (doPrevent) {
        event.preventDefault();
    }
});
$(function() {
    $("#shapeslider").slider({
        "min": 0.25,
        "max": 1.25,
        "value": 1,
        "step": 0.05,
        orientation: "horizontal"
    });
    $("#shapeslider").slider({
        stop: function(event, ui) {
            var spaceopacity = $("#shapeslider").slider("value");
            var obj = canvas.getActiveObject();
            if (obj) {
                obj.setOpacity(spaceopacity);
            }
            canvas.renderAll();
        }
    });
});
$(function() {
    $("#shapeslider").slider();
});

$("#upload_image").click(function() {

    $('#AdduploadimageModal').modal({show:true})                        
});

$('#AdduploadimageModal').on('shown.bs.modal', function (e) {
      var $grid = $('#image_container');

      $grid.imagesLoaded().progress(function() {
        $grid.isotope('layout');
        $grid.isotope('reloadItems');
      });
});
var uploadIdToDel = '';
$(document).on("click", ".deleteUploadImg", function() {
    uploadIdToDel = $(this).attr('id');
	proceed_uploadimgDelete();
});
function proceed_uploadimgDelete() {
    var selectedimg = uploadIdToDel;
    if (selectedimg != '') {
        $.post("actions/deleteimg.php", {
            "imgid": selectedimg
        }, function(data) {
            $('#image_container').empty();
            getuploadimages();
        });
    } else {
    }
}

/*$(document).ready(function() {
	$("#image_container").load("get_uploadimages.php");  //initial page number to load
	$(".pagination").bootpag({
	   total: <?php echo $pages; ?>,
	   page: 1,
	   maxVisible: 5 
	}).on("page", function(e, num){
		e.preventDefault();
		$("#image_container").load("get_uploadimages.php", {'page':num});
	});

});*/
</script>
</html>