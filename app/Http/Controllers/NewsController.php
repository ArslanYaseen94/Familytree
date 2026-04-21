<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('user.news')
            ->with(__('messages.success'), __('messages.News deleted successfully.'));
    }
    public function index()
    {
        $auth = Auth::user()->id;
        $newsList = News::where("user_id", $auth)->get();
        return view("user-view.news.index", compact("newsList"));
    }
    public function edit($id)
    {

        $news = News::find($id);
        // dd($news);
        return view("user-view.news.create",compact("news"));
    }
    public function create()
    {
        return view("user-view.news.create");
    }
public function store(Request $request)
{
    $news = $request->filled('news_id') 
        ? News::find($request->news_id) 
        : new News();

    if ($request->filled('news_id') && !$news) {
        return redirect()->back()->with('error', 'News not found.');
    }

    $news->user_id = auth()->id();
    $news->title = $request->title;
    $news->slug = $request->slug ?: Str::slug($request->title);
    $news->category_id = $request->category_id;
    $news->content = $request->content;
    $news->excerpt = $request->excerpt;
    $news->status = $request->status ?: 'draft';
    $news->published_at = $request->published_at;

    // Handle image upload
    if ($request->hasFile('featured_image')) {
        $image = $request->file('featured_image');
        $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('news'), $imageName);
        $news->featured_image = 'news/' . $imageName;
    }

    $news->save();

    return redirect()->route('user.news')->with(
        __('messages.success'), 
        $request->filled('news_id')
            ? __('messages.News updated successfully.')
            : __('messages.News created successfully.')
    );
}

}
