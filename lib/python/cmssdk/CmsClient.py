# -*- coding: utf-8 -*-

from thrift import Thrift
from thrift.transport import THttpClient
from thrift.protocol import TMultiplexedProtocol
from thrift.protocol import TJSONProtocol
from cmssdk.AdminAuth import AdminAuthService
from cmssdk.AdminMenu import AdminMenuService
from cmssdk.AdminTag import AdminTagService
from cmssdk.AdminUser import AdminUserService
from cmssdk.LoginSession import LoginSession
from cmssdk.Config import Config

def _createProtocol(service_name, config: Config):
    client = THttpClient.THttpClient(config.RPC_URL)
    client.setCustomHeaders({'Accept' : 'application/x-thrift'})
    protocol = TJSONProtocol.TJSONProtocol(client)
    protocol = TMultiplexedProtocol.TMultiplexedProtocol(protocol, service_name)
    return protocol

class AdminAuth(AdminAuthService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminAuth', config))

    def shouldRedirectForLogin(self, login_session: LoginSession):
        token_info = login_session.requestTokenIntrospect()
        return token_info and 'user_id' in token_info

    def authorizeUrl(self, check_url, login_session: LoginSession):
        return self.hasHashAuth(null, check_url, login_session.getAdminId())

    def getLoginUrl(self, return_url: str = None):
        param = '?return_url=%s' % return_url if return_url else ''
        return '/login' + param

class AdminMenu(AdminMenuService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminMenu', config))

class AdminTag(AdminTagService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminTag', config))

class AdminUser(AdminUserService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminUser', config))
