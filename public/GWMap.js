/**
 * @filesource   GWMap.js
 * @created      17.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

'use strict';

/**
 * TODO: add es & fr language snippets
 */
const GWMAP_I18N = {
	de: {
		wiki       : 'https://www.guildwiki.de/wiki/',
		attribution: 'Kartendaten und -bilder',
		layers     : {
			labels     : 'Beschriftungen',
			explorables: 'Erforschbar',
			missions   : 'Missionen',
			outposts   : 'Außenposten',
			bosses     : 'Bosse',
		},
		outposttypes:{
			1: 'Stadt',
			2: 'Außenposten',
			3: 'Missionsaußenposten',
			4: 'Arenaaußenposten',
			5: 'Missionsaußenposten (Herausforderungs-Mission)',
			6: 'Elitemissionsaußenposten',
			7: 'Gildenhalle',
			8: 'Missionsaußenposten (Kompetitive Mission)',
		},
	},
	en: {
		wiki       : 'https://wiki.guildwars.com/wiki/',
		attribution: 'Map data and imagery',
		layers     : {
			labels     : 'Labels',
			explorables: 'Explorable',
			missions   : 'Missions',
			outposts   : 'Outposts',
			bosses     : 'Bosses',
		},
		outposttypes:{
			1: 'Town',
			2: 'Outpost',
			3: 'Mission outpost',
			4: 'Arena outpost',
			5: 'Challenge mission outpost',
			6: 'Elite mission outpost',
			7: 'Guild hall',
			8: 'Competetive mission outpost',
		},
	},
};


class GWMap{

	/**
	 * @param {HTMLElement} container
	 * @param {*} options
	 */
	constructor(container, options){
		this.container = container;

		this.options = {
			targetSelector  : '.gw1map',
			apiURL          : './',
			apiEditURL      : 'http://localhost/gw1-database/', // you don't want this on a public server
			gwdbURL         : './gwdb',
			tilePath        : '/tiles', // relative from "gwdbURL"
			tileExt         : '.png',
			lang            : 'en',
			defaultContinent: 2, // tyria
			zoom            : 4,
			minZoom         : 1,
			maxZoom         : 8,
			zoomNormalize   : 6,
			minIconZoom     : 3,
			errorTile       : '/blank.png', // relative from "tilePath"
			colors          : {
				explorables: 'rgba(255, 255, 255, 0.4)',
				missions   : {
					2: 'rgba(20, 200, 255, 0.5)',
					4: 'rgba(255, 200, 20, 0.5)',
				},
			},
		};

		// extend default options
		for(let property in options){
			if(options.hasOwnProperty(property)){
				this.options[property] = options[property];
			}
		}

		this.tilebase = this.options.gwdbURL + this.options.tilePath;
		this.layers   = {};
		this.panes    = {};
		this.i18n     = GWMAP_I18N[this.options.lang];

		this.setBaseMap();
	}

	/**
	 * @returns {GWMap}
	 */
	init(){
		let dataset = this.container.dataset;

		// FUCK the stupid fetch/promises API. DON'T @ ME
		let request = new XMLHttpRequest();
		request.open('POST', this.options.apiURL, true);
		request.addEventListener('load', ev => this.loadJSON(ev.target));
		request.setRequestHeader('Content-type','application/json; charset=utf-8');
		request.send(JSON.stringify({continent: dataset.continent, floor: dataset.floor, lang: this.options.lang}));

		return this;
	}

	/**
	 * @param {XMLHttpRequest} request
	 * @returns {GWMap}
	 */
	loadJSON(request){
		let r = JSON.parse(request.responseText);

		if(request.readyState === 4 && request.status === 200){
			return this.render(r);
		}

		console.log('(╯°□°）╯彡┻━┻ ', r.error, r.trace);
	}

	/**
	 * @returns {GWMap}
	 */
	setBaseMap(){

		this.map = L.map(this.container, {
			minZoom: this.options.minZoom,
			maxZoom: this.options.maxZoom,
			crs    : L.CRS.Simple,
		});

		this.map.on('click', ev => this.clickEvent(ev));
		this.map.on('zoomend', ev => this.zoomEndEvent(ev));

		let layerOptions = {
			continuousWorld       : true,
			zoomAnimationThreshold: 8,
			minZoom : this.options.minZoom,
			maxZoom : this.options.maxZoom,
			attribution           : this.options.mapAttribution,
			tileGetter            : (coords, zoom) => this.tileGetter(coords, zoom),
		};

		L.tileLayer(null, layerOptions).addTo(this.map);

		return this;
	}

	/**
	 * @param {*} ev
	 */
	clickEvent(ev){
		let point = this.map.project(ev.latlng, this.options.maxZoom);

		console.log([point.x, point.y]);
	}

	/**
	 * @param {*} ev
	 */
	zoomEndEvent(ev){
		let zoom = this.map.getZoom();

		if(zoom <= this.options.zoomNormalize && zoom > this.options.minIconZoom){

			if(this.layers['outposts']){
				this.layers['outposts'].eachLayer(l => l.setIcon(this.iconOutpost(l.feature.properties, zoom)));
			}

			if(this.layers['bosses']){
				this.layers['bosses'].eachLayer(l => l.setIcon(this.iconBoss(l.feature.properties, zoom)));
			}

			if(this.layers['labels']){
				this.layers['labels'].eachLayer(l => {
					if(l.feature.properties.type === 'outpostLabel'){
						l.setIcon(this.labelOutpost(l.feature.properties, zoom));
					}
				});
			}

		}


		if(this.layers['labels']){
			zoom < this.options.minIconZoom ? this.layers['labels'].remove() : this.layers['labels'].addTo(this.map);
		}

	}

	/**
	 * @param json
	 * @returns {GWMap}
	 */
	render(json){
//		console.log(json);
		this.continent = json.continent.id;
		this.floor     = json.continent.floor_id;
		this.viewRect  = json.continent.rect;

		let rect   = new GW2ContinentRect(json.continent.rect).getBounds();
		let bounds = new L.LatLngBounds(this.unproject(rect[0]), this.unproject(rect[1]));//.pad(0.1)
		let center = bounds.getCenter();

		this.map.setMaxBounds(bounds).setView(center, this.options.zoom);

		['explorables', 'missions', 'outposts', 'bosses', 'labels'].forEach(pane => {
//			console.log(pane, json[pane]);

			this.layers[pane] = L.geoJson(json[pane], {
				pane          : this.map.createPane(pane),
				coordsToLatLng: coords => this.unproject(coords),
				pointToLayer  : (feature, coords) => this.pointToLayer(feature, coords, pane),
				onEachFeature : (feature, layer) => this.onEachFeature(feature, layer, pane),
				style         : feature => this.layerStyle(feature, pane),
			}).addTo(this.map);

			// translated layer names as pane keys for display
			this.panes[this.i18n.layers[pane]] = this.layers[pane];
		});

		// add the layer controls
		L.control.layers(null, this.panes).addTo(this.map);

		return this;
	}

	/**
	 * @link  http://leafletjs.com/reference-1.0.0.html#geojson-oneachfeature
	 * @param feature
	 * @param layer
	 * @param pane
	 */
	onEachFeature(feature, layer, pane){
//		console.log(feature, layer, pane);
		let p = feature.properties;

		let content = '';

		if(p.name){
			let displayname = p.name;

			content += '<a class="gwmap-wikilink" href="' + this.i18n.wiki+encodeURIComponent(p.name.replace(/\.$/, '').replace(/\s/g, '_')) + '" target="_blank">' + displayname + '</a>';
		}

		if(content){
			layer.bindPopup(content);
		}

	}

	/**
	 * @link  http://leafletjs.com/reference-1.0.0.html#geojson-pointtolayer
	 * @param feature
	 * @param coords
	 * @param pane
	 */
	pointToLayer(feature, coords, pane){
		let p = feature.properties;
		let zoom = this.map.getZoom();

		switch(p.type){
			case 'boss'        : return this.marker(coords, pane, true, this.iconBoss(p, zoom));
			case 'explorable'  : return this.marker(coords, pane, false, this.labelExplorable(p));
			case 'outpost'     : return this.marker(coords, pane, true, this.iconOutpost(p, zoom));
			case 'outpostLabel': return this.marker(coords, pane, false, this.labelOutpost(p, zoom));
		}

//		console.log(feature, coords, pane)
	}

	/**
	 * @link  http://leafletjs.com/reference-1.0.0.html#geojson-style
	 * @param feature
	 * @param pane
	 */
	layerStyle(feature, pane){
//		console.log(feature, pane);

		if(['explorables','missions'].indexOf(pane) !== -1){
			let color = pane === 'missions'
				? this.options.colors.missions[feature.properties.missiontype]
				: this.options.colors[pane];

			return {
				pane: pane,
				stroke: true,
				opacity: 0.7,
				color: color,
				weight: 2,
				interactive: true,
			}
		}

		return {};
	}

	/**
	 * @param coords
	 * @param pane
	 * @param interactive
	 * @param icon
	 * @returns {*}
	 */
	marker(coords, pane, interactive, icon){
		return L.marker(coords, {
			interactive: interactive || false,
			pane: pane,
			icon: icon,
		});
	}

	/**
	 * @param outposttype
	 * @param zoom
	 * @returns {number}
	 */
	outpostIconsize(outposttype, zoom){
		// @todo: by continent_id
		let s = {
			1: {1: 64, 2: 32, 4: 64, 7: 64},
			2: {1: 64, 2: 32, 4: 64},
			3: {2: 64},
			4: {},
		}[this.continent][outposttype];

		return this.getSize(s ? s : 128, zoom);
	}

	/**
	 * @todo: needles on lower sizes
	 *
	 * @param properties
	 * @param zoom
	 * @returns {*}
	 */
	iconOutpost(properties, zoom){
		let iconsize = this.outpostIconsize(properties.outposttype, zoom);
		let cssClass = {
			1: 'town', 2: '', 3: 'mission', 4: 'arena', 5: 'chmission', 6: 'elmission', 7: 'guildhall', 8: 'comission'
		}[properties.outposttype];

		return L.divIcon({
			iconSize   : [iconsize, iconsize],
			popupAnchor: [0, -iconsize/2],
			className  : 'c' + this.continent + 'f' + this.floor + ' outpost ' + cssClass,
		});
	}

	/**
	 * @param properties
	 * @param zoom
	 * @returns {*}
	 */
	labelOutpost(properties, zoom){
		let iconsize = this.outpostIconsize(properties.outposttype, zoom);

		return L.divIcon({
			iconSize   : [160, 20],
			iconAnchor : [80, -iconsize/4],
			className  : 'outpost label',
			html       : properties.name,
		})
	}

	/**
	 * @param properties
	 * @param zoom
	 * @returns {*}
	 */
	iconBoss(properties, zoom){
		let iconsize = this.getSize(32, zoom);
		let cssClass = {
			0:'', 1:'warrior', 2:'ranger', 3:'monk', 4:'necromancer', 5:'mesmer',
			6:'elementalist', 7:'assassin', 8:'ritualist', 9:'paragon', 10:'dervish'
		}[properties.prof];

		return L.divIcon({
			iconSize   : [iconsize, iconsize],
			popupAnchor: [0, -iconsize/2],
			className: 'boss ' + cssClass,
		})
	}

	/**
	 * @param properties
	 * @returns {*}
	 */
	labelExplorable(properties){
		return L.divIcon({
			iconSize   : [256, 64],
			popupAnchor: [0, -32],
			className  : 'explorable label',
			html       : '<div style="margin-top: 36px;">' + properties.name + '</div>',
		})
	}

	/**
	 * @param s
	 * @param zoom
	 * @returns {*}
	 */
	getSize(s, zoom){
		let zd;

		if(this.options.maxZoom > this.options.zoomNormalize && zoom > this.options.zoomNormalize){
			zd = 1 << (zoom - this.options.zoomNormalize);

			return zd * s;
		}

		if(zoom < this.options.zoomNormalize){
			zd = 1 << (this.options.zoomNormalize - zoom);

			return Math.round(s / zd);
		}

		return s;
	}
	/**
	 * @param coords
	 *
	 * @returns {LatLng}
	 */
	unproject(coords){
		return this.map.unproject(coords, this.options.maxZoom);
	}

	/**
	 * @param coords
	 * @param zoom
	 *
	 * @returns {[*,*]}
	 */
	project(coords, zoom){
		return coords.map(c => Math.floor((c / (1 << (this.options.maxZoom - zoom))) / 256));
	}

	/**
	 * @param coords
	 * @param zoom
	 *
	 * @returns {*}
	 */
	tileGetter(coords, zoom){
		let clamp = this.viewRect.map(c => this.project(c, zoom));

		if(coords.x < clamp[0][0] || coords.x > clamp[1][0] || coords.y < clamp[0][1] || coords.y > clamp[1][1]){
			return this.tilebase + this.options.errorTile;
		}

		return this.tilebase + '/' + this.continent + '/' + this.floor + '/' + zoom + '/' + coords.x + '/' + coords.y + this.options.tileExt;
	}

}


/**
 * Class GW2ContinentRect
 *
 * @link https://github.com/GW2Wiki/widget-map-floors/blob/master/src/gw2-geojson.js#L313
 */
class GW2ContinentRect{

	/**
	 * GW2ContinentRect constructor
	 *
	 * @param continent_rect
	 */
	constructor(continent_rect){
		this.rect = continent_rect;
	}

	/**
	 * returns bounds for L.LatLngBounds()
	 *
	 * @returns {*[]}
	 */
	getBounds(){
		return [
			[this.rect[0][0], this.rect[1][1]],
			[this.rect[1][0], this.rect[0][1]]
		]
	}

	/**
	 * returns the center of the rectangle
	 *
	 * @returns {*[]}
	 */
	getCenter(){
		return [
			(this.rect[0][0] + this.rect[1][0]) / 2,
			(this.rect[0][1] + this.rect[1][1]) / 2
		]
	}

	/**
	 * returns a polygon made of the rectangles corners
	 *
	 * @returns {*[]}
	 */
	getPoly(){
		return [[
			[this.rect[0][0], this.rect[0][1]],
			[this.rect[1][0], this.rect[0][1]],
			[this.rect[1][0], this.rect[1][1]],
			[this.rect[0][0], this.rect[1][1]]
		]]
	}

}
