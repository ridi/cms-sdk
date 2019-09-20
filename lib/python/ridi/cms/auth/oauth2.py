from urllib.parse import quote_plus
from ridi.cms.login_session import LoginSession

class OAuth2:
    def __init__(self, delegate):
        self.delegate = delegate

    def shouldRedirectForLogin(self, login_session: LoginSession) -> bool:
        token_info = login_session.requestTokenIntrospect()
        return not token_info or not 'user_id' in token_info

    def authorizeUrl(self, check_url, login_session: LoginSession) -> bool:
        return self.hasHashAuth(None, check_url, login_session.getAdminId())

    def authorize(self, login_session: LoginSession, check_url: str) -> bool:
        return not self.shouldRedirectForLogin(login_session) and \
                self.authorizeUrl(check_url, login_session)

    def getAuthorizeUrl(self, return_url: str = None) -> str:
        param = '?return_url=%s' % quote_plus(return_url) if return_url else ''
        return '/auth/oauth2/authorize' + param

    def authorizeByTag(self, token, tags) -> bool:
        self.delegate.authorizeByTag(token, tags)
