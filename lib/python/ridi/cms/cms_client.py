# -*- coding: utf-8 -*-

from urllib.parse import quote_plus
from thrift.transport import THttpClient
from thrift.protocol import TMultiplexedProtocol
from thrift.protocol import TJSONProtocol
from ridi.cms.auth.cloudflare import Cloudflare as AuthCloudflare
from ridi.cms.auth.oauth2 import OAuth2 as AuthOAuth2
from ridi.cms.thrift.AdminAuth import AdminAuthService
from ridi.cms.thrift.AdminMenu import AdminMenuService
from ridi.cms.thrift.AdminTag import AdminTagService
from ridi.cms.thrift.AdminUser import AdminUserService
from ridi.cms.login_session import LoginSession
from ridi.cms.config import Config

def _createProtocol(service_name, config: Config):
    client = THttpClient.THttpClient(config.RPC_URL)
    protocol = TJSONProtocol.TJSONProtocol(client)
    protocol = TMultiplexedProtocol.TMultiplexedProtocol(protocol, service_name)
    return protocol

class AdminAuth(AdminAuthService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminAuth', config))
        self.config = config
        if (self.config.AUTH_TYPE == 'cloudflare'):
            self.auth = AuthCloudflare(super())
        else:
            self.auth = AuthOAuth2(super())

    def getLoginUrl(self, return_url: str = None) -> str:
        param = '?return_url=%s' % quote_plus(return_url) if return_url else ''
        return '/login' + param

    def getAuthorizeUrl(self, return_url: str = None) -> str:
        '''Refresh token or Redirect to login page as neccessary.'''
        self.auth.getAuthorizeUrl(return_url)

    def authorize(self, login_session: LoginSession, check_url: str) -> bool:
        self.auth.authorize(login_session, check_url)

    def authorizeByTag(self, token, tags) -> bool:
        self.auth.authorizeByTag(token, tags)

class AdminMenu(AdminMenuService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminMenu', config))

class AdminTag(AdminTagService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminTag', config))

class AdminUser(AdminUserService.Client):
    def __init__(self, config: Config):
        super().__init__(_createProtocol('AdminUser', config))
