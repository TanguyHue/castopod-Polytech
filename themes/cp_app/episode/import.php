<?= helper('page') ?>
<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= get_site_icon_url('ico') ?>" />
    <link rel="apple-touch-icon" href="<?= get_site_icon_url('180') ?>">
    <link rel="manifest" href="<?= route_to('webmanifest') ?>">
    <meta name="theme-color" content="<?= \App\Controllers\WebmanifestController::THEME_COLORS[service('settings')->get('App.theme')]['theme'] ?>">
    <script>
        // Check that service workers are supported
        if ('serviceWorker' in navigator) {
            // Use the window load event to keep the page load performant
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>

    <link rel='stylesheet' type='text/css' href='<?= route_to('themes-colors-css') ?>' />
    <?= service('vite')->asset('styles/index.css', 'css') ?>
    <?= service('vite')->asset('js/app.ts', 'js') ?>
    <title>Importation d'un fichier Nextcloud</title>
</head>

<body class="flex flex-col min-h-screen mx-auto bg-base theme-<?= service('settings')->get('App.theme') ?>">
    <?php if (auth()->loggedIn()) : ?>
        <?= $this->include('_admin_navbar') ?>
    <?php endif; ?>

    <header class="flex flex-col items-center">
        <h1 class="mx-auto mt-6 text-3xl font-bold text-center">Importer un fichier de Nextcloud</h1>
        <a href="<?= $_GET['lastUrl'] ?>" class="flex items-center justify-start mt-4 text-base text-gray-600 hover:text-gray-800">
            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Retour
        </a>
    </header>

    <main class="container flex-1 px-4 py-10 mx-auto">
        <div id="foldersContainer" class="max-w-md mx-auto mt-8"></div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Fonction pour effectuer la requête API
                function getFiles(path, folderElement) {
                    if (folderElement.classList.contains('loaded')) {
                        return;
                    }

                    folderElement.classList.add('loaded');

                    // Afficher le cercle de chargement à l'intérieur du sous-item
                    var spinner = document.createElement('div');
                    spinner.setAttribute('role', 'status');
                    spinner.className = 'mx-auto'; // Add mx-auto class to center the spinner horizontally
                    spinner.innerHTML = `
                        <svg aria-hidden="true" class="block w-8 h-8 mx-auto text-gray-200 animate-spin dark:text-gray-600 fill-green-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    `;

                    folderElement.appendChild(spinner);

                    var options = {
                        method: 'GET',
                    };

                    var $url = 'import' + path;
                    console.log($url);

                    fetch($url, options)
                        .then(response => {
                            if (!response.ok) {
                                console.error('Erreur lors de la requête API:', response.statusText);
                                throw new Error('Erreur lors de la requête API');
                            }
                            return response.text();
                        })
                        .then(responseText => {
                            const cleanText = responseText.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '')
                                .replace(/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/gi, '');

                            const jsonData = JSON.parse(cleanText);
                            const filesList = folderElement.querySelector('ul');

                            var count = 0;
                            
                            jsonData.ocs.data.forEach(file => {
                                if (file.mimetype.split('/')[0] === 'audio') {
                                    count++;
                                    const button = document.createElement('button');

                                    var lastPoint = file.file_target.lastIndexOf('.');
                                    var fileName = file.file_target.substring(0, lastPoint);
                                    button.textContent = fileName.substring(1);
                                    button.className = 'transition duration-300 bg-navigation hover:bg-green-900 text-white py-3 px-6 rounded mb-2 w-full';

                                    button.addEventListener('click', function() {
                                        var encodedUrl = encodeURI(file.url + '/download' + file.file_target);
                                        var encodedName = encodeURI(file.file_target.substring(1));
                                        window.location.href = '<?= $_GET['lastUrl'] ?>?url=' + encodeURIComponent(encodedUrl) + '&name=' + encodeURIComponent(encodedName);
                                    });


                                    const li = document.createElement('li');
                                    li.appendChild(button);
                                    filesList.appendChild(li);
                                }
                            });

                            if (count === 0) {
                                const li = document.createElement('li');
                                li.textContent = 'Aucun fichier audio trouvé';
                                filesList.appendChild(li);
                            }

                            spinner.remove();
                        })
                        .catch(error => {
                            console.error('Erreur lors de la requête API:', error);
                            spinner.remove();
                        });
                }

                var folders = <?php echo json_encode($folders); ?>;
                var foldersContainer = document.getElementById('foldersContainer');

                if(folders.length === 0) {
                    const p = document.createElement('p');
                    p.textContent = 'Aucun dossier/fichier trouvé';
                    foldersContainer.appendChild(p);
                }

                for (var i = 0; i < folders.length; i++) {
                    var folder = folders[i];
                    
                    if(folder.mimetype === 'httpd/unix-directory') {
                        (function(folder) {
                        var details = document.createElement('details');
                        var summary = document.createElement('summary');
                        summary.style.cursor = 'pointer';
                        summary.style.marginBottom = '0.5rem';
                        summary.textContent = folder.name.substring(1);
                        summary.className = 'summary-class'; // Add the desired class name here
                        details.appendChild(summary);
                        details.appendChild(document.createElement('ul'));

                        details.addEventListener('click', function() {
                            getFiles('/' + summary.textContent, this);
                        });

                        foldersContainer.appendChild(details);
                    })(folder);
                    } else {
                        if (folder.mimetype.split('/')[0] === 'audio') {
                            const button = document.createElement('button');

                            var lastPoint = folder.name.lastIndexOf('.');
                            var fileName = folder.name.substring(0, lastPoint);
                            button.textContent = fileName.substring(1);
                            button.className = 'transition duration-300 bg-navigation hover:bg-green-900 text-white py-3 px-6 rounded mb-2 w-full';

                            var encodedUrl = encodeURI(folder.url);
                            console.log(encodedUrl);
                            var encodeName = encodeURI(folder.name.substring(1));
                            console.log(encodeName);
                            
                            button.addEventListener('click', function() {
                                window.location.href = '<?= $_GET['lastUrl'] ?>?url=' + encodeURIComponent(encodedUrl) + '&name=' + encodeURIComponent(encodeName);
                            });

                            const li = document.createElement('li');
                            li.appendChild(button);
                            li.classList.add('list-none'); 
                            foldersContainer.appendChild(li);
                        }
                    }
                }
            });
        </script>
    </main>
</body>