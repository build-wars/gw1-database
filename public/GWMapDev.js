/**
 * @filesource   GWMap.js
 * @created      14.02.2019
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

'use strict';

class GWMapDev extends GWMap{

	/**
	 * @param coords
	 * @param pane
	 * @param interactive
	 * @param icon
	 * @returns {*}
	 */
	marker(coords, pane, interactive, icon){
		let marker = L.marker(coords, {
			interactive: interactive || false,
			pane: pane,
			icon: icon,
			draggable: true,
		});

		marker.on('dragend', ev => {
			let request = new XMLHttpRequest();

			request.open('POST', this.options.apiEditURL, true);
			request.addEventListener('load', ev => {
				let r = JSON.parse(ev.target.responseText);

				if(ev.target.readyState === 4 && ev.target.status === 200){
					console.log(r);
					return;
				}

				console.log('(╯°□°）╯彡┻━┻ ', r.error, r.trace);
			});

			let coord = this.map.project(ev.target.getLatLng(), this.options.maxZoom);
			let prop  = ev.target.feature.properties;

			request.setRequestHeader('Content-type','application/json; charset=utf-8');
			request.send(JSON.stringify({id: prop.id, type: prop.type, coord: coord}));
		});

		return marker;
	}

}

