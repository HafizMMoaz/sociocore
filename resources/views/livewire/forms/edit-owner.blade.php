<div>
    <form wire:submit.prevent="updateOwner">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="name" value="{{ __('modules.user.name') }}" required/>
                <x-input id="name" class="block mt-1 w-full" type="text" wire:model='name' autocomplete="off"/>
                <x-input-error for="name" class="mt-2" />
            </div>

            <div>
                <x-label for="email" value="{{ __('modules.user.email') }}" required/>
                <x-input id="email" class="block mt-1 w-full" type="email" wire:model='email' autocomplete="off"/>
                <x-input-error for="email" class="mt-2" />
            </div>

            <div>
                <x-label for="phone" value="{{ __('modules.user.phone') }}" />
                <x-input id="phone" class="block mt-1 w-full" type="tel" min='0' wire:model='phone' autocomplete="off"/>
                <x-input-error for="phone" class="mt-2" />
            </div>

            <div>
                <x-label for="status" value="{{ __('modules.user.status') }}" />
                @if($user->id == user()->id)
                    <x-input id="status" class="block mt-1 w-full" type="text" value="{{ $user->status }}" readonly />
                @else
                    <x-select id="status" class="block w-full mt-1" wire:model.live="status">
                        <option value="active">{{ __('modules.user.active') }}</option>
                        <option value="inactive">{{ __('modules.user.inactive') }}</option>
                    </x-select>
                @endif
                <x-input-error for="status" class="mt-2" />
            </div>

            <div class="flex space-x-4">
                <div class="w-1/2">
                    <x-label for="tower" :value="__('modules.settings.selectTower')" required="true" />
                    <x-select id="tower" class="block w-full mt-1" wire:model.live="selectedTower">
                        <option value="">@lang('modules.settings.selectTower')</option>
                        @foreach ($towers as $tower)
                            <option value="{{ $tower->id }}">{{ $tower->tower_name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="selectedTower" class="mt-2" />
                </div>

                <div class="w-1/2">
                    <x-label for="floor" :value="__('modules.settings.selectFloor')" required="true" />
                    <x-select id="floor" class="block w-full mt-1" wire:model.live="selectedFloor">
                        <option value="">@lang('modules.settings.selectFloor')</option>
                        @foreach ($floors as $floor)
                            <option value="{{ $floor->id }}">{{ $floor->floor_name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="selectedFloor" class="mt-2" />
                </div>
            </div>

            <div>
                <x-label for="apartment" :value="__('modules.tenant.selectApartment')" required="true" />
                <x-select id="apartment" class="block w-full mt-1" wire:model.live="selectedApartment">
                    <option value="">@lang('modules.tenant.selectApartment')</option>
                    @foreach ($apartments as $apartment)
                        @if(!in_array($apartment->id, $selectedApartmentsArray))
                            <option value="{{ $apartment->id }}">{{ $apartment->apartment_number }}</option>
                        @endif
                    @endforeach
                </x-select>
                <x-input-error for="selectedApartment" class="mt-2" />
            </div>

            @if(count($selectedApartmentsArray) > 0)
            <div class="mt-4">
                <label>@lang('modules.settings.selectedApartment')</label>
                <div class="space-x-2 mt-2">
                    @foreach($selectedApartmentsArray as $apartmentId)
                        @php
                            $apartment = \App\Models\ApartmentManagement::with(['towers', 'floors'])->find($apartmentId);
                        @endphp
                        @if($apartment)
                            <span class="inline-flex items-center bg-blue-500 text-white py-1 px-3 rounded-full">
                                {{ $apartment->apartment_number }}
                                <button type="button" wire:click="removeApartment({{ $apartmentId }})" class="ml-2 text-white hover:text-red-200">
                                    ×
                                </button>
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <x-input-error for="selectedApartmentsArray" class="mt-2" />

            <div x-data="{ photoName: null, photoPreview: null, hasNewPhoto: @entangle('hasNewPhoto').live , clearFileInput() { this.photoName = ''; this.photoPreview = ''; this.         hasNewPhoto = false; this.$refs.photo.value = ''; @this.set('teamLogo', ''); } }" class="col-span-6 sm:col-span-4">
                <input type="file" class="hidden"
                            wire:model="profilePhoto"
                            accept="image/png, image/gif, image/jpeg, image/webp"
                            x-ref="profilePhoto"
                            x-on:change="
                                    photoName = $refs.profilePhoto.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.profilePhoto.files[0]);
                                    hasNewPhoto = true;" />

                <x-label for="photoName" value="{{ __('Profile Photo') }}" />

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.profilePhoto.click()">
                    {{ __('modules.user.uploadProfilePicture') }}
                </x-secondary-button>

                @if ($user->profile_photo_path)
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $user->profile_photo_url }}" alt="{{ 'Profile Photo' }}" class="object-cover w-20 h-20 overflow-hidden rounded-full">
                </div>
                @endif

                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2" type="button" x-on:click.prevent="clearFileInput()" x-show="hasNewPhoto" x-cloak>
                    {{ __('modules.user.removeProfilePicture') }}
                </x-secondary-button>

                @if ($user->profile_photo_path)
                    <x-danger-button type="button" class="mt-2" wire:click="removeProfilePhoto" x-on:click.prevent="clearFileInput()" x-show="!hasNewPhoto" x-cloak>
                        {{ __('modules.user.removeProfilePicture') }}
                    </x-danger-button>
                @endif
            </div>

            <div class="flex items-center space-x-4 mt-8">
                <x-button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white">
                    @lang('app.update')
                </x-button>
                <x-button-cancel  wire:click="$dispatch('hideEditOwner')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>

            </div>
        </div>
    </form>
</div>
