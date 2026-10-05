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

jeeFrontEnd.jeeasyTools = {
	// Slides the element out then back in, running _midAction in between
	slide: function(_element, _reverse, _midAction) {
		_element.animate({
			opacity: [1, 0],
			transform: ['translateX(0)', _reverse ? 'translateX(10%)' : 'translateX(-10%)']
		}, {
			duration: 400
		})
		// Before the end, the element shows again once the animation is over
		setTimeout(() => {
			_midAction()
			_element.animate({
				opacity: [0, 1],
				transform: [_reverse ? 'translateX(-10%)' : 'translateX(10%)', 'translateX(0)']
			}, {
				duration: 400
			})
		}, 375)
	},
	configSave: function(_configuration, _success) {
		jeedom.config.save({
			configuration: _configuration,
			global: false,
			error: function(_error) {
				jeedomUtils.showAlert({
					message: _error.message,
					level: 'danger'
				})
			},
			success: function() {
				if (typeof _success === 'function') {
					_success()
				}
			}
		})
	},
	installPlugin: function(_marketId, _logicalId) {
		jeedom.repo.install({
			id: _marketId,
			repo: 'market',
			global: false,
			error: function(_error) {
				jeedomUtils.showAlert({
					message: _error.message,
					level: 'danger'
				})
			},
			success: function() {
				jeedom.plugin.toggle({
					id: _logicalId,
					state: 1,
					global: false,
					error: function(_error) {
						jeedomUtils.showAlert({
							message: _error.message,
							level: 'danger'
						})
					},
					success: function() {
						jeedom.plugin.dependancyChangeAutoMode({
							id: _logicalId,
							mode: 1,
							error: function(_error) {
								jeedomUtils.showAlert({
									message: _error.message,
									level: 'danger'
								})
							}
						})
						jeedom.plugin.deamonChangeAutoMode({
							id: _logicalId,
							mode: 1,
							error: function(_error) {
								jeedomUtils.showAlert({
									message: _error.message,
									level: 'danger'
								})
							}
						})
					}
				})
			}
		})
	}
}
