import { assert } from 'chai';
import MenuAuth from './MenuAuth';

describe('MenuAuth', () => {
  it('tests if MenuAuth includes test url', () => {
    const userAuths = [
      {
        id: 9,
        menu_url: '/super/logs',
        menu_deep: 1,
        is_use: true,
        is_show: true,
        ajax_array: [],
        auth: [],
      },
    ];
    const testUrl = '/super/logs';
    assert(MenuAuth(userAuths, '', testUrl));
  });
});
