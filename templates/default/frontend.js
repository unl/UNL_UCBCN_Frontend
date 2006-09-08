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

addLoadEvent(todayHilite);

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


