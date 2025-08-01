<div @class(['single-property-booking-calendar', $class ?? null])>
    <div class="h7 title fw-7">{{ trans('plugins/real-estate::property.see_available_dates') }}</div>
    
    <div class="booking-calendar-wrapper">
        <div id="booking-calendar-inline"></div>
        
        <div class="booking-legend mt-3">
            <div class="legend-item">
                <div class="legend-color legend-booked"></div>
                <span>{{ trans('plugins/real-estate::property.booked') }}</span>
            </div>
            <div class="legend-item">
                <div class="legend-color legend-available"></div>
                <span>{{ trans('plugins/real-estate::property.available') }}</span>
            </div>
        </div>
    </div>
</div>

<style>
.booking-calendar-wrapper {
    margin-top: 1rem;
}

#booking-calendar-inline {
    display: flex;
    justify-content: center;
}

/* Flatpickr custom styles for booked dates */
.flatpickr-calendar .flatpickr-day.booked-date {
    background-color: #ff8c00 !important;
    color: white !important;
    border-color: #ff8c00 !important;
    cursor: not-allowed !important;
}

.flatpickr-calendar .flatpickr-day.booked-date:hover {
    background-color: #ff7700 !important;
    border-color: #ff7700 !important;
}

.flatpickr-calendar .flatpickr-day.available-date {
    background-color: #ffffff !important;
    color: #333 !important;
    border-color: #ddd !important;
}

.flatpickr-calendar .flatpickr-day.available-date:hover {
    background-color: #e9ecef !important;
    border-color: #adb5bd !important;
}

.booking-legend {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
    font-size: 0.875rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 3px;
    border: 1px solid #ddd;
}

.legend-booked {
    background-color: #ff8c00;
    border-color: #ff8c00;
}

.legend-available {
    background-color: #ffffff;
    border-color: #ddd;
}

/* Make the inline calendar look better */
.flatpickr-calendar.inline {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 8px;
    border: 1px solid #e9ecef;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarContainer = document.getElementById('booking-calendar-inline');
    const bookedDates = @json($property->booked_dates ?? []);
    
    if (typeof flatpickr !== 'undefined' && calendarContainer) {
        flatpickr(calendarContainer, {
            inline: true,
            mode: 'single',
            dateFormat: 'Y-m-d',
            disable: bookedDates,
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                // Fix timezone issue by using local date formatting
                const year = dayElem.dateObj.getFullYear();
                const month = String(dayElem.dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dayElem.dateObj.getDate()).padStart(2, '0');
                const dateStr = `${year}-${month}-${day}`;
                
                if (bookedDates.includes(dateStr)) {
                    dayElem.classList.add('booked-date');
                    dayElem.title = 'This date is already booked';
                } else {
                    dayElem.classList.add('available-date');
                    dayElem.title = 'This date is available for booking';
                }
            },
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    // Fix timezone issue by using local date formatting
                    const selectedDate = selectedDates[0];
                    const year = selectedDate.getFullYear();
                    const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
                    const day = String(selectedDate.getDate()).padStart(2, '0');
                    const selectedDateStr = `${year}-${month}-${day}`;
                    
                    if (bookedDates.includes(selectedDateStr)) {
                        instance.clear();
                        alert('{{ trans('plugins/real-estate::property.date_already_booked') }}');
                    }
                }
            }
        });
    } else {
        // Fallback display when Flatpickr is not available
        const fallbackHtml = `
            <div class="calendar-fallback">
                <h6>{{ trans('plugins/real-estate::property.booked_dates_label') }}</h6>
                <div class="booked-dates-list">
                    ${bookedDates.length > 0 ? bookedDates.join(', ') : '{{ trans('plugins/real-estate::property.no_booked_dates') }}'}
                </div>
            </div>
        `;
        calendarContainer.innerHTML = fallbackHtml;
    }
});
</script>