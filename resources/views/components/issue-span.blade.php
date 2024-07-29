@if($issue || $issue == "Select new issue")
@props(['issue', 'disableStyles' => false])
@if (!$disableStyles)
    <span class="px-3 py-1 rounded-full flex-row justify-center items-center gap-2 text-sm <?php if($issue == "Select new issue") { echo 'animate-pulse'; } ?>"
        style="color: {{ $issue->text_color ?? '#ffffff'}}; background-color: {{$issue->bg_color ?? '#000000'}};"
    >
    @endif
        {{ $issue->title ?? "Select new issue"}}
    </span>
    
@endif