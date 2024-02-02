<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

config::save('FREEBOX_SERVER_APP_NAME', config::byKey('product_name'), 'Freebox_OS');
config::save('FREEBOX_SERVER_DEVICE_NAME', config::byKey('product_name'), 'Freebox_OS');

?>

<script src="../js/common.js"></script>
<script>

	var btNext = document.getElementById('bt_next');
  var btPrev = document.getElementById('bt_prev');
	btNext.style.display = 'none';
	btPrev.style.display = 'none';
	progress(20, 'div_progressbar');
	var textFreeboxElement = document.querySelector('.textFreebox');


	textFreeboxElement.innerHTML = '{{Installation du Plugin Freebox en cours.}}';

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
			textFreeboxElement.innerHTML = '{{Demande d\'autorisation sur votre Freebox Delta}}';
			progress(50, 'div_progressbar');
			autorisationFreebox();
		}
	});

	function autorisationFreebox() {
		$.ajax({
			type: "POST",
			url: "plugins/Freebox_OS/core/ajax/Freebox_OS.ajax.php",
			data: {
				action: "connect",
			},
			dataType: 'json',
			error: function(request, status, error) {
				handleAjaxError(request, status, error);
			},
			success: function(data) {
				if (!data.result.success) {
					$('#div_alert').showAlert({
						message: data.result.msg,
						level: 'danger'
					});
					if (data.result.error_code == "new_apps_denied")
						$('#div_alert').append(".<br>{{Pour activer l'option, il faut se rendre dans}} : mafreebox.free.fr -> {{Paramètres de la Freebox -> Gestion des accès}} <br> {{Et cocher}} : <b>{{Permettre les nouvelles demandes d'associations}}</b>  -> {{Appliquer}}<br>{{De nouveau, cliquez sur}} <b>{{Etape}} 1</b>");
					return;
				} else {
					sendToBdd(data.result);
					textFreeboxElement.innerHTML = '{{Merci d\'appuyer sur le bouton V de votre Freebox, afin de confirmer l\'autorisation d\'accès à votre Delta.}}';
					$('.img-freeboxOS').attr('src', 'plugins/jeeasy/core/img/freebox/freeboxAutorisation.jpg');
					progress(70, 'div_progressbar');
					setTimeout(AskTrackAuthorization, 3000);
				}
			}
		});
	}

	function sendToBdd(jsonParser) {
		var fbx_app_token = jsonParser.result.app_token;
		var fbx_track_id = jsonParser.result.track_id;
		$.ajax({
			type: "POST",
			url: "plugins/Freebox_OS/core/ajax/Freebox_OS.ajax.php",
			data: {
				action: "sendToBdd",
				app_token: fbx_app_token,
				track_id: fbx_track_id
			},
			dataType: 'json',
			error: function(request, status, error) {
				handleAjaxError(request, status, error);
			},
			success: function(data) {
				if (!data) {
					$('#div_alert').showAlert({
						message: data,
						level: 'danger'
					});
					return;
				}
			}
		});
	}

	function AskTrackAuthorization() {
		progress(80, 'div_progressbar');
		$.ajax({
			type: "POST",
			url: "plugins/Freebox_OS/core/ajax/Freebox_OS.ajax.php",
			data: {
				action: "ask_track_authorization",
			},
			dataType: 'json',
			error: function(request, status, error) {
				handleAjaxError(request, status, error);
			},
			success: function(data) {
				//console.log(data);
				if (!data.result.success) {
					$('#div_alert').showAlert({
						message: data.result.msg,
						level: 'danger'
					});
				} else {
					switch (data.result.result.status) {
						case "unknown":
							textFreeboxElement.innerHTML = '{{Vous n\'avez pas validé à temps, il faut vous rendre sur le plugin freebox pour relancer l\'association. Merci}}';
							Good();
							progress(-1, 'div_progressbar');
							break;
						case "pending":
							setTimeout(AskTrackAuthorization, 3000);
							break;
						case "timeout":
							textFreeboxElement.innerHTML = '{{Vous n\'avez pas validé à temps, il faut vous rendre sur le plugin freebox pour relancer l\'association. Merci}}'
							Good();
							progress(-1, 'div_progressbar');
							break;
						case "granted":
							textFreeboxElement.innerHTML = '{{Félicitation votre Freebox est maintenant reliée à Jeedom.}}'
							Good();
							progress(100, 'div_progressbar');
							break;

						case "denied":
							textFreeboxElement.innerHTML = '{{Vous avez refusé, il faut vous rendre sur le plugin freebox pour relancer l\'association. Merci}}':
							progress(-1, 'div_progressbar');
							Good();
							break;
						default:
							$('#div_alert').showAlert({
								message: "REST OK : track_authorization -> Error 4 : {{Inconnue}}",
								level: 'danger'
							});
							Good();
							break;
					}
				}
			}
		});
	}

	function Good() {
		btNext.style.display = 'block';
	  btPrev.style.display = 'block';
		let productConnectionImage = '<?php echo config::byKey('product_connection_image'); ?>';
		document.querySelector('.img-freeboxOS').setAttribute('src', productConnectionImage);
	}


</script>

<div class="col-md-12 text-center">
	<h2>{{Autorisation Freebox}}</h2>
</div>
<div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-freeboxOS" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
	<p class="text-center">
	<h3 class="textFreebox">{{Merci d'appuyer sur le bouton V de votre Freebox, afin de confirmer l'autorisation d'accès à votre Delta}}</h3>
	</p>
	<div class="col-md-12 text-center">
		<div id="contenuTextSpan" class="progress">
			<div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0; height:20px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
		</div>
	</div>
</div>
</div>
