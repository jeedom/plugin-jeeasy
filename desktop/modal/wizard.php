<?php
if (!isConnect()) {
	throw new Exception('401 - {{Accès non autorisé}}');
}
// Legacy entry point still opened by older cores first use modal and by the previous jeeasy update modal once its update is done
// Can be removed once the minimum core version ships the first use modal redirecting to the wizard page
?>
<script>
	window.location.href = 'index.php?v=d&m=jeeasy&p=wizard&noFirstUse=1&step=welcome'
</script>
