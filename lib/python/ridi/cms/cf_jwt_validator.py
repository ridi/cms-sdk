import json
import jwt as pyjwt
from jwt.exceptions import PyJWTError
import requests
from ridi.cms.thrift.Errors.ttypes import *            

class CFJwtValidator:
    PUBLIC_KEY_PATH = "/cdn-cgi/access/certs"

    def decode(self, jwt: str, keys: list, aud: str):
        if not keys:
            print('Skip jwt verification')
            return pyjwt.decode(jwt, verify=False)

        for key in keys:
            try:
                return pyjwt.decode(jwt, key, audience=aud, algorithms=['RS256'])
            except:
                pass
        raise MalformedTokenException(message='Invalid Cloudflare JWT')

    def getPublicKeys(self, base_url: str):
        res = requests.get(base_url + CFJwtValidator.PUBLIC_KEY_PATH)
        if res.status_code != requests.codes.ok:
            return None

        jwk_set = res.json()
        public_keys = []
        for key_dict in jwk_set['keys']:
            public_key = pyjwt.algorithms.RSAAlgorithm.from_jwk(json.dumps(key_dict))
            public_keys.append(public_key)
        return public_keys
