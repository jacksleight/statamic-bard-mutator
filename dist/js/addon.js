/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/mixins/mutates-extension.js":
/*!**************************************************!*\
  !*** ./resources/js/mixins/mutates-extension.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  addAttributes: function addAttributes() {
    return BardMutator.mutator.mutate('addAttributes', this.name, this.parent());
  },
  addCommands: function addCommands() {
    return BardMutator.mutator.mutate('addCommands', this.name, this.parent());
  },
  parseHTML: function parseHTML() {
    return BardMutator.mutator.mutate('parseHTML', this.name, this.parent());
  },
  renderHTML: function renderHTML(params) {
    return BardMutator.mutator.mutate('renderHTML', this.name, this.parent(params), params);
  }
});

/***/ }),

/***/ "./resources/js/mutator.js":
/*!*********************************!*\
  !*** ./resources/js/mutator.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Mutator)
/* harmony export */ });
/* harmony import */ var _mixins_mutates_extension__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./mixins/mutates-extension */ "./resources/js/mixins/mutates-extension.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



var Mutator = /*#__PURE__*/function () {
  function Mutator(extensions) {
    _classCallCheck(this, Mutator);

    _defineProperty(this, "extensions", null);

    _defineProperty(this, "registered", []);

    _defineProperty(this, "mutators", {});

    this.extensions = extensions;
  }

  _createClass(Mutator, [{
    key: "mutator",
    value: function mutator(type, kind, callback) {
      // @todo multiple types
      this.registerType(type);

      if (!this.mutators[type]) {
        this.mutators[type] = [];
      }

      if (!this.mutators[type][kind]) {
        this.mutators[type][kind] = [];
      }

      this.mutators[type][kind].push(callback);
    }
  }, {
    key: "mutate",
    value: function mutate(kind, type, value) {
      var params = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : {};
      // @todo normalization
      var mutators = this.mutators[type] && this.mutators[type][kind] ? this.mutators[type][kind] : [];

      if (!mutators.length) {
        return value;
      }

      var _iterator = _createForOfIteratorHelper(mutators),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var mutator = _step.value;
          value = mutator(_objectSpread({
            type: type,
            value: value
          }, params));
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      return value;
    }
  }, {
    key: "registerType",
    value: function registerType(type) {
      if (this.registered.includes(type)) {
        return;
      }

      this.registered.push(type);

      if (this.extensions[type]) {
        Statamic.$bard.replaceExtension(type, function (_ref) {
          var extension = _ref.extension;
          return extension.extend(_mixins_mutates_extension__WEBPACK_IMPORTED_MODULE_0__["default"]);
        });
      }
    }
  }]);

  return Mutator;
}();



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
/*!*******************************!*\
  !*** ./resources/js/addon.js ***!
  \*******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mutator_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./mutator.js */ "./resources/js/mutator.js");

var mutator = new _mutator_js__WEBPACK_IMPORTED_MODULE_0__["default"]({
  blockquote: true,
  bullet_list: true,
  code_block: true,
  hard_break: true,
  heading: true,
  horizontal_rule: true,
  image: true,
  list_item: true,
  ordered_list: true,
  paragraph: true,
  table: true,
  table_cell: true,
  table_header: true,
  table_row: true,
  bold: true,
  code: true,
  italic: true,
  link: true,
  strike: true,
  subscript: true,
  superscript: true,
  underline: true
});
window.BardMutator = {
  mutator: mutator
};
})();

/******/ })()
;