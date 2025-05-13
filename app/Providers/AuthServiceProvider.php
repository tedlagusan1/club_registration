<?php

namespace App\Providers;

use App\Models\Club;
use App\Models\ClubApplication;
use App\Models\ClubMember;
use App\Policies\ClubApplicationPolicy;
use App\Policies\ClubMemberPolicy;
use App\Policies\ClubPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ClubApplication::class => ClubApplicationPolicy::class,
        Club::class => ClubPolicy::class,
        ClubMember::class => ClubMemberPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
