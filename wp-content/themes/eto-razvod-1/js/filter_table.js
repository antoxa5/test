$ = jQuery.noConflict();

function controlFromInput(fromSlider, fromInput, toInput, controlSlider) {
	const [from, to] = getParsed(fromInput, toInput);
	fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
	if (from > to) {
		fromSlider.value = to;
		fromInput.value = to;
	} else {
		fromSlider.value = from;
	}
}

function controlToInput(toSlider, fromInput, toInput, controlSlider) {
	const [from, to] = getParsed(fromInput, toInput);
	fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
	setToggleAccessible(toInput);
	if (from <= to) {
		toSlider.value = to;
		toInput.value = to;
	} else {
		toInput.value = from;
	}
}

function controlFromSlider(fromSlider, toSlider, fromInput) {
	const [from, to] = getParsed(fromSlider, toSlider);
	fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
	if (from > to) {
		fromSlider.value = to;
		fromInput.value = to;
	} else {
		fromInput.value = from;
	}
}

function controlToSlider(fromSlider, toSlider, toInput) {
	const [from, to] = getParsed(fromSlider, toSlider);
	fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
	setToggleAccessible(toSlider);
	if (from <= to) {
		toSlider.value = to;
		toInput.value = to;
	} else {
		toInput.value = from;
		toSlider.value = from;
	}
}

function getParsed(currentFrom, currentTo) {
	const from = parseInt(currentFrom.value, 10);
	const to = parseInt(currentTo.value, 10);
	return [from, to];
}

function fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
	const rangeDistance = to.max-to.min;
	const fromPosition = from.value - to.min;
	const toPosition = to.value - to.min;
	controlSlider.style.background = `linear-gradient(
      to right,
      ${sliderColor} 0%,
      ${sliderColor} ${(fromPosition)/(rangeDistance)*100}%,
      ${rangeColor} ${((fromPosition)/(rangeDistance))*100}%,
      ${rangeColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} 100%)`;
}

function setToggleAccessible(currentTarget) {
	const toSlider = document.querySelector('#toSlider');
	if (Number(currentTarget.value) <= 0 ) {
		toSlider.style.zIndex = 2;
	} else {
		toSlider.style.zIndex = 0;
	}
}





jQuery(document).ready(function($){

	//var current_query = JSON.parse(my_rating_addon.current_query);
	//alert(current_query);
	//if((c_post_id !== 0) && (c_post_id != null)) {
		//ajax_subscribe_block(my_ajax_object.current_post_id);
	//}

	if ($(".range_container")[0]){
		$('.range_container').each(function() {
			var container_id = $(this).attr('id');
			var target_field = $(this).closest('.filter_field').attr('data-target-field-name');
			var min = $('.rating_table').attr('dataglobal-'+target_field+'-min');
			var max = $('.rating_table').attr('dataglobal-'+target_field+'-max');
			if (typeof min !== 'undefined') {
				//alert('from '+min+' to '+max);
				$('#'+container_id+' #fromSlider').attr('min',min);
				$('#'+container_id+' #fromSlider').attr('value',min);
				$('#'+container_id+' #toSlider').attr('min',min);

				$('#'+container_id+' #fromInput').attr('min',min);
				$('#'+container_id+' #fromInput').attr('value',min);
				$('#'+container_id+' #toInput').attr('min',min);
			}
			if (typeof max !== 'undefined') {
				//alert('from '+min+' to '+max);
				$('#'+container_id+' #fromSlider').attr('max',max);
				$('#'+container_id+' #toSlider').attr('value',max);
				$('#'+container_id+' #toSlider').attr('max',max);

				$('#'+container_id+' #fromInput').attr('max',max);
				$('#'+container_id+' #toInput').attr('value',max);
				$('#'+container_id+' #toInput').attr('max',max);
			}

			const fromSlider = document.querySelector('#'+container_id+' #fromSlider');
			const toSlider = document.querySelector('#'+container_id+' #toSlider');
			const fromInput = document.querySelector('#'+container_id+' #fromInput');
			const toInput = document.querySelector('#'+container_id+' #toInput');
			fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
			setToggleAccessible(toSlider);

			fromSlider.oninput = () => controlFromSlider(fromSlider, toSlider, fromInput);
			toSlider.oninput = () => controlToSlider(fromSlider, toSlider, toInput);
			fromInput.oninput = () => controlFromInput(fromSlider, fromInput, toInput, toSlider);
			toInput.oninput = () => controlToInput(toSlider, fromInput, toInput, toSlider);
		});
	};





	$('body').on('submit', '.active_form#sa_rating_filter_form', function(e) {
		e.preventDefault();
	});

	$('body').on('submit', '.inactive_form#sa_rating_filter_form', function(e) {
		//alert('test');
		e.preventDefault();
		$('#sa_rating_filter_form .status_message').remove();
		var form = $(this);
		$(this).removeClass('inactive_form');
		$(this).addClass('active_form');
		$('.rating_container .wrap').empty();
		$('.rating_container .wrap').append('<div class="load_ajax"></div>');
		$.post(form.attr('action'), form.serialize(), function(data) {
			$('#sa_rating_filter_form .sa_rating_filter_reset').addClass('filtered');
			$('#sa_rating_filter_form').removeClass('active_form');
			$('#sa_rating_filter_form').addClass('inactive_form');
			$('.rating_container .wrap').empty();
			$('.rating_container .wrap').append(data);
			//alert(data);
		});
	});
	$('body').on('click', '.sa_rating_filter_open', function(){
		var container_id = $(this).closest('.sa_rating_filter').attr('id');
		$(this).addClass('sa_rating_filter_close');
		$(this).removeClass('sa_rating_filter_open');
		var new_text = $(this).attr('data-text-close');
		$(this).text(new_text);
		$('#'+container_id+' .form_show_hide').slideDown('slow');
		localStorage.removeItem("filter_close");
	});
	$('body').on('click', '.sa_rating_filter_close', function(){
		var container_id = $(this).closest('.sa_rating_filter').attr('id');
		$(this).addClass('sa_rating_filter_open');
		$(this).removeClass('sa_rating_filter_close');
		var new_text = $(this).attr('data-text-open');
		$(this).text(new_text);
		$('#'+container_id+' .form_show_hide').slideUp('slow');

		localStorage.setItem("filter_close", true);
	});
	if(localStorage.getItem("filter_close")) {
		//alert('filter_open');
		//$('#rating_fillter_container .sa_rating_filter_open').trigger("click");
		$("#rating_fillter_container .form_show_hide").ready(function() {
			//alert('ready form_show_hide');
			$('#rating_fillter_container .sa_rating_filter_close').trigger("click");
		});
	}
	$('body').on('click', '.sa_rating_filter_reset', function(){
		document.getElementById('sa_rating_filter_form').reset();
		if ($(".sa_rating_filter_reset").hasClass("filtered")) {
			location.reload();
		} else {
			if ($(".range_container")[0]){
				$('.range_container').each(function() {
					var container_id = $(this).attr('id');
					const fromSlider = document.querySelector('#'+container_id+' #fromSlider');
					const toSlider = document.querySelector('#'+container_id+' #toSlider');
					const fromInput = document.querySelector('#'+container_id+' #fromInput');
					const toInput = document.querySelector('#'+container_id+' #toInput');
					fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
					setToggleAccessible(toSlider);

					fromSlider.oninput = () => controlFromSlider(fromSlider, toSlider, fromInput);
					toSlider.oninput = () => controlToSlider(fromSlider, toSlider, toInput);
					fromInput.oninput = () => controlFromInput(fromSlider, fromInput, toInput, toSlider);
					toInput.oninput = () => controlToInput(toSlider, fromInput, toInput, toSlider);
				});
			};
		}
	});
});

