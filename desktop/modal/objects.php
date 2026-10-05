<?php
if (!isConnect()) {
	throw new Exception('401 - {{Accès non autorisé}}');
}
$allObjects = jeeObject::all();
sendVarToJS([
	'jeephp2js.allObjects' => array_combine(array_map(fn($o) => $o->getId(), $allObjects), array_map(fn($o) => $o->getName(), $allObjects)),
	'jeephp2js.rootpath' => realpath(__DIR__ . '/../../../../')
]);

$fathers = [
	'apartment' => [
		'name' => __('Appartement', __FILE__),
		'label' => __('Un appartement', __FILE__),
		'roomsTitle' => __("Configuration de l'appartement", __FILE__),
		'icon' => 'maison-building33',
		'image' => 'salon/salon_4.jpg'
	],
	'house' => [
		'name' => __('Maison', __FILE__),
		'label' => __('Une maison', __FILE__),
		'roomsTitle' => __('Configuration de la maison', __FILE__),
		'icon' => 'maison-modern13',
		'image' => 'salon/salon_3.jpg'
	],
	'building' => [
		'name' => __('Bâtiment', __FILE__),
		'label' => __('Un bâtiment', __FILE__),
		'roomsTitle' => __('Configuration du bâtiment', __FILE__),
		'icon' => 'fas fa-building',
		'image' => 'batiment/industrial_building.jpg'
	]
];

$rooms = [
	'atelier' => [
		'name' => __('Atelier', __FILE__),
		'visible' => false,
		'variants' => [
			['image' => 'atelier/atelier_1.jpg', 'icon' => 'fas fa-toolbox'],
			['image' => 'atelier/atelier_3.jpg', 'icon' => 'fas fa-tools']
		]
	],
	'buanderie' => [
		'name' => __('Buanderie', __FILE__),
		'visible' => false,
		'variants' => [
			['image' => 'buanderie/buanderie_1.jpg', 'icon' => 'kiko-laundry']
		]
	],
	'bureau' => [
		'name' => __('Bureau', __FILE__),
		'visible' => true,
		'variants' => [
			['image' => 'bureau/bureau_1.jpg', 'icon' => 'maison-man337'],
			['image' => 'bureau/bureau_3.jpg', 'icon' => 'fas fa-laptop-house'],
			['image' => 'bureau/bureau_5.jpg', 'icon' => 'maison-man77']
		]
	],
	'cave' => [
		'name' => __('Cave', __FILE__),
		'visible' => false,
		'variants' => [
			['image' => 'cave/cave_1.jpg', 'icon' => 'nourriture-wine23'],
			['image' => 'cave/cave_2.jpg', 'icon' => 'fas fa-wine-bottle'],
			['image' => 'cave/cave_3.jpg', 'icon' => 'kiko-basement']
		]
	],
	'chambre' => [
		'name' => __('Chambre', __FILE__),
		'visible' => true,
		'variants' => [
			['image' => 'chambre/chambre_1.jpg', 'icon' => 'maison-queen9'],
			['image' => 'chambre/chambre_3.jpg', 'icon' => 'fas fa-bed'],
			['image' => 'chambre/chambre_4.jpg', 'icon' => 'kiko-bedroom'],
			['image' => 'chambre/chambre_7.jpg', 'icon' => 'maison-bedroom10'],
			['image' => 'chambre/chambre_6.jpg', 'icon' => 'maison-baby139']
		]
	],
	'cuisine' => [
		'name' => __('Cuisine', __FILE__),
		'visible' => true,
		'variants' => [
			['image' => 'cuisine/cuisine_1.jpg', 'icon' => 'maison-kitchen56'],
			['image' => 'cuisine/cuisine_2.jpg', 'icon' => 'kiko-kitchen']
		]
	],
	'dressing' => [
		'name' => __('Dressing', __FILE__),
		'visible' => false,
		'variants' => [
			['image' => 'dressing/dressing_1.jpg', 'icon' => 'fashion-hanger2']
		]
	],
	'salle_a_manger' => [
		'name' => __('Salle à manger', __FILE__),
		'visible' => true,
		'variants' => [
			['image' => 'salle_a_manger/salle_a_manger_1.jpg', 'icon' => 'maison-dining3'],
			['image' => 'salle_a_manger/salle_a_manger_2.jpg', 'icon' => 'kiko-dining-room']
		]
	],
	'salle_de_bain' => [
		'name' => __('Salle de bain', __FILE__),
		'visible' => true,
		'variants' => [
			['image' => 'salle_de_bain/salle_de_bain_1.jpg', 'icon' => 'fas fa-bath'],
			['image' => 'salle_de_bain/salle_de_bain_2.jpg', 'icon' => 'kiko-bathroom']
		]
	],
	'salon' => [
		'name' => __('Salon', __FILE__),
		'visible' => true,
		'variants' => [
			['image' => 'salon/salon_1.jpg', 'icon' => 'kiko-living-room'],
			['image' => 'salon/salon_2.jpg', 'icon' => 'maison-sofa3'],
			['image' => 'salon/salon_5.jpg', 'icon' => 'fas fa-couch']
		]
	],
	'toilettes' => [
		'name' => __('Toilettes', __FILE__),
		'visible' => false,
		'variants' => [
			['image' => 'toilettes/toilettes_1.jpg', 'icon' => 'maison-toilet1'],
			['image' => 'toilettes/toilettes_3.jpg', 'icon' => 'kiko-guest-toilet']
		]
	]
];
?>

<h3 class="step_father">{{Configuration des objets}}</h3>
<div class="logo step_father flex-evenly">
	<?php
	foreach ($fathers as $key => $father) {
	?>
		<div class="sel_father text-center cursor shadowed" title="<?= htmlspecialchars(sprintf(__('Définir un objet racine "%s"', __FILE__), $father['name'])) ?>" data-father="<?= $key ?>" data-name="<?= $father['name'] ?>" data-rooms_title="<?= $father['roomsTitle'] ?>">
			<img src="core/img/object_background/<?= $father['image'] ?>">
			<div class="object_name"><?= $father['label'] ?>
				<i class="icon <?= $father['icon'] ?>"></i>
			</div>
		</div>
	<?php
	}
	?>
</div>
<div class="step_father bold">{{Vous pouvez sélectionner l'objet principal définissant au mieux votre installation ou passer à l'étape suivante}}
	<i class="far fa-arrow-alt-circle-right"></i>
</div>
<div class="step_father flex-evenly" style="margin:15px">
	<div class="sel_father text-center cursor shadowed" title="{{Ne pas définir d'objet racine}}" data-father="none" data-rooms_title="{{Configuration des pièces}}" data-tippy-placement="bottom">
		<div class="object_name">{{Pas d'objet racine}}</div>
		<img id="no_father" style="opacity:.5">
	</div>
</div>

<h3 class="step_childs hidden">
	<span id="rooms_title"></span>
	<a class="btn btn-default btn-xs" id="bt_changeFather"><i class="fas fa-undo"></i> {{Changer}}</a>
</h3>
<div class="step_childs hidden logo flex-column">
	<div class="bold">{{Vous pouvez sélectionner les pièces à créer puis passer à l'étape suivante}}
		<i class="far fa-arrow-alt-circle-right"></i>
	</div>

	<button class="btn btn-primary" id="toggle_childs" style="margin:10px"><i class="fas fa-sync"></i> {{Voir d'autres pièces}}</button>

	<div class="panel-group" id="rooms">
		<?php
		foreach ($rooms as $key => $room) {
		?>
			<div class="panel panel-default<?= ($room['visible']) ? '' : ' hidden' ?>">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#rooms" aria-expanded="false" href="#room_<?= $key ?>">
							<?= $room['name'] ?> <sub class="room_count_selected">0</sub>
						</a>
					</h4>
				</div>
				<div id="room_<?= $key ?>" class="panel-collapse collapse">
					<div class="panel-body flex-evenly" data-name="<?= $room['name'] ?>">
						<?php
						foreach ($room['variants'] as $variant) {
						?>
							<div class="sel_child text-center cursor shadowed">
								<img src="core/img/object_background/<?= $variant['image'] ?>">
								<div class="object_name">
									<i class="icon <?= $variant['icon'] ?>"></i>
									<?= $room['name'] ?> <span></span>
								</div>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		<?php
		}
		?>
	</div>
</div>

<script>
	(function() {
		const rooms = document.getElementById('rooms')
		let selectedFather = null

		document.getElementById('no_father').src = 'core/img/background/jeedom_abstract_01' + document.body.dataset.theme.toLowerCase().replace('core2019', '') + '.jpg'

		function createObject(_object, _fatherId, _success) {
			let objectId = Object.keys(jeephp2js.allObjects).find(_id => jeephp2js.allObjects[_id] === _object.name)
			if (objectId) {
				_success(objectId)
				return
			}
			jeedom.object.save({
				object: {
					name: _object.name,
					display: {
						icon: _object.icon
					},
					father_id: _fatherId
				},
				error: function(_error) {
					jeedomUtils.showAlert({
						message: _error.message,
						level: 'danger'
					})
				},
				success: function(_result) {
					jeephp2js.allObjects[_result.id] = _object.name
					jeedom.object.uploadImage({
						id: _result.id,
						file: jeephp2js.rootpath + '/' + _object.image,
						error: function(_error) {
							jeedomUtils.showAlert({
								message: _error.message,
								level: 'danger'
							})
						}
					})
					_success(_result.id)
				}
			})
		}

		function createSelectedObjects(_next) {
			let selectedRooms = rooms.querySelectorAll('.sel_child.selected')
			if (selectedFather === null || (selectedFather == 'none' && selectedRooms.length == 0)) {
				_next()
				return
			}

			let roomsList = []
			let roomsMessage = ''
			rooms.querySelectorAll('.panel-body').forEach(_roomVariants => {
				let selectedVariants = Array.from(_roomVariants.querySelectorAll('.sel_child.selected')).sort((_a, _b) => _a.dataset.number - _b.dataset.number)
				selectedVariants.forEach(_child => {
					let name = _roomVariants.dataset.name
					if (selectedVariants.length > 1) {
						name += ' ' + _child.dataset.number
					}
					roomsList.push({
						name: name,
						icon: _child.querySelector('.object_name>i').outerHTML,
						image: _child.querySelector('img').getAttribute('src')
					})
					roomsMessage += '<li>' + _child.querySelector('.object_name').innerHTML + '</li>'
				})
			})
			if (roomsMessage != '') {
				roomsMessage = '<ul>' + roomsMessage + '</ul>'
			}

			let father = null
			let message = roomsMessage
			if (selectedFather != 'none') {
				let fatherCard = document.querySelector('.sel_father[data-father="' + selectedFather + '"]')
				father = {
					name: fatherCard.dataset.name,
					icon: fatherCard.querySelector('.object_name>i').outerHTML,
					image: fatherCard.querySelector('img').getAttribute('src')
				}
				message = '<ul><li>' + father.icon + ' ' + father.name + roomsMessage + '</li></ul>'
			}

			function createRooms(_fatherId, _index = 0) {
				if (_index >= roomsList.length) {
					_next()
					return
				}
				createObject(roomsList[_index], _fatherId, function() {
					createRooms(_fatherId, _index + 1)
				})
			}

			jeeDialog.confirm({
				title: '{{Créer les objets suivants ?}}',
				message: message
			}, function(result) {
				if (result) {
					if (father !== null) {
						createObject(father, null, createRooms)
					} else {
						createRooms(null)
					}
				}
			})
		}

		jeeP.onNext = createSelectedObjects

		document.querySelectorAll('.sel_father').forEach(_father => {
			_father.addEventListener('click', function() {
				selectedFather = this.dataset.father
				document.getElementById('rooms_title').innerText = this.dataset.rooms_title
				document.querySelectorAll('.step_father').addClass('hidden')
				document.querySelectorAll('.step_childs').removeClass('hidden')
			})
		})

		document.getElementById('bt_changeFather').addEventListener('click', function() {
			selectedFather = null
			document.querySelectorAll('.step_childs').addClass('hidden')
			document.querySelectorAll('.step_father').removeClass('hidden')
		})

		document.querySelector('.step_childs.logo').addEventListener('click', function(_event) {
			let _target = null

			if (_target = _event.target.closest('.sel_child')) {
				let roomVariants = _target.parentNode
				let countSelected = roomVariants.closest('.panel').querySelector('.room_count_selected')
				let totalSelected = Number(countSelected.innerText)
				if (_target.classList.contains('selected')) {
					let removedNumber = Number(_target.dataset.number)
					_target.classList.remove('selected')
					delete _target.dataset.number
					totalSelected--
					roomVariants.querySelectorAll('.sel_child.selected').forEach(_child => {
						if (Number(_child.dataset.number) > removedNumber) {
							_child.dataset.number = Number(_child.dataset.number) - 1
						}
					})
				} else {
					_target.classList.add('selected')
					totalSelected++
					_target.dataset.number = totalSelected
				}
				roomVariants.querySelectorAll('.sel_child').forEach(_child => {
					let numberSpan = _child.querySelector('.object_name>span')
					if (_child.classList.contains('selected')) {
						numberSpan.innerText = (totalSelected > 1) ? _child.dataset.number : ''
					} else {
						numberSpan.innerText = (totalSelected > 0) ? totalSelected + 1 : ''
					}
				})
				countSelected.innerText = totalSelected
				countSelected.style.color = (totalSelected > 0) ? 'var(--logo-primary-color)' : ''
				return
			}

			if (_target = _event.target.closest('#toggle_childs')) {
				rooms.querySelector('.collapse.in')?.classList.remove('in')
				rooms.querySelectorAll('.panel').forEach(_panel => {
					_panel.classList.toggle('hidden')
				})
				return
			}
		})
	})()
</script>
