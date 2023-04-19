@servers(['web' => 'codircdossetemares.com.br'])

<?php
$repo = 'git@github.com:lukzgois/rotaract-event-manager.git';
$release = 'release_' . date('Y_m_d_H_i_s');

$release_dir_staging = '/var/www/staging/releases';
$app_dir_staging = '/var/www/staging/app';

$release_dir_production = '/var/www/production/releases';
$app_dir_production = '/var/www/production/app';
?>

@macro('deploy-staging', ['on' => 'web'])
    fetch_repo_staging
    run_composer_staging
    update_permissions_staging
    update_symlinks_staging
    compile_frontend_staging
    reset_migrations_staging
    optimize_laravel_staging
    reload_php
@endmacro

@task('fetch_repo_staging')
    [ -d {{ $release_dir_staging }} ] || mkdir {{ $release_dir_staging }};
    cd {{ $release_dir_staging }};
    git clone -b main {{ $repo }} {{ $release }};
@endtask

@task('run_composer_staging')
    cd {{ $release_dir_staging }}/{{ $release }};
    composer install --optimize-autoloader
@endtask

@task('update_permissions_staging')
    cd {{ $release_dir_staging }};
    chgrp -R www-data {{ $release }};
    chmod -R ug+rwx {{ $release }};
@endtask

@task('optimize_laravel_staging')
    cd {{ $release_dir_staging }}/{{ $release }};
    php artisan clear-compiled --env=production;
    php artisan optimize --env=production;
    php artisan config:cache
    php artisan event:cache
    php artisan route:cache
    php artisan view:cache
@endtask

@task('reset_migrations_staging')
    cd {{ $release_dir_staging }}/{{ $release }};
    php artisan migrate:refresh --seed --force
@endtask

@task('update_symlinks_staging')
    ln -nfs {{ $release_dir_staging }}/{{ $release }} {{ $app_dir_staging }};
    chgrp -h www-data {{ $app_dir_staging }};

    cd {{ $release_dir_staging }}/{{ $release }};
    ln -nfs ../../.env .env;
    chgrp -h www-data .env;

    rm -r {{ $release_dir_staging }}/{{ $release }}/storage/logs;
    cd {{ $release_dir_staging }}/{{ $release }}/storage;
    ln -nfs ../../../logs logs;
    chgrp -h www-data logs;
@endtask

@task('compile_frontend_staging')
    cd {{ $release_dir_staging }}/{{ $release }};
    npm install
    npm run build
@endtask

@task('reload_php')
    sudo service php8.2-fpm reload;
@endtask
