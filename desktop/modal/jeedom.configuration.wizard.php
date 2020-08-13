<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
if( file_exists( config::byKey('path_wizard_configuration') ) )
    $path_wizard = json_decode( file_get_contents( config::byKey( 'path_wizard_configuration' ) ), true );
else
    $path_wizard = json_decode( file_get_contents('plugins/jeeasy/core/data/wizard.configuration.json'), true );
if(config::byKey('updateWizard','jeeasy','none') !== 'okay'){
    if(isset($path_wizard['update']) && $path_wizard['update'] == 1){
        $jeeObjects = jeeObject::all();
        if(!is_object($jeeObjects)){
            ?>
            <script>
                $('#md_modal').dialog({title: "{{Initialisation de votre}} <?php echo config::byKey('product_name'); ?>"});
                $('#md_modal').load('index.php?v=d&plugin=jeeasy&modal=update').dialog('open');
            </script>
            <?php
        }
    }
}
include_file('desktop', 'utils', 'js');
?>
    <div class="bodyModal animated slideInRight">
        <div class="multisteps-form">
            <!--progress bar-->
            <div class="row">
                <div class="multisteps-form__progress">
                    <?php
                    $i = 0;
                    $step = $path_wizard['trame'];
                    //          unset($step[array_search('update', $step)]);
                    usort($step, function($a, $b) {
                        return $a['order'] <=> $b['order'];
                    });
                    foreach ( $step as $key => $value ) {
                        if( $i == 0 )
                            $current_step = ' js-active current';
                        else
                            $current_step = '';
                        echo '<button id="'.$step[$key]['wizard'].'" class="multisteps-form__progress-btn '.$current_step.'" type="button" data-stepwizard="'.$step[$key]['order'].'">'.$step[$key]['title'].'</button>';
                        $i++;
                    }
                    ?>
                </div>
            </div>
            <div class="row" id="contentModal">
                <div id="div_AlertJeeasyJeedomConfigure"></div>
                <div id="div_jeeasyConfigureJeedom" >
                    <?php
                    $j = 0;
                    foreach ( $step as $key => $value ) {
                        if( $j == 0 )
                            $current_step = '';
                        else
                            $current_step = 'hidden';

                        echo '<div class="currentPage '.$step[$key]['wizard'].'" '.$current_step.'>';
                        include_file('desktop', 'configuration/'.$step[$key]['wizard'], 'php', 'jeeasy');
                        echo '</div>';
                        $j++;
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="prevDiv">
            <i class="next fas fa-arrow-circle-left cursor" id="bt_prev"></i>
        </div>
        <div class="nextDiv">
            <i class="next fas fa-arrow-circle-right cursor" id="bt_next"></i>
        </div>
        <div class="saveDiv">
            <i class="next fas fa-check-circle cursor" id="bt_save"></i>
        </div>
    </div>
    <style>
        #md_modal {
        <?php
          if(config::byKey('product_connection_color') != ''){
            echo "background:".config::byKey('product_connection_color')." !important;";
          }else{
            echo "background-image: linear-gradient(to bottom right, rgba(147,204,1,0.6), rgba(147,204,1,1)) !important;";
          }
        ?>
        }
        .next {
            font-size: 50px;
            color: rgba(147,204,1,1);
        }
        .saveDiv {
            width: 100px;
            height: 100px;
            margin-right: -45px;
            bottom: -40px;
            right: 5px;
            position: absolute;
        }
        .prevDiv {
            width: 100px;
            height: 100px;
            margin-right: -45px;
            bottom: -40px;
            left: 5px;
            position: absolute;
        }
        .nextDiv {
            width: 100px;
            height: 100px;
            margin-right: -45px;
            bottom: -40px;
            right: 5px;
            position: absolute;
        }
        .bodyModal{
            background-color : white;
            width: 75%;
            min-height: 85%;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            position: relative;
        }
        .multisteps-form {
            margin-bottom:0px;
        }
        .multisteps-form__progress {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
            margin: 0 auto;
        }
        .multisteps-form__progress-btn {
            transition-property: all;
            transition-duration: 0.15s;
            transition-timing-function: linear;
            transition-delay: 0s;
            position: relative;
            padding-top: 20px;
            color: rgba(108, 117, 125, 0.7);
            text-indent: -9999px;
            border: none;
            background-color: transparent;
            outline: none !important;
            cursor: pointer;
        }
        @media (min-width: 500px) {
            .multisteps-form__progress-btn {
                text-indent: 0;
            }
        }
        .multisteps-form__progress-btn:before {
            position: absolute;
            top: 0;
            left: 50%;
            display: block;
            width: 13px;
            height: 13px;
            content: '';
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
            transition: all 0.15s linear 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            border: 2px solid currentColor;
            border-radius: 50%;
            background-color: #fff;
            box-sizing: border-box;
            z-index: 3;
        }
        .multisteps-form__progress-btn:after {
            position: absolute;
            top: 5px;
            left: calc(-50% - 13px / 2);
            transition-property: all;
            transition-duration: 0.15s;
            transition-timing-function: linear;
            transition-delay: 0s;
            display: block;
            width: 100%;
            height: 2px;
            content: '';
            background-color: currentColor;
            z-index: 1;
        }
        .multisteps-form__progress-btn:first-child:after {
            display: none;
        }
        .multisteps-form__progress-btn.js-active {
            color: rgba(147,204,1,1);
        }
        .multisteps-form__progress-btn.js-active:before {
            -webkit-transform: translateX(-50%) scale(1.2);
            transform: translateX(-50%) scale(1.2);
            background-color: currentColor;
        }
        .multisteps-form__form {
            position: relative;
        }
        .multisteps-form__panel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            opacity: 0;
            visibility: hidden;
        }
        .multisteps-form__panel.js-active {
            height: auto;
            opacity: 1;
            visibility: visible;
        }
    </style>
    <script>
        $( document ).ready(function() {
            $('.prevDiv').hide();
            $('.saveDiv').hide();
            var jsonArr = {};
            var stepObject = JSON.parse('<?php echo json_encode($step); ?>');
            $('#bt_prev').click( function() {
                var current = $( '.current' ).data( 'stepwizard' );
                $( '.current' ).removeClass('current');
                var prev = $(".multisteps-form__progress").find("[data-stepwizard='" + (current - 1) + "']").attr('id');
                var nextID = $(".multisteps-form__progress").find("[data-stepwizard='" + current + "']").attr('id');
                $('#contentModal').removeClass('animated').removeClass('fadeIn');
                $('#contentModal').addClass('fadeOut');
                $('#contentModal').addClass('animated');
                $( '#' + prev ).addClass('js-active current');
                $( '#' + nextID).removeClass('js-active current');
                $('.saveDiv').hide();
                if((current - 1) == 0){
                    $('.prevDiv').hide();
                    $('.nextDiv').show();
                }else{
                    $('.prevDiv').show();
                    $('.nextDiv').show();
                }
                setTimeout(NextWizard( prev ), 2000);
            });
            $('#bt_next').click( function() {
                var current = $( '.current' ).data( 'stepwizard' );
                var stateArr = {};
                stateArr.name = $( '.current' ).prop( 'id' );
                stateArr.state = "ok";
                if($( '.current' ).prop( 'id' ) == "objects"){
                    var ArrSelected = [];
                    $(document).find('input[type="checkbox"]:checked').each(function () {
                        ArrSelected.push(this.name);
                    });
                    sendObjects(ArrSelected);
                }
                $( '.current' ).removeClass('current');
                var next = $(".multisteps-form__progress").find("[data-stepwizard='" + (current + 1) + "']").attr('id');
                $('#contentModal').removeClass('animated').removeClass('fadeIn');
                $('#contentModal').addClass('fadeOut');
                $('#contentModal').addClass('animated');
                $( '#' + next ).addClass('js-active current');
                if((current + 1) == (stepObject.length - 1)){
                    $('.nextDiv').hide();
                    $('.saveDiv').show();
                }else{
                    $('.saveDiv').hide();
                    $('.prevDiv').show();
                    $('.nextDiv').show();
                }
                setTimeout(NextWizard( next ), 2000);
            });
        });
        $('.saveDiv').click( function() {
            jeedom.config.save({
                configuration: {'jeedom::firstUse': 0},
                error: function (error) {
                    $('#div_alertFirstUse').showAlert({message: error.message, level: 'danger'});
                },
                success: function () {
                    $('#div_alertFirstUse').showAlert({message: '{{Sauvegarde réussie}}', level: 'success'});
                }
            });
            $('#md_modal').dialog('close');
            location.reload(true);
        });
        function NextWizard( step ) {
            saveDataConfig();
            $('#contentModal').removeClass('animated').removeClass('fadeOut').addClass('fadeIn');
            $('.currentPage').hide();
            $('.'+step).show();
            $('#contentModal').addClass('animated');
        }
        function saveJson(json){
            console.log('json >' + json);
            $.ajax({
                type: "POST",
                url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
                data: {
                    action: "saveJson",
                    json : json
                },
                global:false,
                dataType: 'json',
                error: function (request, status, error) {
                    handleAjaxError(request, status, error,$('#div_AlertJeeasyLight'));
                },
                success: function (data) {
                    if (data.state != 'ok') {
                        $('#div_AlertJeeasyLight').showAlert({message: data.result, level: 'danger'});
                        return;
                    }
                }
            });
        }
        function sendObjects(objects){
            $.ajax({
                type: "POST",
                url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
                data: {
                    action: "sendObjects",
                    objects : JSON.stringify(objects)
                },
                global:false,
                dataType: 'json',
                error: function (request, status, error) {
                    handleAjaxError(request, status, error,$('#div_AlertJeeasyLight'));
                },
                success: function (data) {
                    if (data.state != 'ok') {
                        $('#div_AlertJeeasyLight').showAlert({message: data.result, level: 'danger'});
                        return;
                    }
                }
            });
        }
        function saveDataConfig(){
            var config = $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0];
            jeedom.config.save({
                configuration: config,
                error: function (error) {
                    $('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
                },
                success: function () {
                    jeedom.config.load({
                        configuration: $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0],
                        error: function (error) {
                            $('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
                        },
                        success: function (data) {
                            $('#div_jeeasyConfigureJeedom').setValues(data, '.configKey');
                            loadAactionOnMessage()
                            modifyWithoutSave = false;
                            //$('#div_AlertJeeasyJeedomConfigure').showAlert({message: '{{Sauvegarde réussie}}', level: 'success'});
                        }
                    });
                    return "ok";
                }
            });
        }

        $('.bt_selectAlertCmd').off('click').on('click', function () {
            var type=$(this).attr('data-type');
            jeedom.cmd.getSelectModal({cmd: {type: 'action', subType: 'message'}}, function (result) {
                $('.configKey[data-l1key="alert::'+type+'Cmd"]').value(result.human);
            });
        });

        $("jeeasyDisplay").delegate(".listCmdAction", 'click', function () {
            var el = $(this).closest('.actionOnMessage').find('.expressionAttr[data-l1key=cmd]');
            jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function (result) {
                el.value(result.human);
                jeedom.cmd.displayActionOption(el.value(), '', function (html) {
                    el.closest('.actionOnMessage').find('.actionOptions').html(html);
                    taAutosize();
                });
            });
        });

        $("jeeasyDisplay").delegate(".listAction", 'click', function () {
            var el = $(this).closest('.actionOnMessage').find('.expressionAttr[data-l1key=cmd]');
            jeedom.getSelectActionModal({}, function (result) {
                el.value(result.human);
                jeedom.cmd.displayActionOption(el.value(), '', function (html) {
                    el.closest('.actionOnMessage').find('.actionOptions').html(html);
                    taAutosize();
                });
            });
        });

        $("jeeasyDisplay").delegate('.bt_removeAction', 'click', function () {
            $(this).closest('.actionOnMessage').remove();
        });

        $('#bt_addActionOnMessage').on('click',function(){
            addActionOnMessage();
        });

        $('.bt_jeeasySave').off('click').on('click',function(){
            saveDataConfig();
        });

        jeedom.config.load({
            configuration: $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0],
            error: function (error) {
                $('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
            },
            success: function (data) {
                $('#div_jeeasyConfigureJeedom').setValues(data, '.configKey');
                loadAactionOnMessage();
                modifyWithoutSave = false;
            }
        });

        $('.testRepoConnection').on('click',function(){
            var repo = $(this).attr('data-repo');
            jeedom.config.save({
                configuration: $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0],
                error: function (error) {
                    $('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
                },
                success: function () {
                    jeedom.config.load({
                        configuration: $('#div_jeeasyConfigureJeedom').getValues('.configKey')[0],
                        error: function (error) {
                            $('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
                        },
                        success: function (data) {
                            $('#div_jeeasyConfigureJeedom').setValues(data, '.configKey');
                            modifyWithoutSave = false;
                            jeedom.repo.test({
                                repo: repo,
                                error: function (error) {
                                    $('#div_AlertJeeasyJeedomConfigure').showAlert({message: error.message, level: 'danger'});
                                },
                                success: function (data) {
                                    $('#div_AlertJeeasyJeedomConfigure').showAlert({message: '{{Test réussi}}', level: 'success'});
                                }
                            });
                        }
                    });
                }
            });
        });

        function loadAactionOnMessage(){
            $('#div_actionOnMessage').empty();
            jeedom.config.load({
                configuration: 'actionOnMessage',
                error: function (error) {
                    $('#div_alert').showAlert({message: error.message, level: 'danger'});
                },
                success: function (data) {
                    if(data == ''){
                        return;
                    }
                    actionOptions = [];
                    for (var i in data) {
                        addActionOnMessage(data[i]);
                    }
                    jeedom.cmd.displayActionsOption({
                        params : actionOptions,
                        async : false,
                        error: function (error) {
                            $('#div_alert').showAlert({message: error.message, level: 'danger'});
                        },
                        success : function(data){
                            for(var i in data){
                                $('#'+data[i].id).append(data[i].html.html);
                            }
                            taAutosize();
                        }
                    });
                }
            });
        }

        function addActionOnMessage(_action) {
            if (!isset(_action)) {
                _action = {};
            }
            if (!isset(_action.options)) {
                _action.options = {};
            }
            var div = '<div class="actionOnMessage">';
            div += '<div class="form-group ">';
            div += '<label class="col-xs-3 control-label">Action</label>';
            div += '<input type="checkbox" class="expressionAttr" data-l1key="options" data-l2key="enable" checked title="{{Décocher pour desactiver l\'action}}" style="display:none;" />';
            div += '<div class="col-xs-4">';
            div += '<div class="input-group">';
            div += '<span class="input-group-btn">';
            div += '<a class="btn btn-default bt_removeAction btn-sm"><i class="fas fa-minus-circle"></i></a>';
            div += '</span>';
            div += '<input class="expressionAttr form-control input-sm cmdAction" data-l1key="cmd" />';
            div += '<span class="input-group-btn">';
            div += '<a class="btn btn-default btn-sm listAction" title="{{Sélectionner un mot-clé}}"><i class="fas fa-tasks"></i></a>';
            div += '<a class="btn btn-default btn-sm listCmdAction"><i class="fas fa-list-alt"></i></a>';
            div += '</span>';
            div += '</div>';
            div += '</div>';
            var actionOption_id = uniqId();
            div += '<div class="col-xs-5 actionOptions" id="'+actionOption_id+'">';
            div += '</div>';
            div += '</div>';
            $('#div_actionOnMessage').append(div);
            $('#div_actionOnMessage .actionOnMessage:last').setValues(_action, '.expressionAttr');
            actionOptions.push({
                expression : init(_action.cmd, ''),
                options : _action.options,
                id : actionOption_id
            });
        }
        /****************************** ajout sab ***************************************/
        $(document).ready(function () {
            $('.activerDns').hide();
            $('.divCheckboxDns').hide();
        })
        function afficher() {
            $('.activerDns').show();
            verifChekedDns();
        }
        function verifChekedDns() {
            var dnsCheked = document.getElementById("dnsCheked");

            if (dnsCheked.checked == true){
            } else {
                dnsCheked.checked = true;
            }
            saveDataConfig();
        }
        /****************************** fin ajout sab ***************************************/

    </script>

<?php
include_file('3rdparty', 'animate/animate', 'css');
include_file('3rdparty', 'animate/animate', 'js');
?>