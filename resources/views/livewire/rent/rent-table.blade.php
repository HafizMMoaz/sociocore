<div class="px-4 pt-2 xl:grid-cols-3 xl:gap-4 bg-white dark:bg-gray-900">
    @if ($showFilters)
        @include('rents.filters')
    @endif
    <div class="flex items-center justify-end">
        @if($showActions)
            <x-dropdown dropdownClasses="z-50">
                <x-slot name="trigger">
                    <span class="inline-flex">
                        <button type="button"
                            class="inline-flex items-center justify-center p-2 text-sm font-medium text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-300 hover:text-gray-700 focus:outline-none hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 mb-2">
                            @lang('app.action')
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </span>
                </x-slot>
                <x-slot name="content">
                        <x-dropdown-link href="javascript:;" wire:click="showSelectedDeleteRent">
                            <span class="inline-flex items-center justify-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @lang('app.delete')
                            </span>
                        </x-dropdown-link>
                        <x-dropdown-link href="javascript:;" wire:click="showSelectedPay">
                            <span class="inline-flex items-center justify-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zm.75 5.75a.75.75 0 00-1.5 0v1h-1a.75.75 0 000 1.5h1v1h-1a.75.75 0 100 1.5h1v1a.75.75 0 001.5 0v-1h1a.75.75 0 000-1.5h-1v-1h1a.75.75 0 000-1.5h-1v-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @lang('app.pay')
                            </span>
                        </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        @endif
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                @if(user_can('Delete Rent'))
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        <input type="checkbox" wire:model.live="selectAll" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    </th>
                                @endif
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.settings.apartmentNumber')
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.rent.tenantName')
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.rent.rentFor')
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.tenant.rentAmount')
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.settings.status')
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.rent.paymentDate')
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='user-list-{{ microtime() }}'>
                            @forelse ($rents as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='item-{{ $item->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                                @if(user_can('Delete Rent'))
                                    <td class="p-4">
                                        <input type="checkbox" wire:model.live="selected" value="{{ $item->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    </td>
                                @endif
                                <td class="p-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="javascript:;" wire:click="showRentDetail({{ $item->id }})" class="text-base font-semibold hover:underline dark:text-black-400">
                                    {{ $item->apartment->apartment_number }}
                                    </a>
                                </td>
                                <td class="p-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->tenant->user->name }}
                                </td>
                                <td class="p-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ ucfirst($item->rent_for_month) . ' ' .$item->rent_for_year ?? '--'}}
                                </td>
                                <td class="p-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{  currency_format($item->rent_amount) ?? '--' }}
                                </td>

                                <td class="p-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center">
                                        @if($item->status == "paid")
                                            <x-badge type="success">{{ ucfirst($item->status) }}</x-badge>
                                        @else
                                            <x-badge type="danger">{{ ucfirst($item->status) }}</x-badge>
                                        @endif
                                    </div>
                                </td>

                                <td class="p-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->status === 'unpaid' ? '--' : $item->payment_date }}
                                </td>

                                <td class="p-4 space-x-2 text-right whitespace-nowrap">
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <span class="inline-flex">
                                                <button type="button"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-300 hover:text-gray-700 focus:outline-none hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                                                    <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="5" r="1.5"></circle>
                                                        <circle cx="12" cy="12" r="1.5"></circle>
                                                        <circle cx="12" cy="19" r="1.5"></circle>
                                                    </svg>
                                                </button>
                                            </span>
                                        </x-slot>
                                        <x-slot name="content">

                                                <x-dropdown-link href="javascript:;" wire:click="showRentDetail({{ $item->id }})">
                                                    <span class="inline-flex items-center">
                                                        <svg class="w-4 h-4 mr-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                        </svg>
                                                        @lang('app.view')
                                                    </span>

                                                </x-dropdown-link>

                                                @if(user_can('Update Rent') && $item->status == "unpaid")
                                                    <x-dropdown-link href="javascript:;" wire:click="showEditRent({{ $item->id }})">
                                                        <span class="inline-flex items-center ">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                                </path>
                                                                <path fill-rule="evenodd"
                                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            @lang('app.edit')
                                                        </span>
                                                    </x-dropdown-link>
                                                @endif
                                            @if($item->status == "unpaid")
                                                @if(user_can('Delete Rent'))
                                                    <x-dropdown-link href="javascript:;" wire:click="showDeleteRent({{ $item->id }})">
                                                        <span class="inline-flex items-center justify-center">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            @lang('app.delete')
                                                        </span>
                                                    </x-dropdown-link>
                                                @endif

                                                <x-dropdown-link href="javascript:;" wire:click="showPay({{ $item->id }})">
                                                    <span class="inline-flex items-center justify-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M10 2a8 8 0 100 16 8 8 0 000-16zm.75 5.75a.75.75 0 00-1.5 0v1h-1a.75.75 0 000 1.5h1v1h-1a.75.75 0 100 1.5h1v1a.75.75 0 001.5 0v-1h1a.75.75 0 000-1.5h-1v-1h1a.75.75 0 000-1.5h-1v-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        @lang('app.pay')
                                                    </span>
                                                </x-dropdown-link>
                                            @endif
                                            @if($item->status == "paid")
                                                <x-dropdown-link href="javascript:;" wire:click="downloadReceipt({{ $item->id }})">
                                                    <span class="inline-flex items-center justify-center">
                                                        <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/>                                                         </svg>
                                                        @lang('app.download')
                                                    </span>
                                                </x-dropdown-link>
                                            @endif
                                        </x-slot>
                                    </x-dropdown>
                                </td>
                            </tr>
                            @empty
                                <x-no-results :message="__('messages.noRentFound')" />
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div wire:key='rent-table-paginate-{{ microtime() }}'
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-0 w-full">
            {{ $rents->links() }}
        </div>
    </div>

    <x-right-modal wire:model.live="showEditRentModal">
        <x-slot name="title">
            {{ __("modules.rent.editRentDetails") }}
        </x-slot>

        <x-slot name="content">
            @if ($seletedRent)
            @livewire('forms.editRent', ['rent' => $seletedRent], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditRentModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-right-modal wire:model.live="showRentDetailModal">
        <x-slot name="title">
            {{ __("modules.rent.viewRentDetails") }}
        </x-slot>

        <x-slot name="content">
            @if ($seletedRent)
            @livewire('forms.showRent', ['rent' => $seletedRent], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showTenantDetailModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-confirmation-modal wire:model="confirmDeleteRentModal">
        <x-slot name="title">
            @lang('modules.rent.deleteRent')?
        </x-slot>

        <x-slot name="content">
            @lang('app.deleteMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteRentModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if ($seletedRent)
            <x-danger-button class="ml-3" wire:click='deleteRent({{ $seletedRent->id }})' wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
            @endif
         </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal wire:model="confirmSelectedDeleteRentModal">
        <x-slot name="title">
            @lang('modules.rent.deleteRent')?
        </x-slot>

        <x-slot name="content">
            @lang('app.deleteMessage')
            <div class="flex items-center p-4 mt-4 mb-4 w-64 max-w-full text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div>
                <span class="font-medium"><strong>@lang('modules.rent.deletePaidRentMessage')</strong></span>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmSelectedDeleteRentModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click='deleteSelected' wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>

         </x-slot>
    </x-confirmation-modal>

    <x-dialog-modal wire:model.live="showPayModal">
        <x-slot name="title">
            {{ __("modules.utilityBills.addPaymentDetail") }}
        </x-slot>
        <x-slot name="content">
            @if($payRent)
                @livewire('forms.rent-pay',['rent' => $payRent], key(str()->random(50)))
            @endif
            </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showPayModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="showSelectedPayModal">
        <x-slot name="title">
            {{ __("modules.utilityBills.addPaymentDetail") }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="paySelected">
                @csrf
                <div class="space-y-4">
                    <div class = "mt-3">
                        <x-label for="paymentDate" value="{{ __('modules.rent.paymentDate') }}" required="true" />
                        <x-datepicker class="block w-full mt-1" wire:model.live="paymentDate" id="paymentDate" autocomplete="off" placeholder="{{ __('modules.rent.choosePaymentDate') }}" :maxDate="true"/>
                        <x-input-error for="paymentDate" class="mt-2" />
                    </div>

                    <div class="flex w-full pb-4 mt-6 space-x-4">
                        <x-button>@lang('app.save')</x-button>
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showSelectedPayModal', false)" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
