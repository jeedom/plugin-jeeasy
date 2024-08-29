<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<h3 class="step_father">{{Configuration des objets}}</h3>
<div class="logo step_father flex-evenly">
	<div class="sel_father text-center cursor shadowed" title='{{Créer un objet racine "Appartement"}}' data-father="apartment">
		<img src="/core/img/object_background/salon/salon_4.jpg">
		<div class="img_title">{{Un appartement}}</div>
	</div>
	<div class="sel_father text-center cursor shadowed" title='{{Créer un objet racine "Maison"}}' data-father="house">
		<img src="/core/img/object_background/chambre/chambre_7.jpg">
		<div class="img_title">{{Une maison}}</div>
	</div>
	<div class="sel_father text-center cursor shadowed" title='{{Créer un objet racine "Bâtiment"}}' data-father="building">
		<img src="/core/img/object_background/batiment/industrial_building.jpg">
		<div class="img_title">{{Un bâtiment}}</div>
	</div>
</div>
<div class="step_father bold">{{Sélectionnez l'objet principal caractérisant au mieux la base de votre installation}} <?php echo config::byKey('product_name'); ?>.</div>
<div class="step_father flex-evenly" style="margin:15px">
	<!-- <div class="sel_father text-center cursor shadowed" title='{{Créer un objet racine "Général"}}' data-father="general" data-tippy-placement="bottom">
		<div class="img_title">{{Par fonctions}}</div>
		<img src="/core/img/object_background/atelier/atelier_2.jpg">
	</div>
	<div class="sel_father text-center cursor shadowed" title="{{Créer un objet racine personnalisé}}" data-father="custom" data-tippy-placement="bottom">
		<div class="img_title">{{Personnalisé}}</div>
		<img src="/core/img/object_background/salle_de_bain/salle_de_bain_4.jpg">
	</div> -->
	<div class="sel_father text-center cursor shadowed" title="{{Ne pas créer d'objet racine}}" data-father="none" data-tippy-placement="bottom">
		<div class="img_title">{{Pas d'objet racine}}</div>
		<img id="no_father" style="opacity:.5">
	</div>
</div>

<h3 class="step_childs hidden"></h3>
<div class="step_childs hidden logo flex-column">
	<div class="bold" style="margin-bottom:15px">{{Sélectionnez les pièces à créer puis cliquer sur}}
		<button class="btn btn-success" id="btn_validate_childs"><i class="fas fa-check"></i> {{Valider}}</button>
	</div>

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
					<div class="img_title">{{Atelier}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/atelier/atelier_3.jpg">
					<div class="img_title">{{Atelier}} <span></span></div>
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
					<div class="img_title">{{Buanderie}} <span></span></div>
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
					<div class="img_title">{{Bureau}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/bureau/bureau_3.jpg">
					<div class="img_title">{{Bureau}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/bureau/bureau_5.jpg">
					<div class="img_title">{{Bureau}} <span></span></div>
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
					<div class="img_title">{{Cave}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/cave/cave_2.jpg">
					<div class="img_title">{{Cave}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/cave/cave_3.jpg">
					<div class="img_title">{{Cave}} <span></span></div>
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
					<div class="img_title">{{Chambre}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/chambre/chambre_3.jpg">
					<div class="img_title">{{Chambre}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/chambre/chambre_4.jpg">
					<div class="img_title">{{Chambre}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/chambre/chambre_6.jpg">
					<div class="img_title">{{Chambre}} <span></span></div>
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
					<div class="img_title">{{Cuisine}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/cuisine/cuisine_2.jpg">
					<div class="img_title">{{Cuisine}} <span></span></div>
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
					<div class="img_title">{{Dressing}} <span></span></div>
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
					<?php if (version_compare(jeedom::version(), '4.4', '>=')) {
						echo '<img src="/core/img/object_background/salle_a_manger/salle_a_manger_1.jpg">';
					} else {
						echo '<img src="/core/img/object_background/salle_%23U00e0_manger/salle_%23U00e0_manger_1.jpg">';
					} ?>
					<div class="img_title">{{Salle à manger}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<?php if (version_compare(jeedom::version(), '4.4', '>=')) {
						echo '<img src="/core/img/object_background/salle_a_manger/salle_a_manger_2.jpg">';
					} else {
						echo '<img src="/core/img/object_background/salle_%23U00e0_manger/salle_%23U00e0_manger_2.jpg">';
					} ?>
					<div class="img_title">{{Salle à manger}} <span></span></div>
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
					<div class="img_title">{{Salle de bain}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salle_de_bain/salle_de_bain_2.jpg">
					<div class="img_title">{{Salle de bain}} <span></span></div>
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
					<div class="img_title">{{Salon}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salon/salon_2.jpg">
					<div class="img_title">{{Salon}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salon/salon_3.jpg">
					<div class="img_title">{{Salon}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/salon/salon_5.jpg">
					<div class="img_title">{{Salon}} <span></span></div>
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
					<div class="img_title">{{Toilettes}} <span></span></div>
				</div>

				<div class="sel_child text-center cursor shadowed">
					<img src="/core/img/object_background/toilettes/toilettes_3.jpg">
					<div class="img_title">{{Toilettes}} <span></span></div>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
	document.getElementById('no_father').src = '/core/img/background/jeedom_abstract_01' + document.body.dataset.theme.toLowerCase().replace('core2019', '') + '.jpg'

	jeedomUtils.initTooltips()

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
			bootbox.confirm('<strong>' + title + ' ?</strong>', function(result) {
				if (result) {
					document.querySelector('h3.step_childs').innerText = childsTitle[_father.dataset.father]
					// document.querySelectorAll('.step_father').unseen() // 4.4 mini
					document.querySelectorAll('.step_father').forEach(_fatherStep => {
						_fatherStep.classList.add('hidden')
					})
					// document.querySelectorAll('.step_childs').classList.remove('hidden') // 4.4 mini
					document.querySelectorAll('.step_childs').forEach(_childStep => {
						_childStep.classList.remove('hidden')
					})
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

				var targetNumber = _target.querySelector('.img_title>span').innerText != ''
				_target.parentNode.querySelectorAll('.sel_child').forEach(_child => {
					let childNumberSpan = _child.querySelector('.img_title>span')
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
					let childNumberSpan = _child.querySelector('.img_title>span')
					childNumberSpan.innerText = (childNumberSpan.innerText != '') ? Number(childNumberSpan.innerText) + 1 : 2
				})
			}
			return
		}
	})
</script>
