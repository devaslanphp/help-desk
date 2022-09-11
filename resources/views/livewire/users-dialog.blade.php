<form wire:submit.prevent="save" class="w-full">
    <div class="w-full p-5">
        {{ $this->form }}
    </div>

    <div class="w-full flex flex-row gap-2 justify-between items-center border-t border-gray-200 mt-5 pb-5 px-5">
        <button type="submit" class="rounded-lg flex flex-row justify-center items-center text-center text-white bg-primary-700 bg-opacity-90 hover:bg-opacity-100 shadow hover:shadow-lg px-10 py-3 text-sm mt-5">
            @lang($user->id ? 'Update' : 'Create')
        </button>
        @if($user->id)
            <button type="button" wire:click="deleteUser" class="rounded-lg flex flex-row justify-center items-center text-center text-white bg-red-700 bg-opacity-90 hover:bg-opacity-100 shadow hover:shadow-lg px-10 py-3 text-sm mt-5">
                @lang('Delete')
            </button>
        @endif
    </div>
</form>
