function addTextToFeilds() {
	var msgField = document.getElementById('msgField');
	msgField.onfocus = function () {
		if (msgField.value === 'your message') {
			msgField.value = "";			
		}
	};
	msgField.onblur = function () {
		if (msgField.value === "") {
			msgField.value = 'your message';			
		}
	};
}

function preparePage() {
	document.getElementById('msgForm').onsubmit = function () {
		// prevent form from submitting if no msg
		if (document.getElementById('msgField').value === '' || document.getElementById('msgField').value === 'your message') {
			document.getElementById('errorMsg').innerHTML = "please submit a message";
			// stop the form 
			return false; 
		} else {
			// reset and allow submit
			document.getElementById('errorMsg').innerHTML = "";
			// and disable the submit button to prevent dubbel submits
			document.getElementById("submitbutton").disabled = true;
			return true;
		} 	
	};
	
	document.getElementById('moreOptions').onclick = function () {
		if (document.getElementById('moreOptions').checked) {
			document.getElementById('showMoreOption').style.display = "block";
		} else {
			document.getElementById('showMoreOption').style.display = "none";	
		}			
	};
	// if not 
	document.getElementById('showMoreOption').style.display = "block";	
}


// moreOption

window.onload = function () {
	addTextToFeilds();
	preparePage(); 
};
