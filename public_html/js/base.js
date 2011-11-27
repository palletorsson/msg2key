
addListener(
			'submit_post_msg'
			,'click'
			,function () { 
				
				// alert('sniff sniff becomes angry'); 
				
				/* imgBox.setAttribute('src', './hamsters/top2.png');		
				imgBox.setAttribute('alt', 'angry mouse');
				imgBox.setAttribute('title', imgBox.getAttribute('alt'));
				setText('imgTitleText', 'Angry Mouse'); 
				setText('imgDescText', 'is angry'); */
				}
);

function addListener(id, eventName, fn) {
	console.log(id);
	var el = document.getElementById(id);
	if (el.addEventListener) {
		 el.addEventListener(eventName,fn,false)
	} else if (el.attachEvent) {
		 el.attachEvent('no'+eventName,fn)
	} else {
		 el['on'+eventName] = fn; // ingen punkt el 
	}
}
