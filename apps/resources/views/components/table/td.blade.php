@props([
    'colspan' => 1,
])

<td colspan="{{ $colspan }}" class="px-6 py-4
    {{ $attributes->get('class') }}">
    {{ $slot }}
</td>