// `window.onload = setupEvents` would cause corrupt images, mimick jQuery's $(document).onload(...)`:
if (document.readyState == 'complete') {
	main();
} else {
	document.addEventListener('DOMContentLoaded', main);
}

function main()
{
	detect(setupEvents_normal, setupEvents_compact);
}

function detect(normalCase, compactCase)
{
	if (isMobile() || isSmall()) {
		compactCase();
	} else {
		normalCase();
	}
}

function isMobile()
{
	return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}


function isSmall()
{
	return cmWidth() < 15;
}

function cmWidth()
{
	var csspx = window.innerWidth;
	var csspxToCm = 2.54 / 96;
	return csspx * csspxToCm;
}

function setupEvents_normal()
{
	var leftNavImg = document.getElementById('left');
	var leftNavA   = leftNavImg.parentNode;
	leftNavA.onclick = doLeft;

	var rightNavImg = document.getElementById('right');
	var rightNavA   = rightNavImg.parentNode;
	rightNavA.onclick = doRight;

	var clickableSlides = document.querySelectorAll('a.slide.left, a.slide.right');
	for (var i = 0; i < clickableSlides.length; i++) {
		clickableSlides[i].onclick = doSlide;
	}

	var slideSetData = document.getElementById('test-pager-strip').dataset;
	var leftN  = Number(slideSetData.triageLeft);
	var rightN = Number(slideSetData.triageRight);

	var slidesColl = document.querySelectorAll('a.slide');
	var slides = Array.from(slidesColl);
	var n = slides.length;

	var slideHolderData = document.getElementById('test-pager-strip').dataset;
	var bigFocusImg = document.getElementById('focus');


	function repaginate(newFocus)
	{
		var triagedSlides = triage(leftN, rightN, slides, newFocus);

		hideShowNavButtons(newFocus, n, leftNavA, rightNavA, 'enabled');
		// NO CALL TO `rewriteFallbackLink(newFocus, triagedSlides)` !!!!

		for (var i = 0; i < n; i++) {
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

	function doLeft(event)
	{
		event.preventDefault();
		var focusImgData    = document.getElementById('focus-small').parentNode.dataset;
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
		var i = Number(this.dataset.order);
		repaginate(i);
		//var href = this.href;
	}


}



function hideShowNavButtons(newFocus, n, leftElm, rightElm, enablerClassName)
{
	if (newFocus <= 0) {
		hideNav(leftElm, enablerClassName);
	} else {
		leftElm.firstChild.classList.add(enablerClassName);
		showNav(leftElm);
	}
	if (newFocus >= n - 1) {
		rightElm.firstChild.classList.remove(enablerClassName);
		hideNav(rightElm);
	} else {
		rightElm.firstChild.classList.add(enablerClassName);
		showNav(rightElm);
	}
}

function showNav(a, enablerClassName)
{
	var img = a.firstChild;
	img.src = img.dataset.show;
	img.classList.add(enablerClassName);
	renameAttribute(a, 'data-href', 'href');
}

function hideNav(a, enablerClassName)
{
	var img = a.firstChild;
	img.src = img.dataset.hide;
	img.classList.remove(enablerClassName);
	renameAttribute(a, 'href', 'data-href');
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

function setupEvents_compact()
{
	var leftNavImg = document.getElementById('left');
	var leftNavA   = leftNavImg.parentNode;
	leftNavA.onclick = doLeft;

	var rightNavImg = document.getElementById('right');
	var rightNavA   = rightNavImg.parentNode;
	rightNavA.onclick = doRight;

	var slideHolder = document.getElementById('test-pager-strip');
	var slidesColl = document.querySelectorAll('a.slide');
	for (var i = 0; i < slidesColl.length; i++) {
		slidesColl[i].style.display = 'none';
	}
	slideHolder.style.overflow = 'hidden'; // see explanation below:
	// https://stackoverflow.com/questions/20180081/css-background-color-with-floating-elements
	// https://stackoverflow.com/questions/11709433/floating-div-not-displaying-background-color-when-i-am-not-using-overflow
	// https://stackoverflow.com/questions/9538247/css-background-disappears-when-using-floatleft

	leftNavImg.style.width  = '18vw';
	rightNavImg.style.width = '18vw';

	var slides = Array.from(slidesColl);
	var n = slides.length;
	var i = Number(slideHolder.dataset.order);

	var bigFocusImg = document.getElementById('focus');


	function repaginate(newFocus)
	{
		hideShowNavButtons(newFocus, n, leftNavA, rightNavA, 'enabled');
		// NO CALL TO `rewriteFallbackLink(newFocus, triagedSlides)` !!!!
		bigFocusImg.src = slides[newFocus].firstChild.src;
	}

	function doLeft(event) // uses i
	{
		event.preventDefault();
		var prev = i - 1;
		if (0 <= prev  && prev < n) {
			i = prev;
			repaginate(prev);
		}
	}

	function doRight(event) // uses i
	{
		event.preventDefault();
		var next = i + 1;
		if (0 <= next && next < n) {
			i = next;
			repaginate(next);
		}
	}

}
