var _goNext = true
var _contentContainer

(function() {
	_contentContainer = document.getElementById('wizard_container')
	let currentStep = getUrlVars('step')
	if (!currentStep) {
		currentStep = document.querySelector('.navDot').dataset.step
	}
	document.querySelector('.navDot[data-step="' + currentStep + '"]').classList.add('active')
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

document.querySelectorAll('.navDot').forEach(_dot => {
	_dot.addEventListener('click', function() {
		let currentStep = document.querySelector('.navDot.active')
		if (this == currentStep || this.classList.contains('blocked')) {
			return false
		}
		if (!canGoNext()) {
			allowNext()
		}

		let outAnimation = slideOut
		let inAnimation = slideIn
		if (Number(this.innerText) < Number(currentStep.innerText)) {
			outAnimation = slideOutReverse
			inAnimation = slideInReverse
		}

		_contentContainer.animate(outAnimation, {
			duration: 500
		})
		setTimeout(() => {
			document.querySelector('.navDot.active').classList.remove('active')
			this.classList.add('active')
			_contentContainer.empty()
			loadPageContent(this.dataset.step)
			_contentContainer.animate(inAnimation, {
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
			document.querySelector('.navBtn.bt_next').dataset.step = _step
			if (!currentStep.previousElementSibling) {
				document.querySelector('.navBtn.bt_prev').classList.add('hidden')
			} else {
				document.querySelector('.navBtn.bt_prev').title = currentStep.previousElementSibling.dataset.title
				document.querySelector('.navBtn.bt_prev.hidden')?.classList.remove('hidden')
			}
			if (currentStep.nextElementSibling == undefined) {
				document.querySelector('.navBtn.bt_next').classList.add('hidden')
				document.getElementById('bt_jeedom_ready').classList.remove('hidden')
			} else {
				document.getElementById('bt_jeedom_ready').classList.add('hidden')
				document.querySelector('.navBtn.bt_next').title = currentStep.nextElementSibling.dataset.title
				document.querySelector('.navBtn.bt_next.hidden')?.classList.remove('hidden')
			}

			_contentContainer.innerHTML = data
			jeedomUtils.addOrUpdateUrl('step', _step)

			_contentContainer.querySelectorAll('script').forEach(_script => {
				let newScript = document.createElement('script')
				if (_script.src) {
					newScript.src = _script.src
				} else {
					newScript.textContent = _script.textContent
				}
				_contentContainer.appendChild(newScript)
				_contentContainer.removeChild(newScript)
			})
			jeedomUtils.initTooltips(_contentContainer)
		})
		.catch(error => console.error('{{Erreur au chargement de la page}}:', error))
}

function allowNext(_allowed = true) {
	_goNext = _allowed
	let nextDot = document.querySelector('.navDot.active').nextElementSibling
	while (nextDot) {
		if (!_goNext) {
			nextDot.classList.add('blocked')
		} else {
			nextDot.classList.remove('blocked')
		}
		nextDot = nextDot.nextElementSibling
	}
}

function canGoNext() {
	return _goNext
}

function configSave(_configuration, _async = true) {
	jeedom.config.save({
		configuration: _configuration,
		async: _async,
		error: function(_error) {
			jeedomUtils.showAlert({
				message: _error.message,
				level: 'danger'
			})
		}
	})
}

function installPlugin(_marketId, _logicalId, _async = true) {
	jeedom.repo.install({
		id: _marketId,
		repo: 'market',
		async: _async,
		global: false,
		error: function(error) {
			jeedomUtils.showAlert({
				message: error.message,
				level: 'danger'
			})
		},
		success: function() {
			jeedom.plugin.toggle({
				id: _logicalId,
				state: 1,
				global: false,
				error: function(error) {
					jeedomUtils.showAlert({
						message: error.message,
						level: 'danger'
					})
				}
			})
		}
	})
}

function exitJeeasy() {
	configSave({
		'jeedom::firstUse': 0
	})
	loadPage('index.php?v=d&p=dashboard')
}
