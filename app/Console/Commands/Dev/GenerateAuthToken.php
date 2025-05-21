<?php

namespace App\Console\Commands\Dev;

use App\Exceptions\UnreportableException;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateAuthToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:token {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates auth token for specified user';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $column = match (true) {
            is_numeric($this->argument('user')) => 'id',
            Str::isUuid($this->argument('user')) => 'uuid',
            default => throw new UnreportableException('Only ID and UUID is accepted as user!'),
        };

        if (! ($user = User::query()->where($column, $this->argument('user'))->first())) {
            $this->components->error('Could not find a user with specified ' . strtoupper($column));
            return 0;
        }

        $token = $user->createToken('dev-login-' . Str::random(16), expiresAt: now()->addDay());
        $this->components->info("Auth token {$token->plainTextToken} for [{$user->name}]");
    }
}
