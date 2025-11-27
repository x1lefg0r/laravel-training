@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent">
            О нашей компании
        </h1>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">
            Мы создаём инновационные решения, которые меняют мир технологий
        </p>
    </div>

    <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-2xl p-8">
        <div class="prose prose-invert max-w-none">
            <p class="text-gray-300 text-lg leading-relaxed mb-6">
                Мы — динамично развивающаяся компания, которая специализируется на создании 
                современных веб-решений. Наша команда состоит из опытных профессионалов, 
                которые стремятся к совершенству в каждом проекте.
            </p>
            
            <div class="bg-gradient-to-r from-violet-900/20 to-purple-900/20 border border-violet-500/20 rounded-xl p-6 my-8">
                <h2 class="text-2xl font-semibold text-violet-400 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Наша история
                </h2>
                <p class="text-gray-300 leading-relaxed">
                    Компания была основана в 2020 году с целью помочь бизнесу развиваться в 
                    цифровой среде. За это время мы реализовали более 100 успешных проектов 
                    и завоевали доверие клиентов по всему миру.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection