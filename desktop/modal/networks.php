<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$internal = config::byKeys(['network::disableInternalAuto', 'network::internalAutoInterface', 'internalAddr']);
$external = config::byKeys(['network::disableMangement', 'externalAddr', 'dns::token', 'market::allowDNS']);
$docker = config::byKeys(['network::localip']);
?>

<h3>{{Paramètres réseaux}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<div class="bold">{{Vous pouvez modifier certains paramètres réseaux de votre installation puis passer à l'étape suivante}}
	<i class="far fa-arrow-alt-circle-right"></i>
</div>

<div class="input-group">
	<span class="input-group-addon roundedLeft">{{Local}}
		<sup><i class="fas fa-question-circle" title="{{Adresse d'accès par le réseau local}}"></i></sup>
	</span>
	<input type="text" class="form-control" id="in_internalAddr" value="<?= $internal['internalAddr'] ?>" <?= ($internal['network::disableInternalAuto'] != 1) ? ' disabled' : '' ?>>
	<span class="input-group-addon interface <?= ($internal['network::disableInternalAuto'] == 1) ? ' hidden' : '' ?>">{{Interface}}</span>
	<select class="form-control interface <?= ($internal['network::disableInternalAuto'] == 1) ? ' hidden' : '' ?>" id="sel_internalInterface">
		<option value="auto" <?= ($internal['network::internalAutoInterface'] == 'auto') ? ' selected' : '' ?>>{{Automatique}}</option>
		<?php
		foreach ((network::getInterfacesInfo()) as $interface) {
			$selected = ($internal['network::internalAutoInterface'] == $interface['ifname']) ? ' selected' : '';
			$ip = (isset($interface['addr_info']) && isset($interface['addr_info'][0])) ? $interface['addr_info'][0]['local'] : '';
		?>
			<option value="<?= $interface['ifname'] ?>" data-ip="<?= $ip ?>" <?= $selected ?>>
				<?= $interface['ifname'] ?>
			</option>
		<?php
		}
		?>
	</select>
	<span class="input-group-btn">
		<?php
		if ($internal['network::disableInternalAuto'] != 1) {
		?>
			<button class="btn btn-warning roundedRight" title="{{Désactiver la gestion automatique de l'adresse d'accès local}}" id="btn_internalAuto">
				<i class="fas fa-times-circle"></i>
			</button>
		<?php
		} else {
		?>
			<button class="btn btn-success roundedRight" title="{{Activer la gestion automatique de l'adresse d'accès local}}" id="btn_internalAuto">
				<i class="fas fa-check-circle"></i>
			</button>
		<?php
		}
		?>
	</span>
</div>

<div class="input-group">
	<span class="input-group-addon roundedLeft">{{Externe}}
		<sup><i class="fas fa-question-circle" title="{{Adresse d'accès par un réseau externe}}"></i></sup>
	</span>
	<?php
	if ($external['dns::token'] != '') {
		if ($external['market::allowDNS'] != 1) {
	?>
			<input type="text" class="form-control" id="in_externalAddr" value="<?= $external['externalAddr'] ?>">
			<span class="input-group-btn">
				<button class="btn btn-success bold" id="btn_allowDNS" title="{{Accès externe disponible, il est recommandé de l'activer}}">
					<i class="fas fa-globe"></i> {{Activer l'accès externe}}
				</button>
			</span>
		<?php
		} else if (!network::dns_run()) {
		?>
			<input type="text" class="form-control" id="in_externalAddr" value="<?= $external['externalAddr'] ?>">
			<span class="input-group-btn">
				<button class="btn btn-success bold" id="btn_startDNS" title="{{Accès externe disponible, il est recommandé de le démarrer}}">
					<i class="fas fa-play"></i> {{Démarrer l'accès externe}}
				</button>
			</span>
		<?php
		} else {
		?>
			<input type="text" class="form-control" value="<?= network::getNetworkAccess('external')  ?>" disabled>
		<?php
		}
	} else {
		?>
		<input type="text" class="form-control" id="in_externalAddr" value="<?= $external['externalAddr'] ?>">
	<?php
	}
	?>
	<span class="input-group-btn">
		<?php
		if ($external['network::disableMangement'] != 1) {
		?>
			<button class="btn btn-warning roundedRight" title="{{Désactiver la gestion automatique de l'adresse d'accès externe}}" id="btn_externalAuto">
				<i class="fas fa-times-circle"></i>
			</button>
		<?php
		} else {
		?>
			<button class="btn btn-success roundedRight" title="{{Activer la gestion automatique de l'adresse d'accès externe}}" id="btn_externalAuto">
				<i class="fas fa-check-circle"></i>
			</button>
		<?php
		}
		?>
	</span>
</div>

<div class="input-group">
	<span class="input-group-addon roundedLeft">{{Docker}}
		<sup><i class="fas fa-question-circle" title="{{Masque d'IP locales pour l'accès Docker}}"></i></sup>
	</span>
	<input type="text" class="form-control roundedRight" id="in_localip" value="<?= $docker['network::localip'] ?>">
</div>

<script>
	document.getElementById('in_internalAddr').addEventListener('change', function() {
		configSave({
			internalAddr: this.value
		})
	})

	document.getElementById('sel_internalInterface').addEventListener('change', function() {
		configSave({
			'network::internalAutoInterface': this.value
		})
		if (this.value == 'auto') {
			for (let _option of this.querySelectorAll('option')) {
				let autoInterface = _option.value
				if (autoInterface == 'auto' || autoInterface == 'lo' || autoInterface.startsWith('docker') || autoInterface.startsWith('tun') || autoInterface.startsWith('br')) {
					continue
				}
				let interfaceIP = _option.dataset.ip
				if (interfaceIP == '' || interfaceIP.startsWith('127.0') || interfaceIP.startsWith('169')) {
					continue
				}
				if (/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(interfaceIP)) {
					document.getElementById('in_internalAddr').value = interfaceIP
					break
				}
			}
		} else {
			document.getElementById('in_internalAddr').value = this.querySelector('option[value="' + this.value + '"]').dataset.ip
		}
		document.getElementById('in_internalAddr').triggerEvent('change')
	})

	document.getElementById('btn_internalAuto').addEventListener('click', function() {
		if (this.hasClass('btn-warning')) {
			configSave({
				'network::disableInternalAuto': 1
			})
			document.getElementById('in_internalAddr').removeAttribute('disabled')
			document.querySelectorAll('.interface').addClass('hidden')
			this.classList.remove('btn-warning')
			this.classList.add('btn-success')
			this.title = "{{Activer la gestion automatique de l'adresse d'accès local}}"
			this.innerHTML = '<i class="fas fa-check-circle"></i>'
		} else {
			configSave({
				'network::disableInternalAuto': 0
			})
			document.getElementById('in_internalAddr').setAttribute('disabled', true)
			document.querySelectorAll('.interface').removeClass('hidden')
			this.classList.remove('btn-success')
			this.classList.add('btn-warning')
			this.title = "{{Désactiver la gestion automatique de l'adresse d'accès local}}"
			this.innerHTML = '<i class="fas fa-times-circle"></i>'
		}
	})

	document.getElementById('in_externalAddr')?.addEventListener('change', function() {
		configSave({
			externalAddr: this.value
		})
	})

	document.getElementById('btn_allowDNS')?.addEventListener('click', function() {
		enableAndStartDNS()
	})

	document.getElementById('btn_startDNS')?.addEventListener('click', function() {
		enableAndStartDNS()
	})

	document.getElementById('btn_externalAuto').addEventListener('click', function() {
		if (this.hasClass('btn-warning')) {
			configSave({
				'network::disableMangement': 1
			})
			this.classList.remove('btn-warning')
			this.classList.add('btn-success')
			this.title = "{{Activer la gestion automatique de l'adresse d'accès externe}}"
			this.innerHTML = '<i class="fas fa-check-circle"></i>'
		} else {
			configSave({
				'network::disableMangement': 0
			})
			this.classList.remove('btn-success')
			this.classList.add('btn-warning')
			this.title = "{{Désactiver la gestion automatique de l'adresse d'accès externe}}"
			this.innerHTML = '<i class="fas fa-times-circle"></i>'
		}
	})

	document.getElementById('in_localip').addEventListener('change', function() {
		configSave({
			'network::localip': this.value
		})
	})

	function enableAndStartDNS() {
		jeedom.network.restartDns({
			error: function(error) {
				jeedomUtils.showAlert({
					message: error.message,
					level: 'danger'
				})
			},
			success: function() {
				loadPageContent(getUrlVars('step'))
			}
		})
	}
</script>
