<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$allObjects = jeeObject::all();
sendVarToJS([
	'_allObjects' => array_combine(array_map(fn($o) => $o->getId(), $allObjects), array_map(fn($o) => $o->getName(), $allObjects)),
	'_rootpath' => realpath(__DIR__ . '/../../../../')
]);
?>

<h3 class="step_father">{{Configuration des objets}}</h3>
<div class="logo step_father flex-evenly">
	<div class="sel_father text-center cursor shadowed" title='{{Définir un objet racine "Appartement"}}' data-father="apartment" data-name="{{Appartement}}">
		<img src="/core/img/object_background/salon/salon_4.jpg">
		<div class="object_name">{{Un appartement}}
			<i class="icon maison-building33"></i>
		</div>
	</div>
	<div class="sel_father text-center cursor shadowed" title='{{Définir un objet racine "Maison"}}' data-father="house" data-name="{{Maison}}">
		<img src="/core/img/object_background/salon/salon_3.jpg">
		<div class="object_name">{{Une maison}}
			<i class="icon maison-modern13"></i>
		</div>
	</div>
	<div class="sel_father text-center cursor shadowed" title='{{Définir un objet racine "Bâtiment"}}' data-father="building" data-name="{{Bâtiment}}">
		<img src="/core/img/object_background/batiment/industrial_building.jpg">
		<div class="object_name">{{Un bâtiment}}
			<i class="icon fas fa-building"></i>
		</div>
	</div>
</div>
<div class="step_father bold">{{Vous pouvez sélectionner l'objet principal caractérisant au mieux la base de votre installation ou passer à l'étape suivante}}
	<i class="far fa-arrow-alt-circle-right"></i>
</div>
<div class="step_father flex-evenly" style="margin:15px">
	<!-- <div class="sel_father text-center cursor shadowed" title='{{Définir un objet racine "Général"}}' data-father="general" data-name="{{Général}}" data-tippy-placement="bottom">
		<div class="object_name">{{Par fonctionnalités}}</div>
		<img src="/core/img/object_background/atelier/atelier_2.jpg">
	</div>
	<div class="sel_father text-center cursor shadowed" title="{{Définir un objet racine personnalisé}}" data-father="custom" data-name="" data-tippy-placement="bottom">
		<div class="object_name">{{Personnalisé}}</div>
		<img src="/core/img/object_background/salle_de_bain/salle_de_bain_4.jpg">
	</div> -->
	<div class="sel_father text-center cursor shadowed" title="{{Ne pas définir d'objet racine}}" data-father="none" data-tippy-placement="bottom">
		<div class="object_name">{{Pas d'objet racine}}</div>
		<img id="no_father" style="opacity:.5">
	</div>
</div>

<h3 class="step_childs hidden"></h3>
<div class="step_childs hidden logo flex-column">
	<div class="bold">{{Vous pouvez sélectionner les pièces à créer puis passer à l'étape suivante}}
		<i class="far fa-arrow-alt-circle-right"></i>
	</div>

	<button class="btn btn-primary" id="toggle_childs" style="margin:10px"><i class="fas fa-sync"></i> {{Voir d'autres pièces}}</button>

	<div class="panel panel-default hidden">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#atelier">
			<h4 class="panel-title bold">
				<span class="room_name">{{Atelier}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="atelier" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/atelier/atelier_1.jpg">
					<div class="object_name">
						<i class="icon fas fa-toolbox"></i>
						{{Atelier}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/atelier/atelier_3.jpg">
					<div class="object_name">
						<i class="icon fas fa-tools"></i>
						{{Atelier}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default hidden">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#buanderie">
			<h4 class="panel-title bold">
				<span class="room_name">{{Buanderie}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="buanderie" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/buanderie/buanderie_1.jpg">
					<div class="object_name">
						<i class="icon kiko-laundry"></i>
						{{Buanderie}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#bureau">
			<h4 class="panel-title bold">
				<span class="room_name">{{Bureau}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="bureau" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/bureau/bureau_1.jpg">
					<div class="object_name">
						<i class="icon maison-man337"></i>
						{{Bureau}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/bureau/bureau_3.jpg">
					<div class="object_name">
						<i class="icon fas fa-laptop-house"></i>
						{{Bureau}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/bureau/bureau_5.jpg">
					<div class="object_name">
						<i class="icon maison-man77"></i>
						{{Bureau}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default hidden">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#cave">
			<h4 class="panel-title bold">
				<span class="room_name">{{Cave}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="cave" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/cave/cave_1.jpg">
					<div class="object_name">
						<i class="icon nourriture-wine23"></i>
						{{Cave}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/cave/cave_2.jpg">
					<div class="object_name">
						<i class="icon fas fa-wine-bottle"></i>
						{{Cave}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/cave/cave_3.jpg">
					<div class="object_name">
						<i class="icon kiko-basement"></i>
						{{Cave}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#chambre">
			<h4 class="panel-title bold">
				<span class="room_name">{{Chambre}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="chambre" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/chambre/chambre_1.jpg">
					<div class="object_name">
						<i class="icon maison-queen9"></i>
						{{Chambre}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/chambre/chambre_3.jpg">
					<div class="object_name">
						<i class="icon fas fa-bed"></i>
						{{Chambre}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/chambre/chambre_4.jpg">
					<div class="object_name">
						<i class="icon kiko-bedroom"></i>
						{{Chambre}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/chambre/chambre_7.jpg">
					<div class="object_name">
						<i class="icon maison-bedroom10"></i>
						{{Chambre}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/chambre/chambre_6.jpg">
					<div class="object_name">
						<i class="icon maison-baby139"></i>
						{{Chambre}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#cuisine">
			<h4 class="panel-title bold">
				<span class="room_name">{{Cuisine}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="cuisine" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/cuisine/cuisine_1.jpg">
					<div class="object_name">
						<i class="icon maison-kitchen56"></i>
						{{Cuisine}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/cuisine/cuisine_2.jpg">
					<div class="object_name">
						<i class="icon kiko-kitchen"></i>
						{{Cuisine}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default hidden">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#dressing">
			<h4 class="panel-title bold">
				<span class="room_name">{{Dressing}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="dressing" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/dressing/dressing_1.jpg">
					<div class="object_name">
						<i class="icon fashion-hanger2"></i>
						{{Dressing}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#salle_a_manger">
			<h4 class="panel-title bold">
				<span class="room_name">{{Salle à manger}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="salle_a_manger" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salle_a_manger/salle_a_manger_1.jpg">
					<div class="object_name">
						<i class="icon maison-dining3"></i>
						{{Salle à manger}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salle_a_manger/salle_a_manger_2.jpg">
					<div class="object_name">
						<i class="icon kiko-dining-room"></i>
						{{Salle à manger}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#salle_de_bain">
			<h4 class="panel-title bold">
				<span class="room_name">{{Salle de bain}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="salle_de_bain" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salle_de_bain/salle_de_bain_1.jpg">
					<div class="object_name">
						<i class="icon fas fa-bath"></i>
						{{Salle de bain}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salle_de_bain/salle_de_bain_2.jpg">
					<div class="object_name">
						<i class="icon kiko-bathroom"></i>
						{{Salle de bain}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#salon">
			<h4 class="panel-title bold">
				<span class="room_name">{{Salon}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="salon" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salon/salon_1.jpg">
					<div class="object_name">
						<i class="icon kiko-living-room"></i>
						{{Salon}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salon/salon_2.jpg">
					<div class="object_name">
						<i class="icon maison-sofa3"></i>
						{{Salon}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salon/salon_5.jpg">
					<div class="object_name">
						<i class="icon fas fa-couch"></i>
						{{Salon}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default hidden">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#toilettes">
			<h4 class="panel-title bold">
				<span class="room_name">{{Toilettes}}</span>
				<sub><span class="room_count_selected">0</span></sub>
			</h4>
		</div>
		<div id="toilettes" class="panel-collapse collapse">
			<div class="panel-body flex-evenly">
				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/toilettes/toilettes_1.jpg">
					<div class="object_name">
						<i class="icon maison-toilet1"></i>
						{{Toilettes}} <span></span>
					</div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/toilettes/toilettes_3.jpg">
					<div class="object_name">
						<i class="icon kiko-guest-toilet"></i>
						{{Toilettes}} <span></span>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
	jeedomUtils.initTooltips()
	document.getElementById('no_father').src = '/core/img/background/jeedom_abstract_01' + document.body.dataset.theme.toLowerCase().replace('core2019', '') + '.jpg'

	var childsTitle = {
		'apartment': "{{Configuration de l'appartement}}",
		'house': '{{Configuration de la maison}}',
		'building': '{{Configuration du bâtiment}}',
		'none': '{{Configuration des pièces}}'
	}

	document.querySelectorAll('.sel_father').forEach(_father => {
		_father.addEventListener('click', function() {
			this.classList.add('selected')
			let title = this.dataset.title || $(this).tooltipster('content')
			bootbox.confirm('<div class="bold">' + title + ' ?</div>', function(result) {
				if (result) {
					allowNext(false)
					document.querySelector('h3.step_childs').innerText = childsTitle[_father.dataset.father]
					document.querySelectorAll('.step_father').addClass('hidden')
					document.querySelectorAll('.step_childs').removeClass('hidden')

				} else {
					_father.classList.remove('selected')
				}
			})
		})
	})

	document.querySelector('.step_childs.logo').addEventListener('click', function() {
		var _target = null

		if (_target = event.target.closest('.panel-heading')) {
			document.querySelector('.collapse.in:not(' + _target.getAttribute('href') + ')')?.classList.remove('in')
			return
		}

		if (_target = event.target.closest('.sel_child')) {
			let countSelectedSpan = _target.closest('.panel-collapse').previousElementSibling.querySelector('.room_count_selected')
			let countSelected = Number(countSelectedSpan.innerText)
			if (_target.classList.contains('selected')) {
				_target.classList.remove('selected')

				let totalSelected = countSelected - 1
				countSelectedSpan.innerText = totalSelected
				if (totalSelected == 0) {
					countSelectedSpan.parentNode.style.color = ''
				}

				var targetNumber = _target.querySelector('.object_name>span').innerText != ''
				_target.parentNode.querySelectorAll('.sel_child').forEach(_child => {
					let childNumberSpan = _child.querySelector('.object_name>span')
					let childNumber = Number(childNumberSpan.innerText)
					if (totalSelected == 0) {
						childNumberSpan.innerText = ''
					} else if (_child.classList.contains('selected')) {
						if (totalSelected == 1 || childNumber == 2 && !targetNumber) {
							childNumberSpan.innerText = ''
						} else if (childNumber > 2) {
							childNumberSpan.innerText = childNumber - 1
						}
					} else {
						childNumberSpan.innerText = totalSelected + 1
					}
				})
			} else {
				_target.classList.add('selected')
				countSelectedSpan.innerText = countSelected + 1
				if (countSelectedSpan.innerText != 0) {
					countSelectedSpan.parentNode.style.color = 'var(--logo-primary-color)'
				}

				_target.parentNode.querySelectorAll('.sel_child:not(.selected)').forEach(_child => {
					let childNumberSpan = _child.querySelector('.object_name>span')
					childNumberSpan.innerText = (childNumberSpan.innerText != '') ? Number(childNumberSpan.innerText) + 1 : 2
				})
			}
			return
		}

		if (_target = event.target.closest('#toggle_childs')) {
			document.querySelector('.collapse.in')?.classList.remove('in')
			document.querySelectorAll('.panel').forEach(_panel => {
				_panel.classList.toggle('hidden')
			})
			return
		}

	})

	document.querySelector('#wizard_navigation').addEventListener('click', function(_event) {
		var _target = null
		if (_target = event.target.closest('.navBtn.bt_next[data-step="objects"]')) {
			_event.preventDefault()
			_event.stopImmediatePropagation()
			if (!canGoNext()) {
				let objectsList = {
					father: {},
					childs: []
				}
				let message = '{{Créer les objets suivants?}}'
				let father = document.querySelector('.sel_father.selected')
				if (isset(father.dataset.name)) {
					objectsList.father = {
						name: father.dataset.name,
						icon: father.querySelector('.object_name>i')?.outerHTML,
						background: father.querySelector('img').getAttribute('src')
					}
					message += '<ul>'
					message += '<li class="bold">' + objectsList.father.icon + ' ' + objectsList.father.name + '</li>'
				}
				message += '<ul>'
				document.querySelectorAll('.sel_child.selected').forEach(_child => {
					objectsList.childs.push({
						name: _child.querySelector('.object_name').innerText.replace(/[\t\n]/g, '').trim(),
						icon: _child.querySelector('.object_name>i')?.outerHTML,
						background: _child.querySelector('img').getAttribute('src')
					})
					message += '<li class="bold">' + _child.querySelector('.object_name').innerHTML + '</li>'
				})
				message += '</ul>'
				if (isset(objectsList.father.name)) {
					message += '</ul>'
				}

				if (isset(objectsList.father.name) || objectsList.childs.length > 0) {
					bootbox.confirm(message, function(result) {
						if (result) {
							let fatherId = null
							if (isset(objectsList.father.name)) {
								fatherId = createObject(objectsList.father)
							}
							objectsList.childs.forEach(_child => {
								createObject(_child, fatherId)
							})
							allowNext()
							_target.triggerEvent('click')
						}
					})
				} else {
					allowNext()
					_target.triggerEvent('click')
				}
			}
			return
		}
	})

	function createObject(_object, _fatherId = null) {
		let objectId = Object.keys(_allObjects).find(key => _allObjects[key] === _object.name)
		if (!objectId) {
			jeedom.object.save({
				object: {
					name: _object.name,
					display: {
						icon: _object.icon
					},
					father_id: _fatherId
				},
				async: false,
				error: function(_error) {
					jeedomUtils.showAlert({
						message: _error.message,
						level: 'danger'
					})
				},
				success: function(_result) {
					objectId = _result.id
					jeedom.object.uploadImage({
						id: objectId,
						file: _rootpath + _object.background,
						error: function(_error) {
							jeedomUtils.showAlert({
								message: _error.message,
								level: 'danger'
							})
						}
					})
				}
			})
		}
		return objectId
	}
</script>
