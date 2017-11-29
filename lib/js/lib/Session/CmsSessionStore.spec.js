import { assert } from 'chai';
import CmsSessionStore from './CmsSessionStore';

describe('CmsSessionStore', () => {
  it('decodes php session', () => {
    const store = new CmsSessionStore();
    const session = 'session_admin_id|s:5:"admin"';
    assert.deepEqual(store.decodePhpSession(session), { session_admin_id: 'admin' });
  });
});
