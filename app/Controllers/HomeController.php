<?php

declare(strict_types=1);

/**
 * @copyright  2020 Ad Aures
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace App\Controllers;

use App\Models\PodcastModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Modules\Media\FileManagers\FileManagerInterface;

class HomeController extends BaseController
{
    public function index(): RedirectResponse | string
    {
        $db = db_connect();
        if ($db->getDatabase() === '' || ! $db->tableExists('podcasts')) {
            // Database has not been set or could not find the podcasts table
            // Redirecting to install page because it is likely that Castopod has not been installed yet.
            // NB: as base_url wouldn't have been defined here, redirect to install wizard manually
            $route = Services::routes()->reverseRoute('install');
            return redirect()->to(rtrim(host_url(), '/') . $route);
        }

        $sortOptions = ['activity', 'created_desc', 'created_asc'];
        $sortBy = in_array($this->request->getGet('sort'), $sortOptions, true) ? $this->request->getGet(
            'sort'
        ) : 'activity';

        $allPodcasts = (new PodcastModel())->getAllPodcasts($sortBy);

        // check if there's only one podcast to redirect user to it
        if (count($allPodcasts) === 1) {
            return redirect()->route('podcast-activity', [$allPodcasts[0]->handle]);
        }

        // default behavior: list all podcasts on home page
        $data = [
            'metatags' => get_home_metatags(),
            'podcasts' => $allPodcasts,
            'sortBy' => $sortBy,
        ];

        return view('home', $data);
    }

    public function health(): ResponseInterface
    {
        $errors = [];

        try {
            db_connect();
        } catch (DatabaseException) {
            $errors[] = 'Unable to connect to the database.';
        }

        // --- Can Castopod connect to the cache handler
        if (config('Cache')->handler !== 'dummy' && cache()->getCacheInfo() === null) {
            $errors[] = 'Unable connect to the cache handler.';
        }

        // --- Can Castopod write to storage?

        /** @var FileManagerInterface $fileManager */
        $fileManager = service('file_manager', false);

        if (! $fileManager->isHealthy()) {
            $errors[] = 'Problem with file manager.';
        }

        if ($errors !== []) {
            return $this->response->setStatusCode(503, 'Problem with cache handler.')
                ->setJSON([
                    'code' => 503,
                    'errors' => $errors,
                ]);
        }

        return $this->response->setStatusCode(200)
            ->setJSON([
                'code' => 200,
                'message' => '✨ All good!',
            ]);
    }
}
