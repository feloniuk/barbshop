'use strict';

let ajaxUrl,
    files,
    intervals = [],
    ajaxVars = {},
    GLOBAL_URL = ''; // GLOBAL_URL


function clearFiles() { files = null; }

$.fn.hasAttr = function (name) {
    return this.attr(name) !== undefined;
};

$(function () {
    // Cancel transitions
    $('body').on('click', 'a', function (e) {
        console.log('Cancel transitions');
        if ($(this).hasAttr('onclick')) {
            e.preventDefault();
        }
        //if (!$(this).hasClass('nob'))
    });
});


window.addEventListener('popstate', function(event) {
    // back to prev page
    // load(window.location.pathname.replace('/dir', ''));
    // history.pushState(null, null, window.location.pathname);
});


function load(url = null, ...fileds) {
    let data = new FormData();
    let type = 'POST';

    // Files
    let fieldOfFiles = $('#files');
    if (typeof fieldOfFiles[0] != "undefined")
        files = fieldOfFiles[0].files;

    // Files 2
    let fieldOfFiles2 = $('.init-files');
    for (let i = 0; i < fieldOfFiles2.length; i++) {
        if (fieldOfFiles2[i].files) {
            files = fieldOfFiles2[i].files;
            break;
        }
    }

    $.each(files, function (key, value) {
        data.append(key, value);
    });


    // Parse params:
    // #text - значення input з id='text'
    // .text - значення input з class='text'
    // age=25 - передаємо ключ та значення
    // name#field - передаємо ключ та значення форми ( ключ=name, значення=field )
    // !name#el - передаємо ключ та значення елементу(не input, ex: <p id="el">Text</p>)
    // form:#login - передаємо форму з id='login'
    // json:{} - передаємо json // TODO ...
    // *SYS_OPTION* - системна опція для load() ex: *move*
    for (let i = 0; i < fileds.length; i++) {
        if (fileds[i].charAt(0) === '#' || fileds[i].charAt(0) === '.') {
            data.append(fileds[i], $(fileds[i]).val());
        } else {

            // if (fileds[i].indexOf('=') >= 0) {
            if (/^\w{1,32}=(.*?)$/i.test(fileds[i])) {
                let arr = fileds[i].split('=');
                data.append(arr[0], arr[1]);
            } else {
                if (/^!?\w{1,32}#(.*?)$/i.test(fileds[i])) { // name#field
                    let arr = fileds[i].split('#');
                    if (arr[0].charAt(0) === '!')
                        data.append(arr[0].replace('!', ''), $('#'+arr[1]).text());
                    else
                        data.append(arr[0], $('#'+arr[1]).val());

                } else if (/^!?\w{1,32}\.(.*?)$/i.test(fileds[i])) { // name.field
                    let arr = fileds[i].split('.');
                    if (arr[0].charAt(0) === '!')
                        data.append(arr[0].replace('!', ''), $('.'+arr[1]).text());
                    else
                        data.append(arr[0], $('.'+arr[1]).val());

                } else if (/^\*(.*?)\*$/i.test(fileds[i])) { // *SYS_OPTION*
                    let arr = fileds[i].split('=');
                    sysFunctions[arr[0]] = (arr[1]) ? arr[1] : true;

                } else if ('url:url' === (fileds[i])) { // url:url curent page url
                    data.append('_url', window.location.href);

                } else {
                    // form serialize
                    if (/^form:#(.*?)$/i.test(fileds[i])) {
                        let arr = fileds[i].split('#');
                        let elements = document.forms[arr[1]].elements;
                        // console.log($('#' + arr[1]).serialize());

                        for (let i = 0; i < elements.length; i++){
                            let formField = $(elements[i]);

                            if (formField[0].type === 'radio' || formField[0].type === 'checkbox') {
                                if (formField[0].checked === true) {
                                    data.append(formField.attr("name"), formField[0].value);
                                }
                            } else {
                                data.append(formField.attr("name"), formField.val());
                            }
                        }
                    }
                    // console.log(fileds[i]);
                }
            }
        }
    }

    let contentType = false;
    if (/Edge/.test(navigator.userAgent)) {
        // contentType = "application/x-www-form-urlencoded"; // [-----------------------------7e314734a0746 Content-Disposition:_form-data;_name] => "email" shloserb@gmail.com
        // contentType = "multipart/form-data;"; // Missing boundary in multipart/form-data POST data in <b>Unknown</b> on line <b>0</b>
        // contentType = "application/json; charset=utf-8;"; // empty
        // contentType = "multipart/form-data; charset=utf-8; boundary=" + Math.random() .toString().substr(2); // empty
    }

    $.ajax({
        // url:         site_url + trim(url, '/'),
        url:         url.substring(0, 4) === 'http' ? url : ( site_url + trim(url, '/') ),
        type:        type,
        data:        data,
        cache:       false,
        dataType:    'json',
        processData: false,
        contentType: contentType,


        success: function (result) {
            if (result.error == false) {
                //prev page
                ajaxUrl = window.location.href;

                // Parse result
                for (let key in result.res)
                    processField(result.res[key]);

                callAfterLoad(); // After Load func
            } else {
                if (Array.isArray(result.error)) {
                    result.error.forEach(function (item, i, arr) {
                        $('.' + item.key).addClass('error');
                        $('.' + item.key + ' span.error_text').text(item.value);
                    });
                } else {
                    noticeError(result.error);
                    // alert(result.error);
                }

                // Parse error res
                if (Array.isArray(result.error_res)) {
                    for (let key in result.error_res)
                        processField(result.error_res[key]);
                }

                callAfterLoad(); // After Load func
            }

            // callAfterLoad();
        },
        error: function (result) {
            // alert("Error!");
            stopAllSpinnersIMG();
        }
    });

    callAfterClick();
}


function processField(jsonObj) {
    try {
        if (jsonObj.action === 'prepend') {
            // paste at the begin
            $(jsonObj.key).prepend(jsonObj.value);

        } else if (jsonObj.action === 'append') {
            // paste et the end
            $(jsonObj.key).append(jsonObj.value);

        } else if (jsonObj.action === 'after') {
            // paste after
            $(jsonObj.key).after(jsonObj.value);

            console.log(jsonObj.key);
            console.log(jsonObj.value);

        } else if (jsonObj.action === 'before') {
            // paste before
            $(jsonObj.key).before(jsonObj.value);

        } else if (jsonObj.action === 'attr') {
            // set attr
            $(jsonObj.key).attr(jsonObj.attrName, jsonObj.value);

        } else if (jsonObj.action === 'removeAttr') {
            // set attr
            $(jsonObj.key).removeAttr(jsonObj.value);

        } else if (jsonObj.action === 'addClass') {
            // set attr
            $(jsonObj.key).addClass(jsonObj.value);

        } else if (jsonObj.action === 'removeClass') {
            // set attr
            $(jsonObj.key).removeClass(jsonObj.value);

        } else if (jsonObj.action === 'remove' || jsonObj.action === 'delete') {
            // remove element
            $(jsonObj.key).remove();

        } else if (jsonObj.action === 'val') {
            // set value
            $(jsonObj.key).val(jsonObj.value);

        } else if (jsonObj.action === 'func') {
            // function
            window[jsonObj.key](jsonObj.value);

        } else if (jsonObj.action === 'jvar') {
            // переменная в глобальном масиве ajaxVars
            ajaxVars[jsonObj.key] = jsonObj.value;

        } else if (jsonObj.action === 'load') {
            // load page
            if (jsonObj.value)
                load(jsonObj.key, jsonObj.value);
            else
                load(jsonObj.key);

        } else if (jsonObj.action === 'redirect') {
            // redirect
            window.location.href = jsonObj.value;

        } else if (jsonObj.action === 'title') {
            // set title
            document.title = jsonObj.value;

        } else if (jsonObj.action === 'url') { //url
            // add history
            history.pushState('', '', jsonObj.value);
            GLOBAL_URL = jsonObj.value;

        } else if (jsonObj.url != false && typeof jsonObj.url !== 'undefined') {
            // add history
            history.pushState('', '', jsonObj.url);
            GLOBAL_URL = jsonObj.url;

        } else if (jsonObj.click != false && typeof jsonObj.click !== 'undefined') {
            // trigger click
            $(jsonObj.click).trigger("click");

        } else {
            $(jsonObj.key).html(jsonObj.value);
        }
        return;
    } catch (e) {
        console.log("Error process", e);
        return;
    }
}


let CHECKcallAfterClick = false;
let CHECKcallAfterLoad = false;

/**
 * Function calling after click load()
 */
function callAfterClick() {
    if (!CHECKcallAfterClick) {
        CHECKcallAfterClick = true;

        // // Hide boards panel
        // $(document).on('click', function(e) {
        //     // Board
        //     if (!$(e.target).closest('.boards_window').length && !$(e.target).closest('header a').length) {
        //         // console.log("click not boards_window");
        //         $('#boards').removeClass('open').addClass('close');
        //         // $('#boards').fadeOut(200);
        //     }
        //
        //     // Board link
        //     if ($(e.target).closest('.boards_window .board_choose a').length) {
        //         // console.log("click not boards_window > a");
        //         // $('#boards').removeClass('open').addClass('close'); // <--- work before
        //         // $('#search').addClass('close').removeClass('open');
        //     }
        //
        //     e.stopPropagation();
        // });
    }
}

function callAfterLoad() {
    if (!CHECKcallAfterLoad) {
        CHECKcallAfterLoad = true;

        // // Hide search
        // $(document).on('click', function(e) {
        //     // Search -> Home
        //     if ($(e.target).closest('._home').length) {
        //         // console.log("click home");
        //         // closeSearch();
        //     }
        //
        //     // Search -> tool open
        //     if ($(e.target).closest('a.head').length) {
        //         // console.log("click search tool");
        //         // closeSearch();
        //     }
        //
        //     e.stopPropagation();
        // });
    }

    if (typeof(AOS) !== 'undefined') {
        AOS.refreshHard();
    }
    // if (typeof window['showBtn'] === "function") {
    //     showBtn();
    // }
    // if (typeof window['redissBtn'] === "function") {
    //     redissBtn();
    // }
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(Object.prototype.hasOwnProperty.call(obj, prop)) {
            return false;
        }
    }

    return JSON.stringify(obj) === JSON.stringify({});
}

/**
 * Function event_stop
 * - event.preventDefault() stop go by link
 * - event.stopPropagation() stop next events
 */
function stopEv() {
    event.preventDefault(); // cancel switch href
    event.stopPropagation();
}


function trim( str, charlist ) {
    charlist = !charlist ? ' \\s\xA0' : charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    let re = new RegExp('^[' + charlist + ']+|[' + charlist + ']+$', 'g');
    return str.replace(re, '');
}

function formatString(str) {
    return str
        .replace(/\\\'/g, '\'')
        .replace(/\\\"/g, '\"')
        .replace(/\\\//g, '\/')
        .replace(/\\\\/g, '\\');
}


function putText(target, html) {
    $(target).html(html);
}

function setVal(target, html) {
    $(target).val(html);
}


function getTime (mode) {
    mode = mode || 's';

    if (mode === 'ms')
        return new Date().getTime(); // result in ms
    else
        return Math.floor(new Date().getTime() / 1000); // result in s
}


function addZero(value) {
    if (value.toString().length === 1)
        value = '0' + value;

    return value;
}

function focusMe(key) {
    $(key).focus();
}


window.scrollToEl = function scrollToEl(targetID) {
    let config = [...(targetID.split('|'))];
    let duration = +config[1] && +config[1] != "" ? +config[1] : 800;
    let paddingTop = +config[2] && +config[2] != "" ? +config[2] : 0;
    let target = config[0];
    if ($(target).length) {
        $("html, body").animate({
            scrollTop: $(target).offset().top - paddingTop,
        }, duration);
        return false;
    }
};


/**
 * isObjEmpty
 * @param obj
 * @returns {boolean}
 */
function isObjEmpty(obj) {
    for (let key in obj)
        return false;

    return true;
}


/**
 * checkInt - перевіряє чи значення є чилом і повертає його, якщо ні - повертається значення за замовчуванням
 * @param value
 * @param defaultValue
 */
function checkInt(value, defaultValue) {
    if (!defaultValue && defaultValue !== false)
        defaultValue = 0;

    if (!isNaN(parseFloat(value)) && isFinite(value))
        return parseInt(value); // added parseInt 12.11.2018
    else
        return defaultValue;
}

/**
 * incrementAction
 * @param el
 */

function incrementAction(el) {
    let value = parseInt( $(el).text() );
    if (isNaN(value))
        value = 0;

    $(el).text(value + 1);
}

function hideNotice(id) {
    setTimeout(function(){ $('#'+id).fadeOut(2000); }, 7000);
}


function randomInteger(min, max) {
    return Math.round( min + Math.random() * (max - min) );
}

function docW() { return $(document).width(); }
function docH() { return $(document).height(); }
function winW() { return $(window).width(); }
function winH() { return $(window).height(); }


/**
 * copyToClipboard
 * @param target
 */
function copyToClipboard(target) {
    /* Get the text field */
    var copyText = document.getElementById(target);

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    noticeInfo('Copied!');
}






/* Crop */

var minHeightForCrop = 300;
var minWidthForCrop = 300;

function setMinHeightForCrop(height) {
    minHeightForCrop = height;
}
function setMinWidthForCrop(width) {
    minWidthForCrop = width;
}

function addCrop(cropEl) {
    var xy_h = document.getElementById("xy_h");
    var div = document.getElementById("xy");
    var flagOnMove = false;
    var flagOnResize = false;

    var crop = document.getElementById(cropEl);
    var cropHeight = parseInt(crop.style.height);
    var cropWidth = parseInt(crop.style.width);

    var imgCoefficient = $("#coef").val();
    if (imgCoefficient <= 1)
        imgCoefficient = 1;

    var minCropHeight = parseInt(minHeightForCrop / imgCoefficient);
    var minCropWidth = parseInt(minWidthForCrop / imgCoefficient);


    //console.log(cropWidth + ' * ' + cropHeight);
    //console.log(imgCoefficient);

    xy_h.style.top = 0 + "px";
    xy_h.style.left = 0 + "px";
    $("#posY").val(0);
    $("#posX").val(0);

    xy_h.style.width = minCropWidth + "px";
    xy_h.style.height = minCropHeight + "px";
    div.style.width = minCropWidth + "px";
    div.style.height = minCropHeight + "px";
    $("#width").val(minCropWidth);
    $("#height").val(minCropHeight);

    // ---C1--------------------------
    var c1 = document.getElementById("c1");

    c1.onmousedown = function (event) {
        flagOnResize = true;

        var width = div.offsetWidth;
        var height = div.offsetHeight;
        var top = xy_h.offsetTop;
        var left = xy_h.offsetLeft;

        var posX = event.pageX;
        var posY = event.pageY;

        document.onmousemove = function (event) {
            if (flagOnResize == true) {
                var res = width - (event.pageX - posX);
                var resTop = top + event.pageX - posX;
                var resLeft = left + event.pageX - posX;

                if (res >= minCropWidth && resTop >= 0 && resLeft >= 0) {
                    xy_h.style.top = resTop + "px";
                    xy_h.style.left = resLeft + "px";
                    $("#posY").val(resTop);
                    $("#posX").val(resLeft);
                }

                if (res >= minCropWidth && resTop >= 0 && resLeft >= 0) {
                    xy_h.style.width = res + "px";
                    xy_h.style.height = res + "px";
                    div.style.width = res + "px";
                    div.style.height = res + "px";

                    $("#width").val(res);
                    $("#height").val(res);
                }

                scaling('mini');
            }
        };
    };

    // ---C2--------------------------
    var c2 = document.getElementById("c2");

    c2.onmousedown = function (event) {
        flagOnResize = true;

        var width = div.offsetWidth;
        var height = div.offsetHeight;
        var top = xy_h.offsetTop;
        var left = xy_h.offsetLeft;

        var posX = event.pageX;
        var posY = event.pageY;

        document.onmousemove = function (event) {
            if (flagOnResize == true) {
                var res = height + (posY - event.pageY);
                var resTop = top - (posY - event.pageY);

                if (res >= minCropHeight && resTop >= 0) {
                    if (left + res <= cropWidth) {
                        xy_h.style.top = resTop + "px";
                        $("#posY").val(resTop);
                    }
                }

                if (res >= minCropHeight && resTop >= 0) {

                    if (left + res <= cropWidth) {
                        //res = cropWidth - left;
                        xy_h.style.width = res + "px";
                        xy_h.style.height = res + "px";
                        div.style.width = res + "px";
                        div.style.height = res + "px";

                        $("#width").val(res);
                        $("#height").val(res);
                    }
                }

                scaling('mini');
            }
        };
    };

    // ---C3--------------------------
    var c3 = document.getElementById("c3");

    c3.onmousedown = function (event) {
        flagOnResize = true;

        var width = div.offsetWidth;
        var height = div.offsetHeight;
        var top = xy_h.offsetTop;
        var left = xy_h.offsetLeft;

        var posX = event.pageX;
        var posY = event.pageY;

        document.onmousemove = function (event) {
            if (flagOnResize == true) {
                var res = width + event.pageX - posX;

                if (res <= minCropWidth)
                    res = minCropWidth;
                if (left + res >= cropWidth)
                    res = cropWidth - left;
                if (top + res >= cropHeight)
                    res = cropHeight - top;

                xy_h.style.width = res + "px";
                xy_h.style.height = res + "px";
                div.style.width = res + "px";
                div.style.height = res + "px";

                $("#width").val(res);
                $("#height").val(res);

                scaling('mini');
            }
        };
    };

    // ---C4--------------------------
    var c4 = document.getElementById("c4");

    c4.onmousedown = function (event) {
        flagOnResize = true;

        var width = div.offsetWidth;
        var height = div.offsetHeight;
        var top = xy_h.offsetTop;
        var left = xy_h.offsetLeft;

        var posX = event.pageX;
        var posY = event.pageY;

        document.onmousemove = function (event) {
            if (flagOnResize == true) {
                var res = height + (event.pageY - posY);
                var resLeft = left + (posY - event.pageY);

                if (res >= minCropHeight && resLeft >= 0 && top + res <= cropHeight) {
                    xy_h.style.left = resLeft + "px";
                    $("#posX").val(resLeft);
                }

                if (res >= minCropHeight && resLeft >= 0 && top + res <= cropHeight) {
                    xy_h.style.width = res + "px";
                    xy_h.style.height = res + "px";
                    div.style.width = res + "px";
                    div.style.height = res + "px";

                    $("#width").val(res);
                    $("#height").val(res);
                }

                scaling('mini');
            }
        };
    };

    // -----------------------------

    div.onmousedown = function (event) {
        flagOnMove = true;

        var width = div.offsetWidth;
        var height = div.offsetHeight;
        var top = xy_h.offsetTop;
        var left = xy_h.offsetLeft;

        var posX = event.pageX;
        var posY = event.pageY;

        document.onmousemove = function (event) {
            if (flagOnMove == true) {
                var newTop = top + event.pageY - posY;
                if (newTop <= 0)
                    newTop = 0;
                if (newTop + height >= cropHeight)
                    newTop = cropHeight - height;

                var newLeft = left + event.pageX - posX;
                if (newLeft <= 0)
                    newLeft = 0;
                if (newLeft + width >= cropWidth)
                    newLeft = cropWidth - width;

                xy_h.style.top = newTop + "px";
                xy_h.style.left = newLeft + "px";

                $("#width").val(width);
                $("#height").val(height);
                $("#posY").val(newTop);
                $("#posX").val(newLeft);

                scaling('mini');
            }
        };
    };

    document.onmouseup = function () {
        flagOnMove = false;
        flagOnResize = false;
    };
}

function scaling(id) {
    var obj = document.getElementById(id);
    var xy_h = document.getElementById("xy_h");
    var div = document.getElementById("xy");

    var width = div.offsetWidth;
    var height = div.offsetHeight;
    var top = xy_h.offsetTop;
    var left = xy_h.offsetLeft;

    var imgW = 265;
    var imgH = 265;
    var miniature = 50;

    var cofW = miniature/width;
    var cofH = miniature/height;

    if (obj != null) {
        obj.style.width = imgW*cofW + "px";
        obj.style.height = imgH*cofH + "px";
        obj.style.marginTop = "-"+top*cofW + "px";
        obj.style.marginLeft = "-"+left*cofH + "px";
    }
}

function removeFieldImage(id) {
    $('#image_block_' + id).remove();
}

// Return TRUE if the given function has been defined
function function_exists(function_name) {
    if (typeof function_name == 'string') {
        return (typeof window[function_name] == 'function');
    } else {
        return (function_name instanceof Function);
    }
}

function loaderBtnStartCMS(btn) {
    const currentColor = getComputedStyle(btn)
        .getPropertyValue('--text-color-loader');
    btn.innerHTML = `<span class="disabled-btn-content">${btn.innerHTML}</span>`;

    btn.insertAdjacentHTML(
        "beforeend",
        `
      <div role="status">
         <svg aria-hidden="true" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path class="track-loader" d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="${currentColor}"/>
               <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="${currentColor}"/>
         </svg>
         <span class="disabled-btn-sr-only">Loading...</span>
      </div>
   `
    );

    btn.classList.add("disabled-btn-loader-cms");
    btn.disabled = true;
}

function loaderBtnEndCMS(id) {
    const btn = document.getElementById(id);

    btn.querySelector('div[role="status"]').remove();
    btn.innerHTML = btn.querySelector("span.disabled-btn-content").innerHTML;

    btn.classList.remove("disabled-btn-loader-cms");
    btn.disabled = false;
}

function globalLoaderStartCMS() {
    const loader = document.getElementById("global-loader");

    loader.style.opacity = '1';
    loader.style.pointerEvents = 'auto';
    scrollLock.disablePageScroll();
}

function globalLoaderEndCMS() {
    const loader = document.getElementById("global-loader");

    loader.style.opacity = '0';
    loader.style.pointerEvents = 'none';
    scrollLock.enablePageScroll();
}
