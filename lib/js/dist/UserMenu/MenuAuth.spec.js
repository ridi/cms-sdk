'use strict';

require('babel-polyfill');

var _MenuAuth = require('./MenuAuth');

var _MenuAuth2 = _interopRequireDefault(_MenuAuth);

var _chai = require('chai');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

describe('MenuAuth', function () {
    it('tests if MenuAuth includes test url', function () {
        var userMenu = {
            'auths': [{ id: 9,
                menu_url: '/super/logs',
                menu_deep: 1,
                is_use: true,
                is_show: true,
                ajax_array: [],
                auth: [] }]
        };
        var testUrl = '/super/logs';
        (0, _chai.expect)((0, _MenuAuth2.default)(userMenu, '', testUrl)).to.equal(true);
    });
});