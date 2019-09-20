import json
import jwt as pyjwt
from jwt.exceptions import PyJWTError
import requests
from ridi.cms.thrift.Errors.ttypes import *            

class CFJwtValidator:
    PUBLIC_KEY_PATH = "/cdn-cgi/access/certs"

    def decode(self, jwt: str, key: str, aud: str):
        try:
            if not key:
                payload = pyjwt.decode(jwt, verify=False)
            else:
                payload = pyjwt.decode(jwt, key, audience=aud, algorithms=['RS256'])
        except PyJWTError as e:
            raise MalformedTokenException(message='Invalid Cloudflare JWT')
        return payload

    def getPublicKey(self, base_url: str):
        res = requests.get(base_url + CFJwtValidator.PUBLIC_KEY_PATH)
        if res.status_code != requests.codes.ok:
            return None

        data = res.json()
        return data['public_cert']['cert']
