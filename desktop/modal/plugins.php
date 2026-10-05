<?php
if (!isConnect()) {
	throw new Exception('401 - {{Accès non autorisé}}');
}
$servicePack = 'Community';
$plugins = array();
$pluginsDetails = jeeasy::getPluginDetails();
// Dedicated plugin listed first
$hardwarePluginIds = array('atlas' => 4195, 'luna' => 4346, 'freeboxdelta' => 1666);
$hardware = strtolower(jeedom::getHardwareName());
if (isset($hardwarePluginIds[$hardware])) {
	$plugins[$hardwarePluginIds[$hardware]] = $pluginsDetails[$hardwarePluginIds[$hardware]];
}
$SPInfos = config::byKey('SPInfos', 'jeeasy');
if ($SPInfos != '' || $SPInfos = jeeasy::updateServicePackInfos()) {
	$servicePack = $SPInfos['servicePack'];
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
	(function() {
		const pluginList = document.getElementById('plugins')

		function installSelectedPlugins(_next) {
			let selected = pluginList.querySelectorAll('.plugin.selected:not([data-installed="1"])')
			if (selected.length == 0) {
				_next()
				return
			}
			let message = '<ul>'
			selected.forEach(_plugin => {
				message += '<li><img src="' + _plugin.querySelector('img').src + '" height="24px"> ' + _plugin.querySelector('.plugin-name').innerText + '</li>'
			})
			message += '</ul>'
			jeeDialog.confirm({
				title: '{{Installer les plugins suivants ?}}',
				message: message
			}, function(result) {
				if (result) {
					selected.forEach(_plugin => {
						jeeFrontEnd.jeeasyTools.installPlugin(_plugin.dataset.id, _plugin.dataset.logicalid)
					})
					_next()
				}
			})
		}

		jeeP.onNext = installSelectedPlugins

		pluginList.addEventListener('click', function(_event) {
			let _target = null
			if (_target = _event.target.closest('.plugin:not([data-installed="1"])')) {
				_target.classList.toggle('selected')
				_target.querySelectorAll('.plugin-name>i').forEach(_icon => {
					_icon.classList.toggle('hidden')
				})
			}
		})
	})()
</script>
