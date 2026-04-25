<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Support\Resources\CustomAnonymousResourceCollection;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Return all the news items, paginated
     */
    public function index(Request $request): CustomAnonymousResourceCollection
    {
        $news = News::with('user')
            ->latest()
            ->paginate();

        return NewsResource::collection($news);
    }
}
