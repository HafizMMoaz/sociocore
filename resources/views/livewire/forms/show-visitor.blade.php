<div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">

        <div>
            <x-label value="{{__('modules.settings.societyTower')}}"/>
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->apartment->towers->tower_name }}</p>
        </div>

        <div>
            <x-label value="{{ __('modules.settings.floorName') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->apartment->floors->floor_name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">

        <div>
            <x-label value="{{__('modules.visitorManagement.visitorName')}}"/>
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->visitor_name }}</p>
        </div>

        <div>
            <x-label value="{{ __('modules.settings.apartmentNumber') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->apartment->apartment_number }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">

        <div>
            <x-label class="mb-2" value="{{ __('modules.visitorManagement.inTime') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->in_time ? \Carbon\Carbon::parse($this->visitor->in_time)->timezone(timezone())->format('h:i A') : '--' }}</p>
        </div>

        <div>
            <x-label value="{{ __('modules.visitorManagement.outTime') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->out_time ? \Carbon\Carbon::parse($this->visitor->out_time)->timezone(timezone())->format('h:i A') : '--' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">

        <div>
            <x-label class="mb-2" value="{{ __('modules.visitorManagement.dateOfVisit') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->date_of_visit ? \Carbon\Carbon::parse($this->visitor->date_of_visit)->timezone(timezone())->format('d F Y') : '--' }}</p>
        </div>
        <div>
            <x-label class="mb-2" value="{{ __('modules.visitorManagement.dateOfExit') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->date_of_exit ? \Carbon\Carbon::parse($this->visitor->date_of_exit)->timezone(timezone())->format('d F Y') : '--'}}</p>
        </div>

    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">

        <div>
            <x-label class="mb-2" value="{{ __('modules.visitorManagement.purposeOfVisit') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->purpose_of_visit ? $this->visitor->purpose_of_visit : "--"}}</p>
        </div>

        <div>
            <x-label class="mb-2" value="{{ __('modules.visitorManagement.visitorType') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->visitorType->name ? $this->visitor->visitorType->name :'--' }}</p>

        </div>
    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">

        <div class="w-full">
            <x-label class="mb-2" value="{{ __('modules.visitorManagement.visitorAddress') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->address }}</p>
        </div>
        <div>
            <x-label class="mb-2" value="{{ __('modules.visitorManagement.visitorMobile') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->phone_number ? $this->visitor->phone_number : "--"}}</p>

        </div>
    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">

        <div class="w-full">
            <x-label class="mb-2" value="{{ __('modules.visitorManagement.addedBy') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $this->visitor->user->name ?? '--'}}
            </p>
        </div>
        <div class="w-full">
            <x-label class="mb-2" value="{{ __('modules.settings.status') }}" />
            @if ($this->visitor->status === 'allowed')
                <x-badge type="success">{{ ucFirst($this->visitor->status) }}</x-badge>
            @elseif ($this->visitor->status === 'not_allowed')
                <x-badge type="danger">{{ ucFirst(str_replace('_', ' ', $this->visitor->status)) }}</x-badge>
            @else
                <x-badge type="warning">{{ ucFirst($this->visitor->status) }}</x-badge>
            @endif
        </div>

    </div>

    <div class="w-full mt-2">
        @if($this->visitor->visitor_photo_url)
            <x-label class="mb-2" value="{{ __('modules.visitorManagement.visitorPhoto') }}" />
            <a href="{{$this->visitor->visitor_photo_url}}" target="_blank">
                <x-avatar-image :src="$this->visitor->visitor_photo_url" :alt="$this->visitor->visitor_name"/>
            </a>
            <x-secondary-button wire:click="download" class="mt-2">
                <span class="inline-flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/></svg>
                </span>
            </x-secondary-button>
        @endif
    </div>

    <div class="grid grid-cols-2 mb-6">
        <a class="min-h-[40px] w-24 rounded-xl bg-white hover:bg-gray-50 text-gray-700 border p-2 inline-flex items-center justify-center gap-1 transition-colors dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700"
            href="{{ route('visitors.print', $visitorId) }}" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                <path
                    d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
            </svg>
            <span class="text-sm font-medium">@lang('app.print')</span>
        </a>
    </div>
    
    <div class="flex w-full pb-4 mt-6 space-x-4">
        <x-button-cancel  wire:click="$dispatch('hideShowVisitor')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
    </div>
</div>
