$(document).ready(function () {
	//using tablesorter jquery plugins
	$("#myTable").tablesorter();

	//using jquery tabs
	$("#tabs").tabs();

});

function showEditor(editedObj) {
	$(editedObj).css("border","#CCC");
}

function saveDatabase(editedObj, column_name, row_id) {
	$.ajax({
		url: "updateDatabase.php",
		method: "POST",
		data: {
			column_name: column_name,
			editedValue: editedObj.innerHTML,
			row_id: row_id
		},
		success: function(data) {
			console.log('updated successfully');
		}
	});
}