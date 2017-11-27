'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _couchbase = require('couchbase');

var _couchbase2 = _interopRequireDefault(_couchbase);

var _phpUnserialize = require('php-unserialize');

var _phpUnserialize2 = _interopRequireDefault(_phpUnserialize);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var CmsSessionStore = function () {
  function CmsSessionStore(couchbaseUri, bucketName) {
    _classCallCheck(this, CmsSessionStore);

    this.cluster = new _couchbase2.default.Cluster(couchbaseUri);
    this.bucket = this.cluster.openBucket(bucketName);
  }

  _createClass(CmsSessionStore, [{
    key: 'read',
    value: function read(key) {
      var _this = this;

      return new Promise(function (resolve, reject) {
        _this.bucket.get(key, function (err, res) {
          if (err == null && res) {
            resolve(res.value);
            return;
          }
          reject();
        });
      });
    }
  }, {
    key: 'write',
    value: function write(key, value, callback) {
      var _this2 = this;

      return new Promise(function (resolve, reject) {
        _this2.bucket.upsert(key, value, function (err, res) {
          if (err == null) {
            resolve();
            return;
          }
          reject();
        });
      });
    }
  }, {
    key: 'readCmsSession',
    value: function readCmsSession(key) {
      var _this3 = this;

      return new Promise(function (resolve, reject) {
        _this3.bucket.get(key, function (err, res) {
          if (err == null && res) {
            resolve(_this3.decodePhpSession(res.value));
            return;
          }
          reject();
        });
      });
    }
  }, {
    key: 'decodePhpSession',
    value: function decodePhpSession(data) {
      return _phpUnserialize2.default.unserializeSession(data);
    }
  }]);

  return CmsSessionStore;
}();

exports.default = CmsSessionStore;