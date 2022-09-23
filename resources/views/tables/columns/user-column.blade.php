<div class="flex items-center py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
    <x-user-avatar :user="$getState()" />
    <div class="pl-3">
        <div class="text-base font-semibold">{{ $getState()->name }}</div>
        <div class="font-normal text-gray-500">{{ $getState()->email }}</div>
    </div>
</div>
