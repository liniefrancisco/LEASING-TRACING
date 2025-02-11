//JQUERY PLUGIN
(function ( $ ) {
  	$.fn.serializeObject = function() {

		var data = {};
		$(this).serializeArray().forEach(function(fd, key){
			data[fd.name] = fd.value;
		})  	
	    return data;
	};


}( jQuery ));

window.$ = jQuery;

window.$post = function(obj){
	return new Promise((resolve, reject) => {
        $.post(obj).done((result)=>{
        	resolve(result);
        });
    });
}

window.toKebabCase = str => str && str.match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g).map(x => x.toLowerCase()).join('-');

window.arraysMatch = function (arr1, arr2) {

	if (!arr1 || !arr2) {
		console.log("nm 1");
		return false;
	} 

	// Check if the arrays are the same length
	if (arr1.length !== arr2.length) {
		console.log("nm 2");
		return false;
	}

	// Check if all items exist and are in the same order
	for (var i = 0; i < arr1.length; i++) {
		if (arr1[i] !== arr2[i]){
			console.log("nm 3");
			return false;
		} 
	}

	// Otherwise, return true
	return true;

};



window.isEqual = function (value, other) {

	// Get the value type
	var type = Object.prototype.toString.call(value);

	// If the two objects are not the same type, return false
	if (type !== Object.prototype.toString.call(other)) return false;

	// If items are not an object or array, return false
	if (['[object Array]', '[object Object]'].indexOf(type) < 0) return false;

	// Compare the length of the length of the two items
	var valueLen = type === '[object Array]' ? value.length : Object.keys(value).length;
	var otherLen = type === '[object Array]' ? other.length : Object.keys(other).length;
	if (valueLen !== otherLen) return false;

	// Compare two items
	var compare = function (item1, item2) {

		// Get the object type
		var itemType = Object.prototype.toString.call(item1);

		// If an object or array, compare recursively
		if (['[object Array]', '[object Object]'].indexOf(itemType) >= 0) {
			if (!isEqual(item1, item2)) return false;
		}

		// Otherwise, do a simple comparison
		else {

			// If the two items are not the same type, return false
			if (itemType !== Object.prototype.toString.call(item2)) return false;

			// Else if it's a function, convert to a string and compare
			// Otherwise, just compare
			if (itemType === '[object Function]') {
				if (item1.toString() !== item2.toString()) return false;
			} else {
				if (item1 !== item2) return false;
			}

		}
	};

	// Compare properties
	if (type === '[object Array]') {
		for (var i = 0; i < valueLen; i++) {
			if (compare(value[i], other[i]) === false) return false;
		}
	} else {
		for (var key in value) {
			if (value.hasOwnProperty(key)) {
				if (compare(value[key], other[key]) === false) return false;
			}
		}
	}

	// If nothing failed, return true
	return true;

};

window.groupBy = function(xs, key) {
  return xs.reduce(function(rv, x) {
    (rv[x[key]] = rv[x[key]] || []).push(x);
    return rv;
  }, {});
};

window.mergeArrayValues = function(arr) {
	var merged = [];

	if(typeof arr == 'object'){
		arr = Object.values(arr);
	}

	arr.forEach((r)=>{
		 merged = merged.concat(r);
	})

	return merged;
}





