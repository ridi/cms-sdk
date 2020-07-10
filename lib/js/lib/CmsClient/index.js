import thrift from 'thrift';
import url from 'url';
import AdminAuthService from './thrift/AdminAuthService';
import AdminMenuService from './thrift/AdminMenuService';
import AdminTagService from './thrift/AdminTagService';
import AdminUserService from './thrift/AdminUserService';
import ClientWrapper from './ClientWrapper';

class CmsClient {
  constructor(endpoint, secret) {
    const multiplexer = new thrift.Multiplexer();

    const urlObj = url.parse(endpoint || 'http://localhost');

    const cfHeaders = secret
      ? {
        'CF-Access-Client-Id': secret.split(',')[0],
        'CF-Access-Client-Secret': secret.split(',')[1],
      }
      : null;

    const connection = thrift.createHttpConnection(
      urlObj.hostname,
      urlObj.port,
      {
        path: urlObj.pathname,
        https: urlObj.protocol === 'https:',
        transport: thrift.TBufferedTransport,
        protocol: thrift.TJSONProtocol,
        headers: {
          Accept: 'application/x-thrift',
          'Content-Type': 'application/x-thrift',
          ...cfHeaders,
        },
      },
    );

    const authClient = multiplexer.createClient('AdminAuth', AdminAuthService, connection);
    this.auth = new ClientWrapper(authClient);

    const menuClient = multiplexer.createClient('AdminMenu', AdminMenuService, connection);
    this.menu = new ClientWrapper(menuClient);

    const tagClient = multiplexer.createClient('AdminTag', AdminTagService, connection);
    this.tag = new ClientWrapper(tagClient);

    const userClient = multiplexer.createClient('AdminUser', AdminUserService, connection);
    this.user = new ClientWrapper(userClient);
  }
}

export default CmsClient;
