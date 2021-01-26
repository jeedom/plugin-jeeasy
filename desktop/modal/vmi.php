<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<iframe src="index.php?v=d&plugin=ventilairsec&modal=integrator" />
