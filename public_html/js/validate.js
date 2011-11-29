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
	
	var keyField = document.getElementById('keyField');
	keyField.onfocus = function () {
		if (keyField.value === 'insert key') {
			keyField.value = "";			
		}
	};
	keyField.onblur = function () {
		if (keyField.value === "") {
			keyField.value = 'insert key';			
		}
	};

}

function preparePage() {
	var submittedMsg = false;
	var submittedKey = false;

	document.getElementById('msgForm').onsubmit = function () {
		// prevent form from submitting if no msg
		if (document.getElementById('msgField').value === '' || document.getElementById('msgField').value === 'your message') {
			document.getElementById('errorMsg').innerHTML = "please type a message";
			// stop the form 
			return false; 
		} else {
		//	if (submittedMsg) { return false;
			// }			// reset and allow submit
			
			document.getElementById('errorMsg').innerHTML = "";
			// and disable the submit button to prevent dubbel submits
			document.getElementById("submitMsg").disabled = true;
			document.getElementById("errorMsg").innerHTML = "processing...";
			submittedMsg = true;
			return true;
		} 	
	};
	// more options 
	document.getElementById('moreOptions').onclick = function () {
		if (document.getElementById('moreOptions').checked) {
			document.getElementById('showMoreOption').style.display = "block";
		} else {
			document.getElementById('showMoreOption').style.display = "none";	
		}			
	};
	// if not 
	document.getElementById('showMoreOption').style.display = "none";	
	
	document.getElementById('keyForm').onsubmit = function () {
		// prevent form from submitting if no key
		if (document.getElementById('keyField').value === '' || document.getElementById('keyField').value === 'insert key') {
			document.getElementById('errorKey').innerHTML = "please insert a key";
			// stop the form 
			return false; 
		} else {
			//if (submittedKey) { return false;
			//}			// reset and allow submit
			
			document.getElementById('errorKey').innerHTML = "";
			// and disable the submit button to prevent dubbel submits
			document.getElementById("submitKey").disabled = true;
			document.getElementById("errorKey").innerHTML = "processing...";
			submittedKey = true;
			return true;
		 } 	
	};
	
}


// moreOption

window.onload = function () {
	addTextToFeilds();
	preparePage(); 
};
