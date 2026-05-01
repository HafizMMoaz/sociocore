<div>
    <form wire:submit="submitForm">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="apartmentName" :value="__('modules.settings.societyApartmentNumber')"/>
                <x-select id="apartmentName" class="block w-full mt-1" wire:model="apartmentName">
                    <option value="">@lang('modules.settings.selectAparmentNumber')</option>
                    @foreach ($apartments as $item)
                        <option value="{{ $item->id }}">{{ $item->apartment_number}}</option>
                    @endforeach
                </x-select>
                <x-input-error for="apartmentName" class="mt-2" />
            </div>

            <div>
                <x-label for="parkingCode" value="{{ __('modules.settings.societyParkingCode') }}" required="true"/>
                <x-input id="parkingCode" class="block w-full mt-1" type="text" wire:model='parkingCode' />
                <x-input-error for="parkingCode" class="mt-2" />
            </div>
        </div>


        <div class="flex w-full pb-4 mt-6 space-x-4">
            <x-button>@lang('app.save')</x-button>
            <x-button-cancel  wire:click="$dispatch('hideEditParking')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
        </div>
    </form>
</div>
