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

"use strict"

jeeFrontEnd.jeeasyWizard = {
	init: function() {
		window.jeeP = this
		this.container = document.getElementById('wizard_container')
		// Optional step action run before moving forward, calls the given callback to proceed
		this.onNext = null

		let step = getUrlVars('step')
		if (!step || !document.querySelector('.navDot[data-step="' + step + '"]')) {
			step = document.querySelector('.navDot').dataset.step
		}
		document.querySelector('.navDot[data-step="' + step + '"]').classList.add('active')
		setTimeout(() => {
			this.loadStep(step)
		}, 250)
	},
	goToStep: function(_dot) {
		let current = document.querySelector('.navDot.active')
		jeeFrontEnd.jeeasyTools.slide(this.container, Number(_dot.innerText) < Number(current.innerText), () => {
			current.classList.remove('active')
			_dot.classList.add('active')
			this.loadStep(_dot.dataset.step)
		})
	},
	loadStep: function(_step) {
		this.onNext = null
		this.updateNavigation(_step)
		this.updateContent('index.php?v=d&plugin=jeeasy&modal=' + _step)
	},
	updateContent: function(_url) {
		this.container.empty()
		fetch(_url)
			.then(response => {
				if (!response.ok) {
					throw new Error(response.status + ' ' + response.statusText)
				}
				return response.text()
			})
			.then(html => {
				this.container.innerHTML = html
				domUtils.loadScript(this.container.querySelectorAll('script'), 0, () => {
					jeedomUtils.initTooltips(this.container)
				})
			})
			.catch(error => {
				jeedomUtils.showAlert({
					message: '{{Erreur au chargement de la page}} : ' + error.message,
					level: 'danger'
				})
			})
	},
	updateNavigation: function(_step) {
		let current = document.querySelector('.navDot[data-step="' + _step + '"]')
		if (!current.previousElementSibling) {
			document.querySelector('.navBtn.bt_prev').classList.add('hidden')
		} else {
			document.querySelector('.navBtn.bt_prev').title = current.previousElementSibling.dataset.title
			document.querySelector('.navBtn.bt_prev.hidden')?.classList.remove('hidden')
		}
		if (!current.nextElementSibling) {
			document.querySelector('.navBtn.bt_next').classList.add('hidden')
			if (_step == 'ready') {
				document.getElementById('bt_jeedom_ready').classList.remove('hidden')
				document.getElementById('bt_quitJeeasyWizard').classList.add('hidden')
			}
		} else {
			document.getElementById('bt_jeedom_ready').classList.add('hidden')
			document.getElementById('bt_quitJeeasyWizard').classList.remove('hidden')
			document.querySelector('.navBtn.bt_next').title = current.nextElementSibling.dataset.title
			document.querySelector('.navBtn.bt_next.hidden')?.classList.remove('hidden')
		}
		jeedomUtils.addOrUpdateUrl('step', _step)
	},
	exit: function() {
		jeeFrontEnd.jeeasyTools.configSave({
			'jeedom::firstUse': 0
		}, function() {
			window.location.href = 'index.php?v=d&p=overview'
		})
	}
}

jeeFrontEnd.jeeasyWizard.init()

/*Events delegations
*/
document.getElementById('div_pageContainer').addEventListener('click', function(_event) {
	let _target = null
	if (_target = _event.target.closest('.navDot')) {
		let current = document.querySelector('.navDot.active')
		if (_target == current) {
			return
		}
		if (Number(_target.innerText) > Number(current.innerText) && typeof jeeP.onNext === 'function') {
			jeeP.onNext(() => jeeP.goToStep(_target))
			return
		}
		jeeP.goToStep(_target)
		return
	}

	if (_target = _event.target.closest('.navBtn.bt_next')) {
		document.querySelector('.navDot.active').nextElementSibling?.triggerEvent('click')
		return
	}

	if (_target = _event.target.closest('.navBtn.bt_prev')) {
		document.querySelector('.navDot.active').previousElementSibling?.triggerEvent('click')
		return
	}

	if (_target = _event.target.closest('#bt_quitJeeasyWizard')) {
		jeeDialog.confirm({
			title: "{{Voulez-vous vraiment fermer l'assistant de configuration ?}}",
			message: '{{Certaines configurations ne seront pas effectuées et les plugins proposés ne seront pas installés}}'
		}, function(result) {
			if (result) {
				jeeP.exit()
			}
		})
		return
	}

	if (_target = _event.target.closest('#bt_jeedom_ready')) {
		jeeP.exit()
		return
	}
})
