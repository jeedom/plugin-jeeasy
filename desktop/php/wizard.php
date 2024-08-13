<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
include_file('desktop', 'wizard', 'css', 'jeeasy');
$steps = jeeasy::getWizard();
?>

<button class="btn btn-xs btn-danger" id="bt_quitJeeasyWizard"><i class="fas fa-times"></i> {{Annuler l'assistant}}</button>

<div id="jeeasy_wizard">
	<div class="container" id="jeeasy_container">
	</div>
	<div id="jeeasy_navigation">
		<div>
			<i class="far fa-arrow-alt-circle-left navBtn bt_prev hidden"></i>
		</div>
		<div>
			<?php
			foreach ($steps as $index => $step) {
				echo '<span class="navDot" data-step="' . $step['wizard'] . '" data-title="' . $step['title'] . '">';
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

<?php include_file('desktop', 'wizard', 'js', 'jeeasy'); ?>
