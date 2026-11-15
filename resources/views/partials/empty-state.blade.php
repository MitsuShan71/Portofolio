<div class="empty-panel">
    <span class="empty-panel__icon"><i class="{{ $icon }}" aria-hidden="true"></i></span>
    <h3>{{ $title }}</h3>
    <p>{{ $text }}</p>
    @if (! empty($action))
        <a href="{{ $action }}" class="btn btn--ghost btn--sm">
            {{ $actionLabel ?? 'Selengkapnya' }} <i class="ri-arrow-right-line" aria-hidden="true"></i>
        </a>
    @endif
</div>
