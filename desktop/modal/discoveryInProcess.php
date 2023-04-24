<?php
if (!isConnect())
{
    throw new Exception('{{401 - Accès non autorisé}}');
}

editDns();

$discovers = jeeasy::discoverNetwork();
sleep(2);
$jsonrpc = repo_market::getJsonRpc();
$marketURL = config::byKey('market::address');
$listPlugins = plugin::listPlugin();
$imgPlugin = '';
$arrayFirst = array();
$arraySecond = array();

?>


<div style="margin-top:2%;width:100%;height:100%;">
<table id="tableDiscover">

  <thead>
    <tr>
      <th style="font-weight:bold;width:500px;">{{NOM FABRICANT}}</th>
      <th style="font-weight:bold;">{{ADRESSE IP}}</th>
      <th style="font-weight:bold;">{{ADRESSE MAC}}</th>
    </tr>
  </thead>
  <tbody>
    <tr></tr>
    <?php
$arrayHtml = array();


function editDns(){
    $result = shell_exec("ip r | grep default");
    $arrayR = explode(' ', $result);
    $ipGateway = $arrayR[2];
    $resultVerif = shell_exec("sudo cat /etc/resolv.conf | grep 'nameserver $ipGateway'");
    if(strpos($resultVerif, $ipGateway) == false){
       shell_exec("sudo sed -i '1inameserver $ipGateway' /etc/resolv.conf");
    }
  }

foreach ($discovers as $name => $value)
{
    $occurence = count($value);
    if (array_key_exists('plugin', $value) == true)
    {
        $arrayFirst[$name] = $value;
    }
    else
    {
        $arraySecond[$name] = $value;
    }
}

foreach ($arrayFirst as $name => $value)
{
    if ($occurence > 2)
    {
        echo '<tr>';
        echo '<td id="tdName" colspan="3">';
        echo $name;
        echo '</td>';
        echo '</tr>';
        foreach ($value as $nbOccurence => $ipocurrence)
        {
            if (is_numeric($nbOccurence))
            {
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
            }
            elseif (in_array($value['ip'], $arrayHtml) == false && in_array($value['mac'], $arrayHtml) == false)
            {
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
            }
            array_push($arrayHtml, $value['ip']);
            array_push($arrayHtml, $value['mac']);
        }
    }
    else
    {
        echo '<tr>';
        echo '<td id="tdName" colspan="3">';
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

    }
?>
         <?php
    foreach ($value['plugin'] as $plugin)
    {
        $arrId = array();
        $arrId['id'] = $plugin['id'];
        if ($jsonrpc->sendRequest('market::byId', $arrId))
        {
            $result = $jsonrpc->getResult();
            $imgPlugin = $result['img'];
            $finalCost = '';
            if ($result['cost'] > 0)
            {
                $finalCost = '(' . $result['cost'] . '.00 €)';
            }
            else
            {
                $finalCost = "(GRATUIT)";
            }
        }

        $class = "btn-info";
        if ($plugin['certification'] == 'official')
        {
            $class = "btn-success";
        }

        echo '<img class="test" src="' . $marketURL . '/' . $imgPlugin["icon"] . '" style="height:105px;width:90px;margin-right:20px">';

        $arrayDescription = explode('.', $result['description']);

        if (in_array($plugin['id'], $listPlugins))
        {
            $essai = 'PLUGIN INSTALLE';
        }
        else
        {
            $essai = 'PLUGIN NON INSTALLE';
        }
        echo '<a class="btn ' . $class . ' btn-xs" style="width:300px;" href="https://www.jeedom.com/market/index.php?v=d&p=market&type=plugin&plugin_id=' . $plugin['id'] . '" target="_blank" >' . $plugin['name'] . '  ' . $finalCost . '  -  ' . $essai . '  ' . '</a> ';
        echo '<span style="margin-left:20px;">' . $arrayDescription[0] . '</span>';
        echo '<br>';

    }
    /* }*/
    echo '</td>';

    echo '</tr>';
    echo '</tr>';
?>
        <?php
}
foreach ($arraySecond as $name => $value)
{
    if ($occurence > 2)
    {
        echo '<tr>';
        echo '<td id="tdName" colspan="3">';
        echo $name;
        echo '</td>';
        echo '</tr>';
        foreach ($value as $nbOccurence => $ipocurrence)
        {
            if (is_numeric($nbOccurence))
            {
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

            }
            elseif (in_array($value['ip'], $arrayHtml) == false && in_array($value['mac'], $arrayHtml) == false)
            {
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

            }
            array_push($arrayHtml, $value['ip']);
            array_push($arrayHtml, $value['mac']);

        }
    }
    else
    {
        echo '<tr>';
        echo '<td id="tdName" colspan="3">';
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

    }

}

?>
  </tbody>
</table>
</div>

<?php include_file('desktop', 'jeeasy', 'css', 'jeeasy');?>
