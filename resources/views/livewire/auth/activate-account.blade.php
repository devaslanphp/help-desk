<div class="w-full flex flex-col justify-center items-center text-center">
    <span class="lg:text-3xl md:text-2xl text-xl font-bold text-gray-700">@lang('Activate account')</span>
    <span class="font-medium text-gray-400 mt-2">
        @lang('Choose a password and confirm it then click the activate button to access your account')
    </span>
    <form wire:submit.prevent="activate" class="w-full mt-5">
        {{ $this->form }}
        <button
            type="submit"
            class="w-full rounded-lg uppercase flex flex-row justify-center items-center gap-2 text-center
                 text-white bg-primary-700 bg-opacity-90 hover:bg-opacity-100 shadow hover:shadow-lg px-5 py-3 mt-5">
            @lang('Activate')
            <div wire:loading>
                <em class="fa fa-spin fa-spinner"></em>
            </div>
        </button>
    </form>
    <div class="w-full text-center mt-2 text-sm text-gray-500">
        @lang('Have you already activated your user account?')
        <br>
        <a href="{{ route('auth.login') }}" class="hover:underline text-primary-500 hover:text-primary-600">
            @lang('Go to sign in page')
        </a>
    </div>
</div>
