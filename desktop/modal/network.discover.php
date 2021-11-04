<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}



$discovers = jeeasy::discoverNetwork();
$jsonrpc = repo_market::getJsonRpc();
$marketURL = config::byKey('market::address');
$listPlugins = plugin::listPlugin();
$imgPlugin = '';

/*table table-condensed*/
?>

<table class="tablesorter">
  <thead>
    <tr>
      <th style="font-weight:bold;width:500px;">{{Nom}}</th>
      <th style="font-weight:bold;">{{IP}}</th>
      <th style="font-weight:bold;">{{MAC}}</th>
    </tr>
  </thead>
  <tbody>
    <tr></tr>
    <?php
    $arrayHtml = array();
    /*foreach ($discovers as $mac => $value)*/
    foreach ($discovers as $name => $value){
      $occurence = count($value);
      if($occurence > 2){
        echo '<tr>';
        echo '<td colspan="3" style="font-weight:bold;color:#93ca02;">';
        echo $name;
        echo '</td>';
        echo '</tr>';
        foreach($value as $nbOccurence => $ipocurrence){
          if(is_numeric($nbOccurence)){
            echo '<tr>';
            echo '<td>';
            echo '</td>';
            echo '<td style="font-weight:bold;">';
            echo $ipocurrence["ip"];
            echo '</td>';
            echo '<td style="font-weight:bold;">';
            echo $ipocurrence["mac"];
            echo '</td>';
            echo '<tr>';
            echo '<td colspan="3">';
          /*  echo '<div class="coucou" style="display:flex;">';*/
          }elseif(in_array($value['ip'], $arrayHtml) == false && in_array($value['mac'], $arrayHtml) == false){
            echo '<tr>';
            echo '<td>';
            echo '</td>';
            echo '<td style="font-weight:bold;">';
            echo $value['ip'];
            echo '</td>';
            echo '<td style="font-weight:bold;">';
            echo $value['mac'];
            echo '</td>';
            echo '<tr>';
            echo '<td colspan="3">';
            /*echo '<div class="coucou" style="display:flex;">';*/
          }
          array_push($arrayHtml, $value['ip'] );
          array_push($arrayHtml, $value['mac'] );

        }
      }else{
        echo '<tr>';
        echo '<td colspan="3" style="font-weight:bold;color:#93ca02;">';
        echo $name;
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo '</td>';
        echo '<td style="font-weight:bold;">';
        echo $value['ip'];
        echo '</td>';
        echo '<td style="font-weight:bold;">';
        echo $value['mac'];
        echo '</td>';
        echo '<tr>';
        echo '<td colspan="3">';
      /*  echo '<div class="coucou" style="display:flex;flex-grow:1;">';*/
      }
        ?>
         <?php
         foreach ($value['plugin'] as $plugin) {
             $arrId = array();
             $arrId['id'] = $plugin['id'];
             if ( $jsonrpc->sendRequest('market::byId', $arrId)) {
                  $result = $jsonrpc->getResult();
                  $imgPlugin = $result['img'];
                  $finalCost = '';
                   if($result['cost'] > 0){
                     $finalCost = '('.$result['cost'].'.00 €)';
                   }else{
                     $finalCost = "(GRATUIT)";
                   }
              }

              $class="btn-info";
            if($plugin['certification'] == 'official'){
                $class="btn-success";
            }

            echo '<img class="test" src="'.$marketURL.'/'.$imgPlugin["icon"].'" style="height:105px;width:90px;margin-right:20px">';
          /*  echo '<span style="margin-right:20px;">'.$plugin['name'].'</span>';
            echo '<span style="margin-right:20px;">'.$finalCost.'</span>';*/

            $arrayDescription = explode('.', $result['description']);

            if(in_array($plugin['id'], $listPlugins)){
                 $essai = 'PLUGIN INSTALLE';
                /* echo '<span class="btn '.$class.' btn-xs" style="width:300px;"</span> ';*/
                 /*echo '<span style="margin-left:20px;font-weight:bold;color:#93ca02;">Plugin installé</span>';*/
            }else{
                $essai = 'PLUGIN NON INSTALLE';

                  /*echo '<span style="margin-left:20px;font-weight:bold;color:#93ca02;">Plugin non installé</span>';*/

            }
            echo '<a class="btn '.$class.' btn-xs" style="width:300px;" href="https://www.jeedom.com/market/index.php?v=d&p=market&type=plugin&plugin_id='.$plugin['id'].'" target="_blank" >'.$plugin['name'].'  '.$finalCost.'  -  '.$essai.'  '.'</a> ';
            echo '<span style="margin-left:20px;">'.$arrayDescription[0].'</span>';
            echo '<br>';

            }
        /*  echo '</div>';*/
           echo '</td>';

           echo '</tr>';
           echo '</tr>';
        ?>
        <?php
      }
    ?>
  </tbody>
</table>
