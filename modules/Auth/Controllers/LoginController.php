<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Controllers\AuthController;
use App\Models\OAuthModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;
use Modules\Auth\Models\UserModel as User;
use Psr\Log\LoggerInterface;
use ViewThemes\Theme;

class LoginController extends ShieldLoginController
{
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);

        Theme::setTheme('auth');
    }

    /**
     * Attempts to log the user in with OAuth.
     */
    public function loginActionOAuth(int $user, string $email): RedirectResponse
    {
        $credentials['idUser'] = $user;
        $credentials['email'] = $email;

        $users = new User();
        $authenticator = new Session($users);

        /** @var User $user */
        $user = $users->findById($credentials['idUser']);

        if ($user === null) {
            return redirect()->route('login')
                ->withInput()
                ->with('error', 'pas de compte associé à cet email');
        }

        if ($user->isBanned()) {
            $this->user = null;

            return redirect()->route('login')
                ->withInput()
                ->with('error', $user->getBanMessage() ?? lang('Auth.bannedUser'));
        }

        $this->user = $user;
        $user->touchIdentity($user->getEmailIdentity());
        $authenticator->startUpAction('login', $user);

        $authenticator->startLogin($user);

        if (! $authenticator->hasAction()) {
            $authenticator->completeLogin($user);
        }

        $query = (new OAuthModel())->where([
            'idUser' => $user->id,
        ])->first();
        if (isset($query['lastRefreshToken'])) {
            (new AuthController())->connectWithToken($query['lastRefreshToken']);
        }

        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show')
                ->withCookies();
        }

        return redirect()->to(config('Auth')->loginRedirect())
            ->withCookies();
    }
}
