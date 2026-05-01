{{-- <div class="ticket-edit-container">
    <div class="p-8">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            @lang('app.editTicket') #{{ $ticketId }}
        </h1>

        <form wire:submit.prevent="updateTicket">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">@lang('app.ticketTitle')</label>
                <input type="text" id="title" wire:model="title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600" />
            </div>

            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300">@lang('app.ticketPriority')</label>
                <select id="priority" wire:model="priority" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="low">@lang('app.low')</option>
                    <option value="medium">@lang('app.medium')</option>
                    <option value="high">@lang('app.high')</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">@lang('app.ticketStatus')</label>
                <select id="status" wire:model="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="open">@lang('app.open')</option>
                    <option value="closed">@lang('app.closed')</option>
                    <option value="pending">@lang('app.pending')</option>
                </select>
            </div>

            <button type="submit" class="w-full px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                @lang('app.updateTicket')
            </button>
        </form>
    </div>
</div> --}}
