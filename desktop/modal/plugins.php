<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$servicePack = 'Community';
$plugins = array();
$SPInfos = config::byKey('SPInfos', 'jeeasy');
if ($SPInfos != '' || $SPInfos = jeeasy::updateServicePackInfos()) {
	$servicePack = $SPInfos['servicePack'];
	$pluginsDetails = jeeasy::getPluginDetails();
	foreach (((array) $SPInfos['plugins']) as $pluginId) {
		if (isset($pluginsDetails[$pluginId])) {
			$plugins[$pluginId] = $pluginsDetails[$pluginId];
		}
	}
}
?>

<h3>{{Installation des plugins}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<h4><?= $servicePack ?></h4>
<?php
if (empty($plugins)) {
?>
	<div class="bold">{{Aucun plugin à installer, vous pouvez passer à l'étape suivante}}
		<i class="far fa-arrow-alt-circle-right"></i>
	</div>
<?php
} else {
?>
	<div class="bold">{{Vous pouvez sélectionner des plugins à installer puis passer à l'étape suivante}}
		<i class="far fa-arrow-alt-circle-right"></i>
	</div>
<?php
}
?>
<div class="flex-evenly" id="plugins">
	<?php
	foreach ($plugins as $pluginId => $pluginDetails) {
	?>
		<div class="plugin cursor shadowed<?= ($pluginDetails['installed'] ? ' selected' : '') ?>" data-id="<?= $pluginId ?>" data-logicalid="<?= $pluginDetails['logicalId'] ?>" data-installed="<?= $pluginDetails['installed'] ?>" title="<?= $pluginDetails['description'] ?>">
			<div class="bold plugin-name">
				<?php
				if ($pluginDetails['installed']) {
					echo '<i class="fas fa-check-circle icon_blue" title="{{Installé}}"></i>';
				} else {
					echo '<i class="fas fa-times-circle" title="{{Non installé}}"></i>';
					echo '<i class="fas fa-plus-circle icon_green hidden" title="{{A installer}}"></i>';
				}
				?>
				<?= $pluginDetails['name'] ?>
			</div>
			<img src="<?= $pluginDetails['icon'] ?>" alt="{{Icone du plugin}}">
			<div class="plugin-category"><?= $pluginDetails['category'] ?></div>
		</div>
	<?php
	}
	?>
</div>

<script>
	document.getElementById('plugins').querySelectorAll('.plugin').forEach(_plugin => {
		_plugin.addEventListener('click', function() {
			if (this.dataset.installed != '1') {
				this.classList.toggle('selected')
				_plugin.querySelectorAll('.plugin-name>i').forEach(_icon => {
					_icon.classList.toggle('hidden')
				})
				if (document.getElementById('plugins').querySelectorAll('.plugin.selected:not([data-installed="1"])').length > 0) {
					allowNavigation('next', false)
				} else {
					allowNavigation()
				}
			}
		})
	})

	document.querySelector('#wizard_navigation').addEventListener('click', function(_event) {
		var _target = null
		if (_target = event.target.closest('.navBtn.bt_next[data-step="plugins"]')) {
			_event.preventDefault()
			_event.stopImmediatePropagation()
			if (document.querySelector('.navDot.active').nextElementSibling.hasClass('blocked')) {
				let plugins = document.getElementById('plugins').querySelectorAll('.plugin.selected:not([data-installed="1"])')
				let message = '{{Installer les plugins suivants?}}'
				message += '<ul>'
				plugins.forEach(_plugin => {
					message += '<li class="bold"><img src="' + _plugin.querySelector('img').src + '" height="24px"> ' + _plugin.querySelector('.plugin-name').innerText + '</li>'
				})
				message += '</ul>'
				bootbox.confirm(message, function(result) {
					if (result) {
						plugins.forEach(_plugin => {
							installPlugin(_plugin.dataset.id, _plugin.dataset.logicalid)
						})
						allowNavigation()
						_target.triggerEvent('click')
					}
				})
			}
			return
		}
	})
</script>
