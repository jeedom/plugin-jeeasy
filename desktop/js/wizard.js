var contentContainer

(function() {
	contentContainer = document.getElementById('jeeasy_container')
	let currentStep = getUrlVars('step')
	if (!currentStep) {
		currentStep = document.querySelector('.navDot').dataset.step
	}
	document.querySelector('.navDot[data-step="' + currentStep + '"]').addClass('active')
	loadPageContent(currentStep)
})()

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
		tooltip.innerText = this.dataset.title
		tooltip.style.display = 'block'
		tooltip.style.left = _event.pageX + 'px'
		tooltip.style.top = (_event.pageY + 20) + 'px'
	})

	_dot.addEventListener('mouseout', function() {
		tooltip.style.display = 'none'
	})

	_dot.addEventListener('mousemove', function(_event) {
		tooltip.style.left = _event.pageX + 'px'
		tooltip.style.top = (_event.pageY + 20) + 'px'
	})

	_dot.addEventListener('click', function() {
		let currentStep = document.querySelector('.navDot.active')

		if (this == currentStep) {
			return
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
			loadPageContent(this.dataset.step)
			contentContainer.animate(inAnimation, {
				duration: 500
			})
		}, 450)
	})
})

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
			exitJeeasy()
		}
	})
})

document.getElementById('bt_jeedom_ready').addEventListener('click', function() {
	exitJeeasy()
})

function loadPageContent(_step) {
	fetch('index.php?v=d&plugin=jeeasy&modal=' + _step)
		.then(response => response.text())
		.then(data => {
			let currentStep = document.querySelector('.navDot[data-step="' + _step + '"]')
			if (!currentStep.previousElementSibling) {
				document.querySelector('.navBtn.bt_prev').addClass('hidden')
			} else {
				document.querySelector('.navBtn.bt_prev.hidden')?.removeClass('hidden')
			}
			if (currentStep.nextElementSibling.tagName == 'DIV') {
				document.querySelector('.navBtn.bt_next').addClass('hidden')
				document.getElementById('bt_jeedom_ready').removeClass('hidden')
			} else {
				document.getElementById('bt_jeedom_ready').addClass('hidden')
				document.querySelector('.navBtn.bt_next.hidden')?.removeClass('hidden')
			}

			contentContainer.innerHTML = data
			jeedomUtils.addOrUpdateUrl('step', _step)

			// Rechargement des scripts
			const scripts = contentContainer.querySelectorAll('script')
			scripts.forEach(script => {
				console.log('script', script)
				const newScript = document.createElement('script')
				if (script.src) {
					newScript.src = script.src
				} else {
					newScript.textContent = script.textContent
				}
				document.getElementById('jeeasy_wizard').appendChild(newScript)
				document.getElementById('jeeasy_wizard').removeChild(newScript)
			})

		})
		.catch(error => console.error('{{Erreur au chargement de la page}}:', error))
}

function configSave(_configuration) {
	jeedom.config.save({
		configuration: _configuration,
		error: function(_error) {
			jeedomUtils.showAlert({
				message: _error.message,
				level: 'danger'
			})
		},
		success: function() {
			let step = getUrlVars('step')
			switch (step) {
				case 'welcome':
					loadPageContent(step)
					break
			}
		}
	})
}

function exitJeeasy() {
	configSave({
		'jeedom::firstUse': 0
	})
	loadPage('index.php?v=d&p=dashboard')
}
