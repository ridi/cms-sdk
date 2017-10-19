import 'babel-polyfill';
import AuthCheck from './AuthCheck';
import { expect } from 'chai';

describe('AuthCheck', function () {
    it('tests if userAuth includes test url', function () {
        const userAuths = {
            'menuAuths': [
                { id: 9,
                    menu_url: '/super/logs',
                    menu_deep: 1,
                    is_use: true,
                    is_show: true,
                    ajax_array: [],
                    auth: [] }
            ]
        };
        const testUrl = '/super/logs';
        expect(AuthCheck(userAuths, '', testUrl)).to.equal(true);
    });
});