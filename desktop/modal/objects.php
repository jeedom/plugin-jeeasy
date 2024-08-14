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
	<!-- <div class="sel_father text-center cursor shadowed" title='{{Créer un objet racine "Général"}}' data-father="general" data-tippy-placement="bottom">
		<div class="img_title">{{Par fonctions}}</div>
		<img src="/core/img/object_background/salon/salon_4.jpg">
	</div>
	<div class="sel_father text-center cursor shadowed" title="{{Créer un objet racine personnalisé}}" data-father="custom" data-tippy-placement="bottom">
		<div class="img_title">{{Personnalisé}}</div>
		<img src="/core/img/object_background/salon/salon_4.jpg">
	</div> -->
	<div class="sel_father text-center cursor shadowed" title="{{Ne pas créer d'objet racine}}" data-father="none" data-tippy-placement="bottom">
		<div class="img_title">{{Pas d'objet racine}}</div>
		<img id="no_father" style="opacity:.5">
	</div>
</div>

<h3 class="step_childs hidden"></h3>
<div class="logo step_childs hidden">
</div>
<div class="step_childs bold hidden"></div>

<script>
	document.getElementById('no_father').src = '/core/img/background/jeedom_abstract_01' + document.body.dataset.theme.toLowerCase().replace('core2019', '') + '.jpg'

	jeedomUtils.initTooltips()

	var tradFather = {
		'apartment': "{{Configuration de l'appartement}}",
		'house': '{{Configuration de la maison}}',
		'apartment': '"{{Configuration du bâtiment}}"',
		'none': '{{des pièces}}'
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
</script>
