<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
include_file('desktop', 'wizard', 'css', 'jeeasy');
$wizardMode = jeeasy::getWizardMode();
sendVarToJS('_wizardMode', $wizardMode);
?>

<button class="btn btn-xs btn-danger" id="bt_quitJeeasyWizard"><i class="fas fa-times"></i> {{Fermer l'assistant}}</button>

<div id="jeeasy_wizard">
	<div class="container text-center" id="wizard_container">
	</div>
	<div class="flex-evenly" id="wizard_navigation">
		<div>
			<i class="far fa-arrow-alt-circle-left navBtn bt_prev hidden"></i>
		</div>
		<div>
			<?php
			$i = 1;
			foreach (jeeasy::getWizardSteps($wizardMode) as $step => $title) {
				echo '<span class="navDot cursor shadowed" data-step="' . $step . '" title="' . $title . '">';
				echo $i;
				echo '</span>';
				$i++;
			}
			?>
		</div>
		<div>
			<i class="far fa-arrow-alt-circle-right navBtn bt_next"></i>
			<i class="fas fa-check-circle hidden" id="bt_jeedom_ready" title="{{Démarrer}}"></i>
		</div>
	</div>
</div>

<?php include_file('desktop', 'wizard', 'js', 'jeeasy'); ?>
