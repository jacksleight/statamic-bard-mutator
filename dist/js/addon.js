/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/Marks.js":
/*!*******************************!*\
  !*** ./resources/js/Marks.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Bold": () => (/* binding */ Bold),
/* harmony export */   "Code": () => (/* binding */ Code),
/* harmony export */   "Italic": () => (/* binding */ Italic),
/* harmony export */   "Link": () => (/* binding */ Link),
/* harmony export */   "Strike": () => (/* binding */ Strike),
/* harmony export */   "Subscript": () => (/* binding */ Subscript),
/* harmony export */   "Superscript": () => (/* binding */ Superscript),
/* harmony export */   "Underline": () => (/* binding */ Underline)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _get() { if (typeof Reflect !== "undefined" && Reflect.get) { _get = Reflect.get; } else { _get = function _get(target, property, receiver) { var base = _superPropBase(target, property); if (!base) return; var desc = Object.getOwnPropertyDescriptor(base, property); if (desc.get) { return desc.get.call(arguments.length < 3 ? target : receiver); } return desc.value; }; } return _get.apply(this, arguments); }

function _superPropBase(object, property) { while (!Object.prototype.hasOwnProperty.call(object, property)) { object = _getPrototypeOf(object); if (object === null) break; } return object; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

var extensions = Statamic.$bard.tiptap.extensions;
var Bold = /*#__PURE__*/function (_extensions$Bold) {
  _inherits(Bold, _extensions$Bold);

  var _super = _createSuper(Bold);

  function Bold() {
    _classCallCheck(this, Bold);

    return _super.apply(this, arguments);
  }

  _createClass(Bold, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Bold.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, _get(_getPrototypeOf(Bold.prototype), "commands", this).call(this, data), data);
    }
  }]);

  return Bold;
}(extensions.Bold);
var Code = /*#__PURE__*/function (_extensions$Code) {
  _inherits(Code, _extensions$Code);

  var _super2 = _createSuper(Code);

  function Code() {
    _classCallCheck(this, Code);

    return _super2.apply(this, arguments);
  }

  _createClass(Code, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Code.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, _get(_getPrototypeOf(Code.prototype), "commands", this).call(this, data), data);
    }
  }]);

  return Code;
}(extensions.Code);
var Italic = /*#__PURE__*/function (_extensions$Italic) {
  _inherits(Italic, _extensions$Italic);

  var _super3 = _createSuper(Italic);

  function Italic() {
    _classCallCheck(this, Italic);

    return _super3.apply(this, arguments);
  }

  _createClass(Italic, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Italic.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, _get(_getPrototypeOf(Italic.prototype), "commands", this).call(this, data), data);
    }
  }]);

  return Italic;
}(extensions.Italic);
var Link = /*#__PURE__*/function (_extensions$Link) {
  _inherits(Link, _extensions$Link);

  var _super4 = _createSuper(Link);

  function Link() {
    _classCallCheck(this, Link);

    return _super4.apply(this, arguments);
  }

  _createClass(Link, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Link.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, _get(_getPrototypeOf(Link.prototype), "commands", this).call(this, data), data);
    }
  }]);

  return Link;
}(extensions.Link);
var Strike = /*#__PURE__*/function (_extensions$Strike) {
  _inherits(Strike, _extensions$Strike);

  var _super5 = _createSuper(Strike);

  function Strike() {
    _classCallCheck(this, Strike);

    return _super5.apply(this, arguments);
  }

  _createClass(Strike, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Strike.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, _get(_getPrototypeOf(Strike.prototype), "commands", this).call(this, data), data);
    }
  }]);

  return Strike;
}(extensions.Strike);
var Subscript = /*#__PURE__*/function (_extensions$Subscript) {
  _inherits(Subscript, _extensions$Subscript);

  var _super6 = _createSuper(Subscript);

  function Subscript() {
    _classCallCheck(this, Subscript);

    return _super6.apply(this, arguments);
  }

  _createClass(Subscript, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Subscript.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, _get(_getPrototypeOf(Subscript.prototype), "commands", this).call(this, data), data);
    }
  }]);

  return Subscript;
}(extensions.Subscript);
var Superscript = /*#__PURE__*/function (_extensions$Superscri) {
  _inherits(Superscript, _extensions$Superscri);

  var _super7 = _createSuper(Superscript);

  function Superscript() {
    _classCallCheck(this, Superscript);

    return _super7.apply(this, arguments);
  }

  _createClass(Superscript, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Superscript.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, _get(_getPrototypeOf(Superscript.prototype), "commands", this).call(this, data), data);
    }
  }]);

  return Superscript;
}(extensions.Superscript);
var Underline = /*#__PURE__*/function (_extensions$Underline) {
  _inherits(Underline, _extensions$Underline);

  var _super8 = _createSuper(Underline);

  function Underline() {
    _classCallCheck(this, Underline);

    return _super8.apply(this, arguments);
  }

  _createClass(Underline, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Underline.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, _get(_getPrototypeOf(Underline.prototype), "commands", this).call(this, data), data);
    }
  }]);

  return Underline;
}(extensions.Underline);

/***/ }),

/***/ "./resources/js/Mutator.js":
/*!*********************************!*\
  !*** ./resources/js/Mutator.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Mutator)
/* harmony export */ });
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utilities */ "./resources/js/utilities.js");
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

    _defineProperty(this, "extensions", {});

    _defineProperty(this, "registered", []);

    _defineProperty(this, "schemaMutators", {});

    _defineProperty(this, "commandsMutators", {});

    this.extensions = extensions;
  }

  _createClass(Mutator, [{
    key: "schema",
    value: function schema(type, callback) {
      this.registerType(type);
      this.schemaMutators[type].push(callback);
      return this;
    }
  }, {
    key: "getSchemaMutators",
    value: function getSchemaMutators(type) {
      return this.schemaMutators[type] || [];
    }
  }, {
    key: "mutateSchema",
    value: function mutateSchema(type, schema) {
      var mutators = this.getSchemaMutators(type);

      if (!mutators.length) {
        return schema;
      }

      var _iterator = _createForOfIteratorHelper(mutators),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var mutator = _step.value;
          schema = mutator(schema, {
            extendSchema: _utilities__WEBPACK_IMPORTED_MODULE_0__.extendSchema
          });
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      return schema;
    }
  }, {
    key: "commands",
    value: function commands(type, callback) {
      this.registerType(type);
      this.commandsMutators[type].push(callback);
      return this;
    }
  }, {
    key: "getCommandsMutators",
    value: function getCommandsMutators(type) {
      return this.commandsMutators[type] || [];
    }
  }, {
    key: "mutateCommands",
    value: function mutateCommands(type, data, commands) {
      var mutators = this.getCommandsMutators(type);

      if (!mutators.length) {
        return commands;
      }

      var _iterator2 = _createForOfIteratorHelper(mutators),
          _step2;

      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var mutator = _step2.value;
          commands = mutator(data, commands, {
            extendCommands: function extendCommands() {
              for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
                args[_key] = arguments[_key];
              }

              return _utilities__WEBPACK_IMPORTED_MODULE_0__.extendCommands.apply(void 0, [type].concat(args));
            }
          });
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }

      return commands;
    }
  }, {
    key: "registerType",
    value: function registerType(type) {
      var _this = this;

      if (this.registered.includes(type)) {
        return;
      }

      this.registered.push(type);
      this.schemaMutators[type] = [];
      this.commandsMutators[type] = [];

      if (this.extensions[type]) {
        Statamic.$bard.replaceExtension(type, function (_ref) {
          var extension = _ref.extension;
          return new _this.extensions[type](extension.options);
        });
      }
    }
  }]);

  return Mutator;
}();



/***/ }),

/***/ "./resources/js/Nodes.js":
/*!*******************************!*\
  !*** ./resources/js/Nodes.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Blockquote": () => (/* binding */ Blockquote),
/* harmony export */   "BulletList": () => (/* binding */ BulletList),
/* harmony export */   "CodeBlock": () => (/* binding */ CodeBlock),
/* harmony export */   "HardBreak": () => (/* binding */ HardBreak),
/* harmony export */   "Heading": () => (/* binding */ Heading),
/* harmony export */   "HorizontalRule": () => (/* binding */ HorizontalRule),
/* harmony export */   "Image": () => (/* binding */ Image),
/* harmony export */   "ListItem": () => (/* binding */ ListItem),
/* harmony export */   "OrderedList": () => (/* binding */ OrderedList),
/* harmony export */   "Paragraph": () => (/* binding */ Paragraph),
/* harmony export */   "Table": () => (/* binding */ Table),
/* harmony export */   "TableCell": () => (/* binding */ TableCell),
/* harmony export */   "TableHeader": () => (/* binding */ TableHeader),
/* harmony export */   "TableRow": () => (/* binding */ TableRow)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _get() { if (typeof Reflect !== "undefined" && Reflect.get) { _get = Reflect.get; } else { _get = function _get(target, property, receiver) { var base = _superPropBase(target, property); if (!base) return; var desc = Object.getOwnPropertyDescriptor(base, property); if (desc.get) { return desc.get.call(arguments.length < 3 ? target : receiver); } return desc.value; }; } return _get.apply(this, arguments); }

function _superPropBase(object, property) { while (!Object.prototype.hasOwnProperty.call(object, property)) { object = _getPrototypeOf(object); if (object === null) break; } return object; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

var _Statamic$$bard$tipta = Statamic.$bard.tiptap,
    core = _Statamic$$bard$tipta.core,
    extensions = _Statamic$$bard$tipta.extensions;
var Blockquote = /*#__PURE__*/function (_extensions$Blockquot) {
  _inherits(Blockquote, _extensions$Blockquot);

  var _super = _createSuper(Blockquote);

  function Blockquote() {
    _classCallCheck(this, Blockquote);

    return _super.apply(this, arguments);
  }

  _createClass(Blockquote, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Blockquote.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(Blockquote.prototype), "commands", this).call(this, data));
    }
  }]);

  return Blockquote;
}(extensions.Blockquote);
var BulletList = /*#__PURE__*/function (_extensions$BulletLis) {
  _inherits(BulletList, _extensions$BulletLis);

  var _super2 = _createSuper(BulletList);

  function BulletList() {
    _classCallCheck(this, BulletList);

    return _super2.apply(this, arguments);
  }

  _createClass(BulletList, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(BulletList.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(BulletList.prototype), "commands", this).call(this, data));
    }
  }]);

  return BulletList;
}(extensions.BulletList);
var CodeBlock = /*#__PURE__*/function (_extensions$CodeBlock) {
  _inherits(CodeBlock, _extensions$CodeBlock);

  var _super3 = _createSuper(CodeBlock);

  function CodeBlock() {
    _classCallCheck(this, CodeBlock);

    return _super3.apply(this, arguments);
  }

  _createClass(CodeBlock, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(CodeBlock.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(CodeBlock.prototype), "commands", this).call(this, data));
    }
  }]);

  return CodeBlock;
}(extensions.CodeBlock);
var HardBreak = /*#__PURE__*/function (_extensions$HardBreak) {
  _inherits(HardBreak, _extensions$HardBreak);

  var _super4 = _createSuper(HardBreak);

  function HardBreak() {
    _classCallCheck(this, HardBreak);

    return _super4.apply(this, arguments);
  }

  _createClass(HardBreak, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(HardBreak.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(HardBreak.prototype), "commands", this).call(this, data));
    }
  }]);

  return HardBreak;
}(extensions.HardBreak);
var Heading = /*#__PURE__*/function (_extensions$Heading) {
  _inherits(Heading, _extensions$Heading);

  var _super5 = _createSuper(Heading);

  function Heading() {
    _classCallCheck(this, Heading);

    return _super5.apply(this, arguments);
  }

  _createClass(Heading, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Heading.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(Heading.prototype), "commands", this).call(this, data));
    }
  }]);

  return Heading;
}(extensions.Heading);
var HorizontalRule = /*#__PURE__*/function (_extensions$Horizonta) {
  _inherits(HorizontalRule, _extensions$Horizonta);

  var _super6 = _createSuper(HorizontalRule);

  function HorizontalRule() {
    _classCallCheck(this, HorizontalRule);

    return _super6.apply(this, arguments);
  }

  _createClass(HorizontalRule, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(HorizontalRule.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(HorizontalRule.prototype), "commands", this).call(this, data));
    }
  }]);

  return HorizontalRule;
}(extensions.HorizontalRule);
var Image = /*#__PURE__*/function (_extensions$Image) {
  _inherits(Image, _extensions$Image);

  var _super7 = _createSuper(Image);

  function Image() {
    _classCallCheck(this, Image);

    return _super7.apply(this, arguments);
  }

  _createClass(Image, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Image.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(Image.prototype), "commands", this).call(this, data));
    }
  }]);

  return Image;
}(extensions.Image);
var ListItem = /*#__PURE__*/function (_extensions$ListItem) {
  _inherits(ListItem, _extensions$ListItem);

  var _super8 = _createSuper(ListItem);

  function ListItem() {
    _classCallCheck(this, ListItem);

    return _super8.apply(this, arguments);
  }

  _createClass(ListItem, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(ListItem.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(ListItem.prototype), "commands", this).call(this, data));
    }
  }]);

  return ListItem;
}(extensions.ListItem);
var OrderedList = /*#__PURE__*/function (_extensions$OrderedLi) {
  _inherits(OrderedList, _extensions$OrderedLi);

  var _super9 = _createSuper(OrderedList);

  function OrderedList() {
    _classCallCheck(this, OrderedList);

    return _super9.apply(this, arguments);
  }

  _createClass(OrderedList, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(OrderedList.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(OrderedList.prototype), "commands", this).call(this, data));
    }
  }]);

  return OrderedList;
}(extensions.OrderedList);
var Paragraph = /*#__PURE__*/function (_core$Paragraph) {
  _inherits(Paragraph, _core$Paragraph);

  var _super10 = _createSuper(Paragraph);

  function Paragraph() {
    _classCallCheck(this, Paragraph);

    return _super10.apply(this, arguments);
  }

  _createClass(Paragraph, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Paragraph.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(Paragraph.prototype), "commands", this).call(this, data));
    }
  }]);

  return Paragraph;
}(core.Paragraph);
var Table = /*#__PURE__*/function (_extensions$Table) {
  _inherits(Table, _extensions$Table);

  var _super11 = _createSuper(Table);

  function Table() {
    _classCallCheck(this, Table);

    return _super11.apply(this, arguments);
  }

  _createClass(Table, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(Table.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(Table.prototype), "commands", this).call(this, data));
    }
  }]);

  return Table;
}(extensions.Table);
var TableCell = /*#__PURE__*/function (_extensions$TableCell) {
  _inherits(TableCell, _extensions$TableCell);

  var _super12 = _createSuper(TableCell);

  function TableCell() {
    _classCallCheck(this, TableCell);

    return _super12.apply(this, arguments);
  }

  _createClass(TableCell, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(TableCell.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(TableCell.prototype), "commands", this).call(this, data));
    }
  }]);

  return TableCell;
}(extensions.TableCell);
var TableHeader = /*#__PURE__*/function (_extensions$TableHead) {
  _inherits(TableHeader, _extensions$TableHead);

  var _super13 = _createSuper(TableHeader);

  function TableHeader() {
    _classCallCheck(this, TableHeader);

    return _super13.apply(this, arguments);
  }

  _createClass(TableHeader, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(TableHeader.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(TableHeader.prototype), "commands", this).call(this, data));
    }
  }]);

  return TableHeader;
}(extensions.TableHeader);
var TableRow = /*#__PURE__*/function (_extensions$TableRow) {
  _inherits(TableRow, _extensions$TableRow);

  var _super14 = _createSuper(TableRow);

  function TableRow() {
    _classCallCheck(this, TableRow);

    return _super14.apply(this, arguments);
  }

  _createClass(TableRow, [{
    key: "schema",
    get: function get() {
      return BardMutator.mutator.mutateSchema(this.name, _get(_getPrototypeOf(TableRow.prototype), "schema", this));
    }
  }, {
    key: "commands",
    value: function commands(data) {
      return BardMutator.mutator.mutateCommands(this.name, data, _get(_getPrototypeOf(TableRow.prototype), "commands", this).call(this, data));
    }
  }]);

  return TableRow;
}(extensions.TableRow);

/***/ }),

/***/ "./resources/js/utilities.js":
/*!***********************************!*\
  !*** ./resources/js/utilities.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "normalizeSchema": () => (/* binding */ normalizeSchema),
/* harmony export */   "normalizeParseDOM": () => (/* binding */ normalizeParseDOM),
/* harmony export */   "normalizeToDOMValue": () => (/* binding */ normalizeToDOMValue),
/* harmony export */   "extendSchema": () => (/* binding */ extendSchema),
/* harmony export */   "normalizeCommands": () => (/* binding */ normalizeCommands),
/* harmony export */   "extendCommands": () => (/* binding */ extendCommands)
/* harmony export */ });
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var normalizeSchema = function normalizeSchema(schema) {
  if (!schema.attrs) {
    schema.attrs = {};
  }

  return schema;
};
var normalizeParseDOM = function normalizeParseDOM(parseDOM) {
  parseDOM.forEach(function (parseDOMItem) {
    if (!parseDOMItem.getAttrs) {
      parseDOMItem.getAttrs = function () {
        return {};
      };
    }
  });
  return parseDOM;
};
var normalizeToDOMValue = function normalizeToDOMValue(value) {
  if (!value[1] || !_.isPlainObject(value[1])) {
    value.splice(1, 0, {});
  }

  return value;
};
var extendSchema = function extendSchema(schema, _ref) {
  var attrs = _ref.attrs,
      parseDOMAttrs = _ref.parseDOMAttrs,
      toDOMAttrs = _ref.toDOMAttrs;
  normalizeSchema(schema);

  if (attrs) {
    Object.assign(schema.attrs, attrs);
  }

  if (parseDOMAttrs) {
    var parseDOM = normalizeParseDOM(schema.parseDOM);
    parseDOM.forEach(function (parseDOMItem) {
      var current = parseDOMItem.getAttrs;

      parseDOMItem.getAttrs = function (dom) {
        var value = current(dom);
        Object.assign(value, parseDOMAttrs(dom));
        return value;
      };
    });
  }

  if (toDOMAttrs) {
    var toDOM = schema.toDOM;
    var current = toDOM;

    schema.toDOM = function (node) {
      var value = normalizeToDOMValue(current(node));
      Object.assign(value[1], toDOMAttrs(node));
      return value;
    };
  }

  return schema;
};
var normalizeCommands = function normalizeCommands(name, commands) {
  if (typeof commands === 'function') {
    commands = _defineProperty({}, name, commands);
  }

  return commands;
};
var extendCommands = function extendCommands(name, commands, additional) {
  commands = normalizeCommands(name, commands);
  Object.assign(commands, additional);
  return commands;
};

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
/* harmony import */ var _Nodes_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Nodes.js */ "./resources/js/Nodes.js");
/* harmony import */ var _Marks_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Marks.js */ "./resources/js/Marks.js");
/* harmony import */ var _Mutator_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Mutator.js */ "./resources/js/Mutator.js");



var mutator = new _Mutator_js__WEBPACK_IMPORTED_MODULE_2__["default"]({
  blockquote: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.Blockquote,
  bullet_list: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.BulletList,
  code_block: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.CodeBlock,
  hard_break: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.HardBreak,
  heading: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.Heading,
  horizontal_rule: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.HorizontalRule,
  image: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.Image,
  list_item: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.ListItem,
  ordered_list: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.OrderedList,
  paragraph: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.Paragraph,
  table: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.Table,
  table_cell: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.TableCell,
  table_header: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.TableHeader,
  table_row: _Nodes_js__WEBPACK_IMPORTED_MODULE_0__.TableRow,
  bold: _Marks_js__WEBPACK_IMPORTED_MODULE_1__.Bold,
  code: _Marks_js__WEBPACK_IMPORTED_MODULE_1__.Code,
  italic: _Marks_js__WEBPACK_IMPORTED_MODULE_1__.Italic,
  link: _Marks_js__WEBPACK_IMPORTED_MODULE_1__.Link,
  strike: _Marks_js__WEBPACK_IMPORTED_MODULE_1__.Strike,
  subscript: _Marks_js__WEBPACK_IMPORTED_MODULE_1__.Subscript,
  superscript: _Marks_js__WEBPACK_IMPORTED_MODULE_1__.Superscript,
  underline: _Marks_js__WEBPACK_IMPORTED_MODULE_1__.Underline
});
window.BardMutator = {
  mutator: mutator
};
})();

/******/ })()
;