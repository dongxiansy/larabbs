<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboard;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserInsights extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            //
        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'user-insights';
    }

    public function fields(Request $request){
        return [
            Text::make('contact_email',setting('contact_email')),
        ];
    }
}
