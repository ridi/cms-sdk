'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _UserAuthReader = require('./UserAuthReader');

var _UserAuthReader2 = _interopRequireDefault(_UserAuthReader);

var _AuthCheck = require('./AuthCheck');

var _AuthCheck2 = _interopRequireDefault(_AuthCheck);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var UserAuth = function () {
    function UserAuth() {
        _classCallCheck(this, UserAuth);
    }

    _createClass(UserAuth, [{
        key: 'readUserAuth',
        value: function readUserAuth(cmsClient, userId, isDev) {
            return new Promise(function (resolve, reject) {
                var res = (0, _UserAuthReader2.default)(cmsClient, userId, isDev);
                resolve(res);
            });
        }
    }, {
        key: 'hasUrlAuth',
        value: function hasUrlAuth(userAuth, method, checkUrl) {
            return new Promise(function (resolve, reject) {
                var res = (0, _AuthCheck2.default)(userAuth, method, checkUrl);
                resolve(res);
            });
        }
    }]);

    return UserAuth;
}();

exports.default = UserAuth;