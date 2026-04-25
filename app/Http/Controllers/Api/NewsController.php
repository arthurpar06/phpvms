<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Http\Resources\News as NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Return all the news items, paginated
     *
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $news = News::with('user')
            ->latest()
            ->paginate();

        return NewsResource::collection($news);
    }
}
