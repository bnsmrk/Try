<x-filament-panels::page>
    <div>
        <div class="flex justify-between items-center gap-2 mb-2">
            <div></div>
            @if (!auth()->user()->isClient())
                <div>
                    <x-filament::modal width="4xl">
                        <x-slot name="trigger">
                            <x-filament::button>
                                New Event
                            </x-filament::button>
                        </x-slot>
                        {{ $this->form }}

                        <x-slot name="footerActions">
                            <x-filament::button wire:click.prevent="addEvent" wire:loading.attr="disabled">
                                Submit
                            </x-filament::button>
                        </x-slot>
                    </x-filament::modal>
                </div>
            @endif
        </div>

        <div id="calendar"
            class="fi-ta-ctn divide-y divide-gray-200 p-4 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
        </div>
    </div>
</x-filament-panels::page>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
<script type="module">
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        initialView: 'dayGridMonth',
        selectable: true,
        events: @json($calendarData),
        eventMouseEnter: function(data) {

            let tooltipContent = `
            <div>
            <h1 >
            <strong> EVENT INFORMATION</strong>
            </h1>
            <div><strong>Name:</strong> <p style="padding-left: 15px"> - ${data.event.extendedProps.name} </p> </div>
            <div><strong>Title:</strong><br> <p style="padding-left: 15px"> - ${data.event.title} </p></div>
            <div><strong>Description:</strong><br> <p style="padding-left: 15px"> - ${data.event.extendedProps.description} </p></div>
            <div><strong>Date:</strong><br> <p style="padding-left: 15px"> - ${data.event.start} </p></div>
            </div>
            `;
            let tooltip = tippy(data.el, {
                content: tooltipContent,
                placement: "top",
                interactive: true,
                arrow: true,
                theme: "material",
                appendTo: document.body,
                allowHTML: true,
                duration: [1, 1],
                animation: "scale-extreme",
            });
        }
    });

    calendar.render();
</script>
