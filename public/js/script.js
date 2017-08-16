$(document).ready(function () {

	$('input[name="tache_finance"]').change(function () {
		var v = $(this).val();
		if (v == 'finan'){
			$('.budget-tache').show();
		} else {
			$('.budget-tache').hide();
		} 
	});
	$('input[name="type_project"]').change(function () {
		var v = $(this).val();
		if (v == 'cadre'){
			$('.budget_cadre').hide();
		} else {
			$('.budget_cadre').show();
		} 
	});
	$('input[name="finance"]').change(function () {
		var v = $(this).val();
		if (v == 'NONFINANC'){
			$('.budget_specif').hide();
		} else {
			$('.budget_specif').show();
		} 
	});


	$('.modif_expert').on("click", function () {
		$('#notif_expert_modif').toggle();
		$('#expert_call').toggle();
		console.log("clicked");
	});

	$('.opts').on("click", function () {
		var optname = $(this).data("optname");
		var optname1 = ".opt-" + optname;
		$(optname1).toggle();
		var optname2 = ".user-form-" + optname;
		$(optname2).toggle();
	});

	$('.maj-coord').on("click", function () {
		var coord = $(this).data("comite");
		var cname = '.maj-coord-' + coord;
		console.log(coord + " " + cname);
		$(cname).toggle();
	});
	
});