<?php

return [
    /*
     | Should programmatic changes to the orbit models be tracked by git
     */
    'enabled' => env('ORBIT_GIT_ENABLED', true),

    /*
     | Name which is used for the commit. Can be overwritten with
     | OrbitGit::resolveNameUsing(fn() => '...')
     */
    'name' => env('ORBIT_GIT_NAME'),

    /*
     | Email which is used for the commit. Can be overwritten with
     | OrbitGit::resolveEmailUsing(fn() => '...')
     */
    'email' => env('ORBIT_GIT_EMAIL'),

    /*
     | Folder in which changes will be tracked with git. (Default: base_path())
     */
    'root' => env('ORBIT_GIT_ROOT', base_path()),

    /*
     | Path to the git binary. (Default: '/usr/bin/git')
     */
    'binary' => env('ORBIT_GIT_BINARY', '/usr/bin/git'),

    /*
     | Email which is used for the commit. Can be overwritten with
     | OrbitGit::resolveMessageUsing(fn($event) => '...')
     | OrbitGit::resolveCreatedMessageUsing(fn($event) => '...')
     | OrbitGit::resolveDeletedMessageUsing(fn($event) => '...')
     | OrbitGit::resolveForceDeletedMessageUsing(fn($event) => '...')
     | OrbitGit::resolveUpdatedMessageUsing(fn($event) => '...')
     */
    'message_template' => '[AUTO] {event} {model} {primary_key}',
];
