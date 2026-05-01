<div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">

        <div>
            <x-label value="{{ __('modules.serviceManagement.serviceType') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-200">{{ $this->serviceManagementShow->serviceType->name }}</p>
        </div>


        <div>
            <x-label value="{{ __('modules.serviceManagement.contactPersonName') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-200">{{ $this->serviceManagementShow->contact_person_name }}</p>
        </div>

    </div>
    <div class="grid grid-cols-2 mb-6 gap-x-2">
        <div>
            <x-label class="mb-2" value="{{ __('modules.serviceManagement.contactNumber') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-200">{{ $this->serviceManagementShow->phone_number }}</p>
        </div>

        <div>
            <x-label class="mb-2" value="{{ __('modules.settings.status') }}" />
            @if($this->serviceManagementShow->status === 'available')
                <x-badge type="success">{{ __('app.' .$this->serviceManagementShow->status) }}</x-badge>
            @else
                <x-badge type="danger">{{ __('app.' .$this->serviceManagementShow->status) }}</x-badge>
            @endif
        </div>

    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2"> 
        <div>
            <x-label value="{{ __('modules.serviceManagement.price') }}" />
            @if($this->serviceManagementShow->price != 0)
                <p class="mt-2 text-gray-600 dark:text-gray-200">{{ currency_format($this->serviceManagementShow->price) }}</p>
            @else
            <p class="mt-2 text-gray-600 dark:text-gray-200">@lang('modules.serviceManagement.notDisclosed')</p>
            @endif
        </div>

        <div>
            <x-label value="{{ __('modules.serviceManagement.paymentFrequency') }}" class="mb-2" />
            <x-badge type="secondary">{{ __('app.'.$this->serviceManagementShow->payment_frequency) }}</x-badge>
        </div>
    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">

        <div>
            <x-label value="{{ __('modules.settings.dailyHelp') }}" class="mb-2" />
                @if($this->serviceManagementShow->daily_help == 1)
                    <p class="mt-2 text-gray-600 dark:text-gray-200">@lang('app.yes')</p>
                @else
                    <p class="mt-2 text-gray-600 dark:text-gray-200">@lang('app.no')</p>
                @endif
        </div>

        <div>
            <x-label value="{{ __('modules.serviceManagement.websiteLink') }}"/>
            @if ($this->serviceManagementShow->website_link)
                <a href="{{ $this->serviceManagementShow->website_link }}" target="_blank" class="break-all">
                    {{ $this->serviceManagementShow->website_link }}
                </a>
            @else
                <span class="text-xs text-gray-500">--</span>
            @endif
        </div>

    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">
        <div>
            <x-label value="{{ __('modules.serviceManagement.companyName') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-200">{{ $this->serviceManagementShow->company_name ?? '--'}}</p>
        </div>

        <div>
            <x-label value="{{ __('modules.settings.apartment') }}" />
            @if($this->serviceManagementShow->apartmentManagements->pluck('apartment_number')->join(', '))
                <p class="mt-2 text-gray-600 dark:text-gray-200">{{$this->serviceManagementShow->apartmentManagements->pluck('apartment_number')->join(', ')}}</p>
            @else
                <span class="dark:text-gray-400">--</span>
            @endif
        </div>  

    </div>

    <div class="grid grid-cols-2 mb-6 gap-x-2">
        <div>
            <x-label value="{{ __('modules.serviceManagement.description') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-200">{{ $this->serviceManagementShow->description }}</p>
        </div>
    </div>


    <div class="flex w-full pb-4 mt-6 space-x-4">
        <x-button-cancel  wire:click="$dispatch('hideShowServiceManagement')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
    </div>
</div>

