import CmsSessionStore from './CmsSessionStore';
import { assert } from 'chai';

describe('CmsSessionStore', () => {
  it('decodes php session', () => {
    const store = new CmsSessionStore();
    const session = `session_admin_id|s:5:"admin"`;
    assert.deepEqual(store.decodePhpSession(session), { session_admin_id: 'admin' });
  });
});
