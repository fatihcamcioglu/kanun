@php
    $user = filament()->auth()->user();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; width: 100%;">
            <div style="display: flex; align-items: center; gap: 16px; flex: 1;">
                <x-filament-panels::avatar.user
                    size="lg"
                    :user="$user"
                    loading="lazy"
                />

                <div class="fi-account-widget-main">
                    <h2 class="fi-account-widget-heading">
                        Hoş geldin
                    </h2>

                    <p class="fi-account-widget-user-name">
                        {{ filament()->getUserName($user) }}
                    </p>
                </div>
            </div>

            <form
                action="{{ filament()->getLogoutUrl() }}"
                method="post"
                class="fi-account-widget-logout-form"
                style="flex-shrink: 0;"
            >
                @csrf

                <x-filament::button
                    color="gray"
                    :icon="\Filament\Support\Icons\Heroicon::ArrowLeftOnRectangle"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    Oturumu kapat
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

