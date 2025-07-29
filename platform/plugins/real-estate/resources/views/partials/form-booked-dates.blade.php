<div class="form-group mb-3" id="booked-dates-wrapper">
    <label class="control-label required">{{ trans('plugins/real-estate::property.booked_dates') }}</label>
    <div class="form-group">
        <input type="text" 
               id="booked-dates-picker" 
               class="form-control @error('booked_dates') is-invalid @enderror" 
               placeholder="{{ trans('plugins/real-estate::property.select_booked_dates') }}"
               readonly
               required>
        <div id="booked-dates-hidden-inputs"></div>
        @error('booked_dates')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="help-block">
        <small class="text-muted">{{ trans('plugins/real-estate::property.booked_dates_help') }} <span class="text-danger">*</span></small>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const picker = document.getElementById('booked-dates-picker');
    const hiddenInputsContainer = document.getElementById('booked-dates-hidden-inputs');
    
    let selectedDates = [];
    
    // Initialize with existing dates
    const existingDates = @json(old('booked_dates', $bookedDates ?? []));
    selectedDates = existingDates || [];
    updateDisplayText();
    updateHiddenInputs();
    
    // Initialize Flatpickr
    if (typeof flatpickr !== 'undefined') {
        flatpickr(picker, {
            mode: 'multiple',
            dateFormat: 'Y-m-d',
            defaultDate: selectedDates,
            onChange: function(selectedDatesArray, dateStr, instance) {
                selectedDates = selectedDatesArray.map(date => {
                    return date.toISOString().split('T')[0];
                });
                updateHiddenInputs();
                updateDisplayText();
                validateSelection();
            }
        });
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
        
        // Add remove functionality
        picker.addEventListener('dblclick', function() {
            if (selectedDates.length > 0) {
                selectedDates.pop();
                updateHiddenInputs();
                updateDisplayText();
                validateSelection();
            }
        });
    }
    
    function updateHiddenInputs() {
        // Clear existing hidden inputs
        hiddenInputsContainer.innerHTML = '';
        
        // Create hidden input for each selected date
        selectedDates.forEach(function(date, index) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'booked_dates[]';
            input.value = date;
            hiddenInputsContainer.appendChild(input);
        });
    }
    
    function updateDisplayText() {
        if (selectedDates.length === 0) {
            picker.value = '';
            picker.placeholder = '{{ trans('plugins/real-estate::property.select_booked_dates') }}';
        } else if (selectedDates.length === 1) {
            picker.value = selectedDates[0];
        } else {
            picker.value = selectedDates.length + ' {{ trans('plugins/real-estate::property.dates_selected') }}';
        }
    }
    
    function validateSelection() {
        const isValid = selectedDates.length > 0;
        if (isValid) {
            picker.classList.remove('is-invalid');
            picker.classList.add('is-valid');
        } else {
            picker.classList.remove('is-valid');
            picker.classList.add('is-invalid');
        }
        return isValid;
    }
    
    // Form submission validation
    const form = picker.closest('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateSelection()) {
                e.preventDefault();
                picker.focus();
                alert('{{ trans('plugins/real-estate::property.booked_dates_required') }}');
                return false;
            }
        });
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
.control-label.required::after {
    content: " *";
    color: #dc3545;
}
</style>