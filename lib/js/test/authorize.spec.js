import { assert } from 'chai';
import authorize from '../lib/authorize';

describe('authorize', () => {
  it('includes test url', () => {
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
    assert(authorize(userAuths, '', testUrl));
  });
});
