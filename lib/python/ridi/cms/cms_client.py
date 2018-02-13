# -*- coding: utf-8 -*-

from urllib.parse import quote_plus
from thrift.transport import THttpClient
from thrift.protocol import TMultiplexedProtocol
from thrift.protocol import TJSONProtocol
from ridi.cms.thrift.AdminAuth import AdminAuthService
from ridi.cms.thrift.AdminMenu import AdminMenuService
from ridi.cms.thrift.AdminTag import AdminTagService
from ridi.cms.thrift.AdminUser import AdminUserService
from ridi.cms.login_session import LoginSession
from ridi.cms.config import Config

def _createProtocol(service_name, config: Config):
    client = THttpClient.THttpClient(config.RPC_URL)
    client.setCustomHeaders({'Accept' : 'application/x-thrift'})
    protocol = TJSONProtocol.TJSONProtocol(client)
    protocol = TMultiplexedProtocol.TMultiplexedProtocol(protocol, service_name)
    return protocol

class AdminAuth(AdminAuthService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminAuth', config))

    def shouldRedirectForLogin(self, login_session: LoginSession) -> bool:
        token_info = login_session.requestTokenIntrospect()
        return not token_info or not 'user_id' in token_info

    def authorizeUrl(self, check_url, login_session: LoginSession) -> bool:
        return self.hasHashAuth(None, check_url, login_session.getAdminId())

    def getLoginUrl(self, return_url: str = None) -> str:
        param = '?return_url=%s' % quote_plus(return_url) if return_url else ''
        return '/login' + param

    def authorize(self, login_session: LoginSession, check_url) -> bool:
        return not self.shouldRedirectForLogin(login_session) and \
            self.authorizeUrl(check_url, login_session)

class AdminMenu(AdminMenuService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminMenu', config))

class AdminTag(AdminTagService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminTag', config))

class AdminUser(AdminUserService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminUser', config))
