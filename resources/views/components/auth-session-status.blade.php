@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-2xl shadow-sm']) }}>
        <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-xl flex items-center justify-center shadow-sm">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <p class="text-sm font-semibold text-green-800 flex-1">{{ $status }}</p>
    </div>
@endif
