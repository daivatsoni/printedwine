<?php
    require("library/config.php");
?>
<!DOCTYPE>
<style type="text/css">
div {
  -webkit-user-select: none;
}
body {
  -moz-user-focus: ignore;
  -moz-user-select: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -o-user-select: none;
  user-select: none;
}
</style>
<html class=''>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Printed Wine</title>
	    <meta name="description" content="">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/custom.css">
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link href="css/spectrum.css" type="text/css" rel="stylesheet">
		<link href="css/bootstrap-slider.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" href="css/dropzone.css">
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

	<style type="text/css">
      .label-upload > input {
            display: none;
      }
	</style>

	<body>
	<div id="loadingpage" style="z-index:3000;" class="modal" data-backdrop="static" data-keyboard="false" style="background:#00a5c5; opacity:1; display:block;"><i class="fa fa-cog fa-spin" style="position: absolute; top: 50%; left: 50%; margin-top: -75px; margin-left: -75px; font-size: 150px; color:#fff;"></i></div>

		 <ul class='custom-menu'>
			<li data-action="selectall">Select All</li>
			<li data-action="cut">Cut</li>
			<li data-action="copy">Copy</li>
			<li data-action="paste">Paste</li>
		</ul>
		<div class="container">
			<div class="row">
				<header class="header">
					<nav class="navbar navbar-custom">
						<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
						  <div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
							<div class="navbar-logo"> <a href="#"><img alt="Logo" class="img-responsive" src="images/logo.png"></a> </div>
						  </div>
						</div>
						 <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
						  <div style="height: 1px;" aria-expanded="false" id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav nav-custom">
								<li><a href="#" class="active-menu">Home</a></li>
								<li><a href="#">Wines</a></li>
								<li><a href="#">Cases</a></li>
								<li><a href="#">Artists</a></li>
								<li><a href="#">Winemakers</a></li>
								<li><a href="#">Specials</a></li>
								<li><a href="#">Subscribe</a></li>
								<li><a href="#">Register</a></li>
							</ul>
						  </div>
						  <!--/.nav-collapse -->
						  </div>
					</nav>
				</header>
			</div>
			<div class="header-bottom">
				<div class="row">
					<div class="col-md-2">
						<h4>Make it your own!</h4>
					</div>
					<div class="col-md-6">
						<p class="text-center">Hey Dan, you have $144 in your account to spend on wine!</p>
					</div>
					<div class="col-md-4">
						<form>
							<div class="form-group">
								<input type="text" placeholder="Browse Or Search " id="exampleInputEmail2" class="form-control custom-width">
								<button class="btn btn-default btn-search" type="submit"><i class="fa fa-search"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="content-wrapper">
			<div class="container">
				<div class="row">
					<div class="heading-sec clearfix margbtm20">
						<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" id="labelcontent2">
							<!--<h2>Wine Label maker <small>Label 3 <span>of 12</span></small></h2>-->	`
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<h3>Step 2 of 3</h3>
						</div>
					</div>
				</div>
				<div class="row margbtm20">
				<div class="tools-top" style="visibility:hidden;" align='center'>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 iconsdiv" style="z-index:2000;">
						<ul class="list-inline icons">
							<span class="textelebtns">
								<div class="btn-group" style="z-index:1000;">
								<a title="Select Font" id="font-selected" class="btn btn-default dropdown-toggle" data-placement="top" data-toggle="dropdown" href="javascript:void(0);">
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
								<div class="input-group" style="display:inline-flex;">
									<input type="text" class="fontinput form-control" id="fontsize" name="fontsize" min="0" max="100" value="6" style="width:50px; display:inline-block;">
									<div class="input-group-btn" style="display:inline-block;">
									<a id="fzbutton" title="Font Size" class="tools-top btn btn-default fzbutton-container dropdown-toggle" data-placement="top" data-toggle="dropdown" href="javascript:void(0);" style="padding:2px 5px;"> <i id="fontsizeInc" class="fa fa fa-caret-up fzbutton" style="display:block;"></i> <i id="fontsizeDec" class="fa fa-caret-down fzbutton" style="display:block;"></i></a>
										<ul class="dropdown-menu font-size-dropdown" id="font-size-dropdown" style='z-index:2000;'>
										   <li><a href="javascript:void(0);">6</a></li>
										   <li><a href="javascript:void(0);">8</a></li>
										   <li><a href="javascript:void(0);">10</a></li>
										   <li><a href="javascript:void(0);">12</a></li>
										   <li><a href="javascript:void(0);">14</a></li>
										   <li><a href="javascript:void(0);">16</a></li>
										   <li><a href="javascript:void(0);">18</a></li>
										   <li><a href="javascript:void(0);">20</a></li>
										   <li><a href="javascript:void(0);">22</a></li>
										   <li><a href="javascript:void(0);">24</a></li>
										   <li><a href="javascript:void(0);">26</a></li>
										   <li><a href="javascript:void(0);">28</a></li>
										   <li><a href="javascript:void(0);">30</a></li>
										   <li><a href="javascript:void(0);">36</a></li>
										   <li><a href="javascript:void(0);">48</a></li>
										   <li><a href="javascript:void(0);">60</a></li>
										   <li><a href="javascript:void(0);">72</a></li>
										   <li><a href="javascript:void(0);">96</a></li>
										   <li><a href="javascript:void(0);">120</a></li>
										   <li><a href="javascript:void(0);">144</a></li>
										</ul>
									</div>
								</div>
							</span>
                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Align left" id="objectalignleft" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-align-left"></i></a>
                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" id="objectaligncenter" title="Align center" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-align-center"></i></a>
                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" id="objectalignright" title="Align right" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-align-right"></i></a>
                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" id="objectalignjustify" title="Align justify" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-align-justify"></i></a>
							<li><a href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title ="Clone" class="tools-top"  id="clone"><i class="fa fa-clone"></i></a></li>
							<li><a href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title ="Send-BackWard" class="tools-top"  id="sendbackward"><img src="images/send-backward.gif"></a></li>
							<li><a href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title ="Bring-Forward" class="tools-top" id="bringforward"><img src="images/send-forward.gif"></a></li>
							<li class="btn-trash"><a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title = "Delete" id="deleteitem"><i class="tools-top fa fa-trash-o"></i></a></li>
							<li><a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Color-Selector" id="colorSelector"><i class="fa fa-eyedropper" aria-hidden="true"></i></a><li>
                            <span id='dynamiccolorpickers'></span>
                            <li>
								<div style="display:inline-block;" class="btn-group" id="showmoreoptions">
								  <button class="tools-top btn btn-default dropdown-toggle" title="Show More Tools" data-toggle="dropdown" id="showmore" href="javascript:void(0);" aria-expanded="false"><span class="caret"></span></button>
									  <ul class="dropdown-menu dropdown-menu-right" style='z-index:2000;'>
										 <li><a style="font-weight: bolder;" class="tools-top more textelebtns" title="Bold" id="fontbold" href="javascript:void(0);">Bold</a></li>
										 <li><a style="font-style: italic;" class="tools-top more textelebtns" title="Italic" id="fontitalic" href="javascript:void(0);">Italic</a></li>
										 <li><a style="text-decoration: underline;" class="tools-top more textelebtns" title="Underline" id="fontunderline" href="javascript:void(0);">Underline</a></li>
										 <li><a class="tools-top more textelebtns noclose" title="Line Height" id="lineheight" href="javascript:void(0);"><img width="14" src="">&nbsp; Line height</a></li>
										 <div class="slider slider-horizontal" id="lineheightSlider" style="display: none;"><div class="slider-track"><div class="slider-track-low" style="left: 0px; width: 0%;"></div><div class="slider-selection" style="left: 0%; width: 17.7778%;"></div><div class="slider-track-high" style="right: 0px; width: 82.2222%;"></div><div class="slider-handle min-slider-handle round" style="left: 17.7778%;" tabindex="0"></div><div class="slider-handle max-slider-handle round hide" style="left: 0%;" tabindex="0"></div></div><div class="tooltip tooltip-main top" style="left: 17.7778%; margin-left: 0px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">1.3</div></div><div class="tooltip tooltip-min top" style=""><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div><div class="tooltip tooltip-max top" style=""><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div></div><input type="text" data-slider-value="1.3" data-slider-step="0.1" data-slider-max="5" data-slider-min="0.5" data-slider-id="lineheightSlider" id="changelineheight" style="display: none;" data-value="1.3" value="1.3">
			<!--
			-->
										 <li><a class="tools-top more" title="Flip Horizontal" id="objectfliphorizontal" href="javascript:void(0);"><img width="14" src="images/fliphorizontally.png">&nbsp; Flip Horizontally</a></li>
										 <li><a class="tools-top more" title="Flip Vertical" id="objectflipvertical" href="javascript:void(0);"><img width="14" src="images/flipvertically.png">&nbsp; Flip Vertically</a></li>
										 <li><a class="tools-top more" title="Lock Object" id="objectlock" href="javascript:void(0);"><i style="font-size:16px;" class="fa fa-lock"></i>&nbsp;&nbsp; Lock Object</a></li>
										 <li><a class="tools-top more noclose" title="Opacity" id="objectopacity" href="javascript:void(0);" style="visibility: visible;"><img width="13" src="">&nbsp; Opacity</a></li>
										 <div class="slider slider-horizontal" id="opacitySlider" style="display: none;"><div class="slider-track"><div class="slider-track-low" style="left: 0px; width: 0%;"></div><div class="slider-selection" style="left: 0%; width: 100%;"></div><div class="slider-track-high" style="right: 0px; width: 0%;"></div><div class="slider-handle min-slider-handle round" style="left: 100%;" tabindex="0"></div><div class="slider-handle max-slider-handle round hide" style="left: 0%;" tabindex="0"></div></div><div class="tooltip tooltip-main top" style="left: 100%; margin-left: 0px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">100%</div></div><div class="tooltip tooltip-min top" style=""><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div><div class="tooltip tooltip-max top" style=""><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div></div><input type="text" data-slider-value="1" data-slider-step=".1" data-slider-max="1" data-slider-min="0.1" data-slider-id="opacitySlider" id="changeopacity" style="display: none;" data-value="1" value="1">
									  </ul>
								</div>

							</li>
							<li class="btn-replace"><a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Replace Image" id="replace_image">Replace Image</a></li>
                            <span id="imagecropOptions">
								 <a href="javascript:zoomBy(0,0,10);" data-toggle="tooltip" data-placement="top" title="Zoom In" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-search-plus"></i></a>
								 <a href="javascript:zoomBy(0,0,-10);" data-toggle="tooltip" data-placement="top" title="Zoom Out" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-search-minus"></i></a>
								 <a href="javascript:zoomBy(-5,0,0);" data-toggle="tooltip" data-placement="top" title="Shift Left" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-arrow-left"></i></a>
								 <a href="javascript:zoomBy(5,0,0);" data-toggle="tooltip" data-placement="top" title="Shift Right" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-arrow-right"></i></a>
								 <a href="javascript:zoomBy(0,-5,0);" data-toggle="tooltip" data-placement="top" title="Shift Up" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-arrow-up"></i></a>
								 <a href="javascript:zoomBy(0,5,0);" data-toggle="tooltip" data-placement="top" title="Shift Down" class="tools-top btn btn-default" style="padding:9px;"><i class="fa fa-arrow-down"></i></a>
							 </span>
 							 <span id="multitextalign">
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="AlignObjectsLeft" id="alignobjectsleft" class="tools-top btn btn-default" style="padding:9px;"><i><img src="images/btn_alignobjectsleft.png"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="AlignObjectsCenter" id="alignobjectscenter" class="tools-top btn btn-default" style="padding:9px;"><i><img src="images/btn_alignobjectscenter.png"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="AlignObjectsRight" id="alignobjectsright" class="tools-top btn btn-default" style="padding:9px;"><i><img src="images/btn_alignobjectsrigth.png"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="AlignObjectsTop" id="alignobjectstop" class="tools-top btn btn-default" style="padding:9px;"><i><img src="images/btn_alignobjectstop.png"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="AlignObjectsMiddle" id="alignobjectsmiddle" class="tools-top btn btn-default" style="padding:9px;"><i><img src="images/btn_alignobjectsmiddle.png"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="AlignObjectsBottom" id="alignobjectsbottom" class="tools-top btn btn-default" style="padding:9px;"><i><img src="images/btn_alignobjectsbottom.png"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="ObjectsLeft" id="objectsleft" class="tools-top btn btn-default" style="padding:9px;"><i><img src="images/btn_alignobjectsleft.png"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="ObjectsCenter" id="objectscenter" class="tools-top btn btn-default" style="padding:9px;"><i><img src="images/btn_alignobjectscenter.png"></i></a>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="ObjectRight" id="objectsright" class="tools-top btn btn-default" style="padding:9px;"><i><img src="images/btn_alignobjectsrigth.png"></i></a>
                              </span>
					    <!--<ul class="list-inline icons" style="margin-left: 962px;">-->
							<li><a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Undo" id="undo" style="visibility:visible;"><i class="fa fa-rotate-right"></i></a></li>
							<li><a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Redo" id="redo" style="visibility:visible;" ><i class="fa fa-rotate-left"></i></a></li>
							<li class="btn-save"><a href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title="Save" id="saveastemplate" style="visibility:visible;">Save</a></li>
							<!--<li><a href="javascript:void(0);" id="AddImage" style="visibility:visible;">Add-Image</a></li>-->
						<!--</ul>-->
						</ul>

					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="container canvasarea" style="padding: 0;">
			<div class="row">
			<div style="position:relative; z-index:1000; overflow:hidden;" class="clearfix col-xs-6 col-sm-4 col-md-4" id="leftsection">
				<div class="tabs-left">
					<ul class="nav nav-tabs main-nav-tabs">
						<li class=""><a data-toggle="tab" href="#a" aria-expanded="true" id="AddImage"><i class="fa fa-cloud-upload"></i><br>Add Image</a></li>
						<li class="active"><a data-toggle="tab" href="#b" aria-expanded="true"><i class="fa fa-font"></i><br>Text</a></li>
						<li class=""><a data-toggle="tab" href="#c" aria-expanded="true"><i class="fa fa-picture-o"></i><br>Elements</a></li>
						<li class=""><a data-toggle="tab" href="#e" aria-expanded="true"><i class="fa fa-circle"></i><br>Shapes</a></li>
						<li class=""><a data-toggle="tab" href="#d" aria-expanded="true"><i class="fa fa-th"></i><br>Background</a></li>
						<li class=""><a data-toggle="tab" href="#f" aria-expanded="true"><i class="fa fa-cloud-upload"></i><br>Artist Library</a></li>
					</ul>
					<div class="main-tab-content">
						<div id="a" class="main-tab-pane">
							<div id="">
							</div>
						</div>
						<!--<div id="a" class="main-tab-pane">
							<ul class="nav nav-tabs nav-tab-two">
							  <li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-camera"></i></a></li>
							  <li><a data-toggle="tab" href="#menu1"><i class="fa fa-paste"></i></a></li>
							</ul>

							<div class="tab-content tab-content-two">
								<div id="home" class="tab-pane fade in active">
									<ul class="nav nav-tabs nav-tab-btn">
									  <li class="active"><a data-toggle="tab" href="#btn1"><i class="fa fa-cloud-upload"></i></a></li>
									  <li><a data-toggle="tab" href="#btn2"><i class="fa fa-facebook-square"></i></a></li>
									  <li><a data-toggle="tab" href="#btn3"><i class="fa fa-instagram"></i></a></li>
									</ul>
									<div class="tab-content tab-content-btn">
										<div id="btn1" class="tab-pane fade in active">
											<form action="upload.php" class="dropzone">
											</form>
										</div>
										<div id="btn2" class="tab-pane fade">
											<p>&nbsp;

											</p>
											<p class="text-center"><a href="http://facebook.com/"><img src="images/icon-fb.jpg"></a></p>
										</div>
										<div id="btn3" class="tab-pane fade">
											<p>&nbsp;

											</p>
											<p class="text-center"><a href="https://www.instagram.com/accounts/login/"><img src="images/icon-instagram.png"></a></p>
										</div>
									</div>
								</div>
								<div id="menu1" class="tab-pane fade">
									<h3>Menu 1</h3>
									<p>Some content in menu 1.</p>
								</div>
							</div>
						</div>-->
						<div id="b" class="main-tab-pane active">
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
								<select class="form-control" name="textcat-select" id="textcat-select">
									<option value="">Select Category</option>
								</select>
							</div>
							<div id="addtextoptions" class="col-lg-12" style="text-align:center;">
								<div id="addheading" style="font-size:36px; font-weight:900;"><a href="javascript:void(0);" onClick="javascript:addheadingText();" style="color:#000000;">Add heading</a></div>
								<div id="addsubheading" style="font-size:24px; font-weight:bold;"><a href="javascript:void(0);" onClick="javascript:addsubheadingText();" style="color:#000000;">Add subheading</a></div>
								<div id="addsometext" style="font-size:18px; font-weight:bold; margin:5px 0 10px 0;"><a href="javascript:void(0);" onClick="javascript:addText();" style="color:#000000;">Add some regular text</a></div>
							</div>
							<!--<div class="" id="text_container" style="text-align:center;">
							</div>-->
						</div>

								<div id="c" class="main-tab-pane">
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
										<select class="form-control" name="cat-select" id="cat-select">
											<option value="">Select Category</option>
										</select>
									</div>
									<div class="col-lg-12 col-xs-12" id="catimage_container" style="text-align:center;">
									</div>
								</div>
								<div id="e" class="main-tab-pane">
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
													<button id="strokeline" class="btn btn-small btn-primary"><i class="fa fa-paint-brush"></i>
													</button>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12" style='display:inline-flex;'>
													<span class="stroketext">Select Line Stroke Width :</span>
													<select name="" class="form-control" style="width:100px;"  id="storkewidth">
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
								<div id="d" class="main-tab-pane">
									<div class="col-lg-12">
										<div class="dropdown" style="float:left;">
											<button class="btn btn-default dropdown-toggle btn-menu" type="button" id="backgroundMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												<span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
											</button>
											<ul class="dropdown-menu" aria-labelledby="backgroundMenu" style="z-index: 2000;">
												<li><a href="#" id="addBGCategory">New Category</a></li>
												<li><a href="#" id="addBackground">New Background</a></li>
												<li><a href="#" id="deleteBGCategory">Delete Category</a></li>
												<li><a href="#" id="deleteBackground">Delete Background</a></li>
											</ul>
										</div>
										<select class="form-control" name="bgcat-select" id="bgcat-select">
											<option value="">Select Category</option>
										</select>
										<button class="btn btn-default" type="button" id="bgcolorselect">Select Color</button>
									</div></br></br>
									<div class="col-lg-12 col-xs-12" style="text-align:center;">
										<p>
											<label>Background Scale</label>
											<input type="range" min="25" max="100" value="100" id="img-width">
										</p>
									</div>
									<div class="col-lg-12 col-xs-12" id="background_container" style="text-align:center;">
									</div>
								</div>
						<div id="f" class="main-tab-pane">
							<div id="">
								<h1>Artist Library</h1>
							</div>
						</div>
					</div>
		<!-- 			<ul id="sidebar-footer" class="list-unstyled hidden-xs">
						<li><i style="cursor:pointer;" id="btnZoomIn" class="fa fa-plus-circle fa-lg"></i><br>
						<span id="zoomperc">100%</span><br><i style="cursor:pointer;" id="btnZoomOut" class="fa fa-minus-circle fa-lg"></i></li>
					</ul> -->
				</div>
			</div>
			<div id="rightsection" class="col-xs-6 col-sm-8 col-md-8">
				<div class="row">
					<div class="col-xs-12 col-md-8">
						<div class="tab-content" id='canvasbox-tab' style='margin-top:17px; text-align: -webkit-center; display: inline-block;border:1px solid #000000;margin-left: 70px;' align="center">
							<span id='infotext' style='font-size: 10px; opacity: 0.8; position: relative; left: 0px; top: 0px; z-index: 1000;'></span>
							<div id='canvaspages' tabindex="0" style='outline:none;'>
								<div class="page" id='page0'>
								</div>
							</div>
							<!--
								  <div id='divcanvas0' class="divcanvas" onClick='javascript:selectCanvas(this.id);'>
								  </div>
							  -->
							<!--
							<div style="display:none; float:right; margin-top: -240px; margin-right: 112px; color:#ffffff;">
								<i id='duplicatecanvas' class="fa fa-files-o fa-lg duplicatecanvas" style='z-index:1000; cursor:pointer; color:#ffffff;'></i>
								</br>
								</br>
								<i id='deletecanvas' class="fa fa-trash-o fa-lg deletecanvas" style='z-index:1000; cursor:pointer; color:#ffffff;'></i>
							</div>
							<button onClick='javascript:addNewCanvasPage();' id="addnewpagebutton" class="btn" type="button" style="display:none; width:150px; margin:20px 0; padding:10px; border:1px solid #555;"> + Add a New Page</button>-->
							<div style="display:none;">
								<canvas id="outputcanvas" width="750" height="600" class="canvas"></canvas>
							</div>
							<div style="display:none;">
								<canvas id="tempcanvas" width="100" height="100" class="canvas"></canvas>
							</div>
						</div>
						<p class="text-center">Portrait - 95mm x 115mm</p>
					</div>
					<div class="col-xs-12 col-md-3 hidden-xs hidden-sm">
						<img src="labeloutput/output.png" data-zoom-image="labeloutput/output.png" style="min-width:400px;margin-left:-120px;" alt="" class="img-responsive center-block" id='labeloutput'>
						<!--<p class="text-center"><a href="#" class="btn-prev"><img src="images/btn-prev.jpg" alt=""></a> Label Preview <a href="#" class="btn-next"><img src="images/btn-next.jpg" alt=""></a></p>-->
						<p class="text-center" style="margin-left: 10px;"><a href="#" class="btn-prev"></a> Label Preview <a href="#" class="btn-next"></a></p>
					</div>
				</div>

			</div>
		</div>
	</div>
		<!--<div class="container">
			<div class="row">
				<h3>Label 3 <span>of 12</span></h3>
				<div id='label_gallery' class="gallery clearfix">




				</div>

					<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
						<span></span>
						<img src="uploads/user_1/product_1/img11.jpg" alt="" class="img-responsive">
						<p>
							<form id="upload" class="label-upload" action="uploadlabel.php" method="POST" enctype="multipart/form-data" style="margin-bottom: 0px;">
							   <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="1000000" />
							   <label for="labelselect" style="cursor: pointer; font-weight:normal;">Add Image</label>
							   <input id="labelselect" type="file" name="labelselect[]" />
							</form>
							<a href="#">Artist Library</a>
						</p>
					</div>

			</div>

		</div>-->
		<div class="container">
			<div class="row">
				<!--<h3>Label 3 <span>of 12</span></h3>-->
				<div id="labelcontent1">
				</div>
				<div id="label_cont">
				</div>
			</div>
		</div>
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
		<!-- Save Template Modal HTML
		<div id="savetemplate_modal" class="modal fade">
		 <div class="modal-dialog">
			<div class="modal-content modal-content-500">
			   <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
				  <h4 class="modal-title">Save Flyer</h4>
			   </div>
			   <form role="form" name="savetemplateform" id="savetemplateform">
			   <div class="modal-body" style="margin-top:-30px; ">
				  <div class="body">
					 <span><label for="template">Flyer Name :</label>
						   <input type="text" name="templatename" id="templatename" class="form-control" placeholder="Enter Name"></span>
				  </div>
			   </div>
				  <div class="modal-footer clearfix">
					 <button type="submit" class="btn btn-default" >Submit</button>
				  </div>
			   </form>
			</div>
		 </div>
		</div>-->
		<!-- Download Template Modal HTML -->
		<div id="downloadtemplate_modal" class="modal fade">
		 <div class="modal-dialog">
			<div class="modal-content modal-content-500">
			   <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
				  <h4 class="modal-title">Download Flyer</h4>
			   </div>
			   <div class="modal-body" style="margin-top:-30px; ">
				  <div class="body">
					 <span><label for="template">Flyer Name :</label>
						   <input type="text" name="downtemplatename" id="downtemplatename" class="form-control" placeholder="Enter Name"></span>
				  </div>
			   </div>
				  <div class="modal-footer clearfix">
					 <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:downloadTemplateFile();" >Download</button>
				  </div>
			</div>
		 </div>
		</div>
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
						   <input type="text" name="loadCanvasWid" id="loadCanvasWid" class="form-control" placeholder="Enter Width" value='4'>
							  </span></br>
					 <span><label for="template">Canvas height (in inches):</label>
						   <input type="text" name="loadCanvasHei" id="loadCanvasHei" class="form-control" placeholder="Enter Height" value='5'></span>
					 <span><label for="template">Number of Canvas rows</label>
						   <input type="text" name="numOfcanvasrows" id="numOfcanvasrows" class="form-control" value="1"></span>
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
						<div class="form-group image-upload col-lg-3">
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
		<!-- Delete Template Modal HTML -->
		<div id="Del_tempModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content modal-content-400">
					<div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
						</button>
						<h4 class="modal-title">Delete Template</h4>
					</div>
					<div class="modal-body" style="margin-top:-30px; ">
						<div class="body">
							<span>Are you sure you want to delete this template? This cannot be undone.</span>
						</div>
					</div>
					<div class="modal-footer clearfix">
						<button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_tempDelete();">Delete</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>


		<!-- Delete Label Modal HTML -->
		<div id="Del_labelModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content modal-content-400">
					<div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
						</button>
						<h4 class="modal-title">Delete Label</h4>
					</div>
					<div class="modal-body" style="margin-top:-30px; ">
						<div class="body">
							<span>Are you sure you want to delete this Label? This cannot be undone.</span>
						</div>
					</div>
					<div class="modal-footer clearfix">
						<button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_labelDelete();">Delete</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Labels allowed Limit -->
		<div id="Labels_limit" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content modal-content-400">
					<div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
						</button>
						<h4 class="modal-title">Labels allowed Limit</h4>
					</div>
					<div class="modal-body" style="margin-top:-30px; ">
						<div class="body">
							<span>Only 12 Labels are allowed.</span>
						</div>
					</div>
					<div class="modal-footer clearfix">
						<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>
		</div>


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
		<footer>
		</footer>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.elevateZoom-3.0.8.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js"></script>
		<script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/validation-methods.js"></script>
		<script src="js/filedrag.js" type="text/javascript"></script>
		<script src="js/labeldrag.js" type="text/javascript"></script>
		<script src="js/jquery-validate.bootstrap-tooltip.js"></script>
		<script type="text/javascript" src="js/bootstrap-slider.js"></script>
		<script type="text/javascript" src="js/fabric1.6.js"></script>
		<script type="text/javascript" src="js/aligning_guidelines.js"></script>
		<script type="text/javascript" src="js/centering_guidelines.js"></script>
		<script type="text/javascript" src="js/spectrum.js"></script>
		<script type="text/javascript" src="js/fileSaver.min.js"></script>
		<script type="text/javascript" src="js/functions.js" ></script>
		<script type="text/javascript" src="js/canvasevents.js"></script>
		<script type="text/javascript" src="js/dropzone.js"></script>
		<script type="text/javascript" src="//api.filestackapi.com/filestack.js"></script>
		<script type="text/javascript">
			var tempcanvas = new fabric.Canvas('tempcanvas');
			var canvas = new fabric.Canvas('canvas0');
			canvas.rotationCursor = 'url("img/rotatecursor2.png") 10 10, crosshair';
			canvas.backgroundColor = '#ffffff';
			var selectedFont = 'Tinos';
			var fillColor = 'Black';

			// Wait for window load
			$(window).load(function() {
			    getuploadedlabels(true);
			    // Animate loader off screen
			    $("#loadingpage").fadeOut("slow");
			    // $("#canvaswh_modal").modal('show');
			    addCanvasToPage();
			    setCanvasSize();

			    $('.deletecanvas').css('display', 'none');

			});
			var Istempselected = false;
			var Iscatselected = false;
			var IsBgselected = false;
			var IsTextselected = false;
			$(document).ready(function() {
			    $('[data-toggle="tooltip"]').tooltip();
			    $('[data-toggle="dropdown"]').tooltip();
			});
			$(document).ready(function() {
			    $('#labelcontent1').html("<h3>Label 0 <span>of 12</span></h3>");
			    $('#labelcontent2').html("<h2>Wine Label maker <small>Label 0 <span>of 12</span></small></h2>");
			    setTimeout(function() {
			        getTemplates('');
			    }, 250);
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
			    }, 2000);
			    setTimeout(function() {
			        getTexts('');
			    }, 2250);
			    setTimeout(function() {
			        getuploadimages();
			    }, 3000);
				setTimeout(function() {
			      saveTemplate();  
			    }, 250);
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
			    $('#template-select').on('change', function() {
			        getTemplates($(this).val());
			    });
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
			$(document).on("click", ".bgImage", function() {
			    var bgimagepath = $(this).data('imgsrc');
			    setCanvasBg(canvas, bgimagepath);
			    return false;
			});
			$(document).on("click", "#bgImageRemove", function() {
			    deleteCanvasBg(canvas);
			    return false;
			});
			var tempIdToDel = '';
			$(document).on("click", ".deleteTemp", function() {
			    tempIdToDel = $(this).attr('id');
			    $("#Del_tempModal").modal('show');
			});
			/*$("#saveTemplate").click(function() {
				$("#templateSaveModal").modal('show');
			});*/

			$("#publishTemplate").click(function() {
			    $("#publishModal").modal('show');
			});

			$("#colorSelector").spectrum({
			    showAlpha: false,
			    showPalette: true,
			    //maxSelectionSize: 2,
			    preferredFormat: "hex",
			    hideAfterPaletteSelect: true,
			    showInput: true,
			    allowEmpty: true,
			    move: function(color) {
			        var colorVal = '';
			        if (color) {
			            colorVal = color.toHexString(); // #ff0000
			        }
			        changeObjectColor(colorVal);
			        $('#colorSelector').css('background', colorVal);
			    },
			});

			$("#bgcolorselect").spectrum({
			    flat: true,
			    allowEmpty: true,
			    hideAfterPaletteSelect: true,
			    move: function(color) {
			        var colorVal = color.toHexString(); // #ff0000
			        deleteCanvasBg(canvas);
			        setCanvasBg(canvas, false, colorVal);
			    },
			});

			$("#colorStrokeSelector").spectrum({
			    showAlpha: false,
			    showPalette: true,
			    //maxSelectionSize: 2,
			    preferredFormat: "hex",
			    hideAfterPaletteSelect: true,
			    showInput: true,
			    allowEmpty: true,
			    move: function(color) {
			        var colorVal = color.toHexString(); // #ff0000
			        changeStrokeColor(colorVal);
			        $('#colorStrokeSelector').css('backgroundColor', colorVal);
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
			<!-- get Category Images -->
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
			var bgoffset = 0;
			<!-- get Category Images -->
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
			<!-- get Template Images -->
			function getTexts(id) {
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
			                $('#text_container').append(data);
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
			    //$("ul.navbar-nav>li.dropdown").removeClass("open");
			    $("#uploadtemplate_modal").modal('hide');
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
			                openTemplate(e.target.result, true, theFile.name);
			            };
			        })(f);
			        // Read in the image file as a data URL.
			        reader.readAsText(f);
			    }
			}
			//document.getElementById('templateselect').addEventListener('change', handleFileSelect, false);
			$('#templateselect').on('change', handleFileSelect);

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

			$(window).resize(function() {
			    resizeUpCanvas();
			    resizeDownCanvas();
			    $('#rightside').css('margin-left', $(".tabs-left").width() - 25);
			});

			function resizeDownCanvas() {
			    canvasScale = Math.round(canvasScale * 10) / 10;
			    if (Math.round(canvas.width) > (window.innerWidth - $(".tabs-left").width())) {
			        zoomOut();
			        resizeDownCanvas();
			    }
			}

			function resizeUpCanvas() {
			    canvasScale = Math.round(canvasScale * 10) / 10;
			    if (canvasScale < 1 && canvas.width < (window.innerWidth - $(".tabs-left").width())) {
			        zoomIn();
			        resizeUpCanvas();
			    }
			}

			$(document).ready(function() {
			    $('#rightside').css('margin-left', $(".tabs-left").width() - 25);
			});

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
			$(document).on("click", ".addImage", function() {
			    var imgpath = $(this).data('imgsrc');
			    addImage(imgpath);
			    return false;
			});

			function addImage(imgpath) {

			    //alert(imgpath);

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

			            actObj.scaleX = w / actObj.width;
			            actObj.scaleY = h / actObj.height;

			            var ih = img.naturalHeight;
			            var iw = img.naturalWidth;

			            //find the width/height for the aspect ratio.
			            var fw, fh;

			            var width_ratio = w / iw;
			            var height_ratio = h / ih;
			            if (width_ratio > height_ratio) {
			                fw = iw * width_ratio;
			                fh = ih * fw / iw;
			            } else {
			                fh = ih * height_ratio;
			                fw = iw * fh / ih;
			            }

			            if (width_ratio > height_ratio) {
			                actObj.cw = w / width_ratio;
			                actObj.ch = h / width_ratio;
			            } else {
			                actObj.cw = w / height_ratio;
			                actObj.ch = h / height_ratio;
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

			$("#upload_image").click(function() {
			    $('#AdduploadimageModal').modal({
			        show: true
			    })
			});

			$('#AdduploadimageModal').on('shown.bs.modal', function(e) {
			    var $grid = $('#image_container');

			    $grid.imagesLoaded().progress(function() {
			        $grid.isotope('layout');
			        $grid.isotope('reloadItems');
			    });
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

			function getuploadedlabels(loadfirst) {

				//$("#labeloutput").elevateZoom({zoomWindowPosition: 10});

			    $.ajax({
			        type: 'GET',
			        url: './actions/getlabels.php',
			        cache: false,
			        success: function(data) {
			            $('#label_cont').empty();
			            $('#label_cont').append(data);

			            if(loadfirst)
			            $(".labelimg:first").click();

			            $("#loadingpage").fadeOut("slow");

			            $("#AddImage1").click(function() {

			                filepicker.pick({
			                        mimetype: 'image/*'
			                    },
			                    function(Blob) {
			                        console.log(Blob);
			                        var imgurl = Blob.url;
			                        canvas.clear();
			                        canvas.renderAll();
			                        loadedtemplateid = 0;
			                        filepickerimageToCanvas(imgurl);
			                    }
			                );
			            });
			        }
			    });
			}

			$(document).on("click", ".labelImage", function() {

			    var labelimagepath = $(this).data('labelsrc');
			    loadedtemplateid = $(this).data('labelid');
			    loadedlabelid = $(this).data('countid');
			    $('#labelcontent1').html('');
			    $('#labelcontent2').html('');
			    if (loadedlabelid == "") {
			        $('#labelcontent1').html("<h3>Label 0 <span>of 12</span></h3>");
			        $('#labelcontent2').html("<h2>Wine Label maker <small>Label 0 <span>of 12</span></small></h2>");
			    } else if (loadedlabelid == "0") {
			        $('#labelcontent1').html("<h3>Label 0 <span>of 12</span></h3>");
			        $('#labelcontent2').html("<h2>Wine Label maker <small>Label 0 <span>of 12</span></small></h2>");
			    } else {
			        $('#labelcontent1').html("<h3>Label " + loadedlabelid + " <span>of 12</span></h3>");
			        $('#labelcontent2').html("<h2>Wine Label maker <small>Label " + loadedlabelid + " <span>of 12</span></small></h2>");
			    }
			    loadlabel = $(this).data('labelid');
			    canvas.clear();
			    //alert(labelimagepath)
			    //if (labelimagepath.length < 20) {
			        canvas.clear();
			        loadTemplate(loadlabel);

			        var outimg = "timthumb.php?src=labeloutput/output" +  loadlabel + ".png&w=500&h=500&maxw=500&maxh=500";
                    $("#labeloutput").attr("src",outimg);
                    $("#labeloutput").attr("data-zoom-image",outimg);
			    //} else {
			    //    addImage(labelimagepath);
			    //}
			    return false;
			});

			$(document).on("click", ".labelimg", function() {

				$("img").css('border',"");
				$(this).css('border',"5px solid #00aeef");

			    var labelpath = $(this).attr('src');
			    loadedtemplateid = $(this).data('labelid');				
			    loadedlabelid = $(this).data('countid');
			    $('#labelcontent1').html('');
			    $('#labelcontent2').html('');
			    if (loadedlabelid == "") {
			        $('#labelcontent1').html("<h3>Label 0 <span>of 12</span></h3>");
			        $('#labelcontent2').html("<h2>Wine Label maker <small>Label 0 <span>of 12</span></small></h2>");
			    } else if (loadedlabelid == "0") {
			        $('#labelcontent1').html("<h3>Label 0 <span>of 12</span></h3>");
			        $('#labelcontent2').html("<h2>Wine Label maker <small>Label 0 <span>of 12</span></small></h2>");
			    } else {
			        $('#labelcontent1').html("<h3>Label " + loadedlabelid + " <span>of 12</span></h3>");
			        $('#labelcontent2').html("<h2>Wine Label maker <small>Label " + loadedlabelid + " <span>of 12</span></small></h2>");
			    }
			    loadlabel = $(this).data('labelid');
			    canvas.clear();
			    //if (labelpath.indexOf('templates') != -1) {
			        loadTemplate(loadlabel);

			        //var outimg = "labeloutput/output" +  loadlabel + ".png?rand=123";
			        var outimg = "timthumb.php?src=labeloutput/output" +  loadlabel + ".png&w=500&h=500&maxw=500&maxh=500";
                    $("#labeloutput").attr("src",outimg);
                    $("#labeloutput").attr("data-zoom-image",outimg);

			    //} else {
			    //    addImage(labelpath);
			    //}
			    return false;
			});

			$(document).on("click", ".copyimage", function() {
			    var cpyimg = $(this).attr('id');
			    <?php
									$result=mysql_query("SELECT count(*) as total from user_templates");
									$data=mysql_fetch_assoc($result);
									if($data['total']==12 || 12 < $data['total']) {
								?>
			    $("#Labels_limit").modal('show');
			    <?php  } else {	 ?>
			    if (cpyimg != '') {
			        $.post("actions/cpyimage.php", {
			            "id": cpyimg
			        }, function(data) {
			            location.reload();
			        });
			    } else {}
			    <?php  } ?>
			});

			var labelidTodel = '';

			$(document).on("click", ".deleteLabel", function() {
			    var labelid = $(this).data('labelid');
			    labelidTodel = labelid;
			    $("#Del_labelModal").modal('show');
			});

			function proceed_labelDelete() {

			    $.post("actions/deleteLabel.php", {
			        "labelid": labelidTodel
			    }, function(data) {
			        $("#Del_labelModal").modal('hide');
			        getuploadedlabels(true);
			        $('#successMessage').html('Label deleted successfully')
			        $("#successModal").modal('show');
			    });

			}
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
			    } else {}
			}
			(function(a) {
			    if (window.filepicker) {
			        return
			    }
			    var b = a.createElement("script");
			    b.type = "text/javascript";
			    b.async = !0;
			    b.src = ("https:" === a.location.protocol ? "https:" : "http:") + "//api.filestackapi.com/filestack.js";
			    var c = a.getElementsByTagName("script")[0];
			    c.parentNode.insertBefore(b, c);
			    var d = {};
			    d._queue = [];
			    var e = "pick,pickMultiple,pickAndStore,read,write,writeUrl,export,convert,store,storeUrl,remove,stat,setKey,constructWidget,makeDropPane".split(",");
			    var f = function(a, b) {
			        return function() {
			            b.push([a, arguments])
			        }
			    };
			    for (var g = 0; g < e.length; g++) {
			        d[e[g]] = f(e[g], d._queue)
			    }
			    window.filepicker = d
			})(document);

			filepicker.setKey('A5tZAhSs4R9SpoPxFKhIAz');

			$("#AddImage").click(function() {

				$('.iconsdiv').css("zIndex",999);

			    filepicker.pick({
			            mimetype: 'image/*'
			        },
			        function(Blob) {
			            console.log(Blob);
			            var imgurl = Blob.url;
			            filepickerimageToCanvas(imgurl);
			            $('.iconsdiv').css("zIndex",2000);
			        }
			    );
			});
		</script>
	</body>
</html>