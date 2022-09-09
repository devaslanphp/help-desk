<div class="w-full flex flex-col justify-start items-start gap-5" id="tickets">
    <div class="w-full flex flex-row justify-start items-center gap-3 overflow-x-auto menu">
        @foreach($menu as $item)
            <button wire:click="selectMenu('{{ $item }}')" type="button" class="item {{ $activeMenu === $item ? 'active' : '' }}">
                @lang($item)
            </button>
        @endforeach
    </div>
</div>
