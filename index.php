<?php
require("db.php");
require("banned.php");
$userIP = mysql_real_escape_string(htmlentities($_SERVER['REMOTE_ADDR']));
include("rememberme.php");
$ap[0]="register.php";
$ap[1]="login.php";
$ap[2]="mailbox.php";
$ap[3]="logout.php";
$ap[4]="verify.php";
$ap[5]="compose.php";
$ap[6]="message.php";
$ap[7]="nation.php";
$ap[8]="city.php";
$ap[9]="mycities.php";
$ap[10]="allnations.php";
$ap[11]="allcities.php";
$ap[12]="newcity.php";
$ap[13]="alliance.php";
$ap[14]="leavealliance.php";
$ap[15]="allalliances.php";
$ap[16]="viewalliance.php";
$ap[17]="joinalliance.php";
$ap[18]="createalliance.php";
$ap[19]="soldiers.php";
$ap[20]="tanks.php";
$ap[21]="fighterjets.php";
$ap[22]="battleships.php";
$ap[23]="ballisticmissiles.php";
$ap[24]="budget.php";
$ap[25]="attribution.php";
$ap[26]="myaccount.php";
$ap[27]="modify.php";
$ap[28]="search.php";
$ap[29]="declare.php";
$ap[30]="mywars.php";
$ap[31]="forgotpass.php";
$ap[32]="changepass.php";
$ap[33]="editalliance.php";
$ap[34]="groundbattle.php";
$ap[35]="seabattle.php";
$ap[36]="airbattle.php";
$ap[37]="nukeattack.php";
$ap[38]="buynukes.php";
$ap[39]="terms.php";
$ap[40]="bmattack.php";
$ap[41]="deleteall.php";
$ap[42]="offerpeace.php";
$ap[43]="stats.php";
$ap[44]="skyscraper.php";
$ap[45]="university.php";
$ap[46]="militaryhq.php";
$ap[47]="capitol.php";
$ap[48]="shrine.php";
$ap[49]="olympic.php";
$ap[50]="arcology.php";
$ap[51]="observatory.php";
$ap[52]="armory.php";
$ap[53]="stock.php";
$ap[54]="missioncontrol.php";
$ap[55]="nwds.php";
$ap[56]="spacestation.php";
$ap[57]="wtf.php";
$ap[58]="elevator.php";
$ap[59]="marvels.php";
$ap[60]="reset.php";
$ap[61]="sendgift.php";
$ap[62]="maintenance.php";
$ap[63]="paratroopers.php";
$ap[64]="snipers.php";
$ap[65]="infantry.php";
$ap[66]="vehicles.php";
$ap[67]="nomad.php";
$ap[68]="longhorn.php";
$ap[69]="aircraft.php";
$ap[70]="interceptor.php";
$ap[71]="bomber.php";
$ap[72]="sam.php";
$ap[73]="navy.php";
$ap[74]="destroyers.php";
$ap[75]="subs.php";
$ap[76]="carrier.php";
$ap[77]="donate.php";
$ap[78]="delete.php";
$ap[79]="resendvalidation.php";
$ap[80]="removealliance.php";
$ap[81]="updatealliance.php";
$ap[82]="research.php";
$ap[83]="coinmint.php";
$ap[84]="donatebonus.php";
$ap[85]="wtc.php";
$ap[86]="sendoffer.php";
$ap[87]="completeoffer.php";
$ap[88]="market.php";
$ap[89]="guides.php";
$ap[90]="about.php";
$ap[91]="cpanel.php";
$ap[92]="managebanned.php";
$ap[93]="adminedit.php";
$ap[94]="managesuspended.php";
$ap[95]="suspend.php";
$ap[96]="managemods.php";
$ap[97]="alliancewars.php";
$ap[98]="bank.php";
$ap[99]="massalliancepm.php";

//maintenance
/*
if($_GET['id'] != "62") {
if($userIP != "69.145.94.49") {
echo '<meta http-equiv="REFRESH" content="0;url=http://www.pixelnations.net/beta/index.php?id=62">';
}
}
*/

?>
<!doctype html>
<html>
<head>
<meta charset="iso-8859-1"> 
<title>Pixel Nations Beta - A free online massively-multiplayer nation simulation game!</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="SHORTCUT ICON" href="http://www.pixelnations.net/beta/images/favicon.ico">
<meta name="google-site-verification" content="gV_y3UBrz49XZBnZlurjv9gQMm6gkVCuhczv80rWi48" />
<META NAME="Description" CONTENT="Pixel Nations is a free online nation simulation game. Manage your nation while interacting with thousands of players as you become the most famous leader of all time.">
<META NAME="Keywords" CONTENT="nation game, government simulators, geo-political simulators, online game, nation simulator, political simulator, country game, build a nation, nation building game, nation creation, internet game, free internet games, management game, multiplayer games, interactive games, web games, browser game, text based game, fun game, nationstates, cybernations, pixelnations, pixel nation, pixel country, alex winchell, alex, winchell">
<META HTTP-EQUIV=Content-Type CONTENT="text/html; charset=iso-8859-1">
<META name="Copyright" content="Copyright © 2012 Pixel Nations. All Rights Reserved.">
<SCRIPT language="JavaScript" SRC="jsresources.js"></SCRIPT>
<img border="0" hspace="0" vspace="0" width="1" height="1" src="http://stats.adbrite.com/stats/stats.gif?_uid=1190768&_pid=0" />
<style type="text/css">.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}</style><script type="text/JavaScript">var qmad = new Object();qmad.bvis="";qmad.bhide="";</script>

<script type="text/javascript">/* <![CDATA[ */var qm_si,qm_li,qm_lo,qm_tt,qm_th,qm_ts,qm_la,qm_ic,qm_ib;var qp="parentNode";var qc="className";var qm_t=navigator.userAgent;var qm_o=qm_t.indexOf("Opera")+1;var qm_s=qm_t.indexOf("afari")+1;var qm_s2=qm_s&&qm_t.indexOf("ersion/2")+1;var qm_s3=qm_s&&qm_t.indexOf("ersion/3")+1;var qm_n=qm_t.indexOf("Netscape")+1;var qm_v=parseFloat(navigator.vendorSub);;function qm_create(sd,v,ts,th,oc,rl,sh,fl,ft,aux,l){var w="onmouseover";var ww=w;var e="onclick";if(oc){if(oc=="all"||(oc=="lev2"&&l>=2)){w=e;ts=0;}if(oc=="all"||oc=="main"){ww=e;th=0;}}if(!l){l=1;qm_th=th;sd=document.getElementById("qm"+sd);if(window.qm_pure)sd=qm_pure(sd);sd[w]=function(e){qm_kille(e)};document[ww]=qm_bo;if(oc=="main"){qm_ib=true;sd[e]=function(event){qm_ic=true;qm_oo(new Object(),qm_la,1);qm_kille(event)};document.onmouseover=function(){qm_la=null;clearTimeout(qm_tt);qm_tt=null;};}sd.style.zoom=1;if(sh)x2("qmsh",sd,1);if(!v)sd.ch=1;}else  if(sh)sd.ch=1;if(oc)sd.oc=oc;if(sh)sd.sh=1;if(fl)sd.fl=1;if(ft)sd.ft=1;if(rl)sd.rl=1;sd.style.zIndex=l+""+1;var lsp;var sp=sd.childNodes;for(var i=0;i<sp.length;i++){var b=sp[i];if(b.tagName=="A"){lsp=b;b[w]=qm_oo;if(w==e)b.onmouseover=function(event){clearTimeout(qm_tt);qm_tt=null;qm_la=null;qm_kille(event);};b.qmts=ts;if(l==1&&v){b.style.styleFloat="none";b.style.cssFloat="none";}}else  if(b.tagName=="DIV"){if(window.showHelp&&!window.XMLHttpRequest)sp[i].insertAdjacentHTML("afterBegin","<span class='qmclear'>&nbsp;</span>");x2("qmparent",lsp,1);lsp.cdiv=b;b.idiv=lsp;if(qm_n&&qm_v<8&&!b.style.width)b.style.width=b.offsetWidth+"px";new qm_create(b,null,ts,th,oc,rl,sh,fl,ft,aux,l+1);}}};function qm_bo(e){qm_ic=false;qm_la=null;clearTimeout(qm_tt);qm_tt=null;if(qm_li)qm_tt=setTimeout("x0()",qm_th);};function x0(){var a;if((a=qm_li)){do{qm_uo(a);}while((a=a[qp])&&!qm_a(a))}qm_li=null;};function qm_a(a){if(a[qc].indexOf("qmmc")+1)return 1;};function qm_uo(a,go){if(!go&&a.qmtree)return;if(window.qmad&&qmad.bhide)eval(qmad.bhide);a.style.visibility="";x2("qmactive",a.idiv);};;function qa(a,b){return String.fromCharCode(a.charCodeAt(0)-(b-(parseInt(b/2)*2)));};function qm_oo(e,o,nt){if(!o)o=this;if(qm_la==o&&!nt)return;if(window.qmv_a&&!nt)qmv_a(o);if(window.qmwait){qm_kille(e);return;}clearTimeout(qm_tt);qm_tt=null;qm_la=o;if(!nt&&o.qmts){qm_si=o;qm_tt=setTimeout("qm_oo(new Object(),qm_si,1)",o.qmts);return;}var a=o;if(a[qp].isrun){qm_kille(e);return;}if(qm_ib&&!qm_ic)return;var go=true;while((a=a[qp])&&!qm_a(a)){if(a==qm_li)go=false;}if(qm_li&&go){a=o;if((!a.cdiv)||(a.cdiv&&a.cdiv!=qm_li))qm_uo(qm_li);a=qm_li;while((a=a[qp])&&!qm_a(a)){if(a!=o[qp]&&a!=o.cdiv)qm_uo(a);else break;}}var b=o;var c=o.cdiv;if(b.cdiv){var aw=b.offsetWidth;var ah=b.offsetHeight;var ax=b.offsetLeft;var ay=b.offsetTop;if(c[qp].ch){aw=0;if(c.fl)ax=0;}else {if(c.ft)ay=0;if(c.rl){ax=ax-c.offsetWidth;aw=0;}ah=0;}if(qm_o){ax-=b[qp].clientLeft;ay-=b[qp].clientTop;}if(qm_s2&&!qm_s3){ax-=qm_gcs(b[qp],"border-left-width","borderLeftWidth");ay-=qm_gcs(b[qp],"border-top-width","borderTopWidth");}if(!c.ismove){c.style.left=(ax+aw)+"px";c.style.top=(ay+ah)+"px";}x2("qmactive",o,1);if(window.qmad&&qmad.bvis)eval(qmad.bvis);c.style.visibility="inherit";qm_li=c;}else  if(!qm_a(b[qp]))qm_li=b[qp];else qm_li=null;qm_kille(e);};function qm_gcs(obj,sname,jname){var v;if(document.defaultView&&document.defaultView.getComputedStyle)v=document.defaultView.getComputedStyle(obj,null).getPropertyValue(sname);else  if(obj.currentStyle)v=obj.currentStyle[jname];if(v&&!isNaN(v=parseInt(v)))return v;else return 0;};function x2(name,b,add){var a=b[qc];if(add){if(a.indexOf(name)==-1)b[qc]+=(a?' ':'')+name;}else {b[qc]=a.replace(" "+name,"");b[qc]=b[qc].replace(name,"");}};function qm_kille(e){if(!e)e=event;e.cancelBubble=true;if(e.stopPropagation&&!(qm_s&&e.type=="click"))e.stopPropagation();};function qm_pure(sd){if(sd.tagName=="UL"){var nd=document.createElement("DIV");nd.qmpure=1;var c;if(c=sd.style.cssText)nd.style.cssText=c;qm_convert(sd,nd);var csp=document.createElement("SPAN");csp.className="qmclear";csp.innerHTML="&nbsp;";nd.appendChild(csp);sd=sd[qp].replaceChild(nd,sd);sd=nd;}return sd;};function qm_convert(a,bm,l){if(!l)bm[qc]=a[qc];bm.id=a.id;var ch=a.childNodes;for(var i=0;i<ch.length;i++){if(ch[i].tagName=="LI"){var sh=ch[i].childNodes;for(var j=0;j<sh.length;j++){if(sh[j]&&(sh[j].tagName=="A"||sh[j].tagName=="SPAN"))bm.appendChild(ch[i].removeChild(sh[j]));if(sh[j]&&sh[j].tagName=="UL"){var na=document.createElement("DIV");var c;if(c=sh[j].style.cssText)na.style.cssText=c;if(c=sh[j].className)na.className=c;na=bm.appendChild(na);new qm_convert(sh[j],na,1)}}}}}/* ]]> */</script>

	<script type="text/JavaScript">

		/*******  Menu 0 Add-On Settings *******/
		var a = qmad.qm0 = new Object();

		// Item Bullets (CSS - Imageless) Add On
		a.ibcss_apply_to = "parent";
		a.ibcss_main_type = "arrow";
		a.ibcss_main_direction = "right";
		a.ibcss_main_size = 5;
		a.ibcss_main_bg_color = "#bbbbbb";
		a.ibcss_main_bg_color_hover = "#bbbbbb";
		a.ibcss_main_bg_color_active = "#bbbbbb";
		a.ibcss_main_border_color_active = "#dd3300";
		a.ibcss_main_position_x = -9;
		a.ibcss_main_position_y = -3;
		a.ibcss_main_align_x = "left";
		a.ibcss_main_align_y = "middle";
		a.ibcss_sub_type = "arrow-v";
		a.ibcss_sub_direction = "right";
		a.ibcss_sub_size = 3;
		a.ibcss_sub_border_color = "#797979";
		a.ibcss_sub_border_color_hover = "#222222";
		a.ibcss_sub_border_color_active = "#000000";
		a.ibcss_sub_position_x = -8;
		a.ibcss_sub_position_y = -1;
		a.ibcss_sub_align_x = "left";
		a.ibcss_sub_align_y = "middle";

		// Tree Menu Add On
		a.tree_enabled = true;
		a.tree_sub_sub_indent = 12;
		a.tree_hide_focus_box = true;
		a.tree_auto_collapse = true;
		a.tree_expand_animation = 2;
		a.tree_expand_step_size = 8;
		a.tree_collapse_animation = 3;
		a.tree_collapse_step_size = 15;

	</script>

<!-- Add-On Code: Tree Menu -->
<script type="text/javascript">/* <![CDATA[ */qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav=qmad.br_navigator&&qmad.br_version<7.1;qmad.tree=new Object();if(qmad.bvis.indexOf("qm_tree_item_click(b.cdiv);")==-1){qmad.bvis+="qm_tree_item_click(b.cdiv);";qm_tree_init_styles();}if(window.attachEvent)window.attachEvent("onload",qm_tree_init);else  if(window.addEventListener)window.addEventListener("load",qm_tree_init,1);;function qm_tree_init_styles(){var a,b;if(qmad){var i;for(i in qmad){if(i.indexOf("qm")!=0||i.indexOf("qmv")+1)continue;var ss=qmad[i];if(ss.tree_width)ss.tree_enabled=true;if(ss&&ss.tree_enabled){var az="";if(window.showHelp)az="zoom:1;";var a2="";if(qm_s2)a2="display:none;position:relative;";var wv='<style type="text/css">.qmistreestyles'+i+'{} #'+i+'{position:relative !important;} #'+i+' a{float:none !important;white-space:normal !important;position:static !important}#'+i+' div{width:auto !important;left:0px !important;top:0px !important;overflow:hidden !important;'+a2+az+'border-top-width:0px !important;border-bottom-width:0px !important;margin-left:0px !important;margin-top:0px !important;}';if(ss.tree_sub_sub_indent)wv+='#'+i+' div div{padding-left:'+ss.tree_sub_sub_indent+'px}';document.write(wv+'</style>');}}}};function qm_tree_init(event,spec){var q=qmad.tree;var a,b;var i;for(i in qmad){if(i.indexOf("qm")!=0||i.indexOf("qmv")+1||i.indexOf("qms")+1||(!isNaN(spec)&&spec!=i))continue;var ss=qmad[i];if(ss&&ss.tree_enabled){q.estep=ss.tree_expand_step_size;if(!q.estep)q.estep=1;q.cstep=ss.tree_collapse_step_size;if(!q.cstep)q.cstep=1;q.acollapse=ss.tree_auto_collapse;q.no_focus=ss.tree_hide_focus_box;q.etype=ss.tree_expand_animation;if(q.etype)q.etype=parseInt(q.etype);if(!q.etype)q.etype=0;q.ctype=ss.tree_collapse_animation;if(q.ctype)q.ctype=parseInt(q.ctype);if(!q.ctype)q.ctype=0;if(qmad.br_oldnav){q.etype=0;q.ctype=0;}qm_tree_init_items(document.getElementById(i));}i++;}};function qm_tree_init_items(a,sub){var w,b;var q=qmad.tree;var aa;aa=a.childNodes;for(var j=0;j<aa.length;j++){if(aa[j].tagName=="A"){if(aa[j].cdiv){aa[j].cdiv.ismove=1;aa[j].cdiv.qmtree=1;}if(!aa[j].onclick){aa[j].onclick=aa[j].onmouseover;aa[j].onmouseover=null;}if(q.no_focus){aa[j].onfocus=function(){this.blur();};}if(aa[j].cdiv)new qm_tree_init_items(aa[j].cdiv,1);if(aa[j].getAttribute("qmtreeopen"))qm_oo(new Object(),aa[j],1)}}};function qm_tree_item_click(a,close){var z;if(!a.qmtree&&!((z=window.qmv)&&z.loaded)){var id=qm_get_menu(a).id;if(window.qmad&&qmad[id]&&qmad[id].tree_enabled)x2("qmfh",a,1);return;}if((z=window.qmv)&&(z=z.addons)&&(z=z.tree_menu)&&!z["on"+qm_index(a)])return;x2("qmfh",a);var q=qmad.tree;if(q.timer)return;qm_la=null;q.co=new Object();var levid="a"+qm_get_level(a);var ex=false;var cx=false;if(q.acollapse){var mobj=qm_get_menu(a);var ds=mobj.getElementsByTagName("DIV");for(var i=0;i<ds.length;i++){if(ds[i].style.position=="relative"&&ds[i]!=a){var go=true;var cp=a[qp];while(!qm_a(cp)){if(ds[i]==cp)go=false;cp=cp[qp];}if(go){cx=true;q.co["a"+i]=ds[i];qm_uo(ds[i],1);}}}}if(a.style.position=="relative"){cx=true;q.co["b"]=a;var d=a.getElementsByTagName("DIV");for(var i=0;i<d.length;i++){if(d[i].style.position=="relative"){q.co["b"+i]=d[i];qm_uo(d[i],1);}}a.qmtreecollapse=1;qm_uo(a,1);if(window.qm_ibullets_hover)qm_ibullets_hover(null,a.idiv);}else {ex=true;if(qm_s2)a.style.display="block";a.style.position="relative";q.eh=a.offsetHeight;a.style.height="0px";x2("qmfv",a,1);x2("qmfh",a);a.qmtreecollapse=0;q.eo=a;}qmwait=true;qm_tree_item_expand(ex,cx,levid);};function qm_tree_item_expand(expand,collapse,levid){var q=qmad.tree;var go=false;var cs=1;if(collapse){for(var i in q.co){if(!q.co[i].style.height&&q.co[i].style.position=="relative"){q.co[i].style.height=(q.co[i].offsetHeight)+"px";q.co[i].qmtreeht=parseInt(q.co[i].style.height);}cs=parseInt((q.co[i].offsetHeight/parseInt(q.co[i].qmtreeht))*q.cstep);if(q.ctype==1)cs=q.cstep-cs+1;else  if(q.ctype==2)cs=cs+1;else  if(q.ctype==3)cs=q.cstep;if(q.ctype&&parseInt(q.co[i].style.height)-cs>0){q.co[i].style.height=parseInt(q.co[i].style.height)-cs+"px";go=true;}else {q.co[i].style.height="";q.co[i].style.position="";if(qm_s2)q.co[i].style.display="";x2("qmfh",q.co[i],1);x2("qmfv",q.co[i]);}}}if(expand){cs=parseInt((q.eo.offsetHeight/q.eh)*q.estep);if(q.etype==2)cs=q.estep-cs;else  if(q.etype==1)cs=cs+1;else  if(q.etype==3)cs=q.estep;if(q.etype&&q.eo.offsetHeight<(q.eh-cs)){q.eo.style.height=parseInt(q.eo.style.height)+cs+"px";go=true;if(window.qmv_position_pointer)qmv_position_pointer();}else {q.eo.qmtreeh=q.eo.style.height;q.eo.style.height="";if(window.qmv_position_pointer)qmv_position_pointer();}}if(go){q.timer=setTimeout("qm_tree_item_expand("+expand+","+collapse+",'"+levid+"')",10);}else {qmwait=false;q.timer=null;}};function qm_get_level(a){lev=0;while(!qm_a(a)&&(a=a[qp]))lev++;return lev;};function qm_get_menu(a){while(!qm_a(a)&&(a=a[qp]))continue;return a;}/* ]]> */</script>

<!-- Add-On Code: Item Bullets (CSS - Imageless) -->
<script type="text/javascript">/* <![CDATA[ */qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav6=qmad.br_navigator&&qmad.br_version<7;qmad.br_strict=(dcm=document.compatMode)&&dcm=="CSS1Compat";qmad.br_ie=window.showHelp;qmad.str=(qmad.br_ie&&!qmad.br_strict);if(!qmad.br_oldnav6){if(!qmad.ibcss)qmad.ibcss=new Object();if(qmad.bvis.indexOf("qm_ibcss_active(o,false);")==-1){qmad.bvis+="qm_ibcss_active(o,false);";qmad.bhide+="qm_ibcss_active(a,1);";if(window.attachEvent)window.attachEvent("onload",qm_ibcss_init);else  if(window.addEventListener)window.addEventListener("load",qm_ibcss_init,1);if(window.attachEvent)document.attachEvent("onmouseover",qm_ibcss_hover_off);else  if(window.addEventListener)document.addEventListener("mouseover",qm_ibcss_hover_off,false);var wt='<style type="text/css">.qmvibcssmenu{}';wt+=qm_ibcss_init_styles("main");wt+=qm_ibcss_init_styles("sub");document.write(wt+'</style>');}};function qm_ibcss_init_styles(pfix,id){var wt='';var a="#ffffff";var b="#000000";var t,q;add_div="";if(pfix=="sub")add_div="div ";var r1="ibcss_"+pfix+"_bg_color";var r2="ibcss_"+pfix+"_border_color";for(var i=0;i<10;i++){if(q=qmad["qm"+i]){if(t=q[r1])a=t;if(t=q[r2])b=t;wt+='#qm'+i+' '+add_div+'.qm-ibcss-static span{background-color:'+a+';border-color:'+b+';}';if(t=q[r1+"_hover"])a=t;if(t=q[r2+"_hover"])b=t;wt+='#qm'+i+'  '+add_div+'.qm-ibcss-hover span{background-color:'+a+';border-color:'+b+';}';if(t=q[r1+"_active"])a=t;if(t=q[r2+"_active"])b=t;wt+='#qm'+i+'  '+add_div+'.qm-ibcss-active span{background-color:'+a+';border-color:'+b+';}';}}return wt;};function qm_ibcss_init(e,spec){var z;if((z=window.qmv)&&(z=z.addons)&&(z=z.ibcss)&&(!z["on"+qmv.id]&&z["on"+qmv.id]!=undefined&&z["on"+qmv.id]!=null))return;qm_ts=1;var q=qmad.ibcss;var a,b,r,sx,sy;z=window.qmv;for(i=0;i<10;i++){if(!(a=document.getElementById("qm"+i))||(!isNaN(spec)&&spec!=i))continue;var ss=qmad[a.id];if(ss&&(ss.ibcss_main_type||ss.ibcss_sub_type)){q.mtype=ss.ibcss_main_type;q.msize=ss.ibcss_main_size;if(!q.msize)q.msize=5;q.md=ss.ibcss_main_direction;if(!q.md)md="right";q.mbg=ss.ibcss_main_bg_color;q.mborder=ss.ibcss_main_border_color;sx=ss.ibcss_main_position_x;sy=ss.ibcss_main_position_y;if(!sx)sx=0;if(!sy)sy=0;q.mpos=eval("new Array('"+sx+"','"+sy+"')");q.malign=eval("new Array('"+ss.ibcss_main_align_x+"','"+ss.ibcss_main_align_y+"')");r=q.malign;if(!r[0])r[0]="right";if(!r[1])r[1]="center";q.stype=ss.ibcss_sub_type;q.ssize=ss.ibcss_sub_size;if(!q.ssize)q.ssize=5;q.sd=ss.ibcss_sub_direction;if(!q.sd)sd="right";q.sbg=ss.ibcss_sub_bg_color;q.sborder=ss.ibcss_sub_border_color;sx=ss.ibcss_sub_position_x;sy=ss.ibcss_sub_position_y;if(!sx)sx=0;if(!sy)sy=0;q.spos=eval("new Array('"+sx+"','"+sy+"')");q.salign=eval("new Array('"+ss.ibcss_sub_align_x+"','"+ss.ibcss_sub_align_y+"')");r=q.salign;if(!r[0])r[0]="right";if(!r[1])r[1]="middle";q.type=ss.ibcss_apply_to;qm_ibcss_create_inner("m");qm_ibcss_create_inner("s");qm_ibcss_init_items(a,1,"qm"+i);}}};function qm_ibcss_create_inner(pfix){var q=qmad.ibcss;var wt="";var s=q[pfix+"size"];var type=q[pfix+"type"];var head;if(type.indexOf("head")+1)head=true;var gap;if(type.indexOf("gap")+1)gap=true;var v;if(type.indexOf("-v")+1)v=true;if(type.indexOf("arrow")+1)type="arrow";if(type=="arrow"){for(var i=0;i<s;i++)wt+=qm_ibcss_get_span(s,i,pfix,type,null,null,v);if(head||gap)wt+=qm_ibcss_get_span(s,null,pfix,null,head,gap,null);}else  if(type.indexOf("square")+1){var inner;if(type.indexOf("-inner")+1)inner=true;var raised;if(type.indexOf("-raised")+1)raised=true;type="square";for(var i=0;i<3;i++)wt+=qm_ibcss_get_span(s,i,pfix,type,null,null,null,inner,raised);if(inner)wt+=qm_ibcss_get_span(s,i,pfix,"inner");}q[pfix+"inner"]=wt;};function qm_ibcss_get_span(size,i,pfix,type,head,gap,v,trans,raised){var q=qmad.ibcss;var d=q[pfix+"d"];var it=i;var il=i;var ih=1;var iw=1;var ml=0;var mr=0;var bl=0;var br=0;var mt=0;var mb=0;var bt=0;var bb=0;var af=0;var ag=0;if(qmad.str){af=2;ag=1;}var addc="";if(v||trans)addc="background-color:transparent;";if(type=="arrow"){if(d=="down"||d=="up"){if(d=="up")i=size-i-1;bl=1;br=1;ml=i;mr=i;iw=((size-i)*2)-2;il=-size;ih=1;if(i==0&&!v){bl=iw+2;br=0;ml=0;mr=0;iw=0;if(qmad.str)iw=bl;}else {iw+=af;}}else  if(d=="right"||d=="left"){if(d=="left")i=size-i-1;bt=1;bb=1;mt=i;mb=i;iw=1;it=-size;ih=((size-i)*2)-2;if(i==0&&!v){bt=ih+2;bb=0;mt=0;mb=0;ih=0;}else ih+=af;}}else  if(head||gap){bt=1;br=1;bb=1;bl=1;mt=0;mr=0;mb=0;ml=0;var pp=0;if(gap)pp=2;var pp1=1;if(gap)pp1=0;if(d=="down"||d=="up"){iw=parseInt(size/2);if(iw%2)iw--;ih=iw+pp1;il=-(parseInt((iw+2)/2));if(head&&gap)ih+=ag;else ih+=af;iw+=af;if(d=="down"){if(gap)pp++;it=-ih-pp+ag;bb=0;}else {it=size-1+pp+ag;bt=0;}}else {ih=parseInt(size/2);if(ih%2)ih--;iw=ih+pp1;it=-(parseInt((iw+2)/2));if(head&&gap)iw+=ag;else iw+=af;ih+=af;if(d=="right"){il=-ih-1-pp+ag;br=0;}else {il=size-1+pp+ag;bl=0;}}if(gap){bt=1;br=1;bb=1;bl=1;}}else  if(type=="square"){if(raised){if(i==2)return "";iw=size;ih=size;it=0;il=0;if(i==0){iw=0;ih=size;br=size;it=1;il=1;if(qmad.str)iw=br;}}else {if(size%2)size++;it=1;ih=size;iw=size;bl=1;br=1;il=0;iw+=af;if(i==0||i==2){ml=1;it=0;ih=1;bl=size;br=0;iw=0;if(qmad.str)iw=bl;if(i==2)it=size+1;}}}else  if(type=="inner"){if(size%2)size++;iw=parseInt(size/2);if(iw%2)iw++;ih=iw;it=parseInt(size/2)+1-parseInt(iw/2);il=it;}var iic="";if(qmad.str)iic="&nbsp;";return '<span style="'+addc+'border-width:'+bt+'px '+br+'px '+bb+'px '+bl+'px;border-style:solid;display:block;position:absolute;overflow:hidden;font-size:1px;line-height:0px;height:'+ih+'px;margin:'+mt+'px '+mr+'px '+mb+'px '+ml+'px;width:'+iw+'px;top:'+it+'px;left:'+il+'px;">'+iic+'</span>';};function qm_ibcss_init_items(a,main){var q=qmad.ibcss;var aa,pf;aa=a.childNodes;for(var j=0;j<aa.length;j++){if(aa[j].tagName=="A"){if(window.attachEvent)aa[j].attachEvent("onmouseover",qm_ibcss_hover);else  if(window.addEventListener)aa[j].addEventListener("mouseover",qm_ibcss_hover,false);var skip=false;if(q.type!="all"){if(q.type=="parent"&&!aa[j].cdiv)skip=true;if(q.type=="non-parent"&&aa[j].cdiv)skip=true;}if(!skip){if(main)pf="m";else pf="s";var ss=document.createElement("SPAN");ss.className="qm-ibcss-static";var s1=ss.style;s1.display="block";s1.position="relative";s1.fontSize="1px";s1.lineHeight="0px";s1.zIndex=1;ss.ibhalign=q[pf+"align"][0];ss.ibvalign=q[pf+"align"][1];ss.ibposx=q[pf+"pos"][0];ss.ibposy=q[pf+"pos"][1];ss.ibsize=q[pf+"size"];qm_ibcss_position(aa[j],ss);ss.innerHTML=q[pf+"inner"];aa[j].qmibulletcss=aa[j].insertBefore(ss,aa[j].firstChild);ss.setAttribute("qmvbefore",1);ss.setAttribute("isibulletcss",1);if(aa[j].className.indexOf("qmactive")+1)qm_ibcss_active(aa[j]);}if(aa[j].cdiv)new qm_ibcss_init_items(aa[j].cdiv,null);}}};function qm_ibcss_position(a,b){if(b.ibhalign=="right")b.style.left=(a.offsetWidth+parseInt(b.ibposx)-b.ibsize)+"px";else  if(b.ibhalign=="center")b.style.left=(parseInt(a.offsetWidth/2)-parseInt(b.ibsize/2)+parseInt(b.ibposx))+"px";else b.style.left=b.ibposx+"px";if(b.ibvalign=="bottom")b.style.top=(a.offsetHeight+parseInt(b.ibposy)-b.ibsize)+"px";else  if(b.ibvalign=="middle")b.style.top=parseInt((a.offsetHeight/2)-parseInt(b.ibsize/2)+parseInt(b.ibposy))+"px";else b.style.top=b.ibposy+"px";};function qm_ibcss_hover(e,targ){e=e||window.event;if(!targ){var targ=e.srcElement||e.target;while(targ.tagName!="A")targ=targ[qp];}var ch=qmad.ibcss.lasth;if(ch&&ch!=targ&&ch.qmibulletcss)qm_ibcss_hover_off(new Object(),ch);if(targ.className.indexOf("qmactive")+1)return;var wo=targ.qmibulletcss;if(wo){x2("qm-ibcss-hover",wo,1);qmad.ibcss.lasth=targ;}if(e)qm_kille(e);};function qm_ibcss_hover_off(e,o){if(!o)o=qmad.ibcss.lasth;if(o&&o.qmibulletcss)x2("qm-ibcss-hover",o.qmibulletcss);};function qm_ibcss_active(a,hide){if(!hide&&a.className.indexOf("qmactive")==-1)return;if(hide&&a.idiv){var o=a.idiv;if(o&&o.qmibulletcss){x2("qm-ibcss-active",o.qmibulletcss);}}else {if(!a.cdiv.offsetWidth)a.cdiv.style.visibility="inherit";qm_ibcss_wait_relative(a);var wo=a.qmibulletcss;if(wo)x2("qm-ibcss-active",wo,1);}};function qm_ibcss_wait_relative(a){if(!a)a=qmad.ibcss.cura;if(a.cdiv){if(a.cdiv.qmtree&&a.cdiv.style.position!="relative"){qmad.ibcss.cura=a;setTimeout("qm_ibcss_wait_relative()",10);return;}var aa=a.cdiv.childNodes;for(var i=0;i<aa.length;i++){if(aa[i].tagName=="A"&&aa[i].qmibulletcss)qm_ibcss_position(aa[i],aa[i].qmibulletcss);}}}/* ]]> */</script>

<!-- Add-On Code: Show Select Containers On Load -->
<script type="text/javascript">/* <![CDATA[ */if(!qmad.sopen){qmad.sopen=new Object();qmad.sopen.log=new Array();if(window.attachEvent)window.attachEvent("onload",qm_sopen_init);else  if(window.addEventListener)window.addEventListener("load",qm_sopen_init,1);};function qm_sopen_init(e,go){if(window.qmv)return;if(!go){setTimeout("qm_sopen_init(null,1)",10);return;}var i;var ql=qmad.sopen.log;for(i=0;i<10;i++){var a;if(a=document.getElementById("qm"+i)){var dd=a.getElementsByTagName("DIV");for(var j=0;j<dd.length;j++){if(dd[j].idiv.className.indexOf("qm-startopen")+1){ql.push(dd[j].idiv);var f=dd[j][qp];if(!qm_a(f)){var b=false;for(var k=0;k<ql.length;k++){if(ql[k]==f.idiv)ql[k]=null;}ql.push(f.idiv);f=f[qp];}}}}}var se=0;var sc=0;if(qmad.tree){se=qmad.tree.etype;sc=qmad.tree.ctype;qmad.tree.etype=0;qmad.tree.ctype=0;}for(i=ql.length-1;i>=0;i--){if(ql[i]){qm_oo(new Object(),ql[i],1);qm_li=null;}}if(qmad.tree){qmad.tree.etype=se;qmad.tree.ctype=sc;}}/* ]]> */</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32341336-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<div id="header">
</div>
<div id="divider">
</div>
<div id="container">
<div id="leftcolumn">

<?php 
if(isset($_GET['id'])) {
$page = $_GET['id'];
if(is_numeric($page)) {
$include = $ap[$page];
require($include);
}
} else {
$playerNumquery = mysql_query("SELECT * FROM players");
$playerNum = mysql_num_rows($playerNumquery);
?>
<!--
    <script type="text/javascript" src="jquery-1.7.1.js"></script>
    <script type="text/javascript" src="fadeslideshow.js"></script>
    
    <script type="text/javascript">
    var gallery1 = new fadeSlideShow ({
        wrapperid: 'slideshow',
        dimensions: [950, 450],
        imagearray: [
            ["http://pixelnations.net/beta/images/bridge.jpg"],
            ["http://pixelnations.net/beta/images/navy.jpg"],
			["http://pixelnations.net/beta/images/rocket.jpg"],
			["http://pixelnations.net/beta/images/soldiers.jpg"],
			["http://pixelnations.net/beta/images/airport.jpg"],
			["http://pixelnations.net/beta/images/space.jpg"],
			["http://pixelnations.net/beta/images/ships.jpg"],
			["http://pixelnations.net/beta/images/harrier.jpg"]
        ],
        displaymode: {type: 'auto', pause: 1500, cycles:0, wraparound: true },
        persist: false, 
        fadeduration: 1500, 
        descreveal: 'always',
        togglerid: ''
    })
    </script>
	-->
	<div id="fb-root"></div>

<div id="title">
Welcome to Pixel Nations!
</div>
Congratulations! You've stumbled across Pixel Nations! What is Pixel Nations you ask? Pixel Nations is a free online massively-multiplayer nation simulation game! Each player gets to create his or her own simulated country and rule it however they see fit! Pick a national flag, government type, tax-rates, you name it! Collect taxes from your citizens and spend it on improvements like harbors, colleges, barracks, and much more! Construct national wonders that players from all around the world can marvel at. Trade with other nations, wage war with your friends or create coalitions and work together with other countries to give yourself an advantage. The choices are yours to make in Pixel Nations! <a href="index.php?id=0">Register</a> and begin playing right away! 
<?php echo number_format($playerNum); ?> people are playing Pixel Nations
<!--
<div id="slideshow" ></div>
-->
<br /><br /><center><iframe width="853" height="480" src="http://www.youtube.com/embed/5zsxaheKrRU" frameborder="0" allowfullscreen></iframe></center>

<?php
}
?>

</div>
<div id="rightcolumn">
<div id="title">
Navigation Menu
</div>
<?php 
if(isset($_SESSION['id'])) {
$id = mysql_real_escape_string(htmlentities($_SESSION['id']));
$userSelectindex = mysql_query("SELECT * FROM players WHERE id='$id'");
$userFetchindex = mysql_fetch_array($userSelectindex);
$indexUsername = $userFetchindex['username'];
$mailSelect = mysql_query("SELECT * FROM messages WHERE receiver='$indexUsername' AND readmsg='0'");
$mailCheck = mysql_num_rows($mailSelect);

if($mailCheck > 0) {
$mailboxNum = "(" .$mailCheck. ")";
}
if($userFetchindex['javamenu'] == 0) {
?>

<ul>
<li>Personal Menu
<ul>
<li><a href="index.php">Home</a></li>
<li><a target="_blank" href="http://www.pixelnations.net/forums/index.php">Forums</a></li>
<li><a target="_blank" href="http://pixelnations.referata.com/">Pixelopedia</a></li>
<li><a href="index.php?id=2">Mailbox <?php echo $mailboxNum; ?></a></li>
<li><a href="index.php?id=26">Account</a></li>
<li><a href="index.php?id=13">Alliance</a></li>
<li><a href="http://www.pndonations.com/">Donations</a></li>
<?php if($userFetchindex['level'] > 1) {
echo "<li><a href='index.php?id=91'>Control Panel</a></li>";
}
?>
<li><a href="index.php?id=3">Logout</a></li>
</ul>
</li>
<li>Domestic Menu
<ul>
<li><a href="index.php?id=7&nid=<?php echo $_SESSION['id']; ?>">Overview</a></li>
<li><a href="index.php?id=27">Policies</a></li>
<li><a href="index.php?id=9">Cities</a></li>
<li><a href="index.php?id=59">Marvels</a></li>
<li><a href="index.php?id=82">Research</a></li>
<li><a href="index.php?id=28&currentpage=1&name=<?php echo $indexUsername; ?>&type=gift">Shipments</a></li>
<li><a href="index.php?id=24">Budget</a></li>
</ul>
</li>
<li>Military Menu
<ul>
<li><a href="index.php?id=30">Wars</a></li>
<li><a href="index.php?id=65">Infantry</a></li>
<li><a href="index.php?id=66">Vehicles</a></li>
<li><a href="index.php?id=69">Aircraft</a></li>
<li><a href="index.php?id=73">Navy</a></li>
<li><a href="index.php?id=23">Ballistic Missiles</a></li>
<li><a href="index.php?id=38">Nuclear Weapons</a></li>
</ul>
</li>
<li>Global Menu
<ul>
<li><a href="index.php?id=28">Search</a></li>
<li><a href="index.php?id=88">Market</a></li>
<li><a href="index.php?id=15">Alliances</a></li>
<li><a href="index.php?id=11">Cities</a></li>
<li><a href="index.php?id=10">Nations</a></li>
<li><a href="index.php?id=43">Statistics</a></li>
</ul>
</li>


</ul>
<?php
} else {
?>

<ul id="qm0" class="qmmc">

	<li><a class="qm-startopen qmparent" href="javascript:void(0)">Personal Menu</a>

		<ul>
		<li><a href="index.php">Home</a></li>
		<li><a class="qmparent" href="javascript:void(0)">Community</a>

			<ul>
			<li><a href="http://www.pixelnations.net/forums/" target="_blank">Forums</a></li>
			<li><a href="http://pixelnations.referata.com" target="_blank">Pixelopedia</a></li>
			<li><a href="http://www.coldfront.net/tiramisu/tiramisu.swf?channels=#PixelNations" target="_blank">IRC Channel</a></li>
			<li><a href="index.php?id=89" target="_blank">Guides</a></li>
			</ul></li>

		<li><a href="index.php?id=2">Mailbox <?php echo $mailboxNum; ?></a></li>
		<li><a href="index.php?id=26">Account</a></li>
		<li><a href="index.php?id=13">Alliance</a></li>
		<li><a href="http://www.pndonations.com/">Donations</a></li>
		<li><a href="index.php?id=3">Logout</a></li>
		</ul></li>

	<li><a class="qmparent" href="javascript:void(0)">Domestic Menu</a>

		<ul>
		<li><a href="index.php?id=7&nid=<?php echo $_SESSION['id']; ?>">Overview</a></li>
		<li><a href="index.php?id=27">Policies</a></li>
		<li><a href="index.php?id=9">Cities</a></li>
		<li><a href="index.php?id=59">Marvels</a></li>
		<li><a href="index.php?id=82">Research</a></li>
		<li><a href="index.php?id=28&currentpage=1&name=<?php echo $indexUsername; ?>&type=gift">Shipments</a></li>
		<li><a href="index.php?id=24">Budget</a></li>
		</ul></li>

	<li><a class="qmparent" href="javascript:void(0)">Military Menu</a>

		<ul>
		<li><a href="index.php?id=30">Wars</a></li>
		<li><a class="qmparent" href="javascript:void(0);">Infantry</a>

			<ul>
			<li><a href="index.php?id=19">Soldiers</a></li>
			<li><a href="index.php?id=64">Snipers</a></li>
			<li><a href="index.php?id=63">Paratroopers</a></li>
			</ul></li>

		<li><a class="qmparent" href="javascript:void(0)">Vehicles</a>

			<ul>
			<li><a href="index.php?id=67">Nomads</a></li>
			<li><a href="index.php?id=20">Mavericks</a></li>
			<li><a href="index.php?id=68">Longhorns</a></li>
			</ul></li>

		<li><a class="qmparent" href="javascript:void(0)">Aircraft</a>

			<ul>
			<li><a href="index.php?id=21">Fighter Jets</a></li>
			<li><a href="index.php?id=70">Interceptors</a></li>
			<li><a href="index.php?id=71">Bombers</a></li>
			<li><a href="index.php?id=72">SAM Batteries</a></li>
			</ul></li>

		<li><a class="qmparent" href="javascript:void(0)">Navy</a>

			<ul>
			<li><a href="index.php?id=22">Battleships</a></li>
			<li><a href="index.php?id=74">Destroyers</a></li>
			<li><a href="index.php?id=75">Submarines</a></li>
			<li><a href="index.php?id=76">Carriers</a></li>
			</ul></li>

		<li><a href="index.php?id=23">Ballistic Missiles</a></li>
		<li><a href="index.php?id=38">Nuclear Weapons</a></li>
		</ul></li>

	<li><a class="qmparent" href="javascript:void(0)">Global Menu</a>

		<ul>
		<li><a href="index.php?id=28">Search</a></li>
		<li><a href="index.php?id=88">Market</a></li>
		<li><a href="index.php?id=15">Alliances</a></li>
		<li><a href="index.php?id=10">Nations</a></li>
		<li><a href="index.php?id=11">Cities</a></li>
		<li><a href="index.php?id=43">Statistics</a></li>
		</ul></li>

<li class="qmclear">&nbsp;</li></ul>

<script type="text/javascript">qm_create(0,false,0,500,'all',false,false,false,false);</script>

<?php
}
?>
</div>
<?php
} else {
?>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="index.php?id=90">About</a></li>
<li><a href="index.php?id=0">Register</a></li>
<li><a href="index.php?id=1">Login</a></li>
<li><a target="_blank" href="http://www.pixelnations.net/forums/index.php">Forums</a></li>
<li><a target="_blank" href="http://pn.referata.com">Pixelopedia</a></li>
<li><a target="_blank" href="http://ajwinchell.tumblr.com/">Blog</a></li>
</ul>
<div class="fb-like" data-href="http://www.facebook.com/pixelnations" data-send="false" data-width="285" data-show-faces="false" data-font="verdana"></div>
</div>
<?php
}
echo "</div>";
if($page != null) {
if($userIP != "66.113.46.150") {
?>

<div id="advertisement">
<center><!-- Begin: adBrite, Generated: 2012-05-21 18:46:20  -->

<span style="white-space:nowrap;"><script type="text/javascript">document.write(String.fromCharCode(60,83,67,82,73,80,84));document.write(' src="http://ads.adbrite.com/mb/text_group.php?sid=2154978&zs=3732385f3930&ifr='+AdBrite_Iframe+'&ref='+AdBrite_Referrer+'" type="text/javascript">');document.write(String.fromCharCode(60,47,83,67,82,73,80,84,62));</script>
<a target="_top" href="http://www.adbrite.com/mb/commerce/purchase_form.php?opid=2154978&afsid=1"></a></span>
<!-- End: adBrite --></center>
</div>
<?php
}
}
?>
<div id="footer">
</div>
<center>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="WC5U43MAXTE88">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" style="border:none; background:#FFF" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</center>

</body>
</html>