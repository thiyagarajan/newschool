        window.addEvent('domready', function () {
            // initialize Nivoo-Slider
			if ($('Slider')) new NivooSlider($('Slider'), {
				effect: 'random',
				interval: 5000,
				orientation: 'random'
			});
        }); 