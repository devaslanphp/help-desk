@if($user)
    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-full shadow"
         style="width: {{ $size }}px; height:{{ $size }}px;"/>
@endif
