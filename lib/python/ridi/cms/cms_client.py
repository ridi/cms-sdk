# -*- coding: utf-8 -*-

from urllib.parse import quote_plus
from thrift.transport import THttpClient
from thrift.protocol import TMultiplexedProtocol
from thrift.protocol import TJSONProtocol
from ridi.cms.thrift.AdminAuth import AdminAuthService
from ridi.cms.thrift.AdminMenu import AdminMenuService
from ridi.cms.thrift.AdminTag import AdminTagService
from ridi.cms.thrift.AdminUser import AdminUserService
from ridi.cms.config import Config

def _createProtocol(service_name, config: Config):
    client = THttpClient.THttpClient(config.RPC_URL)
    client.setCustomHeaders({
        'Authorization': config.RPC_SECRET,
    })
    protocol = TJSONProtocol.TJSONProtocol(client)
    protocol = TMultiplexedProtocol.TMultiplexedProtocol(protocol, service_name)
    return protocol

class AdminAuth(AdminAuthService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminAuth', config))
        self.config = config

    def getAuthorizeUrl(self, return_url: str = None) -> str:
        param = '?return_url=%s' % quote_plus(return_url) if return_url else ''
        return '/login' + param

    def authorize(self, admin_id: str, check_url: str) -> bool:
        return self.hasHashAuth(None, check_url, admin_id)

class AdminMenu(AdminMenuService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminMenu', config))

class AdminTag(AdminTagService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminTag', config))

class AdminUser(AdminUserService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminUser', config))
