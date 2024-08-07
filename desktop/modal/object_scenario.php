<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

$objects = jeeObject::all();
// getChilds()
?>


<div class="mainContainer" style="height:100%;">
<div class="col-md-12 text-center">
	<h2>{{Choissisons une premiere pièce où se situent vos équipements}}</h2>
</div>
<div style="display:flex;flex-direction:column;justify-content:center;width:100%;align-items:center;">
	<select id="firstSelect" style="width:20%;margin-bottom:40px;">
        <?php
        foreach ($objects as $object) {
            if($object->getEqLogic() == null){
                continue;
            }
            echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
        }
        ?>
    </select>
    <select id="secondSelect" style="width:20%; display:none;">

    </select>

</div>
</div>


<script>
	document.getElementById('contentModal').style.height = '70vh';

    document.getElementById('firstSelect').addEventListener('change', function() {

    var selectedValue = this.value;

    document.getElementById('secondSelect').style.display = 'block';

    $.ajax({
        url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
        type: 'POST',
        data: {
            action : "getChilds",
            object_id: selectedValue
        },
        dataType: 'json',
          error: function(request, status, error) {
            console.log(status);
            handleAjaxError(request, status, error);
          },
        success: function(data) {
            var options = data.result
            // data.result.forEach(function(item) {
            //     console.log(itemParsed.name); 
            // });
            var secondSelect = document.getElementById('secondSelect');
            while (secondSelect.firstChild) {
                secondSelect.removeChild(secondSelect.firstChild);
            }
            options.forEach(function(option) {
                var opt = document.createElement('option');
                opt.value = option.id;
                opt.textContent = option.name;
                secondSelect.appendChild(opt);
            });
        }
    });

});

</script>