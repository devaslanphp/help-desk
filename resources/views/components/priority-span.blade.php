@if($priority || $priority == null)
@props(['priority', 'disableStyles' => false])
@if (!$disableStyles)
    <span class="px-3 py-1 rounded-full flex-row justify-center items-center gap-2 text-sm <?php if(!$priority) { echo 'animate-pulse'; } ?>"
    
          style="color: {{ $priority?->text_color ?? '#ffffff'}}; background-color: {{ $priority?->bg_color ?? '#000000'}};"
      
    >
        <em class="fa {{ $priority?->icon }}"></em>
    @endif
        {{ $priority?->title ?? "Select priority"}}
    </span>
@endif
