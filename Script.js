function functest1()
{
	//var items = document.getElementsByClassName("panel-body");
	//for(var i = 0; i < items.length; i++)
	//{
		//var current_item = items[i];
		//current_item.style.opacity = 0;
		//current_item.style.maxHeight = "0px";
	//}
	
	var itemA = document.getElementById("Pre-Make");
	itemA.style.opacity = 0;
	itemA.style.maxHeight = "0px";

	setTimeout(function(){ 
		itemA.style.display = "none";
		var itemB = document.getElementById("Make");
		itemB.style.opacity = 1;
		itemB.style.maxHeight = "1000px";
	}, 1500);

	functest2();
	document.getElementById("progress_step1").style.color = "green";
	document.getElementById("progress_step1").innerHTML = "Finished";
	document.getElementById("progress_step2").style.color = "gold";
}

function functest2()
{
    $('#theForm').ajaxSubmit({
        beforeSubmit: showRequest,
        success: processJson
    });
    return false;

}

function processJson(data) {
    //debugger;
    console.log(data);
	document.getElementById("progress_step2").style.color = "green";
	document.getElementById("progress_step2").innerHTML = "Finished";
	document.getElementById("progress_step3").style.color = "green";
	document.getElementById("progress_step3").innerHTML = "Finished";
	document.getElementById("Make_final_panel").style.opacity = 1;
	document.getElementById("Make_final_panel").style.maxHeight = "1000px";
	var getlinkname = document.getElementById("user_db_id").value;
	var linkname = "http://www.altanalyze.org/ICGS/Public/".concat(getlinkname).concat("/User.php");
	document.getElementById("linkout").href = linkname;
	document.getElementById("linkout").innerHTML = linkname;
}
function showRequest(formData, jqForm, options) {
    //debugger;
    var queryString = $.param(formData);
    console.log('About to submit: \n' + queryString + '\n');
    return true;
}

$('#theForm').ajaxForm({
    beforeSubmit: showRequest,
    success: processJson
});

function onSelectGo()
{
	location.href = "http://www.altanalyze.org/ICGS/AssemblyLine/portal.php";
}

function onSelectCreate()
{
	location.href = "http://www.altanalyze.org/ICGS/AssemblyLine/AssemblyLine.html";
}