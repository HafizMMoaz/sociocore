<div>
    <div class="grid grid-cols-2 mb-6">
        <div>
            <x-label value="{{__('modules.rent.rentFor')}}"/>
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ ucfirst($rent->rent_for_month) . ' ' .$rent->rent_for_year ?? '--'}}</p>
        </div>

        <div>
            <x-label value="{{__('modules.settings.apartmentNumber')}}"/>
            <p class="mt-2 text-gray-600 dark:text-gray-400"> {{ $rent->apartment->apartment_number }}</p>
        </div>
    </div>
    <div class="grid grid-cols-2 mb-6">
        <div>
            <x-label value="{{__('modules.rent.tenantName')}}"/>
            <x-user :user="$tenant->user"  :tenantId="$tenant->id"/>
        </div>

        <div>
            <x-label value="{{ __('modules.tenant.rentAmount') }}" />
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{currency_format($rent_amount) ?? __('modules.rent.noAmount') }}</p>
        </div>
    </div>
    <div class="grid grid-cols-2 mb-6">

        <div>
            <x-label class="mb-2" value="{{ __('modules.settings.status') }}" />
            <div class="flex items-center">
                @if($status === 'paid')
                    <x-badge type="success">{{ __('modules.rent.paid') }}</x-badge>
                @else
                    <x-badge type="danger">{{ __('modules.rent.unpaid') }}</x-badge>
                @endif
            </div>
        </div>
        @if ($payment_date)
            <div>
                <x-label class="mb-2" value="{{ __('modules.rent.paymentDate') }}" />
                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($payment_date)->format('d F Y') }}</p>
            </div>
        @endif

    </div>

    @if($paymentProof)
        <div class="relative w-full group">
            <x-label class="mb-2" value="{{ __('modules.utilityBills.paymentProofShow') }}" />
            <div class="relative w-64 h-56 p-1 overflow-hidden rounded bg-gray-50 ring-gray-300 ring-1 dark:ring-gray-500">
                <a href="{{ $paymentProof }}" target="_blank">
                    <img class="object-cover w-full h-full" src="{{ $paymentProof }}" alt="Payment Proof" />
                </a>
                <div class="absolute inset-0 flex items-end justify-end p-2 transition-opacity duration-300 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100">
                    <a href="{{ $paymentProof }}" target="_blank" class="px-4 py-2 mr-2 text-white rounded shadow hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4.5C6.75 4.5 3 12 3 12s3.75 7.5 9 7.5 9-7.5 9-7.5-3.75-7.5-9-7.5zM12 16.5c-2.25 0-4.5-1.5-4.5-4.5s2.25-4.5 4.5-4.5 4.5 1.5 4.5 4.5-2.25 4.5-4.5 4.5zM12 10.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                        </svg>
                    </a>
                    <button wire:click="download" wire:loading.attr="disabled" class="px-4 py-2 text-white rounded shadow hover:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                            <path d="M12 16l4-4h-3V4h-2v8H8l4 4zM5 20h14v-2H5v2z" stroke="currentColor" stroke-width="1.5"/>
                        </svg>

                    </button>
                </div>
            </div>
        </div>
    @endif
    <div class="flex w-full pb-4 mt-6 space-x-4">
        <x-button-cancel  wire:click="$dispatch('hideRentDetail')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
    </div>
</div>
