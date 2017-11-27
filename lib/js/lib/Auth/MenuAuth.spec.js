import 'babel-polyfill';
import MenuAuth from './MenuAuth';
import { assert } from 'chai';

describe('MenuAuth', () => {
  it('tests if MenuAuth includes test url', () => {
    const userMenu = {
      auths: [
        {
          id: 9,
          menu_url: '/super/logs',
          menu_deep: 1,
          is_use: true,
          is_show: true,
          ajax_array: [],
          auth: [],
        },
      ],
    };
    const testUrl = '/super/logs';
    assert(MenuAuth(userMenu, '', testUrl));
  });
});
