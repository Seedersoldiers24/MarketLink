@extends('layouts.app')

@section('title', 'Sign In - MarketLink')

@section('content')
<div class="py-12 sm:py-16 bg-[#fcfbf9] min-h-[85vh] flex items-center justify-center px-4">
    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12">
        <div class="relative hidden lg:block lg:col-span-5 min-h-[500px]">
            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1000&q=80" alt="Fresh Organic Market" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-950/90 via-brand-900/50 to-brand-900/20"></div>
            <div class="relative h-full flex flex-col justify-between p-8 text-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold text-white shadow-sm border border-white/20">
                        <i class="fa-solid fa-leaf text-base"></i>
                    </div>
                    <span class="font-heading font-extrabold text-xl tracking-tight text-white">Market<span class="text-brand-300">Link</span></span>
                </div>
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-brand-200 text-xs font-semibold">
                        <i class="fa-solid fa-circle-check text-brand-400"></i>
                        <span>100% Direct From Growers</span>
                    </div>
                    <h3 class="font-heading font-extrabold text-2xl leading-tight text-white">
                        Fresh harvests reserved for your weekend table.
                    </h3>
                    <p class="text-xs text-brand-100/90 leading-relaxed font-normal">
                        Pre-order heirloom vegetables, organic fruits, and artisan foods directly from verified Springfield farms.
                    </p>
                    <div class="pt-2 flex items-center gap-2 text-xs text-brand-200 font-semibold">
                        <div class="flex text-amber-400 text-xs">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-white font-bold">4.9/5</span>
                        <span class="text-brand-200/80">from 450+ customers</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 p-5 sm:p-8 md:p-10 flex flex-col justify-center">
            <div class="max-w-md mx-auto w-full space-y-6">
                <div class="space-y-1.5">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-brand-50 text-brand-800 text-[11px] font-bold border border-brand-100">
                        <i class="fa-solid fa-shield-halved text-brand-600"></i> Secure Portal Sign In
                    </div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">Welcome Back</h1>
                    <p class="text-xs sm:text-sm text-slate-500">Sign in to manage your pre-orders, farmer stalls, or market account.</p>
                </div>

                <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-envelope text-xs"></i>
                            </div>
                            <input type="email" id="login-email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700">Password</label>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                            <input type="password" id="login-password" name="password" required placeholder="Enter your password" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-10 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                            <button type="button" onclick="togglePasswordVisibility('login-password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="fa-regular fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-brand-700 border-slate-300 focus:ring-brand-500">
                            <span class="text-slate-600 font-medium">Keep me signed in</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs sm:text-sm shadow-md transition-all active:scale-[0.99] flex items-center justify-center gap-2">
                        <span>Sign In to Account</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </form>

                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-1 text-xs text-slate-500 text-center sm:text-left">
                    <span>Don't have an account yet?</span>
                    <a href="{{ route('register') }}" class="font-bold text-brand-700 hover:text-brand-800 underline">
                        Register for free &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush
