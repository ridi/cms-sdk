import { assert } from 'chai';
import CmsSession from '../../lib/Session/CmsSession';

describe('CmsSession', () => {
  it('gets authenticated menus from the php session', () => {
    const cmsSession = new CmsSession('', null);
    // php-unserialize package read php array as js object.
    cmsSession.session = {
      session_user_auth: [{
        ajax_array: { k1: 'j1', k2: 'j2' },
        auth: { k1: 'a1' },
      }],
    };

    assert.deepEqual(cmsSession.getUserMenuAuths(), [{
      ajax_array: ['j1', 'j2'],
      auth: ['a1'],
    }]);
  });
});
