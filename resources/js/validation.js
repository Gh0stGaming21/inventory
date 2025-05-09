/**
 * Inventory System Form Validation Library
 * 
 * This library provides client-side validation functions for the inventory system forms.
 */

// Validation rules object
const ValidationRules = {
    // Common validation methods
    required: (value, message = 'This field is required') => {
        value = value.toString().trim();
        return value.length > 0 ? null : message;
    },
    
    minLength: (value, min, message = `Must be at least ${min} characters`) => {
        value = value.toString().trim();
        return value.length >= min ? null : message;
    },
    
    maxLength: (value, max, message = `Cannot exceed ${max} characters`) => {
        value = value.toString().trim();
        return value.length <= max ? null : message;
    },
    
    numeric: (value, message = 'Must be a valid number') => {
        return !isNaN(parseFloat(value)) && isFinite(value) ? null : message;
    },
    
    min: (value, min, message = `Must be at least ${min}`) => {
        return parseFloat(value) >= min ? null : message;
    },
    
    max: (value, max, message = `Cannot exceed ${max}`) => {
        return parseFloat(value) <= max ? null : message;
    },
    
    pattern: (value, regex, message = 'Invalid format') => {
        return regex.test(value) ? null : message;
    },
    
    decimalPlaces: (value, places = 2, message = `Must have at most ${places} decimal places`) => {
        const regex = new RegExp(`^\\d+(\\.\\d{1,${places}})?$`);
        return regex.test(value) ? null : message;
    },
    
    // Specific field validators
    validateProductName: (value) => {
        let error = ValidationRules.required(value, 'Product name is required');
        if (error) return error;
        
        error = ValidationRules.minLength(value, 3, 'Product name must be at least 3 characters');
        if (error) return error;
        
        error = ValidationRules.maxLength(value, 255, 'Product name cannot exceed 255 characters');
        return error;
    },
    
    validateCategoryName: (value) => {
        let error = ValidationRules.required(value, 'Category name is required');
        if (error) return error;
        
        error = ValidationRules.minLength(value, 2, 'Category name must be at least 2 characters');
        if (error) return error;
        
        error = ValidationRules.maxLength(value, 255, 'Category name cannot exceed 255 characters');
        return error;
    },
    
    validateDescription: (value) => {
        let error = ValidationRules.required(value, 'Description is required');
        if (error) return error;
        
        error = ValidationRules.minLength(value, 10, 'Description must be at least 10 characters');
        if (error) return error;
        
        error = ValidationRules.maxLength(value, 2000, 'Description cannot exceed 2000 characters');
        return error;
    },
    
    validatePrice: (value) => {
        let error = ValidationRules.required(value, 'Price is required');
        if (error) return error;
        
        error = ValidationRules.numeric(value, 'Price must be a valid number');
        if (error) return error;
        
        error = ValidationRules.min(value, 0.01, 'Price must be at least 0.01');
        if (error) return error;
        
        error = ValidationRules.max(value, 9999999.99, 'Price cannot exceed 9,999,999.99');
        if (error) return error;
        
        error = ValidationRules.decimalPlaces(value, 2, 'Price must have at most 2 decimal places');
        return error;
    },
    
    validateQuantity: (value) => {
        let error = ValidationRules.required(value, 'Quantity is required');
        if (error) return error;
        
        if (value % 1 !== 0) {
            return 'Quantity must be a whole number';
        }
        
        error = ValidationRules.min(value, 0, 'Quantity cannot be negative');
        if (error) return error;
        
        error = ValidationRules.max(value, 99999, 'Quantity cannot exceed 99,999 units');
        return error;
    },
    
    validateSku: (value) => {
        if (!value) return null; // SKU is optional
        
        let error = ValidationRules.maxLength(value, 50, 'SKU cannot exceed 50 characters');
        if (error) return error;
        
        error = ValidationRules.pattern(value, /^[A-Za-z0-9\-_.]+$/, 'SKU may only contain letters, numbers, dashes, underscores, and periods');
        return error;
    },
    
    validateMinimumStock: (value, quantity) => {
        if (!value) return null; // Minimum stock is optional
        
        if (value % 1 !== 0) {
            return 'Minimum stock must be a whole number';
        }
        
        let error = ValidationRules.min(value, 0, 'Minimum stock cannot be negative');
        if (error) return error;
        
        error = ValidationRules.max(value, 99999, 'Minimum stock cannot exceed 99,999 units');
        if (error) return error;
        
        if (parseInt(value) > parseInt(quantity)) {
            return 'Minimum stock cannot be greater than current quantity';
        }
        
        return null;
    }
};

// Form validator class
class FormValidator {
    constructor(formId, options = {}) {
        this.form = document.getElementById(formId);
        this.options = {
            validateOnInput: true,
            validateOnBlur: true,
            validateOnSubmit: true,
            showErrorsOnSubmit: true,
            ...options
        };
        
        this.fields = {};
        this.isValid = true;
        
        if (!this.form) {
            console.error(`Form with ID "${formId}" not found`);
            return;
        }
        
        this.setupEventListeners();
    }
    
    setupEventListeners() {
        if (this.options.validateOnSubmit) {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        }
    }
    
    addField(fieldId, validationFn, options = {}) {
        const field = document.getElementById(fieldId);
        
        if (!field) {
            console.error(`Field with ID "${fieldId}" not found`);
            return this;
        }
        
        this.fields[fieldId] = {
            element: field,
            validationFn,
            options: {
                errorClass: 'border-red-500',
                errorMessageClass: 'text-red-500 text-sm mt-1',
                ...options
            }
        };
        
        // Add event listeners for real-time validation
        if (this.options.validateOnInput) {
            field.addEventListener('input', () => this.validateField(fieldId));
        }
        
        if (this.options.validateOnBlur) {
            field.addEventListener('blur', () => this.validateField(fieldId));
        }
        
        return this;
    }
    
    validateField(fieldId, relatedFields = {}) {
        const field = this.fields[fieldId];
        
        if (!field) {
            console.error(`Field "${fieldId}" not registered for validation`);
            return false;
        }
        
        // Remove existing error message
        this.removeErrorMessage(fieldId);
        
        // Get the field value
        const value = field.element.value;
        
        // Call the validation function
        const error = field.validationFn(value, relatedFields);
        
        if (error) {
            this.showError(fieldId, error);
            return false;
        }
        
        // Remove error styling
        field.element.classList.remove(field.options.errorClass);
        return true;
    }
    
    showError(fieldId, message) {
        const field = this.fields[fieldId];
        
        // Add error class to the field
        field.element.classList.add(field.options.errorClass);
        
        // Create and append error message
        const errorElement = document.createElement('div');
        errorElement.className = field.options.errorMessageClass;
        errorElement.id = `${fieldId}-error`;
        errorElement.textContent = message;
        
        // Insert error message after the field
        field.element.parentNode.insertBefore(errorElement, field.element.nextSibling);
    }
    
    removeErrorMessage(fieldId) {
        const errorElement = document.getElementById(`${fieldId}-error`);
        if (errorElement) {
            errorElement.remove();
        }
    }
    
    validateAll() {
        this.isValid = true;
        
        // Collect all field values for interdependent validations
        const fieldValues = {};
        Object.keys(this.fields).forEach(id => {
            fieldValues[id] = this.fields[id].element.value;
        });
        
        // Validate each field
        Object.keys(this.fields).forEach(id => {
            const isFieldValid = this.validateField(id, fieldValues);
            if (!isFieldValid) {
                this.isValid = false;
            }
        });
        
        return this.isValid;
    }
    
    handleSubmit(e) {
        if (!this.validateAll() && this.options.showErrorsOnSubmit) {
            e.preventDefault();
            
            // Scroll to the first error
            const firstErrorField = Object.keys(this.fields).find(id => 
                document.getElementById(`${id}-error`)
            );
            
            if (firstErrorField) {
                this.fields[firstErrorField].element.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                this.fields[firstErrorField].element.focus();
            }
        }
    }
}

// Export the validation components
window.ValidationRules = ValidationRules;
window.FormValidator = FormValidator;
