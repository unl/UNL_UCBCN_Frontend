/* body onload by simon collison */
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

/*this is the event loader*/
addLoadEvent(function() {

  //attach monthdisplay() if it's a month view and not safari (safari support will be added soon)
  if (document.getElementById('month_viewcal')){
  	if(readCookie('monthview') ==null){
  		monthdisplay(); 
  		var viewall = document.getElementById('monthfullview');
  		viewall.className = 'monthfullview_unchecked';
  	}
  	else{
  		var monthID = document.getElementById('month_viewcal');
 		var LImonth = monthID.getElementsByTagName('ul');
  			for(m=0; m<LImonth.length; m++){
  				LImonth[m].className = 'unhide';
  			}
  	}
  }  
  
  todayHilite();
  dropdown();
  //attach search tips if cookie does not exist
  if(readCookie('searchtips') ==null){
  searchinfo(); 
  }
});

/*------------------------ GENERIC FUNCTIONS --------------------------*/ 
/* getElementsByClassName by some guy with a yeallowish website. */
function getElementsByClassName(oElm, strTagName, strClassName){
    var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
    var arrReturnElements = new Array();
    strClassName = strClassName.replace(/\-/g, "\\-");
    var oRegExp = new RegExp("(^|\\s)" + strClassName + "(\\s|$)");
    var oElement;
    for(var i=0; i<arrElements.length; i++){
        oElement = arrElements[i];      
        if(oRegExp.test(oElement.className)){
            arrReturnElements.push(oElement);
        }
    }
    return (arrReturnElements);
}

/* compressed browser detection (http://www.quirksmode.org/js/detect.html) */
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[(function(e){return d[e]})];e=(function(){return'\\w+'});c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('a A={E:g(){6.t=6.h(6.D)||"Z k t";6.G=6.f(3.8)||6.f(3.I)||"r k G";6.s=6.h(6.z)||"r k s"},h:g(7){M(a i=0;i<7.B;i++){a 9=7[i].4;a H=7[i].q;6.l=7[i].b||7[i].2;d(9){d(9.v(7[i].5)!=-1)c 7[i].2}N d(H)c 7[i].2}},f:g(9){a p=9.v(6.l);d(p==-1)c;c S(9.U(p+6.l.B+1))},D:[{4:3.8,5:"m",b:"m/",2:"m"},{4:3.e,5:"X",2:"Y"},{q:J.K,2:"L"},{4:3.e,5:"x",2:"x"},{4:3.e,5:"O",2:"P"},{4:3.8,5:"u",2:"u"},{4:3.e,5:"w",2:"w"},{4:3.8,5:"n",2:"n"},{4:3.8,5:"F",2:"T",b:"F"},{4:3.8,5:"V",2:"o",b:"W"},{4:3.8,5:"o",2:"n",b:"o"}],z:[{4:3.j,5:"Q",2:"R"},{4:3.j,5:"y",2:"y"},{4:3.j,5:"C",2:"C"}]};A.E();',62,62,'||identity|navigator|string|subString|this|data|userAgent|dataString|var|versionSearch|return|if|vendor|searchVersion|function|searchString||platform|unknown|versionSearchString|OmniWeb|Netscape|Mozilla|index|prop|an|OS|browser|Firefox|indexOf|Camino|iCab|Mac|dataOS|BrowserDetect|length|Linux|dataBrowser|init|MSIE|version|dataProp|appVersion|window|opera|Opera|for|else|KDE|Konqueror|Win|Windows|parseFloat|Explorer|substring|Gecko|rv|Apple|Safari|An'.split('|'),0,{}))

/* cookie function */
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

/* Go to a given URL */
function gotoURL(location) {document.location=location;}
/*------------------------------------------------------------------------*/

/*
 * subscriber drop down for ie, adjust css when min height is triggered
 * Call from: closeULbox(), showMoreEvents(), todayHilite()
 * Call to: none
 */
var g_bH = false; 
  function dropdown(p_strId) {
    g_bH = false;
    var l_E = document.getElementById(p_strId);

    if(l_E && document.defaultView) {
      if(document.defaultView.getComputedStyle(l_E, 'hover')) {
        g_bH = true;    
      }
    }
    l_E = null;
   try{ 
   var dr = document.getElementById('droplist').style;
   var rightCol = getElementsByClassName(document, "div", "col");
   if (document.getElementById('maincontent').clientHeight < rightCol[0].clientHeight){
   dr.margin = '-64px 2px 0 0';
   dr.borderTop = '1px solid #ccc';
   }
   }catch(e){};
  }

/*
 * Toggle off monthview() based on cookie
 * Call from: none
 * Call to: none
 */
function fullview(){
	if (readCookie('monthview') ==null){
	createCookie('monthview','showallevents',1);
	window.location.reload();
	
	}else{
	eraseCookie('monthview');
	window.location.reload();
	}
return false;
}

/*
 * Return full month strings based on javascript date function
 * Call from: closeULbox(), showMoreEvents(), todayHilite()
 * Call to: none
 */
function getCalendarDate()
{
   var months = new Array(13);
   months[0]  = "January";
   months[1]  = "February";
   months[2]  = "March";
   months[3]  = "April";
   months[4]  = "May";
   months[5]  = "June";
   months[6]  = "July";
   months[7]  = "August";
   months[8]  = "September";
   months[9]  = "October";
   months[10] = "November";
   months[11] = "December";
   var now         = new Date();
   var monthnumber = now.getMonth();
   var monthname   = months[monthnumber];
   var dateString = monthname;
   return dateString;
}

/*
 * Return full month strings based on input value
 * Call from: showMoreEvents()
 * Call to: none
 */
function getCalendarName(t)
{
   var months = new Array(13);
   months[0]  = "January";
   months[1]  = "February";
   months[2]  = "March";
   months[3]  = "April";
   months[4]  = "May";
   months[5]  = "June";
   months[6]  = "July";
   months[7]  = "August";
   months[8]  = "September";
   months[9]  = "October";
   months[10] = "November";
   months[11] = "December";
   var monthname   = months[t];
   return monthname;
}

function eventLink(){
	var tbodyObj = document.getElementsByTagName('tbody');
	for(tb=0; tb<tbodyObj.length; tb++){
		var eventLink = getElementsByClassName(tbodyObj[tb], "a", "url");
			for(a=0; a<eventLink.length; a++){
				eventLink[a].onclick = function(){
									   var linkURL = this.getAttribute("href", 2)+'?&format=hcalendar';
									   new ajaxEngine(linkURL);
									   return false;
									   }
			}
	}
}

/*
 * today icon and ajax initialization for month widget
 * Call from: addLoadEvent
 * Call to: none
 */
var todayFlag = 0;
function todayHilite(){
	x = new Date ();
	y = x.getDate ();
	var td0 = getElementsByClassName(document, "table", "wp-calendar");
	var spanID = document.getElementById(getCalendarDate());
		var td1 = td0[0].getElementsByTagName('td');
		var verify = getElementsByClassName(td0[0], "span", "monthvalue");
		
		//month widget caption navigation
			
		//if in day view (only), execute....
		if (document.getElementById('frontend_view_selector').className == 'day'){
			monthNav(); 
			eventLink();
			monthCaptionSwitch(td0[0]);
			for(i=0;i<td1.length;i++){
			monthWidget(td0[0],td1);
			}
		}
	
		//indicate today
		for(i=0;i<td1.length;i++){
			//insert icon to indicate today	
			if(verify[0].id == getCalendarDate() && td1[i].className.indexOf('prev') < 0 && td1[i].className.indexOf('next') < 0){
				if (document.getElementById('onselect') == null){
					try{
						if(td1[i].firstChild.nodeValue==y || td1[i].firstChild.childNodes[0].nodeValue==y){
							td1[i].setAttribute("class","today");
							if (todayFlag == 0){
								td1[i].setAttribute("id","onselect");								
							}
							var imageToday = document.createElement("div");
							imageToday.setAttribute("id","today_image");
							td1[i].appendChild(imageToday);
							break;
						}
					}
					catch(e){}	
				}
				/*else{
					try{
						if(td1[i].firstChild.nodeValue==y || td1[i].firstChild.childNodes[0].nodeValue==y){
							td1[i].setAttribute("class","today");
							var imageToday = document.createElement("div");
							imageToday.setAttribute("id","today_image");
							td1[i].appendChild(imageToday);
							break;
						}
					}
					catch(e){}	
				}*/
			}
			/* else if(td1[i].className.indexOf('prev') < 0 && td1[i].className.indexOf('next') < 1){
					if(document.getElementById('onselect') == null){
						td1[i].setAttribute("id","onselect");
						//ajaxEngine(td1[i].getAttribute("href", 2)+'?&format=hcalendar');
						break;
					}
					else{
						//document.getElementById('onselect').id = 'none';
						//td1[i].setAttribute("id","onselect");
						//ajaxEngine(td1[i].getAttribute("href", 2)+'?&format=hcalendar');
						break;
					}
			}*/
			
		}			
}



document.onkeydown = checkKeyNav;
function checkKeyNav(e) {
var nav_prev1 = document.getElementById('day_nav');
var linkprev = nav_prev1.getElementsByTagName('a')[0].getAttribute("href", 2)+'?&format=hcalendar';
var linknext = nav_prev1.getElementsByTagName('a')[1].getAttribute("href", 2)+'?&format=hcalendar';

var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
	if(keycode == 39){
	nav_prev1.getElementsByTagName('a')[1].id = 'ac';
	new ajaxEngine(linknext);
	var td0 = getElementsByClassName(document, "table", "wp-calendar");
	var td1 = td0[0].getElementsByTagName('td');
	for(i=0;i<td1.length;i++){	
		if(td1[i].getAttribute("id") == 'onselect'){			
			td1[i].id = 'none';
			td1[i+1].id = 'onselect';
			if(document.getElementById('onselect').className.indexOf('next') > 0){
				var val_month = document.getElementById('next_month').getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
				new ajaxMonthEngine(val_month);
			}
			break;
		}		
	}
	return false;
	}
	
	else if(keycode == 37){
	nav_prev1.getElementsByTagName('a')[0].id = 'dc';
	new ajaxEngine(linkprev);
	var td0 = getElementsByClassName(document, "table", "wp-calendar");
	var td1 = td0[0].getElementsByTagName('td');
	for(i=0;i<td1.length;i++){
		if(td1[i].getAttribute("id") == 'onselect'){
			td1[i].id = 'none';
			td1[i-1].id = 'onselect';
			if(document.getElementById('onselect').className.indexOf('prev') > 0 || i == 1){
				var val_month = document.getElementById('prev_month').getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
				new ajaxMonthEngine(val_month);
				
			}	
		}	
	}
	return false;
	}
}

function monthNav(){
	var nav_prev1 = document.getElementById('day_nav');
	var linkprev = nav_prev1.getElementsByTagName('a')[0].getAttribute("href", 2)+'?&format=hcalendar';
	var linknext = nav_prev1.getElementsByTagName('a')[1].getAttribute("href", 2)+'?&format=hcalendar';
		
	nav_prev1.getElementsByTagName('a')[0].onclick=function(){
	var currentOnselect = document.getElementById('onselect');
	var td0 = getElementsByClassName(document, "table", "wp-calendar");
	var td1 = td0[0].getElementsByTagName('td');
		for(i=0;i<td1.length;i++){				
				if(td1[i].getAttribute("id") == 'onselect'){
					if(i == 0){
						var val_month = document.getElementById('prev_month').getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
						new ajaxMonthEngine(val_month);
						break;							
					}
					else{
						td1[i-1].id = 'onselect';
						currentOnselect.id = 'none';
						if(document.getElementById('onselect').className.indexOf('prev') > 0){
							var val_month = document.getElementById('prev_month').getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
							new ajaxMonthEngine(val_month);
							break;
						}
					}				
				}				
		}
	new ajaxEngine(linkprev);	
	return false;};
	
	nav_prev1.getElementsByTagName('a')[1].onclick=function(){
	var currentOnselect = document.getElementById('onselect');
	var td0 = getElementsByClassName(document, "table", "wp-calendar");
	var td1 = td0[0].getElementsByTagName('td');
		for(i=0;i<td1.length;i++){				
				if(td1[i].getAttribute("id") == 'onselect'){
					if(i == td1.length - 1){
						var val_month = document.getElementById('next_month').getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
						new ajaxMonthEngine(val_month);
					}
					else{
						td1[i+1].id = 'onselect';
						currentOnselect.id = 'none';
						if(document.getElementById('onselect').className.indexOf('next') > 0){
							var val_month = document.getElementById('next_month').getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
							new ajaxMonthEngine(val_month);
						}
					}
				break;
				}									
		}
	new ajaxEngine(linknext);	
	return false;};
}

function monthWidget(t0,tD){
	if (tD[i].className.indexOf('selected') >= 0){
			tD[i].style.cursor = 'pointer';
			var daylink = tD[i].getElementsByTagName('a');
				tD[i].onclick = function(){
					if(this.className.indexOf('next') > 0){
						var nextmonth = document.getElementById('next_month').getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
						new ajaxMonthEngine(nextmonth);	
					}
					else if(this.className.indexOf('prev') > 0){
						var prevmonth = document.getElementById('prev_month').getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
						new ajaxMonthEngine(prevmonth);	
					}
					if(document.getElementById('onselect')){
						var link = daylink[0].getAttribute("href", 2)+'?&format=hcalendar';
						document.getElementById('onselect').id = 'none';
						this.id = 'onselect';
						new ajaxEngine(link);
					}
					else{
						var link = daylink[0].getAttribute("href", 2)+'?&format=hcalendar';
						this.id = 'onselect';
						new ajaxEngine(link);
					}
  					//gotoURL(link);
					return false;
				}
	}
}
function monthCaptionSwitch(eT){
	var spanarrow = eT.getElementsByTagName('span');
	var spanlinkprev = spanarrow[0].childNodes[0].getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
	var spanlinknext = spanarrow[3].childNodes[0].getAttribute("href", 2)+'?&monthwidget&format=hcalendar';
	spanarrow[3].childNodes[0].onclick=function(){new ajaxMonthCaptionEngine(spanlinknext);return false;};
 	spanarrow[0].childNodes[0].onclick=function(){new ajaxMonthCaptionEngine(spanlinkprev);return false;};
}
function ajaxMonthCaptionEngine(urlPath){
	document.getElementById('load').innerHTML="<img src='/ucomm/templatedependents/templatecss/images/loading.gif' />";
	ajaxCaller.get(urlPath, null, onMonthCaptionResponse, false, null);	
}

function onMonthCaptionResponse(text, headers, callingContext) {
  document.getElementById('load').innerHTML=""
  document.getElementById("monthwidget").innerHTML = text;
  todayHilite();
}
function ajaxMonthEngine(urlPath){
	document.getElementById('load').innerHTML="<img src='/ucomm/templatedependents/templatecss/images/loading.gif' />";
	ajaxCaller.get(urlPath, null, onMonthResponse, false, null);	
}

function onMonthResponse(text, headers, callingContext) {
  if(document.getElementById('onselect') && document.getElementById('onselect').getElementsByTagName('a')[0] != null){
  var tdlink = document.getElementById('onselect').getElementsByTagName('a')[0].getAttribute("href", 2);
  }
  document.getElementById('load').innerHTML=""
  document.getElementById("monthwidget").innerHTML = text;
  todayHilite();
  fun(tdlink);	

}
function fun(ss){
var td0 = getElementsByClassName(document, "table", "wp-calendar");
var td1 = td0[0].getElementsByTagName('a');
var td2 = td0[0].getElementsByTagName('td');
	for(l=0;l<td1.length;l++){
		if(td1[l].getAttribute("href", 2) == ss){
		td1[l].parentNode.id = 'onselect';
		break;
		}
		/*else{
			for(j=td2.length; j >= 0; j--){
				if(td2[j-1].className.indexOf('next') < 0 && td2[j-1].className.indexOf('prev') < 0){
					td2[j-1].id = 'onselect';
					break;	
				}
			}
		}*/	
	}
}
function ajaxEngine(urlPath){
	document.getElementById('load').innerHTML="<img src='/ucomm/templatedependents/templatecss/images/loading.gif' />";
	ajaxCaller.get(urlPath, null, onSumResponse, false, null);		
	todayFlag++;
}

function onSumResponse(text, headers, callingContext) {
  document.getElementById('load').innerHTML=""
  document.getElementById("updatecontent").innerHTML = text;
  new eventLink();
  if(document.getElementById('day_nav') != null){
  new monthNav(); 
  }
}



/*
 * Search box tips
 * Call from: none
 * Call to: none
 */
function searchinfo(){
	var nav_prev1 = document.getElementById('day_nav');
	var search = document.forms.event_search.q;
	search.onclick = function(){
								var flagappeared = document.getElementById('search_term');
								if(nav_prev1.style.display != 'inline'){
								nav_prev1.style.display = 'none';
								}
									if(!flagappeared.className){
										createCookie('searchtips','searchterms',7);
										Spry.Effect.AppearFade("search_term", {duration: 1000, from: 0, to: 100, toggle: true});
										flagappeared.className = 'appeared';										
									}
								};
	var top_off = document.forms.event_search.getElementsByTagName('a');
	top_off[0].onclick = function(){
									var formseaarch = document.forms.event_search.q;
									nav_prev1.style.display = 'inline';
									Spry.Effect.AppearFade("search_term", {duration: 1000, from: 0, to: 100, toggle: true});
									formseaarch.focus();
									return false;
									};
									
}
/*
 * Clean and simple month display
 * Call from: addLoadEvent
 * Call to: createButton(), truncate()
 */
function monthdisplay(){
	var td0 = getElementsByClassName(document, "table", "wp-calendar");
	for(j=0;j<td0.length;j++){
		var td1 = td0[j].getElementsByTagName('td');
		for(i=0;i<td1.length;i++){
			var listevent = td1[i].getElementsByTagName('li');
			if(listevent.length != 0){
				if (listevent.length > 4){
					var how_many_more = listevent.length - 4;
					for( var d=4; d<listevent.length; d++){
						listevent[d].style.display = 'none';
					}
					createButton("+"+how_many_more+" more", td1[i], showMoreEvents, "more_event");
				}
				else{
					createButton("full view", td1[i], showMoreEvents, "more_event");
				}
				for (k=0;k<listevent.length;k++){
				var listText = listevent[k].getElementsByTagName('a');
					for(x=0; x<listText.length; x++){
					  truncate(listText[x]);
					}
				}
			}
		}
	}
}

/*
 * Create <a href> buttons
 * Call from: monthdisplay()
 * Call to: showMoreEvents()
 */
function createButton(linktext, attachE, actionFunc, classN){
	var morelink = document.createElement("a");
	morelink.style.display = 'inline';
	var text = document.createTextNode(linktext);
	morelink.className=classN;
	morelink.href = '#';
	morelink.onclick = actionFunc;
	morelink.appendChild(text);
	attachE.appendChild(morelink);
}

/*
 * Truncate text 
 * Call from: monthdisplay()
 * Call to: Del()
 */
function truncate(t){
	var len = 12;
	var trunc = t.innerHTML;
	// rinse text to weed out any html tags
	trunc = Del(trunc);
	if (trunc.length > len) {
	   /* Truncate the content of the P, then go back to the end of the
	      previous word to ensure that we don't truncate in the middle of
	      a word */
	    trunc = trunc.substring(0, len);
	    //trunc = trunc.replace(/\w+$/, '');
		/* Add an ellipses to the end and make it a link that expands
       	   the paragraph back to its original size */
   try{	 
   	trunc += '...<span style="display:none">'+t.innerHTML;
	t.innerHTML = trunc;
	}catch(e){};
	}						
}

/*
 * Weed out HTML tags
 * Call from: truncate()
 * Call to: none
 */	
function Del(Word) {
a = Word.indexOf("<");
b = Word.indexOf(">");
len = Word.length;
c = Word.substring(0, a);
if(b == -1)
b = a;
d = Word.substring((b + 1), len);
Word = c + d;
tagCheck = Word.indexOf("<");
if(tagCheck != -1)
Word = Del(Word);
return Word;
}

/*
 * onclick function to view the rest of the events. All the actions are here :)
 * Call from: createButton()
 * Call to: showDate(), adjustPos(), closeULbox();
 */	
var zInde = 1000;
function showMoreEvents(){

	var ul = this.previousSibling;
	var tdcell = ul.parentNode;
	var monthL = getElementsByClassName(document.getElementById('month_viewcal'), "span", "monthvalue");

	//if it's today, give different id to td to counteract position relative for today TD and hide today icon
	if(monthL[0].id == getCalendarDate()){
	if(tdcell.id == 'today'){
	document.getElementById('today_image').style.display = 'none';
	tdcell.setAttribute("id","tt");
	}
	}
	
	//stack ulbox according to 'who click first' and restack if it is clicked again.
	ul.className = "ul_box";
	ul.style.zIndex = zInde;
	zInde++;
	ul.onclick = function(){
	this.style.zIndex = zInde+1;
	zInde++;
	};
	
	var li = ul.getElementsByTagName('li');
	
	//get the month value and pass it through showDate function
	//var monthL = getElementsByClassName(document.getElementById('month_viewcal'), "span", "monthvalue");
	var yearL = getElementsByClassName(document, "span", "yearvalue");
	var now         = new Date();
 	var monthnumber = now.getMonth();
	var monthval = getCalendarName(tdcell.childNodes[1].childNodes[0].nodeValue-1);

	if (tdcell.className == 'prev'){
	showDate(ul, li, monthval, yearL[0].firstChild.childNodes[0].nodeValue);
	}else if (tdcell.className == 'next'){
	showDate(ul, li, monthval, yearL[0].firstChild.childNodes[0].nodeValue);
	}else{
	showDate(ul, li, monthval, yearL[0].firstChild.childNodes[0].nodeValue);
	}
	
	for (i=0;i<li.length;i++){
		var listText = li[i].getElementsByTagName('a');
			for(x=0; x<listText.length; x++){
				var everything = listText[x].getElementsByTagName('span');
				if (everything.length > 0){
				listText[x].innerHTML = everything[0].innerHTML;
				}
			}
	}
		var para = document.createElement("li");
		para.className = 'close_eventbox';
		var text = document.createTextNode("close");
		var elip_link = document.createElement('a');
		elip_link.href = '#';
		elip_link.onclick = closeULbox;
		elip_link.appendChild(text);
		para.appendChild(elip_link);
		ul.appendChild(para);

	//find position and adjust accordingly so there's no overflow on ul_box
	adjustPos(ul, tdcell);
	return false;
}

/*
 * contruct the date when ul_box is brought up. Format: September 12, 2006
 * Call from: showMoreEvents()
 * Call to: none
 */	
function showDate(ulList, liList, m, y){
	var date = ulList.parentNode.firstChild.childNodes[0].nodeValue;
	var dateUL = document.createElement("li");
	var dateTEXT = document.createTextNode(m+' '+date+','+' '+y);
	var dateLink = document.createElement('a');
	dateUL.className="dateUL";
	dateLink.href = ulList.parentNode.firstChild;
	dateLink.appendChild(dateTEXT);
	dateUL.appendChild(dateLink);
	ulList.insertBefore(dateUL,liList[0]);
}

/*
 * calculate pop up position and apply bottom and right = 0 to prevent overflow.
 * Call from: showMoreEvents()
 * Call to: findPos()
 */	
function adjustPos(ulL, tD){
	var pos = findPos(ulL.parentNode.parentNode.parentNode.parentNode);
	var ulpos = findPos(ulL);
	var footpos = findPos(document.getElementById('footer'));
	var tdHeight = tD.clientHeight;
	var version=0;
	var widthOffset;
	
	var theWidth = 0;
    if (window.innerWidth) {
	theWidth = window.innerWidth
    } else if (document.documentElement &&
                document.documentElement.clientWidth) {
	theWidth = document.documentElement.clientWidth
    } else if (document.body) {
	theWidth = document.body.clientWidth
    }
    
	widthOffset = ((theWidth-pos[0])/ulpos[0])*100;
   	if(ulpos[1]+ulL.clientHeight > (footpos[1]-20)){
	ulL.style.bottom = '0';
	}
	if (widthOffset < 120){
	ulL.style.right = '0';
	}		
}

/*
 * return offset value x and y of an object
 * Call from: adjustPos()
 * Call to: none
 */	
function findPos(obj)
{
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	return [curleft,curtop];
}

/*
 * close and retruncate ul_box
 * Call from: showMoreEvents()
 * Call to: truncate()
 */	
function closeULbox(){
var monthL = getElementsByClassName(document.getElementById('month_viewcal'), "span", "monthvalue");
var ul = this.parentNode.parentNode;
	
/* -- Today icon is moving!!! Bug -- */
/*if(monthL[0].id == getCalendarDate()){
document.getElementById('today_image').style.display = 'inline';
ul.parentNode.id = "today";
}*/

ul.className = 'none';
ul.removeChild(ul.lastChild);
ul.removeChild(ul.getElementsByTagName('li')[0]);
var listevent = ul.getElementsByTagName('li');
for (k=0;k<listevent.length;k++){
				var listText = listevent[k].getElementsByTagName('a');
					for(x=0; x<listText.length; x++){
					  truncate(listText[x]);
					}
				}

return false;
}
