<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
include_file('desktop', 'jeeasy.welcome', 'css', 'jeeasy');
$steps = jeeasy::getWizard();
?>

<button class="btn btn-xs btn-danger" id="bt_quitJeeasyWizard"><i class="fas fa-times"></i> {{Annuler l'assistant}}</button>

<div id="jeeasy_wizard">
	<div class="container" id="jeeasy_container">
		<h3>{{Assistant de configuration}}</h3>
		<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
		<div class="text-center">
			<p>{{Bienvenue dans l'assistant de configuration}} <?php echo config::byKey('product_name'); ?>.</p>
			<p>{{Configurez facilement votre installation <?php echo config::byKey('product_name'); ?> en suivant les étapes de cet assistant interactif.}}</p>
			<br>
			<strong>{{Cliquez sur la flèche en bas à droite pour commencer}} <i class='far fa-arrow-alt-circle-right'></i></strong>
		</div>
	</div>
	<div id="jeeasy_navigation">
		<div>
			<i class="far fa-arrow-alt-circle-left navBtn bt_prev hidden"></i>
		</div>
		<div>
			<?php
			foreach ($steps as $index => $step) {
				echo '<span class="navDot' . (($index == 0) ? ' active' : '') . '" data-step="' . $step['wizard'] . '" data-title="' . $step['title'] . '">';
				echo $index + 1;
				echo '</span>';
			}
			?>
			<div id="div_dots_tooltip"></div>
		</div>
		<div>
			<i class="far fa-arrow-alt-circle-right navBtn bt_next"></i>
			<i class="fas fa-check-circle hidden" id="bt_jeedom_ready"></i>
		</div>
	</div>
</div>

<script>
	var contentContainer = document.getElementById('jeeasy_container')

	let currentStep = getUrlVars('step')
	if (currentStep && currentStep != 'welcome') {
		contentContainer.empty()
	}

	var slideOut = {
		opacity: [1, 0],
		transform: ['translateX(0)', 'translateX(-10%)']
	}
	var slideIn = {
		opacity: [0, 1],
		transform: ['translateX(10%)', 'translateX(0)']
	}
	var slideOutReverse = {
		opacity: [1, 0],
		transform: ['translateX(0)', 'translateX(10%)']
	}
	var slideInReverse = {
		opacity: [0, 1],
		transform: ['translateX(-10%)', 'translateX(0)']
	}

	var tooltip = document.getElementById('div_dots_tooltip')

	document.querySelectorAll('.navDot').forEach(_dot => {
		_dot.addEventListener('mouseover', function(_event) {
			tooltip.innerText = this.dataset.title;
			tooltip.style.display = 'block';
			tooltip.style.left = _event.pageX + 'px';
			tooltip.style.top = (_event.pageY + 20) + 'px';
		});

		_dot.addEventListener('mouseout', function() {
			tooltip.style.display = 'none';
		});

		_dot.addEventListener('mousemove', function(_event) {
			tooltip.style.left = _event.pageX + 'px';
			tooltip.style.top = (_event.pageY + 20) + 'px';
		});

		_dot.addEventListener('click', function() {
			let currentStep = document.querySelector('.navDot.active')

			if (this == currentStep) {
				return loadPageContent(this.dataset.step)
			}

			let outAnimation = slideOut
			let inAnimation = slideIn
			if (Number(this.innerText) < Number(currentStep.innerText)) {
				outAnimation = slideOutReverse
				inAnimation = slideInReverse
			}

			contentContainer.animate(outAnimation, {
				duration: 500
			})
			setTimeout(() => {
				contentContainer.empty()
				document.querySelectorAll('.navDot.active').removeClass('active')
				this.addClass('active')
				contentContainer.animate(inAnimation, {
					duration: 500
				})
				loadPageContent(this.dataset.step)
			}, 450)
		})
	})

	if (currentStep && currentStep != 'welcome') {
		document.querySelectorAll('.navDot.active').removeClass('active')
		document.querySelector('.navDot[data-step="' + currentStep + '"]').addClass('active').triggerEvent('click')
	}

	document.querySelectorAll('.navBtn').forEach(_navBtn => {
		_navBtn.addEventListener('click', function() {
			let activeNavDot = document.querySelector('.navDot.active')
			if (this.classList.value.includes('bt_next')) {
				activeNavDot.nextElementSibling.triggerEvent('click')
			} else if (this.classList.value.includes('bt_prev')) {
				activeNavDot.previousElementSibling.triggerEvent('click')
			}
		})
	})

	document.getElementById('bt_quitJeeasyWizard').addEventListener('click', function() {
		let confirm = "{{Voulez-vous vraiment annuler l'assistant de configuration?}}"
		confirm += '<br><br>'
		confirm += '<div class="alert alert-danger text-center">{{Certaines configurations ne seront pas effectuées et plusieurs plugins essentiels ne seront pas installés!}}</div>'
		bootbox.confirm(confirm, function(result) {
			if (result) {
				jeedom.config.save({
					configuration: {
						'jeedom::firstUse': 0
					}
				})
				loadPage('index.php?v=d&p=dashboard')
			}
		})
	})

	document.getElementById('bt_jeedom_ready').addEventListener('click', function() {
		jeedom.config.save({
			configuration: {
				'jeedom::firstUse': 0
			}
		})
		loadPage('index.php?v=d&p=dashboard')
	})

	function loadPageContent(_step) {
		fetch('index.php?v=d&plugin=jeeasy&modal=' + _step)
			.then(response => response.text())
			.then(data => {
				if (_step === 'ready') {
					document.querySelector('.navBtn.bt_next').addClass('hidden')
					document.getElementById('bt_jeedom_ready').removeClass('hidden')
				} else {
					document.getElementById('bt_jeedom_ready').addClass('hidden')
					document.querySelector('.navBtn.bt_next').removeClass('hidden')
				}

				if (_step === 'welcome') {
					document.querySelector('.navBtn.bt_prev').addClass('hidden')
					const parser = new DOMParser()
					const doc = parser.parseFromString(data, 'text/html')
					const newContent = doc.querySelector('.container').innerHTML
					contentContainer.innerHTML = newContent
				} else {
					document.querySelector('.navBtn.bt_prev.hidden')?.removeClass('hidden')
					contentContainer.innerHTML = data
				}
				jeedomUtils.addOrUpdateUrl('step', _step)

				// Rechargement des scripts
				const scripts = contentContainer.querySelectorAll('script');
				scripts.forEach(script => {
					console.log('script', script)
					const newScript = document.createElement('script');
					if (script.src) {
						newScript.src = script.src
					} else {
						newScript.textContent = script.textContent;
					}
					document.getElementById('jeeasy_wizard').appendChild(newScript)
					document.getElementById('jeeasy_wizard').removeChild(newScript)
				})

			})
			.catch(error => console.error('{{Erreur au chargement de la page}}:', error))
	}
</script>
