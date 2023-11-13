@props(['name' => '', 'id' => '', 'placeholder' => ''])
<textarea
    rows="4"
    name="{{ $name }}"
    id="{{ $id }}"
    placeholder="{{ $placeholder }}"
    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
    focus:ring-blue-500 focus:border-blue-500">{{ $slot }}</textarea>
