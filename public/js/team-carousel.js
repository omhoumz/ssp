$(document).ready(function () {
	var count = $("#team-carousel > div.team-member").length;
	var nth = 1;
	var div = "";
	console.log(count);
	for (var i = count; i > 1; i--) {
		div = "#team-carousel > div.team-member-" + i;
		$(div).hide();
	}
	$(".team-chevron").on("click", function () {
		var arr = $(this).data("arr");
		div = "#team-carousel > div.team-member-" + nth;
		$(div).fadeOut(150);
		switch (arr) {
			case "right":
				if (nth == count) nth = 1; else nth++;
				break;
			case "left":
				if (nth == 1)  nth = count; else nth--;
				break;
		}
		div = "#team-carousel > div.team-member-" + nth;
		$(div).delay(150).fadeIn(800);
	});
	
});