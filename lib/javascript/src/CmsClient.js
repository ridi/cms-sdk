import thrift from 'thrift';
import url from 'url';
import AdminMenuService from '../lib/thrift/AdminMenuService';
import AdminTagService from '../lib/thrift/AdminTagService';
import AdminUserService from '../lib/thrift/AdminUserService';
import ClientWrapper from './ClientWrapper';

class CmsClient {
  constructor(endpoint = 'http://localhost') {
    const urlObj = url.parse(endpoint);
    const connection = thrift.createHttpConnection(urlObj.hostname, urlObj.port, {
      path: urlObj.pathname,
      https: urlObj.protocol === 'https:',
      transport: thrift.TBufferedTransport,
      protocol: thrift.TJSONProtocol,
      headers: {
        Accept: 'application/x-thrift',
      },
    });

    this.adminMenu = new ClientWrapper('AdminMenu', AdminMenuService, connection);
    this.adminTag = new ClientWrapper('AdminTag', AdminTagService, connection);
    this.adminUser = new ClientWrapper('AdminUser', AdminUserService, connection);
  }
}

export default CmsClient;
