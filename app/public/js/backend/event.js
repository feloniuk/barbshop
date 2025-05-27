"use strict";

function resetRecaptcha() {
  console.log("reset recaptcha");
  grecaptcha.reset();
}

function errorsColor(el) {
  if (el === "content") el = "description";

  // console.log(el);
  var input = $("input[name=" + el + "]");
  var textarea = $("#cke_" + el);
  var checkboxes_border = $("#chb_" + el);

  if (input) {
    input.css("border-color", "red");
  }

  if (textarea) {
    textarea.attr("style", "border-color: red !important");
  }

  if (checkboxes_border) {
    checkboxes_border.css("border-color", "red");
  }
}

function fillPostcode(el) {
  var code = trim($(el).text());
  $("#postcode").val(code);
  $(".suggests_result").html("");
}

function closeSuggest() {
  $(".suggests_result").html("");
}

function suggestPostcode(el) {
  if (trim($(el).val())) {
    load("jobs/postcode", "postcode#postcode");
    console.log("suggestPostcode");
  }
}

function loader() {
  $("#loader_fon").addClass("loader-wrapper");
  $("#loader").addClass("loader");
}

function removeLoader() {
  $("#loader_fon").removeClass("loader-wrapper");
  $("#loader").removeClass("loader");
}

function reInitConfirmation() {
  if (!!$.prototype.confirm) {
    // Remove confirmation
    $(".fa-trash, .fa-trash-restore-alt, .delete-section, .remove-item")
        .confirm({
          buttons: {
            tryAgain: {
              text: "Yes, delete",
              btnClass: "btn-red",
              action: function () {
                const link = this.$target.attr("@click");
                console.log("Clicked tooltip");

                if (typeof link === "undefined") {
                  location.href = this.$target.attr("href");
                } else {
                  eval(link);
                }
              },
            },
            cancel: function () {},
          },
          icon: "fas fa-exclamation-triangle",
          title: "Are you sure?",
          content:
              "Are you sure you wish to delete this item? Please re-confirm this action.",
          type: "red",
          typeAnimated: true,
          boxWidth: "30%",
          useBootstrap: false,
          theme: "modern",
          animation: "scale",
          backgroundDismissAnimation: "shake",
          draggable: false,
        });
  }
}

$(document).ready(function () {
  // Show Hide Code Snippet
  $(".toggle-code-snippet").click(function () {
    $(this).parents(".code-section-container").toggleClass("show-code");
  });

  if (typeof ClipboardJS != "undefined") {
    // COPY TO CLIPBOARD
    var clipboard = new ClipboardJS(".copy_btn");

    clipboard.on("success", function (e) {
      noticeInfo("Copied: " + e.text);
      // console.log(e);
    });

    clipboard.on("error", function (e) {
      noticeInfo("Copy Error!");
      // console.log(e);
    });
  }

  if (!!$.prototype.confirm) {
    // Remove confirmation
    reInitConfirmation();

    // Re-store confirmation
    $(".restore-item").confirm({
      buttons: {
        tryAgain: {
          text: "Yes, restore",
          btnClass: "btn-red",
          action: function () {
            const link = this.$target.attr("@click");
            console.log("Clicked tooltip");

            if (typeof link === "undefined") {
              location.href = this.$target.attr("href");
            } else {
              eval(link);
            }
          },
        },
        cancel: function () {},
      },
      icon: "fas fa-trash-restore",
      title: "Are you sure?",
      content:
        "Are you sure you wish to delete this item? Please re-confirm this action.",
      type: "green",
      typeAnimated: true,
      boxWidth: "30%",
      useBootstrap: false,
      theme: "modern",
      animation: "scale",
      backgroundDismissAnimation: "shake",
      draggable: false,
    });
  }
});

function noticeSuccess(msg) {
  msg = msg || "Success";
  Snackbar.show({
    text: msg,
    duration: 5000,
    actionTextColor: "#fff",
    backgroundColor: "#8dbf42",
  });
}

function noticeError(msg) {
  msg = msg || "Error";
  Snackbar.show({
    text: msg,
    duration: 10000,
    actionTextColor: "#fff",
    backgroundColor: "#e7515a",
  });
}

function noticeInfo(msg) {
  msg = msg || "Info";
  Snackbar.show({
    text: msg,
    duration: 5000,
    actionTextColor: "#fff",
    backgroundColor: "#3b3f5c",
  });
}

function chooseOption(el, valueField, nameField, funcName) {
  if (valueField) $(valueField).val($(el).attr("data-option"));

  if (nameField) $(nameField).html($(el).html());

  if (typeof funcName !== "undefined" && funcName !== false)
    window[funcName](el); // todo check function exist
}

function closePopupListener(redirectUrl) {
  $("#popup").addClass("active");

  const menuBar = document.querySelector(".navbar-nav .menu");

  if (menuBar) {
    scrollLock.disablePageScroll(menuBar);
  } else {
    scrollLock.disablePageScroll();
  }
  scrollLock.addScrollableSelector(".simplebar-content-wrapper");

  // // var $body = $('body');
  // // $body.addClass('open');
  //
  // $(".close_popup, .popup_fon").click(function () {
  //     // $body.removeClass('open');
  //     // $(".popup").fadeOut(200);
  //     // $(".popup").addClass('leave_right');
  //     if (redirectUrl) load(redirectUrl);
  // });
}

function removeErrors() {
  $(".error_text").text("");
}

function closePopup(redirectUrl) {
  $("#popup").removeClass("active");
  scrollLock.clearQueueScrollLocks();
  scrollLock.enablePageScroll();
  if (redirectUrl) load(redirectUrl);
}

// Open/close menu
function openMenu() {
  $("#site").addClass("open-menu");
}

function closeMenu() {
  $("#site").removeClass("open-menu");
}

// PopupMe
// <div class="mememe" onclick="popupMe(this);">
//     Popup Me
//     <div class="popup-me">
//         <div onclick="closeMe();">(X) Close</div>
//         <div>Popup Body</div>
//     </div>
// </div>
var popupMeEl;
function popupMe(el) {
  popupMeEl = $(el);
  $(popupMeEl).children().appendTo("#notice");
}

function closeMe() {
  $("#notice")
    .children()
    .appendTo("." + $(popupMeEl).prop("class"));
}

function toggleClass(el, toggleClass) {
  $(el).toggleClass(toggleClass);
}

/**
 * Put it to "onclick" when upload file
 * @param el
 */
function initFile(el) {
  files = el.files;
}

/**
 * Add loading spinner image to image uploader block
 * @param el
 * @param parent
 */
function addSpinnerIMG(el, parent, classRow) {
  parent = parent || false;
  classRow = classRow || "text-success";

  console.log(el);
  // $(el).parent().find('.preview_image').append('<div class="spinner-border text-success img__loading"></div>');

  if (parent)
    $(el)
      .parent()
      .append(
        '<div class="spinner-border img__loading ' + classRow + '"></div>'
      );
  else
    $(el).append(
      '<span class="spinner-border img__loading ' + classRow + '"></span>'
    );
}
function stopAllSpinnersIMG() {
  $("body > .img__loading").remove();
}

/**
 * initSlug function
 * $("#firstname, #lastname").keyup(function () {
 *     initSlug('#slug', '#firstname,#lastname', '+', 'http://am.loc/');
 * });
 * @param writeField
 * @param readFields
 * @param separator
 * @param start
 */
function initSlug(writeField, readFields, separator, start) {
  var readFieldsArr = readFields.split(",");
  separator = separator || "-";
  start = start || "";

  var row = start;
  for (var i = 0; i < readFieldsArr.length; i++) {
    if (i > 0) row += separator;
    row += $(readFieldsArr[i])
      .val()
      .replace(/[^a-zA-Z0-9]+/g, separator)
      .toLowerCase();
  }

  $(writeField).val(row);
}

// Start search
function startSearch(el) {
  let value = $(el).val();
  if (value) load("jobs", "keywords" + el);
}

// Buttons events

function share_linkedin(e) {
  window.open(
    "http://www.linkedin.com/shareArticle?mini=true&url=" + $(e).data("url"),
    "",
    "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600"
  );
  return false;
}

function share_twitter(e) {
  window.open(
    "https://twitter.com/intent/tweet?url=" + $(e).data("url"),
    "",
    "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600"
  );
  return false;
}

function share_facebook(e) {
  window.open(
    "https://www.facebook.com/sharer/sharer.php?u=" + $(e).data("url"),
    "",
    "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600"
  );
  return false;
}

function copy_link_modal(el) {
  $("#copy_link_profile_url").val($(el).data("url"));
  $("#copy_link_profile_url").tooltipster("content", "Copy Link");

  $("#copy-link-dialog").dialog({
    resizable: false,
    height: "auto",
    width: 600,
    modal: true,
    buttons: {
      Copy: function () {
        var copyText = document.getElementById("copy_link_profile_url");
        copyText.select();
        document.execCommand("copy");

        $("#copy_link_profile_url").tooltipster("content", "Copied");
        $("#copy_link_profile_url").tooltipster("open");
      },
      Cancel: function () {
        $("#copy_link_profile_url").tooltipster("close");
        $(this).dialog("close");
      },
    },
  });
}

function latestRolesSlider(el) {
  $(el).slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 650,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });
}

// Download
window.downloadFile = function (sUrl) {
  //iOS devices do not support downloading. We have to inform user about this.
  if (/(iP)/g.test(navigator.userAgent)) {
    alert(
      "Your device does not support files downloading. Please try again in desktop browser."
    );
    return false;
  }

  //If in Chrome or Safari - download via virtual link click
  if (window.downloadFile.isChrome || window.downloadFile.isSafari) {
    //Creating new link node.
    var link = document.createElement("a");
    link.href = sUrl;

    if (link.download !== undefined) {
      //Set HTML5 download attribute. This will prevent file from opening if supported.
      var fileName = sUrl.substring(sUrl.lastIndexOf("/") + 1, sUrl.length);
      link.download = fileName;
    }

    //Dispatching click event.
    if (document.createEvent) {
      var e = document.createEvent("MouseEvents");
      e.initEvent("click", true, true);
      link.dispatchEvent(e);
      return true;
    }
  }

  // Force file download (whether supported by server).
  if (sUrl.indexOf("?") === -1) {
    sUrl += "?download";
  }

  // window.open(sUrl, '', 'scrollbars=1');
  window.open(sUrl, "_blank");
  return true;
};

window.downloadFileNew = function (sUrl) {
  //iOS devices do not support downloading. We have to inform user about this.
  if (/(iP)/g.test(navigator.userAgent)) {
    alert(
      "Your device does not support files downloading. Please try again in desktop browser."
    );
    return false;
  }

  //Creating new link node.
  var link = document.createElement("a");
  var pathArray = sUrl.split("||");
  link.href = pathArray[0];

  link.download = pathArray[1];

  //Dispatching click event.
  if (document.createEvent) {
    var e = document.createEvent("MouseEvents");
    e.initEvent("click", true, true);
    link.dispatchEvent(e);
    return true;
  }
};
