
var xmlhttp=null;


function caricoRisultati(ajx)
{
	//var oo=window.open("","new");  //oggetto di riferimento
	var oo=parent.mappa;
	
	
	//var xmlnum = doc.getElementsByTagName('num').firstChild.nodeValue;   // numero presenti
	//console.log (ajx);
	
	xx=ajx.responseXML.documentElement.getElementsByTagName("status");
	xstatus=xx[0].firstChild.nodeValue;	
	xx=ajx.responseXML.documentElement.getElementsByTagName("row");
	try {
		xrow=xx[0].firstChild.nodeValue;
	}
		catch (er) {
			xrow="";
	}

	if ( xstatus == 0 ) {
			document.getElementById("x").innerHTML="";
			
			
	} else if (xrow!= "") {

		var post=ajx.responseXML.documentElement.getElementsByTagName("post");
		
		
		for (i=0;i<post.length ;i++) {
			txt="";    
			
			xx=post[i].getElementsByTagName("pg");
			xpg=xx[0].firstChild.nodeValue;
			xx=post[i].getElementsByTagName("idpg");
			xidpg=xx[0].firstChild.nodeValue;
			xx=post[i].getElementsByTagName("testo");
			xtesto=xx[0].firstChild.nodeValue;
			xx=post[i].getElementsByTagName("ora");
			xora=xx[0].firstChild.nodeValue;
			xx=post[i].getElementsByTagName("data");
			xdata=xx[0].firstChild.nodeValue;
	
								
	
			txt = '<table><tr><td>'+xdata+'&nbsp;'+xora+'&nbsp;' + xpg + '&nbsp;' + xtesto+'</td></tr></table>';	


			if ( xstatus > 0 )  {
				oo.document.getElementById("x").innerHTML+=txt;
				
				

			} else {
				oo.document.getElementById("x").innerHTML = txt + oo.document.getElementById("x").innerHTML;
				
				
			}

  	}
		
		var h = 0;
		try {
			h = document.body.offsetHeight + 4000; // was 5000
			
			
		}
		catch(e) {h = 0;}
		
		oo.scroll (0, h); 
	}

}

function state_change()
{ 
	if(xmlhttp.readyState  == 4) {
		if(xmlhttp.status  == 200) {
			caricoRisultati(xmlhttp);
			//var doc = xmlhttp.responseXML;   // Assign the XML file to a var
			//var element = doc.getElementsByTagName('root').item(0);   // Read the first
		} else {
			// do nothing 
		}
   }
}


function loadXMLDoc(url)
{
	try {  
		xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
	}
	catch (e) {
		try {
			xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
        catch (e2) {
			try {
				xmlhttp = new XMLHttpRequest();
			}
			catch (e3) {
				alert("Your browser does not support XMLHTTP.");
			}
		}
	}
	 
	xmlhttp.onreadystatechange  = state_change;	
	xmlhttp.open("GET",url,true);
//	xmlhttp.open("GET",url,false);
	xmlhttp.send(null);
}
