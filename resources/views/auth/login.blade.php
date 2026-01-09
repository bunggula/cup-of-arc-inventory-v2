@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-[2.5rem] border border-stone-100 shadow-xl p-8 md:p-12">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-black text-stone-800 uppercase tracking-tighter italic">Cup Of <span class="text-orange-600">Arc</span></h1>
                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.3em] mt-2">Management Portal</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-red-600">
                        {{ $errors->first() }}
                    </p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                
                {{-- Email Input --}}
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" 
                           class="w-full px-6 py-4 bg-stone-50 border-none rounded-2xl outline-none ring-1 ring-stone-100 focus:ring-2 focus:ring-orange-500/20 transition-all text-sm font-semibold" required>
                </div>

                {{-- Password Input --}}
                <div class="relative" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" 
                           name="password" 
                           placeholder="Password" 
                           class="w-full px-6 py-4 bg-stone-50 border-none rounded-2xl outline-none ring-1 ring-stone-100 focus:ring-2 focus:ring-orange-500/20 transition-all text-sm font-semibold" required>
                    
                    <button type="button" 
                            @click="show = !show" 
                            class="absolute right-6 top-1/2 -translate-y-1/2 text-stone-400 hover:text-orange-600 transition-colors">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                {{-- REMEMBER ME SECTION --}}
                <div class="flex items-center justify-between px-2 py-2">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="remember" class="sr-only peer">
                            <div class="w-10 h-5 bg-stone-100 rounded-full peer peer-checked:bg-orange-600 transition-all"></div>
                            <div class="absolute left-1 top-1 w-3 h-3 bg-white rounded-full peer-checked:translate-x-5 transition-all"></div>
                        </div>
                        <span class="ml-3 text-[10px] font-black text-stone-400 group-hover:text-stone-600 uppercase tracking-widest transition-colors">Remember Me</span>
                    </label>
                </div>

                <button type="submit" 
                        class="w-full bg-stone-900 text-white py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-orange-600 transition-all shadow-lg shadow-stone-200">
                    Sign In to Dashboard
                </button>
            </form>
        </div>
        
        <p class="text-center mt-8 text-[10px] font-bold text-stone-400 uppercase tracking-widest">
            Authorized Personnel Only
        </p>
    </div>
</div>
@endsection