<?php

declare(strict_types=1);

namespace App\Entities;

use App\Models\OAuthModel;
use Bahuma\OAuth2\Client\Provider\Nextcloud;
use Config\Services;

/**
 * @property string $url
 * @property string|null  $host
 * @property string $clientId
 * @property string $clientSecret
 * @property string $redirectUri
 * @property string $access_token
 * @property string $refreshToken
 * @property string $email
 */
class Oauth
{
    /**
     * @var string
     */
    private const grant_type = 'authorization_code';

    private string $refreshToken = '';

    private string $email = '';

    public function __construct(
        protected string $url,
        protected string $clientId,
        protected string $clientSecret,
        protected string $redirectUri,
    ) {
        $parsedUrl = parse_url($url);

        $this->url = $url;
        $this->host = isset($parsedUrl['host']) ? $parsedUrl['host'] : null;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
        $this->refreshToken = '';
        $this->access_token = '';
        $this->email = '';
    }

    public function setRefreshToken(string $code = ''): string | null
    {
        $this->refreshToken = $code;
        return $this->getToken();
    }

    public function getFirstToken(string $code = ''): string | null
    {
        if ($code === '') {
            if (Services::request()->getGet('code') === null) {
                $provider = $this->getProvider();

                $authUrl = 'http://localhost:8090' . $provider->getAuthorizationUrl();
                $_SESSION['oauth2state'] = $provider->getState();
                header('Location: ' . $authUrl);
                exit;
            }

            $code = Services::request()->getGet('code');
        }

        $token_url = $this->url . 'index.php/apps/oauth2/api/v1/token';

        $_SESSION['token_url'] = $token_url;

        $data = [
            'grant_type'    => self::grant_type,
            'code'          => $code,
            'redirect_uri'  => $this->redirectUri,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];

        $headers = ['Accept: application/json', 'Content-Type: application/json', 'Host: ' . $this->host];

        $ch = curl_init($token_url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        try {
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode === 200) {
                $data = json_decode($response, true);

                if (is_array($data)) {
                    $this->access_token = $data['access_token'];
                    $this->refreshToken = $data['refresh_token'];

                    $this->setRefreshTokenDatabase();
                    unset($_SESSION['erreur']);

                    return $this->refreshToken;
                }

                $_SESSION['erreur'] = 'Erreur lors de la récupération de l\'access_token.';
            } else {
                $_SESSION['erreur'] = $httpCode . ' : ' . $response;
            }
        } catch (\Exception $e) {
            $_SESSION['erreur'] = 'Erreur cURL getFirstToken : ';
        } finally {
            curl_close($ch);
        }

        return null;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getHost(): string | null
    {
        return $this->host;
    }

    public function getToken(string $token = ''): string | null
    {
        $token_url = $this->url . 'index.php/apps/oauth2/api/v1/token';

        if ($token !== '') {
            $this->refreshToken = $token;
        } else {
            $this->refreshToken = $this->getRefreshTokenDatabase();

            if ($this->refreshToken === '') {
                return null;
            }
        }

        $data = [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $this->refreshToken,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];

        $headers = ['Accept: application/json', 'Content-Type: application/json', 'Host: ' . $this->host];

        $ch = curl_init($token_url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        try {
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode === 200) {
                $data = json_decode($response, true);
                $_SESSION['test'] = $data;

                if (isset($data['access_token'])) {
                    $this->access_token = $data['access_token'];
                    $this->refreshToken = $data['refresh_token'];
                    unset($_SESSION['erreur']);

                    return $this->access_token;
                }

                $_SESSION['erreur'] = 'Erreur lors de la récupération de l\'access_token.';
            } else {
                $_SESSION['erreur'] = 'Erreur lors de la requête HTTP : ' . $httpCode;
            }
        } catch (\Exception $e) {
            $_SESSION['erreur'] = 'Erreur cURL getToken : ' . $e->getMessage() . PHP_EOL;
        } finally {
            curl_close($ch);
        }

        return null;
    }

    public function getProvider(): Nextcloud
    {
        return new Nextcloud([
            'url'          => $this->url,
            'clientId'     => $this->clientId,
            'clientSecret' => $this->clientSecret,
            'redirectUri'  => $this->redirectUri,
        ]);
    }

    public function getDataUser(): string | false
    {
        if ($this->access_token === null && $this->getFirstToken() === null) {
            return false;
        }

        $url = $this->url . 'ocs/v2.php/cloud/user?format=json';

        $headers = ['Authorization: Bearer ' . $this->access_token];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        try {
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode === 200) {
                $data = json_decode($response, true);

                if (isset($data['ocs']['data']) && is_array($data['ocs']['data'])) {
                    $response = $data['ocs']['data'];
                    return json_encode($response);
                }
            }
        } catch (\Exception $e) {
            $_SESSION['erreur'] = 'Erreur cURL getDataUser : ' . $e->getMessage() . PHP_EOL;
        } finally {
            curl_close($ch);
        }

        return false;
    }

    public function getData(string $url): string | false
    {
        if ($this->access_token === null && $this->getFirstToken() === null) {
            return false;
        }

        $this->getToken();

        $fullUrl = $this->url . $url;

        $headers = ['Authorization: Bearer ' . $this->access_token];

        $ch = curl_init($fullUrl);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        try {
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode === 200) {
                $data = json_decode($response, true);

                if (is_array($data)) {
                    return json_encode($data);
                }
            }
        } catch (\Exception $e) {
            $_SESSION['erreur'] = 'Erreur cURL getData : ' . $e->getMessage() . PHP_EOL;
        } finally {
            curl_close($ch);
        }

        return false;
    }

    public function getFiles(string $path = '/castopod'): string | false
    {
        $url = $this->url . 'ocs/v2.php/apps/files_sharing/api/v1/shares';
        $query = [
            'subfiles' => 'true',
            'path'     => $path,
            'format'   => 'json',
        ];

        $headers = ['Authorization: Bearer ' . $this->access_token, 'Host: ' . $this->host];

        $url .= '?' . http_build_query($query);

        $_SESSION['url'] = $url;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        try {
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode === 200) {
                $data = json_decode($response, true);

                if (is_array($data)) {
                    unset($_SESSION['erreur']);
                    return json_encode($data);
                }
                $_SESSION['erreur'] = 'Erreur lors de la récupération des fichiers.';
            } else {
                $_SESSION['erreur'] = 'Erreur lors de la requête HTTP : ' . $httpCode;
            }
        } catch (\Exception $e) {
            $_SESSION['erreur'] = 'Erreur cURL getFiles : ' . $e->getMessage() . PHP_EOL;
        } finally {
            curl_close($ch);
        }

        return false;
    }

    public function getFolders(string $path): string | false
    {
        if ($this->access_token === null && $this->getFirstToken() === null) {
            return false;
        }

        $url = $this->url . 'ocs/v2.php/apps/files_sharing/api/v1/shares?path=' . $path . '&subfiles=true&format=json';
        $_SESSION['url'] = $url;

        $headers = [
            'Authorization: Bearer ' . $this->access_token,
            'Host: ' . $this->host,
            'OCS-APIRequest: true',
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        try {
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode === 200) {
                $data = json_decode($response, true);
                $_SESSION['test'] = $data;

                if (is_array($data)) {
                    return json_encode($data);
                }
            }
        } catch (\Exception $e) {
            $_SESSION['erreur'] = 'Erreur cURL getFolders : ' . $e->getMessage() . PHP_EOL;
        } finally {
            curl_close($ch);
        }

        return false;
    }

    public function checkToken(): bool
    {
        if ($this->access_token === null) {
            return $this->getFirstToken() !== null;
        }

        return $this->getToken() !== null;
    }

    public function getInformation(): string | false
    {
        $data = $this->getDataUser();

        if ($data === false) {
            return false;
        }

        $data = json_decode($data, true);

        return $data['displayname'] . ' (' . $data['email'] . ')';
    }

    public function getEmail(): string
    {
        if ($this->email !== '') {
            return $this->email;
        }

        $data = $this->getDataUser();

        if ($data === false) {
            return '';
        }

        $data = json_decode($data, true);

        return $data['email'];
    }

    public function getDisplayName(): string | false
    {
        $data = $this->getDataUser();

        if ($data === false) {
            return false;
        }

        $data = json_decode($data, true);

        return $data['displayname'];
    }

    public function setRefreshTokenDatabase(): bool
    {
        if ($this->email === '') {
            $this->email = $this->getEmail();
        }

        (new OAuthModel())->where([
            'email' => $this->email,
        ])->set([
            'lastRefreshToken' => $this->refreshToken,
        ])->update();

        return true;
    }

    public function getRefreshTokenDatabase(): string
    {
        $query = (new OAuthModel())->where([
            'idUser' => $_SESSION['user']['id'],
        ])->first();

        if (isset($query['lastRefreshToken'])) {
            return $query['lastRefreshToken'];
        }

        return '';
    }
}
