<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<h3 class="step_father">{{Typologie de l'installation}}</h3>
<div class="replace_logo step_father">
	<div class="sel_father text-center cursor" title="{{Appartement}}">
		<img src="/core/img/object_background/cuisine/cuisine_1.jpg">
		<div class="img_title">{{Un appartement}}</div>
	</div>
	<div class="sel_father text-center cursor" title="{{Maison}}">
		<img src="/core/img/object_background/salon/salon_5.jpg">
		<div class="img_title">{{Une maison}}</div>
	</div>
	<div class="sel_father text-center cursor" title="{{Bâtiment}}">
		<img class="img-responsive" src="/core/img/object_background/batiment/industrial_building.jpg">
		<div class="img_title">{{Un bâtiment}}</div>
	</div>
</div>
<div class="step_father bold">{{Sélectionner le type d'installation qui sera géré par}} <?php echo config::byKey('product_name'); ?>.</div>


<h3 class="step_childs hidden"></h3>
<div class="replace_logo step_childs hidden">
</div>
<div class="step_childs bold hidden">{{Sélectionner le type d'installation qui sera géré par}} <?php echo config::byKey('product_name'); ?>.</div>

<script>
	jeedomUtils.initTooltips()

	document.querySelectorAll('.sel_father').forEach(_father => {
		_father.addEventListener('click', function() {
			document.querySelectorAll('.sel_father.selected')?.removeClass('selected')
			this.addClass('selected')
			setTimeout(() => {
				document.querySelectorAll('.step_father').unseen()
				document.querySelectorAll('.step_childs').removeClass('hidden')
				document.querySelector('h3.step_childs').innerText = this.dataset.title
			}, 750);
		})
	})
</script>
