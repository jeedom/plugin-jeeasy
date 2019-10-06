<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

if( file_exists( config::byKey('path_wizard') ) )
  $path_wizard = json_decode( file_get_contents( config::byKey( 'path_wizard' ) ), true );
else
  $path_wizard = json_decode( file_get_contents('plugins/jeeasy/core/data/wizard.json'), true );
?>
<legend>
    <a class='btn btn-default btn-xs pull-right' id='bt_doNotDisplayFirstUse'><i class="fas fa-eye-slash"></i> Ne plus afficher</a>
</legend>

<div class="bodyModal animated slideInRight">

  <div class="multisteps-form">
    <!--progress bar-->
    <div class="row">
        <div class="multisteps-form__progress">
          <?php
          $i = 0;
          $step = $path_wizard['trame'];
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
      <!--<h2 class="text-center">{{Bienvenue chez vous}} <strong><?php echo config::byKey('market::username'); ?></strong>,</h2>

      <p class="text-center">Votre Assistant va vous aider à configurer votre <?php echo config::byKey('product_name'); ?>.</p>-->
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
  var stepObject = JSON.parse('<?php echo json_encode($step); ?>');
  $('#contentModal').load('index.php?v=d&plugin=jeeasy&modal='+stepObject[0]['wizard']);
	$('#bt_prev').click( function() {
    var current = $( '.current' ).data( 'stepwizard' );
    $( '.current' ).removeClass('current');
    var prev = $(".multisteps-form__progress").find("[data-stepwizard='" + (current - 1) + "']").attr('id');
    $('#contentModal').removeClass('animated').removeClass('fadeIn');
    $('#contentModal').addClass('fadeOut');
    $('#contentModal').addClass('animated');
    $( '#' + prev ).addClass('js-active current');
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
			$('.prevDiv').show();
			$('.nextDiv').show();
		}
    setTimeout(NextWizard( next ), 2000);
  });
});

function NextWizard( step ) {
  $('#contentModal').removeClass('animated').removeClass('fadeOut').addClass('fadeIn');
  $('#contentModal').load('index.php?v=d&plugin=jeeasy&modal='+step);
  $('#contentModal').addClass('animated');
}

// //DOM elements
// const DOMstrings = {
//   stepsBtnClass: 'multisteps-form__progress-btn',
//   stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
//   stepsBar: document.querySelector('.multisteps-form__progress'),
//   stepsForm: document.querySelector('.multisteps-form__form'),
//   stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
//   stepFormPanelClass: 'multisteps-form__panel',
//   stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
//   stepPrevBtnClass: 'js-btn-prev',
//   stepNextBtnClass: 'js-btn-next' };
//
//
// //remove class from a set of items
// const removeClasses = (elemSet, className) => {
//
//   elemSet.forEach(elem => {
//
//     elem.classList.remove(className);
//
//   });
//
// };
//
// //return exect parent node of the element
// const findParent = (elem, parentClass) => {
//
//   let currentNode = elem;
//
//   while (!currentNode.classList.contains(parentClass)) {
//     currentNode = currentNode.parentNode;
//   }
//
//   return currentNode;
//
// };
//
// //get active button step number
// const getActiveStep = elem => {
//   return Array.from(DOMstrings.stepsBtns).indexOf(elem);
// };
//
// //set all steps before clicked (and clicked too) to active
// const setActiveStep = activeStepNum => {
//
//   //remove active state from all the state
//   removeClasses(DOMstrings.stepsBtns, 'js-active');
//
//   //set picked items to active
//   DOMstrings.stepsBtns.forEach((elem, index) => {
//
//     if (index <= activeStepNum) {
//       elem.classList.add('js-active');
//     }
//
//   });
// };
//
// //get active panel
// const getActivePanel = () => {
//
//   let activePanel;
//
//   DOMstrings.stepFormPanels.forEach(elem => {
//
//     if (elem.classList.contains('js-active')) {
//
//       activePanel = elem;
//
//     }
//
//   });
//
//   return activePanel;
//
// };
//
// //open active panel (and close unactive panels)
// const setActivePanel = activePanelNum => {
//
//   //remove active class from all the panels
//   removeClasses(DOMstrings.stepFormPanels, 'js-active');
//
//   //show active panel
//   DOMstrings.stepFormPanels.forEach((elem, index) => {
//     if (index === activePanelNum) {
//
//       elem.classList.add('js-active');
//
//       setFormHeight(elem);
//
//     }
//   });
//
// };
//
// //set form height equal to current panel height
// const formHeight = activePanel => {
//
//   const activePanelHeight = activePanel.offsetHeight;
//
//   DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;
//
// };
//
// const setFormHeight = () => {
//   const activePanel = getActivePanel();
//
//   formHeight(activePanel);
// };
//
// //STEPS BAR CLICK FUNCTION
// DOMstrings.stepsBar.addEventListener('click', e => {
//
//   //check if click target is a step button
//   const eventTarget = e.target;
//
//   if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
//     return;
//   }
//
//   //get active button step number
//   const activeStep = getActiveStep(eventTarget);
//
//   //set all steps before clicked (and clicked too) to active
//   setActiveStep(activeStep);
//
//   //open active panel
//   setActivePanel(activeStep);
// });
//
// //PREV/NEXT BTNS CLICK
// DOMstrings.stepsForm.addEventListener('click', e => {
//
//   const eventTarget = e.target;
//
//   //check if we clicked on `PREV` or NEXT` buttons
//   if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`)))
//   {
//     return;
//   }
//
//   //find active panel
//   const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);
//
//   let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);
//
//   //set active step and active panel onclick
//   if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
//     activePanelNum--;
//
//   } else {
//
//     activePanelNum++;
//
//   }
//
//   setActiveStep(activePanelNum);
//   setActivePanel(activePanelNum);
//
// });
//
// //SETTING PROPER FORM HEIGHT ONLOAD
// window.addEventListener('load', setFormHeight, false);
//
// //SETTING PROPER FORM HEIGHT ONRESIZE
// window.addEventListener('resize', setFormHeight, false);


</script>

<?php
include_file('3rdparty', 'animate/animate', 'css');
include_file('3rdparty', 'animate/animate', 'js');
?>
