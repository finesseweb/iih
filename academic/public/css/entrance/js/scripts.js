$(window).bind('resizeEnd', function () {
	calculateHeight();
});

function calculateHeight() {
	if ($(window).width() < 768) {
		$('.carousel-item').css({
			height: $(window).height(),
		});
	} else {
		$('.carousel-item').css({
			height:
				$(window).height() -
				$('.header').outerHeight(true) -
				$('footer').outerHeight(true) / 3,
		});
	}
}

$(document).ready(function () {
	$('[data-toggle="tooltip"]').tooltip();
	$('.logofixed').hide();
	headerScrollEffect();
	$(window).scroll(function () {
		headerScrollEffect();
	});
});

function headerScrollEffect() {
	var scroll = $(window).scrollTop();
	if (scroll >= 20) {
		$('.logofixed').show();
		$('.logox').hide();
		$('.navbar-light .list-inline a.btnread').addClass('btnreadfixed');
		$('.navbar-light .navbar-nav .nav-link.btnread.virt_btn').addClass(
			'btnreadfixed'
		);
		$('.fixed-top').addClass('darkHeader');
	} else {
		$('.logofixed').hide();
		$('.logox').show();
		$('.fixed-top').removeClass('darkHeader');
		$('.navbar-light .list-inline a.btnread').removeClass('btnreadfixed');
		$('.navbar-light .navbar-nav .nav-link.btnread.virt_btn').removeClass(
			'btnreadfixed'
		);
	}
}

jQuery('.c_ul_1 > li > a').click(function () {
	jQuery(this)
		.parent('li')
		.parent('ul')
		.parent('div')
		.children('div')
		.children('div')
		.removeClass('active');
	jQuery(this)
		.parent('li')
		.parent('ul')
		.parent('div')
		.children('div')
		.children('div')
		.addClass('fade');

	jQuery(jQuery(this).attr('data-href')).addClass('active');
	jQuery(jQuery(this).attr('data-href')).removeClass('fade');
	jQuery(this)
		.parent('li')
		.parent('ul')
		.children('li')
		.children('a')
		.removeClass('active');
	jQuery(this).addClass('active');
});
jQuery('.c_ul_2  > li > a').click(function () {
	jQuery(this)
		.parent('li')
		.parent('ul')
		.parent('div')
		.children('div')
		.children('div')
		.removeClass('active');
	``;
	jQuery(this)
		.parent('li')
		.parent('ul')
		.parent('div')
		.children('div')
		.children('div')
		.addClass('fade');

	jQuery(jQuery(this).attr('data-href')).addClass('active');
	jQuery(jQuery(this).attr('data-href')).removeClass('fade');
	jQuery(this)
		.parent('li')
		.parent('ul')
		.children('li')
		.children('a')
		.removeClass('active');
	jQuery(this).addClass('active');
});
jQuery('.c_ul_3  > li > a').click(function () {
	jQuery(this)
		.parent('li')
		.parent('ul')
		.parent('div')
		.parent('div')
		.children('div')
		.children('div')
		.children('div')
		.removeClass('active');
	jQuery(this)
		.parent('li')
		.parent('ul')
		.parent('div')
		.parent('div')
		.children('div')
		.children('div')
		.children('div')
		.addClass('fade');

	jQuery(jQuery(this).attr('data-href')).addClass('active');
	jQuery(jQuery(this).attr('data-href')).removeClass('fade');
	jQuery(this)
		.parent('li')
		.parent('ul')
		.children('li')
		.children('a')
		.removeClass('active');
	jQuery(this).addClass('active');
});

function handleSchoolProgramListsOptGroup() {
	var $cat = $('#category1');
	var $subcat = $('.subcat');

	var optgroups = {};

	$subcat.each(function (i, v) {
		var $e = $(v);
		var _id = $e.attr('id');
		optgroups[_id] = {};

		$e.find('optgroup').each(function () {
			var _r = $(this).data('rel');
			$(this).find('option').addClass('is-dyn');
			optgroups[_id][_r] = $(this).html();
		});
	});

	$subcat.find('optgroup').remove();

	var _lastRel;

	$cat.on('change', function () {
		var _rel = $(this).val();

		if (_lastRel === _rel) return true;
		_lastRel = _rel;

		$subcat.find('option').attr('style', '');
		$subcat.val('');
		$subcat.find('.is-dyn').remove();

		if (!_rel) return $subcat.prop('disabled', true);

		$subcat.each(function () {
			var $el = $(this);
			var _id = $el.attr('id');
			$el.append(optgroups[_id][_rel]);
		});

		$subcat.prop('disabled', false);
	});
}
