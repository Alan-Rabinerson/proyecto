// AJAX cart loader and simple quantity update handlers
document.addEventListener('DOMContentLoaded', function () {
	loadCart();
});

function loadCart() {
    let list = document.querySelector('.carrito-items');
    renderCart([], 0); // clear first
    if (!list) return;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            try {
                var response = JSON.parse(this.responseText);
                if (response && response.success) {
                    renderCart(response.items, response.total);
                } else {
                    renderCart([], 0);
                }
            } catch (e) {
                console.error('Error parsing JSON response:', e);
                renderCart([], 0);
            }
        }
    };
    xmlhttp.open("GET", "/student024/Shop/backend/endpoints/shopping_cart/get_cart.php", true);
    xmlhttp.send();    
}

function renderCart(items, total) {
	const list = document.querySelector('.carrito-items');
	if (!list) return;
	// keep header (first li) if present
	const header = list.querySelector(':scope > li:first-child');
	list.innerHTML = '';
	if (header) list.appendChild(header);

	items.forEach(item => {
		const li = document.createElement('li');
		li.className = 'carrito-item';

		li.innerHTML = `
			<img src="${item.image}" alt="${escapeHtml(item.name)}">
			<span class="nombre-producto">${escapeHtml(item.name)}</span>
			<div class="cantidad-container">
				<button class="restar-cantidad" data-product="${item.product_id}" data-size="${escapeHtml(item.size)}">-</button>
				<span class="cantidad-producto">${item.quantity}</span>
				<button class="añadir-cantidad" data-product="${item.product_id}" data-size="${escapeHtml(item.size)}">+</button>
			</div>
			<span class="precio-producto">${Number(item.subtotal).toFixed(2)} €</span>
		`;

		// attach handlers
		li.querySelectorAll('button.restar-cantidad, button.añadir-cantidad').forEach(btn => {
			btn.addEventListener('click', function (e) {
				const pid = this.getAttribute('data-product');
				const size = this.getAttribute('data-size');
				const delta = this.classList.contains('restar-cantidad') ? -1 : 1;
				updateQuantity(pid, size, delta);
			});
		});

		list.appendChild(li);
	});

	// update total if footer element exists
	const totalEl = document.querySelector('.carrito-footer .total-amount');
	if (totalEl) totalEl.textContent = 'Total: ' + Number(total).toFixed(2) + ' €';
}

function escapeHtml(str) {
	if (!str) return '';
	return String(str).replace(/[&<>"'`]/g, function (s) {
		return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#x60;'})[s];
	});
}

