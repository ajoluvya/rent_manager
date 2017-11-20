$(document).ready(function () {
	$("#estate_id").change(function()
	{
		if ($(this).data('options') == undefined) {
			$(this).data('options', $('#house_id option').clone());
		}
		var estate_id = $(this).val();
		var options = $(this).data('options').filter('[estate_id=' + estate_id + ']');
		$('#house_id').html(options);
	});
	
	//each house has a default price so it should be reflected in the amount field whenever the selection changes
	$("#house_id").change(function()
	{
		var rent_rate = $('option:selected', this).attr("rent_rate");
		$('#rent_rate').val(rent_rate);
	});
});

function confirm_delete(delValue)
{
	var really=confirm("Do you really want to delete " + delValue + "?");
	return really;
}