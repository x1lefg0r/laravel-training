@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent">
            Галерея изображений
        </h1>
        <p class="text-xl text-gray-400">
            Коллекция потрясающих фотографий
        </p>
    </div>

    @if(count($items) > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($items as $index => $item)
            <a href="/gallery/{{ $index }}" class="group bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-xl overflow-hidden hover:border-violet-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-violet-500/10 hover:scale-105">
                <div class="aspect-video overflow-hidden bg-gray-800">
                    <img 
                        src="/{{ $item['preview_image'] }}" 
                        alt="{{ $item['name'] }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                        onerror="this.src='https://placehold.co/600x400/1f2937/8b5cf6?text={{ urlencode($item['name']) }}'"
                    >
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-violet-400 mb-2 group-hover:text-purple-400 transition-colors">
                        {{ $item['name'] }}
                    </h3>
                    <p class="text-gray-400 mb-3 line-clamp-2">
                        {{ Str::limit($item['desc'], 100) }}
                    </p>
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $item['date'] }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <div class="text-6xl mb-4">📷</div>
            <h2 class="text-2xl font-semibold text-gray-300 mb-2">Нет изображений</h2>
            <p class="text-gray-500">Добавьте данные в файл data.json</p>
        </div>
    @endif
</div>
@endsection