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
	<div class="sel_father text-center cursor shadowed" title=' {{Créer un objet racine "Maison"}}' data-father="house">
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
	<div class="sel_father text-center cursor shadowed hidden" title='{{Créer un objet racine "Général"}}' data-father="general" data-tippy-placement="bottom">
		<div class="img_title">{{Par fonctions}}</div>
		<img src="/core/img/object_background/atelier/atelier_2.jpg">
	</div>
	<div class="sel_father text-center cursor shadowed hidden" title="{{Créer un objet racine personnalisé}}" data-father="custom" data-tippy-placement="bottom">
		<div class="img_title">{{Personnalisé}}</div>
		<img src="/core/img/object_background/salle_de_bain/salle_de_bain_4.jpg">
	</div>
	<div class="sel_father text-center cursor shadowed" title="{{Ne pas créer d'objet racine}}" data-father="none" data-tippy-placement="bottom">
		<div class="img_title">{{Pas d'objet racine}}</div>
		<img id="no_father" style="opacity:.5">
	</div>
</div>

<h3 class="step_childs hidden"></h3>
<div class="step_childs hidden logo flex-column">
	<div class="bold">{{Sélectionnez les pièces à créer puis cliquer sur}}
		<button class="btn btn-success" id="btn_validate_childs"><i class="fas fa-check"></i> {{Valider}}</button>
	</div>

	<hr class="hrPrimary">
	</hr>

	<div class="panel panel-default hidden">
		<div class="panel-heading accordion-toggle collapsed cursor" data-toggle="collapse" data-parent="" aria-expanded="false" href="#atelier">
			<h4 class="panel-title">
				<span class="room_name bold">{{Atelier}}</span>
				<sub><span class="room_count_selected">0</span> {{sélectionnées}}</sub>
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
			<h4 class="panel-title">
				<span class="room_name bold">{{Buanderie}}</span>
				<sub><span class="room_count_selected">0</span> {{sélectionnées}}</sub>
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
			<h4 class="panel-title">
				<span class="room_name bold">{{Bureau}}</span>
				<sub><span class="room_count_selected">0</span> {{sélectionnées}}</sub>
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
			<h4 class="panel-title">
				<span class="room_name bold">{{Cave}}</span>
				<sub><span class="room_count_selected">0</span> {{sélectionnées}}</sub>
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
			<h4 class="panel-title">
				<span class="room_name bold">{{Chambre}}</span>
				<sub><span class="room_count_selected">0</span> {{sélectionnées}}</sub>
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

	<script>
		document.getElementById('no_father').src = '/core/img/background/jeedom_abstract_01' + document.body.dataset.theme.toLowerCase().replace('core2019', '') + '.jpg'

		jeedomUtils.initTooltips()

		var tradFather = {
			'apartment': "{{Configuration de l'appartement}}",
			'house': '{{Configuration de la maison}}',
			'apartment': '"{{Configuration du bâtiment}}"',
			'none': '{{Configuration des pièces}}'
		}

		document.querySelectorAll('.sel_father').forEach(_father => {
			_father.addEventListener('click', function() {
				document.querySelectorAll('.sel_father.selected')?.removeClass('selected')
				this.addClass('selected')
				bootbox.confirm('<strong>' + this.dataset.title + ' ?</strong>', function(result) {
					if (result) {
						document.querySelector('h3.step_childs').innerText = tradFather[_father.dataset.father]
						document.querySelectorAll('.step_father').unseen()
						document.querySelectorAll('.step_childs').removeClass('hidden')

					} else {
						_father.removeClass('selected')
					}
				})
			})
		})

		document.querySelector('.step_childs.logo').addEventListener('click', function() {
			var _target = null

			if (_target = event.target.closest('.panel-heading')) {
				document.querySelectorAll('.collapse.in:not(' + _target.getAttribute('href') + ')').removeClass('in')
				return
			}


			if (_target = event.target.closest('.sel_child')) {
				let countSelectedSpan = _target.closest('.panel-collapse').previousElementSibling.querySelector('.room_count_selected')
				let countSelected = Number(countSelectedSpan.innerText)
				if (_target.hasClass('selected')) {
					_target.removeClass('selected')

					countSelectedSpan.innerText = countSelected - 1
					if (countSelectedSpan.innerText == 0) {
						countSelectedSpan.parentNode.style.color = ''
					}

					let currentNumber = Number(_target.querySelector('.img_title>span').innerText)
					_target.parentNode.querySelectorAll('.sel_child').forEach(_child => {
						let childNumberSpan = _child.querySelector('.img_title>span')
						let childNumber = Number(childNumberSpan.innerText)
						if (currentNumber == 0) {
							childNumberSpan.innerText = ''
						} else {
							if (childNumber < 1) {
								childNumberSpan.innerText = ''
							} else if (childNumber != 1 && childNumber > currentNumber) {
								childNumberSpan.innerText = childNumber - 1
							}
						}
					})
				} else {
					_target.addClass('selected')

					countSelectedSpan.innerText = countSelected + 1
					if (countSelectedSpan.innerText != 0) {
						countSelectedSpan.parentNode.style.color = 'var(--logo-primary-color)'
					}

					_target.parentNode.querySelectorAll('.sel_child:not(.selected)').forEach(_child => {
						let childNumberSpan = _child.querySelector('.img_title>span')
						childNumberSpan.innerText = Number(childNumberSpan.innerText) + 1
					})
				}
				return
			}
		})
	</script>
