/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./platform/core/base/resources/assets/js/ckeditor-upload-adapter.js":
/*!***************************************************************************!*\
  !*** ./platform/core/base/resources/assets/js/ckeditor-upload-adapter.js ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

/**
 * Upload file adapter for Botble ckeditor
 */
var CKEditorUploadAdapter = /*#__PURE__*/function () {
  /**
   * Creates a new adapter instance.
   *
   */
  function CKEditorUploadAdapter(loader, url, t) {
    _classCallCheck(this, CKEditorUploadAdapter);

    /**
     * FileLoader instance to use during the upload.
     *
     */
    this.loader = loader;
    /**
     * Upload URL.
     *
     * @member {String} #url
     */

    this.url = url;
    /**
     * Locale translation method.
     *
     */

    this.t = t;
  }
  /**
   * Starts the upload process.
   *
   * @returns {Promise.<Object>}
   */


  _createClass(CKEditorUploadAdapter, [{
    key: "upload",
    value: function upload() {
      var _this = this;

      return this.loader.file.then(function (file) {
        return new Promise(function (resolve, reject) {
          _this._initRequest();

          _this._initListeners(resolve, reject, file);

          _this._sendRequest(file);
        });
      });
    }
    /**
     * Aborts the upload process.
     *
     */

  }, {
    key: "abort",
    value: function abort() {
      if (this.xhr) {
        this.xhr.abort();
      }
    }
    /**
     * Initializes the XMLHttpRequest object.
     *
     * @private
     */

  }, {
    key: "_initRequest",
    value: function _initRequest() {
      var xhr = this.xhr = new XMLHttpRequest();
      xhr.open('POST', this.url, true);
      xhr.responseType = 'json';
    }
    /**
     * Initializes XMLHttpRequest listeners.
     *
     * @private
     * @param {Function} resolve Callback function to be called when the request is successful.
     * @param {Function} reject Callback function to be called when the request cannot be completed.
     * @param {File} file File instance to be uploaded.
     */

  }, {
    key: "_initListeners",
    value: function _initListeners(resolve, reject, file) {
      var xhr = this.xhr;
      var loader = this.loader;
      var t = this.t;
      var genericError = t('Cannot upload file:') + " ".concat(file.name, ".");
      xhr.addEventListener('error', function () {
        return reject(genericError);
      });
      xhr.addEventListener('abort', function () {
        return reject();
      });
      xhr.addEventListener('load', function () {
        var response = xhr.response;

        if (!response || !response.uploaded) {
          return reject(response && response.error && response.error.message ? response.error.message : genericError);
        }

        resolve({
          "default": response.url
        });
      }); // Upload progress when it's supported.

      /* istanbul ignore else */

      if (xhr.upload) {
        xhr.upload.addEventListener('progress', function (evt) {
          if (evt.lengthComputable) {
            loader.uploadTotal = evt.total;
            loader.uploaded = evt.loaded;
          }
        });
      }
    }
    /**
     * Prepares the data and sends the request.
     *
     * @private
     * @param {File} file File instance to be uploaded.
     */

  }, {
    key: "_sendRequest",
    value: function _sendRequest(file) {
      // Prepare form data.
      var data = new FormData();
      data.append('upload', file);
      data.append('_token', $('meta[name="csrf-token"]').attr('content')); // laravel token
      // Send request.

      this.xhr.send(data);
    }
  }]);

  return CKEditorUploadAdapter;
}();

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CKEditorUploadAdapter);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!**********************************************************!*\
  !*** ./platform/core/base/resources/assets/js/editor.js ***!
  \**********************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ckeditor_upload_adapter__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ckeditor-upload-adapter */ "./platform/core/base/resources/assets/js/ckeditor-upload-adapter.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }



var EditorManagement = /*#__PURE__*/function () {
  function EditorManagement() {
    _classCallCheck(this, EditorManagement);
  }

  _createClass(EditorManagement, [{
    key: "initCkEditor",
    value: function initCkEditor(element, extraConfig) {
      var _this = this;

      ClassicEditor.create(document.querySelector('#' + element), _objectSpread({
        fontSize: {
          options: [9, 11, 13, 'default', 17, 16, 18, 19, 21, 22, 23, 24]
        },
        heading: {
          options: [{
            model: 'paragraph',
            title: 'Paragraph',
            "class": 'ck-heading_paragraph'
          }, {
            model: 'heading1',
            view: 'h1',
            title: 'Heading 1',
            "class": 'ck-heading_heading1'
          }, {
            model: 'heading2',
            view: 'h2',
            title: 'Heading 2',
            "class": 'ck-heading_heading2'
          }, {
            model: 'heading3',
            view: 'h3',
            title: 'Heading 3',
            "class": 'ck-heading_heading3'
          }, {
            model: 'heading4',
            view: 'h4',
            title: 'Heading 4',
            "class": 'ck-heading_heading4'
          }]
        },
        placeholder: ' ',
        toolbar: {
          items: ['heading', '|', 'fontColor', 'fontSize', 'fontBackgroundColor', 'fontFamily', 'bold', 'italic', 'underline', 'link', 'strikethrough', 'bulletedList', 'numberedList', '|', 'codeBlock', 'outdent', 'indent', '|', 'htmlEmbed', 'imageInsert', 'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo', 'findAndReplace', 'removeFormat', 'sourceEditing']
        },
        language: 'en',
        image: {
          toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
        },
        table: {
          contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableCellProperties', 'tableProperties']
        }
      }, extraConfig)).then(function (editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
          return new _ckeditor_upload_adapter__WEBPACK_IMPORTED_MODULE_0__["default"](loader, RV_MEDIA_URL.media_upload_from_editor, editor.t);
        }; // create function insert html


        editor.insertHtml = function (html) {
          var viewFragment = editor.data.processor.toView(html);
          var modelFragment = editor.data.toModel(viewFragment);
          editor.model.insertContent(modelFragment);
        };

        window.editor = editor;
        _this.CKEDITOR[element] = editor;
        var minHeight = $('#' + element).prop('rows') * 90;
        var className = "ckeditor-".concat(element, "-inline");
        $(editor.ui.view.editable.element).addClass(className).after("\n                    <style>\n                        .ck-editor__editable_inline {\n                            min-height: ".concat(minHeight - 100, "px;\n                            max-height: ").concat(minHeight + 100, "px;\n                        }\n                    </style>\n                ")); // debounce content for ajax ne

        var timeout;
        editor.model.document.on('change:data', function () {
          clearTimeout(timeout);
          timeout = setTimeout(function () {
            editor.updateSourceElement();
          }, 150);
        }); // insert media embed

        editor.commands._commands.get("mediaEmbed").execute = function (url) {
          editor.insertHtml("[media url=\"".concat(url, "\"][/media]"));
        };
      })["catch"](function (error) {
        console.error(error);
      });
    }
  }, {
    key: "uploadImageFromEditor",
    value: function uploadImageFromEditor(blobInfo, callback) {
      var formData = new FormData();

      if (typeof blobInfo.blob === 'function') {
        formData.append('upload', blobInfo.blob(), blobInfo.filename());
      } else {
        formData.append('upload', blobInfo);
      }

      $.ajax({
        type: 'POST',
        data: formData,
        url: RV_MEDIA_URL.media_upload_from_editor,
        processData: false,
        contentType: false,
        cache: false,
        success: function success(res) {
          if (res.uploaded) {
            callback(res.url);
          }
        }
      });
    }
  }, {
    key: "initTinyMce",
    value: function initTinyMce(element) {
      var _this2 = this;

      tinymce.init({
        menubar: true,
        selector: '#' + element,
        min_height: $('#' + element).prop('rows') * 110,
        resize: 'vertical',
        plugins: 'code autolink advlist visualchars link image media table charmap hr pagebreak nonbreaking hanbiroclip anchor insertdatetime lists textcolor wordcount imagetools  contextmenu  visualblocks',
        extended_valid_elements: 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]',
        toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link image table | alignleft aligncenter alignright alignjustify  | numlist bullist indent  |  visualblocks code',
        convert_urls: false,
        image_caption: true,
        image_advtab: true,
        image_title: true,
        placeholder: '',
        contextmenu: 'link image inserttable | cell row column deletetable',
        images_upload_url: RV_MEDIA_URL.media_upload_from_editor,
        automatic_uploads: true,
        block_unsupported_drop: false,
        file_picker_types: 'file image media',
        images_upload_handler: this.uploadImageFromEditor.bind(this),
        file_picker_callback: function file_picker_callback(callback) {
          var $input = $('<input type="file" accept="image/*" />').click();
          $input.on('change', function (e) {
            _this2.uploadImageFromEditor(e.target.files[0], callback);
          });
        }
      });
    }
  }, {
    key: "initEditor",
    value: function initEditor(element, extraConfig, type) {
      if (!element.length) {
        return false;
      }

      var current = this;

      switch (type) {
        case 'ckeditor':
          $.each(element, function (index, item) {
            current.initCkEditor($(item).prop('id'), extraConfig);
          });
          break;

        case 'tinymce':
          $.each(element, function (index, item) {
            current.initTinyMce($(item).prop('id'));
          });
          break;
      }
    }
  }, {
    key: "init",
    value: function init() {
      var _this3 = this;

      var $ckEditor = $('.editor-ckeditor');
      var $tinyMce = $('.editor-tinymce');
      var current = this;

      if ($ckEditor.length > 0) {
        current.initEditor($ckEditor, {}, 'ckeditor');
      }

      if ($tinyMce.length > 0) {
        current.initEditor($tinyMce, {}, 'tinymce');
      }

      this.CKEDITOR = {};
      $(document).on('click', '.show-hide-editor-btn', function (event) {
        event.preventDefault();

        var _self = $(event.currentTarget);

        var $result = $('#' + _self.data('result'));

        if ($result.hasClass('editor-ckeditor')) {
          if (_this3.CKEDITOR[_self.data('result')] && typeof _this3.CKEDITOR[_self.data('result')] !== 'undefined') {
            _this3.CKEDITOR[_self.data('result')].destroy();

            _this3.CKEDITOR[_self.data('result')] = null;
            $('.editor-action-item').not('.action-show-hide-editor').hide();
          } else {
            current.initCkEditor(_self.data('result'), {}, 'ckeditor');
            $('.editor-action-item').not('.action-show-hide-editor').show();
          }
        } else if ($result.hasClass('editor-tinymce')) {
          tinymce.execCommand('mceToggleEditor', false, _self.data('result'));
        }
      });
      this.manageShortCode();
      return this;
    }
  }, {
    key: "manageShortCode",
    value: function manageShortCode() {
      var self = this;
      $('.list-shortcode-items li a').on('click', function (event) {
        var _this4 = this;

        event.preventDefault();

        if ($(this).data('has-admin-config') == '1') {
          $('.short-code-admin-config').html('');
          $('.short_code_modal').modal('show');
          $('.half-circle-spinner').show();
          $.ajax({
            type: 'GET',
            url: $(this).prop('href'),
            success: function success(res) {
              if (res.error) {
                Botble.showError(res.message);
                return false;
              }

              $('.short-code-data-form').trigger('reset');
              $('.short_code_input_key').val($(_this4).data('key'));
              $('.half-circle-spinner').hide();
              $('.short-code-admin-config').html(res.data);
              Botble.initResources();
              Botble.initMediaIntegrate();

              if ($(_this4).data('description') !== '' && $(_this4).data('description') != null) {
                $('.short_code_modal .modal-title strong').text($(_this4).data('description'));
              }
            },
            error: function error(data) {
              Botble.handleError(data);
            }
          });
        } else {
          if ($('.editor-ckeditor').length > 0) {
            self.CKEDITOR[$('.add_shortcode_btn_trigger').data('result')].insertHtml('[' + $(this).data('key') + '][/' + $(this).data('key') + ']');
          } else {
            tinymce.get($('.add_shortcode_btn_trigger').data('result')).execCommand('mceInsertContent', false, '[' + $(this).data('key') + '][/' + $(this).data('key') + ']');
          }
        }
      });

      $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
          if (o[this.name]) {
            if (!o[this.name].push) {
              o[this.name] = [o[this.name]];
            }

            o[this.name].push(this.value || '');
          } else {
            o[this.name] = this.value || '';
          }
        });
        return o;
      };

      $('.add_short_code_btn').on('click', function (event) {
        event.preventDefault();
        var formElement = $('.short_code_modal').find('.short-code-data-form');
        var formData = formElement.serializeObject();
        var attributes = '';
        $.each(formData, function (name, value) {
          var element = formElement.find('*[name="' + name + '"]');
          var shortcodeAttribute = element.data('shortcode-attribute');

          if ((!shortcodeAttribute || shortcodeAttribute !== 'content') && value) {
            name = name.replace('[]', '');

            if (Array.isArray(value)) {
              value.map(function (i, e) {
                attributes += ' ' + name + '_' + (e + 1) + '="' + i + '"';
              });
            } else {
              attributes += ' ' + name + '="' + value + '"';
            }
          }
        });
        var content = '';
        var contentElement = formElement.find('*[data-shortcode-attribute=content]');

        if (contentElement != null && contentElement.val() != null && contentElement.val() !== '') {
          content = contentElement.val();
        }

        var $shortCodeKey = $(this).closest('.short_code_modal').find('.short_code_input_key').val();

        if ($('.editor-ckeditor').length > 0) {
          self.CKEDITOR[$('.add_shortcode_btn_trigger').data('result')].insertHtml('<div>[' + $shortCodeKey + attributes + ']' + content + '[/' + $shortCodeKey + ']</div>');
        } else {
          tinymce.get($('.add_shortcode_btn_trigger').data('result')).execCommand('mceInsertContent', false, '<div>[' + $shortCodeKey + attributes + ']' + content + '[/' + $shortCodeKey + ']</div>');
        }

        $(this).closest('.modal').modal('hide');
      });
    }
  }]);

  return EditorManagement;
}();

$(document).ready(function () {
  window.EDITOR = new EditorManagement().init();
  window.EditorManagement = window.EditorManagement || EditorManagement;
});
})();

/******/ })()
;