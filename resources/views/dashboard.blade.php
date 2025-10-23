@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="text-center">
    <h1 class="text-5xl font-extrabold text-green-900 drop-shadow-md">
        Welcome to MyClimb
    </h1>
    <p class="mt-4 text-lg text-black-800/90 font-medium">
        Explore nature, book climbing tickets, and save your favorite mountains
    </p>

    <div class="mt-12 flex justify-center gap-6">
        <div class="w-52 h-36 rounded-xl overflow-hidden shadow-md hover:scale-105 transition">
            <img src="{{ asset('images/bromo.jpg') }}" class="object-cover w-full h-full" alt="Gunung Bromo">
        </div>
        <div class="w-64 h-44 rounded-xl overflow-hidden shadow-lg hover:scale-110 transition">
            <img src="{{ asset('images/rinjani.jpg') }}" class="object-cover w-full h-full" alt="Gunung Rinjani">
        </div>
        <div class="w-52 h-36 rounded-xl overflow-hidden shadow-md hover:scale-105 transition">
            <img src="{{ asset('images/semeru.jpg') }}" class="object-cover w-full h-full" alt="Gunung Semeru">
        </div>
    </div>

    <div class="mt-10">
        <a href="{{ route('mountain.index') }}"
           class="bg-green-700 hover:bg-green-800 text-white px-8 py-3 rounded-full text-lg shadow-md transition transform hover:scale-105">
            View Mountain List
        </a>
    </div>
</div>
@endsection