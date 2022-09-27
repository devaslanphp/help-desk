@if($role && config('system.roles.' . $role))
    <span class="px-2 py-1 rounded-lg
        {{ __(config('system.roles.' . $role . '.bg-color')) }}
        {{ __(config('system.roles.' . $role . '.text-color')) }}">
        {{ __(config('system.roles.' . $role . '.title')) }}
    </span>
@endif
