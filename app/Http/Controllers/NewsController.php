<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Statistics;

class NewsController extends Controller
{
    public function index()
    {
        Statistics::process();
        
        $news = News::all();
        
        return view('news.index', compact('news'));
    }
    
    public function news($id)
    {
        if ($news = News::find($id)) {
            Statistics::process($id);
            
            return view('news.news', compact('news'));
        } else {
            abort(404);
        }
    }
}
