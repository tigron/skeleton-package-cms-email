var utils  = new function() {

	this.pad = function(text, length, char, align) {
		char = this.def_value(char, " ");
		align = this.def_value(align, "l");
		var additional_chars = length - text.length;
		var result = "";
		switch (align) {
			case "r":
				result = this.repeat(char, additional_chars) + text;
				break;
			case "l":
				result = text + this.repeat(char, additional_chars);
				break;
			case "c":
				var left_spaces = Math.floor(additional_chars / 2);
				var right_spaces = additional_chars - left_spaces;
				result = this.repeat(char, left_spaces) + text + this.repeat(char,right_spaces);
				break;
		}
		return result;
	};

	this.repeat = function(str, num) {
		return new Array(num + 1).join(str);
	};

	this.def_value = function(value, default_value) {
		return (typeof value === "undefined") ? default_value : value;
	};

	this.render_table = function(data) {
		rows = data.split(/[\r\n]+/);
		if (rows[rows.length - 1] == "") {
			rows.pop();
		}

		var col_lengths = [];
		var is_number_col = [];
		$.each(rows, function(i, row) {
			var cols = row.split(/\t/);
			$.each(cols, function(j, col) {
				var is_new_col = col_lengths[j] == undefined;
				if (is_new_col) {
					is_number_col[j] = true;
				}
				// keep track of which columns are numbers only
				if ( i == 0 ) {
					; // a header is allowed to not be a number (exclude spreadsheet because the header hasn't been added yet
				} else if (is_number_col[j] && !col.match(/^(\s*-?\d+\s*|\s*)$/)) {
					is_number_col[j] = false;
				}
				if (is_new_col || col_lengths[j] < col.length) {
					col_lengths[j] = col.length;
				}
			});
		});

		var output = "";
		$.each(rows, function(i, row) {
			if ( i == 1) {
				output += '|';
				for (var j = 0; j < col_lengths.length; j++) {
					output += utils.repeat('-', col_lengths[j] + 2);
					output += '|';
				}
				output += "\n";
			}

			output += '|';
			var cols = rows[i].split(/\t/);
			for (var j = 0; j < col_lengths.length; j++) {
				var data = cols[j] || "";
				var align = "l";
				if ( i == 0) {
					align = "c";
				} else if (is_number_col[j]) {
					align = "r";
				}
				data = utils.pad(data, col_lengths[j], " ", align);
				output += " " + data + " " + '|';
			}
			output += "\n";
		});

		return output;
	};

}
