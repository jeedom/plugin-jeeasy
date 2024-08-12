<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
include_file('desktop', 'jeeasy.welcome', 'css', 'jeeasy');
$steps = jeeasy::getWizard();
?>

<button class="btn btn-xs btn-danger" id="bt_quitJeeasyWizard"><i class="fas fa-times"></i> {{Annuler l'assistant}}</button>

<div id="jeeasy_wizard">
	<div class="container" id="jeeasy_container">
		<h3>{{Assistant de configuration}}</h3>
		<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
		<div class="text-center">
			<p>{{Bienvenue dans l'assistant de configuration}} <?php echo config::byKey('product_name'); ?>.</p>
			<p>{{Configurez facilement votre installation <?php echo config::byKey('product_name'); ?> en suivant les étapes de cet assistant interactif.}}</p>
			<br>
			<strong>{{Cliquez sur la flèche en bas à droite pour commencer}} <i class='far fa-arrow-alt-circle-right'></i></strong>
		</div>
	</div>
	<div id="jeeasy_navigation">
		<div>
			<i class="far fa-arrow-alt-circle-left navBtn bt_prev hidden"></i>
		</div>
		<div>
			<?php
			foreach ($steps as $index => $step) {
				echo '<span class="navDot' . (($index == 0) ? ' active' : '') . '" data-step="' . $step['wizard'] . '" data-title="' . $step['title'] . '">';
				echo $index + 1;
				echo '</span>';
			}
			?>
			<div id="div_dots_tooltip"></div>
		</div>
		<div>
			<i class="far fa-arrow-alt-circle-right navBtn bt_next"></i>
			<i class="fas fa-check-circle hidden" id="bt_jeedom_ready"></i>
		</div>
	</div>
</div>

<?php include_file('desktop', 'modal.welcome', 'js', 'jeeasy'); ?>
