import json
import jwt as pyjwt
import requests

class CFJwtValidator:
    PUBLIC_KEY_PATH = "/cdn-cgi/access/certs"

    def decode(self, jwt: str, key: str, aud: str):
        if not key:
            return pyjwt.decode(jwt, verify=False)
        else:
            return pyjwt.decode(jwt, key, audience=aud, algorithms=['RS256'])

    def getPublicKey(self, base_url: str):
        res = requests.get(base_url + CFJwtValidator.PUBLIC_KEY_PATH)
        if res.status_code != requests.codes.ok:
            return None

        data = res.json()
        return data['public_cert']['cert']
