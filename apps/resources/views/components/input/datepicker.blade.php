@props([
    'id' => 'datetimepicker',
    'name' => null,
    'label' => 'Tanggal & Waktu',
    'value' => null,
    'error' => null,
])

@php
    $name = $name ?? $id;
@endphp

<div x-data="datetimePicker('{{ $value }}')" x-init="init()" class="mb-5 w-full flex flex-col gap-2 relative">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ $label }}</label>

    <div class="relative">
        <!-- Input utama -->
        <input
            type="text"
            id="{{ $id }}"
            @click="togglePicker"
            :value="formattedValue()"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg
                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                   dark:bg-gray-700 dark:border-gray-600 dark:text-white cursor-pointer"
            placeholder="YYYY-MM-DD HH:MM:SS"
        />

        <!-- POPUP PICKER -->
        <div
            x-show="show"
            @click.outside="show = false"
            x-cloak
            class="absolute z-50 mt-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg p-4 flex gap-6 w-max"
        >
            <!-- KALENDER -->
            <div>
                <div class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-200 mb-2">
                    <button type="button" @click="prevMonth" class="hover:text-blue-600">&larr;</button>
                    <span x-text="monthYear"></span>
                    <button type="button" @click="nextMonth" class="hover:text-blue-600">&rarr;</button>
                </div>
                <div class="grid grid-cols-7 text-xs text-center text-gray-500 dark:text-gray-400">
                    <template x-for="d in ['Su','Mo','Tu','We','Th','Fr','Sa']">
                        <div x-text="d" class="py-1"></div>
                    </template>
                </div>
                <div class="grid grid-cols-7 gap-1 text-sm">
                    <template x-for="blank in blankDays"><div></div></template>
                    <template x-for="(day, index) in daysInMonth" :key="index">
                        <button type="button"
                            @click="selectDate(day)"
                            x-text="day"
                            class="py-1 rounded-full w-8 h-8 text-center"
                            :class="{
                                'bg-blue-600 text-white': isSelectedDay(day),
                                'hover:bg-blue-100 dark:hover:bg-gray-700': true
                            }"
                        ></button>
                    </template>
                </div>
            </div>
            <!-- TIME PICKER -->
            <div class="flex flex-col gap-3 text-sm text-gray-800 dark:text-white">
                <div class="flex gap-2">
                    <!-- Jam -->
                    <div>
                        <p class="mb-1">Jam</p>
                        <div class="grid grid-cols-1 gap-1 max-h-40 overflow-y-auto scrollbar-hide">
                            <template x-for="h in 12">
                                <button type="button"
                                    @click="hour = pad(h); updateLivewire()"
                                    :class="hour === pad(h) ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-black dark:text-white'"
                                    class="px-2 py-1 rounded text-sm"
                                    x-text="pad(h)"
                                ></button>
                            </template>
                        </div>
                    </div>
                    <!-- Menit -->
                    <div>
                        <p class="mb-1">Menit</p>
                        <div class="grid grid-cols-1 gap-1 max-h-40 overflow-y-auto scrollbar-hide">
                            <template x-for="m in 60">
                                <button type="button"
                                    @click="minute = pad(m - 1); updateLivewire()"
                                    :class="minute === pad(m - 1) ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-black dark:text-white'"
                                    class="px-2 py-1 rounded text-sm"
                                    x-text="pad(m - 1)"
                                ></button>
                            </template>
                        </div>
                    </div>
                    <!-- Detik -->
                    <div>
                        <p class="mb-1">Detik</p>
                        <div class="grid grid-cols-1 gap-1 max-h-40 overflow-y-auto scrollbar-hide">
                            <template x-for="s in 60">
                                <button type="button"
                                    @click="second = pad(s - 1); updateLivewire()"
                                    :class="second === pad(s - 1) ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-black dark:text-white'"
                                    class="px-2 py-1 rounded text-sm"
                                    x-text="pad(s - 1)"
                                ></button>
                            </template>
                        </div>
                    </div>
                    <!-- AM/PM -->
                    <div class="mt-6 flex flex-col gap-2">
                        <button type="button" @click="ampm = 'AM'; updateLivewire()" :class="ampm === 'AM' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700'" class="px-3 py-1 rounded">AM</button>
                        <button type="button" @click="ampm = 'PM'; updateLivewire()" :class="ampm === 'PM' ? 'bg-blue-500 text-white ' : 'bg-gray-200 dark:bg-gray-700'" class="px-3 py-1 rounded">PM</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hidden input for Livewire -->
    <input type="hidden" x-ref="hiddenInput" wire:model.defer="{{ $name }}" name="{{ $name }}">
    @if($error)
        <p class="text-sm text-red-600 dark:text-red-500 mt-1">{{ $error }}</p>
    @endif
</div>

<script>
    function datetimePicker(initialValue = '') {
        return {
            show: false,
            today: new Date(),
            selectedDate: null,
            currentMonth: null,
            currentYear: null,
            daysInMonth: [],
            blankDays: [],
            hour: '12',
            minute: '00',
            second: '00',
            ampm: 'AM',

            init() {
                const now = new Date();
                this.currentMonth = now.getMonth();
                this.currentYear = now.getFullYear();
                const rawHour = now.getHours();
                if (initialValue) {
                    const dt = new Date(initialValue.replace(' ', 'T')); // YYYY-MM-DD HH:MM:SS → ISO
                    if (!isNaN(dt)) {
                        this.selectedDate = dt;
                        let rawHour = dt.getHours();
                        this.ampm = rawHour >= 12 ? 'PM' : 'AM';
                        let displayHour = rawHour % 12 || 12;

                        this.hour = this.pad(displayHour);
                        this.minute = this.pad(dt.getMinutes());
                        this.second = this.pad(dt.getSeconds());
                    }
                } else {
                    this.selectedDate = null;
                }
                this.getCalendar();
                this.updateLivewire();
            },

            togglePicker() {
                this.show = !this.show;
            },

            pad(n) {
                return String(n).padStart(2, '0');
            },

            formatDate(date) {
                return `${date.getFullYear()}-${this.pad(date.getMonth() + 1)}-${this.pad(date.getDate())}`;
            },

            formattedValue() {
                if (!this.selectedDate) return '';
                let h = parseInt(this.hour);
                if (this.ampm === 'PM' && h !== 12) h += 12;
                if (this.ampm === 'AM' && h === 12) h = 0;
                return `${this.formatDate(this.selectedDate)} ${this.pad(h)}:${this.minute}:${this.second}`;
            },

            updateLivewire() {
                this.$refs.hiddenInput.value = this.formattedValue();
                this.$refs.hiddenInput.dispatchEvent(new Event('input'));
            },

            selectDate(day) {
                this.selectedDate = new Date(this.currentYear, this.currentMonth, day);
                this.updateLivewire();
            },

            isSelectedDay(day) {
                return this.selectedDate &&
                    this.selectedDate.getDate() === day &&
                    this.selectedDate.getMonth() === this.currentMonth &&
                    this.selectedDate.getFullYear() === this.currentYear;
            },

            prevMonth() {
                if (--this.currentMonth < 0) {
                    this.currentMonth = 11;
                    this.currentYear--;
                }
                this.getCalendar();
            },

            nextMonth() {
                if (++this.currentMonth > 11) {
                    this.currentMonth = 0;
                    this.currentYear++;
                }
                this.getCalendar();
            },

            getCalendar() {
                const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                const firstDay = new Date(this.currentYear, this.currentMonth, 1).getDay();
                this.blankDays = Array.from({ length: firstDay });
                this.daysInMonth = Array.from({ length: daysInMonth }, (_, i) => i + 1);
            },

            get monthYear() {
                const months = [
                    'January','February','March','April','May','June',
                    'July','August','September','October','November','December'
                ];
                return `${months[this.currentMonth]} ${this.currentYear}`;
            }
        };
    }
</script>
