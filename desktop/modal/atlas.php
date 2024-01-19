<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

if( file_exists( config::byKey('path_wizard') ) )
  $path_wizard = json_decode( file_get_contents( config::byKey( 'path_wizard' ) ), true );
else
  $path_wizard = json_decode( file_get_contents('plugins/jeeasy/core/data/wizard.json'), true );

$custom = null;

if($path_wizard['trame']['atlas']['custom']){
	if($path_wizard['trame']['atlas']['custom'] != ''){
		$custom = $path_wizard['trame']['atlas']['custom'];
	}
}
?>

		<script>

    var divProgressbar = document.getElementById('div_progressbar');
    var btNext = document.getElementById('bt_next');
    var btPrev = document.getElementById('bt_prev');

    btNext.style.display = 'none';
    btPrev.style.display = 'none';
		progress(20);
    document.getElementById('textAtlas').innerHTML = '{{Installation du Plugin Atlas en cours.}}';

		$.ajax({
			type: "POST",
			url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
			data: {
			    action: "installPlugin",
			    id: 'atlas'
					<?php if($custom['branch']){echo ", branch: '".$custom['branch']."'";} ?>
			},
			dataType: 'json',
			error: function(request, status, error) {
					handleAjaxError(request, status, error);
			},
			success: function(data) {
				testDep();
				progress(50);
			}
    	});

      function testDep(){
        $.ajax({
          type: "POST",
          url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
          data: {
              action: "installDepPlugin",
              id: 'atlas'
          },
          dataType: 'json',
          error: function(request, status, error) {
              handleAjaxError(request, status, error);
          },
          success: function(data) {
            progress(100);
          }
          });
       }

      function progress(ProgressPourcent){
        if(ProgressPourcent == -1){
          divProgressbar.removeClass('progress-bar-success progress-bar-info progress-bar-warning');
          divProgressbar.addClass('active progress-bar-danger');
          divProgressbar.width('100%');
          divProgressbar.attr('aria-valuenow',100);
          divProgressbar.html('N/A');
            return;
        }
        if(ProgressPourcent == 100){
            divProgressbar.classList.remove('active', 'progress-bar-info', 'progress-bar-danger', 'progress-bar-warning');
            divProgressbar.classList.add('progress-bar-success');
            divProgressbar.style.width = ProgressPourcent + '%';
            divProgressbar.setAttribute('aria-valuenow', ProgressPourcent);
            divProgressbar.innerHTML = 'FIN';
            document.getElementById('textAtlas').style.display = 'none';
            Good();
            return;
        }
          divProgressbar.classList.remove('active', 'progress-bar-info', 'progress-bar-danger', 'progress-bar-warning');
          divProgressbar.classList.add('progress-bar-success');
          divProgressbar.style.width = ProgressPourcent + '%';
          divProgressbar.setAttribute('aria-valuenow', ProgressPourcent);
          divProgressbar.innerHTML = ProgressPourcent + '%';
      }
      function Good(){
        btNext.style.display = 'block';
        btNext.style.marginTop = '70px';
        var imgElement = document.querySelector('.img-atlas');
        imgElement.setAttribute('src', '<?php echo config::byKey("product_connection_image"); ?>');

      }
      </script>


      <div class="col-md-12 text-center"><h2>{{Merci d'avoir choisi Jeedom Atlas}}</h2></div>
      <div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
      <div class="col-md-12 text-center"><p class="text-center"><h3 class="textAtlas" id="textAtlas"></h3></p>
      <div class="col-md-12 text-center">
      <div id="contenuTextSpan" class="progress">
      	<div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0; height:20px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
      	</div>
      </div>
      </div>
      </div>