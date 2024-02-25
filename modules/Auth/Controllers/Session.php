<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use CodeIgniter\Shield\Authentication\Authenticators\Session as ShieldSessionAuthenticator;
use Modules\Auth\Models\UserModel;

class Session extends ShieldSessionAuthenticator
{
    public function __construct(UserModel $provider)
    {
        parent::__construct($provider);
    }
}
