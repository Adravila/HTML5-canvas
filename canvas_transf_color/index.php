<html>
<head>
<script src="jquery.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../../pixihama/js/jquery.min.js"></script>
<script>

$(window).load(function() {
	
	$(function() {
		$('#file-input').change(function(e) {
                addImage(e);
                // Limpiamos el input
                /*e.target.files = [];
                e.target.value = "";*/
	});

	function addImage(e) {
		var file = e.target.files[0],
                imageType = /image.*/;

                if (!file.type.match(imageType))
                    return;

                var reader = new FileReader();
                reader.onload = function(e) {
                    fileOnload(e);
                };
                reader.readAsDataURL(file);
	}

		function fileOnload(e) {

                var result = e.target.result;
                var cty = minicanvas_preview.getContext('2d');

                cty.shadowColor = "#E1E0E4";
                cty.fillStyle = "#E1E0E4";
                img = new Image();
                play = false;
                //ctx.mozImageSmoothingEnabled = false;
                cty.imageSmoothingEnabled = false;
				var ctnuevo = minicanvas_preview.getContext('2d');
				ctnuevo.imageSmoothingEnabled = false;
                img.src = result;
				img.onload = pixelate;
				//ajustar.addEventListener('change', pixelate, true);
				tam_canvas = 116;
				tam_pixel = 29;
				tam_resol = minicanvas_preview.width / tam_canvas;

                function pixelate(){
			cty.clearRect(0, 0, tam_canvas, tam_canvas);
			if($('#ajustar')[0].checked == false){
				if(img.width <= tam_canvas && img.height <= tam_canvas)
					cty.drawImage(img, 0, 0, img.width, img.height);
				else 
					cty.drawImage(img, 0, 0, tam_canvas, tam_canvas);
			}
			else
				cty.drawImage(img, 0, 0, tam_canvas, tam_canvas);

                    	var imgData = cty.getImageData(0, 0, tam_canvas, tam_canvas);
                    	var data = imgData.data ;

			// Pixelar imagen
				
			// Transformar imagen					
			// Código de color de la paleta de colores de HAMA BEADS
			// 		   #01 #02 #03 #04 #05 #06 #07 #08 #09 #10 #11 #12 #13 #14 #15 #16 #17 #18 #19 #20 #21 #22 #23 #24 #25 #26 #27 #28 #29 #30 #31 #32 #33 #34 #35 #36 #37 #38 #39 #40 #41 #42 #43 #44 #45 #46 #47 #48 #49 #55 #56 #57 #60 #61 #62 #63
			rgb_red = [255,255,255,228,194,255,105,0,0,15,92,64,224,228,0,135,142,0,229,139,192,179,118,141,157,237,239,24,202,90,103,255,255,246,255,0,121,255,242,255,0,87,255,255,168,139,188,223,90,230,243,212,241,234,161,143];
			rgb_gre = [255,239,197,82,43,142,61,69,126,138,207,36,70,192,141,221,147,0,235,57,100,27,120,109,113,182,190,44,17,11,169,0,66,255,20,22,230,141,244,98,93,190,253,118,134,199,242,145,189,240,218,215,161,183,158,114];
			rgb_blu = [255,189,0,20,42,164,159,132,190,73,151,32,76,0,201,173,151,0,244,30,46,41,121,180,78,159,146,29,255,21,191,144,0,0,0,238,51,49,95,36,163,0,112,117,195,235,94,201,206,214,214,217,37,50,158,36];
			// Transformar imagen
			for (var i = 0; i < data.length; i += 4) {
				var m = 255, red = 0, gre = 0, blu = 0, red_ = 0, gre_ = 0, blu_ = 0,  x = 0, y = 0, filtro = 110;
				if (data[i + 3] < 255) {
					data[i] = 225;
					data[i + 1] = 224;
					data[i + 2] = 228;
					data[i + 3] = 255;
				}else{
					for(var j = 0; j < 57; j++){		
						if(data[i] - rgb_red[j]  > 0) 
							red_ =  data[i] - rgb_red[j];
						else 
							red_ = rgb_red[j] - data[i];
						if(data[i+1] - rgb_gre[j]  > 0) 
							gre_ = data[i+1] - rgb_gre[j];
						else 
							gre_ = rgb_gre[j] - data[i+1]
						if(data[i+2] -  rgb_blu[j]  > 0) 
							blu_ = data[i+2] - rgb_blu[j];
						else 
							blu_ =  rgb_blu[j] - data[i+2]
						if(m >= red_ + blu_ + gre_ + filtro){
							m = red_ + blu_ + gre_;
							red = rgb_red[j];
							gre = rgb_gre[j];
							blu = rgb_blu[j];
						}
					}	
						// Aquí ya tengo el color asignado
						data[i]	= red;
						data[i+1] = gre;
						data[i+2] = blu;
				}
			}
			cty.putImageData(imgData,0, 0);
					
			delete img;
			img = new Image();
			ctnuevo.drawImage(minicanvas_preview, 0, 0,minicanvas_preview.width*tam_resol, minicanvas_preview.height*tam_resol);
                }
            }
        });
    });

</script>
</head>
	
<body>
<canvas title="Canvas a cargar" id="minicanvas_preview" width="464" height="464" style="background-color:#E1E0E4"></canvas>
<br><input name="file-input" class="enlace" id="file-input" type="file" accept="image/*" />
<input type="checkbox" id="ajustar" checked >Ajustar<br>
</body>
	
</html>
