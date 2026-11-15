<article class="timeline-item">
    <div class="timeline-item__body">
        <div class="timeline-item__top">
            <h4>{{ $experience->title }}</h4>
            @if ($experience->role)
                <span class="timeline-item__role">{{ $experience->role }}</span>
            @endif
        </div>
        <p class="timeline-item__meta">
            @if ($experience->organization)
                <span><i class="ri-building-4-line" aria-hidden="true"></i> {{ $experience->organization }}</span>
            @endif
            <span>
                <i class="ri-calendar-line" aria-hidden="true"></i>
                {{ $experience->start_date->format('d M Y') }}@if ($experience->end_date) — {{ $experience->end_date->format('d M Y') }}@endif
            </span>
        </p>
        @if ($experience->description)
            <p class="timeline-item__description">{{ $experience->description }}</p>
        @endif
        @if ($experience->documentation)
            <a href="{{ Storage::url($experience->documentation) }}" class="link-arrow" target="_blank" rel="noopener noreferrer">
                Lihat dokumentasi <i class="ri-arrow-right-up-line" aria-hidden="true"></i>
            </a>
        @endif
    </div>
</article>
