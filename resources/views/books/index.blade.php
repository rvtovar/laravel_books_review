@extends('layout.app')


@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>

    <form action="{{route('books.index')}}" METHOD="GET" class="mb-4 flex items-center space-x-2">
        <input class="input h-10" type="text" name="title" placeholder="Search By Title" value="{{request('title')}}" />
        <input type="hidden" name="filter" value="{{request('filter')}}">
        <button class="btn h-10">Search</button>
        <a href="{{route('books.index')}}" class="btn h-10">Reset</a>
    </form>
    <div class="filter-container mb-4 flex">
        @php
            $filters = [
                '' => 'Latest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6_months' => 'Popular Last 6 Months',
                'highest_rated_month' => 'Highest Rated Last Month',
                'highest_rated_last_6_months' => 'Highest Rated Last 6 Months',
            ];
        @endphp

        @foreach($filters as $key => $label)
            <a href="{{route('books.index', [...request()->query(),'filter' => $key])}}"
               class="{{request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item'}}"
            >
                {{$label}}
            </a>
        @endforeach
    </div>

    <ul>
        @forelse($books as $book)
            <li class="mb-4">
                <div class="book-item bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between p-4">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{route('books.show', $book)}}" class="book-title text-lg font-semibold text-slate-800 hover:text-slate-600">{{$book->title}}</a>
                            <span class="book-author block text-slate-600">{{$book->author}}</span>
                        </div>
                        <div>
                            <div class="book-rating text-sm font-medium text-slate-700">
                                {{number_format($book->reviews_avg_rating, 1)}}
                                <x-star-rating :rating="(float) $book->reviews_avg_rating" />
                            </div>
                            <div class="book-review-count text-xs text-slate-500">
                                out of {{ $book->reviews_count }} {{Str::plural('review', $book->reviews_count)}}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{route('books.index')}}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
