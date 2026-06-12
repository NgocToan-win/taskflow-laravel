<x-app-layout>
    <x-slot name="header">
        Lịch công việc
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow-sm border-0 rounded-3 p-4">
            <div id="calendar" class="min-h-[650px] text-dark"></div>
        </div>
    </div>

    <!-- FullCalendar CSS and JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'vi', 
                firstDay: 1,  
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,listMonth'
                },
                buttonText: {
                    today: 'Hôm nay',
                    month: 'Tháng',
                    week: 'Tuần',
                    list: 'DS'
                },
                // Responsive: trên mobile chuy?n sang ch? ?? danh sách t? ??ng
                windowResize: function(view) {
                    if (window.innerWidth < 768) {
                        calendar.changeView('listMonth');
                    } else {
                        calendar.changeView('dayGridMonth');
                    }
                },
                views: {
                    dayGridMonth: {
                        titleFormat: { year: 'numeric', month: 'long' }
                    },
                    dayGridWeek: {
                        titleFormat: { year: 'numeric', month: 'long', day: 'numeric' }
                    }
                },
                
                displayEventTime: false, 
                events: @json($events), 

                eventClick: function(info) {
                    const taskData = {
                        id: info.event.id,
                        title: info.event.title,
                        description: info.event.extendedProps.description,
                        status: info.event.extendedProps.status,
                        due_date: info.event.startStr
                    };

                    // Trigger the global window listener registered in task-modals component
                    window.dispatchEvent(new CustomEvent('open-edit-modal', { detail: taskData }));
                }
            });
            
            calendar.render();
        });
    </script>
    
    <x-task-modals />
</x-app-layout>