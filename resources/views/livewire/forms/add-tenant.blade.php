<div>

    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">

            <div>
                <x-label for="name" value="{{ __('modules.tenant.name') }}" required/>
                <x-input id="name" class="block mt-1 w-full" type="text" autofocus wire:model='name' autocomplete="off"/>
                <x-input-error for="name" class="mt-2" />
            </div>



            <div>
                <x-label for="email" value="{{ __('modules.tenant.email') }}" required/>
                <x-input id="email" class="block mt-1 w-full" type="email" autofocus wire:model='email' autocomplete="off"/>
                <x-input-error for="email" class="mt-2" />
            </div>

            <div>
                <x-label for="phone" value="{{ __('modules.tenant.phone') }}" />
                <x-input id="phone" class="block mt-1 w-full" type="tel" wire:model='phone' autocomplete="off"/>
                <x-input-error for="phone" class="mt-2" />
            </div>

            <div x-data="{ photoName: null, photoPreview: null }" x-on:photo-removed.window="photoName = null; photoPreview = null;">
                <input type="file" id="profilePhoto" class="hidden" wire:model="profilePhoto" accept="image/png, image/gif, image/jpeg, image/webp"
                    x-ref="profilePhoto"
                    x-on:change="
                        photoName = $refs.profilePhoto.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.profilePhoto.files[0]);
                    "/>
                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.profilePhoto.click()">
                    {{ __('modules.tenant.uploadProfilePicture') }}
                </x-secondary-button>

                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="mt-2" x-show="photoPreview">
                    <x-danger-button type="button" wire:click="removeProfilePhoto">
                        {{ __('modules.tenant.removeProfilePicture') }}
                    </x-danger-button>
                </div>

                <x-input-error for="profilePhoto" class="mt-2" />
            </div>

            <div>
                <x-label for="apartmentRented" value="{{ __('modules.settings.apartmentNumber') }}" required/>

                <x-select  class="mt-1 block w-full" wire:model.live='selectedApartment'>
                    <option value="">@lang('modules.settings.apartmentNumber')</option>
                    @foreach ($apartmentRented as $apartment)
                        <option value="{{ $apartment->id }}">{{ $apartment->apartment_number }}</option>
                    @endforeach
                </x-select>

                <x-input-error for="selectedApartment" class="mt-2" />
            </div>

            <div class="flex space-x-4">
                <div class="w-1/2">
                    <x-label for="contract_start_date" value="{{ __('modules.tenant.contractStartDate') }}" required/>
                    <x-datepicker class="w-full" wire:model.live="contract_start_date" id="contract_start_date" autocomplete="off" placeholder="{{ __('modules.tenant.contractStartDate') }}" />
                    <x-input-error for="contract_start_date" class="mt-2" />
                </div>

                <div class="w-1/2">
                    <x-label for="contract_end_date" value="{{ __('modules.tenant.contractEndDate') }}" required/>
                    <x-datepicker class="w-full" wire:model.live="contract_end_date" id="contract_end_date" autocomplete="off" placeholder="{{ __('modules.tenant.contractEndDate') }}" />
                    <x-input-error for="contract_end_date" class="mt-2" />
                </div>
            </div>

            <div class="mt-2">
                <x-label for="status" value="{{ __('modules.settings.status') }}" />
                <x-select id="status" class="block w-full mt-1" wire:model.live="status">
                    <option value="current_resident">{{ __('modules.tenant.currentResident') }}</option>
                    <option value="left">{{ __('modules.tenant.left') }}</option>
                </x-select>
                <x-input-error for="status" class="mt-2" />
            </div>


            <div class="flex space-x-4 mt-2">
                <div class="w-1/2">
                    <x-label for="rent_billing_cycle" value="{{ __('modules.tenant.rentBillingCycle') }}" />
                    <x-select id="rent_billing_cycle" class="block w-full mt-1" wire:model.live="rent_billing_cycle">
                        <option value="monthly">{{ __('modules.tenant.monthly') }}</option>
                        <option value="annually">{{ __('modules.tenant.annually') }}</option>
                    </x-select>
                    <x-input-error for="rent_billing_cycle" class="mt-2" />
                </div>
                <div class="w-1/2">
                    <x-label for="rent_amount" value="{{ __('modules.tenant.rentAmount') }}" />
                    <x-input id="rent_amount" class="block mt-1 w-full" type="number" step="0.01" wire:model='rent_amount' autocomplete="off"/>
                    <x-input-error for="rent_amount" class="mt-2" />
                </div>
            </div>
            
            <div class="flex space-x-4 mt-2">
                <div class="w-1/2">
                    <label for="move_in_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        {{ __('modules.tenant.moveInDate') }}
                    </label>
                    <x-datepicker class="w-full" wire:model.live="move_in_date" id="move_in_date" autocomplete="off" placeholder="{{ __('modules.tenant.moveInDate') }}" />
                    <x-input-error for="move_in_date" class="mt-2" />
                </div>

                <div class="w-1/2">
                    <label for="move_out_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        {{ __('modules.tenant.moveOutDate') }}
                    </label>
                    <x-datepicker class="w-full" wire:model.live="move_out_date" id="move_out_date" autocomplete="off" placeholder="{{ __('modules.tenant.moveOutDate') }}" />
                    <x-input-error for="move_out_date" class="mt-2" />
                </div>
            </div>

        </div>
        <div class="flex w-full pb-4 space-x-4 mt-6">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideAddTenant')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
