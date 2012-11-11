/**
 * Countdown on a Twitter Bootstrap progress bar.
 * 
 * (C) 2012 David Madl <freeware@abanbytes.eu>
 */

(function ($) {
	/**
	 * from: Date
	 * target: Date
	 * days: string
	 * remaining: string
	 */
	$.fn.countdown = function (from, target, days, remaining) {
		function pad(num, size) {
			var s = num + '';
			while(s.length < size)
				s = '0' + s;
			return s;
		}

		function formatTimeDiffSeconds(diff) {
			delta = '';

			// seconds
			delta = pad(diff % 60, 2) + delta;
			diff = Math.floor(diff / 60);

			// minutes
			delta = pad(diff % 60, 2) + ':' + delta;
			diff = Math.floor(diff / 60);

			// hours
			delta = pad(diff % 24, 2) + ':' + delta;
			diff = Math.floor(diff / 24);

			if(diff > 0) {
				// days
				delta = diff + ' ' + days + ', ' + delta;
			}

			return delta;
		}

		function refreshCountdown() {
			curDate = new Date();
			diff = Math.floor((target - curDate) / 1000);
			if(diff < 0) {
				$('#voteButtonPanel').show();
				$('#countdownPanel').hide();
			} else {
				delta = formatTimeDiffSeconds(diff);

				dur = target - from;
				cur = target - curDate;
				perc = (cur * 100) / dur;
				$('#elapsed').css('width', (100 - perc).toFixed(2) + '%');
				$('#remaining').css('width', perc.toFixed(2) + '%');

				if(perc > 50) {
					$('#elapsed').html('');
					$('#remaining').html(delta + ' ' + remaining);
				} else {
					$('#elapsed').html(delta + ' ' + remaining);
					$('#remaining').html('');
				}
			}
		}

		setInterval(refreshCountdown, 1000);
	};
})(jQuery);
