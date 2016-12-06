var LZW = {
    compress: function (uncompressed) {
        "use strict";
        var i,
            dictionary = {},
            c,
            wc,
            w = "",
            result = [],
            dictSize = 30000;
        for (i = 0; i < 30000; i += 1) {
            dictionary[String.fromCharCode(i)] = i;
        }
 
        for (i = 0; i < uncompressed.length; i += 1) {
            c = uncompressed.charAt(i);
            wc = w + c;
            if (dictionary.hasOwnProperty(wc)) {
                w = wc;
            } else {
                result.push(dictionary[w]);
                dictionary[wc] = dictSize++;
                w = String(c);
            }
        }
 
        if (w !== "") {
            result.push(dictionary[w]);
        }
        return bin2String(result);
    },
 
 
    decompress: function (compressedStr) {
        "use strict";
	var compressed = string2Bin(compressedStr);
        var i,
            dictionary = [],
            w,
            result,
            k,
            entry = "",
            dictSize = 30000;
        for (i = 0; i < 30000; i += 1) {
            dictionary[i] = String.fromCharCode(i);
        }
 
        w = String.fromCharCode(compressed[0]);
        result = w;
        for (i = 1; i < compressed.length; i += 1) {
            k = compressed[i];
            if (dictionary[k]) {
                entry = dictionary[k];
            } else {
                if (k === dictSize) {
                    entry = w + w.charAt(0);
                } else {
                    return null;
                }
            }
 
            result += entry;
 
            dictionary[dictSize++] = w + entry.charAt(0);
 
            w = entry;
        }
        return result;
    }
};

/*
 * Added by rbianchi
 */
function bin2String(array) {
  var result = "";
  for (var i = 0; i < array.length; i++) {
    result += String.fromCharCode(array[i]);
  }
  return result;
}

function string2Bin(str) {
  var result = [];
  for (var i = 0; i < str.length; i++) {
    result.push(str.charCodeAt(i));
  }
  return result;
}

