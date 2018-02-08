import LoginSession from '../lib/LoginSession';

describe('CmsSession', () => {
  it('requests token introspect', (done) => {
    const session = new LoginSession();
    session.requestTokenIntrospect('admin.ridibooks.com', 'test')
      .then((data) => {
        console.log(data);
        done();
      }).catch((e) => {
        done(e);
      });
  });
});
