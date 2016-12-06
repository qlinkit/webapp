/*
MIT License
Copyright (c) 2016 Lucas Mingarro, Ricardo Bianchi, Ezequiel Alvarez, César Miquel
https://opensource.org/licenses/MIT
*/

var JsonFormatter = {
    stringify: function (a) {
        var b = {
            ct: a.ciphertext.toString(CryptoJS.enc.Base64)
        };
        if (a.iv) {
            b.iv = a.iv.toString()
        }
        if (a.salt) {
            b.s = a.salt.toString()
        }
        return JSON.stringify(b)
    },
    parse: function (a) {
        var c = JSON.parse(a);
        var b = CryptoJS.lib.CipherParams.create({
            ciphertext: CryptoJS.enc.Base64.parse(c.ct)
        });
        if (c.iv) {
            b.iv = CryptoJS.enc.Hex.parse(c.iv)
        }
        if (c.s) {
            b.salt = CryptoJS.enc.Hex.parse(c.s)
        }
        return b
    }
};
var qrConfig = {
    width: 110,
    height: 110,
    colorDark : "#f3f3f3",
    colorLight : "#191919",
    correctLevel : QRCode.CorrectLevel.H
};
var flash_active = false;
var is_mobile_or_tablet = false;
var is_ipad_type = false;
var password = null;
var minPasswordLength = 25;
var maxPasswordLength = 30;
var fwLimit = 5;
var trkLength = 10;
var localeCode;
var localeMessages;
var wsh = "";
var dencFiles = [];
var totalIndex = 0;
var encFiles = [];
var namesFiles = [];
var sha256 = null;
$(document).ready(function () {
    init()
});

var rawData = "";
var points = 0;
var strongPoints = 1000;
var entropy = 0;
var minX = 999999;
var maxX = -999999;
var sminX = 999999;
var smaxX = -999999;
var sizeX = window.screen.width;
var minY = 9999999;
var maxY = -9999999;
var sminY = 9999999;
var smaxY = -9999999;
var rangeX = 0;
var rangeY = 0;
var sizeY = window.screen.height;

$(document).bind( "mobileinit", function(event) {
    $.extend($.mobile.zoom, {locked:true,enabled:false});
});

function init() {
    var a = Math.floor(Math.random() * 10);
    $("body").addClass("bg" + a);
    $("#new-qlink-button-container-mobile-container").hide();
    if (!(window.File && window.FileReader && window.FileList && window.Blob)) {
        $(".file-input-wrapper").hide();
        $("#files").hide()
    }
    sha256 = CryptoJS.algo.SHA256.create();
    var c = CryptoJS.lib.WordArray.random(128);
    var x = $("#x_token");
    var y = $('[name="_token"]');
    var b = (new Date().getTime()).toString() + c + x.val() + y.val();
    sha256.update(b);
    rawData = b;
    $("#qlink_textarea").click(function (d) {
        document.body.scrollTop = document.documentElement.scrollTop = 0;
    });
    $("#qlink_textarea").keypress(function (d) {
        if (Math.floor((Math.random() * 10) + 1) <= 3) {
            var c = CryptoJS.lib.WordArray.random(128);
            sha256.update((new Date().getTime()).toString() * d.timeStamp + d.keyCode.toString())
            rawData = rawData + (new Date().getTime()).toString() * d.timeStamp + c + d.keyCode.toString();
            updateStrengthBar(10000, 10000);
        }
    });
    $("#qlink_textarea").bind("vmousemove", function (d) {
        if ( d.pageX < minX )
            minX = d.pageX;

        if ( d.pageX > maxX )
            maxX = d.pageX;

        if ( d.pageY < minY )
            minY = d.pageY;

        if ( d.pageY > maxY )
            maxY = d.pageY;

        var c = CryptoJS.lib.WordArray.random(128);
        sha256.update((new Date().getTime()).toString() + c + d.pageX + d.pageY)
        rawData = rawData + (new Date().getTime()).toString() + c + d.clientX * d.timeStamp + d.clientY * d.timeStamp;

        if ( smaxX - sminX > maxX - minX )
        {
            rangeX = smaxX - sminX;
        } else {
            rangeX = maxX - minX;
        }

        if ( smaxY - sminY > maxY - minY )
        {
            rangeY = smaxY - sminY;
        } else {
            rangeY = maxY - minY;
        }

        updateStrengthBar(rangeX, rangeY);
    });

    $( window ).scroll(function( d ) {
        if ( d.target.scrollX < sminX )
            sminX = d.target.scrollX;

        if ( d.target.scrollX > smaxX )
            smaxX = d.target.scrollX;

        if ( d.target.scrollY < sminY )
            sminY = d.target.scrollY;

        if ( d.target.scrollY > smaxY )
            smaxY = d.target.scrollY;

        var c = CryptoJS.lib.WordArray.random(128);
        sha256.update((new Date().getTime()).toString() + c + d.target.scrollX + d.target.scrollY)
        rawData = rawData + (new Date().getTime()).toString() + c + d.target.scrollX * d.timeStamp + d.target.scrollY * d.timeStamp;

        if ( smaxX - sminX > maxX - minX )
        {
            rangeX = smaxX - sminX;
        } else {
            rangeX = maxX - minX;
        }

        if ( smaxY - sminY > maxY - minY )
        {
            rangeY = smaxY - sminY;
        } else {
            rangeY = maxY - minY;
        }

        updateStrengthBar(rangeX, rangeY);
    });

    $("body").bind("vmousemove", function (d) {
        if ( d.pageX < minX )
            minX = d.pageX;

        if ( d.pageX > maxX )
            maxX = d.pageX;

        if ( d.pageY < minY )
            minY = d.pageY;

        if ( d.pageY > maxY )
            maxY = d.pageY;

        var c = CryptoJS.lib.WordArray.random(128);
        sha256.update((new Date().getTime()).toString() + c + d.pageX + d.pageY)
        rawData = rawData + (new Date().getTime()).toString() + c + d.pageX * d.timeStamp + d.pageY * d.timeStamp;

        if ( smaxX - sminX > maxX - minX )
        {
            rangeX = smaxX - sminX;
        } else {
            rangeX = maxX - minX;
        }

        if ( smaxY - sminY > maxY - minY )
        {
            rangeY = smaxY - sminY;
        } else {
            rangeY = maxY - minY;
        }

        updateStrengthBar(rangeX, rangeY);
    });
    $("body").bind("tap", function (d) {
        if ( d.pageX < minX )
            minX = d.pageX;

        if ( d.pageX > maxX )
            maxX = d.pageX;

        if ( d.pageY < minY )
            minY = d.pageY;

        if ( d.pageY > maxY )
            maxY = d.pageY;

        var c = CryptoJS.lib.WordArray.random(128);
        sha256.update((new Date().getTime()).toString() + c + d.pageX + d.pageY)
        rawData = rawData + (new Date().getTime()).toString() + c + d.pageX * d.timeStamp + d.pageY * d.timeStamp;

        if ( smaxX - sminX > maxX - minX )
        {
            rangeX = smaxX - sminX;
        } else {
            rangeX = maxX - minX;
        }

        if ( smaxY - sminY > maxY - minY )
        {
            rangeY = smaxY - sminY;
        } else {
            rangeY = maxY - minY;
        }

        updateStrengthBar(rangeX, rangeY);
    });

    var display_viewer = false;
    $('#toggle_entropy_viewer').click(function (d) {
        if ( display_viewer ) {
            $('#entropy-viewer').toggle(false);
            display_viewer = false;
        } else {
            $('#entropy-viewer').toggle(true);
            display_viewer = true;
        }
    });
    $("#new-qlink-button-container").hide();
    $("#get-track").hide();
    $("#hash_result").hide();
    $("#sharing-container").hide();
    $(".alert-success").hide();
    $("[placeholder]").togglePlaceholder();
    flash_active = ((typeof navigator.plugins != "undefined" && typeof navigator.plugins["Shockwave Flash"] == "object") || (window.ActiveXObject && (new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) != false));
    if (flash_active == true || flash_active == "true") {
        $("body").on("copy", "#zclip", function (d) {
            $("#share-menu").hide();
            d.clipboardData.clearData();
            d.clipboardData.setData("text/plain", $("#hash_result_text").val());
            d.preventDefault()
        })
    } else {
        $("#zclip").hide()
    }
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        is_mobile_or_tablet = true
    }
    if (/iPad|iPod/i.test(navigator.userAgent)) {
        is_ipad_type = true
    }
    $("#qlink_textarea").on("input", function () {
        var d = parseInt($("#qlink_textarea").val().length);
        $(".leters-counter").html(2000 - d)
    });
    $("#qlink_textarea").on("keydown", function () {
        var d = parseInt($("#qlink_textarea").val().length);
        $(".leters-counter").html(2000 - d)
    });
    $("#trk").on("input", function () {
        trkCount("#trk")
    });
    $("#trk").on("keydown", function (d) {
        trkCount("#trk");
        trkStatus(d, "#trk", "#trk-status")
    });
    $("#trk2").on("input", function () {
        trkCount("#trk2")
    });
    $("#trk2").on("keydown", function (d) {
        trkCount("#trk2");
        trkStatus(d, "#trk2", "#trk-status2")
    });
    $("#trk-update").click(function (d) {
        d.which = 13;
        trkCount("#trk");
        trkStatus(d, "#trk", "#trk-status")
    });
    $("#trk-update2").click(function (d) {
        d.which = 13;
        trkCount("#trk2");
        trkStatus(d, "#trk2", "#trk-status2")
    })
}
function trkCount(a) {
    var b = parseInt($(a).val().length);
    if (b > trkLength) {
        $(a).val($(a).val().substring(0, trkLength))
    }
}
function trkStatus(c, b, e) {
    var d = parseInt($(b).val().length);
    if (c.which == 13 && d < trkLength) {
        c.preventDefault()
    }
    $(e).html("");
    if (c.which == 13 && d == trkLength) {
        var a = "/gtrkstatus";
        $.ajax({
            type: "post",
            dataType: "json",
            url: a,
            data: {
                trk: $(b).val()
            },
            success: function (f) {
                if (f.status == "OK") {
                    if (f.trkStatus == 0) {
                        $(e).html(localeMessages.trk_unread)
                    } else {
                        if (f.trkStatus == 1) {
                            $(e).html(localeMessages.trk_read)
                        } else {
                            $(e).html(localeMessages.trk_no_track)
                        }
                    }
                } else {
                    $(e).html(localeMessages.trk_no_track)
                }
            },
            error: function () {},
            beforeSend: function () {}
        }).done(function (f) {})
    }
}

function updateStrengthBar(rangeX, rangeY) {

    if ( points <= strongPoints ) {
        points++;
    }

    if ( rangeX < 800 && rangeY < 800 && points > 700 )
    {
        points = 700;
    }
    if ( rangeX < 600 && rangeY < 600 && points > 400 )
    {
        points = 400;
    }
    if ( rangeX < 200 && rangeY < 200 && points > 150 )
    {
        points = 150;
    }
    if ( rangeX < 100 && rangeY < 100 && points > 60 )
    {
        points = 60;  
    }

    entropy = points * 100 / strongPoints;
    entropy = entropy * 70 / 100;
    if ( entropy > 70 )
        entropy = 70;

    var green = Math.round(255 * entropy / 100);
    var red = Math.round(255 - green);

    if ( points <= 60 )
        $('#strength-label').html(localeMessages.WEAK);

    if ( points > 60 && points <= 150 )
        $('#strength-label').html(localeMessages.GOOD);

    if ( points > 150 && points <= 400 )
        $('#strength-label').html(localeMessages.STRONG);

    if ( points > 400 && points <= 700 )
        $('#strength-label').html(localeMessages.VERY_STRONG);

    if ( points > 700 )
        $('#strength-label').html(localeMessages.EXTREMELY_STRONG);

    $('#entropy-viewer').html("....." + rawData.substring(rawData.length - 300, rawData.length));
    $('#entropy-bar').css('width', entropy + '%');
}

function makeId() {
    password = "";
    sha256.update((new Date().getTime()).toString());
    rawData = rawData + (new Date().getTime()).toString();
    var b = sha256.finalize();

    var c = CryptoJS.lib.WordArray.random(32);
    var half = Math.round(rawData.length / 2);
    var x = CryptoJS.PBKDF2((new Date().getTime()).toString() + b.toString() + rawData.substring(0, half), c + rawData.substring(half + 1, rawData.length), {
        keySize: 256 / 32, iterations: 2000
    });

    var a = Math.floor(Math.random() * (maxPasswordLength - minPasswordLength + 1)) + minPasswordLength;
    password = x.toString(CryptoJS.enc.Base64).substring(0, a)
    password = password.replace("+", "");
    password = password.replace("+", "");
}

function createQlink() {
    if ( points <= 20 ) {
        $(".qlink-inner").block({
            message: $("#question-entropy"),
            css: {
                width: "275px"
            }
        });
        $("#ok-entropy").click(function () {
            $(".qlink-inner").unblock();
            return false;
        });
        return;
    }
    $('#li-entropy-container').hide();
    document.body.scrollTop = document.documentElement.scrollTop = 0;

    $(".qlink-msj").block({
        message: "<div class='circles-loader'></div> <div>" + "&#9817;&#9812;&#9817;" + "</div>",
        css: {
            border: "none",
            padding: "10px",
            showOverlay: false,
            backgroundColor: "#fff",
            "-webkit-border-radius": "0px",
            "-moz-border-radius": "0px",
            opacity: 1,
            color: "#000"
        },
        overlayCSS: {
            backgroundColor: "none"
        }
    });
    if (doesConnectionExist() == false) {
        $(".qlink-msj").unblock();
        $(".qlink-msj").block({
            message: $("#question"),
            css: {
                width: "275px"
            }
        });
        $("#yes").click(function () {
            createQlink()
        });
        $("#no").click(function () {
            $(".qlink-msj").unblock();
            return false;
        });
        return;
    }
    $(".qlink-msj").unblock();
    $(".qlink-msj").block({
        message: "<div class='circles-loader'></div> <div>" + localeMessages.st_encrypting + "</div>",
        css: {
            border: "none",
            padding: "10px",
            showOverlay: false,
            backgroundColor: "#fff",
            "-webkit-border-radius": "0px",
            "-moz-border-radius": "0px",
            opacity: 1,
            color: "#000"
        },
        overlayCSS: {
            backgroundColor: "none"
        }
    });
    sleep(1000, doCreateQlink, null)
}
var generatingQlink = false;
var reintent = false;
var readingQlink = false;
var replyIntent = "false";

function doCreateQlink() {
    if (generatingQlink == true) {
        return
    }
    generatingQlink = true;
    var a = "/inject";
    var c = $("#qlink_textarea");
    var d = new Date();
    var m = d.getTime();
    var b = d.getTimezoneOffset();
    var h = $("#x_token");
    makeId();
    if (reintent == false) {
        for (var j = 0, k; k = encFiles[j]; j++) {
            encFiles[j] = aesEncrypt(encFiles[j])
        }
    }
    var g = false;
    var e = document.getElementById("imprint");
    var r = document.getElementById("captcha");
    var l = lastQl + "%%A%%" + c.val() + "%%C%%";
    if (g) {
        l = aesEncrypt(LZW.compress(filterXSS(escapeHtmlEntities(l)))); 
        l.decom = "true"
    } else {
        l = aesEncrypt(filterXSS(escapeHtmlEntities(l))); 
        l.decom = "false"
    }
    l = JSON.stringify(l);
    $.ajax({
        type: "post",
        dataType: "json",
        url: a,
        data: {
            files: encFiles,
            namesFiles: namesFiles,
            msg: l,
            imprint: e.checked,
            captcha: r.checked,
            randomHash: m,
            from: "web_app",
            x_token: h.val(),
            lang: localeCode,
            replyIntent: replyIntent,
            n: b
        },
        success: function (i) {
            generatingQlink = false;
            reintent = false;
            if (i.status == "OK") {
                $('#major-text').html(localeMessages.share_it_trans);
                $('#read-title').show();
                var f = i.hash;
                var n = f + "#" + password;
                $("#hash_result_text").val(n);
                $("#quick_warning_message").hide();
                $("#expire_date").html(i.expireDate);
                $("#trk2").val(i.tn.split(" ")[1]);
                $("#trkspan").html(i.tn.split(" ")[1]);

                $("#tnlk").html(i.tnlk);
                $("#tnlk").attr("href", i.tnlk);
                $("#hash_result_text").on("keydown", function (o) {
                    if (o.metaKey == true || o.ctrlKey || o.shiftKey) {
                        return
                    }
                    $("#hash_result_text").val(n)
                });
                $("#hash_result_text").on("input", function () {
                    $("#hash_result_text").val(n)
                });
                $("#hash_result").show();
                $("#hash_result_text").val(n).focus().select();
                $(".quick_success_message").show();
                $("#qlink_textarea_form").remove();
                $("#qlink_textarea").remove();
                $("#qlink-button-container").remove();
                $(".chk_imprint").remove();
                $("#new-qlink-button-container").show();
                $("#get-track").show();
                $("#form-files").hide();
                wsh = f + "%23" + password;
                if (is_mobile_or_tablet && !is_ipad_type) {
                    $("#ws-share").attr("href", "whatsapp://send?text=go secure: " + wsh);
                    $("#sharing-container").show()
                }
                $("#tw-share").attr("href", "https://twitter.com/intent/tweet?url=&text=go secure: " + wsh.replace(/\+/g, "%2B"));
                c.val();
                $("#new-qlink-button-container-mobile-container").show();
                $("#header").hide();

                $(".marketing-place-container").show();
                if (!is_mobile_or_tablet)
                {
                    qrConfig.text = "go secure: " + n;
                    var qrcode = new QRCode(document.getElementById("qr-code-scan"), qrConfig);
                }
                document.body.scrollTop = document.documentElement.scrollTop = 0;
            } else {
                reintent = true;
                generatingQlink = false;
                $(".qlink-msj").unblock();
                $(".qlink-msj").block({
                    message: $("#ajax-error"),
                    css: {
                        width: "275px"
                    }
                });
                $("#ok").click(function () {
                    reintent = true;
                    generatingQlink = false;
                    $(".qlink-msj").unblock();
                });
                return;
            }
        },
        error: function () {
            reintent = true;
            generatingQlink = false;
            $(".qlink-msj").unblock();
            $(".qlink-msj").block({
                message: $("#ajax-error"),
                css: {
                    width: "275px"
                }
            });
            $("#ok").click(function () {
                reintent = true;
                generatingQlink = false;
                $(".qlink-msj").unblock();
            });
            return;
        },
        beforeSend: function () {
            $(".qlink-msj").block({
                message: "<div class='circles-loader'></div> <div>" + localeMessages.st_generating + "</div>",
                css: {
                    border: "none",
                    padding: "10px",
                    showOverlay: false,
                    backgroundColor: "#fff",
                    "-webkit-border-radius": "0px",
                    "-moz-border-radius": "0px",
                    opacity: 1,
                    color: "#000"
                },
                overlayCSS: {
                    backgroundColor: "none"
                }
            })
        }
    }).done(function (f) {
        reintent = false;
        generatingQlink = false;

        if (f.status != "OK") {
            $(".qlink-msj").unblock();
        } else {
            $('#step-number').html("2");
            $('#step-text').html(localeMessages.tip_text_share);

        }
    })
}
function sendQlink() {
    var a = localeMessages.share_email_subject;
    window.location = "mailto:?subject=" + a + "&body=go secure: " + wsh
}
function readQlink(b, a) {
    servDo = b;
    hashDo = a;
    $(".qlink-read").block({
        message: "<div class='circles-loader'></div> <div>" + localeMessages.st_loading + "</div>",
        css: {
            border: "none",
            padding: "10px",
            showOverlay: false,
            backgroundColor: "#fff",
            "-webkit-border-radius": "0px",
            "-moz-border-radius": "0px",
            opacity: 1,
            color: "#000"
        },
        overlayCSS: {
            backgroundColor: "none"
        }
    });
    sleep(1000, doReadQlink, null)
}
var servDo;
var hashDo;

function validHash(a) {
    var b = /^[a-zA-Z0-9+/]+={0,2}$/;
    return b.test(a)
}
function doReadQlink() {
    if (!validHash(location.hash.substring(1))) {
        $("#container-read").remove();
        $('.copyright').hide();
        $("#invalid").show();
        return
    }
    var a = filterXSS(location.hash);
    password = a.substring(1);
    var c = "/readmessage";
    var b = new Date().getTime();
    if (readingQlink == true) {
        return
    }
    readingQlink = true;
    $.ajax({
        type: "post",
        dataType: "json",
        url: c,
        data: {
            from: "web_app",
            hash: hashDo,
            servnum: servDo,
            randomHash: b
        },
        success: function (f) {
            readingQlink = false;
            if (f.status == "OK") {
                $("#result_container_area").html(f.data);
                var d = $("#links-area");
                var e = 0;
                if (f.noMore == true) {
                    $(".hash_result_area").html(f.message);
                    $("#reply-qlink-button").hide();
                    $("#forward-qlink-button").hide();
                    $("#forward-qlink-button-help").hide();
                    $("#new-qlink-button").show();
                    $("#quick_help_message").hide();
                    $("#imprint_data").hide();
                    d.hide();
                    finishDecrypt(f)
                } else {
                    $("#reply-qlink-button").show();
                    $("#forward-qlink-button").show();
                    $("#forward-qlink-button-help").show();
                    $("#new-qlink-button").hide();
                    $("#quick_help_message").show();
                    e = 1000;
                    $(".qlink-read").block({
                        message: "<div class='circles-loader'></div> <div>" + localeMessages.st_decrypting + "</div>",
                        css: {
                            border: "none",
                            padding: "10px",
                            showOverlay: false,
                            backgroundColor: "#fff",
                            "-webkit-border-radius": "0px",
                            "-moz-border-radius": "0px",
                            opacity: 1,
                            color: "#000"
                        },
                        overlayCSS: {
                            backgroundColor: "none"
                        }
                    });
                    sleep(e, doDecrypt, f)
                }
            }
        },
        error: function () {
            readingQlink = false;
            $(".qlink-read").unblock();
            $(".qlink-read").block({
                message: $("#ajax-error"),
                css: {
                    width: "275px"
                }
            });
            $("#ok").click(function () {
                readingQlink = false;
                $(".qlink-read").unblock()
            });
            return
        },
        beforeSend: function () {}
    }).done(function (d) {
        readingQlink = false
    });
    servDo = null;
    hashDo = null
}
function finishDecrypt(f) {
    var a = f.encFiles;
    var b = f.namesFiles;
    var d = $("#links-area");
    if (a == null || a.length == 0) {
        d.hide();
        $(".attach-file").hide();
        $(".mjs-attach-files").hide()
    } else {
        $(".attach-file").show();
        $(".mjs-attach-files").show()
    }
    var e = f.hash;
    $("#resulttextarea").val(e);
    var c = f.imprint;
    if (c != null) {
        $("#imprint_text").html("qlinked from: " + c)
    } else {
        $("#imprint_text").html(localeMessages.imprint_not_used)
    }
    $(".title").html(location.protocol + "//" + location.host + "...");
    $(".qlink-read").unblock()
}
var lastQl = "";

function eStop(event) {
    if (event.metaKey == true || event.ctrlKey || event.shiftKey) {
        return;
    }
    event.preventDefault();
    event.stopPropagation()
}
function doDecrypt(n) {
    var m = $("#links-area");
    var b = JSON.parse(n.message);
    var l = aesDecrypt(b);
    if (!b.data) {
        b = JSON.parse(b)
    }
    var e = "true";
    if (b.decom) {
        e = b.decom
    }
    var c = null;
    if (e == "true") {
        var c = LZW.decompress(l)
    } else {
        var c = l
    }
    var k = /<br\s*[\/]?>/gi;
    lastQl = "";
    var conversationVersion = c.indexOf("%%A%%");
    if ( conversationVersion == -1 )
    {
        c = "%%A%%" + c + "%%C%%";
    }   

    var a = c.split("%%A%%");
    if (a.length > 2) {
        for (var d = 1; d < a.length; d++) {
            if (d < (a.length - fwLimit)) {
                continue
            }
            var g = a[d].split("%%C%%");
            g = g[0];
            g = unEscapeHtmlEntities(filterXSS(g.replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(k, "\n")));
            lastQl = lastQl + "%%A%%" + g + "%%C%%";
            if (d % 2 == 0) {
                g = "<div style='width:100%;display:inline-block'><textarea oninput='eStop(event)' onkeydown='eStop(event)' class='hash_result_area_p tx-res-more tx-res' onpaste='event.preventDefault();event.stopPropagation();return false;' oncut='event.preventDefault();event.stopPropagation();return false;'>" + g + "</textarea></div>"
            } else {
                g = "<div style='width:100%;display:inline-block'><textarea oninput='eStop(event)' onkeydown='eStop(event)' class='hash_result_area_i tx-res-more tx-res' onpaste='event.preventDefault();event.stopPropagation();return false;' oncut='event.preventDefault();event.stopPropagation();return false;'>" + g + "</textarea></div>"
            }
            $(".hash_result_area").css('background', 'none');
            $(".hash_result_area").html($(".hash_result_area").html() + g)
        }
    } else {
        var g = a[1].split("%%C%%");
        g = g[0];
        g = unEscapeHtmlEntities(filterXSS(g.replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(k, "\n")));
        lastQl = "%%A%%" + g + "%%C%%";
        g = "<textarea class='tx-res-one-only tx-res' oninput='eStop(event)' onkeydown='eStop(event)' onpaste='event.preventDefault();event.stopPropagation();return false;' oncut='event.preventDefault();event.stopPropagation();return false;' style='height: 100%;width: 100%;'>" + g + "</textarea>";
        $(".hash_result_area").html(g)
    }
    $(".tx-res").autosize();
    $("#msg-scroll-container").scrollTop($("#msg-scroll-container")[0].scrollHeight);
    var j = n.encFiles;
    namesFiles = n.namesFiles;
    if (j != null) {
        for (var d = 0, h; h = j[d]; d++) {
            dencFiles[d] = aesDecrypt(JSON.parse(j[d]));
            if (msieVersion()) {
                m.append("<li class='fa-paper-plane'><a href='#' class='clearfix' onclick='downloadUriForIE(" + d + ")'><div class='icon'></div><div class='file-name'>" + unescape(namesFiles[d]) + "</div><div class='tool-dl'></div></a>")
            } else {
                m.append("<li class='fa-paper-plane'><a href='" + dencFiles[d] + "' target='_blank' download='" + namesFiles[d] + "' class='clearfix' ><div class='icon'></div><div class='file-name'>" + unescape(namesFiles[d]) + "</div><div class='tool-dl'></div></a>")
            }
        }
    }
    finishDecrypt(n)
}
function downloadUriForIE(b) {
    var a = dataURItoBlob(dencFiles[b]);
    saveAs(a, unescape(namesFiles[b]))
}
$(function () {
    $(".normal").autosize();
    $(".animated").autosize()
});
$.fn.togglePlaceholder = function () {
    return this.each(function () {
        $(this).data("holder", $(this).attr("placeholder")).focusin(function () {
            $(this).attr("placeholder", "")
        }).focusout(function () {
            $(this).attr("placeholder", $(this).data("holder"))
        })
    })
};

function finishLoad(a, d, c) {
    if (a.lenght > (1048576 * 4 / 3)) {
        $("#msg-error").html("<span>" + localeMessages.max_file_size + "</span>");
        $("#msg-error").show();
        $(".qlink-msj").unblock();
        totalIndex--;
        if (totalIndex == 0) {
            $(".file-input-wrapper").show();
            $("#files").show()
        }
        return
    }
    ident = totalIndex - 1;
    var b = document.createElement("span");
    encFiles[ident] = a;
    if (encFiles[ident] == null) {
        $("#msg-error").html("<span>" + localeMessages.error_encrypt_file + "</span>");
        $("#msg-error").show()
    }
    $("#msg-error").hide();
    namesFiles[ident] = escape(c.name);
    b.className = "attach";
    b.innerHTML = ["File: ", c.name, '<img class="delattach" src="/images/delete.png" onclick="clearAt(this,\'' + namesFiles[ident] + "')\"/><br/>"].join("");
    document.getElementById("list").insertBefore(b, null)
}
var ident = 0;

function handleFileSelect(b) {
    var d = b.target.files;
    ident = 0;
    for (var c = 0, e; e = d[c]; c++) {
        $(".qlink-msj").block({
            message: "<div class='circles-loader'></div> <div>" + localeMessages.st_loading_image + "</div>",
            css: {
                border: "none",
                padding: "10px",
                showOverlay: false,
                backgroundColor: "#fff",
                "-webkit-border-radius": "0px",
                "-moz-border-radius": "0px",
                opacity: 1,
                color: "#000"
            },
            overlayCSS: {
                backgroundColor: "none"
            }
        });
        var a = new FileReader();
        a.onload = (function (f) {
            return function (h) {
                var g = h.target.result;
                var j = f.type;
                if (j == "image/jpeg" || j == "image/png") {
                    if (f.size > 1048576) {
                        var i = f.size / 1048576;
                        resizeImg(g, i, j, f)
                    } else {
                        finishLoad(g, j, f);
                        $(".qlink-msj").unblock()
                    }
                } else {
                    if (f.size > 1048576) {
                        $("#msg-error").html("<span>" + localeMessages.max_file_size + "</span>");
                        $("#msg-error").show();
                        $(".qlink-msj").unblock();
                        totalIndex--;
                        if (totalIndex == 0) {
                            $(".file-input-wrapper").show();
                            $("#files").show()
                        }
                        return
                    }
                    finishLoad(g, j, f);
                    $(".qlink-msj").unblock()
                }
            }
        })(e);
        a.onerror = function (f) {
            $("#msg-error").html("<span>" + localeMessages.error_file + "</span>");
            $("#msg-error").show()
        };
        a.onabort = function (f) {
            $("#msg-error").html("<span>" + localeMessages.abort_file + "</span>");
            $("#msg-error").show()
        };
        a.readAsDataURL(e);
        totalIndex++;
        if (totalIndex > 0) {
            $(".file-input-wrapper").hide();
            $("#files").hide()
        }
    }
}
function resizeImg(c, f, e, d) {
    var b = document.createElement("canvas");
    var a = new Image();
    a.onload = function () {
        b.width = a.width;
        b.height = a.height;
        var g = b.getContext("2d");
        b.height = b.height / f;
        b.width = b.width / f;
        g.scale(1 / f, 1 / f);
        g.drawImage(a, 0, 0);
        var h = b.toDataURL(e);
        finishLoad(h, e, d);
        $(".qlink-msj").unblock()
    };
    a.src = c;
    return
}
function clearAt(b, a) {
    var c = namesFiles.indexOf(a);
    encFiles.splice(c, 1);
    namesFiles.splice(c, 1);
    totalIndex--;
    b.parentElement.remove();
    if (totalIndex == 0) {
        $(".file-input-wrapper").show();
        $("#files").show()
    }
}
function aesEncrypt(h) {
    var e = CryptoJS.lib.WordArray.random(8).toString();
    var c = CryptoJS.lib.WordArray.random(32).toString();
    c = c.substring(0, 32);
    var a = 100;
    var d = CryptoJS.PBKDF2(password, CryptoJS.enc.Hex.parse(e), {
        keySize: 8,
        iterations: a
    });
    var g = CryptoJS.AES.encrypt(h, d, {
        iv: CryptoJS.enc.Hex.parse(c)
    });
    var f = g.ciphertext.toString(CryptoJS.enc.Base64);
    var b = {
        data: f,
        salt: e,
        iv: c,
        iter: a,
        decom: "true"
    };
    return b
}
function aesDecrypt(f) {
    if (!f.data) {
        f = JSON.parse(f)
    }
    var c = CryptoJS.lib.CipherParams.create({
        ciphertext: CryptoJS.enc.Base64.parse(f.data)
    });
    var b = 500;
    if (f.iter) {
        b = f.iter
    }
    var d = CryptoJS.PBKDF2(password, CryptoJS.enc.Hex.parse(f.salt), {
        keySize: 8,
        iterations: b
    });
    var a = CryptoJS.AES.decrypt(c, d, {
        iv: CryptoJS.enc.Hex.parse(f.iv)
    });
    var e = a.toString(CryptoJS.enc.Utf8);
    return e
}
function sleep(a, c, b) {
    if (b != null) {
        setTimeout(function () {
            c(b)
        }, a)
    } else {
        setTimeout(function () {
            c()
        }, a)
    }
}
function escapeHtmlEntities(a) {
    a = a.replace(/</g, "&lt;");
    a = a.replace(/>/g, "&gt;");
    a = a.replace(/&/g, "&amp;");
    a = a.replace(/¢/g, "&cent;");
    a = a.replace(/£/g, "&pound;");
    a = a.replace(/¥/g, "&yen;");
    a = a.replace(/€/g, "&euro;");
    a = a.replace(/§/g, "&sect;");
    a = a.replace(/©/g, "&copy;");
    a = a.replace(/®/g, "&reg;");
    a = a.replace(/™/g, "&trade;");
    a = a.replace(/"/g, "&quot;");
    a = a.replace(/'/g, "&apos;");
    return a
}
function unEscapeHtmlEntities(a) {
    a = a.replace(/&amp;/g, "&");
    a = a.replace(/&lt;/g, "<");
    a = a.replace(/&gt;/g, ">");
    a = a.replace(/&cent;/g, "¢");
    a = a.replace(/&pound;/g, "£");
    a = a.replace(/&yen;/g, "¥");
    a = a.replace(/&euro;/g, "€");
    a = a.replace(/&sect;/g, "§");
    a = a.replace(/&copy;/g, "©");
    a = a.replace(/&reg;/g, "®");
    a = a.replace(/&trade;/g, "™");
    a = a.replace(/&quot;/g, '"');
    a = a.replace(/&apos;/g, "'");
    return a
}
function doesConnectionExist() {
    var d = new XMLHttpRequest();
    var a = jsConfig.url_check_connection;
    var b = Math.round(Math.random() * 10000);
    d.open("HEAD", a + "?rand=" + b, false);
    try {
        d.send();
        if (d.status >= 200 && d.status < 304) {
            return true
        } else {
            return false
        }
    } catch (c) {
        return false
    }
}
function doReply() {
    location.href = "/?reply=t"
}
function doForward() {
    dencFiles = [];
    totalIndex = 0;
    encFiles = [];
    namesFiles = [];
    sha256 = null;
    password = null;
    wsh = "";
    init();
    var a = "/forward";
    $.ajax({
        type: "post",
        dataType: "json",
        url: a,
        data: {},
        success: function (b) {
            if (b.status == "OK") {
                $('#major-text').html(localeMessages.write_reply);
                $('#read-title').show();
                $(".content").remove();
                $("#xres").html(b.data);
                $("#response-container").show();
                $('.form-container').css('width', 'inherit');
                $("#last-qlink-message").removeClass("quick_message_title");
                $("#last-qlink-message").addClass("last_quick_message_title");
                $("#last-qlink-message").html("<p> >> " + localeMessages.history_include + "</p>")
            }
        },
        error: function () {}
    })
}
function checkBrSupport() {
    var b = true;
    if (navigator.userAgent.indexOf("Opera Mini") != -1) {
        b = false
    }
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
        var a = new Number(RegExp.$1);
        if (a <= 9 && a >= 5) {
            b = false
        }
    }
    if (navigator.whoVersion == "Safari 5") {
        b = false
    }
    if (navigator.whoVersion == "IE 7") {
        b = false
    }
    if (navigator.whoVersion == "IE 8") {
        b = false
    }
    if (navigator.whoVersion == "IE 9") {
        b = false
    }

    if (!b) {
        $("#footer").remove();
        $("#container-read").remove();
        $("#quick_help").remove();
        $("#unsupport").show()
    } else {}
    return b
}
navigator.whoVersion = (function () {
    var b = navigator.userAgent,
    a, c = b.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if (/trident/i.test(c[1])) {
        a = /\brv[ :]+(\d+)/g.exec(b) || [];
        return "IE " + (a[1] || "")
    }
    if (c[1] === "Chrome") {
        a = b.match(/\bOPR\/(\d+)/);
        if (a != null) {
            return "Opera " + a[1]
        }
    }
    c = c[2] ? [c[1], c[2]] : [navigator.appName, navigator.appVersion, "-?"];
    if ((a = b.match(/version\/(\d+)/i)) != null) {
        c.splice(1, 1, a[1])
    }
    return c.join(" ")
})();

function msieVersion() {
    var b = window.navigator.userAgent;
    var a = b.indexOf("MSIE ");
    if (a > 0 || !! navigator.userAgent.match(/Trident.*rv\:11\./)) {
        return true
    }
    return false
}
function dataURItoBlob(b) {
    var e;
    if (b.split(",")[0].indexOf("base64") >= 0) {
        e = atob(b.split(",")[1])
    } else {
        e = unescape(b.split(",")[1])
    }
    var a = b.split(",")[0].split(":")[1].split(";")[0];
    var c = new Uint8Array(e.length);
    for (var d = 0; d < e.length; d++) {
        c[d] = e.charCodeAt(d)
    }
    return new Blob([c], {
        type: a
    })
};
