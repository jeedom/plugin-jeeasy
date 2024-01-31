<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

if( file_exists( config::byKey('path_wizard') ) )
  $path_wizard = json_decode( file_get_contents( config::byKey( 'path_wizard' ) ), true );
else
  $path_wizard = json_decode( file_get_contents('plugins/jeeasy/core/data/wizard.json'), true );

$custom = null;

if($path_wizard['trame']['luna']['custom']){
	if($path_wizard['trame']['luna']['custom'] != ''){
		$custom = $path_wizard['trame']['luna']['custom'];
	}
}
?>


	<script>

		var btNext = document.getElementById('bt_next');
    var btPrev = document.getElementById('bt_prev');
	  btNext.style.display = 'none';
	  btPrev.style.display = 'none';

    var progressInterval;
    var progressBar = document.getElementById('div_progressbar');
    progressBar.classList.add('progress-bar-success');
    var progressValue = 0;

    function updateProgress() {
          if (progressValue >= 90) {
              clearInterval(progressInterval);
          } else {
              progressValue += 10; 
              progressBar.innerHTML = progressValue + '%';
              progressBar.style.width = progressValue + '%';
          }
       }
       // On vient lancer l'intervall pour faire avancer la barre de progression
    progressInterval = setInterval(updateProgress, 1500);


    document.getElementById('textAtlas').innerHTML = '{{Installation du Plugin Luna en cours.}}';

		$.ajax({
			type: "POST",
			url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
			data: {
			    action: "installPlugin",
			    id: 'luna'
					<?php if($custom['branch']){echo ", branch: '".$custom['branch']."'";} ?>
			},
			dataType: 'json',
			error: function(request, status, error) {
          clearInterval(progressInterval);
					handleAjaxError(request, status, error);
			},
			success: function(data) {
				testDep();
			}
    	});

      function testDep(){
        $.ajax({
          type: "POST",
          url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
          data: {
              action: "installDepPlugin",
              id: 'luna'
          },
          dataType: 'json',
          error: function(request, status, error) {
              handleAjaxError(request, status, error);
          },
          success: function(data) {
            clearInterval(progressInterval);
            var progressBar = document.getElementById('div_progressbar');
            progressBar.style.width = '100%';
            progressBar.innerHTML = 100 + '%';
            document.getElementById('textAtlas').innerHTML = '{{Le plugin Luna a été installé avec succès}}';
            //document.querySelector('.textAtlas').innerHTML = '{{Le plugin OpenVpn a été installé avec succès}}';
            progressBar.innerHTML = 'FIN';
            Good();
            //progress(100, 'div_progressbar');
          }
          });
       }

      // function progress(ProgressPourcent){
      //   if(ProgressPourcent == -1){
      //       $('#div_progressbar').removeClass('progress-bar-success progress-bar-info progress-bar-warning');
      //       $('#div_progressbar').addClass('active progress-bar-danger');
      //       $('#div_progressbar').width('100%');
      //       $('#div_progressbar').attr('aria-valuenow',100);
      //       $('#div_progressbar').html('N/A');
      //       return;
      //   }
      //   if(ProgressPourcent == 100){
      //       $('#div_progressbar').removeClass('active progress-bar-info progress-bar-danger progress-bar-warning');
      //       $('#div_progressbar').addClass('progress-bar-success');
      //       $('#div_progressbar').width(ProgressPourcent+'%');
      //       $('#div_progressbar').attr('aria-valuenow',ProgressPourcent);
      //       $('#div_progressbar').html('FIN');
			// 			$('.textAtlas').hide();
      //       Good();
      //       return;
      //   }
      //   $('#div_progressbar').removeClass('active progress-bar-info progress-bar-danger progress-bar-warning');
      //   $('#div_progressbar').addClass('progress-bar-success');
      //   $('#div_progressbar').width(ProgressPourcent+'%');
      //   $('#div_progressbar').attr('aria-valuenow',ProgressPourcent);
      //   $('#div_progressbar').html(ProgressPourcent+'%');
      // }
      function Good(){
        btNext.style.display = 'block';
	      btPrev.style.display = 'block';
        var imgElement = document.querySelector('.img-atlas');
        imgElement.setAttribute('src', '<?php echo config::byKey("product_connection_image"); ?>');
      }
      
      </script>


      <div class="col-md-12 text-center"><h2>{{Merci d'avoir choisi }} <?= config::byKey('product_name'); ?></h2></div>
      <div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
      <div class="col-md-12 text-center"><p class="text-center"><h3 class="textAtlas" id="textAtlas"></h3></p>
      <div class="col-md-12 text-center">
      <div id="contenuTextSpan" class="progress">
      	<div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0; height:20px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
      	</div>
      </div>
      </div>
      </div>