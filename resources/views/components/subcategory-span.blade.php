@if($subcategory || $subcategory == "Select new subcategory")
    <span class="px-3 py-1 rounded-full flex flex-row justify-center items-center gap-2 text-sm <?php if($subcategory == "Select new subcategory") { echo 'animate-pulse'; } ?> "
        style="color: {{ $subcategory->text_color ?? '#ffffff'}}; background-color: {{$subcategory->bg_color ?? '#000000'}};"
    >
        {{ $subcategory->title ?? "Select new subcategory"}}
    </span>
@endif