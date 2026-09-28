@extends('layouts.dashboard')

@section('title', 'Platform Announcements | MarketLink Admin')
@section('header_title', 'Broadcast Announcements')
@section('header_subtitle', 'Push notifications and top banner alert announcements across the platform')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <h3 class="font-heading font-extrabold text-base text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-bullhorn text-brand-600"></i> Broadcast Announcement
        </h3>

        <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-4 text-xs font-medium">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-slate-600 font-bold mb-1">Headline Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Saturday Harvest Festival Schedule" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5">
                </div>
                <div>
                    <label class="block text-slate-600 font-bold mb-1">Target Audience *</label>
                    <select name="target_role" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-bold">
                        <option value="all">Everyone (All Visitors)</option>
                        <option value="customer">Customers Only</option>
                        <option value="farmer">Farmers Only</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-slate-600 font-bold mb-1">Message Content *</label>
                <textarea name="message" rows="3" required placeholder="Write the announcement details here..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md transition-all">
                    Broadcast Now
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <h3 class="font-heading font-extrabold text-base text-slate-900">Published Announcements</h3>
        <div class="divide-y divide-slate-100 text-xs font-medium">
            @forelse($announcements as $ann)
                <div class="py-4 flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-900">{{ $ann->title }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-brand-100 text-brand-800 uppercase">Target: {{ $ann->target_role }}</span>
                        </div>
                        <p class="text-slate-600">{{ $ann->message }}</p>
                        <div class="text-[10px] text-slate-400">Published by: {{ $ann->admin->name ?? 'Admin' }} • {{ $ann->created_at->diffForHumans() }}</div>
                    </div>
                    <form action="{{ route('admin.announcements.delete', $ann->id) }}" method="POST" onsubmit="return confirm('Remove announcement?');">
                        @csrf
                        <button type="submit" class="px-3 py-1 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold transition-all">
                            Delete
                        </button>
                    </form>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400">No announcements published yet.</div>
            @endforelse
        </div>
        <div class="pt-4">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection
