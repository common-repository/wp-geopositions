var _mZoomIn = 'Zoom In';
var _mZoomOut = 'Zoom Out';
var _mZoomSet = 'Click to set zoom level';
var _mZoomDrag = 'Drag to zoom';
var _mPanWest = 'Go left';
var _mPanEast = 'Go right';
var _mPanNorth = 'Go up';
var _mPanSouth = 'Go down';
var _mLastResult = 'Return to the last result';
var _mGoogleCopy = '&#169;2005 Google';
var _mDataCopy = 'Map data &#169;2005 ';
var _mNavteq = 'NAVTEQ&#8482;';
var _mTeleAtlas = 'Tele Atlas';
var _mNormalMap = 'Map';
var _mNew = '';
var _mTerms = 'Terms of Use';
var _mTermsURL = 'http://www.google.com/help/terms_local.html';
var _mKeyholeMap = 'Satellite';
var _mKeyholeCopy = 'Imagery &#169;2005 ';

function createMapSpecs() {
	var mt = '';
	var tv = 'w2.4';
	var kmt = '';
	var kdomain = 'google.com';
	var ktv = '2';
	var kdisable = false;
	var khauth = 'fzwq2lyKz95PEWRsD8Is-mDPO2M';
	var mercator = (tv.charAt(0) == 'w');
	if (!arguments.callee.mapSpecs) {
		var mapSpecs = [];
		if (mercator) {
			_GOOGLE_MAP_SPEC = new _GoogleMapMercSpec(mt, tv);
		} else {
			_GOOGLE_MAP_SPEC = new _GoogleMapSpec(mt, tv);
		}
		mapSpecs.push(_GOOGLE_MAP_SPEC);
		if (!kdisable) {
			_KEYHOLE_SPEC = new _KeyholeMapSpec(kmt, kdomain, ktv, mercator, khauth);
			mapSpecs.push(_KEYHOLE_SPEC);
		}
		arguments.callee.mapSpecs = mapSpecs;
	}
	return arguments.callee.mapSpecs;
}

var _u = navigator.userAgent.toLowerCase();function _ua(t) {
	return _u.indexOf(t) != -1;
}

function _uan(t){
	if(!window.RegExp){
		return 0;
	}
	
	var r = new RegExp(t+'([0-9]*)');
	var s = r.exec(_u);
	var ret = 0;
	if (s.length >= 2){
		ret = s[1];
	}
	return ret;
}

function _noActiveX(){
	if(!_ua('msie') || !document.all || _ua('opera')){
		return false;
	}
	var s = false;
	eval('try { new ActiveXObject("Microsoft.XMLDOM"); }'+'catch (e) { s = true; }');
	return s;
}

function _compat(){
	return ((_ua('opera') &&(_ua('opera 7.5') || _ua('opera/7.5') ||_ua('opera 8') || _ua('opera/8'))) ||(_ua('safari') && _uan('safari/') >= 125) ||(_ua('msie') &&!_ua('msie 4') && !_ua('msie 5.0') && !_ua('msie 5.1') &&!_ua('msie 3') && !_ua('powerpc')) ||(document.getElementById && window.XSLTProcessor &&window.XMLHttpRequest && !_ua('netscape6') &&!_ua('netscape/7.0')));
}

_fc = false;
_c = _fc || _compat();

function _browserIsCompatible(){
	return _compat();
}

function _havexslt(){
	if (typeof GetObject != 'undefined' ||(typeof XMLHttpRequest != 'undefined' &&typeof DOMParser != 'undefined' &&typeof XSLTProcessor != 'undefined')) {
		return true;
	} else {
		return false;
	}
}

function _script(src) {
	var ret='<'+'script src="'+src+'"'+' type="text/javascript"><'+'/script>';
	document.write(ret);
}

function _loadMapsScript(){
	if(_havexslt()){
		_script("maps.8.js");
	} else if(_ua('safari')) {
		_script("maps.8.safari.js");
	} else {
		_script("maps.8.xslt.js");
	}
}

if (_c && !_noActiveX()) {
	document.write('<style type="text/css" media="screen">.noscreen {display: none}</style>');
	document.write('<style type="text/css" media="print">.noprint {display: none}</style>');
	_loadMapsScript();
}

//	Get a referance to everything we'll need to look at
var bMapShowing = true;

function fnTurnMapOn() {
	var interfaceMap = document.getElementById('container_frb');
	var interfaceCrossHairs = document.getElementById('mapOverlay');

	//	turn the map on
	interfaceMap.style.display = 'block';
	interfaceMapHead.style.display = 'block';
	
	//	Call the function that gets called when the window is resized to force a recenter and rescale of the map.
	//	When the map was draw in a hidden div the layout is centered on 0,0, when we show the map we want it to
	//	automatically resize.
	try{
		mapControlPointerHack.resizeMapView();
	} catch(er) {
	}
	
	//	turn the cross hairs on
	interfaceCrossHairs.style.display = 'block';
}

function fnTurnCrossHairsOff() {
	//	turn the cross hairs off
	var interfaceCrossHairs = document.getElementById('mapOverlay');
	interfaceCrossHairs.style.display = 'none';
}



//	This function will place the cross hairs at the center of the map
function fnPlaceCrossHairs() {
		var divMapOverlay = document.getElementById('mapOverlay');
		var divMap = document.getElementById('container_frb');
		divMapOverlay.style.position = 'absolute';
		divMapOverlay.style.top = ((divMap.clientHeight/2)-22) + 'px';
		divMapOverlay.style.left = ((divMap.clientWidth/2)-22) + 'px';
		divMapOverlay.style.width = '45px';
		divMapOverlay.style.height = '45px';
}	

//	This function will load up the center lat/lon into the search box
function fnSetLatLon(thisLatLon) {
	thisLatLon = thisLatLon.toString();
	arrLatLon = thisLatLon.split(",");
	var thisLonVal = arrLatLon[0].substr(1,arrLatLon[0].length-1);
	var thisLatVal = parseFloat(arrLatLon[1]);
	
	//var thisLat = document.getElementById('ioz_gp_latitude');
	//var thisLon = document.getElementById('ioz_gp_longitude');
	var thisLat = parent.document.getElementById('ioz_gp_position_latitude');
	var thisLon = parent.document.getElementById('ioz_gp_position_longitude');

	thisLatVal = Math.floor(thisLatVal*1000000)/1000000;
	thisLonVal = Math.floor(thisLonVal*1000000)/1000000;

	if (thisLatVal < -90) { thisLatVal = -90 };
	if (thisLatVal > 90) { thisLatVal = 90 };
	
	thisLat.value = thisLatVal;
	thisLon.value = thisLonVal;

	//	turn the cross hairs on
	var interfaceCrossHairs = document.getElementById('mapOverlay');
	interfaceCrossHairs.style.display = 'block';
}

function fnDoPan() {
	//var thisLat = document.getElementById('ioz_gp_latitude');
	//var thisLon = document.getElementById('ioz_gp_longitude');
	var thisLat = parent.document.getElementById('ioz_gp_position_latitude');
	var thisLon = parent.document.getElementById('ioz_gp_position_longitude');
	
	thisLat = parseFloat(thisLat.value);
	thisLon = parseFloat(thisLon.value);
	
	if (isNaN(thisLat) || isNaN(thisLon)) {
	} else {
		if (thisLat < -90 || thisLat > 90 || thisLon < -180 || thisLon > 180) {
		} else {
			var targetPoint = new n();
			targetPoint.y=thisLat;
			targetPoint.x=thisLon;
			myMapApp.map.recenterOrPanToLatLng(targetPoint);
			fnSetSearchByDistance(true);
		}
	}
	
}

function fnDoPan2(latitude,longitude) {
	var thisLat = latitude;
	var thisLon = longitude;
	
	thisLat = parseFloat(thisLat);
	thisLon = parseFloat(thisLon);
	
	if (isNaN(thisLat) || isNaN(thisLon)) {
	} else {
		if (thisLat < -90 || thisLat > 90 || thisLon < -180 || thisLon > 180) {
		} else {
			var targetPoint = new n();
			targetPoint.y=thisLat;
			targetPoint.x=thisLon;
			myMapApp.map.recenterOrPanToLatLng(targetPoint);
			fnSetSearchByDistance(true);
		}
	}
	
}
