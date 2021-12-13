<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}


$jsonrpc = repo_market::getJsonRpc();
