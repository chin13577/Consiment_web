function myFunction(elem) {
	var tid = elem.value;
	$('#proof' + tid).show(500);
}

function myHide(elem) {
	var tid = elem.value;
	$('#proof' + tid).hide(500);
}