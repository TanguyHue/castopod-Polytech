<?php declare(strict_types=1);

helper('form');
?>

<?= $this->extend('_layout') ?>

<?= $this->section('title') ?>
<?= lang('MyAccount.info') ?>
<?= $this->endSection() ?>

<?= $this->section('pageTitle') ?>
<?= lang('MyAccount.info') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?= view('_partials/_user_info.php', [
    'user' => auth()
        ->user(),
]) ?>

<?php if(service('settings')->get('Nextcloud.nextcloudActive')): ?>
<div class="px-4 py-5">
    <dt class="text-sm font-medium leading-5 text-skin-muted">
    Compte Nextcloud
    </dt>
    <dd class="mt-1 text-sm leading-5">
        <?php if(isset($email)): ?>
            Compte associé avec <?= $email ?>.
            <button onclick="confirmDelete()" class="inline-flex items-center justify-center p-1 mb-4 ml-4 text-sm text-red-500 transition duration-300 rounded-lg bg-red-50 hover:text-red-900 hover:bg-red-100 dark:text-red-400 dark:bg-red-800 dark:hover:bg-red-700 dark:hover:text-white">
                Supprimer l'association
            </button>
            <script>
                function confirmDelete() {
                    if (confirm("Êtes-vous sûr de vouloir supprimer l'association ?")) {
                        document.location.href='<?= route_to('deleteAccount')?>';
                    }
                }
            </script>

            <br>

            <form action="<?= route_to('set-folder') ?>" method="POST" class="flex flex-col w-full max-w-xl gap-y-4" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <Forms.Section
                    title="Organisation du Nextcloud"
                    subtitle="Lors de la recherche des fichiers audios, Castopod va chercher dans un dossier
                    principale. Par défaut, il va chercher dans le dossier /castopod, mais vous pouvez
                    le modifier ici">
                
                
                <Forms.Field
                    label="Nom du dossier principal"
                    name="nextcloudFolder"
                    type="text"
                    required="true"
                    value="<?= service('settings')->get('Nextcloud.nextcloudFolder') ?>"
                    hint="Exemple : nomDossier/"
                />

                <Button 
                    variant="primary" 
                    type="submit" 
                    class="self-end"><?= lang('Settings.theme.submit') ?>
                </Button>

                </Forms.Section>
            </form>
        <?php else: ?>
            <a href="<?=
                route_to('syncAccount') . '?redirectLink=my-account'
            ?>" class="inline-flex items-center justify-center p-1 mb-4 text-sm text-gray-500 transition duration-300 rounded-lg bg-gray-50 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                <span class="w-full">Synchroniser son compte avec Nextcloud</span>
                <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        <?php endif; ?>
        <br>

        <p>Configuration actuelle du Nextcloud</p>

        <dl class="mt-2 space-y-4">
            <div class="justify-between">
                <dt class="text-sm font-medium leading-5 text-left text-skin-muted">
                    URL de Nextcloud
                </dt>
                <dd class="mt-1 text-sm leading-5 text-left text-skin-base">
                    <?= service('settings')->get('Nextcloud.nextcloudUrl') ?>
                </dd>
            </div>
            <div class="justify-between">
                <dt class="text-sm font-medium leading-5 text-left text-skin-muted">
                    Clé utilisateur
                </dt>
                <dd class="mt-1 text-sm leading-5 text-left text-skin-base">
                    <?= service('settings')->get('Nextcloud.nextcloudIdClient') ?>
                </dd>
            </div>
            <div class="justify-between">
                <dt class="text-sm font-medium leading-5 text-left text-skin-muted">
                    Clé secrète
                </dt>
                <dd class="mt-1 text-sm leading-5 text-left text-skin-base">
                    <span id="secretKey" style="display: none;">
                        <?= service('settings')->get('Nextcloud.nextcloudSecret') ?>
                    </span>
                    <button id="toggleButton" onclick="toggleSecretKey()">
                        Afficher la clé secrète
                    </button>
                </dd>
            </div>

            <script>
                function toggleSecretKey() {
                    var secretKey = document.getElementById("secretKey");
                    var button = document.getElementById("toggleButton");
                    if (secretKey.style.display === "none") {
                        secretKey.style.display = "inline";
                        button.innerText = "Masquer la clé secrète";
                    } else {
                        secretKey.style.display = "none";
                        button.innerText = "Afficher la clé secrète";
                    }
                }
            </script>
            <div class="justify-between">
                <dt class="text-sm font-medium leading-5 text-left text-skin-muted">
                    URL de redirection
                </dt>
                <dd class="mt-1 text-sm leading-5 text-left text-skin-base">
                    <?= service('settings')->get('Nextcloud.nextcloudRedirectUri') ?>
                </dd>
            </div>
        </dl>
        <br>
    </dd>

    <button onclick="confirmDelNextcloud()" class="inline-flex items-center justify-center p-1 text-sm text-red-500 transition duration-300 rounded-lg bg-red-50 hover:text-red-900 hover:bg-red-100 dark:text-red-400 dark:bg-red-800 dark:hover:bg-red-700 dark:hover:text-white">
        Supprimer l'association avec Nextcloud
    </button>
    <script>
        function confirmDelNextcloud() {
            if (confirm("Êtes-vous sûr de vouloir désactiver l'association avec Nextcloud ?")) {
                document.location.href='<?= route_to('del-params')?>';
            }
        }
    </script>
</div>

<?php else: ?>
<div class="px-4 py-5">
    <form action="<?= route_to('set-params') ?>" method="POST" class="flex flex-col w-full max-w-xl gap-y-4" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <Forms.Section
            title="Connexion Nextcloud"
            subtitle="Si vous avez activé la connexion OAuth sur Nextcloud, nous vous invitons à indiquer
            les informations de connexion données par Nextcloud juste ici.">
        
        
        <Forms.Field
            label="URL de Nextcloud"
            name="nextcloudUrl"
            type="url"
            required="true"
            value=""
            hint="Exemple : https://nextcloud.example.com/"
        />

        <Forms.Field
            label="Clé utilisateur"
            name="nextcloudId"
            type="text"
            required="true"
            value=""
        />

        <Forms.Field
            label="Clé secrète"
            name="nextcloudSecret"
            type="text"
            required="true"
            value=""
        />
        <Forms.Field
            label="URL de redirection"
            name="nextcloudRedirectUri"
            required="true"
            value="http://<?= $_SERVER['HTTP_HOST'] ?>/authenticate"
            hidden="true"
        />

        <p>Pour l'URL de redirection, veuillez indiquer cet URL sur Nextcloud : http://<?= $_SERVER['HTTP_HOST'] ?>/authenticate</p>

        <Button 
            variant="primary" 
            type="submit" 
            class="self-end"><?= lang('Settings.theme.submit') ?>
        </Button>

        </Forms.Section>
        
        </form>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
