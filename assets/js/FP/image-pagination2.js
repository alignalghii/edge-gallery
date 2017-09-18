window.onload = setupEvents;

function setupEvents()
{
	var leftNavImg = document.querySelector('#left');
	var leftNavA   = leftNavImg.parentNode;
	leftNavA.onclick = doLeft;

	var rightNavImg = document.querySelector('#right');
	var rightNavA   = rightNavImg.parentNode;
	rightNavA.onclick = doRight;

	var clickableSlides = document.querySelectorAll('a.slide.left, a.slide.right');
	for (var i = 0; i < clickableSlides.length; i++) {
		clickableSlides[i].onclick = doSlide;
	}
}

function doLeft(event)
{
	event.preventDefault();
	var focusImgData    = document.getElementById('focus-small').parentNode.dataset;
	var slideHolderData = document.getElementById('small-ones').dataset;
	var i = Number(focusImgData.order);
	var n = Number(slideHolderData.count);
	var prev = i - 1;
	if (0 <= prev && prev < n) {
		repaginate(prev);
	}
}

function doRight(event)
{
	event.preventDefault();
	var focusImgData    = document.getElementById('focus-small').parentNode.dataset;
	var slideHolderData = document.getElementById('small-ones').dataset;
	var i = Number(focusImgData.order);
	var n = Number(slideHolderData.count);
	var next = i + 1;
	if (0 <= next && next < n) {
		repaginate(next);
	}
}

function doSlide(event)
{
	event.preventDefault();
	var img = this.firstChild;
	i = Number(this.dataset.order);
	repaginate(i);
	//var href = this.href;
}

function repaginate(newFocus)
{
	var slidesColl = document.querySelectorAll('a.slide');
	var slides = Array.from(slidesColl);
	triagedSlides = triage(1, 1, slides, newFocus);
	for (var i = 0; i < triagedSlides.length; i++) {
		var triagedSlide = triagedSlides[i];
		var lbl = triagedSlide[0];
		var a   = triagedSlide[1];
		var img = a.firstChild;
		a.className = 'slide ' + lbl;
		switch (lbl) {
			case 'notdisplayed-left':
			case 'notdisplayed-right':
				removeThisId(img, 'focus-small');
				img.className = 'fitbox small';
				break;
			case 'focus':
				a.onclick = '';
				renameAttribute(a, 'href', 'data-href');
				img.className = 'fitbox';
				img.id = 'focus-small';
				var bigFocusImg = document.getElementById('focus');
				bigFocusImg.src = img.src;
				break;
			case 'left':
			case 'right':
				a.onclick = doSlide;
				renameAttribute(a, 'data-href', 'href');
				removeThisId(img, 'focus-small');
				img.className = 'fitbox small';
				break;
		}
	}
}

function renameAttribute(element, oldAttrName, newAttrName)
{
	attrVal = element.getAttribute(oldAttrName);
	if (attrVal && newAttrName != oldAttrName) {
		element.removeAttribute(oldAttrName);
		element.setAttribute(newAttrName, attrVal);
	}
}

function removeThisId(element, id)
{
	if (element.id == id) {
		element.removeAttribute('id');
	}
}

function selfSacrifyIfParent(parent)
{
	var className = parent.className;
	firstChild = parent.firstChild;
	if (firstChild) {
		grandparent = parent.parentNode;
		grandparent.replaceChild(firstChild, parent);
		return firstChild;
	} else {
		return parent;
	}
}

function removeClasses(element, classNames)
{
	for (var i = 0; i < classNames.length; i++) {
		element.classList.remove(classNames[i]);
	}
}


function triage(leftN, rightN, arr, index)
{
	var n   = arr.length;
	var res = [];
	var i;
	if (index >= leftN) {
		for (i = 0; i < index - leftN; i++) {
			res[i] = ['notdisplayed-left', arr[i]];
		}
		for (i = index - leftN; i < index; i++) {
			res[i] = ['left', arr[i]];
		}
	} else { // index < leftN
		for (i = 0; i < index; i++) {
			res[i] = ['left', arr[i]];
		}
	}
	res[index] = ['focus', arr[i]];
	if (index + rightN < n) {
		for (i = index + 1; i <= index + rightN; i++) {
			res[i] = ['right', arr[i]];
		}
		for (i = index + rightN + 1; i < n; i ++) {
			res[i] = ['notdisplayed-right', arr[i]];
		}
	} else { // index + rightN >= n
		for (i = index + 1; i < n; i++) {
			res[i] = ['right', arr[i]];
		}
	}
	return res;
}


function peek(href)
{
	var parts = /([a-zA-Z0-9_\-]+)\/(\d+)\/(\d+)$/.exec(href);
	return '/' + parts[1] + '/' + parts[2] + '/' + parts[3];
}
