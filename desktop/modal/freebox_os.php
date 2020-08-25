<?php
  if (!isConnect()) {
      throw new Exception('{{401 - Accès non autorisé}}');
  }
?>

		<script>
		$('#bt_next').hide();
		$('#bt_prev').hide();
		$('.textFreebox').text('{{Installation du Plugin Freebox en cours.}}');
		$.ajax({
			type: "POST", 
			url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php", 
			data: {
			    action: "installPlugin",
			    id: 'Freebox_OS'
			},
			dataType: 'json',
			error: function(request, status, error) {
					handleAjaxError(request, status, error);
			},
			success: function(data) { 
				startModalFreeOS();
            }
    	});

		function startModalFreeOS() {
            $('#jeeesyDefaultDiv').hide();
            $('#contentModal').load('index.php?v=d&modal=authentification&plugin=Freebox_OS&type=Freebox_OS');
          	setTimeout(() => verifFinishFreeOS(), 4000);  
            
        }

		function verifFinishFreeOS() {
           	value = $('#div_progressbar').attr('aria-valuenow');
          	console.log(value)
            if (value != undefined) {
            	if (value == 100) {
                	goodjeeasy();
              	} else {
                	setTimeout(() => verifFinishFreeOS(), 500);
              	}
         	}
       	}

		function goodjeeasy() {
        	$('#bt_next').show();
			$('#bt_prev').show();
          	$('.Freebox_OK').html("Authentification réussie, Vous pouvez continuer");
			$('.img-freeboxOS').attr('src', '<?php echo config::byKey('product_connection_image'); ?>');
        }

    	</script>
<div id="jeeesyDefaultDiv">
  <div class="col-md-12 text-center"><h2>{{Autorisation Freebox}}</h2></div>
  <div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-freeboxOS" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
    <div class="col-md-12 text-center"><p class="text-center"><h3 class="textFreebox">{{Merci d'appuyer sur le bouton V de votre Freebox, afin de confirmer l'autorisation d'accès à votre Delta}}</h3></p>
      <div class="col-md-12 text-center">
        <div id="contenuTextSpan" class="progress">
          </div>
      </div>
    </div>
</div>
</div>
