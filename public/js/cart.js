(function() {
    const PLACEHOLDER_IMAGE = '/var/assets/images/misc/camera.png';
    const LOADER_STYLE_ID = 'cart-loader-style';

    function ensureLoaderStyles() {
        if (document.getElementById(LOADER_STYLE_ID)) return;
        const style = document.createElement('style');
        style.id = LOADER_STYLE_ID;
        style.textContent = `
            @keyframes cart-bounce {
                0%, 80%, 100% { transform: translateY(0); opacity: 0.3; }
                40% { transform: translateY(-4px); opacity: 1; }
            }
            .qty-control {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                position: relative;
            }
            .qty-control input[type="number"] {
                width: 56px;
                text-align: center;
            }
            .loading-indicator {
                display: inline-flex;
                gap: 4px;
                align-items: center;
                justify-content: center;
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                font-size: 1rem;
                letter-spacing: 1px;
                pointer-events: none;
            }
            .loading-indicator span {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: currentColor;
                display: inline-block;
                animation: cart-bounce 1s infinite ease-in-out;
            }
            .loading-indicator span:nth-child(2) { animation-delay: 0.15s; }
            .loading-indicator span:nth-child(3) { animation-delay: 0.3s; }
        `;
        document.head.appendChild(style);
    }

    function formatMoney(n) {
        return '$' + (Math.round(n * 100) / 100).toFixed(2);
    }

    function parseMoney(str) {
        return parseFloat(String(str).replace(/[$,]/g, '')) || 0;
    }

    function recalcSummary() {
        const items = document.querySelectorAll('.cart-item');
        let subtotal = 0;
        let count = 0;
        items.forEach(el => {
            const extendedPrice = parseFloat(el.dataset.extendedprice || '0');
            const qty = parseInt(el.dataset.qty || '1', 10);
            subtotal += extendedPrice;
            count += qty;
            const subtotalEl = el.querySelector('.item-subtotal');
            if (subtotalEl) subtotalEl.textContent = formatMoney(extendedPrice);
        });
        const tax = subtotal * 0.0725;
        const total = subtotal + tax;
        const fmt = (n) => (Math.round(n * 100) / 100).toFixed(2);
        const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = '$' + fmt(val); };
        setText('summary-subtotal', subtotal);
        setText('summary-tax', tax);
        setText('summary-total', total);

        const bagCountEl = document.getElementById('bag-count');
        const bagTotalEl = document.getElementById('bag-total');
        if (bagCountEl) bagCountEl.textContent = `${count} item${count === 1 ? '' : 's'}`;
        if (bagTotalEl) bagTotalEl.textContent = formatMoney(subtotal);

        return { subtotal, tax, total, count };
    }

    function attachItemHandlers(article) {
        const dec = article.querySelector('.qty-decrease');
        const inc = article.querySelector('.qty-increase');
        const input = article.querySelector('input[type="number"]');
        const removeBtn = article.querySelector('.remove-item');
        let isUpdating = false;

        const loader = article.querySelector('.loading-indicator');

        function updateQtyControls() {
            const currentQty = parseInt(input?.value || '1', 10);
            const atMinimum = currentQty <= 1;
            if (dec) dec.disabled = isUpdating || atMinimum;
            if (inc) inc.disabled = isUpdating;
            if (input) {
                input.disabled = isUpdating;
                input.style.visibility = isUpdating ? 'hidden' : 'visible';
            }
            if (removeBtn) removeBtn.disabled = isUpdating;
            if (loader) loader.style.display = isUpdating ? 'inline-flex' : 'none';
        }

        function syncQty(newQty) {
            const qty = Math.max(1, parseInt(newQty || '1', 10));
            const productId = article.dataset.productid;
            const uom = article.dataset.uom;
            
            if (productId && uom) {
                if (isUpdating) return;
                isUpdating = true;
                updateQtyControls();
                updateCartItemQuantity(productId, uom, qty)
                    .then(() => loadCartFromApi())
                    .catch(() => loadCartFromApi())
                    .finally(() => {
                        isUpdating = false;
                        updateQtyControls();
                    });
            } else {
                input.value = qty;
                article.dataset.qty = String(qty);
                recalcSummary();
                updateQtyControls();
            }
        }

        if (dec) dec.addEventListener('click', () => syncQty((parseInt(input.value || '1', 10) - 1)));
        if (inc) inc.addEventListener('click', () => syncQty((parseInt(input.value || '1', 10) + 1)));
        if (input) input.addEventListener('change', () => syncQty(input.value));
        if (removeBtn) removeBtn.addEventListener('click', () => {
            const productId = article.dataset.productid;
            const uom = article.dataset.uom;
            
            if (productId && uom) {
                if (isUpdating) return;
                isUpdating = true;
                updateQtyControls();
                deleteCartItem(productId, uom)
                    .then(() => loadCartFromApi())
                    .catch(() => loadCartFromApi())
                    .finally(() => {
                        isUpdating = false;
                        updateQtyControls();
                    });
            } else {
                article.remove();
                recalcSummary();
            }
        });

        updateQtyControls();
    }

    function createCartItemDom(item, qty, extendedPrice) {
        const article = document.createElement('article');
        article.className = 'cart-item';
        article.dataset.sku = item.sku || '';
        article.dataset.price = String(item.price || 0);
        article.dataset.qty = String(qty);
        article.dataset.extendedprice = String(extendedPrice);
        
        if (item.productId) { article.dataset.productid = String(item.productId); }
        if (item.uom) { article.dataset.uom = String(item.uom); }

        const imageDiv = document.createElement('div');
        imageDiv.className = 'item-image';
        const img = document.createElement('img');

        if (typeof item.image === 'string' && item.image.startsWith('/var/assets/')) {
            img.src = item.image;
        } else {
            img.src = '/var/assets/images/misc/camera.png';
        }
        img.alt = item.name || '';
        imageDiv.appendChild(img);

        const bodyDiv = document.createElement('div');
        bodyDiv.className = 'item-body';

        const rowDiv = document.createElement('div');
        rowDiv.className = 'item-row';

        const leftDiv = document.createElement('div');
        const h3 = document.createElement('h3');
        h3.textContent = item.name || '';
        leftDiv.appendChild(h3);

        const skuP = document.createElement('p');
        skuP.className = 'item-meta';
        skuP.textContent = 'SKU: ' + (item.sku || '');
        leftDiv.appendChild(skuP);

        const pillRow = document.createElement('div');
        pillRow.className = 'pill-row';
        (item.attrs || []).forEach(a => {
            const pill = document.createElement('span');
            pill.className = 'pill';
            pill.textContent = String(a);
            pillRow.appendChild(pill);
        });
        leftDiv.appendChild(pillRow);
        rowDiv.appendChild(leftDiv);

        const priceSpan = document.createElement('span');
        priceSpan.className = 'item-price';
        priceSpan.textContent = formatMoney(item.price);
        rowDiv.appendChild(priceSpan);
        bodyDiv.appendChild(rowDiv);

        const actionsDiv = document.createElement('div');
        actionsDiv.className = 'item-row item-actions';

        const qtyControl = document.createElement('div');
        qtyControl.className = 'qty-control';

        const btnDec = document.createElement('button');
        btnDec.className = 'btn-ghost qty-decrease';
        btnDec.textContent = '−';
        qtyControl.appendChild(btnDec);

        const loader = document.createElement('span');
        loader.className = 'loading-indicator';
        loader.style.display = 'none';
        loader.setAttribute('aria-live', 'polite');
        loader.innerHTML = '<span></span><span></span><span></span>';
        qtyControl.appendChild(loader);

        const qtyInput = document.createElement('input');
        qtyInput.type = 'number';
        qtyInput.value = String(qty);
        qtyInput.min = '1';
        qtyControl.appendChild(qtyInput);

        const btnInc = document.createElement('button');
        btnInc.className = 'btn-ghost qty-increase';
        btnInc.textContent = '+';
        qtyControl.appendChild(btnInc);

        actionsDiv.appendChild(qtyControl);

        const btnRemove = document.createElement('button');
        btnRemove.className = 'btn-link remove-item';
        btnRemove.textContent = 'Remove';
        actionsDiv.appendChild(btnRemove);

        const subtotalSpan = document.createElement('span');
        subtotalSpan.className = 'item-subtotal';
        subtotalSpan.textContent = formatMoney(extendedPrice);
        actionsDiv.appendChild(subtotalSpan);

        bodyDiv.appendChild(actionsDiv);
        article.appendChild(imageDiv);
        article.appendChild(bodyDiv);

        return article;
    }

    function initQuickAdd() {
    }

    function initExistingItems() {
        document.querySelectorAll('.cart-item').forEach(attachItemHandlers);
        recalcSummary();
    }

    function parseApiItems(itemsPayload) {
        if (!itemsPayload) return [];
        if (Array.isArray(itemsPayload)) return itemsPayload.slice();
        if (typeof itemsPayload === 'object') return Object.values(itemsPayload);
        return [];
    }

    function renderApiItems(items) {
        const container = document.querySelector('.cart-items');
        if (!container) return;

        const existingItems = container.querySelectorAll('.cart-item');
        existingItems.forEach(item => item.remove());
        
        const existingEmptyMessages = container.querySelectorAll('p.lede');
        existingEmptyMessages.forEach(msg => msg.remove());

        const parsed = parseApiItems(items);
        if (!parsed.length) {
            const empty = document.createElement('p');
            empty.className = 'lede';
            empty.textContent = 'Your cart is empty.';
            const quickAdd = container.querySelector('.quick-add');
            if (quickAdd) {
                container.insertBefore(empty, quickAdd);
            } else {
                container.appendChild(empty);
            }
            recalcSummary();
            document.dispatchEvent(new CustomEvent('cartUpdated'));
            return;
        }

        const quickAdd = container.querySelector('.quick-add');
        
        parsed.forEach(apiItem => {
            const sku = apiItem.product.productId;
            const name = apiItem.product.name;
            const brand = apiItem.product.brandName;
            const uom = apiItem.quantityOrdered.uom;
            const qty = parseInt(apiItem.quantityOrdered.quantity, 10);
            const price = parseFloat(apiItem.price);
            const extendedPrice = parseFloat(apiItem.extendedPrice);
            const attrs = [];
            if (brand) attrs.push(brand);
            if (uom) attrs.push(String(uom).toUpperCase());

            const itemForDom = { sku, name, price, image: PLACEHOLDER_IMAGE, attrs, productId: sku, uom };
            const article = createCartItemDom(itemForDom, qty, extendedPrice);
            
            if (quickAdd) {
                container.insertBefore(article, quickAdd);
            } else {
                container.appendChild(article);
            }
            attachItemHandlers(article);
        });

        recalcSummary();
        document.dispatchEvent(new CustomEvent('cartUpdated'));
    }

    function updateCartItemQuantity(productId, uom, qty) {
        const validQty = Math.max(1, parseInt(qty, 10));
        if (isNaN(validQty)) {
            return Promise.reject(new Error('Invalid quantity'));
        }
        const body = new URLSearchParams({ quantity: String(validQty) });
        return fetch(`/carts/items/${encodeURIComponent(productId)}/${encodeURIComponent(uom)}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: body.toString()
        }).then(resp => {
            if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
            return resp.text();
        }).catch(err => {
            console.error('Error updating cart item:', err);
            throw err;
        });
    }

    function deleteCartItem(productId, uom) {
        return fetch(`/carts/items/${encodeURIComponent(productId)}/${encodeURIComponent(uom)}`, {
            method: 'DELETE'
        }).then(resp => {
            if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
            return resp.text();
        }).catch(err => {
            console.error('Error deleting cart item:', err);
            throw err;
        });
    }

    function loadCartFromApi() {
        return fetch('/carts')
            .then(resp => {
                if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
                return resp.json();
            })
            .then(data => {
                const items = data.items || [];
                renderApiItems(items);
                
                const subtotalEl = document.getElementById('summary-subtotal');
                const taxEl = document.getElementById('summary-tax');
                const totalEl = document.getElementById('summary-total');
                const itemCountEl = document.querySelector('.item-count');
                
                const subTotal = parseFloat(data.subTotal || 0);
                const tax = parseFloat(data.tax || 0);
                const total = parseFloat(data.totalDue || 0);
                
                if (subtotalEl) subtotalEl.textContent = formatMoney(subTotal);
                if (taxEl) taxEl.textContent = formatMoney(tax);
                if (totalEl) totalEl.textContent = formatMoney(total);
                
                let count = 0;
                const parsed = parseApiItems(items);
                parsed.forEach(item => {
                    const qty = parseInt(item.quantityOrdered?.quantity || 0, 10);
                    if (!Number.isNaN(qty)) {
                        count += qty;
                    }
                });
                
                if (itemCountEl) {
                    itemCountEl.textContent = `${count} item${count === 1 ? '' : 's'}`;
                }

                document.dispatchEvent(new CustomEvent('cartUpdated'));
            })
            .catch(err => {
                console.error('Error fetching cart from /carts endpoint:', err.message || err);
                const container = document.querySelector('.cart-items');
                if (container) {
                    const existingEmptyMessages = container.querySelectorAll('p.lede');
                    existingEmptyMessages.forEach(msg => msg.remove());
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'lede';
                    errorMsg.textContent = 'Unable to load cart. Please try again.';
                    container.appendChild(errorMsg);
                }
            });
    }

    function initCart() {
        ensureLoaderStyles();
        initExistingItems();
        loadCartFromApi();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initCart();
        });
    } else {
        initCart();
    }
})();
