from ridi.cms.cf_jwt_validator import CFJwtValidator
from ridi.cms.config import Config
from ridi.cms.thrift.Errors.ttypes import *

COOKIE_CMS_TOKEN = 'CF_Authorization'

def _introspectJwt(token: str, config: Config) -> dict:
    if not token:
        raise NoTokenException()

    jwt = CFJwtValidator()
    key = jwt.getPublicKeys(config.CF_ACCESS_DOMAIN or config.RPC_URL)
    payload = jwt.decode(token, key, config.CF_AUDIENCE_TAG)
    if not payload:
        raise UnauthorizedException()

    return payload

def authenticate(token: str, config: Config) -> str:
    if config.TEST_ID:
        return config.TEST_ID

    payload = _introspectJwt(token, config)
    id = payload['email'].split('@')[0]
    return id
