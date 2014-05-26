/*! Written by lukegb. See https://github.com/lukegb/mcassoc.php */
// Modifications:
// 26/05/14 - lol768: Add colour support.
var MCAssoc = (function() {
    var MCAssoc = {
        baseurl: 'https://mcassoc.lukegb.com/'
    };

    var iframe;

    MCAssoc.init = function(siteid, key, postback, mcusername, colours) {
        iframe = document.getElementById('mcassoc');

        // mcusername is optional
        mcusername = mcusername || null;

        // formulate the URL:
        this.url = this.baseurl + 'perform?';

        var pieces = {
            siteid: siteid,
            key: key,
            postback: postback,
            mcusername: mcusername
        };
        if (colours != null) {
            pieces['c:bdr:b'] = colours.borderBg;
            pieces['c:bdr:t'] = colours.borderFg;
            pieces['c:box:b'] = colours.boxBg;
            pieces['c:box:t'] = colours.boxFg;
            pieces['c:mn:b'] = colours.contentBg;
            pieces['c:mn:t'] = colours.contentFg;
        }
        var qs = '';
        for (var piecen in pieces) {
            if (!pieces.hasOwnProperty(piecen)) continue;
            var piecev = pieces[piecen];
            if (piecev) {
                if (qs != '') qs += '&';
                qs += encodeURIComponent(piecen) + '=' + encodeURIComponent(piecev);
            }
        }

        this.url += qs;

        iframe.src = this.url;
    };

    return MCAssoc;
})();