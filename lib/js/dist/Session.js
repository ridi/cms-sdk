'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

exports.default = function (option) {
    var store = null;
    if (option.couchbaseConfig) {
        var CouchbaseStore = (0, _connectCouchbase2.default)(_expressSession2.default);
        store = new CouchbaseStore(option.couchbaseConfig);
    }

    return (0, _expressSession2.default)({
        store: store,
        secret: option.secret,
        cookie: { maxAge: option.maxAge }
    });
};

var _expressSession = require('express-session');

var _expressSession2 = _interopRequireDefault(_expressSession);

var _connectCouchbase = require('connect-couchbase');

var _connectCouchbase2 = _interopRequireDefault(_connectCouchbase);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }