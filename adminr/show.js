//fuction to show the right results from showthis.php
function show(val)
{
  var test = document.getElementById("test_score").value;
  var exam = document.getElementById("exam_score").value;
  var total = document.getElementById("total_score").value;
  var reg = val;

  const xhttp = new XMLHttpRequest();
  

  var url="showThis.php";
  url=url+"?class="+test+"&stream="+exam+"&subject="+total+"&reg_num="+reg;
  url=url+"&sid="+Math.random();
  xhttp.open("GET",url,true);
  xhttp.onreadystatechange = function() 
  { 
	if (this.readyState==4 && this.status == 200)
	{ 
	  document.getElementById("showClassResults").innerHTML = this.responseText;
	}
  };
  xhttp.send();
}