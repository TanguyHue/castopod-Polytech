<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entities\Oauth;
use App\Models\OAuthModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services as Services;
use Modules\Auth\Controllers\LoginController;

class AuthController extends BaseController
{
    protected Podcast $podcast;

    private Oauth $oauth;

    private string $email;

    public function addOAuth(): RedirectResponse
    {
        $url = $this->request->getPost('nextcloudUrl');
        $idClient = $this->request->getPost('nextcloudId');
        $secret = $this->request->getPost('nextcloudSecret');
        $redirectUri = $this->request->getPost('nextcloudRedirectUri');

        $this->setParams($url, $idClient, $secret, $redirectUri);

        return redirect()
            ->back()
            ->with('success', 'Paramètres enregistrés');
    }

    public function removeOAuth(): RedirectResponse
    {
        service('settings')->set('Nextcloud.nextcloudActive', false);
        unset($_SESSION['AT']);
        unset($_SESSION['RT']);

        (new OAuthModel())->truncate();

        return redirect()
            ->back()
            ->with('success', 'Paramètres supprimés');
    }

    public function setParams(string $url, string $idClient, string $secret, string $redirectUri): void
    {
        service('settings')->set('Nextcloud.nextcloudActive', true);

        service('settings')
            ->set('Nextcloud.nextcloudUrl', $url);
        service('settings')
            ->set('Nextcloud.nextcloudIdClient', $idClient);
        service('settings')
            ->set('Nextcloud.nextcloudSecret', $secret);
        service('settings')
            ->set('Nextcloud.nextcloudRedirectUri', $redirectUri);
    }

    public function authenticate(): RedirectResponse
    {
        if (! isset($this->oauth)) {
            $this->oauth = new Oauth(
                service('settings')
                    ->get('Nextcloud.nextcloudUrl'),
                service('settings')
                    ->get('Nextcloud.nextcloudIdClient'),
                service('settings')
                    ->get('Nextcloud.nextcloudSecret'),
                service('settings')
                    ->get('Nextcloud.nextcloudRedirectUri'),
            );
        }

        if (! empty(Services::request()->getGet('error'))) {
            $_SESSION['tets'] = 'test1';
            exit('Got error: ' . htmlspecialchars(Services::request()->getGet('error'), ENT_QUOTES, 'UTF-8'));
        }

        if (empty(Services::request()->getGet('code'))) {
            $_SESSION['tets'] = 'test';
            $provider = $this->oauth->getProvider();
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            $_SESSION['authUrl'] = 'http://localhost:8090' . $authUrl;
            header('Location: http://localhost:8090' . $authUrl);
            exit;
        }

        if (empty(Services::request()->getGet('state')) || (Services::request()->getGet(
            'state'
        ) !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        }

        $code = Services::request()->getGet('code');

        $_SESSION['code'] = $code;
        $this->oauth->getFirstToken($code);

        $this->email = $this->oauth->getEmail();

        if (isset($_SESSION['redirectLink'])) {
            $idUser = $_SESSION['user']['id'];
            $link = $_SESSION['redirectLink'];
            unset($_SESSION['redirectLink']);

            if ($this->getUserEmail($idUser) === '' && $this->getUserId() === 0) {
                $this->insert($idUser);

                $this->oauth->getToken();

                $_SESSION['RT'] = $this->oauth->getRefreshToken();
                $_SESSION['AT'] = $this->oauth->getAccessToken();

                $this->oauth->setRefreshTokenDatabase();

                return redirect()->route($link)
                    ->withInput()
                    ->with('success', 'compte associé');
            }

            unset($_SESSION['RT']);
            unset($_SESSION['AT']);

            return redirect()->route($link)
                ->withInput()
                ->with('error', 'compte déjà associé');
        }

        $idUser = $this->getUserId();
        if ($idUser === 0) {
            return redirect()->route('login')
                ->withInput()
                ->with('error', 'pas de compte associé');
        }

        $_SESSION['test'] = 'bb';

        (new LoginController())->loginActionOAuth($idUser, $this->email);

        $_SESSION['test'] = 'cc';

        $this->oauth->getToken();

        $_SESSION['RT'] = $this->oauth->getRefreshToken();
        $_SESSION['AT'] = $this->oauth->getAccessToken();

        $this->oauth->setRefreshTokenDatabase();

        return redirect()->to(config('Auth')->loginRedirect())
            ->withCookies();
    }

    public function connectWithToken(string $token = ''): string
    {
        if (! isset($this->oauth)) {
            $this->oauth = new Oauth(
                service('settings')
                    ->get('Nextcloud.nextcloudUrl'),
                service('settings')
                    ->get('Nextcloud.nextcloudIdClient'),
                service('settings')
                    ->get('Nextcloud.nextcloudSecret'),
                service('settings')
                    ->get('Nextcloud.nextcloudRedirectUri'),
            );
        }

        $result = $this->oauth->getToken($token);
        if ($result === null) {
            return 'false';
        }

        $this->oauth->setRefreshTokenDatabase();

        $_SESSION['RT'] = $this->oauth->getRefreshToken();
        $_SESSION['AT'] = $this->oauth->getAccessToken();

        return $_SESSION['RT'];
    }

    public function import(string $path = 'config(Nextcloud::class)->nextcloudRedirectUri,'): string
    {
        if ($path === '$1') {
            $path = '/castopod';
        }
        if (! isset($this->oauth)) {
            $this->oauth = new Oauth(
                service('settings')
                    ->get('Nextcloud.nextcloudUrl'),
                service('settings')
                    ->get('Nextcloud.nextcloudIdClient'),
                service('settings')
                    ->get('Nextcloud.nextcloudSecret'),
                service('settings')
                    ->get('Nextcloud.nextcloudRedirectUri'),
            );
        }

        $result = $this->oauth->getToken();
        if ($result === null) {
            return 'erreur';
        }

        $this->oauth->setRefreshTokenDatabase();

        $foldersResponse = $this->oauth->getFolders(urlencode($path));
        $folders = json_decode($foldersResponse, true);

        if (isset($folders['ocs']['data']) && is_array($folders['ocs']['data'])) {
            $folderNames = array_map(function ($item) {
                return [
                    'name' => $item['file_target'],
                    'path' => $item['path'],
                ];
            }, $folders['ocs']['data']);
        } else {
            $folderNames = 'false';
        }

        $_SESSION['AT'] = $this->oauth->getAccessToken();
        $_SESSION['RT'] = $this->oauth->getRefreshToken();

        return view('episode/import', [
            'folders' => $folderNames,
            'api'     => $_SESSION['AT'],
            'host'    => $this->oauth->getHost(),
        ]);
    }

    public function getFolders(string $path): string
    {
        if (! isset($this->oauth)) {
            $this->oauth = new Oauth(
                service('settings')
                    ->get('Nextcloud.nextcloudUrl'),
                service('settings')
                    ->get('Nextcloud.nextcloudIdClient'),
                service('settings')
                    ->get('Nextcloud.nextcloudSecret'),
                service('settings')
                    ->get('Nextcloud.nextcloudRedirectUri'),
            );
        }

        $result = $this->oauth->getToken();
        if ($result === null) {
            return 'erreur';
        }

        $this->oauth->setRefreshTokenDatabase();

        $_SESSION['AT'] = $this->oauth->getAccessToken();
        $_SESSION['RT'] = $this->oauth->getRefreshToken();

        $_SESSION['path'] = urlencode('/castopod/' . $path);
        return $this->oauth->getFolders($_SESSION['path']);
    }

    public function syncAccount(): void
    {
        $_SESSION['redirectLink'] = Services::request()->getGet('redirectLink');

        $this->authenticate();
    }

    public function explore(string $path = '/'): string
    {
        // Obtenez la liste des dossiers
        $foldersResponse = $this->oauth->getFolders($path);

        // Obtenez la liste des fichiers
        $filesResponse = $this->oauth->getFiles($path);

        // Analysez les réponses JSON
        $folders = json_decode($foldersResponse, true);
        $files = json_decode($filesResponse, true);

        // Maintenant, vous pouvez afficher ces informations dans votre vue ou retourner la réponse sous forme de chaîne
        return view('explorer', [
            'folders' => $folders,
            'files'   => $files,
        ]);
    }

    public function deleteAccount(): RedirectResponse
    {
        $this->deleteWithEmail();
        return redirect()->back();
    }

    public function getUserId(): int
    {
        $query = (new OAuthModel())->where([
            'email' => $this->email,
        ])->first();
        if (isset($query['idUser'])) {
            return (int) $query['idUser'];
        }

        return 0;
    }

    public function getUserEmail(int $id): string
    {
        $query = (new OAuthModel())->where([
            'idUser' => $id,
        ])->first();
        if (isset($query['email'])) {
            return $query['email'];
        }

        return '';
    }

    public function insert(int $idUser): void
    {
        if (! isset($this->email)) {
            $this->email = $this->getUserEmail($_SESSION['user']['id']);
        }

        (new OAuthModel())->insert([
            'email'            => $this->email,
            'idUser'           => $idUser,
            'lastRefreshToken' => $this->oauth->getRefreshToken(),
        ]);
    }

    public function deleteWithEmail(): void
    {
        if (! isset($this->email)) {
            $this->email = $this->getUserEmail($_SESSION['user']['id']);
        }

        (new OAuthModel())->where([
            'email' => $this->email,
        ])->delete();

        unset($_SESSION['RT']);
        unset($_SESSION['AT']);
    }

    public function deleteWithId(int $idUser): void
    {
        (new OAuthModel())->where([
            'idUser' => $idUser,
        ])->delete();
    }
}
