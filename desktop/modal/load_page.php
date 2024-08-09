<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $directory = __DIR__; 
    $allowed_pages = glob($directory . '/*.php'); 

    $allowed_pages = array_map('basename', $allowed_pages);

    if (in_array($page, $allowed_pages)) {
        ob_start();
        include $page;
        $content = ob_get_clean();
        echo $content;
    } else {
        http_response_code(403);
        echo 'Page non autorisée';
    }
} else {
    http_response_code(400);
    echo 'Paramètre de page manquant';
}
?>