
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

 /*************MODULE CONFIGURATION***************************/

 JEEASY_TYPE_LIST =  [
 {text: '{{Frigo}}',value: 'fridge'},
 {text: '{{Lumière}}',value: 'light'}
 ]

 function jeeasyModalConfigurationEqLogic(_eqLogic_id,_type){
 	switch(_type) {
 		case 'fridge':
 		$('#md_modal').dialog({title: "{{Configuration frigo}}"});
 		$("#md_modal").load('index.php?v=d&modal=fridge.eqLogic.configure&plugin=jeeasy&eqLogic_id='+_eqLogic_id).dialog('open');
 		break;
 		case 'light':
 		$('#md_modal').dialog({title: "{{Configuration lumière}}"});
 		$("#md_modal").load('index.php?v=d&modal=light.eqLogic.configure&plugin=jeeasy&eqLogic_id='+_eqLogic_id).dialog('open');
 		break;
 	}
 }

 $('#bt_jeeasyEqLogicConfiguration').on('click',function(){
 	jeedom.eqLogic.getSelectModal({}, function (eqLogic) {
 		bootbox.prompt({
 			title: "{{Très bien configurons ce module. Quel est son type ?}}",
 			inputType: 'select',
 			inputOptions: JEEASY_TYPE_LIST,
 			callback: function (type) {
 				if(type == null){
 					return;
 				}
 				jeeasyModalConfigurationEqLogic(eqLogic.id,type);
 			}
 		});
 	});
 });

 $('#bt_jeeasyIncludeConfiguration').on('click',function(){
 	bootbox.prompt({
 		title: "{{Très bien ajoutons un module à votre domotique. Quelle est sa technologie ?}}",
 		inputType: 'select',
 		inputOptions: [
 		{text: '{{EnOcean}}',value: 'enoncean'},
 		{text: '{{Rfxcom}}',value: 'rfxcom'},
 		{text: '{{Zwave}}',value: 'zwave'},
 		{text: '{{Sonos}}',value: 'sonos3'},
 		{text: '{{Philips Hue}}',value: 'philipshue'},
 		],
 		callback: function (type) {
 			if(type == null){
 				return;
 			}
 			switch(type) {
 				case 'enoncean':
 				$('#md_modal').dialog({title: "{{Ajout d'un module enOcean}}"});
 				$("#md_modal").load('index.php?v=d&modal=enocean.include&plugin=jeeasy').dialog('open');
 				break;
 				case 'rfxcom':
 				$('#md_modal').dialog({title: "{{Ajout d'un module RFXcom}}"});
 				$("#md_modal").load('index.php?v=d&modal=rfxcom.include&plugin=jeeasy').dialog('open');
 				break;
 				case 'zwave':
 				$('#md_modal').dialog({title: "{{Ajout d'un module Zwave}}"});
 				$("#md_modal").load('index.php?v=d&modal=zwave.include&plugin=jeeasy').dialog('open');
 				break;
 				case 'sonos3':
 				$('#md_modal').dialog({title: "{{Ajout d'un module Sonos}}"});
 				$("#md_modal").load('index.php?v=d&modal=sonos3.include&plugin=jeeasy').dialog('open');
 				break;
 				case 'philipshue':
 				$('#md_modal').dialog({title: "{{Ajout d'un module Philips Hue}}"});
 				$("#md_modal").load('index.php?v=d&modal=philipshue.include&plugin=jeeasy').dialog('open');
 				break;
 			}
 		}
 	});
 });

 $('#bt_jeeasyMainConfiguration').on('click',function(){
 	$('#md_modal').dialog({title: "{{Configuration frigo}}"});
 	$("#md_modal").load('index.php?v=d&modal=jeedom.configuration.wizard&plugin=jeeasy').dialog('open');
 });

 $('#bt_jeeasyDiscovery').on('click',function(){
   $('#md_modal').dialog({title: "{{Discovery}}"});
   $("#md_modal").load('index.php?v=d&modal=network.discover&plugin=jeeasy').dialog('open');
 });

 $('#bt_jeeasyWizard').on('click',function(){
   $('#md_modal').dialog({title: "{{Bienvenue}}"});
   $("#md_modal").load('index.php?v=d&modal=wizard&plugin=jeeasy').dialog('open');
 });


 $('#bt_jeeasyObjectConfiguration').on('click',function(){
 	bootbox.confirm({
 		message: "{{Très bien configurons votre maison. Que souhaitez vous faire ?}}",
 		buttons: {
 			confirm: {
 				label: '<i class="fas fa-plus"></i> {{Créer une nouvelle pièce}}',
 				className: 'btn-success'
 			},
 			cancel: {
 				label: '<i class="fas fa-pencil-alt"></i> {{Modifier une pièce existante}}',
 				className: 'btn-default'
 			}
 		},
 		callback: function (result) {
 			if(result == null){
 				return;
 			}
 			if(result){
 				bootbox.prompt("{{Quel est le nom de cette nouvelle pièce ?}}", function(result){
 					if(result == null){
 						return;
 					}
 					jeedom.object.save({
 						object : {name : result},
 						error: function (error) {
 							$('#div_alert').showAlert({message: error.message, level: 'danger'});
 						},
 						success: function (data) {
 							$('#md_modal').dialog({title: "{{Configuration pièce}}"});
 							$("#md_modal").load('index.php?v=d&modal=object.configure&plugin=jeeasy&object_id='+data.id).dialog('open');
 						}
 					})
 				});
 			}else{
 				jeedom.object.all({
 					error: function (error) {
 						$('#div_alert').showAlert({message: error.message, level: 'danger'});
 					},
 					success: function (data) {
 						var inputOptions = [];
 						for(var i in data){
 							inputOptions.push({text : data[i].name,value : data[i].id});
 						}
 						bootbox.prompt({
 							title: "{{Très bien quel objet voulez vous modifier ?}}",
 							inputType: 'select',
 							inputOptions: inputOptions,
 							callback: function (result) {
 								if(result == null){
 									return;
 								}
 								$('#md_modal').dialog({title: "{{Configuration pièce}}"});
 								$("#md_modal").load('index.php?v=d&modal=object.configure&plugin=jeeasy&object_id='+result).dialog('open');
 							}
 						});
 					}
 				})
 			}
 		}
 	});
 });
