(function() {
    const steps = ['overview', 'payment', 'review'];
    const panels = new Map();
    const tabs = new Map();

    document.querySelectorAll('.checkout-step-panel').forEach(panel => {
        if (panel.dataset.step) {
            panels.set(panel.dataset.step, panel);
        }
    });

    document.querySelectorAll('.checkout-step').forEach(tab => {
        if (tab.dataset.stepTarget) {
            tabs.set(tab.dataset.stepTarget, tab);
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const currentStep = document.querySelector('.checkout-steps')?.dataset.activeStep || steps[0];
                const targetStep = tab.dataset.stepTarget;
                const currentIndex = steps.indexOf(currentStep);
                const targetIndex = steps.indexOf(targetStep);
                const isGoingBack = targetIndex < currentIndex;
                setStep(targetStep, { validate: !isGoingBack });
            });
        }
    });

    document.querySelectorAll('[data-next-step]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            setStep(btn.dataset.nextStep, { validate: true });
        });
    });

    document.querySelectorAll('[data-prev-step]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            setStep(btn.dataset.prevStep, { validate: false });
        });
    });

    function renderOrderSummary(currentStep) {
        const sidebar = document.getElementById('order-summary-sidebar');
        if (!sidebar) return;

        const card = sidebar.querySelector('.card');
        if (!card) return;

        let btn = card.querySelector('button');
        let finePrint = card.querySelector('.fine-print');
        let termsDiv = card.querySelector('.terms-agreement');

        if (!btn) {
            btn = document.createElement('button');
            btn.className = 'btn-primary full';
            btn.type = 'button';
            card.appendChild(btn);
        }

        if (currentStep === 'overview') {
            btn.textContent = 'Proceed to payment';
            btn.id = '';
            btn.setAttribute('data-next-step', 'payment');
            btn.onclick = (e) => {
                e.preventDefault();
                setStep('payment', { validate: true });
            };

            if (!finePrint) {
                finePrint = document.createElement('p');
                finePrint.className = 'fine-print';
                card.appendChild(finePrint);
            }
            finePrint.textContent = 'You can review shipping and tax before placing your order.';
            finePrint.style.display = '';

            if (termsDiv) termsDiv.style.display = 'none';

        } else if (currentStep === 'payment') {
            btn.textContent = 'Proceed to review';
            btn.id = '';
            btn.setAttribute('data-next-step', 'review');
            btn.onclick = (e) => {
                e.preventDefault();
                setStep('review', { validate: true });
            };

            if (finePrint) finePrint.style.display = 'none';
            if (termsDiv) termsDiv.style.display = 'none';

        } else if (currentStep === 'review') {
            if (!termsDiv) {
                termsDiv = document.createElement('div');
                termsDiv.className = 'terms-agreement';
                
                const label = document.createElement('label');
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = 'terms-checkbox';
                label.appendChild(checkbox);
                
                const span = document.createElement('span');
                span.appendChild(document.createTextNode('I have read and agreed to the '));
                const link = document.createElement('a');
                link.href = '#';
                link.target = '_blank';
                link.textContent = 'Terms and Conditions';
                span.appendChild(link);
                label.appendChild(span);
                termsDiv.appendChild(label);
                
                card.insertBefore(termsDiv, btn);
            }
            termsDiv.style.display = '';

            btn.textContent = 'Place order';
            btn.id = 'place-order-btn';
            btn.removeAttribute('data-next-step');
            btn.onclick = (e) => {
                e.preventDefault();
                const termsCheckbox = document.getElementById('terms-checkbox');
                if (termsCheckbox && !termsCheckbox.checked) {
                    alert('Please accept the Terms and Conditions to place your order.');
                    return;
                }
                document.dispatchEvent(new CustomEvent('placeorder', {
                    detail: { termsAccepted: true }
                }));
            };

            if (finePrint) finePrint.style.display = 'none';
        }
    }

    function setStep(step, { validate } = { validate: false }) {
        if (!steps.includes(step)) return;

        const currentStep = document.querySelector('.checkout-steps')?.dataset.activeStep || steps[0];

        if (validate && !validateStep(currentStep)) {
            return;
        }

        panels.forEach((panel, key) => {
            panel.classList.toggle('is-active', key === step);
        });

        tabs.forEach((tab, key) => {
            tab.classList.toggle('is-active', key === step);
            if (key === currentStep && hasStepData(currentStep)) {
                tab.classList.add('is-complete');
            }
        });

        const container = document.querySelector('.checkout-steps');
        if (container) {
            container.dataset.activeStep = step;
        }

        // Render order summary for current step
        renderOrderSummary(step);

        // Update review data if on review step
        if (step === 'review') {
            updateReviewData();
        }
    }

    function updateReviewData() {
        // Update Sold To section
        const customerNameEl = document.getElementById('review-customer-name');
        if (customerNameEl) {
            const value = document.getElementById('attention')?.value || '';
            customerNameEl.textContent = value;
        }

        const accountNameEl = document.getElementById('review-account-name');
        if (accountNameEl) {
            const value = document.getElementById('company')?.value || '';
            accountNameEl.textContent = value;
        }

        const phoneEl = document.getElementById('review-sold-to-phone');
        if (phoneEl) {
            const value = document.getElementById('phone')?.value || '';
            phoneEl.textContent = value;
        }

        const emailEl = document.getElementById('review-sold-to-email');
        if (emailEl) {
            const value = document.getElementById('email')?.value || '';
            emailEl.textContent = value;
        }

        // Update Ship To section
        const shippingMethodEl = document.getElementById('review-shipping-method');
        if (shippingMethodEl) {
            const radioBtn = document.querySelector('input[name="ship-method"]:checked');
            if (radioBtn) {
                const label = radioBtn.closest('label');
                const methodName = label?.querySelector('span')?.textContent || '';
                shippingMethodEl.textContent = methodName;
            }
        }

        const shipDateEl = document.getElementById('review-ship-date');
        if (shipDateEl) {
            const value = document.getElementById('requested-date')?.value || '';
            shipDateEl.textContent = value;
        }

        const addressEl = document.getElementById('review-ship-to-address');
        if (addressEl) {
            const select = document.getElementById('saved-addresses');
            if (select && select.value) {
                const selectedOption = select.options[select.selectedIndex];
                addressEl.textContent = selectedOption.textContent;
            }
        }

        // Update Payment section
        const paymentMethodEl = document.getElementById('review-payment-method');
        if (paymentMethodEl) {
            const radioBtn = document.querySelector('input[name="payment-method"]:checked');
            if (radioBtn) {
                const label = radioBtn.closest('label');
                const methodName = label?.querySelector('h3')?.textContent || '';
                paymentMethodEl.textContent = methodName;
            }
        }

        const billingAddressEl = document.getElementById('review-billing-address');
        if (billingAddressEl) {
            const street = document.getElementById('billing-street')?.value || '';
            const city = document.getElementById('billing-city')?.value || '';
            const state = document.getElementById('billing-state')?.value || '';
            const zip = document.getElementById('billing-zip')?.value || '';
            const fullAddress = [street, city, state, zip].filter(x => x).join(', ');
            billingAddressEl.textContent = fullAddress;
        }
    }

    function hasStepData(step) {
        if (step === 'overview') {
            const savedAddress = document.getElementById('saved-addresses');
            const addNew = document.getElementById('add-new-address');
            const requestedDate = document.getElementById('requested-date');
            const attention = document.getElementById('attention');
            const phone = document.getElementById('phone');
            const email = document.getElementById('email');

            if (addNew && addNew.checked) {
                const newStreet = document.getElementById('new-address-street');
                const newCity = document.getElementById('new-address-city');
                const newState = document.getElementById('new-address-state');
                const newZip = document.getElementById('new-address-zip');
                return (newStreet?.value.trim() && newCity?.value.trim() && newState?.value.trim() && newZip?.value.trim() &&
                    requestedDate?.value.trim() && attention?.value.trim() && phone?.value.trim() && email?.value.trim());
            } else {
                return (savedAddress?.value && requestedDate?.value.trim() && 
                    attention?.value.trim() && phone?.value.trim() && email?.value.trim());
            }
        }

        if (step === 'payment') {
            const paymentMethod = document.querySelector('input[name="payment-method"]:checked')?.value;

            if (paymentMethod === 'credit-card') {
                const cardNumber = document.getElementById('card-number');
                const expiryDate = document.getElementById('expiry-date');
                const cvv = document.getElementById('cvv');
                const cardName = document.getElementById('card-name');
                const billingStreet = document.getElementById('billing-street');
                const billingCity = document.getElementById('billing-city');
                const billingState = document.getElementById('billing-state');
                const billingZip = document.getElementById('billing-zip');
                return (cardNumber?.value.trim() && expiryDate?.value.trim() && 
                    cvv?.value.trim() && cardName?.value.trim() &&
                    billingStreet?.value.trim() && billingCity?.value.trim() &&
                    billingState?.value.trim() && billingZip?.value.trim());
            } else if (paymentMethod === 'net-due') {
                const netDuePo = document.getElementById('net-due-po');
                return (netDuePo?.value.trim());
            } else if (paymentMethod === 'pay-at-pickup') {
                return true;
            }
        }

        return false;
    }

    function validateStep(step) {
        clearErrors();
        let valid = true;

        if (step === 'overview') {
            const savedAddress = document.getElementById('saved-addresses');
            const addNew = document.getElementById('add-new-address');
            const requestedDate = document.getElementById('requested-date');
            const attention = document.getElementById('attention');
            const phone = document.getElementById('phone');
            const email = document.getElementById('email');

            if (addNew.checked) {
                const newStreet = document.getElementById('new-address-street');
                const newCity = document.getElementById('new-address-city');
                const newState = document.getElementById('new-address-state');
                const newZip = document.getElementById('new-address-zip');

                [newStreet, newCity, newState, newZip].forEach((field) => {
                    if (field && field.value.trim() === '') {
                        markError(field, 'Required');
                        valid = false;
                    }
                });
            } else if (savedAddress && savedAddress.value === '') {
                markError(savedAddress, 'Select an address or check to add new');
                valid = false;
            }

            if (requestedDate && requestedDate.value.trim() === '') {
                markError(requestedDate, 'Enter a requested ship date');
                valid = false;
            }

            [attention, phone, email].forEach((field) => {
                if (field && field.value.trim() === '') {
                    markError(field, 'Required');
                    valid = false;
                }
            });
        }

        if (step === 'payment') {
            const paymentMethod = document.querySelector('input[name="payment-method"]:checked')?.value;

            if (paymentMethod === 'credit-card') {
                const cardNumber = document.getElementById('card-number');
                const expiryDate = document.getElementById('expiry-date');
                const cvv = document.getElementById('cvv');
                const cardName = document.getElementById('card-name');
                const billingStreet = document.getElementById('billing-street');
                const billingCity = document.getElementById('billing-city');
                const billingState = document.getElementById('billing-state');
                const billingZip = document.getElementById('billing-zip');

                [cardNumber, expiryDate, cvv, cardName, billingStreet, billingCity, billingState, billingZip].forEach((field) => {
                    if (field && field.value.trim() === '') {
                        markError(field, 'Required');
                        valid = false;
                    }
                });
            } else if (paymentMethod === 'net-due') {
                const netDueDays = document.getElementById('net-due-days');
                const netDuePo = document.getElementById('net-due-po');

                if (netDuePo && netDuePo.value.trim() === '') {
                    markError(netDuePo, 'PO Number is required');
                    valid = false;
                }
            }
        }

        return valid;
    }

    function markError(el, message) {
        el.classList.add('input-error');
        const hint = document.createElement('div');
        hint.className = 'error-text';
        hint.textContent = message;
        if (el.parentElement && !el.parentElement.querySelector('.error-text')) {
            el.parentElement.appendChild(hint);
        }
    }

    function clearErrors() {
        document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
        document.querySelectorAll('.error-text').forEach(el => el.remove());
    }

    function initCheckout() {
        setStep('overview');

        const addNewAddressCheckbox = document.getElementById('add-new-address');
        const savedAddressSection = document.getElementById('saved-address-section');
        const newAddressSection = document.getElementById('new-address-section');

        if (addNewAddressCheckbox) {
            addNewAddressCheckbox.addEventListener('change', (e) => {
                if (e.target.checked) {
                    savedAddressSection.style.display = 'none';
                    newAddressSection.style.display = 'block';
                } else {
                    savedAddressSection.style.display = 'block';
                    newAddressSection.style.display = 'none';
                }
            });
        }

        const paymentMethodCards = document.querySelectorAll('.payment-method-card');
        
        paymentMethodCards.forEach(card => {
            const radio = card.querySelector('input[name="payment-method"]');
            const header = card.querySelector('.payment-method-header');
            
            header.addEventListener('click', (e) => {
                if (e.target.tagName !== 'INPUT') {
                    radio.checked = true;
                }
                
                paymentMethodCards.forEach(c => c.classList.remove('is-expanded'));
                card.classList.add('is-expanded');
            });
            
            radio.addEventListener('change', () => {
                paymentMethodCards.forEach(c => c.classList.remove('is-expanded'));
                card.classList.add('is-expanded');
            });
        });

        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);

                if (value.length > 0 && value[0] !== '1') {
                    value = '1' + value;
                }

                let formatted = '';
                if (value.length > 0) formatted += '+' + value.slice(0, 1);
                if (value.length > 1) formatted += ' (' + value.slice(1, 4);
                if (value.length > 4) formatted += ') ' + value.slice(4, 7);
                if (value.length > 7) formatted += '-' + value.slice(7, 11);

                e.target.value = formatted;
            });

            phoneInput.addEventListener('blur', (e) => {
                let value = e.target.value.replace(/\D/g, '');

                if (value.length > 0 && value[0] !== '1') {
                    value = '1' + value;
                } else if (value.length === 0) {
                    e.target.value = '';
                    return;
                }

                let formatted = '';
                if (value.length > 0) formatted += '+' + value.slice(0, 1);
                if (value.length > 1) formatted += ' (' + value.slice(1, 4);
                if (value.length > 4) formatted += ') ' + value.slice(4, 7);
                if (value.length > 7) formatted += '-' + value.slice(7, 11);

                e.target.value = formatted;
            });
        }

        const dateInput = document.getElementById('requested-date');
        if (dateInput) {
            const today = new Date();
            const minDate = today.toISOString().split('T')[0];
            dateInput.setAttribute('min', minDate);

            dateInput.addEventListener('change', (e) => {
                const selectedDate = e.target.value;
                if (selectedDate) {
                    const [year, month, day] = selectedDate.split('-').map(Number);
                    const inputDate = new Date(year, month - 1, day);
                    const todayDate = new Date();
                    todayDate.setHours(0, 0, 0, 0);

                    if (inputDate < todayDate) {
                        markError(e.target, 'Date cannot be in the past');
                        e.target.value = '';
                    }
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCheckout);
    } else {
        initCheckout();
    }
})();
