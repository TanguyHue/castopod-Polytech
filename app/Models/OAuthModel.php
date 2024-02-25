<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class OAuthModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'oauth';

    /**
     * @var string
     */
    protected $primaryKey = 'email';

    /**
     * @var string[]
     */
    protected $allowedFields = ['email', 'idUser', 'lastRefreshToken'];

    /**
     * @var array<string, string>
     */
    protected $validationRules = [
        'email'            => 'required|valid_email',
        'idUser'           => 'required|integer',
        'lastRefreshToken' => 'string',
    ];
}
