<div class="w-full flex flex-col justify-center items-center text-center">
    <span class="lg:text-3xl md:text-2xl text-xl font-bold text-gray-700">Forgot password?</span>
    <span class="font-medium text-gray-400 mt-2">No worries! Just type your email and click submit button and you will receive a recovery link by email</span>
    <form wire:submit.prevent="login" class="w-full mt-5">
        {{ $this->form }}
        <button type="submit" class="w-full rounded-lg uppercase flex flex-row justify-center items-center text-center text-white bg-primary-700 px-5 py-3 mt-5">
            Submit
        </button>
    </form>
    <div class="w-full text-center mt-2 text-sm text-gray-500">
        <a href="{{ route('auth.login') }}" class="hover:underline text-primary-500 hover:text-primary-600">Back to sign in page</a>
    </div>
</div>
