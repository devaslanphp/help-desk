<form wire:submit.prevent="save" class="w-full">
    <div class="w-full p-5">
        {{ $this->form }}
    </div>

    <div class="w-full flex flex-row gap-2 justify-between items-center border-t border-gray-200 mt-5 pb-5 px-5">
        <button type="submit" wire:loading.attr="disabled"
                class="rounded-lg flex flex-row justify-center items-center text-center gap-2 text-white bg-primary-700
                bg-opacity-90 hover:bg-opacity-100 shadow hover:shadow-lg px-10 py-3 text-sm mt-5">
            Create
            <div wire:loading>
                <em class="fa fa-spin fa-spinner"></em>
            </div>
        </button>
    </div>
</form>
