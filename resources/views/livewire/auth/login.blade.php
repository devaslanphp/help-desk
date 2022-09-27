<div class="w-full flex flex-col justify-center items-center text-center">
    <span class="lg:text-3xl md:text-2xl text-xl font-bold text-gray-700">@lang('Hello again !')</span>
    <span class="font-medium text-gray-400 mt-2">
        @lang('Welcome again, fill the form below and click the sign in button to login into your account')
    </span>
    <form wire:submit.prevent="login" class="w-full mt-5">
        {{ $this->form }}
        <button type="submit"
                class="w-full rounded-lg uppercase flex flex-row justify-center items-center
                gap-2 text-center text-white bg-primary-700 bg-opacity-90 hover:bg-opacity-100
                shadow hover:shadow-lg px-5 py-3 mt-5"
        >
            @lang('Sign in')
            <div wire:loading>
                <em class="fa fa-spin fa-spinner"></em>
            </div>
        </button>
    </form>
    <div class="w-full text-center mt-2 text-sm text-gray-500">
        @lang('Did you forget your password?')
        <br>
        @lang('No worries') <a href="{{ route('password.request') }}"
                               class="hover:underline text-primary-500 hover:text-primary-600">
            @lang('Click here to recover it')
        </a>
    </div>
</div>
