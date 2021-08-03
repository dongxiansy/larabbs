<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Topic extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Topic::class;

    public static $group = '内容管理';
    public static $priority = 2;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'body'
    ];

    public static function label()
    {
        return '话题';
    }

    public static $with = ['user','category','replies'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('标题','title')
                ->showOnCreating()
                ->showOnUpdating()
                ->rules('required','min:3','max:255')
                ->sortable(),

            BelongsTo::make('作者','User','App\Nova\User')
                ->showOnUpdating()
                ->showOnCreating()
                ->required(true)
                ->sortable()
                ->searchable(),

            BelongsTo::make('分类','Category','App\Nova\Category')
                ->sortable(),

            Trix::make('内容','content')
                ->alwaysShow()
                ->withFiles('public'),

            HasMany::make('评论', 'replies','App\Nova\Reply'),

            Text::make('评论数',function(){
                return $this->replies->count();
            })->onlyOnIndex(),

//            Quilljs::make('内容', 'body')
//                ->withFiles('minio', 'Topic')
//                ->placeholder('please enter here')
//                ->height(300)
//                ->alwaysShow()
//                ->rules('required'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
