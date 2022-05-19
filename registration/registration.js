// JavaScript Document


// Function to display and change tabs
function tabOver(str, str2)
{
	document.getElementById('tab1').className = "tabs";
	document.getElementById('tab2').className = "tabs";
	document.getElementById('viewMessages').style.display="none";
	document.getElementById('composeNotice').style.display="none";
	document.getElementById(str).style.display="block";
	document.getElementById(str2).className = "tabs_active";
}

//Function to validate a name.
//it takes in a name and id of where to display the warning.
function vName(name, warn)
{
	document.getElementById(warn).className = "warn";
	name.toString();
	var valid = /^[a-zA-Z]+[a-zA-Z.]*$/ ;
	if( valid.test(name) )
	{
		document.getElementById(warn).innerText = "";
	}
	else if( name == "" )
	{
		document.getElementById(warn).innerText = "*name required";
	}
	else
	{
		document.getElementById(warn).innerText = "*revise name";
	}
}

// Validate email
//it takes in an email and id of where to display the warning.
function vEmail(email, warn)
{
	var valid = /^[a-z0-9_+.-]+\@([a-z0-9-]+\.)+[a-z0-9]{2,4}$/i;
	document.getElementById(warn).className = "warn";
	if( valid.test(email) )
	{
		document.getElementById(warn).innerText = "";
	}
	else if( email == "" )
	{
		document.getElementById(warn).innerText = "*e-mail is required";
	}
	else
	{
		document.getElementById(warn).innerText = "*invalid e-mail";
	}
}

// Validate index number
//it takes in an index number and id of where to display the warning.
function vIndex(index, warn)
{
	var valid = /^[0-9]{2}\/[a-z]{1}\/[0-9]{3,4}\/[a-z]{3}\/[a-z]{2}$/i;
	document.getElementById(warn).className = "warn";
	if( valid.test(index) )
	{
		document.getElementById(warn).innerText = "";
	}
	else if( index == "" )
	{
		document.getElementById(warn).innerText = "*reg. number is required";
	}
	else
	{
		document.getElementById(warn).innerText = "*revise reg. number";
	}
}