jQuery(document).ready(function(){
	
	jQuery('a[href="#pop"]').click(function(e){
		e.preventDefault();
		jQuery('.popup-overlay').addClass('open');
	});

	jQuery('a[href="#close"]').click(function(e){
		e.preventDefault();
		jQuery('.popup-overlay').removeClass('open');
	});

	let _question = jQuery('.faqs-question span');
	
	_question.click(function(){
		jQuery(this).parent().toggleClass('open');
		jQuery(this).parent().next().toggleClass('open');
	});
	
	jQuery('.steps-toggle').click(function(){
		jQuery('.steps').toggleClass('active');
	});
	
	let _seeAll = jQuery('.js-see-all');
	
	_seeAll.click(function(e){
		e.preventDefault();
		jQuery(this).hide();
		let _parent = jQuery(this).closest('.work-listing__item');
		jQuery('.work-posts__item', _parent).show();
	});
	
	jQuery('.category-toggle-control a').click(function(e){
		e.preventDefault();
		let _id = jQuery(this).attr('href');

		jQuery('.work-listing__item').removeClass('show');
		jQuery( _id ).addClass('show');
	});
	
	jQuery('.exit-close').click(function(){
		jQuery('.exit-overlay').removeClass('open');
	});
	
	// QTY
	let _plus = jQuery('.js-plus');
	let _minus = jQuery('.js-minus');
	
	_plus.click(function(e){
		e.preventDefault();
		let _parent = jQuery(this).parent();
		let _qty = jQuery('.js-qty', _parent);
		let _val = parseInt( _qty.val() );
		
		
		_val += 1;
		_qty.val( _val );
		
	});
	
	_minus.click(function(e){
		e.preventDefault();
		let _parent = jQuery(this).parent();
		let _qty = jQuery('.js-qty', _parent);
		let _val = parseInt( _qty.val() );
		
		_val -= 1;
		
		if( _val <= 1 ) {
			_val = 1;
		}
		_qty.val( _val );
		
	});
	
	let _counter = jQuery('.xoo-wsc-items-count').text();
	let _html = '<span class="js-cart-counter">' + _counter + '</span>';
	let _counterCart = jQuery('.icon-cart').append( _html );
	
	jQuery("a.fake-link").fancybox({
		cyclic: true,
		hideOnContentClick: true
	});

	jQuery('.fake-linkx').click(function(e){
		e.preventDefault();
		
		let _headline = jQuery(this).data('headline');
		let _excerpt  = jQuery(this).data('excerpt');
		let _content  = jQuery(this).data('content');
		
		const _wrapperHeadline = jQuery('.js-headline');
		const _wrapperExcerpt  = jQuery('.js-excerpt');
		const _wrapperContent  = jQuery('.js-content');
		
		jQuery('.overlay-work').addClass('open');
		jQuery('body').addClass('open');
		_wrapperHeadline.html('');
		_wrapperExcerpt.html('');
		_wrapperContent.html('');
		
		_wrapperHeadline.html(_headline);
		_wrapperExcerpt.html(_excerpt);
		_wrapperContent.html(_content);
	});
	
	jQuery('.js-overlay-close, .overlay-work').click(function(e){
		e.preventDefault();
		
		const _target = e.target.classList;
		
		if( _target.contains('overlay-work') || _target.contains('js-overlay-close') ) {
			const _wrapperHeadline = jQuery('.js-headline');
			const _wrapperExcerpt  = jQuery('.js-excerpt');
			const _wrapperContent  = jQuery('.js-content');
			jQuery('.overlay-work').removeClass('open');
			jQuery('body').removeClass('open');
			
			_wrapperHeadline.html('');
			_wrapperExcerpt.html('');
			_wrapperContent.html('');
		}
		
	});
	
	const _img = document.querySelectorAll('img');
	
	_img.forEach( _item => {
		if( _item.getAttribute('alt') === "" || !_item.hasAttribute('alt') ) {
			_item.setAttribute('alt', 'Incrementum Digital Asset');
		}
	});
	
	const _svg = document.querySelectorAll('svg');
	
	_svg.forEach( _item => {
		if( _item.getAttribute('alt') === "" || !_item.hasAttribute('alt') ) {
			_item.setAttribute('alt', 'Incrementum Digital Asset');
		}
	});

});

const exit = e => {
    const shouldExit =
        [...e.target.classList].includes('exit-overlay') || // user clicks on mask
        e.target.className === 'exit-close' || // user clicks on the close icon
        e.keyCode === 27; // user hits escape

    if (shouldExit) {
        document.querySelector('.exit-overlay').classList.remove('open');
    }
};


const mouseEvent = e => {
    const shouldShowExitIntent = 
        !e.toElement && 
        !e.relatedTarget &&
        e.clientY < 10;

    if (shouldShowExitIntent ) {
        document.removeEventListener('mouseout', mouseEvent);
        document.querySelector('.exit-overlay').classList.add('open');
		
		setCookie('_exitCookie', 'true', 1);
		
		let _overlay = document.querySelector('.exit-overlay');
		_overlay.addEventListener('click', exit);
		
    }
};

if ( !getCookie('_exitCookie') ) {
    setTimeout(() => {
        document.addEventListener('mouseout', mouseEvent);
        document.addEventListener('keydown', exit);
		
    }, 0);
}


// MOBILE EXIT INTENT
setTimeout(() => {
  document.addEventListener("scroll", scrollSpeed);
}, 10000);

let newPosition = null;
scrollSpeed = () => {
  lastPosition = window.scrollY;
  setTimeout(() => {
    newPosition = window.scrollY;
  }, 100);
  currentSpeed = newPosition - lastPosition;


  if (currentSpeed > 160) {
	  if ( !getCookie('_exitCookie') ) {
		console.log("Exit intent popup triggered");
		document.removeEventListener("scroll", scrollSpeed);
		document.querySelector('.exit-overlay').classList.add('open');

		setCookie('_exitCookie', 'true', 1);

		let _overlay = document.querySelector('.exit-overlay');
		_overlay.addEventListener('click', exit);
	  }
	
  }
};

function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  let expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let ca = document.cookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
