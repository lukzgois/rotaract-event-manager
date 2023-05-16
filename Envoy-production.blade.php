<?php
$repo = 'git@github.com:lukzgois/rotaract-event-manager.git';
$release = 'release_' . date('Y_m_d_H_i_s');

$release_dir_production = '/var/www/production/releases';
$app_dir_production = '/var/www/production/app';
?>

@macro('deploy-production', ['on' => 'web'])
    fetch_repo_production
    run_backup_production
    run_composer_production
    update_permissions_production
    compile_frontend_production
    update_symlinks_production
    run_migrations_production
    optimize_laravel_production
    reload_php
@endmacro

@task('fetch_repo_production')
    [ -d {{ $release_dir_production }} ] || mkdir {{ $release_dir_production }};
    cd {{ $release_dir_production }};
    git clone -b production {{ $repo }} {{ $release }};
@endtask

@task('run_backup_production')
    cd {{ $app_dir_production }};
    php artisan backup:run
    cd {{ $release_dir_production }}/{{ $release }};
@endtask


@task('run_composer_production')
    cd {{ $release_dir_production }}/{{ $release }};
    composer install --optimize-autoloader
@endtask

@task('update_permissions_production')
    cd {{ $release_dir_production }};
    chgrp -R www-data {{ $release }};
    chmod -R ug+rwx {{ $release }};
@endtask

@task('optimize_laravel_production')
    cd {{ $release_dir_production }}/{{ $release }};
    php artisan clear-compiled --env=production;
    php artisan optimize --env=production;
    php artisan config:cache
    php artisan event:cache
    php artisan route:cache
    php artisan view:cache
@endtask

@task('run_migrations_production')
    cd {{ $release_dir_production }}/{{ $release }};
    php artisan migrate --force
@endtask

@task('update_symlinks_production')
    ln -nfs {{ $release_dir_production }}/{{ $release }} {{ $app_dir_production }};
    chgrp -h www-data {{ $app_dir_production }};

    cd {{ $release_dir_production }}/{{ $release }};
    ln -nfs ../../.env .env;
    chgrp -h www-data .env;

    rm -r {{ $release_dir_production }}/{{ $release }}/storage/logs;
    cd {{ $release_dir_production }}/{{ $release }}/storage;
    ln -nfs ../../../logs logs;
    chgrp -h www-data logs;

    cd {{ $release_dir_production }}/{{ $release }}/storage/app;
    ln -nfs ../../../../backups backups;
    chgrp -h www-data backups;
@endtask

@task('compile_frontend_production')
    cd {{ $release_dir_production }}/{{ $release }};
    npm install
    npm run build
@endtask

@task('reload_php')
    sudo service php8.2-fpm reload;
@endtask
