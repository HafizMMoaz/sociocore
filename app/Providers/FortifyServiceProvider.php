<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use App\Models\OnboardingStep;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{

    use AppBoot;
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {

            public function toResponse($request)
            {
                session(['user' => User::find(user()->id)]);

                if (user()->hasRole('Admin_' . user()->society_id)) {
                    $onboardingSteps = OnboardingStep::where('society_id', user()->society->id)->first();

                    if (
                        $onboardingSteps
                        && (
                            !$onboardingSteps->add_tower_completed
                            || !$onboardingSteps->add_floor_completed
                            || !$onboardingSteps->add_apartment_completed
                            || !$onboardingSteps->add_parking_completed
                        )
                    ) {
                        return redirect(RouteServiceProvider::ONBOARDING_STEPS);
                    }
                }

                if (user()->hasRole('Super Admin')) {
                    return redirect(RouteServiceProvider::SUPERADMIN_HOME);
                }

                return redirect(session()->has('url.intended') ? session()->get('url.intended') : RouteServiceProvider::HOME);
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            $this->showInstall();

            $this->checkMigrateStatus();

            if (!$this->isLegal()) {
                if (!module_enabled('Subdomain')) {
                    return redirect('verify-purchase');
                }

                // We will only show verify page for super-admin-login
                // We will check it's opened on main or not
                if (Str::contains(request()->url(), 'super-admin-login')) {
                    return redirect('verify-purchase');
                }
            }

            return view('auth.login');
        });
    }
    public function checkMigrateStatus()
    {
        return check_migrate_status();
    }
}
