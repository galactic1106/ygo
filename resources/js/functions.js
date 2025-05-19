function makeSearchList(data, cardShowUrl, imgUrl, searchResult) {
	data = data.data;
	$(searchResult).html('');
	try {
		data.slice(0, 10).forEach(function (item) {
			let div = $('<div>', {
				class: 'bg-primary-subtle border border-1 mb-1 border-primary d-flex flex-row p-0'

			});
			let link = $('<a>', {
				//href: '{{ route('card.show') }}' + item.id
				href: cardShowUrl + "\/" + item.id,
				class: 'd-flex row',
			});
			let img = $('<img>', {
				//src: '{{ route('api.image') }}?url=' + item.card_images[0].img_url_cropped
				src: imgUrl + '?url=' + item.card_images[0].image_url_cropped,
				class: 'col-3 p-0 border border-0 m-0',
				style: "aspect-ratio: 1 / 1; object-fit: cover;object-position: top;"
			});
			let span = $('<span>', {
				text: item.name,
				class: 'col-9 px-2 align-content-center justify-content-center text-truncate',
			});


			div.append([img, span]);
			link.append(div);
			$(searchResult).append(link);
		});
	} catch (error) { }
}

let timer = null;
function fuzzyFind(searchBar, searchResult, cardDataUrl, imgUrl, cardShowUrl) {

	$(searchBar).on('click input', function () {
		clearTimeout(timer);
		timer = setTimeout(() => {
			const url = cardDataUrl + '?fname=' + encodeURIComponent(searchBar.val());
			console.log('Request URL:', url);
			$.ajax({
				url: cardDataUrl,
				type: 'GET',
				dataType: 'json',
				data: { 'fname': searchBar.val() },
				success: function (data) {
					console.log(data)
					makeSearchList(data, cardShowUrl, imgUrl, searchResult);
				},
				error: function (error) {
					$(searchResult).html('');
					console.log(error)
				}
			});
		}, 500);
	});
}





function filterOffers(imageRadioSelector = 'input[name="selected_image"]', offersTableSelector = '#offers-table') {
	var imageNumber = $(imageRadioSelector + ':checked').data('image-number');
	$(offersTableSelector + ' tbody tr[data-image-number]').each(function () {
		if ($(this).data('image-number') == imageNumber) {
			$(this).show();
		} else {
			$(this).hide();
			// Uncheck radio if hidden
			$(this).find('input[type="radio"]').prop('checked', false);
		}
	});
}

function fetchOffers(cardId, callback) {
	$.getJSON('/api/offers', { card_id: cardId })
		.done(function (data) {
			callback(data);
		})
		.fail(function () {
			callback([]);
		});
}

function renderOffers(offers, imageNumber, offersTableSelector = '#offers-table') {
	let rows = '';
	let found = false;
	offers.forEach(function (offer) {
		if (offer.image_number == imageNumber) {
			found = true;
			rows += `<tr data-image-number="${offer.image_number}">
                <td>${offer.user ? offer.user.name : 'Unknown'}</td>
                <td>$${parseFloat(offer.price).toFixed(2)}</td>
                <td>${offer.card_quantity}</td>
                <td>
                    <input type="radio" name="offer_id" value="${offer.id}" required>
                </td>
            </tr>`;
		}
	});
	if (!found) {
		rows = `<tr>
            <td colspan="4" class="text-center text-muted">No offers available for this card.</td>
        </tr>`;
	}
	$(offersTableSelector + ' tbody').html(rows);
}

function setupOfferModal(cardId, imageRadioSelector = 'input[name="selected_image"]', offersTableSelector = '#offers-table') {
	function updateOffers() {
		let imageNumber = $(imageRadioSelector + ':checked').data('image-number');
		fetchOffers(cardId, function (offers) {
			renderOffers(offers, imageNumber, offersTableSelector);
		});
	}
	$(imageRadioSelector).on('change', function () {
		updateOffers();
	});
	updateOffers();
}


function loadQualities(selectSelector = '#sell-quality', qualitiesApiUrl = '/api/offers/qualities') {
	$.getJSON(qualitiesApiUrl, function (qualities) {
		var $select = $(selectSelector);
		$select.find('option:not([value=""])').remove();
		$.each(qualities, function (_, quality) {
			$select.append($('<option>', {
				value: quality,
				text: quality.charAt(0).toUpperCase() + quality.slice(1)
			}));
		});
	});
}

window.fuzzyFind = fuzzyFind;
window.filterOffers = filterOffers;
window.fetchOffers = fetchOffers;
window.renderOffers = renderOffers;
window.setupOfferModal = setupOfferModal;
window.loadQualities = loadQualities;
