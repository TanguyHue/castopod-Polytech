<?= $this->extend('_layout') ?>

<?= $this->section('title') ?>
<?= lang('Episode.create') ?>
<?= $this->endSection() ?>

<?= $this->section('pageTitle') ?>
<?= lang('Episode.create') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div id="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />


    <form action="<?= route_to('episode-create', $podcast->id) ?>" method="POST" enctype="multipart/form-data" class="flex flex-col w-full max-w-xl mt-6 gap-y-8" id="episode-form">
    <?= csrf_field() ?>

    <?php
    // Vérifier s'il y a une erreur, et dans ce cas l'afficher
    if (isset($_GET['error'])) {
        // Décoder la chaîne URL avant de la diviser
        $decodedError = urldecode($_GET['error']);

        // Diviser la chaîne en un tableau basé sur le caractère "+"
        $errorMessages = explode('+', $_GET['error']);

        // Supprimer les éléments vides du tableau
        $errorMessages = array_filter($errorMessages);

        // Afficher un div contenant un paragraphe pour chaque élément du tableau
        echo '<div class="flex flex-col gap-x-2 gap-y-4 md:flex-row">';
        echo '<fieldset class="flex flex-col items-start w-full p-8 bg-red-200 border-red-600 border-3 rounded-xl ">';
        foreach ($errorMessages as $errorMessage) {
            echo '<p> Erreur : ' . $errorMessage . '</p>';
        }
        echo '</fieldset>';
        echo '</div>';
    }

?>

    <Forms.Section title="<?= lang('Episode.form.info_section_title') ?>" >


<Forms.Section title="<?= lang('Episode.form.info_section_title') ?>">
        <?php if (! isset($audioFileLink)) : ?>
            <Forms.Field 
            name="audio_file" 
            label="<?= esc(lang('Episode.form.audio_file')) ?>" 
            hint="<?= esc(lang('Episode.form.audio_file_hint')) ?>" 
            helper="<?= esc(lang('Common.size_limit', [formatBytes(file_upload_max_size(), true)])) ?>" 
            type="file" 
            accept=".mp3,.m4a" 
            required="true" 
            data-max-size="<?= file_upload_max_size() ?>" 
            data-max-size-error="<?= lang('Episode.form.file_size_error', [formatBytes(file_upload_max_size(), true)]) ?>">
            </Forms.Field>

            <?php if (isset($_SESSION['AT'])) { ?>
                <a href="<?= route_to('episode-import', $podcast->id) ?>?lastUrl=<?php
                                                                                    $currentUrl = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
                $urlWithoutParams = strtok($currentUrl, '?');
                echo htmlspecialchars($urlWithoutParams); ?>" class="inline-flex items-center justify-center p-2 mb-4 text-sm text-gray-500 transition duration-300 rounded-lg bg-gray-50 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="w-full">Ajouter un fichier depuis Nextcloud</span>
                    <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            <?php } ?>
            <script>
                var audioFileLink = false;
            </script>
        <?php endif; ?>
        <?php if (isset($audioFileLink)) : ?>
            <input type="hidden" name="audio_file_link" value="<?= $audioFileLink ?>" />
            <p>Fichier sélectionné : <?= esc($audioName) ?></p>

            <a href="<?php
                        $currentUrl = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $urlWithoutParams = strtok($currentUrl, '?');
            echo htmlspecialchars($urlWithoutParams);
            ?>" class="inline-flex items-center justify-center p-2 mb-4 text-sm text-red-500 transition duration-300 rounded-lg bg-red-50 hover:text-red-900 hover:bg-red-100 dark:text-red-400 dark:bg-red-800 dark:hover:bg-red-700 dark:hover:text-white">
                <span class="w-full">Retirer le fichier</span>
                <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1L13 9M1 9L13 1" />
                </svg>
            </a>
            <script>
                var audioFileLink = true;
            </script>
        <?php endif; ?>


    <Forms.Field
        id="cover"
        name="cover"
        label="<?= lang('Episode.form.cover') ?>"
        hint="<?= lang('Episode.form.cover_hint') ?>"
        helper="<?= lang('Episode.form.cover_size_hint') ?>"
        type="file"
        accept=".jpg,.jpeg,.png"/>

    <div id="imagePreview" class="hidden"></div>

    <Forms.Field
        name="title"
        id="title"
        label="<?= lang('Episode.form.title') ?>"
        hint="<?= lang('Episode.form.title_hint') ?>"
        required="true"
        data-slugify="title" />

    <div>
        <Forms.Label for="slug"><?= lang('Episode.form.permalink') ?></Forms.Label>
        <permalink-edit class="inline-flex items-center w-full text-xs" edit-label="<?= lang('Common.edit') ?>" copy-label="<?= lang('Common.copy') ?>" copied-label="<?= lang('Common.copied') ?>" permalink-base="<?= url_to('podcast-episodes', $podcast->handle) ?>">
            <span slot="domain"><?= '…/' . esc($podcast->at_handle) . '/' ?></span>
            <Forms.Input name="slug" required="true" data-slugify="slug" slot="slug-input" class="flex-1 text-xs" />
        </permalink-edit>
    </div>

    <div class="flex flex-col gap-x-2 gap-y-4 md:flex-row">
        <Forms.Field
            class="flex-1 w-full"
            name="season_number"
            label="<?= lang('Episode.form.season_number') ?>"
            type="number"
            value="<?= $currentSeasonNumber ?>"
        />
        <Forms.Field
            class="flex-1 w-full"
            name="episode_number"
            label="<?= lang('Episode.form.episode_number') ?>"
            type="number"
            value="<?= $nextEpisodeNumber ?>"
            required="<?= $podcast->type === 'serial' ? 'true' : 'false' ?>"
        />
    </div>

    <fieldset class="flex gap-1">
    <legend><?= lang('Episode.form.type.label') ?></legend>
    <Forms.RadioButton
        value="full"
        name="type"
        hint="<?= lang('Episode.form.type.full_hint') ?>"
        isChecked="true" ><?= lang('Episode.form.type.full') ?></Forms.RadioButton>
    <Forms.RadioButton
        value="trailer"
        name="type"
        hint="<?= lang('Episode.form.type.trailer_hint') ?>"
        isChecked="false" ><?= lang('Episode.form.type.trailer') ?></Forms.RadioButton>    
    <Forms.RadioButton
        value="bonus"
        name="type"
        hint="<?= lang('Episode.form.type.bonus_hint') ?>"
        isChecked="false" ><?= lang('Episode.form.type.bonus') ?></Forms.RadioButton>
    </fieldset>

    <fieldset class="flex gap-1">
    <legend>
        <?= lang('Episode.form.parental_advisory.label') .
        hint_tooltip(lang('Episode.form.parental_advisory.hint'), 'ml-1') ?>
    </legend>
    <Forms.RadioButton
        value="undefined"
        name="parental_advisory"
        isChecked="true" ><?= lang('Episode.form.parental_advisory.undefined') ?></Forms.RadioButton>
    <Forms.RadioButton
        value="clean"
        name="parental_advisory"
        isChecked="false" ><?= lang('Episode.form.parental_advisory.clean') ?></Forms.RadioButton>    
    <Forms.RadioButton
        value="explicit"
        name="parental_advisory"
        isChecked="false" ><?= lang('Episode.form.parental_advisory.explicit') ?></Forms.RadioButton>
    </fieldset>



    </Forms.Section>


    <Forms.Section
        title="<?= lang('Episode.form.show_notes_section_title') ?>"
        subtitle="<?= lang('Episode.form.show_notes_section_subtitle') ?>">

    <Forms.Field
        as="MarkdownEditor"
        name="description"
        id="description"
        label="<?= lang('Episode.form.description') ?>"
        required="true"
        disallowList="header,quote" />

    <Forms.Field
        as="MarkdownEditor"
        name="description_footer"
        label="<?= lang('Episode.form.description_footer') ?>"
        hint="<?= lang('Episode.form.description_footer_hint') ?>"
        value="<?= esc($podcast->episode_description_footer_markdown) ?? '' ?>"
        disallowList="header,quote" />

    </Forms.Section>

    <Forms.Section title="<?= lang('Episode.form.premium_title') ?>">
        <Forms.Toggler class="mt-2" name="premium" value="yes" checked="<?= $podcast->is_premium_by_default ? 'true' : 'false' ?>">
            <?= lang('Episode.form.premium') ?></Forms.Toggler>
    </Forms.Section>

    <Forms.Section
        title="<?= lang('Episode.form.location_section_title') ?>"
        subtitle="<?= lang('Episode.form.location_section_subtitle') ?>"
    >
    <Forms.Field
        name="location_name"
        label="<?= lang('Episode.form.location_name') ?>"
        hint="<?= lang('Episode.form.location_name_hint') ?>" />
    </Forms.Section>

    <Forms.Section
        title="<?= lang('Episode.form.additional_files_section_title') ?>">

    <fieldset class="flex flex-col">
    <legend><?= lang('Episode.form.transcript') .
            '<small class="ml-1 lowercase">(' .
            lang('Common.optional') .
            ')</small>' .
            hint_tooltip(lang('Episode.form.transcript_hint'), 'ml-1') ?></legend>
    <div class="form-input-tabs">
        <input type="radio" name="transcript-choice" id="transcript-file-upload-choice" aria-controls="transcript-file-upload-choice" value="upload-file" <?= old('transcript-choice') !== 'remote-file' ? 'checked' : '' ?> />
        <label for="transcript-file-upload-choice"><?= lang('Common.forms.upload_file') ?></label>

        <input type="radio" name="transcript-choice" id="transcript-file-remote-url-choice" aria-controls="transcript-file-remote-url-choice" value="remote-url" <?= old('transcript-choice') === 'remote-file' ? 'checked' : '' ?> />
        <label for="transcript-file-remote-url-choice"><?= lang('Common.forms.remote_url') ?></label>

        <div class="py-2 tab-panels">
            <section id="transcript-file-upload" class="flex items-center tab-panel">
                <Forms.Label class="sr-only" for="transcript_file" isOptional="true"><?= lang('Episode.form.transcript_file') ?></Forms.Label>
                <Forms.Input class="w-full" name="transcript_file" type="file" accept=".txt,.html,.srt,.json" />
            </section>
            <section id="transcript-file-remote-url" class="tab-panel">
                <Forms.Label class="sr-only" for="transcript_remote_url" isOptional="true"><?= lang('Episode.form.transcript_remote_url') ?></Forms.Label>
                <Forms.Input class="w-full" placeholder="https://…" name="transcript_remote_url" />
            </section>
        </div>
    </div>
    </fieldset>


    <fieldset class="flex flex-col">
    <legend><?= lang('Episode.form.chapters') .
            '<small class="ml-1 lowercase">(' .
            lang('Common.optional') .
            ')</small>' .
            hint_tooltip(lang('Episode.form.chapters_hint'), 'ml-1') ?></legend>
    <div class="form-input-tabs">
        <input type="radio" name="chapters-choice" id="chapters-file-upload-choice" aria-controls="chapters-file-upload-choice" value="upload-file" <?= old('chapters-choice') !== 'remote-file' ? 'checked' : '' ?> />
        <label for="chapters-file-upload-choice"><?= lang('Common.forms.upload_file') ?></label>

        <input type="radio" name="chapters-choice" id="chapters-file-remote-url-choice" aria-controls="chapters-file-remote-url-choice" value="remote-url" <?= old('chapters-choice') === 'remote-file' ? 'checked' : '' ?> />
        <label for="chapters-file-remote-url-choice"><?= lang('Common.forms.remote_url') ?></label>

        <div class="py-2 tab-panels">
            <section id="chapters-file-upload" class="flex items-center tab-panel">
                <Forms.Label class="sr-only" for="chapters_file" isOptional="true"><?= lang('Episode.form.chapters_file') ?></Forms.Label>
                <Forms.Input class="w-full" name="chapters_file" type="file" accept=".json" />
            </section>
            <section id="chapters-file-remote-url" class="tab-panel">
                <Forms.Label class="sr-only" for="chapters_remote_url" isOptional="true"><?= lang('Episode.form.chapters_remote_url') ?></Forms.Label>
                <Forms.Input class="w-full" placeholder="https://…" name="chapters_remote_url" />
            </section>
        </div>
    </div>
    </fieldset>
    </Forms.Section>

    <Forms.Section
        title="<?= lang('Episode.form.advanced_section_title') ?>"
        subtitle="<?= lang('Episode.form.advanced_section_subtitle') ?>"
    >
    <Forms.Field 
        as="XMLEditor"
        name="custom_rss"
        label="<?= lang('Episode.form.custom_rss') ?>"
        hint="<?= lang('Episode.form.custom_rss_hint') ?>"
    />

    </Forms.Section>

    <Forms.Toggler name="block" value="yes" checked="false" hint="<?= lang('Episode.form.block_hint') ?>"><?= lang('Episode.form.block') ?></Forms.Toggler>

    <Forms.Toggler name="publish" value="yes" checked="false">Publier l'épisode directement</Forms.Toggler>

    <Button class="self-end" variant="primary" type="submit" id="submit-button"><?= lang('Episode.form.submit_create') ?></Button>

    </form>
</div>

<div role="status" id="loading-circle" class="fixed hidden top-1/2 left-1/2">
    <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
    </svg>
    <span class="sr-only">Loading...</span>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        var $uploadImage = document.getElementById('cover');
        var $imagePreview = document.getElementById('imagePreview');
        var croppie = new Croppie($imagePreview, {
            viewport: { width: 200, height: 200, type: 'square' },
            boundary: { width: 300, height: 300 },
        });

        $uploadImage.addEventListener('change', function () {
            $imagePreview.classList.remove('hidden');
            var reader = new FileReader();
            reader.onload = function (e) {
                croppie.bind({
                    url: e.target.result,
                });
            };
            reader.readAsDataURL(this.files[0]);
        });
        
        document.getElementById('episode-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            if(audioFileLink === false){
                const audioFile = document.getElementById('audio_file').value;
            }
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;

            // Vérifiez si les champs requis sont vides
            const emptyFields = findEmptyFields([
                { id: 'title', label: 'Title' },
                { id: 'description', label: 'Description' }
            ]);

            if(audioFileLink === false){
                emptyFields.push({ id: 'audio_file', label: 'Audio file' });
            }

            if (emptyFields.length > 0) {
                const errorMessage = `Veuillez remplir les champs obligatoires : ${emptyFields.map(field => field.label).join(', ')}.`;
                alert(errorMessage);
                console.log(emptyFields);
                // Faites défiler la page jusqu'au premier champ manquant
                const firstEmptyField = emptyFields[0].id;
                console.log(firstEmptyField);
                const element = document.getElementById(firstEmptyField);
                console.log(element);
                const elementPosition = element.getBoundingClientRect().top + window.scrollY - window.innerHeight / 2;
                console.log(element.getBoundingClientRect().top);

                // Ajustez la position en conséquence (par exemple, en soustrayant 100 pour compenser)
                window.scrollTo({ top: elementPosition, behavior: 'smooth' });
            } else {
                // Baisser l'opacité de la page sauf pour le cercle de chargement
                document.getElementById('all').style.opacity = '0.5';
                // Désactiver le bouton
                const submitButton = document.getElementById('submit-button');
                submitButton.disabled = true;

                // Afficher le cercle de chargement
                const loadingCircle = document.getElementById('loading-circle');
                loadingCircle.style.display = 'block';

                var formData = new FormData(this);

                if(document.getElementById('cover').value !== ''){
                    // Récupérez l'image croppée sous forme de fichier
                    const croppedFile = await getCroppedImageAsFile(croppie);

                    // Redimensionnez l'image à une largeur de 1400px si nécessaire
                    const resizedFile = await resizeImage(croppedFile, 1400);

                    // Ajoutez le fichier redimensionné au formulaire FormData
                    formData.set('cover', resizedFile);
                }

                
                try {
                    const response = await fetch("<?= route_to('episode-create', $podcast->id) ?>", {
                        method: "POST",
                        body: formData,
                    });

                    if (response.ok) {
                        const responseData = await response.json();
                        console.log(responseData);

                        if (responseData.error) {
                            const errorArray = Object.entries(responseData.error);

                            let errorParam = '';

                            errorArray.forEach((key) => errorParam+=key[1]+'+');

                            console.log(errorParam);
                            
                            // Refresh the page with the error as a GET parameter
                            const currentUrl = window.location.href;
                            const separator = currentUrl.includes('?') ? '&' : '?';
                            const updatedUrl = `${currentUrl}${separator}error=${errorParam}`;

                            console.log(updatedUrl);

                            scrollPageToTop();
                            
                            window.location.href = updatedUrl;
                        } else {
                            const idUrl = responseData.id;
                            console.log(idUrl);
                            // Open the new episode view page
                            const baseUrl = '<?= base_url('/'); ?>'.slice(0, -1);
                            window.location.href = baseUrl + idUrl;
                        }
                    } else {
                        console.error('Erreur de requête:', response.status, response.statusText);
                    }
                } catch (e) {
                    console.error(e);
                }

                // Masquer le cercle de chargement en cas d'erreur
                loadingCircle.style.display = 'none';

                // Activer le bouton en cas d'erreur
                submitButton.disabled = false;
            }
        });

        function findEmptyFields(fields) {
            const emptyFields = [];
            for (const field of fields) {
                const fieldValue = document.getElementById(field.id).value;
                if (!fieldValue) {
                    emptyFields.push(field);
                }
            }
            return emptyFields;
        }


        function scrollPageToTop() {
            // Utilisez document.documentElement ou document.body selon le navigateur
            const scrollTopElement = document.documentElement || document.body;
            
            // Faites défiler jusqu'en haut avec une animation douce (smooth scroll)
            scrollTopElement.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }


        // Fonction pour obtenir l'image croppée sous forme de fichier
        function getCroppedImageAsFile(croppieInstance) {
            return new Promise(resolve => {
                croppieInstance.result({
                    type: 'blob',
                    format: 'jpeg',
                    size: 'original',
                }).then(blob => {
                    const file = new File([blob], 'cropped_image.jpeg', { type: 'image/jpeg' });
                    resolve(file);
                });
            });
        }

        async function resizeImage(file, targetWidth) {
            return new Promise(resolve => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    // Redimensionnez l'image
                    const scaleFactor = targetWidth / img.width;
                    canvas.width = targetWidth;
                    canvas.height = img.height * scaleFactor;
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    // Convertissez le canevas en Blob (fichier)
                    canvas.toBlob(blob => {
                        const resizedFile = new File([blob], file.name, { type: file.type });
                        resolve(resizedFile);
                    }, file.type);
                };

                img.src = URL.createObjectURL(file);
            });
        }
    });
</script>


<?= $this->endSection() ?>