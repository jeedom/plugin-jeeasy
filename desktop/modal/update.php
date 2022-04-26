<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

$caught = false;

$username = config::byKey("market::username", 'core', null);
if ($username == null || $username == '') {
	$caught = true;
?>
	<script>
		$('#marketbeforeupdate').show();
	</script>
<?php
}

if (!$caught) {
	config::save('updateWizard', 'okay', 'jeeasy');
?> <script>
		$('#bodymodalupdate').show();
		jeedom.update.doAll({
			options: '',
			error: function(error) {
				$('#md_modal').dialog({
					title: "{{Configuration de votre}} <?php echo config::byKey('product_name'); ?> / {{Mode dégradé}}"
				});
				$('#md_modal').load('index.php?v=d&plugin=jeeasy&modal=wizard').dialog('open');
			},
			success: function() {
				getJeedomLog(1, 'update');
			}
		});
	</script>
<?php
}

?>



<div id="marketbeforeupdate" id="wizardModal" tabindex="502" class="form-group" style="margin:0 auto;display:none">
	<div id="imgbeforeupdate">
		<img src="<?php echo config::byKey('product_connection_image'); ?>" />
	</div>
	<h3>{{Je n'ai pas de compte Market}}</h3>
	<button class="dark btn-lg marketupdatebtn" id="bt_createaccountmarket"><i class="fas fa-sign-in-alt"></i> {{En créer un}} !</button>

	<h3>{{Je possède deja un compte market}}</h3>
	<div class="infosbeforeupdate">
		<div class="mailbeforeupdate">
			<label>{{Nom d'utilisateur}}</label>
			<input type="text" id="login_username_market">

		</div>
		<div class="passwdbeforeupdate">
			<label>{{Mot de passe}}</label>
			<input type="password" autocomplete="new-password" id="login_password_market" style="margin-right:10px;">

		</div>
	</div>
	<br />
	<div class="submitbeforeupdate">
		<button class="btn-lg marketupdatebtn" id="bt_login_market"><i class="fas fa-sign-in-alt"></i> {{Connecter Jeedom au Market}}</button>
	</div>
	<div class="resetPasswordbeforeupdate">
		<a href="https://www.jeedom.com/market/index.php?v=d&p=connection" target="_blank">{{J'ai perdu mon mot de passe}}</a>
	</div>
	<br />
</div>


<div class="bodyModal animated slideInRight" id="bodymodalupdate" id="wizardModal" style="display:none;">
	<div class="multisteps-form">
		<div class="row" id="contentModal">
			<div class="col-md-12 text-center">
				<h2>{{Initialisation de}} <?php echo config::byKey('product_name'); ?></h2>
			</div>
			<div class="col-md-8 col-md-offset-2 text-center"><img class="img-responsive center-block" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
			<div class="col-md-12 text-center">
				<p class="text-center"><br />{{Veuillez patienter quelques instants, cela peut prendre 10 minutes au maximum}}</p>

				<div id="contenuTextSpan" class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	#md_modal {
		<?php
		if (config::byKey('product_connection_color') != '') {
			echo "background:" . config::byKey('product_connection_color') . " !important;";
		} else {
			echo "background-image: linear-gradient(to bottom right, rgba(147,204,1,0.6), rgba(147,204,1,1)) !important;";
		}
		?>
	}

	.next {
		font-size: 50px;
		color: rgba(147, 204, 1, 1);
	}

	h3 {
		color: #93CA02;

	}

	#marketbeforeupdate {
		background-color: #FFFAF0;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		width: 75%;
		height: 100%;
	}

	#imgbeforeupdate {
		margin: 0 auto;
		width: 65%;
		height: 50%;
		border-bottom: 0.30em solid #93CA02;
	}

	#login_username_market {
		margin-right: 10px;
		margin-bottom: 0.25em;
	}

	.marketupdatebtn {
		background-color: #93CA02;
		border: none;
		color: white;
	}

	.infosbeforeupdate {
		display: flex;
		flex-direction: column;
		align-items: flex-end;
	}



	.saveDiv {
		width: 100px;
		height: 100px;
		margin-right: -45px;
		bottom: -40px;
		right: 5px;
		position: absolute;
	}

	.prevDiv {
		width: 100px;
		height: 100px;
		margin-right: -45px;
		bottom: -40px;
		left: 5px;
		position: absolute;
	}

	.nextDiv {
		width: 100px;
		height: 100px;
		margin-right: -45px;
		bottom: -40px;
		right: 5px;
		position: absolute;
	}

	#wizardModal {
		background-color: #FFFFFF !important;
	}

	.bodyModal {
		background-color: white;
		width: 75%;
		min-height: 85%;
		margin: 0 auto;
		padding: 20px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		position: relative;
	}

	.multisteps-form {
		margin-bottom: 0px;
	}
</style>

<script>
	$('#bt_createaccountmarket').click(function() {
		window.open(
			'https://www.jeedom.com/market/index.php?v=d&p=register',
			'_blank'
		)
	});


	$('#bt_login_market').click(function() {
		var username = $('#login_username_market').val()
		var password = $('#login_password_market').val()
		var adress = 'https://jeedom.com/market'
		jeedom.config.save({
			configuration: {
				'market::username': username
			},
			error: function(error) {
				$.fn.showAlert({
					message: error.message,
					level: 'danger'
				})
			},
			success: function(data) {
				jeedom.config.save({
					configuration: {
						'market::password': password
					},
					error: function(error) {
						$.fn.showAlert({
							message: error.message,
							level: 'danger'
						})
						$('.veen').animateCss('shake')
					},
					success: function(data) {
						jeedom.repo.test({
							repo: 'market',
							error: function(error) {
								$.fn.showAlert({
									message: error.message,
									level: 'danger'
								})
								$('.veen').animateCss('shake')
							},
							success: function(data) {
								jeedom.config.save({
									configuration: {
										'updateWizard': 'okay'
									},
									plugin: 'jeeasy',
									error: function(error) {
										$.fn.showAlert({
											message: error.message,
											level: 'danger'
										})
									},
									success: function(data) {}
								})
								$('#marketbeforeupdate').hide();
								$('#bodymodalupdate').show();
								jeedom.update.doAll({
									options: '',
									error: function(error) {
										$('#md_modal').dialog({
											title: "{{Configuration de votre}} <?php echo config::byKey('product_name'); ?> / {{Mode dégradé}}"
										});
										$('#md_modal').load('index.php?v=d&plugin=jeeasy&modal=wizard').dialog('open');
									},
									success: function() {
										getJeedomLog(1, 'update');
									}
								});
							}
						})
					}
				})
			}
		})

	});
</script>



<script>
	var progress = -2;

	function updateProgressBar() {
		if (progress == -4) {
			$('#div_progressbar').removeClass('active progress-bar-info progress-bar-success progress-bar-danger');
			$('#div_progressbar').addClass('progress-bar-warning');
			return;
		}
		if (progress == -3) {
			$('#div_progressbar').removeClass('active progress-bar-info progress-bar-success progress-bar-warning');
			$('#div_progressbar').addClass('progress-bar-danger');
			return;
		}
		if (progress == -2) {
			$('#div_progressbar').removeClass('active progress-bar-info progress-bar-success progress-bar-danger progress-bar-warning');
			$('#div_progressbar').width(0);
			$('#div_progressbar').attr('aria-valuenow', 0);
			$('#div_progressbar').html('0%');
			return;
		}
		if (progress == -1) {
			$('#div_progressbar').removeClass('progress-bar-success progress-bar-danger progress-bar-warning');
			$('#div_progressbar').addClass('active progress-bar-info');
			$('#div_progressbar').width('100%');
			$('#div_progressbar').attr('aria-valuenow', 100);
			$('#div_progressbar').html('N/A');
			return;
		}
		if (progress == 100) {
			$('#div_progressbar').removeClass('active progress-bar-info progress-bar-danger progress-bar-warning');
			$('#div_progressbar').addClass('progress-bar-success');
			$('#div_progressbar').width(progress + '%');
			$('#div_progressbar').attr('aria-valuenow', progress);
			$('#div_progressbar').html(progress + '%');
			return;
		}
		$('#div_progressbar').removeClass('progress-bar-success progress-bar-danger progress-bar-warning');
		$('#div_progressbar').addClass('active progress-bar-info');
		$('#div_progressbar').width(progress + '%');
		$('#div_progressbar').attr('aria-valuenow', progress);
		$('#div_progressbar').html(progress + '%');
	}

	function getJeedomLog(_autoUpdate, _log) {
		$.ajax({
			type: 'POST',
			url: 'core/ajax/log.ajax.php',
			data: {
				action: 'get',
				log: _log,
			},
			dataType: 'json',
			global: false,
			error: function(request, status, error) {
				setTimeout(function() {
					getJeedomLog(_autoUpdate, _log)
				}, 1000);
			},
			success: function(data) {
				if (data.state != 'ok') {
					setTimeout(function() {
						getJeedomLog(_autoUpdate, _log)
					}, 1000);
					return;
				}
				var log = '';
				if ($.isArray(data.result)) {
					for (var i in data.result.reverse()) {
						log += data.result[i] + "\n";
						if (data.result[i].indexOf('[END ' + _log.toUpperCase() + ' SUCCESS]') != -1) {
							progress = 100;
							updateProgressBar();
							$('#md_modal').dialog({
								title: "{{Configuration de votre}} <?php echo config::byKey('product_name'); ?>"
							});
							$('#md_modal').load('index.php?v=d&plugin=jeeasy&modal=wizard').dialog('open');
							_autoUpdate = 0;
						}
						if (data.result[i].indexOf('[END ' + _log.toUpperCase() + ' ERROR]') != -1) {
							progress = -3;
							updateProgressBar();
							$('#md_modal').dialog({
								title: "{{Configuration de votre}} <?php echo config::byKey('product_name'); ?> {{Mode dégradé}}"
							});
							$('#md_modal').load('index.php?v=d&plugin=jeeasy&modal=wizard').dialog('open');
							_autoUpdate = 0;
						}
						if (data.result[i].indexOf('[PROGRESS][5]') != -1) {
							if (progress < 5) {
								progress = 5;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
						if (data.result[i].indexOf('[PROGRESS][15]') != -1) {
							if (progress < 15) {
								progress = 15;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
						if (data.result[i].indexOf('[PROGRESS][25]') != -1) {
							if (progress < 25) {
								progress = 25;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
						if (data.result[i].indexOf('[PROGRESS][30]') != -1) {
							if (progress < 30) {
								progress = 30;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
						if (data.result[i].indexOf('[PROGRESS][35]') != -1) {
							if (progress < 35) {
								progress = 35;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
						if (data.result[i].indexOf('[PROGRESS][40]') != -1) {
							if (progress < 40) {
								progress = 40;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
						if (data.result[i].indexOf('[PROGRESS][50]') != -1) {
							if (progress < 50) {
								progress = 50;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
						if (data.result[i].indexOf('[PROGRESS][55]') != -1) {
							if (progress < 55) {
								progress = 55;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
						if (data.result[i].indexOf('[PROGRESS][75]') != -1) {
							if (progress < 75) {
								progress = 75;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
						if (data.result[i].indexOf('[PROGRESS][90]') != -1) {
							if (progress < 90) {
								progress = 90;
								updateProgressBar();
								_autoUpdate = 1;
							}
						}
					}
				}
				if (init(_autoUpdate, 0) == 1) {
					setTimeout(function() {
						getJeedomLog(_autoUpdate, _log)
					}, 1000);
				} else {}
			}
		});
	}
</script>
