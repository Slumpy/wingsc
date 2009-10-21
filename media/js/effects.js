$(document).ready(function()
{
	$('#portfolio #details .image .chooser a').each(function()
	{
		var self = $(this);

		// Image box, preloader, and source
		var box = $('#portfolio #details .image p');
		var pre = $('<div/>').css({ 'position': 'absolute', 'top': '-2000em' }).appendTo('body');
		var img = $('<img/>').attr({ src: self.attr('href'), alt: self.attr('title') }).appendTo(pre);

		self.click(function()
		{
			if (box.find('img').attr('src') == img.attr('src'))
			{
				// Image is already active
				return false;
			}

			// Slide the box off to the left
			box.stop().animate({ 'margin-left': -800 }, 200, function()
			{
				// Make the box the same height as the image
				box.animate({ height: img.attr('height') }, 50, function()
				{
					// Swap in the image and slide back
					box.html(pre.html()).animate({ 'margin-left': 0 }, 200);
				});
			});

			return false;
		});
	});

	$('#admin .message').each(function()
	{
		var self = $(this);

		self.animate({ backgroundColor: '#eeeeee' }, 2000, function()
		{
			self.slideUp(200, function()
			{
				self.remove();
			});
		});
	});
});
