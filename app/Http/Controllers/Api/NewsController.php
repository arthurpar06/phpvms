<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Http\Resources\News as NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    /**
     * Return all the news items, paginated
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $news = News::with('user')
            ->latest()
            ->paginate();

        return NewsResource::collection($news);
    }
}
