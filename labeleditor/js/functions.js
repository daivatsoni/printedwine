var groupselobject;
var canvasScale = 1;
var roundedcanvasScale = 1;
var SCALE_FACTOR = 1.2;
var savestateaction = true;
var currentcanvasid = 0;
var canvasindex = 0;
var pageindex = 0;
var canvasarray = [];
var isdownloadpdf = false;
var issaveastemplate = false;
var isadmintemplate = false;
var totalsvgs = 0;
var convertedsvgs = 0;
var loadedtemplateid = 0;
var loadedlabelid = 0;
var activeObjectCopy, activeGroupCopy;
var keystring = "";
var remstring = "";
var isReplaceImage = false;
var issavetemplate = false;

function addheadingText() {
    var txtBox = new fabric.Textbox("Heading Text", {
        fontFamily: selectedFont,
        fontSize: 36 * 1.3,
        textAlign: "center",
        fill: fillColor,
        scaleX: canvasScale,
        scaleY: canvasScale,
        lineHeight: 1,
        width: 400,
        //height: 100
        //perPixelTargetFind: true,
        //targetFindTolerance: 4 
    });
    canvas.add(txtBox);
    setControlsVisibility(txtBox);
    txtBox.center();
    txtBox.setCoords();
    canvas.calcOffset();
    saveState();
    canvas.renderAll();
}

function addsubheadingText() {
    var txtBox = new fabric.Textbox("Subheading text", {
        fontFamily: selectedFont,
        fontSize: 24 * 1.3,
        textAlign: "center",
        fill: fillColor,
        scaleX: canvasScale,
        scaleY: canvasScale,
        lineHeight: 1,
        width: 350,
        //height: 100
        //perPixelTargetFind: true,
        //targetFindTolerance: 4 
    });
    canvas.add(txtBox);
    setControlsVisibility(txtBox);
    txtBox.center();
    txtBox.setCoords();
    canvas.calcOffset();
    saveState();
    canvas.renderAll();
}

function addText() {
    var txtBox = new fabric.Textbox("Text element", {
        fontFamily: selectedFont,
        fontSize: 12 * 1.3,
        textAlign: "center",
        fill: fillColor,
        scaleX: canvasScale,
        scaleY: canvasScale,
        lineHeight: 1,
        width: 150,
        fontWeight: "normal",
        //height: 60
        //perPixelTargetFind: true,
        //targetFindTolerance: 4 
    });
    canvas.add(txtBox);
    setControlsVisibility(txtBox);
    txtBox.center();
    txtBox.setCoords();
    canvas.calcOffset();
    saveState();
    canvas.renderAll();
}

function saveState() {
    if (savestateaction && canvas.state) {
        var state = canvas.state;
        var index = canvas.index;
        console.log("savestate index" + index)
        state[++index] = JSON.stringify(canvas.toDatalessJSON(['logoid', 'selectable', 'evented', 'id']));
        canvas.state = state;
        canvas.index = index;
    }
};

function addSVGToCanvas(logosvgimg, svgoptions) {
    fabric.loadSVGFromURL(logosvgimg, function(objects, options) {
        var loadedObject = fabric.util.groupSVGElements(objects, options);
        loadedObject.set({
            scaleX: canvasScale,
            scaleY: canvasScale
                //perPixelTargetFind: true,
                //targetFindTolerance: 4 
        });
        var objects = loadedObject.getObjects()
        loadedObject.src = logosvgimg;
        canvas.add(loadedObject);
        loadedObject.center();
        if (svgoptions) {
            loadedObject.left = svgoptions.left;
            loadedObject.top = svgoptions.top;
            loadedObject.scaleX = svgoptions.scaleX;
            loadedObject.scaleY = svgoptions.scaleY;
            loadedObject.angle = svgoptions.angle;
            loadedObject.flipX = svgoptions.flipX;
            loadedObject.flipY = svgoptions.flipY;
        }
        loadedObject.setCoords();
        saveState();
        loadedObject.hasRotatingPoint = true;
        canvas.renderAll();
    });
}

function addUploadedSVGToCanvas(svgimg) {
    var svgImgPath = "./uploads/" + svgimg;
    fabric.loadSVGFromURL(svgImgPath, function(objects, options) {
        var loadedObject = fabric.util.groupSVGElements(objects, options);
        loadedObject.set({
            left: 200,
            top: 200,
            scaleX: canvasScale,
            scaleY: canvasScale
                //perPixelTargetFind: true,
                //targetFindTolerance: 4 
        });
        loadedObject.src = svgImgPath;
        canvas.add(loadedObject);
        loadedObject.center();
        loadedObject.setCoords();
        saveState();
        loadedObject.hasRotatingPoint = true;
        canvas.renderAll();
    });
}

function setControlsVisibility(object) {
    object.setControlsVisibility({
        tl: true, // top left
        tr: true, // top right
        bl: true, // bottom left
        br: true, // bottom right
        mt: true, // middle top disable
        mb: true, // midle bottom disable
        ml: true, // middle left disable
        mr: true, // middle right disable
    });
    object.hasControls = true;
}

function addCanvasToPage(dupflag, pageid, jsonarray) {
    var rows = document.getElementById("numOfcanvasrows").value,
        cols = document.getElementById("numOfcanvascols").value;
    $('.deletecanvas').css('display', 'block');
    var rc = parseInt(rows) * parseInt(cols) * parseInt(pageid);
    var dupcount = 0;
    var jsonarrcount = 1;
    for (var i = 1; i <= rows; i++) {
        $("#page" + pageindex).append("<table><tr>");
        for (var j = 1; j <= cols; j++) {
            addNewCanvas();
            if (dupflag) {
                var currentcanvasjson = canvasarray[rc + dupcount].toDatalessJSON();
                canvas.loadFromDatalessJSON(currentcanvasjson);
                canvas.renderAll();
                dupcount++;
            }
        }
        $("#page" + pageindex).append("</tr></table>");
    }
    var dupcanvicon = $("#duplicatecanvas").clone(true).prop('id', 'duplicatecanvas' + pageindex);
    var delcanvicon = $("#deletecanvas").clone(true).prop('id', 'deletecanvas' + pageindex);
    dupcanvicon.appendTo("#page" + pageindex);
    delcanvicon.appendTo("#page" + pageindex);
    adjustIconPos(pageindex);
    $("#addnewpagebutton").show();
}

function setCanvasSize() {
    var width = document.getElementById("loadCanvasWid").value,
        height = document.getElementById("loadCanvasHei").value;

    //inch to pixel
    width = width * 96;
    height = height * 96;

    setCanvasWidthHeight(width, height);
    adjustIconPos(pageindex);
    $("#canvaswh_modal").modal('hide');
    $('.deletecanvas').css('display', 'none');

    resizeUpCanvas();
    resizeDownCanvas();
}

function addFileToCanvas(imagefile) {
    $("#loadingpage").fadeOut("slow");

    var actObj = canvas.getActiveObject();
    if (isReplaceImage && actObj && actObj.type == 'cropzoomimage') {
        //replace image
        var img = new Image();
        img.onload = function() {
            var w = actObj.width;
            var h = actObj.height;
            actObj.setElement(img);
            actObj.setWidth(w);
            actObj.setHeight(h);

            $("#spinnerModal").modal('hide');
            $("#AdduploadimageModal").modal('hide');
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

function filepickerimageToCanvas(imgurl) {
    $("#loadingpage").fadeOut("slow");
    fabric.util.loadImage(imgurl, function(img) {
        var object = new fabric.Cropzoomimage(img, {
            left: canvas.getWidth() / 2,
            top: canvas.getHeight() / 2,
            scaleX: canvasScale / 2,
            scaleY: canvasScale / 2
        });
        object.src = imgurl;
        canvas.add(object);
        canvas.setActiveObject(object);
        object.center();
        object.setCoords();
        setControlsVisibility(object);

        $("#spinnerModal").modal('hide');

        canvas.renderAll();
        saveState();
    }, null, {
        crossOrigin: 'Anonymous'
    });
}

function setCanvasBg(lcanvas, bgsrc, bgcolor, scalex) {
    if (!scalex)
        $('#img-width').val(100);

    deleteCanvasBg(lcanvas);
    if (bgcolor) {
        var bg = new fabric.Rect({
            originX: "center",
            originY: "center",
            strokeWidth: 1,
            fill: bgcolor,
            opacity: 1,
            selectable: false,
            width: canvas.getWidth(),
            height: canvas.getHeight()
        });
        lcanvas.add(bg);
        bg.center();
        canvas.sendToBack(bg);
        lcanvas.bgcolor = bgcolor;
        bg.bg = true;
        saveState();
    }
    if (bgsrc) {
        if (!scalex) scalex = 1;
        var img = new Image();
        img.onload = function() {
            var imgwidth = this.width * scalex;
            var imgheight = this.height * scalex;
            for (var left = imgwidth / 2; left < (canvas.width + (imgwidth / 2)); left += imgwidth) {
                for (var top = imgheight / 2; top < (canvas.height + (imgheight / 2)); top += imgheight) {
                    (function(leftpos, toppos) {
                        fabric.util.loadImage(bgsrc, function(img) {
                            var bg = new fabric.Image(img);
                            bg.set({
                                originX: 'center',
                                originY: 'center',
                                opacity: 1,
                                selectable: false,
                                hasBorders: false,
                                hasControls: false,
                                hasCorners: false,
                                width: img.width * scalex,
                                height: img.height * scalex,
                                left: leftpos,
                                top: toppos
                            });
                            lcanvas.add(bg);
                            canvas.sendToBack(bg);
                            lcanvas.bgsrc = bgsrc;
                            bg.bg = true;
                            saveState();
                        });
                    })(left, top);
                }
            }

        };
        img.src = bgsrc;
    }
}

function deleteCanvasBg(lcanvas) {

    var objects = canvas.getObjects().filter(function(o) {
        return o.bg == true;
    });

    for (var i = 0; i < objects.length; i++) {
        canvas.remove(objects[i]);
    }
    canvas.bgsrc = "";
    canvas.bgcolor = "";
    saveState();
}

var bgscale;
$('#img-width').on("change", function() {

    if (this.value == bgscale) return;
    bgscale = this.value;

    bgsrc = canvas.bgsrc;

    deleteCanvasBg();

    console.log(this.value);

    setCanvasBg(canvas, bgsrc, false, this.value / 100);
});

function setStyle(object, styleName, value) {
    if (!object) return;
    if (object.styles) {
        var styles = object.styles;
        for (var row in styles) {
            for (var char in styles[row]) {
                if (styleName in styles[row][char]) {
                    delete styles[row][char][styleName];
                }
            }
        }
    }

    object.set(styleName, value).setCoords();
    canvas.renderAll();
    saveState();
}

var fontBoldValue = "normal";
var fontBoldSwitch = document.getElementById('fontbold');
if (fontBoldSwitch) {
    fontBoldSwitch.onclick = function() {
        fontBoldValue = (fontBoldValue == "normal") ? "bold" : "normal";
        var activeObject = canvas.getActiveObject();
        if (activeObject && /text/.test(activeObject.type)) {
            setStyle(activeObject, 'fontWeight', fontBoldValue);
            canvas.renderAll();
        }
    };
}
var fontItalicValue = "normal";
var fontItalicSwitch = document.getElementById('fontitalic');
if (fontItalicSwitch) {
    fontItalicSwitch.onclick = function() {
        fontItalicValue = (fontItalicValue == "normal") ? "italic" : "normal";
        var activeObject = canvas.getActiveObject();
        if (activeObject && /text/.test(activeObject.type)) {
            setStyle(activeObject, 'fontStyle', fontItalicValue);
            canvas.renderAll();
        }
    };
}
var fontUnderlineValue = "normal";
var fontUnderlineSwitch = document.getElementById('fontunderline');
if (fontUnderlineSwitch) {
    fontUnderlineSwitch.onclick = function() {
        fontUnderlineValue = (fontUnderlineValue == "normal") ? "underline" : "normal";
        var activeObject = canvas.getActiveObject();
        if (activeObject && /text/.test(activeObject.type)) {
            setStyle(activeObject, 'textDecoration', fontUnderlineValue);
            canvas.renderAll();
        }
    };
}
var fontSizeSwitch = document.getElementById('fontsize');
if (fontSizeSwitch) {
    fontSizeSwitch.onchange = function() {
        // Fontsize min/max is 6pt/200pt
        if (this.value > 200) this.value = 200;
        if (this.value < 6) this.value = 6;
        var fontsize = Math.round(this.value.toLowerCase() * 1.3);
        var activeObject = canvas.getActiveObject();
        if (activeObject && /text/.test(activeObject.type)) {
            setStyle(activeObject, 'fontSize', fontsize);
            activeobject.setCoords();
            canvas.renderAll();
        }
    };
}
//Font line height
var ChangeLineHeight = function() {
    var activeObject = canvas.getActiveObject();
    setStyle(activeObject, 'lineHeight', clh.getValue());
    canvas.renderAll();
    saveState();
};
var clh = $("#changelineheight").slider().on('slide', ChangeLineHeight).data('slider');
var deleteitembtn = document.getElementById('deleteitem');
if (deleteitembtn) {
    deleteitembtn.onclick = function() {
        deleteItem();
    }
}

function deleteItem() {
    var activeObject = canvas.getActiveObject();
    if (!activeObject) activeObject = canvas.getActiveGroup();
    if (!activeObject) return;
    if (activeObject.type == "group") {
        activeObject.forEachObject(function(object) {
            canvas.remove(object);
        });
    } else {
        canvas.remove(activeObject);
    }
    canvas.deactivateAllWithDispatch().renderAll();
    saveState();
}
var objectalignleftSwitch = document.getElementById('objectalignleft');
if (objectalignleftSwitch) {
    objectalignleftSwitch.onclick = function() {
        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = -(activeGroup.width * activeGroup.scaleX) / 2 + (object.width * object.scaleX) / 2;
                object.originX = 'center';
                if (object && /textbox/.test(object.type)) {
                    setStyle(object, 'textAlign', "left");
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectalignrightSwitch.click();
        } else if (activeObject) {
            if (activeObject && /textbox/.test(activeObject.type)) {
                setStyle(activeObject, 'textAlign', "left");
                canvas.renderAll();
            }
        }
    };
}
var objectaligncenterSwitch = document.getElementById('objectaligncenter');
if (objectaligncenterSwitch) {
    objectaligncenterSwitch.onclick = function() {
        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = 0;
                object.originX = 'center';
                if (object && /textbox/.test(object.type)) {
                    setStyle(object, 'textAlign', "center");
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectaligncenterSwitch.click();
            objectaligncenterSwitch.click();
        } else if (activeObject) {
            if (activeObject && /textbox/.test(activeObject.type)) {
                setStyle(activeObject, 'textAlign', "center");
                canvas.renderAll();
            }
        }
    };
}
var objectalignrightSwitch = document.getElementById('objectalignright');
if (objectalignrightSwitch) {
    objectalignrightSwitch.onclick = function() {
        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = activeGroup.width / 2 - (object.width * object.scaleX) / 2;
                object.originX = 'center';
                if (object && /textbox/.test(object.type)) {
                    setStyle(object, 'textAlign', "right");
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectalignleftSwitch.click();
        } else if (activeObject) {
            if (activeObject && /textbox/.test(activeObject.type)) {
                setStyle(activeObject, 'textAlign', "right");
                canvas.renderAll();
            }
        }
    };
}
var horizcenterIndentSwitch = document.getElementById('horizcenterindent');
if (horizcenterIndentSwitch) {
    horizcenterIndentSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                originX: 'center',
                originY: 'center',
                top: activeGroup.top
            });
            canvas._activeObject = null;
            canvas.setActiveGroup(group.setCoords()).renderAll();
            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectH(activeGroup);
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerH();
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var verticenterIndentSwitch = document.getElementById('verticenterindent');
if (verticenterIndentSwitch) {
    verticenterIndentSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                originX: 'center',
                originY: 'center',
                left: activeGroup.left
            });
            canvas._activeObject = null;
            canvas.setActiveGroup(group.setCoords()).renderAll();
            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectV(activeGroup);
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerV();
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var leftIndentSwitch = document.getElementById('leftindent');
if (leftIndentSwitch) {
    leftIndentSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                originX: 'center',
                originY: 'center',
                top: activeGroup.top
            });
            canvas._activeObject = null;
            canvas.setActiveGroup(group.setCoords()).renderAll();
            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectH(activeGroup);
            activeGroup.left = activeGroup.width / 2 * activeGroup.scaleX + (12 * canvasScale);
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerH();
            activeObject.setCoords();
            activeObject.originX = 'left';
            // left/right object align should leave 1mm space to the outer edges of the label
            // 1mm = 6px approx;
            activeObject.left = (12 * canvasScale);
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var rightIndentSwitch = document.getElementById('rightindent');
if (rightIndentSwitch) {
    rightIndentSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                originX: 'center',
                originY: 'center',
                top: activeGroup.top
            });
            canvas._activeObject = null;
            canvas.setActiveGroup(group.setCoords()).renderAll();
            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectH(activeGroup);
            activeGroup.left = canvas.width - (activeGroup.width / 2 * activeGroup.scaleX) - (12 * canvasScale);
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerH();
            activeObject.setCoords();
            activeObject.originX = 'left';
            activeObject.left = canvas.width - (activeObject.width * activeObject.scaleX) - (12 * canvasScale);
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}


var undoSwitch = document.getElementById('undo');
if (undoSwitch) {
    undoSwitch.onclick = function() {
        savestateaction = false;
        var index = canvas.index;
        var state = canvas.state;
        index--;
        if (index <= 0) {
            index = 0;
            canvas.index = index;
            if (!state[index]) {
                return;
            }
            var json = jQuery.parseJSON(state[index]).objects;
            json = '{"objects":' + JSON.stringify(json) + ',"background":""}';
            canvas.loadFromDatalessJSON(json, canvas.renderAll.bind(canvas));
            return;
        }
        canvas.index = index;
        if (!state[index]) {
            return;
        }
        var json = jQuery.parseJSON(state[index]).objects;
        json = '{"objects":' + JSON.stringify(json) + ',"background":""}';
        canvas.loadFromDatalessJSON(json, canvas.renderAll.bind(canvas));
        savestateaction = true;
        canvas.renderAll();
    };
}
var redoSwitch = document.getElementById('redo');
if (redoSwitch) {
    redoSwitch.onclick = function() {
        var index = canvas.index;
        var state = canvas.state;
        savestateaction = false;
        index++;
        if (index >= state.length - 1) {
            index = state.length - 1;
            canvas.index = index;
            if (!state[index]) {
                return;
            }
            var json = jQuery.parseJSON(state[index]).objects;
            json = '{"objects":' + JSON.stringify(json) + ',"background":""}';
            canvas.loadFromDatalessJSON(json, canvas.renderAll.bind(canvas));
            return;
        }
        canvas.index = index;
        if (!state[index]) {
            return;
        }
        var json = jQuery.parseJSON(state[index]).objects;
        json = '{"objects":' + JSON.stringify(json) + ',"background":""}';
        canvas.loadFromDatalessJSON(json, canvas.renderAll.bind(canvas));
        savestateaction = true;
    };
}

function changeObjectColor(hex) {
    var obj = canvas.getActiveObject();
    if (obj) {
        if (groupselobject) groupselobject.setFill(hex);
        else if (obj.paths) {
            for (var i = 0; i < obj.paths.length; i++) {
                obj.paths[i].setFill(hex);
            }
        } else if (obj.type == "rect" || obj.type == "circle" || obj.type == "triangle" || obj.type == "square") {
            obj.setFill(hex);
            obj.setStroke(hex);
        } else obj.setFill(hex);
    }
    var grpobjs = canvas.getActiveGroup();
    if (grpobjs) {
        grpobjs.forEachObject(function(object) {
            if (object.paths) {
                for (var i = 0; i < object.paths.length; i++) {
                    object.paths[i].setFill(hex);
                }
            } else object.setFill(hex);
        });
    }
    canvas.renderAll();
    saveState();
}

function changeStrokeColor(hex) {
    var obj = canvas.getActiveObject();
    if (obj) {
        if (groupselobject) groupselobject.setStroke(hex);
        else if (obj.paths) {
            for (var i = 0; i < obj.paths.length; i++) {
                obj.paths[i].setStroke(hex);
            }
        } else obj.setStroke(hex);
    }
    var grpobjs = canvas.getActiveGroup();
    if (grpobjs) {
        grpobjs.forEachObject(function(object) {

            if (object.paths) {
                for (var i = 0; i < object.paths.length; i++) {
                    object.paths[i].setStroke(hex);
                }
            } else object.setStroke(hex);
        });
    }
    canvas.renderAll();
    saveState();
}

function setCanvasWidthHeight(width, height) {
    if (width) {
        //if (canvasScale == 1)
        //$("#productWidth").html(Math.round((width * 2.54 / 300) * 10));
        for (var i = 0, j = 0; i <= canvasindex; i++) {
            if (!canvasarray[i]) continue;
            canvasarray[i].width = width;
            var canvasDOM = document.getElementById('canvas' + i);
            canvasDOM.style.width = width / 1.2 + "px";
            canvasDOM.width = width;
            var elem = document.getElementsByClassName('upper-canvas')[i];
            elem.style.width = width / 1.2 + "px";
            elem.width = width;
            var elem = document.getElementsByClassName('canvas-container')[i];
            elem.style.width = width / 1.2 + "px";
            elem.width = width;
            var elem = document.getElementsByClassName('canvascontent')[i];
            elem.style.width = width / 1.2 + "px";
            elem.width = width;
            var elem = document.getElementById('divcanvas' + i);
            elem.style.width = width / 1.2 + "px";
            elem.width = width;
            j++;
            canvasarray[i].calcOffset();
            canvasarray[i].renderAll();
        }
    }
    if (height) {
        //if (canvasScale == 1)
        //$("#productHeight").html(Math.round((height * 2.54 / 300) * 10));
        for (var i = 0, j = 0; i <= canvasindex; i++) {
            if (!canvasarray[i]) continue;
            canvasarray[i].height = height;
            var canvasDOM = document.getElementById('canvas' + i);
            canvasDOM.style.height = height / 1.2 + "px";
            canvasDOM.height = height;
            var elem = document.getElementsByClassName('upper-canvas')[i];
            elem.style.height = height / 1.2 + "px";
            elem.height = height;
            var elem = document.getElementsByClassName('canvas-container')[i];
            elem.style.height = height / 1.2 + "px";
            elem.height = height;
            var elem = document.getElementsByClassName('canvascontent')[i];
            elem.style.height = height / 1.2 + "px";
            elem.height = height;
            var elem = document.getElementById('divcanvas' + i);
            elem.style.height = height / 1.2 + "px";
            elem.height = height;
            j++;
            canvasarray[i].calcOffset();
            canvasarray[i].renderAll();
        }
    }
    canvas.calcOffset();
    canvas.renderAll();
    $("#canvaswidth").val('');
    $("#canvaswidth").val(Math.round(canvas.getWidth()));
    $("#canvasheight").val('');
    $("#canvasheight").val(Math.round(canvas.getHeight()));
}
// button Zoom In
$("#btnZoomIn").click(function() {
    zoomIn();
    for (var i = 0; i <= pageindex; i++) {
        adjustIconPos(i);
    }
    initCenteringGuidelines(canvas);
});
// button Zoom Out
$("#btnZoomOut").click(function() {
    zoomOut();
    for (var i = 0; i <= pageindex; i++) {
        adjustIconPos(i);
    }
    initCenteringGuidelines(canvas);
});
// Zoom In
function zoomIn() {
    // Set max zoom at 500%
    if (canvasScale * SCALE_FACTOR > 5) {
        $("#zoomperc").html(Math.round(5 * 100) + '%');
        return;
    }
    canvas.deactivateAllWithDispatch().renderAll();
    canvasScale = canvasScale * SCALE_FACTOR;
    setCanvasWidthHeight(canvas.getWidth() * SCALE_FACTOR, canvas.getHeight() * SCALE_FACTOR);
    for (var j = 0; j < canvasindex; j++) {
        if (!canvasarray[j]) continue;
        var objects = canvasarray[j].getObjects();
        for (var i in objects) {
            var scaleX = objects[i].scaleX;
            var scaleY = objects[i].scaleY;
            var left = objects[i].left;
            var top = objects[i].top;
            var tempScaleX = scaleX * SCALE_FACTOR;
            var tempScaleY = scaleY * SCALE_FACTOR;
            var tempLeft = left * SCALE_FACTOR;
            var tempTop = top * SCALE_FACTOR;
            objects[i].scaleX = tempScaleX;
            objects[i].scaleY = tempScaleY;
            objects[i].left = tempLeft;
            objects[i].top = tempTop;
            objects[i].setCoords();
        }
        canvasarray[j].renderAll();
    }
    $("#zoomperc").html('');
    $("#zoomperc").html(Math.round(canvasScale * 100) + '%');
}
// Reset Zoom
function resetZoom() {
    setCanvasWidthHeight(canvas.getWidth() * (1 / canvasScale), canvas.getHeight() * (1 / canvasScale));
    for (var j = 0; j < canvasindex; j++) {
        if (!canvasarray[j]) continue;
        var objects = canvasarray[j].getObjects();
        for (var i in objects) {
            var scaleX = objects[i].scaleX;
            var scaleY = objects[i].scaleY;
            var left = objects[i].left;
            var top = objects[i].top;
            var tempScaleX = scaleX * (1 / canvasScale);
            var tempScaleY = scaleY * (1 / canvasScale);
            var tempLeft = left * (1 / canvasScale);
            var tempTop = top * (1 / canvasScale);
            objects[i].scaleX = tempScaleX;
            objects[i].scaleY = tempScaleY;
            objects[i].left = tempLeft;
            objects[i].top = tempTop;
            objects[i].setCoords();
        }
        canvasarray[j].renderAll();
    }
    canvasScale = 1;
    $("#zoomperc").html('');
    $("#zoomperc").html(Math.round(canvasScale * 100) + '%');
    initCenteringGuidelines(canvas);
}
// Zoom Out
function zoomOut() {
    canvas.deactivateAllWithDispatch().renderAll();
    canvasScale = canvasScale / SCALE_FACTOR;
    setCanvasWidthHeight(canvas.getWidth() * (1 / SCALE_FACTOR), canvas.getHeight() * (1 / SCALE_FACTOR));
    for (var j = 0; j < canvasindex; j++) {
        if (!canvasarray[j]) continue;
        var objects = canvasarray[j].getObjects();
        for (var i in objects) {
            var scaleX = objects[i].scaleX;
            var scaleY = objects[i].scaleY;
            var left = objects[i].left;
            var top = objects[i].top;
            var tempScaleX = scaleX * (1 / SCALE_FACTOR);
            var tempScaleY = scaleY * (1 / SCALE_FACTOR);
            var tempLeft = left * (1 / SCALE_FACTOR);
            var tempTop = top * (1 / SCALE_FACTOR);
            objects[i].scaleX = tempScaleX;
            objects[i].scaleY = tempScaleY;
            objects[i].left = tempLeft;
            objects[i].top = tempTop;
            objects[i].setCoords();
        }
        canvasarray[j].renderAll();
    }
    $("#zoomperc").html('');
    $("#zoomperc").html(Math.round(canvasScale * 100) + '%');
}

$("#savetemplate").click(function() {
    issavetemplate = true;

    if (loadedtemplateid == 0)
        $('#saveflyer_modal').modal('show');
    else {
        resetZoom();
        canvas.deactivateAllWithDispatch().renderAll();
        $("#spinnerModal").modal('show');
        saveTemplate();
    }
});

<!-- Save as Template  form validate -->
/*$(document).ready(function() {
    $('#savetemplateform').validate({
        rules: {
            templatename: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) {
            proceed_savetemplate();
        }
    });
});*/
<!-- Save flyer form validate -->
$(document).ready(function() {
    $('#saveflyerform').validate({
        rules: {
            flyername: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) {
            proceed_savetemplate();
        }
    });
});

$("#saveastemplate").click(function() {
    issaveastemplate = true;
    $('#templateSaveModal').modal('hide');
    // $('#savetemplate_modal').modal('show');
    proceed_savetemplate();
});
$("#loadastemplate").click(function() {
    $.post(
        'editloadimage.php',
        $(this).serialize(),
        function(data) {
            alert("Your ID: " + data);
            //loadTemplate(data);
        }
    );
});

function downloadAsJPEG() {
    downloadImage();
}

function downloadAsPDF() {
    $("#spinnerModal").modal('show');
    isdownloadpdf = true;
    resetZoom();
    downloadPdf();
}

function savetextfromselection() {
    var actobj = canvas.getActiveObject();
    var actgroupobjs = canvas.getActiveGroup();
    if (actobj && actobj.type == 'textbox') {
        var clone = actobj.clone();
        var jsonData = JSON.stringify(clone.toJSON());
        var pngdataURL = clone.toDataURL("image/png");
        //window.open(pngdataURL);
        console.log(jsonData);
        var path = "uploads/savetext/";
        var filename = $('#textname').val();
        var categoryId = $('#text_category option:selected').val();
        $.ajax({
            type: 'POST',
            url: 'savetext.php',
            data: {
                path: path,
                pngimageData: pngdataURL,
                filename: filename,
                category: categoryId,
                jsonData: jsonData
            },
            success: function(msg) {
                getTexts('');
            }
        })
    } else if (actgroupobjs) {
        var jsonData = "";
        var objects = actgroupobjs.getObjects();
        jsonData += JSON.stringify(actgroupobjs.toJSON());
        var pngdataURL = actgroupobjs.toDataURL("image/png");
        //window.open(pngdataURL);
        console.log(jsonData);
        var path = "uploads/savetext/";
        var filename = $('#textname').val();
        var categoryId = $('#text_category option:selected').val();
        $.ajax({
            type: 'POST',
            url: 'savetext.php',
            data: {
                path: path,
                pngimageData: pngdataURL,
                filename: filename,
                category: categoryId,
                jsonData: jsonData
            },
            success: function(msg) {
                getTexts('');
            }
        })
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Text object, you wish to save.');
    }
}

function saveelementsfromselection() {
    var actobj = canvas.getActiveObject();
    var actgroupobjs = canvas.getActiveGroup();
    tempcanvas.clear();
    if (actobj) {
        if (fabric.util.getKlass(actobj.type).async) {
            actobj.clone(function(clone) {
                tempcanvas.width = clone.width * clone.scaleX;
                tempcanvas.height = clone.height * clone.scaleY;
                clone.originX = 'center';
                clone.originY = 'center';
                tempcanvas.add(clone);
                clone.center();
                var svgData = tempcanvas.toSVG();
                var jsonData = JSON.stringify(clone.toJSON());
                saveassvg(svgData, jsonData);
            });
        } else {
            var clone = actobj.clone();
            tempcanvas.width = clone.width * clone.scaleX;
            tempcanvas.height = clone.height * clone.scaleY;
            clone.originX = 'center';
            clone.originY = 'center';
            tempcanvas.add(clone);
            clone.center();
            var svgData = tempcanvas.toSVG();
            var jsonData = JSON.stringify(clone.toJSON());
            saveassvg(svgData, jsonData);
        }
    } else if (actgroupobjs) {
        tempcanvas.width = actgroupobjs.width * actgroupobjs.scaleX;
        tempcanvas.height = actgroupobjs.height * actgroupobjs.scaleY;
        var totalobjs = actgroupobjs.getObjects().length;
        var loadedobjs = 0;
        var jsonData = "";
        actgroupobjs.forEachObject(function(object) {
            if (fabric.util.getKlass(object.type).async) {
                object.clone(function(clone) {
                    tempcanvas.add(clone);
                    clone.setLeft(clone.left + tempcanvas.width / 2);
                    clone.setTop(clone.top + tempcanvas.height / 2);
                    loadedobjs++;
                    if (loadedobjs >= totalobjs) {
                        var svgData = tempcanvas.toSVG();
                        var objects = actgroupobjs.getObjects();
                        jsonData += JSON.stringify(actgroupobjs.toJSON());
                        saveassvg(svgData, jsonData);
                    }
                });
            } else {
                var clone = object.clone();
                tempcanvas.add(clone);
                clone.setLeft(clone.left + tempcanvas.width / 2);
                clone.setTop(clone.top + tempcanvas.height / 2);
                loadedobjs++;
                if (loadedobjs >= totalobjs) {
                    var svgData = tempcanvas.toSVG();
                    var objects = actgroupobjs.getObjects();
                    jsonData += JSON.stringify(actgroupobjs.toJSON());
                    saveassvg(svgData, jsonData);
                }
            }
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the object, you wish to save.');
    }
}

function saveassvg(svgData, jsonData) {
    console.log(jsonData)
    var filename = $('#elmtname').val();
    var categoryId = $('#elmt_category option:selected').val();
    var path = "uploads/";
    //lsvgobj.visible = path + filename + '.svg';
    $.ajax({
        type: 'POST',
        url: 'saveassvg.php',
        data: {
            path: path,
            filename: filename,
            svgData: svgData,
            jsonData: jsonData,
            category: categoryId,
        },
        success: function(msg) {
            getcatimages('');
        }
    })
}

function proceed_savetemplate() {
    resetZoom();
    canvas.deactivateAllWithDispatch().renderAll();
    $("#spinnerModal").modal('show');
    if (issaveastemplate) saveTemplate();
    /* if (issaveastemplate) saveAsTemplate();
     if (issavetemplate) saveTemplate(); */
}

function downloadImage() {
    resetZoom();
    $('#publishModal').modal('hide');
    $("#spinnerModal").modal('show');
    var cwidth = document.getElementById("loadCanvasWid").value;
    var cheight = document.getElementById("loadCanvasHei").value;
    var cols = document.getElementById("numOfcanvascols").value;
    var rows = document.getElementById("numOfcanvasrows").value;

    //inch to pixel
    cwidth = cwidth * 96;
    cheight = cheight * 96;

    var buffer = document.getElementById("outputcanvas");
    var buffer_context = buffer.getContext("2d");
    buffer.width = parseInt(cwidth) * parseInt(cols);
    var hiddencanvascount = parseInt(cols) * parseInt(rows) * (pageindex + 1) - $(".divcanvas:visible").length;
    buffer.height = parseInt(cheight) * ((parseInt(rows) * (pageindex + 1)) - hiddencanvascount / parseInt(cols));

    var h = 0;
    var writtenpages = 0;
    var processpages = 0;
    var rowcount = 0;
    var colcount = 0;
    for (var i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;

        hideshowobjects(canvasarray[i], false);

        canvasarray[i].deactivateAll().renderAll();
        var ito = getinfotextobj(canvasarray[i]);
        if (ito) ito.opacity = 0;
        if ($("#divcanvas" + i).is(":visible")) {
            processpages++;
            if (colcount >= cols) {
                colcount = 0;
                rowcount++;
            }
            w = cwidth * colcount;
            h = cheight * rowcount;
            colcount++;
            (function(li, c, r) {
                var img = new Image();
                img.onload = function() {
                    buffer_context.drawImage(this, c, r);
                    writtenpages++;
                    if (writtenpages == processpages) {

                        var canvasele = document.getElementById("outputcanvas");
                        var currentTime = new Date();
                        var month = currentTime.getMonth() + 1;
                        var day = currentTime.getDate();
                        var year = currentTime.getFullYear();
                        var hours = currentTime.getHours();
                        var minutes = currentTime.getMinutes();
                        var seconds = currentTime.getSeconds();
                        var filename = month + '' + day + '' + year + '' + hours + '' + minutes + '' + seconds + ".png";

                        // draw to canvas...
                        canvasele.toBlob(function(blob) {
                            saveAs(blob, filename);
                            $('#spinnerModal').modal('hide');
                            hideshowobjects(canvasarray[li], true);
                        });
                    }
                };
                img.src = canvasarray[li].toDataURL("image/png");
            })(i, w, h);
        }
    }
}

function hideshowobjects(lcanvas, showflag) {

    var objs = lcanvas.getObjects().map(function(o) {
        if (!o.selectable && !o.bg && o.type != 'text') {
            o.opacity = showflag;
        }
        return o;
    });

    canvas.renderAll();
}

var savecrop = false;

function downloadPdf() {
    if (totalsvgs == convertedsvgs) {
        isdownloadpdf = false;
        if ($('input#savecrop').is(':checked')) {
            savecrop = true;
        }
        var currentTime = new Date();
        var month = currentTime.getMonth() + 1;
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var filename = month + '' + day + '' + year + '' + hours + '' + minutes + '' + seconds;
        filename = filename + ".pdf";
        var jsonCanvasArray = [];
        for (var i = 0; i < canvasindex; i++) {
            if ($("#divcanvas" + i).is(":visible")) {
                hideshowobjects(canvasarray[i], false);
                //jsonCanvasArray.push(canvasarray[i].toDatalessJSON());
                jsonCanvasArray.push(canvasarray[i].toSVG());
            }
        }
        var jsonData = JSON.stringify(jsonCanvasArray);
        console.log(jsonData);
        var cwidth = document.getElementById("loadCanvasWid").value;
        var cheight = document.getElementById("loadCanvasHei").value;
        var rows = document.getElementById("numOfcanvasrows").value;
        var cols = document.getElementById("numOfcanvascols").value;

        //inch to pixel
        cwidth = cwidth * 96;
        cheight = cheight * 96;
        var path = "uploads/savetemplate/";
        $.ajax({
            type: 'POST',
            url: 'pdf.php',
            data: {
                filename: filename,
                jsonData: jsonData,
                cwidth: cwidth,
                cheight: cheight,
                rows: rows,
                cols: cols,
                savecrop: savecrop
            },
            success: function(msg) {

                window.location.href = "downloadfile.php?file=" + msg;
                savecrop = false;
                setTimeout(function() {
                    deleteImage(msg);
                }, 8000);
                for (var i = 0; i < canvasindex; i++) {
                    if ($("#divcanvas" + i).is(":visible")) {
                        hideshowobjects(canvasarray[i], true);
                    }
                }
                $("#spinnerModal").modal('hide');
            }
        })
    }
}

function deleteImage(file_name) {
    $.ajax({
        type: 'POST',
        url: 'deleteimage.php',
        data: {
            filename: file_name,
        },
        success: function(msg) {}
    });
}
// JavaScript Document
$("#addCategory").click(function() {
    $("#Addcategoryodal").modal('show');
});
$("#addTemplateCategory").click(function() {
    $("#AddTemplatecategoryModal").modal('show');
});
$("#addBGCategory").click(function() {
    $("#AddBGcategoryodal").modal('show');
});
$("#addTextCategory").click(function() {
    $("#AddTextcategoryModal").modal('show');
});
$("#saveText").click(function() {
    $('#savetext_modal').modal('show');
});
$("#saveElement").click(function() {
    $('#saveelement_modal').modal('show');
});
$("#addElement").click(function() {
    $("#AddelementModal").modal('show');
});
$("#addBackground").click(function() {
    $("#AddbackgroundModal").modal('show');
});
$("#upload_image").click(function() {
    $("#AdduploadimageModal").modal('show');
});

$("#replace_image").click(function() {
    isReplaceImage = true;
    $("#AdduploadimageModal").modal('show');
});


$("#deletetempcat").click(function() {
    var sel_tempcatid = $('#tempcat-select').val();
    if (sel_tempcatid != '') {
        $("#Del_templatecatmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$("#deleteCategory").click(function() {
    var sel_catid = $('#cat-select').val();
    if (sel_catid != '') {
        $("#Del_catmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$("#deleteBGCategory").click(function() {
    var sel_bgcatid = $('#bgcat-select').val();
    if (sel_bgcatid != '') {
        $("#Del_bgcatmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$("#deletetextcat").click(function() {
    var sel_textcatid = $('#textcat-select').val();
    if (sel_textcatid != '') {
        $("#Del_textcatmodal").modal('show');
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Category, you wish to delete.');
    }
});
$('#deleteEle').click(function() {
    $('#spinnerModal').modal('hide');
    var selectedImg = [];
    $('.catimg-checkbox:checked').each(function() {
        selectedImg.push($(this).val());
    });
    if (selectedImg != '') {
        selectedImg = selectedImg.join(',');
        $.post("actions/deleteElement.php", {
            "elementid": selectedImg
        }, function(data) {
            $('#spinnerModal').modal('hide');
            $('#catimage_container').empty();
            getcategory();
            getcatimages('');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Element(s), you wish to delete.');
    }
});
$('#deleteText').click(function() {
    $('#spinnerModal').modal('hide');
    var selectedTxt = [];
    $('.textimg-checkbox:checked').each(function() {
        selectedTxt.push($(this).val());
    });
    if (selectedTxt != '') {
        selectedTxt = selectedTxt.join(',');
        $.post("actions/deleteText.php", {
            "textid": selectedTxt
        }, function(data) {
            $('#spinnerModal').modal('hide');
            $('#text_container').empty();
            getTexts();
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Text(s), you wish to delete.');
    }
});
$('#deleteBackground').click(function() {
    // $('#spinnerModal').modal('hide');
    var selectedImg = [];
    $('.bgimg-checkbox:checked').each(function() {
        selectedImg.push($(this).val());
    });
    if (selectedImg != '') {
        selectedImg = selectedImg.join(',');
        $.post("actions/deleteBackground.php", {
            "bgid": selectedImg
        }, function(data) {
            $('#spinnerModal').modal('hide');
            $('#background_container').empty();
            //IsBgselected = true;
            getBgcategory();
            getbgimages('');
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Background(s), you wish to delete.');
    }
});

$('#deleteTemp').click(function() {
    $('#spinnerModal').modal('hide');
    var selectedTemp = [];
    $('.templateimg-checkbox:checked').each(function() {
        selectedTemp.push($(this).val());
    });

    if (selectedTemp != '') {
        selectedTemp = selectedTemp.join(',');
        $.post("actions/deleteTemplate.php", {
            "templateid": selectedTemp
        }, function(data) {
            $('#spinnerModal').modal('hide');
            console.log(data);
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            $('#template_container').empty();
            getTemplates();
        });
    } else {
        $("#alertModal").modal('show');
        $('#responceMessage').html('Please select the Flyer(s), you wish to delete.');
    }
});


function getcategory() {
    $.ajax({
        type: "GET",
        url: "actions/getCategory.php",
        success: function(data) {
            $("#cat-select").empty();
            $("#cat-select").html(data);
            $("#element_category").empty();
            $("#element_category").html(data);
            $("#elmt_category").empty();
            $("#elmt_category").html(data);
        }
    });
}

function gettempcategory() {
    $.ajax({
        type: "GET",
        url: "actions/gettempCategory.php",
        success: function(data) {
            $("#tempcat-select").empty();
            $("#tempcat-select").html(data);
            $("#template_category").empty();
            $("#template_category").html(data);
        }
    });
}

function getBgcategory() {
    $.ajax({
        type: "GET",
        url: "actions/getBgCategory.php",
        success: function(data) {
            $("#bgcat-select").empty();
            $("#bgcat-select").html(data);
            $("#bg_category").empty();
            $("#bg_category").html(data);
        }
    });
}

function getTextcategory() {
    $.ajax({
        type: "GET",
        url: "actions/getTextCategory.php",
        success: function(data) {
            $("#textcat-select").empty();
            $("#textcat-select").html(data);
            $("#text_category").empty();
            $("#text_category").html(data);
        }
    });
}

function getTemplatesName() {
    $.ajax({
        type: "GET",
        url: "actions/getTemplate_name.php",
        success: function(data) {
            $("#template-select").empty();
            $("#template-select").html(data);
        }
    });
}
<!-- Category form validate -->
$(document).ready(function() {
    $('#addcategoryform').validate({
        rules: {
            category: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var newcategory = $("#category").val();
            $('#Addcategoryodal').modal('hide');
            $("#spinnerModal").modal('show');
            $.post("actions/addcategory.php", {
                "categoty": newcategory
            }, function(data) {
                $('#spinnerModal').modal('hide');
                $('#catimage_container').empty();
                getcategory();
                getcatimages('');
                document.getElementById("successMessage").innerHTML = data;
                $('#successModal').modal('show');
                $('#addcategoryform')[0].reset();
            });
        }
    });
});
$(document).ready(function() {
    $('#addtextcategoryform').validate({
        rules: {
            textcategory: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var newTxtcategory = $("#textcategory").val();
            $('#AddTextcategoryModal').modal('hide');
            $("#spinnerModal").modal('show');
            $.post("actions/addcategory.php", {
                "textcategoty": newTxtcategory
            }, function(data) {
                $('#spinnerModal').modal('hide');
                getTextcategory();
                document.getElementById("successMessage").innerHTML = data;
                $('#successModal').modal('show');
                $('#addtextcategoryform')[0].reset();
            });
        }
    });
});

function proceed_tempcatdelete() {
    var sel_tmpcatid = $('#tempcat-select').val();
    $('#Del_templatecatmodal').modal('hide');
    $("#spinnerModal").modal('show');
    $.post("actions/deletetempcategory.php", {
        "categoty": sel_tmpcatid
    }, function(data) {
        $('#spinnerModal').modal('hide');
        $('#template_container').empty();
        getTemplates();
        gettempcategory('');
        document.getElementById("successMessage").innerHTML = data;
        $('#successModal').modal('show');
    });
}

function proceed_catdelete() {
    var sel_catid = $('#cat-select').val();
    $('#Del_catmodal').modal('hide');
    $("#spinnerModal").modal('show');
    $.post("actions/deletecategory.php", {
        "categoty": sel_catid
    }, function(data) {
        $('#spinnerModal').modal('hide');
        $('#catimage_container').empty();
        getcategory();
        getcatimages('');
        document.getElementById("successMessage").innerHTML = data;
        $('#successModal').modal('show');
    });
}

function proceed_Bgcatdelete() {
    var sel_bgcatid = $('#bgcat-select').val();
    $('#Del_bgcatmodal').modal('hide');
    $("#spinnerModal").modal('show');
    $.post("actions/deletebgcategory.php", {
        "bgcategoty": sel_bgcatid
    }, function(data) {
        $('#spinnerModal').modal('hide');
        $('#background_container').empty();
        getBgcategory();
        getbgimages('');
        document.getElementById("successMessage").innerHTML = data;
        $('#successModal').modal('show');
    });
}

function proceed_textcatdelete() {
    var sel_textcatid = $('#textcat-select').val();
    $('#Del_textcatmodal').modal('hide');
    $("#spinnerModal").modal('show');
    $.post("actions/deletetextcategory.php", {
        "textcategoty": sel_textcatid
    }, function(data) {
        $('#spinnerModal').modal('hide');
        getTextcategory();
        document.getElementById("successMessage").innerHTML = data;
        $('#successModal').modal('show');
    });
}
$(document).ready(function() {
    $('#addbgcategoryform').validate({
        rules: {
            bgcategory: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var newcategory = $("#bgcategory").val();
            $('#AddBGcategoryodal').modal('hide');
            $("#spinnerModal").modal('show');
            $.post("actions/addcategory.php", {
                "bgcategoty": newcategory
            }, function(data) {
                $('#spinnerModal').modal('hide');
                $('#background_container').empty();
                getBgcategory();
                getbgimages('');
                document.getElementById("successMessage").innerHTML = data;
                $('#successModal').modal('show');
                $('#addbgcategoryform')[0].reset();
            });
        }
    });
});
<!-- Teremplate Category form validate -->
$(document).ready(function() {
    $('#addtemplatecategoryform').validate({
        rules: {
            templatecategory: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var tempcategory = $("#templatecategory").val();
            $('#AddTemplatecategoryModal').modal('hide');
            $("#spinnerModal").modal('show');
            $.post("actions/addcategory.php", {
                "templatecat": tempcategory
            }, function(data) {
                $('#spinnerModal').modal('hide');
                gettempcategory();
                getcatimages('');
                document.getElementById("successMessage").innerHTML = data;
                $('#successModal').modal('show');
                $('#addtemplatecategoryform')[0].reset();
            });
        }
    });
});
<!-- File Upload --->
function readIMG(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewImage').show();
            $('#previewImage').attr('src', e.target.result).width(150).height(150);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
var files;
$('#element_img').on('change', prepareUpload);

function prepareUpload(event) {
    files = event.target.files;
}

function uploadimage() {
    var data = new FormData();
    //adding file content to data
    $.each(files, function(key, value) {
        data.append("element_img", value);
    });
    $.ajax({
        url: 'upload.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {
            alert(data)
        }
    });
}
<!-- File Upload --->
function readBGIMG(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewBGImage').show();
            $('#previewBGImage').attr('src', e.target.result).width(150).height(150);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
var bgfiles;
$('#bg_img').on('change', prepareBGUpload);

function prepareBGUpload(event) {
    bgfiles = event.target.files;
}

function uploadBgimage() {
    var data = new FormData();
    //adding file content to data
    $.each(bgfiles, function(key, value) {
        data.append("bg_img", value);
    });
    $.ajax({
        url: 'upload.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {
            alert(data)
        }
    });
}

function addNewCanvasPage(dupflag, pageid) {
    pageindex++;
    $("#canvaspages").append("<div class='page' id='page" + pageindex + "'></div>");
    addCanvasToPage(dupflag, pageid);
}

function addNewCanvas() {
    var ito = getinfotextobj();
    if (ito) ito.opacity = 0;
    canvas.deactivateAllWithDispatch().renderAll();
    $("#page" + pageindex).append("<td align='center' id='divcanvas" + canvasindex + "' onmousedown='javascript:selectCanvas(this.id);' onClick='javascript:selectCanvas(this.id);' oncontextmenu='javascript:selectCanvas(this.id);' class='divcanvas'><div class='canvascontent' ><canvas id='canvas" + canvasindex + "' class='canvas'></canvas></div></td>");
    canvas = new fabric.Canvas('canvas' + canvasindex);
    canvas.index = 0;
    canvas.state = [];
    canvas.rotationCursor = 'url("img/rotatecursor2.png") 10 10, crosshair';
    canvas.backgroundColor = '#ffffff';
    canvas.selectionColor = 'rgba(255,255,255,0.3)';
    canvas.selectionBorderColor = 'rgba(0,0,0,0.1)';
    canvas.hoverCursor = 'pointer';
    canvasarray.push(canvas);
    var width = document.getElementById("loadCanvasWid").value,
        height = document.getElementById("loadCanvasHei").value;
    //inch to pixel
    width = width * 96;
    height = height * 96;
    setCanvasWidthHeight(width * canvasScale, height * canvasScale);
    initCanvasEvents(canvas);
    initAligningGuidelines(canvas);
    initCenteringGuidelines(canvas);
    initKeyboardEvents();
    //addinfotext();
    canvas.calcOffset();
    canvas.renderAll();
    currentcanvasid = canvasindex;
    canvasindex++;
    saveState();
}

function selectCanvas(id) {
    var ito = getinfotextobj();
    if (ito) ito.opacity = 0;
    id = id.replace("divcanvas", "");
    if (currentcanvasid == parseInt(id)) return;
    savestateaction = true;
    canvas.deactivateAllWithDispatch().renderAll();
    for (var i = 0, j = 0; i < canvasindex; i++) {
        $("#canvas" + i).css("box-shadow", "");
    }
    $("#canvas" + id).css("box-shadow", "3px 3px 3px #888888");
    if (currentcanvasid == parseInt(id)) return;

    currentcanvasid = parseInt(id);
    var tempcanvas = canvasarray[parseInt(id)];
    if (tempcanvas) canvas = tempcanvas;

    var obj = canvas.getActiveObject();
    if (obj)
        canvas.setActiveObject(obj);

    canvas.renderAll();
}

function adjustIconPos(id) {
    //set duplicate / delete icons left top positions.
    var p = $("#page" + id);
    var position = p.position();
    // .outerWidth() takes into account border and padding.
    var width = p.outerWidth();
    var height = p.outerHeight();
    $("#duplicatecanvas" + id).css({
        position: "absolute",
        top: (position.top + height / 2) + "px",
        left: (position.left + width + 10) + "px"
    }).show();
    $("#deletecanvas" + id).css({
        position: "absolute",
        top: (position.top + height / 2 + 25) + "px",
        left: (position.left + width + 10) + "px"
    }).show();
    if ($(".page:visible").length == 1) {
        $('.deletecanvas').css('display', 'none');
    }
}
$(".deletecanvas").click(function() {
    var id = this.id;
    id = id.replace("deletecanvas", "");
    var pageid = id;
    id = "#page" + id;
    //$(id).detach();
    $(id).hide();
    $("#canvaspages").find(".page").each(function() {
        var nextid = this.id;
        nextid = nextid.replace("page", "");
        adjustIconPos(nextid);
    });
    if ($(".page:visible").length == 1) {
        $('.deletecanvas').css('display', 'none');
    }
});

function openTemplate(jsons, isSave, filename) {
    var jsonCanvasArray = JSON.parse(jsons);
    if (!jsonCanvasArray || jsonCanvasArray.length <= 0) return;
    var wh = jsonCanvasArray[0];
    wh = JSON.parse(wh);
    //pixel to inch
    document.getElementById("loadCanvasWid").value = parseFloat(wh.width / 96);
    document.getElementById("loadCanvasHei").value = parseFloat(wh.height / 96);
    document.getElementById("numOfcanvasrows").value = parseInt(wh.rows);
    document.getElementById("numOfcanvascols").value = parseInt(wh.cols);
    var rc = parseInt(wh.rows) * parseInt(wh.cols);
    $("#canvaspages").html('');
    pageindex = 0;
    canvasindex = 0;
    canvasarray = [];
    for (var i = 0; i < (jsonCanvasArray.length - 1) / rc; i++) {
        pageindex = i;
        $("#canvaspages").append("<div class='page' id='page" + pageindex + "'></div>");
        addCanvasToPage(false, i, jsonCanvasArray);
    }
    setCanvasSize();

    var js = jsonCanvasArray[1];
    var ffs = getValues(js, 'fontFamily');
    ffs = remove_duplicates(ffs);

    if (ffs && ffs.length == 0) ffs.push('Droid Sans');

    WebFont.load({
        google: {
            families: ffs
        },
        active: function() {

            var totalloaded = 0;
            for (var i = 0; i < canvasindex; i++) {

                var lcanvas = canvasarray[i];
                var json = jsonCanvasArray[i + 1];

                lcanvas.clear();

                for (var i = 0; i < json.objects.length; i++) {
                    var object = json.objects[i];
                    console.log(object.type);
                    if (object)
                        if (object.type == "cropzoomimage") {

                            (function(lobject) {

                                fabric.util.loadImage(lobject.src, function(img) {
                                    var obj = new fabric.Cropzoomimage(img, {
                                        left: lobject.left,
                                        top: lobject.top,
                                        originX: lobject.originX,
                                        originY: lobject.originY,
                                        scaleX: lobject.scaleX,
                                        scaleY: lobject.scaleY,
                                        width: lobject.width,
                                        height: lobject.height,
                                        cx: lobject.cx,
                                        cy: lobject.cy,
                                        orgSrc: lobject.orgSrc,
                                        cw: lobject.cw,
                                        ch: lobject.ch
                                    });
                                    obj.src = lobject.src;
                                    lcanvas.add(obj);
                                    lcanvas.sendToBack(obj);
                                    obj.setCoords();
                                    lcanvas.renderAll();
                                }, null, {
                                    crossOrigin: 'Anonymous'
                                });
                            })(object);

                        } else if (object.type == 'path-group') {
                             fabric.util.enlivenObjects([object], function (objects) {
                                    objects.forEach(function (o) {
                                           lcanvas.add(o);
                                           console.log(o);
                                           lcanvas.renderAll();
                                    });
                             });
                        } else {

                            var newobject = new fabric[fabric.util.string.camelize(fabric.util.string.capitalize(object.type))].fromObject(object);
                            lcanvas.add(newobject);
                            lcanvas.bringToFront(newobject);
                        }
                }

                initCanvasEvents(lcanvas);
                initAligningGuidelines(lcanvas);
                initCenteringGuidelines(lcanvas);

                saveState();
                totalloaded++;

                if (totalloaded == canvasindex) {

                    $("#spinnerModal").modal('hide');
                    initKeyboardEvents();
                    setCanvasSize();
                }

                lcanvas.renderAll();
            }
        },
        classes: false
    });
}

function saveAsTemplate() {

    issaveastemplate = false;
    var jsonCanvasArray = [];
    var width = document.getElementById("loadCanvasWid").value,
        height = document.getElementById("loadCanvasHei").value,
        rows = document.getElementById("numOfcanvasrows").value,
        cols = document.getElementById("numOfcanvascols").value;
    //inch to pixel
    width = width * 96;
    height = height * 96;
    var wh = '{\"width\": ' + width + ', \"height\": ' + height + ', \"rows\": ' + rows + ', \"cols\": ' + cols + '}';
    jsonCanvasArray.push(wh);
    var firstcanvas;
    for (var i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;
        canvasarray[i].deactivateAll().renderAll();
        if ($("#divcanvas" + i).is(":visible")) {
            if (!firstcanvas || (firstcanvas.getObjects().length < canvasarray[i].getObjects().length)) firstcanvas = canvasarray[i];
            jsonCanvasArray.push(canvasarray[i].toDatalessJSON());
        }
    }

    var jsonData = JSON.stringify(jsonCanvasArray);
    
    if(firstcanvas)
        var pngdataURL = firstcanvas.toDataURL("image/png");
    else
        return false;
    
    var filename = $('#templatename').val();
    var path = "templates";

    $.ajax({
        type: 'POST',
        url: 'saveastemplate.php',
        data: {
            pngimageData: pngdataURL,
            path: path,
            filename: filename,
            jsonData: jsonData
        },
        success: function(templateid) {
            loadedtemplateid = templateid;
            $('#savetemplate_modal').modal('hide');
            $('#spinnerModal').modal('hide');
        }
    })

}

function saveTemplate() {
    issavetemplate = false;
    var jsonCanvasArray = [];
    var width = document.getElementById("loadCanvasWid").value,
        height = document.getElementById("loadCanvasHei").value,
        rows = document.getElementById("numOfcanvasrows").value,
        cols = document.getElementById("numOfcanvascols").value;
    //inch to pixel
    width = width * 96;
    height = height * 96;
    var wh = '{\"width\": ' + width + ', \"height\": ' + height + ', \"rows\": ' + rows + ', \"cols\": ' + cols + '}';
    jsonCanvasArray.push(wh);
    var firstcanvas;
    for (var i = 0; i < canvasindex; i++) {
        if (!canvasarray[i]) continue;
        canvasarray[i].deactivateAll().renderAll();
        if ($("#divcanvas" + i).is(":visible")) {
            if (!firstcanvas || (firstcanvas.getObjects().length < canvasarray[i].getObjects().length)) firstcanvas = canvasarray[i];
            jsonCanvasArray.push(canvasarray[i].toDatalessJSON());
        }
    }
    var jsonData = JSON.stringify(jsonCanvasArray);
    if(firstcanvas)
        var pngdataURL = firstcanvas.toDataURL("image/png");
    else
        return false;

    if (loadedlabelid == 0) {
        var filename = "Label New";
    } else {
        var filename = "Label" + " " + loadedlabelid;
    } 
    var path = "templates/";

    var url = "updatetemplate.php";
    if (loadedtemplateid == 0)
        url = 'saveastemplate.php';

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            pngimageData: pngdataURL,
            path: path,
            filename: filename,
            jsonData: jsonData,
            templateid: loadedtemplateid
        },
        success: function(templateid) {
            loadedtemplateid = templateid;
            $('#savetemplate_modal').modal('hide');
            $.ajax({
                type: 'POST',
                url: 'cylinderize.php',
                data: {
                    labelfile: path + loadedtemplateid + ".png",
                    templateid: loadedtemplateid
                },
                cache: false,
                success: function(msg) {
                    console.log(msg);
                    
                    $("#labeloutput").attr("src",msg);
                    $("#labeloutput").attr("data-zoom-image",msg);

                    $('#spinnerModal').modal('hide');
                }
            })
            getuploadedlabels();
        }
    })
}

$(".duplicatecanvas").click(function() {
    var id = this.id;
    id = id.replace("duplicatecanvas", "");
    addNewCanvasPage(true, id);
});

function initKeyboardEvents() {

    $('#canvaspages').keyup(function(e) {

        switch (e.keyCode) {
            case 17:
                remstring = 'ctrl ';
                break;

            case 67:
                remstring = ' c';
                break;

            case 88:
                remstring = ' x';
                break;

            case 86:
                remstring = ' v';
                break;

            default:
                break;
        }

        if (keystring.indexOf(remstring) != -1)
            keystring = keystring.replace(remstring, '');
    });

    $('#canvaspages').keydown(function(e) {

        if (e.target && e.target.nodeName == 'INPUT') return false;

        var activeobject = canvas.getActiveObject();
        if (!activeobject) activeobject = canvas.getActiveGroup();
        if (!activeobject && !activeObjectCopy && !activeGroupCopy) return;
        if (activeobject && activeobject.isEditing) return;
        switch (e.keyCode) {
            case 8:
                e.preventDefault();
                deleteItem();
                break;
            case 17: //ctrl
                e.preventDefault();
                keystring = 'ctrl';
                break;
            case 91: //cmd
                e.preventDefault();
                keystring = 'cmd';
                break;
            case 173:
            case 109: // -
                e.preventDefault();
                if (e.ctrlKey || e.metaKey) {
                    return objManip('zoomBy-z', -10);
                }
                return true;
            case 61:
            case 107: // +
                if (e.ctrlKey || e.metaKey) {
                    return demo.objManip('zoomBy-z', 10);
                }
                return true;
            case 37: // left
                if (e.shiftKey) {
                    return objManip('zoomBy-x', -1);
                    return false;
                }
                if (e.ctrlKey || e.metaKey) {
                    return objManip('angle', -1);
                }
                return objManip('left', -1);
            case 39: // right
                if (e.shiftKey) {
                    return objManip('zoomBy-x', 1);
                    return false;
                }
                if (e.ctrlKey || e.metaKey) {
                    return objManip('angle', 1);
                }
                return objManip('left', 1);
            case 38: // up
                if (e.shiftKey) {
                    return objManip('zoomBy-y', -1);
                }
                if (!e.ctrlKey && !e.metaKey) {
                    return objManip('top', -1);
                }
                return true;
            case 40: // down
                if (e.shiftKey) {
                    return objManip('zoomBy-y', 1);
                }
                if (!e.ctrlKey && !e.metaKey) {
                    return objManip('top', 1);
                }
                return true;

            case 67: // ctrl + c

                e.preventDefault();
                keystring += ' c';
                if (keystring == "ctrl c" || keystring == "cmd c") {
                    copyobjs();
                }
                break;

            case 88: // ctrl + x
                e.preventDefault();
                keystring += ' x';
                if (keystring == "ctrl x" || keystring == "cmd x") {
                    cutobjs();
                }
                break;

            case 86: // ctrl + v
                e.preventDefault();
                keystring += ' v';
                if (keystring == "ctrl v" || keystring == "cmd v") {
                    pasteobjs();
                }
                break;

            case 46:
                e.preventDefault();
                deleteItem();

                break;
            default:
                break;
        }
        canvas.renderAll();
        return true;
    });
}

$("#font-size-dropdown li a").click(function() {
    var selSize = $(this).text();
    var activeObject = canvas.getActiveObject();
    if (activeObject && /textbox/.test(activeObject.type)) {
        selectedFontSize = selSize;
        setStyle(activeObject, 'fontSize', selectedFontSize * 1.3);
        activeObject.setCoords();
        canvas.renderAll();
    }
    $(this).parents('.input-group').find('.fontinput').val(selectedFontSize);
});

<!-- Element form validate -->
$(document).ready(function() {
    sortUnorderedList("fonts-dropdown");
    $("#fonts-dropdown li a").click(function() {
        var selText = $(this).text();
        var activeObject = canvas.getActiveObject();
        if (activeObject && /textbox/.test(activeObject.type)) {
            selectedFont = selText;
            setStyle(activeObject, 'fontFamily', selectedFont);
            canvas.renderAll();
        }
        $(this).parents('.btn-group').find('.dropdown-toggle').html('<span style="overflow:hidden"><font face="' + selText + '" size="3">' + selText + '</font>&nbsp;&nbsp;<span class="caret"></span></span>');
    });
    $('#addelementform').validate({
        rules: {
            element_category: {
                required: true
            },
            element_name: {
                required: true
            },
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) { // <- only fires when form is valid
            var newelmcategory = $("#element_category").val();
            var newelementName = $("#element_name").val();
            var newelement = $("#element_img").val();
            if (!(/\.(svg|jpeg|jpg|png)$/i).test(newelement)) {
                alert('Only svg, jpeg and png files allowed!');
            } else {
                var elementpath = 'uploads/' + newelement;
                $.post("actions/addelement.php", {
                    "elementCategoty": newelmcategory,
                    "elementName": newelementName,
                    "element": elementpath
                }, function(data) {
                    $('#AddelementModal').modal('hide');
                    uploadimage();
                    document.getElementById("successMessage").innerHTML = data;
                    $('#successModal').modal('show');
                    setTimeout(function() {
                        getcategory();
                        getcatimages('');
                    }, 2000);
                    $('#previewImage').hide();
                    $('#addelementform')[0].reset();
                });
            }
        }
    });
});
$('#addbackgroundform').validate({
    rules: {
        bg_category: {
            required: true
        },
        bg_name: {
            required: true
        },
    },
    highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        element.text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(form) { // <- only fires when form is valid
        var newbgcategory = $("#bg_category").val();
        var newbgName = $("#bg_name").val();
        var newbackground = $("#bg_img").val();
        var bgpath = 'uploads/' + newbackground;
        $.post("actions/addbackground.php", {
            "bgCategoty": newbgcategory,
            "bgName": newbgName,
            "background": bgpath
        }, function(data) {
            $('#AddbackgroundModal').modal('hide');
            uploadBgimage();
            document.getElementById("successMessage").innerHTML = data;
            $('#successModal').modal('show');
            setTimeout(function() {
                getBgcategory();
                getbgimages('');
            }, 2000);
            $('#previewBGImage').hide();
            $('#addbackgroundform')[0].reset();
        });
    }
});

function sortUnorderedList(ul, sortDescending) {
    if (typeof ul == "string") ul = document.getElementById(ul);
    // Idiot-proof, remove if you want
    if (!ul) {
        //  alert("The UL object is null!");
        return;
    }
    // Get the list items and setup an array for sorting
    var lis = ul.getElementsByTagName("LI");
    var vals = [];
    // Populate the array
    for (var i = 0, l = lis.length; i < l; i++) vals.push(lis[i].innerHTML);
    // Sort it
    vals.sort();
    // Sometimes you gotta DESC
    if (sortDescending) vals.reverse();
    // Change the list on the page
    for (var i = 0, l = lis.length; i < l; i++) lis[i].innerHTML = vals[i];
}

function loadAdminTemplate(templateid) {
    $("#spinnerModal").modal('show');
    deleteCanvasBg(canvas);
    canvas.clear();
    $.ajax({
        url: "loadadmintemplate.php",
        type: "get",
        data: {
            id: parseInt(templateid)
        },
        cache: false,
        success: function(data) {
            console.log(data)
            if (data != "empty") {

                savestateaction = false;
                isadmintemplate = true;
                openTemplate(data)
                canvas.calcOffset();
                canvas.renderAll();

                savestateaction = true;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}

function replaceAll(str, find, replace) {
  return str.replace(new RegExp(find, 'g'), replace);
}

function loadTemplate(templateid) {
    $("#spinnerModal").modal('show');
    loadedtemplateid = templateid;
    deleteCanvasBg(canvas);
    canvas.clear();
    $.ajax({
        url: "loadtemplate.php",
        type: "get",
        cache: false,
        data: {
            id: parseInt(templateid)
	   },
        cache: false,
        success: function(data) {

            if (data != "empty") {
                
                console.log(data);

                savestateaction = false;
                openTemplate(data)
                canvas.calcOffset();
                canvas.renderAll();

                savestateaction = true;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}

function loadText(textid) {
    $("#spinnerModal").modal('show');
    $.ajax({
        url: "loadtext.php",
        type: "get",
        data: {
            id: parseInt(textid)
        },
        success: function(data) {
            console.log(data)
            if (data != "empty") {
                var json = JSON.parse(data);
                var objects = json.objects;
                console.log(objects.length);
                for (var i = 0; i < objects.length; i++) {
                    var object = objects[i];
                    console.log(object)
                    if (object.type == 'textbox') {
                        var txtBox = new fabric.Textbox(object.text, object);
                        canvas.add(txtBox);
                        setControlsVisibility(txtBox);
                        txtBox.center();
                        txtBox.setCoords();
                        saveState();
                        canvas.calcOffset();
                        canvas.renderAll();
                    }
                    if (object.type == 'group') {
                        var group = object;
                        var groupleft = group.left;
                        var grouptop = group.top;
                        var grpobjects = group.objects;
                        for (var j = 0; j < grpobjects.length; j++) {
                            var object = grpobjects[j];
                            if (object.type == 'textbox') {
                                var txtBox = new fabric.Textbox(object.text, object);
                                canvas.add(txtBox);
                                txtBox.setLeft(txtBox.left + canvas.width / 2);
                                txtBox.setTop(txtBox.top + canvas.height / 2);
                                txtBox.setCoords();
                            }
                        }
                        canvas.calcOffset();
                        saveState();
                        canvas.renderAll();
                    }
                }
                $("#spinnerModal").modal('hide');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}

function loadElement(elementid) {
    $("#spinnerModal").modal('show');
    $.ajax({
        url: "loadelement.php",
        type: "get",
        data: {
            id: parseInt(elementid)
        },
        success: function(data) {
            var json = JSON.parse(data);
            fabric.util.enlivenObjects([json], function(objects) {
                var origRenderOnAddRemove = canvas.renderOnAddRemove;
                canvas.renderOnAddRemove = false;
                objects.forEach(function(o) {
                    canvas.add(o);
                    o.setCoords();
                    o.center();
                    var items = o._objects;
                    o._restoreObjectsState();
                    canvas.remove(o);
                    for (var i = 0; i < items.length; i++) {
                        canvas.add(items[i]);
                    }
                });
                canvas.renderOnAddRemove = origRenderOnAddRemove;
                canvas.renderAll();
            });
            $("#spinnerModal").modal('hide');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            switch (jqXHR.status) {
                case 400:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("UnableToComplyException:" + excp.message, 'warning');
                    break;
                case 500:
                    var excp = $.parseJSON(jqXHR.responseText).error;
                    console.log("PanicException:" + excp.message, 'panic');
                    break;
                default:
                    console.log("HTTP status=" + jqXHR.status + "," + textStatus + "," + errorThrown + "," + jqXHR.responseText);
            }
        }
    });
}
var objectFlipHorizontalSwitch = document.getElementById('objectfliphorizontal');
if (objectFlipHorizontalSwitch) {
    objectFlipHorizontalSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            if (activeObject.flipX) activeObject.flipX = false;
            else activeObject.flipX = true;
            canvas.renderAll();
            saveState();
        }
    };
}
var objectFlipVerticalSwitch = document.getElementById('objectflipvertical');
if (objectFlipVerticalSwitch) {
    objectFlipVerticalSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            if (activeObject.flipY) activeObject.flipY = false;
            else activeObject.flipY = true;
            canvas.renderAll();
            saveState();
        }
    };
}
//Lock object
var objectLock = document.getElementById('objectlock');
if (objectLock) {
    objectLock.onclick = function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            if (activeObject.lockMovementY) {
                activeObject.lockMovementY = activeObject.lockMovementX = activeObject.lockScalingY = activeObject.lockScalingX = false;
                activeObject.hasControls = true;
                activeObject.hoverCursor = 'pointer';
                activeObject.locked = false;
            } else {
                activeObject.lockMovementY = activeObject.lockMovementX = activeObject.lockScalingY = activeObject.lockScalingX = true;
                activeObject.hasControls = false;
                activeObject.hoverCursor = 'url("../img/lockcursor.png") 10 10, pointer';
                activeObject.locked = true;
                activeObject.lockedleft = activeObject.left;
                activeObject.lockedtop = activeObject.top;
            }
            canvas.renderAll();
            saveState();
        }
    };
}
//Changes opacity of active object
var ChangeOpacity = function() {
    var activeObject = canvas.getActiveObject();
    activeObject.setOpacity(co.getValue());
    canvas.renderAll();
    saveState();
};
var co = $("#changeopacity").slider().on('slide', ChangeOpacity).data('slider');
var clonebtn = document.getElementById('clone');
if (clonebtn) {
    clonebtn.onclick = function() {
        var activeObject = canvas.getActiveObject();
        if (!activeObject) activeObject = canvas.getActiveGroup();
        if (!activeObject) return;
        if (activeObject.type == "group") {
            activeObject.forEachObject(function(object) {
                cloneSelObject(object);
            });
        } else {
            cloneSelObject(activeObject);
        }
    }
}

function cloneSelObject(actobj) {
    if (fabric.util.getKlass(actobj.type).async) {
        actobj.clone(function(clone) {
            clone.set({
                left: actobj.getLeft() + 20,
                top: actobj.getTop() + 20
            });
            canvas.add(clone);
        });
    } else {
        canvas.add(actobj.clone().set({
            left: actobj.getLeft() + 20,
            top: actobj.getTop() + 20
        }));
    }
}
var sendLayerBackSwitch = document.getElementById('sendbackward');
if (sendLayerBackSwitch) {
    sendLayerBackSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            canvas.sendBackwards(activeObject);
            canvas.renderAll();
            saveState();
        }
    }
}
var bringLayerFrontSwitch = document.getElementById('bringforward');
if (bringLayerFrontSwitch) {
    bringLayerFrontSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            canvas.bringForward(activeObject);
            canvas.renderAll();
            saveState();
        }
    }
}
fabric.Cropzoomimage = fabric.util.createClass(fabric.Image, {
    type: 'cropzoomimage',
    zoomedXY: false,
    initialize: function(element, options) {
        options || (options = {});
        this.callSuper('initialize', element, options);
        this.set({
            orgSrc: element.src,
            cx: 0, // clip-x
            cy: 0, // clip-y
            cw: element.width, // clip-width
            ch: element.height // clip-height
        });
    },
    zoomBy: function(x, y, z, callback) {
        if (x || y) {
            this.zoomedXY = true;
        }
        this.cx += x;
        this.cy += y;
        if (z) {
            this.cw -= z;
            this.ch -= z / (this.width / this.height);
        }
        if (z && !this.zoomedXY) {
            // Zoom to center of image initially
            this.cx = this.width / 2 - (this.cw / 2);
            this.cy = this.height / 2 - (this.ch / 2);
        }
        if (this.cw > this.width) {
            this.cw = this.width;
        }
        if (this.ch > this.height) {
            this.ch = this.height;
        }
        if (this.cw < 1) {
            this.cw = 1;
        }
        if (this.ch < 1) {
            this.ch = 1;
        }
        if (this.cx < 0) {
            this.cx = 0;
        }
        if (this.cy < 0) {
            this.cy = 0;
        }
        if (this.cx > this.width - this.cw) {
            this.cx = this.width - this.cw;
        }
        if (this.cy > this.height - this.ch) {
            this.cy = this.height - this.ch;
        }
        this.rerender(callback);
    },
    rerender: function(callback) {
        var img = new Image(),
            obj = this;
        img.onload = function() {
            var canvas = fabric.util.createCanvasElement();
            canvas.width = obj.width;
            canvas.height = obj.height;
            canvas.getContext('2d').drawImage(this, obj.cx, obj.cy, obj.cw, obj.ch, 0, 0, obj.width, obj.height);
            img.onload = function() {
                obj.setElement(this);
                obj.applyFilters(canvas.renderAll);
                obj.set({
                    left: obj.left,
                    top: obj.top,
                    angle: obj.angle
                });
                obj.setCoords();
                if (callback) {
                    callback(obj);
                }
            };
            img.src = canvas.toDataURL('image/png');
        };
        img.src = this.orgSrc;
    },
    toObject: function() {
        return fabric.util.object.extend(this.callSuper('toObject'), {
            orgSrc: this.orgSrc,
            cx: this.cx,
            cy: this.cy,
            cw: this.cw,
            ch: this.ch
        });
    }
});
fabric.Cropzoomimage.async = true;
fabric.Cropzoomimage.fromObject = function(object, callback) {
    fabric.util.loadImage(object.src, function(img) {
        fabric.Image.prototype._initFilters.call(object, object, function(filters) {
            object.filters = filters || [];
            var instance = new fabric.Cropzoomimage(img, object);
            if (callback) {
                callback(instance);
            }
        });
    }, null, object.crossOrigin);
};
zoomBy = function(x, y, z) {
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        activeObject.zoomBy(x, y, z, function() {
            canvas.renderAll()
        });
    }
};
objManip = function(prop, value) {
    var obj = canvas.getActiveObject();
    var grpobjs = canvas.getActiveGroup();
    if (!obj && !grpobjs) {
        return true;
    }
    switch (prop) {
        case 'zoomBy-x':
            obj.zoomBy(value, 0, 0, function() {
                canvas.renderAll()
            });
            break;
        case 'zoomBy-y':
            obj.zoomBy(0, value, 0, function() {
                canvas.renderAll()
            });
            break;
        case 'zoomBy-z':
            obj.zoomBy(0, 0, value, function() {
                canvas.renderAll()
            });
            break;
        default:
            if (obj && obj.lockMovementX == false) {
                obj.set(prop, obj.get(prop) + value);
            }
            if (grpobjs) {
                grpobjs.set(prop, grpobjs.get(prop) + value);
                grpobjs.setCoords();
            }
            break;
    }
    if (obj && ('left' === prop || 'top' === prop)) {
        obj.setCoords();
    }
    canvas.renderAll();
    return false;
};

function rgbToHex(r, g, b) {
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
}

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

function addinfotext() {
    var itext = new fabric.Text('', {
        fontFamily: selectedFont,
        fontSize: 8 * 2,
        fill: 'black',
        scaleX: canvasScale,
        scaleY: canvasScale,
        selectable: false,
        hasControls: false,
        hasBorders: false,
        hasCorners: false,
        opacity: 0
    });
    itext.setCoords();
    canvas.add(itext);
    canvas.renderAll();
}

function getinfotextobj(lcanvas) {
    if (lcanvas) canvas = lcanvas;
    var objs = canvas.getObjects();
    var infotextobj;
    for (var i in objs) {
        if (objs[i].type == 'text') {
            infotextobj = objs[i];
            infotextobj.selectable = false;
        }
    }
    return infotextobj;
}

function cutobjs() {
    activeObjectCopy = canvas.getActiveObject();
    activeGroupCopy = canvas.getActiveGroup();
    if (activeObjectCopy || activeGroupCopy) {
        var jsonData;
        if (activeGroupCopy) {
            var jsonCanvas = activeGroupCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        } else if (activeObjectCopy) {
            var jsonCanvas = activeObjectCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        }
    }
    if (activeGroupCopy) {
        var objectsInGroup = activeGroupCopy.getObjects();
        canvas.discardActiveGroup();
        objectsInGroup.forEach(function(object) {
            canvas.remove(object);
        });
    } else if (activeObjectCopy) {
        canvas.remove(activeObjectCopy);
    }
}

function selectallobjs() {
    var objs = canvas.getObjects().map(function(o) {
        return o.set('active', true);
    });

    var objs = canvas.getObjects().filter(function(o) {
        return o.bg != true;
    });

    var group = new fabric.Group(objs, {
        originX: 'center',
        originY: 'center'
    });
    canvas._activeObject = null;
    canvas.setActiveGroup(group.setCoords()).renderAll();
}

function copyobjs() {
    activeObjectCopy = canvas.getActiveObject();
    activeGroupCopy = canvas.getActiveGroup();
    if (activeObjectCopy || activeGroupCopy) {
        var jsonData;
        if (activeGroupCopy) {
            var jsonCanvas = activeGroupCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        } else if (activeObjectCopy) {
            var jsonCanvas = activeObjectCopy.toJSON();
            jsonData = JSON.stringify(jsonCanvas);
        }
    }
}

function pasteobjs() {
    if (activeGroupCopy) {
        var objectsInGroup = activeGroupCopy.getObjects();
        canvas.discardActiveGroup();
        objectsInGroup.forEach(function(object) {
            if (fabric.util.getKlass(object.type).async) {
                object.clone(function(clone) {
                    canvas.add(clone);
                });
            } else {
                canvas.add(object.clone());
            }
        });
    } else if (activeObjectCopy) {
        if (fabric.util.getKlass(activeObjectCopy.type).async) {
            activeObjectCopy.clone(function(clone) {
                canvas.add(clone);
            });
        } else {
            canvas.add(activeObjectCopy.clone());
        }
    }
    canvas.renderAll();
}

function toSVG() {
    window.open(
        'data:image/svg+xml;utf8,' +
        encodeURIComponent(canvas.toSVG()));
}
$('#strokeline').spectrum({
    parts: ['header', 'cmyk', 'preview', 'swatches', 'footer'],
    alpha: true,
    layout: {
        preview: [0, 0, 0, 1],
        //  swatches: [2, 2, 1, 4],
        //  cmyk:       [1, 5, 1, 2]
    },
    position: {
        my: 'top+5%',
        at: 'left+100',
        of: '#strokeline'
    },
    init: function() {
        var activeobject = canvas.getActiveObject();
        if (activeobject) {
            $('#strokeline i').css('color', activeobject.fill);
        }
    },
    move: function(color) {
        var colorVal = color.toHexString(); // #ff0000
        var activeobject = canvas.getActiveObject();
        if (activeobject) {
            changeStorkColor(colorVal);
            $('#strokeline i').css('color', colorVal);
        } else {
            changeStorkColor('#000000');
        }
    },
    select: function(event, color) {
        var colorval = ('#' + color.formatted);
        $('#strokeline i').css('color', colorval);
        changeStorkColor(colorval);
    }
});

$('#nofill').click(function() {
    var isShapeNoFill = $('#nofill').is(":checked");
    var obj = canvas.getActiveObject();
    if (obj && obj.type == "rect" || obj.type == "circle" || obj.type == "triangle") {
        if (obj && isShapeNoFill == true) {
            obj.prevfill = obj.fill;
            obj.fill = 'Transparent';
            obj.set('onfill', true);
        } else if (obj && isShapeNoFill == false) {
            if (obj.prevfill) {
                obj.setFill(obj.prevfill);
            } else
                obj.set('onfill', false);
        }
        saveState();
    }
    canvas.renderAll();
});
$('#storkewidth').change(function() {
    var strokeWidth = $(this).val();
    var obj = canvas.getActiveObject();
    if (obj) {
        obj.strokeWidth = parseInt(strokeWidth);
        obj.setCoords();
    }
    canvas.calcOffset();
    canvas.renderAll();
});

function addShape(shape) {
    var stroke = $('#strokeline i').css('color');
    var fill = $('#fillshape i').css('color');
    var strokewidth = parseInt($('#storkewidth').val());

    var isShapeNoFill = $('#nofill').is(":checked");

    $('#shapeselectdropdown').val("");

    if (isShapeNoFill)
        fill = 'Transparent';

    if (!fill) fill = 'black';

    if (shape == 'circle') {

        var circle = new fabric.Circle({
            radius: 40,
            originX: "center",
            originY: "center",
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
                //opacity: 0.5
        });

        savestateaction = false;
        canvas.add(circle);
        savestateaction = true;
        circle.center();
        circle.setCoords();
        canvas.setActiveObject(circle);
        canvas.renderAll();
    } else if (shape == 'rectangle') {
        var rectangle = new fabric.Rect({

            width: 100,
            height: 60,
            originX: 'left',
            originY: 'top',
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
                //opacity: 0.5

        });

        savestateaction = false;
        canvas.add(rectangle);
        savestateaction = true;
        rectangle.center();
        rectangle.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(rectangle);

    } else if (shape == 'square') {
        var square = new fabric.Rect({
            width: 60,
            height: 60,
            originX: 'left',
            originY: 'top',
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
                //opacity: 0.5
        });

        savestateaction = false;
        canvas.add(square);
        savestateaction = true;
        square.center();
        square.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(square);

    } else if (shape == 'triangle') {
        var triangle = new fabric.Triangle({
            top: 250,
            left: 300,
            width: 100,
            height: 100,
            strokeWidth: strokewidth,
            fill: fill,
            stroke: stroke,
            onfill: false
                //opacity: 0.5
        });
        savestateaction = false;
        canvas.add(triangle);
        savestateaction = true;
        triangle.center();
        triangle.setCoords();
        canvas.renderAll();
        canvas.setActiveObject(triangle);
    }
}

function changeStorkColor(hex) {
    var obj = canvas.getActiveObject();
    if (obj) {
        obj.setStroke(hex);
        saveState();
    }
    canvas.renderAll();
}

function changefillColor(hex) {
    var obj = canvas.getActiveObject();
    if (!obj) return;
    if (obj.onfill == false) {
        obj.setFill(hex);
    } else if (obj.onfill == true) {
        obj.fill = 'Transparent';
    }
    saveState();
    canvas.renderAll();
}

// function to remove duplicates from the array
function remove_duplicates(arr) {
    var obj = {};
    for (var i = 0; i < arr.length; i++) {
        obj[arr[i]] = true;
    }
    arr = [];
    for (var key in obj) {
        arr.push(key);
    }
    return arr;
}

//return an array of objects according to key, value, or key and value matching
function getObjects(obj, key, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getObjects(obj[i], key, val));
        } else
        //if key matches and value matches or if key matches and value is not passed (eliminating the case where key matches but passed value does not)
        if (i == key && obj[i] == val || i == key && val == '') { //
            objects.push(obj);
        } else if (obj[i] == val && key == '') {
            //only add if the object is not already in the array
            if (objects.lastIndexOf(obj) == -1) {
                objects.push(obj);
            }
        }
    }
    return objects;
}

//return an array of values that match on a certain key
function getValues(obj, key) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getValues(obj[i], key));
        } else if (i == key) {
            objects.push(obj[i]);
        }
    }
    return objects;
}

//return an array of keys that match on a certain value
function getKeys(obj, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getKeys(obj[i], val));
        } else if (obj[i] == val) {
            objects.push(i);
        }
    }
    return objects;
}

var objectalignjustifySwitch = document.getElementById('objectalignjustify');
if (objectalignjustifySwitch) {
    objectalignjustifySwitch.onclick = function() {
        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = activeGroup.width / 2 - (object.width * object.scaleX) / 2;
                object.originX = 'center';
                if (object && /textbox/.test(object.type)) {
                    setStyle(object, 'textAlign', "justify");
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectalignleftSwitch.click();
        } else if (activeObject) {
            if (activeObject && /textbox/.test(activeObject.type)) {
                setStyle(activeObject, 'textAlign', "justify");
                canvas.renderAll();
            }
        }
    };
}
var alignObjectLeftSwitch = document.getElementById('alignobjectsleft');
if (alignObjectLeftSwitch) {
    alignObjectLeftSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {

            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                top: activeGroup.top
            });

            canvas._activeObject = null;

            canvas.setActiveGroup(group.setCoords()).renderAll();

            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectH(activeGroup);
            activeGroup.left = 0;
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerH();
            activeObject.setCoords();
            activeObject.originX = 'left';

            // left/right object align should leave 1mm space to the outer edges of the label
            // 1mm = 6px approx;
            activeObject.left = 0;

            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var alignObjectCenterSwitch = document.getElementById('alignobjectscenter');
if (alignObjectCenterSwitch) {
    alignObjectCenterSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();

            var group = new fabric.Group(objs, {
                top: activeGroup.top
            });

            canvas._activeObject = null;

            canvas.setActiveGroup(group.setCoords()).renderAll();

            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectH(activeGroup);
            activeGroup.setCoords();
            canvas.renderAll();

            saveState();
        } else if (activeObject) {
            activeObject.centerH();
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var alignObjectRightSwitch = document.getElementById('alignobjectsright');
if (alignObjectRightSwitch) {
    alignObjectRightSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();
            var group = new fabric.Group(objs, {
                top: activeGroup.top
            });

            canvas._activeObject = null;

            canvas.setActiveGroup(group.setCoords()).renderAll();

            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectH(activeGroup);
            activeGroup.left = canvas.width - (activeGroup.width * activeGroup.scaleX);
            activeGroup.setCoords();
            canvas.renderAll();
            saveState();
        } else if (activeObject) {
            activeObject.centerH();
            activeObject.setCoords();
            activeObject.originX = 'left';
            activeObject.left = canvas.width - (activeObject.width * activeObject.scaleX);
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var objectaligntopSwitch = document.getElementById('alignobjectstop');
if (objectaligntopSwitch) {
    objectaligntopSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();

            var group = new fabric.Group(objs, {
                left: activeGroup.left
            });

            canvas._activeObject = null;

            canvas.setActiveGroup(group.setCoords()).renderAll();

            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectV(activeGroup);
            activeGroup.top = 0;
            activeGroup.setCoords();
            canvas.renderAll();

            saveState();
        } else if (activeObject) {
            activeObject.originY = 'top';
            activeObject.centerV();
            // top/bottom object align should leave 1mm space to the outer edges of the label
            // 1mm = 6px approx;
            activeObject.top = 0;
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var objectalignmiddleSwitch = document.getElementById('alignobjectsmiddle');
if (objectalignmiddleSwitch) {
    objectalignmiddleSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();

            var group = new fabric.Group(objs, {
                left: activeGroup.left
            });

            canvas._activeObject = null;

            canvas.setActiveGroup(group.setCoords()).renderAll();

            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectV(activeGroup);
            activeGroup.setCoords();
            canvas.renderAll();

            saveState();
        } else if (activeObject) {
            activeObject.originY = 'center';
            activeObject.centerV();
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var objectalignbottomSwitch = document.getElementById('alignobjectsbottom');
if (objectalignbottomSwitch) {
    objectalignbottomSwitch.onclick = function() {
        var activeObject = canvas.getActiveObject();
        var activeGroup = canvas.getActiveGroup();
        if (activeGroup) {
            var objs = activeGroup.getObjects();

            var group = new fabric.Group(objs, {
                left: activeGroup.left
            });

            canvas._activeObject = null;

            canvas.setActiveGroup(group.setCoords()).renderAll();

            var activeGroup = canvas.getActiveGroup();
            canvas.centerObjectV(activeGroup);
            activeGroup.top = canvas.height - (activeGroup.height * activeGroup.scaleY);
            activeGroup.setCoords();
            canvas.renderAll();

            saveState();
        } else if (activeObject) {
            activeObject.originY = 'center';
            activeObject.centerV();
            // top/bottom object align should leave 1mm space to the outer edges of the label
            // 1mm = 6px approx;
            activeObject.top = (1050 * canvasScale);
            activeObject.setCoords();
            canvas.renderAll();
            saveState();
        }
    };
}
var objectleftSwitch = document.getElementById('objectsleft');
if (objectleftSwitch) {
    objectleftSwitch.onclick = function() {

        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();

        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                //console.log(object.left);

                object.left = -(activeGroup.width * activeGroup.scaleX) / 2 + (object.width * object.scaleX) / 2;
                //object.originX = 'center';

                if (object && /text/.test(object.type)) {
                    setStyle(object, 'textAlign', "left");
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectleftSwitch.click();
        }
    }
}
var objectcenterSwitch = document.getElementById('objectscenter');
if (objectcenterSwitch) {
    objectcenterSwitch.onclick = function() {

        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = 0;
                object.originX = 'center';

                if (object && /text/.test(object.type)) {
                    setStyle(object, 'textAlign', "center");
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectcenterSwitch.click();
            //objectaligncenterSwitch.click();
        }
    }
}
var objectrightSwitch = document.getElementById('objectsright');
if (objectrightSwitch) {
    objectrightSwitch.onclick = function() {

        activeGroup = canvas.getActiveGroup();
        activeObject = canvas.getActiveObject();
        if (activeGroup) {
            activeGroup.forEachObject(function(object) {
                object.left = activeGroup.width / 2 - (object.width * object.scaleX) / 2;
                //object.originX = 'center';

                if (object && /text/.test(object.type)) {
                    setStyle(object, 'textAlign', "right");
                    canvas.renderAll();
                }
            });
            canvas.renderAll();
            objectrightSwitch.click();
        }
    }
}