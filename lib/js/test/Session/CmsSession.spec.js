import { expect } from 'chai';
import CmsSession from '../../lib/Session/CmsSession';

describe('CmsSession', () => {
  it('requests token introspect', (done) => {
    const session = new CmsSession();
    session.requestTokenIntrospect('admin.ridibooks.com', 'test')
      .then((data) => {
        console.log(data);
        done();
      }).catch((e) => {
        done(e);
      });
  });
});
