<?php

namespace App\Console\Commands\Dev;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Modules\Auth\Enums\Role;

class ShowTestCredentials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:credentials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show user info and auth tokens for local API testing';

    /**
     * Execute the console command.
     */
    public function handle(Application $app)
    {
        if (! $app->isLocal()) {
            $this->components->error('This command can only be run on local environment');
            return self::FAILURE;
        }

        $super = User::role(Role::SuperAdmin)->first();
        $admin = User::role(Role::Admin)->first();
        $teacher = User::role(Role::Teacher)->first();
        $student = User::role(Role::Student)->whereHas('enrolledClassrooms')->whereHas('pendingClassrooms')->first();

        foreach ([$super, $admin, $teacher, $student] as $user) {
            if (! $user) {
                continue;
            }

            $token = $user->createToken('dev-login-' . Str::random(16), expiresAt: now()->addDay());
            $role = Role::forUser($user);

            $this->components->info("{$role->value} {$token->plainTextToken} [{$user->email}] [{$user->uuid}]");
        }
    }
}
