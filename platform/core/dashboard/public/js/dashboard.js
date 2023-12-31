/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************************************!*\
  !*** ./platform/core/dashboard/resources/assets/js/dashboard.js ***!
  \******************************************************************/
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var BDashboard = /*#__PURE__*/function () {
  function BDashboard() {
    _classCallCheck(this, BDashboard);
  }

  _createClass(BDashboard, [{
    key: "init",
    value: function init() {
      var list_widgets = $('#list_widgets');
      $(document).on('click', '.portlet > .portlet-title .tools > a.remove', function (event) {
        event.preventDefault();
        $('#hide-widget-confirm-bttn').data('id', $(event.currentTarget).closest('.widget_item').prop('id'));
        $('#hide_widget_modal').modal('show');
      });
      list_widgets.on('click', '.page_next, .page_previous', function (event) {
        event.preventDefault();
        BDashboard.loadWidget($(event.currentTarget).closest('.portlet').find('.portlet-body'), $(event.currentTarget).prop('href'));
      });
      list_widgets.on('change', '.number_record .numb', function (event) {
        event.preventDefault();
        var paginate = $('.number_record .numb').val();

        if (!isNaN(paginate)) {
          BDashboard.loadWidget($(event.currentTarget).closest('.portlet').find('.portlet-body'), $(event.currentTarget).closest('.widget_item').attr('data-url'), {
            paginate: paginate
          });
        } else {
          Botble.showError('Please input a number!');
        }
      });
      list_widgets.on('click', '.btn_change_paginate', function (event) {
        event.preventDefault();
        var numb = $('.number_record .numb');
        var paginate = parseInt(numb.val());

        if ($(event.currentTarget).hasClass('btn_up')) {
          paginate += 5;
        }

        if ($(event.currentTarget).hasClass('btn_down')) {
          if (paginate - 5 > 0) {
            paginate -= 5;
          } else {
            paginate = 0;
          }
        }

        numb.val(paginate);
        BDashboard.loadWidget($(event.currentTarget).closest('.portlet').find('.portlet-body'), $(event.currentTarget).closest('.widget_item').attr('data-url'), {
          paginate: paginate
        });
      });
      $('#hide-widget-confirm-bttn').on('click', function (event) {
        event.preventDefault();
        var name = $(event.currentTarget).data('id');
        $.ajax({
          type: 'GET',
          cache: false,
          url: route('dashboard.hide_widget', {
            name: name
          }),
          success: function success(res) {
            if (!res.error) {
              $('#' + name).fadeOut();
              Botble.showSuccess(res.message);
            } else {
              Botble.showError(res.message);
            }

            $('#hide_widget_modal').modal('hide');
            var portlet = $(event.currentTarget).closest('.portlet');

            if ($(document).hasClass('page-portlet-fullscreen')) {
              $(document).removeClass('page-portlet-fullscreen');
            }

            portlet.find('.portlet-title .fullscreen').tooltip('destroy');
            portlet.find('.portlet-title .tools > .reload').tooltip('destroy');
            portlet.find('.portlet-title .tools > .remove').tooltip('destroy');
            portlet.find('.portlet-title .tools > .config').tooltip('destroy');
            portlet.find('.portlet-title .tools > .collapse, .portlet > .portlet-title .tools > .expand').tooltip('destroy');
            portlet.remove();
          },
          error: function error(data) {
            Botble.handleError(data);
          }
        });
      });
      $(document).on('click', '.portlet:not(.widget-load-has-callback) > .portlet-title .tools > a.reload', function (event) {
        event.preventDefault();
        BDashboard.loadWidget($(event.currentTarget).closest('.portlet').find('.portlet-body'), $(event.currentTarget).closest('.widget_item').attr('data-url'));
      });
      $(document).on('click', '.portlet > .portlet-title .tools > .collapse, .portlet .portlet-title .tools > .expand', function (event) {
        event.preventDefault();

        var _self = $(event.currentTarget);

        var state = $.trim(_self.data('state'));

        if (state === 'expand') {
          _self.closest('.portlet').find('.portlet-body').removeClass('collapse').addClass('expand');

          BDashboard.loadWidget(_self.closest('.portlet').find('.portlet-body'), _self.closest('.widget_item').attr('data-url'));
        } else {
          _self.closest('.portlet').find('.portlet-body').removeClass('expand').addClass('collapse');
        }

        $.ajax({
          type: 'POST',
          cache: false,
          url: route('dashboard.edit_widget_setting_item'),
          data: {
            name: _self.closest('.widget_item').prop('id'),
            setting_name: 'state',
            setting_value: state
          },
          success: function success() {
            if (state === 'collapse') {
              _self.data('state', 'expand');
            } else {
              _self.data('state', 'collapse');
            }
          },
          error: function error(data) {
            Botble.handleError(data);
          }
        });
      });
      var manage_widget_modal = $('#manage_widget_modal');
      $(document).on('click', '.manage-widget', function (event) {
        event.preventDefault();
        manage_widget_modal.modal('show');
      });
      manage_widget_modal.on('change', '.swc_wrap input', function (event) {
        $(event.currentTarget).closest('section').find('i').toggleClass('widget_none_color');
      });
    }
  }], [{
    key: "loadWidget",
    value: function loadWidget(el, url, data, callback) {
      Botble.blockUI({
        target: el,
        iconOnly: true,
        overlayColor: 'none'
      });

      if (typeof data === 'undefined') {
        data = {};
      }

      $.ajax({
        type: 'GET',
        cache: false,
        url: url,
        data: data,
        success: function success(res) {
          Botble.unblockUI(el);

          if (!res.error) {
            el.html(res.data);

            if (typeof callback !== 'undefined') {
              callback();
            }

            if (el.find('.scroller').length !== 0) {
              Botble.callScroll(el.find('.scroller'));
            }

            $('.equal-height').equalHeights();
            BDashboard.initSortable();
          } else {
            el.html('<div class="dashboard_widget_msg col-12"><p>' + res.message + '</p>');
          }
        },
        error: function error(res) {
          Botble.unblockUI(el);
          Botble.handleError(res);
        }
      });
    }
  }, {
    key: "initSortable",
    value: function initSortable() {
      if ($('#list_widgets').length > 0) {
        var el = document.getElementById('list_widgets');
        Sortable.create(el, {
          group: 'widgets',
          // or { name: "...", pull: [true, false, clone], put: [true, false, array] }
          sort: true,
          // sorting inside list
          delay: 0,
          // time in milliseconds to define when the sorting should start
          disabled: false,
          // Disables the sortable if set to true.
          store: null,
          // @see Store
          animation: 150,
          // ms, animation speed moving items when sorting, `0` — without animation
          handle: '.portlet-title',
          ghostClass: 'sortable-ghost',
          // Class name for the drop placeholder
          chosenClass: 'sortable-chosen',
          // Class name for the chosen item
          dataIdAttr: 'data-id',
          forceFallback: false,
          // ignore the HTML5 DnD behaviour and force the fallback to kick in
          fallbackClass: 'sortable-fallback',
          // Class name for the cloned DOM Element when using forceFallback
          fallbackOnBody: false,
          // Appends the cloned DOM Element into the Document's Body
          scroll: true,
          // or HTMLElement
          scrollSensitivity: 30,
          // px, how near the mouse must be to an edge to start scrolling.
          scrollSpeed: 10,
          // px
          // dragging ended
          onEnd: function onEnd() {
            var items = [];
            $.each($('.widget_item'), function (index, widget) {
              items.push($(widget).prop('id'));
            });
            $.ajax({
              type: 'POST',
              cache: false,
              url: route('dashboard.update_widget_order'),
              data: {
                items: items
              },
              success: function success(res) {
                if (!res.error) {
                  Botble.showSuccess(res.message);
                } else {
                  Botble.showError(res.message);
                }
              },
              error: function error(data) {
                Botble.handleError(data);
              }
            });
          }
        });
      }
    }
  }]);

  return BDashboard;
}();

$(document).ready(function () {
  new BDashboard().init();
  window.BDashboard = BDashboard;
});
/******/ })()
;