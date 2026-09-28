@extends('layouts.app')

@section('title', 'Contact Us & Head Office Map | MarketLink')

@section('content')
<div class="bg-gradient-to-b from-brand-50/60 to-slate-50 py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-700 bg-brand-100 px-3 py-1 rounded-full border border-brand-300">
                Get In Touch
            </span>
            <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 mt-2">Contact MarketLink Support</h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">Have questions about market stalls, farmer partnerships, or pre-orders? We are here to help.</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <h3 class="font-heading font-extrabold text-xl text-slate-900">Platform Headquarters</h3>
                
                <div class="space-y-4 text-xs">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center flex-shrink-0 text-sm">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-bold text-[10px] uppercase">Central Desk</span>
                            <span class="font-bold text-slate-800 text-sm">100 Market St, Civic Plaza</span>
                            <span class="text-slate-500 block">Springfield, CA 94103</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center flex-shrink-0 text-sm">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-bold text-[10px] uppercase">Direct Email</span>
                            <span class="font-bold text-slate-800 text-sm">support@marketlink.com</span>
                            <span class="text-slate-500 block">Typical response within 2 hours</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center flex-shrink-0 text-sm">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-bold text-[10px] uppercase">Hotline & SMS Alerts</span>
                            <span class="font-bold text-slate-800 text-sm">+1 (555) 019-FARM</span>
                            <span class="text-slate-500 block">Mon - Sun: 7:00 AM - 6:00 PM</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Weekend Market Concierge</div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        On-site market support available every Saturday & Sunday 07:00 AM - 02:00 PM for pickup coordination, stall directions, and grower verification.
                    </p>
                </div>
            </div>

            <div class="bg-white p-3 rounded-3xl border border-slate-200 shadow-sm">
                <div class="text-xs font-bold text-slate-700 mb-2 px-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-map-pin text-brand-600"></i> Office & Hub Location Map
                </div>
                <div id="contact-map" class="h-64 rounded-2xl w-full z-10 border border-slate-100"></div>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                <div>
                    <h3 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900">Send Us a Direct Message</h3>
                    <p class="text-xs text-slate-500 mt-1">Fill out the form below and our team will get back to you shortly.</p>
                </div>

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Your Full Name *</label>
                            <input type="text" name="name" required placeholder="Jane Doe" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:border-brand-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Email Address *</label>
                            <input type="email" name="email" required placeholder="jane@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:border-brand-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Subject *</label>
                        <input type="text" name="subject" required placeholder="e.g. Inquiring about weekend stall registration" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:border-brand-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Message *</label>
                        <textarea name="message" rows="5" required placeholder="How can we assist you with MarketLink?" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:border-brand-500"></textarea>
                    </div>

                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs shadow-lg shadow-brand-600/20 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i> Send Message
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const map = L.map('contact-map').setView([37.774929, -122.419416], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([37.774929, -122.419416])
            .addTo(map)
            .bindPopup(`
                <div style="font-family: inherit;">
                    <strong style="color: #15803d;">MarketLink Headquarters</strong><br>
                    100 Market St, Civic Plaza<br>
                    Springfield, CA
                </div>
            `)
            .openPopup();

        setTimeout(() => {
            map.invalidateSize();
        }, 300);

        window.addEventListener('resize', () => {
            map.invalidateSize();
        });
    });
</script>
@endpush
