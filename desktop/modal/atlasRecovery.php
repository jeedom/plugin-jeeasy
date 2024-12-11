<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
include_file('core', 'atlas', 'class.js', 'atlas');
?>

<script>
	updateContent('index.php?v=d&plugin=atlas&modal=recovery.atlas')

	if (isset(_checkRecovery)) {
		clearInterval(_checkRecovery)
	}
	var _checkRecovery = setInterval(() => {
		if (_atlasRecoveryInProgress) {
			allowNavigation('prev', false)
			document.getElementById('bt_quitJeeasyWizard').addClass('hidden')
			document.getElementById('bt_cancel').removeClass('hidden')
		} else {
			allowNavigation()
			document.getElementById('bt_quitJeeasyWizard').removeClass('hidden')
			document.getElementById('bt_cancel').addClass('hidden')
		}
	}, 250);
</script>
