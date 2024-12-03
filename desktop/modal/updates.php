<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('_product', config::byKeys(['product_image', 'product_name']));
?>
<h3>{{Mises à jour}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<div class="bold" id="jeeasy-loading"><i class="fas fa-spinner fa-spin"></i> {{Vérification des mises à jour en cours, veuillez patienter un instant...}}</div>
<div class="flex-evenly" id="updates">
</div>

<script>
	jeedom.update.checkAll({
		global: false,
		error: function(error) {
			jeedomUtils.showAlert({
				message: error.message,
				level: 'danger'
			})
		},
		success: function() {
			jeedom.update.get({
				global: false,
				error: function(error) {
					jeedomUtils.showAlert({
						message: error.message,
						level: 'danger'
					})
				},
				success: function(plugins) {
					if (getUrlVars('step') == 'updates') {
						let updates = []
						plugins.forEach(plugin => {
							if (plugin.status == 'update') {
								updates.push(plugin)
							}
						});

						if (updates.length <= 0) {
							return document.getElementById('jeeasy-loading').innerHTML = "{{Votre installation est à jour, vous pouvez passer à l'étape suivante}} " + '<i class="far fa-arrow-alt-circle-right"></i>'
						}
						let updatesDiv = document.getElementById('updates')
						updates.forEach(update => {
							let div = document.createElement('div')
							div.classList = 'update cursor shadowed'
							div.dataset.id = update.id
							div.dataset.type = update.type
							div.dataset.remoteVersion = update.remoteVersion
							div.title = '{{Actuelle}}: ' + update.localVersion + '<br>{{Nouvelle}}: ' + update.remoteVersion
							let content = '<div class="bold update-name">'
							if (update.type == 'core') {
								content += _product.product_name + '</div>'
								content += '<img src="' + _product.product_image + '" alt="{{Icone}}">'
								div.innerHTML = content
								updatesDiv.insertAdjacentElement('afterbegin', div)
							} else {
								content += update.plugin.name + '</div>'
								content += '<img src="/plugins/' + update.logicalId + '/plugin_info/' + update.logicalId + '_icon.png" alt="{{Icone}}">'
								div.innerHTML = content
								updatesDiv.appendChild(div)
							}

							div.addEventListener('click', function() {
								this.classList.toggle('selected')
								if (document.getElementById('updates').querySelectorAll('.update.selected').length > 0) {
									allowNext(false)
								} else {
									allowNext()
								}
							})
						})
						document.getElementById('jeeasy-loading').innerHTML = "{{Vous pouvez sélectionner les mises à jour à effectuer puis passer à l'étape suivante}} " + '<i class="far fa-arrow-alt-circle-right"></i>'
						jeedomUtils.initTooltips()
					}
				}
			})
		}
	})

	document.querySelector('#wizard_navigation').addEventListener('click', function(_event) {
		var _target = null
		if (_target = event.target.closest('.navBtn.bt_next[data-step="updates"]')) {
			_event.preventDefault()
			_event.stopImmediatePropagation()
			if (!canGoNext()) {
				let updates = document.getElementById('updates').querySelectorAll('.update.selected')
				let message = '{{Effectuer les mises à jour suivantes?}}'
				message += '<ul>'
				updates.forEach(_update => {
					message += '<li><span class="bold">' + _update.querySelector('.update-name').innerText + '</span> (' + _update.dataset.remoteVersion + ')</li>'
				})
				message += '</ul>'
				bootbox.confirm(message, function(result) {
					if (result) {
						updates.forEach(_update => {
							if (_update.dataset.type == 'core') {
								jeedom.update.doAll({
									options: {
										plugins: 0
									},
									error: function(error) {
										jeedomUtils.showAlert({
											message: error.message,
											level: 'danger'
										})
									}
								})
							} else {
								jeedom.update.do({
									id: _update.dataset.id,
									error: function(error) {
										jeedomUtils.showAlert({
											message: error.message,
											level: 'danger'
										})
									}
								})
							}
						})
						allowNext()
						_target.triggerEvent('click')
					}
				})
			}
			return
		}
	})
</script>
