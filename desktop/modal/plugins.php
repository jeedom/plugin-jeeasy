<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<h3>{{Installation des plugins}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<h4 id="servicePack"></h4>
<div id="jeeasy-loading"><i class="fas fa-spinner fa-spin"></i> {{Chargement en cours, veuillez patienter un instant...}}</div>
<div class="hidden" id="community">
	<div class="bold">{{Aucun plugin à installer, passer à l'étape suivante}}
		<i class="far fa-arrow-alt-circle-right"></i>
	</div>
</div>
<div class="hidden" id="others">
	<div class="bold">{{Veuillez sélectionner les plugins à installer puis passer à l'étape suivante}}
		<i class="far fa-arrow-alt-circle-right"></i>
	</div>
</div>
<div class="flex-evenly" style="flex-wrap:wrap;" id="plugins">
</div>

<script>
	jeedom.jeeasy.getMarketPluginsList({
		global: false,
		error: function(error) {
			document.getElementById('jeeasy-loading').innerHTML = '<i class="fas fa-times"></i> {{Une erreur est survenue}}: ' + error.message
		},
		success: function(data) {
			document.getElementById('jeeasy-loading').remove()
			document.getElementById('servicePack').innerText = data.servicePack
			if (data.plugins.length <= 0) {
				document.getElementById('community').removeClass('hidden')
			} else {
				document.getElementById('others').removeClass('hidden')
				let plugins = document.getElementById('plugins')
				for (let i in data.plugins) {
					let div = document.createElement('div')
					div.classList = 'plugin cursor shadowed' + ((data.plugins[i].installed) ? ' selected' : '')
					div.dataset.id = data.plugins[i].id
					div.dataset.logicalId = data.plugins[i].logicalId
					div.dataset.installed = data.plugins[i].installed
					let content = '<img src="' + data.plugins[i].icon + '" alt="{{Icone}}">'
					content += '<div class="bold plugin-name">' + data.plugins[i].name + '</div>'
					div.innerHTML = content
					plugins.appendChild(div)

					div.addEventListener('click', function() {
						if (this.dataset.installed != 'true') {
							this.classList.toggle('selected')
							if (document.getElementById('plugins').querySelectorAll('.plugin.selected:not([data-installed="true"])').length > 0) {
								allowNext(false)
							} else {
								allowNext()
							}
						}
					})
				}
			}
		}
	})

	document.querySelector('.navBtn.bt_next').addEventListener('click', function(_event) {
		_event.preventDefault()
		_event.stopImmediatePropagation()

		if (!canGoNext()) {
			let next = this
			let plugins = document.getElementById('plugins').querySelectorAll('.plugin.selected:not([data-installed="true"])')
			let message = '{{Installer les plugins suivants?}}'
			message += '<ul>'
			plugins.forEach(_plugin => {
				message += '<li class="bold"><img src="' + _plugin.querySelector('img').src + '" height="24px"> ' + _plugin.querySelector('.plugin-name').innerText + '</li>'
			})
			message += '</ul>'
			bootbox.confirm(message, function(result) {
				if (result) {
					plugins.forEach(_plugin => {
						jeedom.repo.install({
							id: _plugin.dataset.id,
							repo: 'market',
							async: false,
							error: function(error) {
								jeedomUtils.showAlert({
									message: error.message,
									level: 'danger'
								})
							},
							success: function() {
								jeedom.plugin.toggle({
									id: _plugin.dataset.logicalId,
									state: 1,
									global: false,
									error: function(error) {
										jeedomUtils.showAlert({
											message: error.message,
											level: 'danger'
										})
									}
								})
							}
						})
					})
					allowNext()
					next.triggerEvent('click')
				}
			})
		}
	})
</script>
