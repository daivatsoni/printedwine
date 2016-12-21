function initCanvasEvents(lcanvas) {

    if(lcanvas) canvas = lcanvas;

    var selectedObject;
    var ismodified = false;
    canvas.observe('object:selected', function (e) {
        ismodified = false;
        for (var i = 0, j = 0; i <= canvasindex; i++) {
            $("#canvas" + i).css("box-shadow", "");
        }
        $("#canvas" + currentcanvasid).css("box-shadow", "3px 3px 3px #888888");
        $(".tools-top").css("visibility", "visible");
        if(e.target && e.target.selectable==="false") return;        
        selectedObject = e.target;
        setControlsVisibility(selectedObject);
        if (selectedObject.lockMovementY) {
        	selectedObject.hasControls = false;
        	selectedObject.hoverCursor = 'url("../img/lockcursor.png") 10 10, pointer';
        } else {
        	selectedObject.hasControls = true;
        	selectedObject.hoverCursor = 'pointer';
		}
		$('#storkewidth').val(selectedObject.strokeWidth);
		$('#shapeslider').slider('value', selectedObject.opacity);
		if (selectedObject.type == "rect" || selectedObject.type == "circle" || selectedObject.type == "triangle") {
			$('#strokeline i').css('color', selectedObject.stroke);
			$('#fillshape i').css('color', selectedObject.fill);
            } 

        $("#undo").show();
        $("#redo").show();
        $("#saveastemplate").show();
        if (selectedObject.type == "group") {
            $("#multitextalign").show();
            $(".textelebtns").hide();
            $("#objectalignjustify").hide();
            $("#objectalignleft").hide();
            $("#objectaligncenter").hide();
            $("#objectalignright").hide();
            $("#imagecropOptions").hide();
            $("#replace_image").hide();
        } else if (selectedObject.type == "textbox" || selectedObject.type == "text") {
            $("#multitextalign").hide();
            $(".textelebtns").show();
  			$("#objectalignleft").show().html( "<i class='fa fa-align-left'></i>" );
  			$("#objectaligncenter").show().html( "<i class='fa fa-align-center'></i>" );
  			$("#objectalignright").show().html( "<i class='fa fa-align-right'></i>" );
            $("#objectalignjustify").show().html( "<i class='fa fa-align-justify'></i>" );
            $('#colorSelector').css('backgroundColor', selectedObject.fill);
            selectedObject.selectionColor = 'rgba(0, 123, 240, 0.3)';            
            $('#font-selected').html('<span style="overflow:hidden"><font face="' + selectedObject.fontFamily + '" >' + selectedObject.fontFamily + '</font>&nbsp;&nbsp;<span class="caret"></span></span>')
			
            document.getElementById('fontsize').value = Math.round(selectedObject.fontSize / 1.3);
            document.getElementById('fontsize').focus();
			if (selectedObject.lineHeight != undefined) {
				var newValue = selectedObject.lineHeight;
				$('#changelineheight').slider('setValue', newValue, true);
			}
			selectedObject.setControlsVisibility({
				bl: false,
				br: false,
				tl: false,
				tr: false,
				mt: false,
				mb: false,
			});
        }
		if (selectedObject.type == "rect" || selectedObject.type == "circle" || selectedObject.type == "triangle"|| selectedObject.type == "square") {    
            $("#multitextalign").hide();
            $(".textelebtns").hide();
  			$("#objectalignjustify").hide();
  			$("#objectalignleft").hide();
  			$("#objectaligncenter").hide();
  			$("#objectalignright").hide();
            $("#imagecropOptions").hide();
            $("#replace_image").hide();
            $('#colorSelector').css('backgroundColor', selectedObject.fill);
        }
        $("#dynamiccolorpickers").html('');
        if (selectedObject.type == 'path-group') {
            var colorarray = [];
            var objects = selectedObject.getObjects();
            for (var i = 0; i < objects.length; i++) {
                var colorString = objects[i].fill;
                if(colorString && (typeof colorString === 'string')) {
                    var rgb = colorString.substring(colorString.indexOf('(') + 1, colorString.lastIndexOf(')')).split(/,\s*/);
                    if(rgb && rgb != "") {
                        var red = parseInt(rgb[0]);
                        var green = parseInt(rgb[1]);
                        var blue = parseInt(rgb[2]);
                        hexCode = rgbToHex(red, green, blue);
                        objects[i].fill = hexCode;
                        colorarray.push(hexCode);
                    } else
                    colorarray.push(objects[i].fill);
                }
            }
            colorarray = colorarray.filter(onlyUnique); // returns ['a', 1, 2, '1']
            console.log(colorarray);
            $("#colorSelector").hide();
            var colorpickerhtml = "";
            for (var i = 0; i < colorarray.length; i++) {
                console.log(colorarray[i]);
                colorpickerhtml += "<input type='text' class='dynamiccolorpicker' value='" + colorarray[i] + "' />";
            }
            $("#dynamiccolorpickers").html(colorpickerhtml);
            var objinitcolor = "";
            $(".dynamiccolorpicker").spectrum({
            	hideAfterPaletteSelect: true,
                show: function (color) {
                    objinitcolor = color.toHexString(); // #ff0000
                },
                move: function (color) {
                    var newcolorVal = color.toHexString(); // #ff0000
                    var objects = selectedObject.getObjects();
                    for (var i = 0; i < objects.length; i++) {
                        if (objects[i].fill && objinitcolor.toLowerCase() == objects[i].fill.toString().toLowerCase()) {
                            objects[i].fill = newcolorVal;
                        }
                        if (objects[i].stroke && objinitcolor.toLowerCase() == objects[i].stroke.toString().toLowerCase()) {
                            objects[i].stroke = newcolorVal;
                        }
                    }
                    objinitcolor = newcolorVal;
					canvas.renderAll();
                    saveState();
                }
            });
  			$("#objectalignleft, #objectaligncenter, #objectalignright, #objectalignjustify").hide();
        } else {
            $("#colorSelector").show();
        }
        if (selectedObject.type == "textbox" || selectedObject.type == "text" || selectedObject.type == "path-group") {
            $("#multitextalign").hide();
            $("#imagecropOptions").hide();
            $("#replace_image").hide();
            $("#searchplus").hide();
            $("#searchminus").hide();
            $("#leftarrow").hide();
            $("#rightarrow").hide();
            $("#uparrow").hide();
            $("#downarrow").hide();
        }
		if (selectedObject.type == 'cropzoomimage') {
            $("#multitextalign").hide();
  			$("#objectalignjustify").hide();
			$(".textelebtns").hide();
			$("#colorSelector").hide();
            $("#imagecropOptions").show();
            $("#replace_image").show();
  			$("#objectalignleft, #objectaligncenter, #objectalignright, #objectalignjustify").hide();
        }

        var ito = getinfotextobj();
        if(ito)
            ito.opacity = 0;
        canvas.renderAll();        
    });

    canvas.observe('selection:cleared', function (e) {
        $(".tools-top").css("visibility", "hidden");
        var ito = getinfotextobj();
        if(ito)
            ito.opacity = 0;
        groupselobject = '';        
        $(".custom-menu").hide();
    });
    canvas.observe('object:moving', function (e) {
        $(".tools-top").css("visibility", "hidden");

        if(e.target && e.target.locked) {
            e.target.left = e.target.lockedleft;
            e.target.top = e.target.lockedtop;
            e.target.setCoords();
        }

        e.target.setCoords();
        var ito = getinfotextobj();
        if(ito) {
            ito.text = Math.round(e.target.left / canvasScale) + ", " + Math.round(e.target.top / canvasScale);
            //ito.opacity = 1;
            ito.left = e.target.oCoords.mtr.x - ito.width/2;
            ito.top = e.target.oCoords.mtr.y - ito.height;
            ito.setCoords();
        }
        if(e.target !== 'text') {
            ismodified = true;   
        }
    });
    canvas.observe('object:rotating', function (e) {
        e.target.setCoords();
        var ito = getinfotextobj();
        if(ito) {
            ito.text = Math.round(e.target.angle % 360) + "\u00B0";
            //ito.opacity = 1;
            ito.left = e.target.oCoords.mtr.x - ito.width/2;
            ito.top = e.target.oCoords.mtr.y - ito.height;
            ito.setCoords();
        }
        if(e.target !== 'text') {
            ismodified = true;
        }
    });
    canvas.observe('object:scaling', function (e) {
		//Show font size as object is scaling
        if (selectedObject.type == "textbox" || selectedObject.type == "text") {
			if (e.target) {
				$("#fontsize").val(((e.target.fontSize * e.target.scaleX) / 2 ).toFixed(0));
			}    	
		}
        e.target.setCoords();
        var canheight = document.getElementById("loadCanvasHei").value / 2;
        var ito = getinfotextobj();
        if(ito) {
            ito.text = Math.round(e.target.width * e.target.scaleX / canvasScale) + "px, " + Math.round(e.target.height * e.target.scaleY / canvasScale) + "px";
            //ito.opacity = 1;
            ito.left = e.target.oCoords.mtr.x - ito.width/2;
            ito.top = e.target.oCoords.mtr.y - ito.height;
            ito.setCoords();
        }
        if(e.target !== 'text') {
            ismodified = true;
        }
    });
    canvas.observe('object:modified', function (e) {
        $(".tools-top").css("visibility", "visible");
        console.log(e.target.type)
        console.log(ismodified)
        if(ismodified && e.target.type !== 'text') {
            if(!e.target.recorded) {
                saveState();
                e.target.recorded = true;
            }
            else 
                e.target.recorded = false;
        }
    });
    canvas.observe('text:editing:entered', function(e) {
        $(".tools-top").css("visibility", "hidden");
    });
    $( "body" ).mousedown(function(e) {
        console.log(e.target.nodeName)
        console.log(e.target.className)
        var actobj = canvas.getActiveObject();
        if(!actobj && e.target.nodeName != "LI")
            $(".custom-menu").hide();
        if (e.target.nodeName != 'CANVAS' && e.target.nodeName == 'DIV' && e.target.className != 'sp-preview') {
            canvas.deactivateAllWithDispatch().renderAll();
        	$(".tools-top").css("visibility", "hidden");
        }        
    });
}