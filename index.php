<!DOCTYPE HTML>
<html lang="en">
<head>
<title> Table row File </title>
<style>
@import url(https://fonts.googleapis.com/css?family=Raleway);

* {
  font-family: "Raleway", sans-serif, sans;
  margin: 0;
  padding: 0;
}

body {
  /*background: linear-gradient(-45deg, #483D8B, #6F3D8B);
*/
  background: #46D1A3;
}

#ms, #ms th, #ms td {
  padding: 0.8rem;
  /*border-collapse: collapse; */
  border-radius: 5px;
}
#ms {
  margin: 0px auto;
  background: teal;
}

#ms tr:nth-child(1n) {
  opacity: 0;
}

/* To center just the first column */
#ms tr td:first-child {
  text-align: center;
}

#ms tr:nth-child(2n) {
  background: #bbb;
}
#ms tr:nth-child(2n - 1) {
  background: #fff;
}
/*#m tr:first-child th:first-child {
  border-top-left-radius: 15px;
}*/
#rerun {
  width: 100px;
  height: 50px;
  font-size: 1.2em;
}
#errorMsgDiv {
    background-color: #e60303;
    padding: 15px;
    /* display: inline-block; */
    max-width: 200px;
    margin: 12px auto;
    color: #FFF;
	display: none;
}
#LoaderDiv {
	position: fixed;
	width: 100%;
	height: 100%;
	background-color: rgba(0,0,0, 0.5);
	top: 0;
	display: none;
	z-index: 1;
}
.LoaderDivInnerTable {
    width: 100%;
    height: 100%;
    display: table;
}
.LoaderDivInnerCell {
	display: table-cell;
	vertical-align: middle;
	width: 100%;
	text-align: center;
	height: 100%;
}
</style>
</head>
<body>
<button type="button" name="btnResult" id="btnResult">Get Result</button>
<div id="errorMsgDiv" ></div>
<div id="LoaderDiv" ><div class="LoaderDivInnerTable" ><div class="LoaderDivInnerCell" ><img src="img/loader-img.gif" width="80" height="80"></div></div></div>
<table id="ms">
<?php 
$result;

	//foreach()
?>
</table>

<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
var GetData;
$("#btnResult").click(function(){
	htmls='';
	$("#LoaderDiv").fadeIn();
	$.ajax({
		type: "GET",
		url: "https://reqres.in/api/users?delay=3",
		success: function(data) {
			GetData = data;
			
			console.log(data.length);
			console.log(data);
			var count=0;
			for(var i =0;i < GetData.data.length;i++){
				if(count==0){
					htmls+='<tr>'
				}
				htmls += '<td>'+GetData.data[i].first_name+'</td>'+'<td>'+GetData.data[i].last_name+'</td>'+'<td><img src="'+GetData.data[i].avatar+'" alt="'+GetData.data[i].first_name+'"></td>';
				if(count!=GetData.data[i].id){
					htmls+='</tr>';
					count=0;
				}
				count=GetData.data[i].id;
			}
			$("#errorMsgDiv").html("").fadeOut();
			$("#LoaderDiv").fadeOut();
			$("#ms").html(htmls);
			animateTable();
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			if (XMLHttpRequest.readyState == 4) {
				// HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
				$("#errorMsgDiv").html("").fadeIn();
			}
			else if (XMLHttpRequest.readyState == 0) {
				// Network error (i.e. connection refused, access denied due to CORS, etc.)
				$("#errorMsgDiv").html("connection refused, access denied").fadeIn();
			}
			else {
				// something weird is happening
				$("#errorMsgDiv").html("something weird is happening").fadeIn();
			}
			$("#LoaderDiv").fadeOut();
		}
	});
});
	
/*
  I took some data from 'Good Mythical Morning' on youtube
  to use as sample data 
*/
var employees = {
"Alex Punch" : "Production Coordinator",
"Becca Canote" : "Content & Studio Manager",
"Ben Eck" : "Director of Photography",
"Brian Johanson" : "Producer",
"Candace Carrizales" : "Host/Co-Creator, The Hey Hey Show",
"Chase Hilt" : "Production Assistant",
"Edward Coleman" : "Writer/Producer, Good Mythical Morning",
"Jen Matichuk" : "Social Media Manager",
"Kevin Kostelnik" : "Producer/Editor, Ear Biscuits & Song Biscuits",
"Leann Bowen" : "Editor, The Hey Hey Show",
"Leo Kei Angelos" : "Assistant Editor",
"Lizzie Redner" : "Writer / Producer, The Hey Hey Show",
"Morgan Locke" : "Editor, Good Mythical Morning",
"Shannon Coffey" : "Host/Co-Creator, The Hey Hey Show",
"Stevie Wynne Levine" : "Head of Production & Development" 
};

//Can't be set until table is filled
// for obvious reasons
var rows = 0;

//Set variables to decide things like button disable time
//And also eases the changing of animation
var fadeTime = 1000;
var delayTime = 100;

//This also won't be correct until table is set
//since it depends on rows
//Used to decide how long button needs to be disabled after clicked
var animTime = 0;
    
$(document).ready(function() {
  //Create the actual table from the dict
  $("#m").append("<tr class='hide'><th> # </th><th> Name </th><th> Position </th></tr>");
  var ij = 1;
  for (var key in employees) 
  {
    $("#m").append("<tr class='hide'><td>" + ij + "</td><td>" + key + "</td><td> " + (employees[key]) + "</td></tr>");
    ij++;
  }
  
  //Now we can properly set the rows and animTime variable
  rows = $("#ms tr").length;
  animTime = (rows * delayTime) + fadeTime + 100;
  //+100 for margin
  
  //make button unclickable for x sec so animation can finish
  $("#rerun").attr("disabled", true);
  setTimeout(function() { enableClick($("#rerun")) }, animTime);
  
  animateTable();
});

//Loop through all table rows and fade them in
var animateTable = function(i, rows)
{
  (function next(i) {
    if (i++ >= rows) return;
    setTimeout(function() {
        $("#ms tr:nth-child(" + i + ")").fadeTo(fadeTime, 0.7);
        next(i);
    }, delayTime);
  })(0, rows);
}

//The button to rerun animation
$("#rerun").click(function() 
{
  //Disable button until animation complete to avoid bug
  $(this).attr("disabled", true);
  setTimeout(function() { enableClick($("#rerun")) }, animTime);
  
  //Set opacity to 0 and run it again
  $("#ms tr:nth-child(1n)").css("opacity", 0);
  animateTable();
});

//Make button clickable again
var enableClick = function(ele) {
    $(ele).removeAttr("disabled");
}
</script>
</body>
</html>