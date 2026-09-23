(function ($) {
  var PAGE_NAV_OPEN = "page_nav-open";
  var OVERLAY_ON = "page__overlay_on";
  var FILTER_ACTIVE = "filters__item_active";
  var SIDEBAR_LINK_ACTIVE = "sidebar__link_active";
  var cfg = window.MehbazaData || {};
  var PHONE_DIGITS = parseInt(cfg.phoneDigits, 10) || 11;
  var NAME_MIN = parseInt(cfg.nameMin, 10) || 2;
  var DESKTOP_MIN = parseInt(cfg.desktopMin, 10) || 992;
  var FILTER_ALL = cfg.filterAll || "all";
  var PARK_ID = cfg.parkId || "park";
  var MSG_OK = cfg.msgOk || "";
  var MSG_PHONE = cfg.msgPhone || "";
  var MSG_NAME = cfg.msgName || "";
  var MSG_AGREE = cfg.msgAgree || "";
  var MSG_FAIL = cfg.msgFail || "";

  function digitsOnly(value) {
    return String(value || "").replace(/\D/g, "");
  }

  function formatPhone(value) {
    var digits = digitsOnly(value);
    if (digits.charAt(0) === "8") {
      digits = "7" + digits.slice(1);
    }
    if (digits && digits.charAt(0) !== "7") {
      digits = "7" + digits;
    }
    digits = digits.slice(0, PHONE_DIGITS);
    var result = "+7";
    if (digits.length > 1) {
      result += " (" + digits.slice(1, 4);
    }
    if (digits.length >= 4) {
      result += ") " + digits.slice(4, 7);
    }
    if (digits.length >= 7) {
      result += "-" + digits.slice(7, 9);
    }
    if (digits.length >= 9) {
      result += "-" + digits.slice(9, PHONE_DIGITS);
    }
    return result;
  }

  function closeNav() {
    $(".page").removeClass(PAGE_NAV_OPEN);
    $(".js-overlay").removeClass(OVERLAY_ON);
  }

  function openNav() {
    $(".page").addClass(PAGE_NAV_OPEN);
    $(".js-overlay").addClass(OVERLAY_ON);
  }

  function setEquipment(name) {
    if (!name) {
      return;
    }
    $("select[name='equipment']").val(name);
  }

  function validateForm($form) {
    var name = $.trim($form.find("[name='name']").val());
    var phone = digitsOnly($form.find("[name='phone']").val());
    var agree = $form.find("[name='agree']").prop("checked");

    if (name.length < NAME_MIN) {
      return MSG_NAME;
    }
    if (phone.length !== PHONE_DIGITS) {
      return MSG_PHONE;
    }
    if (!agree) {
      return MSG_AGREE;
    }
    return "";
  }

  function handleSubmit($form) {
    var error = validateForm($form);
    var $ok = $form.find(".js-form-ok");
    var $err = $form.find(".js-form-err");

    $ok.hide();
    $err.hide();

    if (error) {
      $err.text(error).show();
      return;
    }

    $form.find(".js-submit").prop("disabled", true);

    $.post(cfg.ajaxUrl, {
      action: cfg.action,
      nonce: cfg.nonce,
      name: $form.find("[name='name']").val(),
      phone: $form.find("[name='phone']").val(),
      equipment: $form.find("[name='equipment']").val(),
      comment: $form.find("[name='comment']").val(),
      agree: $form.find("[name='agree']").prop("checked") ? 1 : 0,
    })
      .done(function (response) {
        if (response && response.success) {
          $form.trigger("reset");
          $form.find("[name='phone']").val("");
          $ok.text((response.data && response.data.message) || MSG_OK).show();
          return;
        }
        var message = response && response.data && response.data.message ? response.data.message : MSG_FAIL;
        $err.text(message).show();
      })
      .fail(function () {
        $err.text(MSG_FAIL).show();
      })
      .always(function () {
        $form.find(".js-submit").prop("disabled", false);
      });
  }

  function setFilterActive(type) {
    $(".js-filter").removeClass(FILTER_ACTIVE + " " + SIDEBAR_LINK_ACTIVE);
    $('.js-filter[data-type="' + type + '"]').each(function () {
      var $el = $(this);
      if ($el.hasClass("filters__item")) {
        $el.addClass(FILTER_ACTIVE);
      } else {
        $el.addClass(SIDEBAR_LINK_ACTIVE);
      }
    });
  }

  $(function () {
    $(".js-open-nav").on("click", function (event) {
      event.preventDefault();
      event.stopPropagation();
      openNav();
    });
    $(".js-close-nav, .js-overlay").on("click", closeNav);

    $(document).on("click", ".sidebar__link, .sidebar__menu a, .topbar__nav a", function () {
      if (window.innerWidth < DESKTOP_MIN) {
        closeNav();
      }
    });

    $("[name='phone']").on("input", function () {
      this.value = formatPhone(this.value);
    });

    $(".js-filter").on("click", function (event) {
      var $btn = $(this);
      var type = $btn.data("type");

      if ($btn.is("a") && type) {
        event.preventDefault();
        var park = document.getElementById(PARK_ID);
        if (park) {
          park.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }

      setFilterActive(type);

      $(".fleet__item").each(function () {
        var cat = $(this).data("cat");
        var visible = !type || type === FILTER_ALL || cat === type;
        $(this).toggle(visible);
      });
    });

    $(".js-order").on("click", function () {
      setEquipment($(this).data("equipment"));
      $("#callbackModal").modal("show");
    });

    $(".js-lead-form").on("submit", function (event) {
      event.preventDefault();
      handleSubmit($(this));
    });
  });
})(jQuery);
