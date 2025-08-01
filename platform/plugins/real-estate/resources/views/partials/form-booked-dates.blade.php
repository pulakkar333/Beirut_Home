<div class="form-group mb-3" id="booked-dates-wrapper">
    <label class="control-label">{{ trans('plugins/real-estate::property.calendar') }}</label>
    <div class="form-group">
        <input type="text" 
               id="booked-dates-picker" 
               class="form-control @error('booked_dates') is-invalid @enderror" 
               placeholder="{{ trans('plugins/real-estate::property.select_booked_dates') }}"
               readonly
               >
        <div id="booked-dates-hidden-inputs"></div>
        @error('booked_dates')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="help-block">
        <small class="text-muted">{{ trans('plugins/real-estate::property.booked_dates_help') }}</small>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const picker = document.getElementById('booked-dates-picker');
    const hiddenInputsContainer = document.getElementById('booked-dates-hidden-inputs');
    
    let selectedDates = [];
    
    // Initialize with existing dates
    const existingDates = @json(old('calender', $bookedDates ?? []));
    selectedDates = existingDates || [];
    updateDisplayText();
    updateHiddenInputs();
    
    // Initialize Flatpickr
    if (typeof flatpickr !== 'undefined') {
        const fp = flatpickr(picker, {
            mode: 'multiple',
            dateFormat: 'Y-m-d',
            defaultDate: selectedDates,
            onChange: function(selectedDatesArray, dateStr, instance) {
                // Update selectedDates array with the new selection
                if (selectedDatesArray.length === 0) {
                    selectedDates = [];
                } else {
                    selectedDates = selectedDatesArray.map(date => {
                        // Use local date to avoid timezone issues
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    });
                }
                updateHiddenInputs();
                updateDisplayText();
                validateSelection();
            },
            onReady: function(selectedDatesArray, dateStr, instance) {
                // Ensure initial dates are properly set
                updateHiddenInputs();
                updateDisplayText();
            }
        });
        
        // Store flatpickr instance for later use
        picker._flatpickr = fp;
    } else {
        // Fallback for basic date selection
        picker.addEventListener('click', function() {
            const dateInput = document.createElement('input');
            dateInput.type = 'date';
            dateInput.style.position = 'absolute';
            dateInput.style.left = '-9999px';
            document.body.appendChild(dateInput);
            
            dateInput.addEventListener('change', function() {
                if (this.value && !selectedDates.includes(this.value)) {
                    selectedDates.push(this.value);
                    selectedDates.sort();
                    updateHiddenInputs();
                    updateDisplayText();
                    validateSelection();
                }
                document.body.removeChild(this);
            });
            
            dateInput.click();
        });
        

    }
    
    function updateHiddenInputs() {
        // Clear existing hidden inputs
        hiddenInputsContainer.innerHTML = '';
        
        // Always create hidden inputs, even if empty array
        if (selectedDates.length > 0) {
            selectedDates.forEach(function(date, index) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'booked_dates[]';
                input.value = date;
                hiddenInputsContainer.appendChild(input);
            });
        } else {
            // Create an empty hidden input to ensure the field is submitted as empty array
            const emptyInput = document.createElement('input');
            emptyInput.type = 'hidden';
            emptyInput.name = 'booked_dates';
            emptyInput.value = '';
            hiddenInputsContainer.appendChild(emptyInput);
        }
    }
    
    function updateDisplayText() {
        if (selectedDates.length === 0) {
            picker.value = '';
            picker.placeholder = '{{ trans('plugins/real-estate::property.select_booked_dates') }}';
            // Hide the calendar section if no dates selected
            const calendarSection = document.querySelector('.single-property-booking-calendar');
            if (calendarSection) {
                calendarSection.style.display = 'none';
            }
        } else if (selectedDates.length === 1) {
            picker.value = selectedDates[0];
            // Show the calendar section if dates are selected
            const calendarSection = document.querySelector('.single-property-booking-calendar');
            if (calendarSection) {
                calendarSection.style.display = 'block';
            }
        } else {
            picker.value = selectedDates.length + ' {{ trans('plugins/real-estate::property.dates_selected') }}';
            // Show the calendar section if dates are selected
            const calendarSection = document.querySelector('.single-property-booking-calendar');
            if (calendarSection) {
                calendarSection.style.display = 'block';
            }
        }
    }
    
    function validateSelection() {
        // Since booked_dates is now optional, always return true
        picker.classList.remove('is-invalid');
        if (selectedDates.length > 0) {
            picker.classList.add('is-valid');
        } else {
            picker.classList.remove('is-valid');
        }
        return true;
    }
});
</script>

<style>
#booked-dates-picker {
    cursor: pointer;
}
#booked-dates-picker:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
#booked-dates-picker.is-invalid {
    border-color: #dc3545;
}
#booked-dates-picker.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
#booked-dates-picker.is-valid {
    border-color: #28a745;
}
#booked-dates-picker.is-valid:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

</style>