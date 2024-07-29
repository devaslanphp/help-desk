@if($category)
    <span class="px-3 py-1 rounded-full flex flex-row justify-center items-center gap-2 text-sm"
        style="color: {{ $category->text_color }}; background-color: {{$category->bg_color}};"
    >
        {{ $category->title }}
    </span>
@endif