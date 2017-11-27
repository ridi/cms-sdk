'use strict';

var _CmsSessionStore = require('./CmsSessionStore');

var _CmsSessionStore2 = _interopRequireDefault(_CmsSessionStore);

var _chai = require('chai');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

describe('CmsSessionStore', function () {
  it('decodes php session', function () {
    var store = new _CmsSessionStore2.default();
    var session = 'session_admin_id|s:5:"admin"';
    _chai.assert.deepEqual(store.decodePhpSession(session), { session_admin_id: 'admin' });
  });
});