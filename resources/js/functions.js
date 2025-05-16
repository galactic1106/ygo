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
		}, 750);
	});
}

// Make available globally
window.fuzzyFind = fuzzyFind;
