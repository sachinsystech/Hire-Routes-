function ucfirst(str) {
	var f = str.charAt(0).toUpperCase();
	return f + str.substr(1);
}

function number_format(pnumber,decimals){
	    if (isNaN(pnumber)) { return 0};
	    if (pnumber=='') { return 0};
	    var snum = new String(pnumber);
	    var sec = snum.split('.');
	    var whole = parseFloat(sec[0]);
	    var result = '';
	    if(sec.length > 1){
	        var dec = new String(sec[1]);
	        dec = String(parseFloat(sec[1])/Math.pow(10,(dec.length - decimals)));
	        dec = String(whole + Math.round(parseFloat(dec))/Math.pow(10,decimals));
	        var dot = dec.indexOf('.');
	        if(dot == -1){
	            dec += '.';
	            dot = dec.indexOf('.');
	        }
	        while(dec.length <= dot + decimals) { dec += '0'; }
	        result = dec;
	    } else{
	        var dot;
	        var dec = new String(whole);
	        dec += '.';
	        dot = dec.indexOf('.');
	        while(dec.length <= dot + decimals) { dec += '0'; }
	        result = dec;
	    }
	    return result;
	}

