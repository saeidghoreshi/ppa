//
// Resizable Table Columns.
//  version: 1.0
//
// (c) 2006, bz

var b = navigator.userAgent.toLowerCase();
var browser = {
	opera: /opera/i.test(b),
	msie: (!this.opera && /msie/i.test(b)),
	msie6: (!this.opera && /msie 6/i.test(b)),
	msie7: (!this.opera && /msie 7/i.test(b)),
	msie8: (!this.opera && /msie 8/i.test(b)),
	mozilla: /firefox/i.test(b),
	chrome: /chrome/i.test(b),
	safari: (!(/chrome/i.test(b)) && /webkit|safari|khtml/i.test(b))
}

function preventEvent(e) {
	var ev = e || window.event;
	if (ev.preventDefault) ev.preventDefault();
	else ev.returnValue = false;
	if (ev.stopPropagation)
		ev.stopPropagation();
	return false;
}

function getStyle(x, styleProp) {
	if (x.currentStyle)
		var y = x.currentStyle[styleProp];
	else if (window.getComputedStyle)
		var y = document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);
	return y;
}

function getWidth(x) {
	if (x.currentStyle)
		var y = x.clientWidth - parseInt(x.currentStyle["paddingLeft"]) - parseInt(x.currentStyle["paddingRight"]);
		// for IE5: var y = x.offsetWidth;
	else if (window.getComputedStyle)
		// in Gecko
		var y = document.defaultView.getComputedStyle(x,null).getPropertyValue("width");
		
	if( browser.chrome || browser.safari ) {
		var y = x.clientWidth;
	}
	
	return y || 0;
}

function setCookie (name, value, expires, path, domain, secure) {
	document.cookie = name + "=" + escape(value) +
		((expires) ? "; expires=" + expires : "") +
		((path) ? "; path=" + path : "") +
		((domain) ? "; domain=" + domain : "") +
		((secure) ? "; secure" : "");
}

function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}
// main class prototype
function ColumnResize(table) {
	if (table.tagName != 'TABLE') return;

	this.id = table.id;

	// ============================================================
	// private data
	var self = this;

	var dragColumns  = table.rows[0].cells; // first row columns, used for changing of width
	if (!dragColumns) return; // return if no table exists or no one row exists

	var dragColumnNo; // current dragging column
	var dragX;        // last event X mouse coordinate

	var saveOnmouseup;   // save document onmouseup event handler
	var saveOnmousemove; // save document onmousemove event handler
	var saveBodyCursor;  // save body cursor property
	
	var defColWidth = [110,60,50,110,110,60,60,80,30,40];

	// ============================================================
	// methods

	// ============================================================
	// do changes columns widths
	// returns true if success and false otherwise
	this.changeColumnWidth = function(no, w) {
		if (!dragColumns) return false;

		if (no < 0) return false;
		if (dragColumns.length < no) return false;

		if (parseInt(dragColumns[no].style.width) <= -w) return false;
		if (dragColumns[no+1] && parseInt(dragColumns[no+1].style.width) <= w) return false;

		
		if (dragColumns[no+1]) {
			var dragWidthCol = parseInt(dragColumns[no].style.width) + w;
			var changeWidthCol = parseInt(dragColumns[no+1].style.width) - w;
			if( changeWidthCol >= defColWidth[no+1] && dragWidthCol >= defColWidth[no] ) {
				dragColumns[no].style.width = parseInt(dragColumns[no].style.width) + w +'px';
				dragColumns[no+1].style.width = changeWidthCol + 'px';
			}
		} else {
			dragColumns[no].style.width = parseInt(dragColumns[no].style.width) + w +'px';
		}

		return true;
	}

	// ============================================================
	// do drag column width
	this.columnDrag = function(e) {
		var e = e || window.event;
		var X = e.clientX || e.pageX;
		if (!self.changeColumnWidth(dragColumnNo, X-dragX)) {
			// stop drag!
			self.stopColumnDrag(e);
		}

		dragX = X;
		// prevent other event handling
		preventEvent(e);
		return false;
	}

	// ============================================================
	// stops column dragging
	this.stopColumnDrag = function(e) {
		var e = e || window.event;
		if (!dragColumns) return;

		// restore handlers & cursor
		document.onmouseup  = saveOnmouseup;
		document.onmousemove = saveOnmousemove;
		document.body.style.cursor = saveBodyCursor;

		// remember columns widths in cookies for server side
		var colWidth = '';
		var separator = '';
		for (var i=0; i<dragColumns.length; i++) {
			colWidth += separator + parseInt( getWidth(dragColumns[i]) );
			separator = '+';
		}
		var expire = new Date();
		expire.setDate(expire.getDate() + 365); // year
		document.cookie = self.id + '-width=' + colWidth +
			'; expires=' + expire.toGMTString();

		preventEvent(e);
	}

	// ============================================================
	// init data and start dragging
	this.startColumnDrag = function(e) {
		var e = e || window.event;

		// if not first button was clicked
		//if (e.button != 0) return;

		// remember dragging object
		dragColumnNo = (e.target || e.srcElement).parentNode.parentNode.cellIndex;
		dragX = e.clientX || e.pageX;

		// set up current columns widths in their particular attributes
		// do it in two steps to avoid jumps on page!
		var colWidth = new Array();
		for (var i=0; i<dragColumns.length; i++)
			colWidth[i] = parseInt( getWidth(dragColumns[i]) );
		for (var i=0; i<dragColumns.length; i++) {			
			//dragColumns[i].width = ""; // for sure
			dragColumns[i].style.width = colWidth[i] + "px";
		}

		saveOnmouseup       = document.onmouseup;
		document.onmouseup  = self.stopColumnDrag;

		saveBodyCursor             = document.body.style.cursor;
		document.body.style.cursor = 'col-resize';

		// fire!
		saveOnmousemove      = document.onmousemove;
		document.onmousemove = self.columnDrag;

		preventEvent(e);
	}

	// prepare table header to be draggable
	// it runs during class creation
	for (var i=0; i<dragColumns.length; i++) {
		if( i != 8 && i != 9 ) {
			dragColumns[i].innerHTML = "<div style='position:relative;height:100%;width:100%'>"+
				"<div style='"+
				"position:absolute;height:100%;width:5px;margin-right:-5px;"+
				"left:100%;top:0px;cursor:col-resize;z-index:10;'>"+
				"</div>"+
				dragColumns[i].innerHTML+
				"</div>";
				// BUGBUG: calculate real border width instead of 5px!!!
				dragColumns[i].firstChild.firstChild.onmousedown = this.startColumnDrag;
		}
	}
}

// select all tables and make resizable those that have 'resizable' class
var resizableTables = new Array();
function ResizableColumns() {

	var tables = document.getElementsByTagName('table');
	for (var i=0; tables.item(i); i++) {
		if (tables[i].className.match(/resizable/)) {
			// generate id
			if (!tables[i].id) tables[i].id = 'table'+(i+1);
			// make table resizable
			resizableTables[resizableTables.length] = new ColumnResize(tables[i]);
		}
	}

}
// init tables

try {
	window.addEventListener('load', ResizableColumns, false);
} catch(e) {
	window.onload = ResizableColumns;
}
