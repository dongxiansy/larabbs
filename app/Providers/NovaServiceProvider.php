<?php

namespace App\Providers;

use App\Nova\Dashboards\UserInsights;
use App\Nova\Metrics\TopicCount;
use App\Nova\Metrics\UserCount;
use Bakerkretzmar\NovaSettingsTool\SettingsTool;
use Beyondcode\CustomDashboardCard\CustomDashboard;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Element;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use OptimistDigital\NovaSettings\NovaSettings;
use Beyondcode\CustomDashboardCard\NovaCustomDashboard;
use Vyuldashev\NovaPermission\NovaPermissionTool;
use Coroowicaksono\ChartJsIntegration\LineChart;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::sortResourcesBy(
            function ($resource) {
                return $resource::$priority ?? 9999;
            }
        );

        Nova::serving(
            function () {
                \App\Models\User::observe(\App\Observers\UserObserver::class);
                \App\Models\Topic::observe(\App\Observers\TopicObserver::class);
                \App\Models\Link::observe(\App\Observers\LinkObserver::class);
                \App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
            }
        );

        NovaCustomDashboard::cards(
            [
                (new TopicCount)->withMeta(
                    [
                        'card-name' => '话题总数'
                    ]
                ),
                (new UserCount)->withMeta(
                    [
                        'card-name' => '用户总数'
                    ]
                ),
            ]
        );
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define(
            'viewNova',
            function ($user) {
//                return $user->hasNovaPermission();
                return in_array(
                    $user->email,
                    [
                        'dongxiansy@163.com'
                    ]
                );
            }
        );
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new CustomDashboard,
//            (new LineChart())
//                ->title('用户增长趋势')
//                ->animations([
//                                 'enabled' => true,
//                                 'easing' => 'easeinout',
//                             ])
//                ->series(array([
//                    'barPercentage' => 0.5,
//                    'label' => 'Average Sales',
//                    'borderColor' => '#f7a35c',
//                    'data' => [80, 90, 80, 40, 62, 79, 79, 90, 90, 90, 92, 91],
//                ],[
//                    'barPercentage' => 0.5,
//                    'label' => 'Average Sales #2',
//                    'borderColor' => '#90ed7d',
//                    'data' => [90, 80, 40, 22, 79, 129, 30, 40, 90, 92, 91, 80],
//                ]))
//                ->options([
//                              'xaxis' => [
//                                  'categories' => [ 'Jan', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct' ]
//                              ],
//                              'legend' => [
//                                  'display' => true,
//                                  'position' => 'left',
//                              ]
//                          ])
//                ->width('2/3'),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
//            new UserInsights,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
//            new NovaPermissionTool,
            (\Vyuldashev\NovaPermission\NovaPermissionTool::make())->canSee(function ($request){
                return $request->user()->can('manage_users');
            }),

//            new NovaSettings
            (new SettingsTool)->canSee(
                function ($request) {
                    return $request->user()->can('manage_users');
                }
            ),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
