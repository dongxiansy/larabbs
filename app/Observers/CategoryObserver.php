<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Topic;

class CategoryObserver
{
    public function deleted(Category $category)
    {

        $topics = Topic::query()->where('category_id', $category->id)->pluck('id');
        Topic::query()->where('id', $topics)->delete();
        Reply::query()->where('topic_id', $topics)->delete();
    }

}
