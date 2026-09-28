@extends('layouts.app')

@section('title', 'Register - MarketLink')

@section('content')
<div class="py-12 sm:py-16 bg-[#fcfbf9] min-h-[90vh] flex items-center justify-center px-4">
    <div class="max-w-5xl w-full bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12">
        <div class="relative hidden lg:block lg:col-span-5 min-h-[600px]">
            <img src="https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=1000&q=80" alt="Local Farmers Market" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-950/95 via-brand-900/60 to-brand-900/25"></div>
            <div class="relative h-full flex flex-col justify-between p-8 text-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold text-white shadow-sm border border-white/20">
                        <i class="fa-solid fa-leaf text-base"></i>
                    </div>
                    <span class="font-heading font-extrabold text-xl tracking-tight text-white">Market<span class="text-brand-300">Link</span></span>
                </div>

                <div class="space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-brand-200 text-xs font-semibold">
                        <i class="fa-solid fa-seedling text-brand-400"></i>
                        <span>Join Our Local Network</span>
                    </div>

                    <h3 class="font-heading font-extrabold text-2xl leading-tight text-white">
                        Support Springfield growers and eat fresher produce every week.
                    </h3>

                    <div class="space-y-3 pt-2 text-xs text-brand-100">
                        <div class="flex items-start gap-2.5">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-brand-300 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[10px]"></i>
                            </div>
                            <span>Guaranteed pre-order reservations before weekly Friday cutoffs</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-brand-300 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[10px]"></i>
                            </div>
                            <span>Direct stall pickup without supermarket checkout lines</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-brand-300 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[10px]"></i>
                            </div>
                            <span>Zero subscription or platform fees for shoppers</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-xs text-brand-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-400/20 text-brand-300 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-tractor"></i>
                        </div>
                        <div>
                            <div class="font-bold text-white text-xs">Selling produce?</div>
                            <div class="text-[11px] text-brand-200/90">Switch to Farmer tab to list your stall.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 p-4 sm:p-8 md:p-10 flex flex-col justify-center">
            <div class="max-w-lg mx-auto w-full space-y-5 sm:space-y-6">
                <div class="space-y-1.5">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-brand-50 text-brand-800 text-[11px] font-bold border border-brand-100">
                        <i class="fa-solid fa-user-plus text-brand-600"></i> Free Account Setup
                    </div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">Create Your Account</h1>
                    <p class="text-xs sm:text-sm text-slate-500">Select whether you are joining as a customer or local grower.</p>
                </div>

                <div class="grid grid-cols-2 p-1.5 bg-slate-100 rounded-2xl text-[11px] sm:text-xs font-bold gap-1 border border-slate-200/60">
                    <button type="button" onclick="selectRole('customer')" id="tab-customer" class="py-2.5 rounded-xl bg-white text-brand-800 shadow-sm transition-all flex items-center justify-center gap-1.5 sm:gap-2">
                        <i class="fa-solid fa-user text-xs"></i>
                        <span>Customer / Shopper</span>
                    </button>
                    <button type="button" onclick="selectRole('farmer')" id="tab-farmer" class="py-2.5 rounded-xl text-slate-600 hover:text-slate-900 transition-all flex items-center justify-center gap-1.5 sm:gap-2">
                        <i class="fa-solid fa-tractor text-xs"></i>
                        <span>Farmer / Stall Owner</span>
                    </button>
                </div>

                <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" id="role-input" value="customer">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="sm:col-span-2 space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Full Name *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-regular fa-user text-xs"></i>
                                </div>
                                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Eleanor Vance" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Email Address *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-regular fa-envelope text-xs"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Phone Number *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-phone text-xs"></i>
                                </div>
                                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="+1 (555) 019-2834" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                            </div>
                        </div>

                        <div class="sm:col-span-2 space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Street Address / Area *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-location-dot text-xs"></i>
                                </div>
                                <input type="text" name="address" value="{{ old('address') }}" required placeholder="142 Elm Street, Springfield" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                            </div>
                        </div>
                    </div>

                    <div id="farmer-fields" class="hidden space-y-3.5 pt-3 border-t border-slate-100">
                        <div class="p-3 bg-brand-50 rounded-2xl border border-brand-200/80 text-[11px] text-brand-900 font-semibold flex items-center gap-2">
                            <i class="fa-solid fa-leaf text-brand-700"></i>
                            <span>Stall Details & Market Location</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Farm / Stall Name *</label>
                                <input type="text" name="stall_name" value="{{ old('stall_name') }}" placeholder="e.g. Sunny Valley Organics" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Contact Person *</label>
                                <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="Lead grower / manager" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                            </div>

                            <div class="sm:col-span-2 space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Market Location</label>
                                <select name="market_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                                    <option value="">Select market you attend...</option>
                                    @foreach($markets as $m)
                                        <option value="{{ $m->id }}">{{ $m->market_name }} ({{ $m->operating_days }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Operating Days *</label>
                                <input type="text" name="operating_days" value="Saturday & Sunday" placeholder="e.g. Saturday & Sunday" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Pickup Windows *</label>
                                <input type="text" name="pickup_windows" value="08:00 AM - 10:00 AM, 10:00 AM - 12:00 PM, 12:00 PM - 02:00 PM" placeholder="e.g. 08:00 AM - 10:00 AM" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                            </div>

                            <div class="sm:col-span-2 space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Stall Specialties & Bio</label>
                                <textarea name="bio" rows="2" placeholder="Tell local shoppers about your harvest, heirloom seeds, honey, sourdough..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Password *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </div>
                                <input type="password" id="reg-password" name="password" required placeholder="Min 6 characters" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-10 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                                <button type="button" onclick="togglePasswordVisibility('reg-password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Confirm Password *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-shield-check text-xs"></i>
                                </div>
                                <input type="password" id="reg-password-confirm" name="password_confirmation" required placeholder="Repeat password" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-10 py-2.5 text-xs sm:text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-medium">
                                <button type="button" onclick="togglePasswordVisibility('reg-password-confirm', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs sm:text-sm shadow-md transition-all active:scale-[0.99] flex items-center justify-center gap-2">
                            <span>Complete Registration</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </form>

                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-1 text-xs text-slate-500 text-center sm:text-left">
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}" class="font-bold text-brand-800 hover:text-emerald-900 underline">
                        Sign In here &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectRole(role) {
    document.getElementById('role-input').value = role;
    const tabCustomer = document.getElementById('tab-customer');
    const tabFarmer = document.getElementById('tab-farmer');
    const farmerFields = document.getElementById('farmer-fields');

    if (role === 'farmer') {
        tabFarmer.className = "py-2.5 rounded-xl bg-white text-brand-800 shadow-sm transition-all flex items-center justify-center gap-2";
        tabCustomer.className = "py-2.5 rounded-xl text-slate-600 hover:text-slate-900 transition-all flex items-center justify-center gap-2";
        farmerFields.classList.remove('hidden');
    } else {
        tabCustomer.className = "py-2.5 rounded-xl bg-white text-brand-800 shadow-sm transition-all flex items-center justify-center gap-2";
        tabFarmer.className = "py-2.5 rounded-xl text-slate-600 hover:text-slate-900 transition-all flex items-center justify-center gap-2";
        farmerFields.classList.add('hidden');
    }
}

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
