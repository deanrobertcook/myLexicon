/**
 * 
 */

$(document).ready(function() {
	/**
	 * Function appends a new row to the bottom of the category table and fills each cell of the row
	 * with input fields for the user to add new information. It also changes to buttons in table console
	 * area so that user can proceed once they have finished writing a new term.
	 * @param categoryName needed in order to "load" the second level buttons.
	 */
	newRow = function(categoryName) {
		if ($("#newTerm").length == 0) {
			//Change the AddTerm button to Save Term and Cancel
			$("#newRowButton").replaceWith(
				"<button id='addTermButton' onclick='addTerm("+'"'+ categoryName +'"'+ ")'>Add Term</button>" + 
				"<button id='cancelButton' onclick='cancelAddTerm("+'"'+ categoryName +'"'+")'>Cancel</button>"
			);
			
			//Get the list of fields used in this table.
			var fields = findFields();
			
			//Append a new row
			$(".catTableDiv > table").append(
				"<tr id='newTerm'></tr>"
			);
			
			//Insert the appropriate number of cells with input boxes into the new row
			for (var i = 0; i < fields.length; i++) {
				$("#newTerm").append(
					"<td><input class='" + fields[i] + "' class='newTermInput' type='text'></td>"
				);
			}
		}
	};
	
	/**
	 * Based upon the headers on the category table, return the fields being displayed
	 * @returns {Array} the field types being displayed in the category table.
	 */
	findFields = function() {
		var fields = [];
		for (var i = 0; i < $("th").length-1; i++) {
			var headerClass = $($("th")[i]).attr("class");
			if (headerClass != "buttonColumn") {
				fields[i] = headerClass;
			}
		}
		return fields;
	};
	
	/**
	 * The Add Term button, which is displayed once the user clicks "Quick Add" proceeds with sending
	 * the newly typed up term to the server to be processed and saved as a new term. The category name
	 * is "loaded up" in the button before the user clicks it. This is needed to know where to save the 
	 * new term. Once clicked, the table is also reset with the new term appended to the bottom of the table.
	 * @param categoryName
	 */
	addTerm = function(categoryName) {
		var fields = findFields();
		var data = {
				"ajax" : true,
				"category" : categoryName,
		};
		var cells = [];
		for (var i = 0; i < fields.length; i++) {
			data[fields[i]] = $("td > ."+fields[i]).val();
			cells[i] = $("td > ."+fields[i]).val();
		}
		createNewRow(cells);
		cancelAddTerm(categoryName);
		
		$.ajax({
			url: "/myLexicon/addTerm/true",
			type: "POST",
			data : data,
			success: function (termId) {
				addButtonsToRow(termId);
			}
		});
	};
	
	/**
	 * Function createNewRow takes in an array of data and appends a new row to the table, filling
	 * out each cell with that data, in the order the array was filled.
	 */
	function createNewRow(cells) {
		var rowCount = $("tr").length-2;
		$("tbody").append("<tr class='latestRow' id='row"+rowCount+"'></tr>");
		
		for (var i = 0; i < cells.length; i++) {
			$("#row"+rowCount).append(
				"<td>" + cells[i] + "</td>"
			);
		}
	}
	
	/**
	 * Finally, add the two buttons back to the end of the row once we have received what the new termID
	 * is from the server (necessary to load up the Edit and Delete buttons).
	 */
	function addButtonsToRow(termId) {
		rowCount = $(".latestRow").attr("id").slice(3);
		console.log(rowCount);
		
		$(".latestRow").append(
			"<td class='buttonColumn'>" +
				"<button onclick='editTerm(" + rowCount + "," + termId + ")'>" +
					"<img width='20px' src='/myLexicon/resources/images/edit.png'>" +
				"</button>" +
				"<button onclick='deleteTerm(" + rowCount + "," + termId + ")'>" +
					"<img width='20px' src='/myLexicon/resources/images/delete.png'>" +
				"</button>" +
			"</td>"
		);
		
		$(".latestRow").removeAttr("class");
	}
	
	/**
	 * Cancel button resets the table, clearing the new row and returning buttons back to their original state.
	 * @param categoryName requires the name of the category to reload the "Quick Add" button
	 */
	cancelAddTerm = function(categoryName) {
		$("#addTermButton").replaceWith(
				"<button id='newRowButton' onclick='newRow("+ '"' + categoryName + '"' +  ")'>Quick Add</button>"
		);
		$("#cancelButton").remove();
		$("#newTerm").remove();
	};
	
	editTerm = function(rowCount, termId) {
		alert(termId);
	};
	
	/**
	 * deleteTerm sends an ajax request to the server to remove the selected Term. The function first confirms
	 * with the user before proceeded with the delete request. In the mean time, it removes the row from the 
	 * DOM so the user doesn't have to wait for the delete action to take place.
	 * @param rowCount the row that the term sits in
	 * @param termId
	 */
	deleteTerm = function(rowCount, termId) {
		var cont = confirm("Are you sure you want to delete this term?");
		if (cont) {
			$("#row"+rowCount).remove();
			$.ajax({
				url: "/myLexicon/editTerm/true",
				type: "POST",
				data: {
					"ajax" : true,
					"delete" : true,
					"termId" : termId,
				},
			});
		}
	};
});