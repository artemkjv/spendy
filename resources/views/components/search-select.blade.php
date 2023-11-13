@props(['units' => [], 'selected' => null, 'selectedCallback' => 'function(selected) {}', 'class'])
<div class="flex flex-col {{ $class }}">
    <div class="w-full flex flex-col items-center">
        <div class="w-full">
            <div init="init()" x-data="selectConfigs()" class="flex flex-col items-center relative">
                <div class="w-full">
                    <div @click.away="close()" class="my-2 p-1 bg-white flex border border-gray-200 rounded">
                        <input
                            x-model="filter"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            @mousedown="open()"
                            @keydown.enter.stop.prevent="selectOption()"
                            @keydown.arrow-up.prevent="focusPrevOption()"
                            @keydown.arrow-down.prevent="focusNextOption()"
                            class="p-1 px-2 appearance-none outline-none w-full text-gray-800">
                        <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200">
                            <button @click="toggle()" type="button"
                                    class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none"
                                     :class="{'relative top-[-5px]': !isOpen()}"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <polyline x-show="!isOpen()" points="18 15 12 20 6 15"></polyline>
                                    <polyline x-show="isOpen()" points="18 15 12 9 6 15"></polyline>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div x-show="isOpen()"
                     class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
                    <div class="flex flex-col w-full">
                        <template x-for="(option, index) in filteredOptions()" :key="index">
                            <div @click="onOptionClick(index)" :class="classOption(option.id, index)"
                                 :aria-selected="focusedOptionIndex === index">
                                <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                                    <div class="w-full items-center flex">
                                        <div class="mx-2 -mt-1"><span
                                                x-text="option.name"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .top-100 {
        top: 100%
    }

    .bottom-100 {
        bottom: 100%
    }

    .max-h-select {
        max-height: 300px;
    }
</style>

<script>

    let options = []
    let selected = null
    var selectedCallback = {!! $selectedCallback !!}

    @foreach($units as $parent)
    @php
        $parentName = $parent->uniq_id;
        $parentOfParent = $parent->unit;
        while ($parentOfParent !== null) {
            $parentName .= " - $parentOfParent->uniq_id";
            $parentOfParent = $parentOfParent->unit;
        }
    @endphp
    options.push({'id': '{{ $parent->id }}', 'name': '{{ $parentName }}'})
    @endforeach
    @if($selected)
        @php
            $selectedName = $selected->uniq_id;
            $parentOfSelected = $selected->unit;
            while ($parentOfSelected !== null) {
                $selectedName .= " - $parentOfSelected->uniq_id";
                $parentOfSelected = $parentOfSelected->unit;
            }
        @endphp
        selected = {'id': '{{ $selected->id }}', 'name': '{{ $selectedName }}'}
    @endif

    function selectConfigs() {
        return {
            filter: '',
            show: false,
            selected: selected,
            focusedOptionIndex: null,
            options: options,
            init() {
              this.filter = this.selectedName()
            },
            close() {
                this.show = false;
                this.filter = this.selectedName();
                this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : null;
            },
            open() {
                this.show = true;
                this.filter = '';
            },
            toggle() {
                if (this.show) {
                    this.close();
                } else {
                    this.open()
                }
            },
            isOpen() {
                return this.show === true
            },
            selectedName() {
                return this.selected ? this.selected.name : this.filter;
            },
            classOption(id, index) {
                const isSelected = this.selected ? (id == this.selected.id) : false;
                const isFocused = (index == this.focusedOptionIndex);
                return {
                    'cursor-pointer w-full border-gray-100 border-b hover:bg-blue-50': true,
                    'bg-blue-100': isSelected,
                    'bg-blue-50': isFocused
                };
            },
            filteredOptions() {
                return this.options
                    ? this.options.filter(option => {
                        return (option.name.toLowerCase().indexOf(this.filter) > -1)
                    })
                    : {}
            },
            onOptionClick(index) {
                this.focusedOptionIndex = index;
                this.selectOption();
            },
            selectOption() {
                if (!this.isOpen()) {
                    return;
                }
                this.focusedOptionIndex = this.focusedOptionIndex ?? 0;
                const selected = this.filteredOptions()[this.focusedOptionIndex]
                if (this.selected && this.selected.id == selected.id) {
                    this.filter = '';
                    this.selected = null;
                } else {
                    this.selected = selected;
                    this.filter = this.selectedName();
                }
                selectedCallback(this.selected)
                this.close();
            },
            focusPrevOption() {
                if (!this.isOpen()) {
                    return;
                }
                const optionsNum = Object.keys(this.filteredOptions()).length - 1;
                if (this.focusedOptionIndex > 0 && this.focusedOptionIndex <= optionsNum) {
                    this.focusedOptionIndex--;
                } else if (this.focusedOptionIndex == 0) {
                    this.focusedOptionIndex = optionsNum;
                }
            },
            focusNextOption() {
                const optionsNum = Object.keys(this.filteredOptions()).length - 1;
                if (!this.isOpen()) {
                    this.open();
                }
                if (this.focusedOptionIndex == null || this.focusedOptionIndex == optionsNum) {
                    this.focusedOptionIndex = 0;
                } else if (this.focusedOptionIndex >= 0 && this.focusedOptionIndex < optionsNum) {
                    this.focusedOptionIndex++;
                }
            }
        }

    }
</script>
