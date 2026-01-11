<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LeadAction;
use App\Models\LeadFollowUp;

use App\Policies\LeadPolicy;
use App\Policies\LeadCommentPolicy;
use App\Policies\LeadActionPolicy;
use App\Policies\LeadFollowUpPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(Lead::class, LeadPolicy::class);
        Gate::policy(LeadComment::class, LeadCommentPolicy::class);
        Gate::policy(LeadAction::class, LeadActionPolicy::class);
        Gate::policy(LeadFollowUp::class, LeadFollowUpPolicy::class);
    }
}
