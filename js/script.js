(function ($) {
  var PAGE_NAV_OPEN = "page_nav-open";
  var OVERLAY_ON = "page__overlay_on";
  var FILTER_ACTIVE = "filters__item_active";
  var SIDEBAR_LINK_ACTIVE = "sidebar__link_active";
  var PHONE_DIGITS = 11;
  var NAME_MIN = 2;
  var DESKTOP_MIN = 992;
  var SUBMIT_DELAY_MS = 400;
  var FILTER_ALL = "all";
  var PARK_ID = "park";
  var EQUIPMENT_OPTIONS = [
    "Экскаватор Doosan DX225",
    "Экскаватор Hyundai R220LC",
    "Экскаватор-погрузчик JCB 3CX",
    "Фронтальный погрузчик 544K",
    "Автокран 32 т",
    "Автовышка АГП-18",
    "Самосвал КамАЗ 20 м³",
    "Бульдозер CAT D6",
    "Пока не знаю, опишу задачу",
  ];
  var MSG_OK = "Заявку приняли. Диспетчер перезвонит в рабочее время, обычно в течение часа.";
  var MSG_PHONE = "Укажите телефон полностью, с кодом города.";
  var MSG_NAME = "Напишите, как к вам обращаться.";
  var MSG_AGREE = "Нужно согласие на обработку данных — иначе заявку не примем.";

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
    window.setTimeout(function () {
      $form.trigger("reset");
      $form.find("[name='phone']").val("");
      $ok.text(MSG_OK).show();
      $form.find(".js-submit").prop("disabled", false);
    }, SUBMIT_DELAY_MS);
  }

  function fillEquipmentSelects() {
    $("select[name='equipment']").each(function () {
      var $select = $(this);
      EQUIPMENT_OPTIONS.forEach(function (name) {
        $select.append($("<option>", { value: name, text: name }));
      });
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
    fillEquipmentSelects();

    $(".js-open-nav").on("click", function (event) {
      event.preventDefault();
      event.stopPropagation();
      openNav();
    });
    $(".js-close-nav, .js-overlay").on("click", closeNav);

    $(document).on("click", ".sidebar__link, .topbar__link", function () {
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

    $(".js-hero-more").on("click", function (event) {
      event.preventDefault();
      var type = $(this).data("type");
      $('.filters__item.js-filter[data-type="' + type + '"]').trigger("click");
    });

    $(".js-lead-form").on("submit", function (event) {
      event.preventDefault();
      handleSubmit($(this));
    });
  });

  window.mehbazaApp = true;
})(jQuery);
