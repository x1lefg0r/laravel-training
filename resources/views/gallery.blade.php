@extends('layouts.app')

@section('title', $item['name'])

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-8">
        <a href="/" class="inline-flex items-center text-violet-400 hover:text-purple-400 transition-colors group">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Вернуться к галерее
        </a>
    </div>

    <!-- Image Card -->
    <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-2xl overflow-hidden">
        <!-- Full Image -->
        <div class="aspect-video bg-gray-800">
            <img 
                src="/{{ $item['full_image'] }}" 
                alt="{{ $item['name'] }}"
                class="w-full h-full object-contain"
                onerror="this.src='https://placehold.co/1200x800/1f2937/8b5cf6?text={{ urlencode($item['name']) }}'"
            >
        </div>
        
        <!-- Info Section -->
        <div class="p-8">
            <div class="flex items-start justify-between mb-4">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent">
                    {{ $item['name'] }}
                </h1>
                <span class="px-4 py-2 bg-violet-500/20 text-violet-400 rounded-lg text-sm font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $item['date'] }}
                </span>
            </div>
            
            <div class="prose prose-invert max-w-none">
                <p class="text-lg text-gray-300 leading-relaxed">
                    {{ $item['desc'] }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection