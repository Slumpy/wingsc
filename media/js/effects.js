$(document).ready(function()
{
	$('#projects .images').each(function()
	{
		// Find the fullsize container
		var fullsize = $('.full', this);
		var thumbs   = $('.thumbnails a', this);

		$('img', fullsize).load(function()
		{
			// Make sure the container has a height
			fullsize.height($(this).height());
		});

		thumbs.click(function()
		{
			var link = $(this);

			// This link is already active
			if (link.is('.active')) return false;

			// Make the current image partially transparent
			fullsize.addClass('loading').find('img').css('opacity', 0.33);

			// Create a preloader
			var preload = $('<div/>').css({ 'position': 'absolute', 'top': '-2000em' }).appendTo('body');

			// Create the new fullsize image
			var image = $('<img/>').load(function()
			{
				var self = $(this);

				// Change the currently active image
				thumbs.removeClass('active');
				link.addClass('active');

				// Do a slight pause here
				self.animate({ opacity: 0.33 }, 200, function()
				{
					fullsize.html('').stop().animate({ height: self.height() }, 250, function()
					{
						// Place the image into the fullsize container
						fullsize.removeClass('loading').append(self);

						// Make the image fully visible
						self.stop().animate({ opacity: 1 }, 100);

						// Delete the preloader
						preload.remove();
					});
				});
			}).attr(
			{
				'src': link.attr('href'),
				'alt': $('img', link).attr('alt')
			});

			// Add the image to the preloader
			preload.append(image);

			return false;
		});
	});
});
