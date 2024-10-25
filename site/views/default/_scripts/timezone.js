// script by Josh Fraser (http://www.onlineaspect.com)

function convert(value, separator) {
	if (!separator) { var separator = ":"; }
	
	var hours = parseInt(value);

	value -= parseInt(value);
	value *= 60;
	
	var mins = parseInt(value);
	value -= parseInt(value);
	value *= 60;

	var secs = parseInt(value);
	var display_hours = hours;

//	display_hours = (hours < 10 && hours > 0) ? "+0" + hours : "+" + hours; 	// positive
//	display_hours = (hours == 0) ? "0" + hours : display_hours; 							// handle GMT case (00:00)
//	display_hours = (hours < 0 && hours > -10) ? "-0" + Math.abs(hours) : display_hours; // neg

	mins = (mins < 10) ? "0" + mins : mins;

	return display_hours + separator + mins; 
}

function calculate_time_zone(separator) 
{
	if (!separator) { var separator = ":"; }

	var rightNow = new Date();
	
	var jan1 = new Date(rightNow.getFullYear(), 0, 1, 0, 0, 0, 0);  // jan 1st
	var june1 = new Date(rightNow.getFullYear(), 6, 1, 0, 0, 0, 0); // june 1st
	
	var temp = jan1.toGMTString();
	
	var jan2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	temp = june1.toGMTString();
	var june2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	
	var std_time_offset = (jan1 - jan2) / (1000 * 60 * 60);
	var daylight_time_offset = (june1 - june2) / (1000 * 60 * 60);
	var dst;
	
	if (std_time_offset == daylight_time_offset) {
		dst = "0"; // daylight savings time is NOT observed
	} else {
		// positive is southern, negative is northern hemisphere
		var hemisphere = std_time_offset - daylight_time_offset;
		if (hemisphere >= 0) {
			std_time_offset = daylight_time_offset;
		}
		dst = "1"; // daylight savings time is observed
	}

	return dst + "|" + convert(std_time_offset, separator);
}

//onload = calculate_time_zone;