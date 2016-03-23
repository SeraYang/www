//-----------------------------------------------------------
// functions for mobile version, mainly handling postMessage
//-----------------------------------------------------------

function del_cookie(cname) {
                document.cookie = cname +'=;Path=/;Expires=Fri, 02 Jan 1970 00:00:01 GMT;';
}

//get the view of the project
function getView(){
	return getViewConcrete(this);
}

//get the view of the project
function getViewConcrete(obj){
		var view = null;
		for(var i=0; i<obj.eventManager.events.length;i++){
			var ev = obj.eventManager.events[i];
			if(ev.type=='showJournal'){
				view = ev.objs[0];
				break;
			}
		}
		return view;
}

function postData(url, data, callbackfunc){
  var xhr= $.post( url, data, function() {
    })
        .done(function(data) {
            callbackfunc(data);
        })
        .fail(function() {
            alert("AJAX call to " + url + " failed!");
        })
}

function callbackLogin(e){
	if(e.indexOf("PROJECT MENU")>=0 || e.indexOf("WISE Teacher")>=0){ 
		var role = e.indexOf("WISE Teacher")>=0? "teacher" : "student";
		var arr = {"cmd": "infoLoginSuccess", "role": role, 
			"msg": "all information retrieved!"};
		var str = JSON.stringify(arr);
		window.parent.parent.postMessage(str, '*');
		window.location="/webapp/student/index.html";	
	}else{
		var arr = {"cmd": "infoLoginFail", "msg": "failed to retrieve user profile. Please log out and then log in again!"};
		var str = JSON.stringify(arr);
		window.parent.parent.postMessage(str, '*');
	}
}

function cloneArr(arr){
	var newarr = [];
	for(var i=0; i<arr.length; i++){
		newarr.push(arr[i]);
	}
	return newarr;
}

function massageArrPos(arr){
	//start from 2nd element
	var newarr = [];
	for(var i=0; i<arr.length; i++){
		newarr.push(arr[i]);
	}
	return newarr;
}
//extract the list of steps as desendents of node
//arrPos is the the position of node, it's an array of integer
function extractSteps(node, arrPos){
	var arr = [];
	if(node.type!="sequence"){
	
		var item = {"id": node.id, "title": node.title, "pos": massageArrPos(arrPos)};
		arr.push(item);
	}
	if(node.children!=null){
		for(var i=0; i<node.children.length; i++){
			var child = node.children[i];
			var newpos = cloneArr(arrPos);
			newpos.push(i);	
			var partResult = extractSteps(child, newpos);
			if(partResult!=null && partResult.length>0){
					arr = arr.concat(partResult);
			}
		}
	}
	return arr;
}
function callbackVLE(e, arg){
		var x = 1;
		var view = getView();
		if(arg[0].indexOf("nav.js")<0) return;

		//only process nav.js which displays the menu completes.
		var rootnode = view.getProject().getRootNode();
		console.log("callbackVLE: " + JSON.stringify(e) + "args: " + arg);
		console.log("project is " + JSON.stringify(view.getProject()) );

		//test code below
		var listSteps = extractSteps(rootnode, []); 
		var arr = {"cmd": "listSteps", "rootnode": listSteps};
		var str = JSON.stringify(arr);
		window.parent.parent.postMessage(str, '*');
}

function myurlencode(str){
	return encodeURIComponent(str).replace(/%20/g,'+');
}

var nodeToLoad = null;

function mynodeLoaded(e, stepID){
	var x = 1;
	if(stepID==nodeToLoad){//shoot the message to parent.
		var arr = {"cmd": "infoRenderNodeComplete", "stepID":stepID};
		var str = JSON.stringify(arr);
		window.parent.parent.postMessage(str, '*');
	}
}


var bHasSubscribed = false;
function receiver(e) {
	var str = e.data;
	var arr = JSON.parse(e.data);
	if(arr["cmd"]=="login"){
		del_cookie("JSESSIONID", null, { path: '/' });
		del_cookie("pLT", null, { path: '/' });
		var uname = arr["info1"];
		var pwd= arr["info2"];
		var postStr = "j_username="+myurlencode(uname)+"&j_password="+myurlencode(pwd);;
		postData("https://localhost:8443/webapp/j_acegi_security_check", postStr, callbackLogin);
	}else if(arr["cmd"]=="loadRun"){
		var arr2 = {"cmd": "infoLoadRunStarts", "msg": "started to load project ..."};
		var str = JSON.stringify(arr2);
		window.parent.parent.postMessage(str, '*');
		var runid = arr["runID"];
		var groupid = arr["workgroupID"];
		window.location = "https://localhost:8443/webapp/student/vleMobile/vle.html?runId="+ runid + "&workgroupId="+groupid;
		var x = 1;
	}else if(arr["cmd"]=="loadStep"){
		var stepID = arr["stepID"];
		nodeToLoad = stepID; 
		var topifrm = this.frames["topifrm"];
		if(topifrm){
				var view = getViewConcrete(topifrm);
				if(!bHasSubscribed){
						view.eventManager.subscribe("renderNodeComplete",mynodeLoaded);
						bHasSubscribed = true;
				}
				view.eventManager.fire("renderNode", stepID, view);
		}
	}
}
window.addEventListener('message', receiver, false);
