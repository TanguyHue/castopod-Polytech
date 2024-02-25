<?php declare(strict_types=1);

use Modules\Auth\Config\Auth;

?>
<?= helper('form') ?>
<?= $this->extend(config(Auth::class)->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?><?= $this->endSection() ?>


<?= $this->section('content') ?>

<form actions="<?= url_to('login') ?>" method="POST" class="flex flex-col w-full gap-y-4">
    <?= csrf_field() ?>

    <Forms.Field
        name="email"
        label="<?= lang('Auth.email') ?>"
        required="true"
        type="email"
        inputmode="email"
        autocomplete="username"
        autofocus="autofocus"
    />

    <Forms.Field
        name="password"
        label="<?= lang('Auth.password') ?>"
        type="password"
        inputmode="text"
        autocomplete="current-password"
        required="true" />

    <!-- Remember me -->
    <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
        <Forms.Toggler name="remember" value="yes" checked="<?= old('remember') ?>" size="small"><?= lang('Auth.rememberMe') ?></Forms.Toggler>
    <?php endif; ?>

    <Button variant="primary" type="submit" class="self-end"><?= lang('Auth.login') ?></Button>
</form>

<?= $this->endSection() ?>


<?= $this->section('footer') ?>

<div class="flex flex-col items-center py-4 text-sm text-center">
    
<?php if(service('settings')->get('Nextcloud.nextcloudActive')): ?>
<a href="<?= route_to('authenticate') ?>" class="inline-flex items-center justify-center p-2 mb-4 text-base font-medium text-gray-500 rounded-lg bg-gray-50 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
    <span class="w-full">Utiliser Nextcloud pour se connecter</span>
    <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
</a>

<?php endif; ?>

    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
            <p class="text-center"><?= lang('Auth.forgotPassword') ?> <a class="underline hover:no-underline" href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
    <?php endif ?>
    <?php if (setting('Auth.allowRegistration')) : ?>
        <p class="text-center"><?= lang('Auth.needAccount') ?> <a class="underline hover:no-underline" href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
