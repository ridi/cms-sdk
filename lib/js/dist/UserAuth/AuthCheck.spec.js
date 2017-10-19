'use strict';

require('babel-polyfill');

var _AuthCheck = require('./AuthCheck');

var _AuthCheck2 = _interopRequireDefault(_AuthCheck);

var _chai = require('chai');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

describe('AuthCheck', function () {
    it('tests if userAuth includes test url', function () {
        var userAuths = {
            'menuAuths': [{ id: 9,
                menu_url: '/super/logs',
                menu_deep: 1,
                is_use: true,
                is_show: true,
                ajax_array: [],
                auth: [] }]
        };
        var testUrl = '/super/logs';
        (0, _chai.expect)((0, _AuthCheck2.default)(userAuths, '', testUrl)).to.equal(true);
    });
});