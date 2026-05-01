<div>
    <div class="space-y-4">
        <div>
            <x-label for="asset_name" value="{{ __('modules.assets.assetName') }}" />
            <p class="text-gray-700">{{ $assetName }}</p>
        </div>
        <div>
            <x-label for="maintenance_date" value="{{ __('modules.assets.maintenanceDate') }}" />
            <p class="text-gray-700">{{ $maintenance_date }}</p>
        </div>

        <div>
            <x-label for="schedule" value="{{ __('modules.assets.maintenanceSchedule') }}" />
            <p class="text-gray-700">{{ ucfirst($schedule) }}</p>
        </div>

        <div>
            <x-label for="status" value="{{ __('modules.assets.status') }}" />
            <p class="text-gray-700">{{ ucfirst($status) }}</p>
        </div>

        <div>
            <x-label for="amount" value="{{ __('modules.assets.amount') }}" />
            <p class="text-gray-700">{{ number_format($amount, 2) }}</p>
        </div>

        @if($serviceProviderName)
            <div>
                <x-label for="serviceId" value="{{ __('modules.assets.serviceProvider') }}" />
                <p class="text-gray-700">{{ $serviceProviderName }}</p>
            </div>
        @endif

        @if($notes)
        <div>
            <x-label for="notes" value="{{ __('modules.assets.notes') }}" />
            <p class="text-gray-700">{{ $notes }}</p>
        </div>
        @endif


    </div>
</div>
