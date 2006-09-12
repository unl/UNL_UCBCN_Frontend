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
    return (arrReturnElements)
}

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

addLoadEvent(function() {
  var cookie_frontend = readCookie('searchtips');
  todayHilite();
  if(!cookie_frontend){
  searchinfo(); 
  }
});

/* If anyone found a better way to return full month string without concatenation, let me know */
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

/* Go to a given URL */
function gotoURL(location) {

	document.location=location;

}

/* output an icon to indicate today date */
function todayHilite(){
	x = new Date ();
	y = x.getDate ();
	var td0 = getElementsByClassName(document, "table", "wp-calendar");
	var spanID = document.getElementById(getCalendarDate());
	for(j=0;j<td0.length;j++){
		var td1 = td0[j].getElementsByTagName('td');
		var verify = getElementsByClassName(td0[j], "span", "monthvalue");
		
		//make td clickable if there's an event (only in month widget)
		for(i=0;i<td1.length;i++){
			if (td1[i].className == 'selected'){
				td1[i].style.cursor = 'pointer';
				td1[i].onclick = function(){
					var daylink = this.getElementsByTagName('a');
					var link = daylink[0].getAttribute("href");
					gotoURL(link);
				}
			}
			
			//insert icon to indicate today	
			if(verify[0].id == getCalendarDate()){
				try{
					if(td1[i].firstChild.nodeValue==y || td1[i].firstChild.childNodes[0].nodeValue==y){
						td1[i].setAttribute("id","today");
						
							var imageToday = document.createElement("div");
							imageToday.setAttribute("id","today_image");
							td1[i].appendChild(imageToday);
					}
				}
				catch(e){}	
			}
		}	
			
	}
	
}

/* search info */
function searchinfo(){

	var search = document.forms.event_search.q;
	search.onclick = function(){
								var flagappeared = document.getElementById('search_term');
									if(!flagappeared.className){
										createCookie('searchtips','searchterms',7);
										Spry.Effect.AppearFade("search_term", {duration: 1000, from: 0, to: 100, toggle: true});
										flagappeared.className = 'appeared';										
									}
								};
	var top_off = document.forms.event_search.getElementsByTagName('a');
	top_off[0].onclick = function(){
									var formseaarch = document.forms.event_search.q;
									Spry.Effect.AppearFade("search_term", {duration: 1000, from: 0, to: 100, toggle: true});
									formseaarch.focus();
									};
}



	
	