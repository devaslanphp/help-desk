<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-1">
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                @lang('My profile')
            </span>
            <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                @lang('Update your :app user account by using the below form.', [
                    'app' => config('app.name')
                ])
            </span>
        </div>
    </div>

    <form wire:submit.prevent="save" class="lg:w-3/5 md:w-4/5 w-full">
        <div class="w-full flex flex-row justify-start items-center gap-3 p-5">
            <x-user-avatar :user="$user" :size="100" />
            <div class="flex flex-col justify-center items-start gap-0">
                <span class="text-lg text-gray-500 font-medium">{{ $user->name }}</span>
                <span class="text-base text-gray-500 font-light">{{ $user->email }}</span>
                <span class="text-sm text-gray-400 font-light">
                    @lang('Account created:') {{ $user->created_at->diffForHumans() }}
                </span>
                <span class="text-sm text-gray-400 font-light">
                    @lang('Last update:') {{ $user->updated_at->diffForHumans() }}
                </span>
            </div>
        </div>

        <div class="w-full p-5">
            {{ $this->form }}
        </div>

        <div class="w-full flex flex-row gap-2 justify-between items-center border-t border-gray-200 mt-5 pb-5 px-5">
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="rounded-lg flex flex-row justify-center items-center text-center gap-2
                    text-white bg-primary-700 bg-opacity-90 hover:bg-opacity-100 shadow hover:shadow-lg
                    px-10 py-3 text-sm mt-5"
            >
                @lang('Save')
                <div wire:loading>
                    <em class="fa fa-spin fa-spinner"></em>
                </div>
            </button>
        </div>
    </form>
</div>
