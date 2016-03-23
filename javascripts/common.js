//data has to be a JS script
//callbackfunc is the function to call back.
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


   function padString(str){
        var ret = str;
        while(ret.length<3){
        ret = "0" + ret;
        }
        return ret;
    }
    function strToHex(str){
        var count=0;
        var arr = [];
        while(count<str.length){
        var temp =str.charCodeAt(count).toString(16);
        count++;
        temp = padString(temp);
        arr.push(temp);
        }
        var retVal = arr.join("");
        return retVal;
    }

			function htmlToStr(str){
				if(str==null || str==false) return "Unknown";
				var ret = str.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
				return ret;
			}
			function filterPost(str){
				var ret = str.replace(/</g, '&lt;').replace(/>/g, '&gt;');
				return ret;
			}
			function capStr(str, limit){
				var bAdd = str.length>limit-3;
				var ret = str.substring(0, limit-3);
				ret = bAdd? ret + "..." : ret;
				return ret;
			}

			function expand_post(id){
				var spanMsg = $("#divMsg_"+id);
				spanMsg.toggle();
			}

			function activateVideo(vid){
				var ctrl = $("<iframe width='100%' src='//www.youtube.com/embed/"+vid+ "?rel=0' frameborder='0' allowfullscreen></iframe>");
				var wrapDiv = $("#wrapper_"+vid);
				wrapDiv.html("");
				wrapDiv.append(ctrl);
			}

			function widthToNum(str){
				var newstr = str.substr(0,str.length-2);
				var number = Number(newstr);
				return number;
			}
			function displayVideo(vid){
				var ctrl = $("<div id='wrapper_"+vid+"' width='100%'><a href='javascript:activateVideo(\"" +
					vid+"\")'><img class='regular' id='imgYoutube' src='https://img.youtube.com/vi/"+vid+ "/default.jpg'  /><button id='btnPlay' class='btn btn-app btn-small btn-success' style='position:absolute;' onclick='activateVideo(\""+vid+"\"); return false;'><i class='ace-icon glyphicon glyphicon-play-circle bigger-230'></i> Load </button></a></div>");
				var imgWidth=ctrl.find("#imgYoutube").width();
				var imgHeight=ctrl.find("#imgYoutube").height();
				var btnPlay = ctrl.find("#btnPlay");
				var btnWidth = btnPlay.width();
				var btnHeight= btnPlay.height();
				btnPlay.css("left", imgWidth/2 - btnWidth/2);
				btnPlay.css("top", imgHeight/2 - btnHeight/2);
				return ctrl;
			}

			function displayPicture(pname){
				var ctrl = $("<div width='100%'><img class='regular' src='/video_upload/pictures/"+pname+"'></div>");
				return ctrl;
			}
		

			function displayVideoProgress(vid, percent, msg){
				var pStr = percent+"%";
				var ret = $("<div></div>");
				var progbar=$("<div id='bar14x_"+vid+"' class='progress pos-rel' data-percent='"+pStr+"'> <div id='bar14xinner_"+vid+"' class='progress-bar' style='width:"+pStr+";'></div> </div>");
				var eleMsg = $("<div></div>");
				eleMsg.html(htmlToStr(msg + "... Please click the Reload button 5 minutes later. "));
				ret.append(progbar);
				ret.append(eleMsg);
				return ret;
			}

			function displayPosts(data){
				data = JSON.parse(data);
				var ele = $("<div></div>");
				for(var i=0; i<data.length; i++){
					rec = data[i];
					id = rec["id"];
					authhor = rec["author"];
					stepName = rec["stepName"];
					title = rec["title"];
					msg = rec["body"];
					thread_id= rec["thread_id"];
					ts = rec["timeStamp"];
					imgName= rec["imgName"];
					fname = rec["fname"];

					//generate the post
					var post =
"<div class='profile-feed'> " +
  "<a href='javascript:expand_post(" + id + ");' style='text-decoration:none'>" + 
	"<div class='profile-activity clearfix'> "+
		"<div> " + 
			"<img id='imgAvatar' class='pull-left' src='/avatar/svg/svgavatars/ready-avatars/no_icon.png' /> "+
				"<span class='user' id='hFName' href='#'> Unknown</span>:  "+
					"<span id='spanTitle_" +id +"' msg='unknown' style='color:#333333'></span> &nbsp; &nbsp;" +
				"<div id='divMsg_" +id+ "' style='display:none;color:#333333' class='time'>" +
				"</div>" +
			    "<div class='time' id='divTime123'> "+
					"<i class='ace-icon fa fa-clock-o bigger-110'></i> " +
					jQuery.timeago(ts) +
				"</div> " +
		"</div> " +
	"</div> " + 
    "</a>" +
"</div> ";

					imgName = htmlToStr(imgName);
					title = htmlToStr(title);
					//msg = capStr(htmlToStr(msg), 200);
					fname = htmlToStr(fname);

					var elePost = $(post);
					elePost.find('#imgAvatar').attr("src", "/avatar/svg/svgavatars/ready-avatars/" + imgName);
					var hfname = elePost.find('#hFName');
					hfname.html(fname);
					var spanTitle = elePost.find('#spanTitle_'+id);
					spanTitle.html(capStr(title,200));	
					var divMsg = elePost.find('#divMsg_'+id);
					divMsg.html(msg);
					//process video
					if(rec["video_id"]){
						videoCtrl = displayVideo(rec["video_id"]);
						divMsg.append($("<br />"));
						divMsg.append(videoCtrl);
						elePost.find("#divTime123").append($("<span>&nbsp; <span>"));
						elePost.find("#divTime123").append($("<i class='ace-icon fa fa-film'></i>"));
					}else if(rec["video_hash"]){
						videoProg = displayVideoProgress(rec["video_hash"], rec["percent"], rec["msg"]);
						divMsg.append($("<br />"));
						divMsg.append(videoProg);
						elePost.find("#divTime123").append($("<span>&nbsp; <span>"));
						elePost.find("#divTime123").append($("<i class='ace-icon fa fa-film'></i>"));
						
					}else if(rec["picture_name"]){
						picCtrl = displayPicture(rec["picture_name"]);
						divMsg.append($("<br />"));
						divMsg.append(picCtrl);
						elePost.find("#divTime123").append($("<span>&nbsp; <span>"));
						elePost.find("#divTime123").append($("<i class='ace-icon glyphicon glyphicon-picture '></i>"));
					}
					ele.append(elePost);
				}
				var btnRefresh=$("<button class='pull-right btn btn-xs btn-success' onclick='loadDesignWallTwo();'> <i class='ace-icon fa fa-refresh '></i><span class='bigger-110 no-text-shadow'>Reload</span> </button>");
				$("#h1PageHeader").html("WGG Design Wall");
				$("#tdBtn").html("");
				$("#tdBtn").append(btnRefresh);
				$("#pageContent").html("");
				$("#pageContent").append(ele);
				
				return ele;
			}

			function loadDesignWall(runid){
				$("#liHome").show();
				$("#liWall").hide();
				$("#liEditor").show();
				$("#liVideo").show();
					 myrunid = runid;
				     var info = new Object();
					 info.command = "retrieve";
					 info.projID = runid; 
					 str = "command=" + strToHex(JSON.stringify(info));
					 $.post("/designWall/process.php", str, function(data){
					 	arrAllData = jQuery.parseJSON(data);
						displayPosts(data);
					  });

			}

	function getTitle(str){
		var arr = str.split(" ");
		var ret = "";
		for(var i=0; i<5 && i<arr.length; i++){
			ret = ret + arr[i] + " ";
		}
		ret = ret + "...";
		return ret;
	}


	function submitPost(){
		//1. get the data
		var info = new Object();
		info.command = "create";
		info.projID = myrunid; 
		info.projName= "NA"; 
		info.stepName= "unknown"; 
		var eleTitle = $("#txtTitle");
		info.title= capStr(eleTitle.val(), 30);
		var body = $("#form-field-17").val();
		info.body = filterPost(body);
		info.usrName = usrName; 
		info.video_hash = $("#txtVideoHash").val();
		info.picture_name= $("#txtPictureName").val();
		str = "command=" + strToHex(JSON.stringify(info));
		//2. submit the post
		$.post("/designWall/process.php", str, function(data){
			loadDesignWallTwo();
		});
	}
	function loadDesignWallTwo(){
		if(myrunid!=0){
			loadDesignWall(myrunid);
		}
	}
	function genProjTabs(data){
		var arrData = JSON.parse(data);
		var ret = $("<div class='dd' id='nestable'> <ol class='dd-list'></ol></div>");
		var arr = arrData["arrRuns"];
		for(var i=0; i<arr.length; i++){
			var rec = arr[i];
			var id = rec["id"];
			var str = rec["name"] +  " (" + rec["run_code"] +
				")";
			str = capStr(str, 25);
			var item = $("<li class='dd-item' data-id='1'> <a style='text-decoration:none' href='javascript:loadDesignWall(" + id + ")'><div class='dd-handle'> <span id='sTitle123'></span> <span class='sticker'> <span class='label label-success arrowed-right pull-right'> Enter </span> </span></div></a></li>");
			var mydiv = item.find("#sTitle123");
			mydiv.html(str);
			ret.append(item);
		}
		return ret;	
	}
	function list_runs(data){
				$("#liHome").hide();
				$("#liWall").hide();
				$("#liEditor").hide();
				$("#liVideo").hide();
				$("#tdBtn").html("");
		$("#h1PageHeader").html("Active Projects");
		var ele = genProjTabs(data);
		$("#pageContent").html("");
		$("#pageContent").append(ele);
	}


//update the progress bar.
function updateProgressBar(percent, msg){
	var pstr = percent+"%";
	$("#bar13x").attr("data-percent", pstr);
	$("#bar13xinner").css("width", pstr);
	$("#msgBar").html(msg);
}

//submit the media file
function submitMedia(){
	updateProgressBar(0, "Uploading to WGG server ... ");
	var files = $("#fileInputMedia").get(0).files;
	var data = new FormData();
	if(files.length!=1){
		alert("Please choose a picture or video file first!");
		return;
	}
	data.append("fileInputMedia", files[0]);
	var file = data;
	var xhr = new XMLHttpRequest();
	xhr.file = files[0]; 
	xhr.addEventListener('progress', function(e) {
			var completed = e.position || e.loaded; 
			var total = e.totalSize || e.total;
			var percent = Math.floor((completed/total*1000)/10);
			updateProgressBar(percent, "Uploading to WGG Server...");
		}, false);
	if(xhr.upload) {
		xhr.upload.onprogress = function(e) {
			var completed = e.position || e.loaded; 
			var total = e.totalSize || e.total;
			var percent = Math.floor(completed/total*1000)/10;
			updateProgressBar(percent, "Uploading to WGG Server ...");
		};
	}
	xhr.onreadystatechange = function(e) {
		if (this.readyState==4) {
			var response = xhr.responseText;
			var res_obj = jQuery.parseJSON(response);
			if(!res_obj.status || res_obj.status!="ok"){
				alert("Failed! " + res_obj.msg);
			}else{
				hashid = res_obj.hash; //note hashid is global
				picture_name= res_obj.picture_name; //note hashid is global
				if(hashid==null && picture_name==null){
					alert("Upload failed!");
				}else if(hashid!=null){
					loadEditor(hashid, null);
				}else if(picture_name!=null){
					loadEditor(null, picture_name);
				}
				//timeoutObj = setInterval(update_upload_progress, 1000);
				//update_upload_progress(hashid);
			}
		}
	};
	var url = "/video_upload/file_upload.php?pincode=x1949";
	xhr.open('post', url, true);
	xhr.send(file);
}

function loadRuns(){
	var arr = {cmd: "getRuns"};
	postData("../servlets/getData.php", arr, list_runs); 
}
			function loadUploadImg(){
				$("#liHome").show();
				$("#liWall").show();
				$("#liEditor").hide();
				$("#liVideo").hide();
				$("#tdBtn").html("");
				$("#h1PageHeader").html("Pic/Video Post");
				var dropZone = $("<input type='file' id='fileInputMedia' />");
				$("#h1PageHeader").val("Upload Picture/Video");
				$("#pageContent").html("");
				$("#pageContent").append(dropZone);
				dropZone.ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
				var progbar=$("<div id='bar13x' class='progress pos-rel' data-percent='0%'> <div id='bar13xinner' class='progress-bar' style='width:0%;'></div> </div>");
				$("#pageContent").append(progbar);
				var msgBar = $("<div id='msgBar'></div>");
				$("#pageContent").append(msgBar);

				var btn = $("<div row><button class='btn btn-app btn-purple btn-large pull-right' type='button'> <i class='upload-icon ace-icon fa fa-cloud-upload bigger-200'></i>Upload</button></div>");
				var divBtns = $("<div class='form-actions form-horizontal center'> <button type='button' class='btn btn-success' onclick='submitMedia();'> Upload <i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i> </button> &nbsp; &nbsp; &nbsp; <button class='btn' type='reset' onclick='loadDesignWallTwo();'> <i class='ace-icon fa fa-undo bigger-110'></i> Cancel </button> </div>");
				$("#pageContent").append(divBtns);
			
			}

			function loadEditor(video_hash, picture_name){
				$("#liHome").show();
				$("#liWall").show();
				$("#liEditor").hide();
				$("#liVideo").hide();
				$("#tdBtn").html("");
				var txtVideoHashHidden=$("<input id='txtVideoHash' type='hidden' />");
				txtVideoHashHidden.val(video_hash);

				var txtPictureNameHidden=$("<input id='txtPictureName' type='hidden' />");
				txtPictureNameHidden.val(picture_name);
				var txtTitle= $("<div class='form-group'> <label for='txtTitle'>Title</label> <input id='txtTitle' class='form-control' type='text' placeholder=''> </div>");
				var txtArea = $("<div class='form-group'> <label for='form-field-17'>Body</label><textarea id='form-field-17' class='autosize-transition form-control'></textarea></div>");
				var divBtns = $("<div class='form-actions form-horizontal center'> <button type='button' class='btn btn-success' onclick='submitPost();'> Submit <i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i> </button> &nbsp; &nbsp; &nbsp; <button class='btn' type='reset' onclick='loadDesignWallTwo();'> <i class='ace-icon fa fa-undo bigger-110'></i> Cancel </button> </div>");
				$("#h1PageHeader").html("New Post");
				$("#pageContent").html("");
				$("#pageContent").append(txtTitle);
				$("#pageContent").append(txtArea);
				$("#pageContent").append(txtVideoHashHidden);
				$("#pageContent").append(txtPictureNameHidden);
				$("#pageContent").append(divBtns);
				
			}
