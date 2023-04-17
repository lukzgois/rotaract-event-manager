@servers(['web' => 'codircdossetemares.com.br'])

<?php
$repo = 'git@github.com:lukzgois/rotaract-event-manager.git';
$release_dir = '/var/www/staging/releases';
$app_dir = '/var/www/staging/app';
$release = 'release_' . date('Y_m_d_H_i_s');
?>

@macro('deploy-staging', ['on' => 'web'])
    fetch_repo
    run_composer
    update_permissions
    update_symlinks
    compile_frontend
    reset_migrations
    optimize_laravel
    reload_php
@endmacro

@task('fetch_repo')
    [ -d {{ $release_dir }} ] || mkdir {{ $release_dir }};
    cd {{ $release_dir }};
    git clone -b main {{ $repo }} {{ $release }};
@endtask

@task('run_composer')
    cd {{ $release_dir }}/{{ $release }};
    composer install --optimize-autoloader
@endtask

@task('update_permissions')
    cd {{ $release_dir }};
    chgrp -R www-data {{ $release }};
    chmod -R ug+rwx {{ $release }};
@endtask

@task('optimize_laravel')
    cd {{ $release_dir }}/{{ $release }};
    php artisan clear-compiled --env=production;
    php artisan optimize --env=production;
    php artisan config:cache
    php artisan event:cache
    php artisan route:cache
    php artisan view:cache
@endtask

@task('reset_migrations')
    cd {{ $release_dir }}/{{ $release }};
    php artisan migrate:refresh --seed --force
@endtask

@task('update_symlinks')
    ln -nfs {{ $release_dir }}/{{ $release }} {{ $app_dir }};
    chgrp -h www-data {{ $app_dir }};

    cd {{ $release_dir }}/{{ $release }};
    ln -nfs ../../.env .env;
    chgrp -h www-data .env;

    rm -r {{ $release_dir }}/{{ $release }}/storage/logs;
    cd {{ $release_dir }}/{{ $release }}/storage;
    ln -nfs ../../../logs logs;
    chgrp -h www-data logs;
@endtask

@task('compile_frontend')
    cd {{ $release_dir }}/{{ $release }};
    npm install
    npm run build
@endtask

@task('reload_php')
    sudo service php8.2-fpm reload;
@endtask
