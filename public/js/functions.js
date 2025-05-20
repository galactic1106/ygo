function makeSearchList(data, cardShowUrl, imgUrl, searchResult) {
	data = data.data;
	$(searchResult).html('');
	try {
		data.forEach(function (item) {
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
	} catch (error) {
		console.log('error in make search list');
		console.log(error);
	}
}

let timer = null;
function fuzzyFind(searchBar, cardDataUrl, callback) {
	clearTimeout(timer);
	timer = setTimeout(function () {
		const url = cardDataUrl + '?fname=' + encodeURIComponent(searchBar.val());
		console.log('Request URL:', url);
		$.ajax({
			url: cardDataUrl,
			type: 'GET',
			dataType: 'json',
			data: { 'fname': searchBar.val(), 'num': 10, 'offset': 0 },
			success: function (data) {
				console.log('in fuzzyfind');
				console.log(data);
				callback(data);

			},
			error: function (error) {
				console.log(error);
				callback([]);
			}
		});
	}, 1000);
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
	$.getJSON('/api/offers?cardId=' + cardId)
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
		if (offer.available_quantity > 0 && offer.image_number == imageNumber) {
			console.log(offer);
			found = true;
			rows += `<tr data-image-number="${offer.image_number}">
                <td>${offer.user.name}</td>
                <td>$${parseFloat(offer.price).toFixed(2)}</td>
                <td>${offer.available_quantity}</td>
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

function filterCards(searchUrl, fname, archetype, attribute, type, race, atk, def, level, num, offset, callback) {
	return $.ajax({
		url: searchUrl,
		type: 'GET',
		dataType: 'json',
		data: {
			fname: fname,
			archetype: archetype,
			attribute: attribute,
			type: type,
			race: race,
			atk: atk,
			def: def,
			level: level,
			num: num,
			offset: offset
		},
		success: function (data) {
			callback(data.data);
		},
		error: function (error) {
			console.log(error);
			callback([]);
		}
	})
}

function renderFilteredCards(data, cardContainer, imgEndpoint, cardShowUrl) {
	console.log('in renderFilteredCards');

	console.log(data);
	let html = '';
	if (!data || !data.length) {
		html = `<div class="col-12">
            <div class="alert alert-info mx-5 my-3">No cards found.</div>
        </div>`;
		$(cardContainer).html(html);
		return;
	}
	data.forEach(function (card) {
		let img = card.card_images[0].image_url;
		let imgSrc = imgEndpoint + '?url=' + encodeURIComponent(img);
		let cardUrl = cardShowUrl + "\/" + card.id;
		html += `<div class="col">
            <div class="card h-100 shadow-sm border border-1 border-light">
                <a href="${cardUrl}">
                    <img src="${imgSrc}" class="card-img-top" alt="${card.name}"
                        style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover; object-position: top;">
                </a>
                <div class="card-body">
                    <h5 class="card-title text-truncate" title="${card.name}">${card.name}</h5>
                    <ul class="list-group list-group-flush small">
						<li class="list-group-item px-0 py-1"><strong>Archetype:</strong> ${card.archetype}</li>
						<li class="list-group-item px-0 py-1"><strong>Attribute:</strong> ${card.attribute}</li>
						<li class="list-group-item px-0 py-1"><strong>Type:</strong> ${card.type}</li>
						<li class="list-group-item px-0 py-1"><strong>Race:</strong> ${card.race}</li>
						<li class="list-group-item px-0 py-1"><strong>ATK:</strong> ${card.atk}</li>
						<li class="list-group-item px-0 py-1"><strong>DEF:</strong> ${card.def}</li>
						<li class="list-group-item px-0 py-1"><strong>Level:</strong> ${card.level}</li>
					</ul>
                </div>
                <div class="card-footer text-end">
                    <a href="${cardUrl}" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>`;
	});
	$(cardContainer).html(html);
}
