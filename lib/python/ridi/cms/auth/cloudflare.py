from urllib.parse import quote_plus
from ridi.cms.login_session import LoginSession
from ridi.cms.auth.cf_jwt_validator import CFJwtValidator

class Cloudflare:
    def __init__(self, delegate, aud_tag):
        self.delegate = delegate
        self.jwt_validator = CFJwtValidator()
        self.aud = aud_tag

    def tokenIntrospect(self, jwt):
        key = jwt_validator.getPublicKey()
        return self.jwt_validator.decode(jwt, key, self.aud)

    def authorize(self, login_session: LoginSession, check_url: str) -> bool:
        raise NotImplementedError('Use authorizeByTag instead')

    def getAuthorizeUrl(self, return_url: str = None) -> str:
        '''Refresh token or Redirect to login page as neccessary.'''
        param = '?return_url=%s' % quote_plus(return_url) if return_url else ''
        return '/login' + param

    def authorizeByTag(self, token, tags) -> bool:
        self.tokenIntrospect(token)
        self.delegate.authorizeByTag('cloudflare', tags)
