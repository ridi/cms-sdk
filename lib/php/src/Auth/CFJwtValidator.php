<?php
declare(strict_types=1);

namespace Ridibooks\Cms\Auth;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Ridibooks\Cms\Thrift\Errors\MalformedTokenException;

class CFJwtValidator
{
    const PUBLIC_KEY_PATH = "/cdn-cgi/access/certs";

    public function decodeJwt(string $jwt, ?string $key = null)
    {
        if (empty($key)) {
            $key = $this->getPublicKey();
        }
        try {
            $decoded = JWT::decode($jwt, $key, ['RS256']);
        } catch (\Firebase\JWT\ExpiredException |
                \Firebase\JWT\SignatureInvalidException $e) {
            throw new MalformedTokenException($e->getMessage());
        }

        return $decoded;
    }

    public function getPublicKey(string $base_url)
    {
        $url = $base_url . self::PUBLIC_KEY_PATH;
        $client = new Client();
        $response = $client->get($url);
        if ($response->getStatusCode() !== 200) {
            throw \Exception($response->getReasonPhrase());
        }
        $contents = (string)$response->getBody();

        $json = json_decode($contents);

        return $json->public_cert->cert;
    }
}
