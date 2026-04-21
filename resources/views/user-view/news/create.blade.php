@extends('layouts.user.app')
@section('content')
<div class="main-content right-chat-active">
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left pe-0">
            <div class="container">
                <div class="card-header bg-primary text-white rounded-4">
                    <h4 class="mb-0 p-4">{{ __('messages.Create a News') }}</h4>
                </div>
                <div class="card shadow rounded-4 mt-3">
                    <div class="card-body mt-3">
                        <form action="{{ route('user.news.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="news_id" value="{{ $news->id ?? "" }}">
                            <div class="mb-3">
                                <label for="title" class="form-label"> {{ __('messages.News Title') }}</label>
                                <input type="text" name="title" value="{{$news->title ?? ""}}" class="form-control" required placeholder="{{ __('messages.Enter News Title') }}">
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label"> {{ __('messages.Slug') }}</label>
                                <input type="text" name="slug" class="form-control" value="{{$news->slug ?? ""}}" placeholder="{{ __('messages.Enter Slug') }}">
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label"> {{ __('messages.Category') }}</label>
                                <select name="category_id" class="form-select">
                                    <option value="">-- {{ __('messages.Select Category') }} --</option>

                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label"> {{ __('messages.Content') }}</label>
                                <textarea name="content" class="form-control" rows="6" required placeholder="{{ __('messages.Content') }}">{{$news->content ?? ""}}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="excerpt" class="form-label"> {{ __('messages.Excerpt') }}</label>
                                <textarea name="excerpt" class="form-control" rows="2" placeholder="{{ __('messages.Excerpt') }}">{{$news->excerpt ?? ""}}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="featured_image" class="form-label"> {{ __('messages.Featured Image') }}</label>
                                <input type="file" name="featured_image" class="form-control">
                                @if(isset($news))
                                <div cl>
                                    <img src="{{asset($news->featured_image)}}" width="100" height="100" alt="">
                                </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label"> {{ __('messages.Status') }}</label>
                                <select name="status" class="form-select">
                                    <option value="draft">{{ __('messages.Draft') }}</option>
                                    <option value="published">{{ __('messages.Published') }}</option>
                                    <option value="archived">{{ __('messages.Archived') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="published_at" class="form-label"> {{ __('messages.Publish Date') }}</label>
                                <input type="datetime-local" name="published_at" class="form-control">
                            </div>
                            <div class="d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-success"> {{ __('messages.Submit') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection