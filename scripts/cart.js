document.addEventListener("DOMContentLoaded", () => {
    const cartTableBody = document.querySelector('.cart-table tbody');
    const totalDisplay = document.querySelector('.cart-total h3');

    // Load cart from local storage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Function to render the cart
    function renderCart() {
        cartTableBody.innerHTML = ''; // Clear current cart items
        let total = 0;

        cart.forEach((item, index) => {
            const rowTotal = item.price * item.quantity;
            total += rowTotal;

            const row = `
                <tr>
                    <td>${item.name}</td>
                    <td>${new Intl.NumberFormat().format(item.price)}</td>
                    <td>
                        <input type="number" value="${item.quantity}" min="1" data-index="${index}">
                    </td>
                    <td>${new Intl.NumberFormat().format(rowTotal)}</td>
                    <td><button class="btn remove-btn" data-index="${index}">Remove</button></td>
                </tr>
            `;
            cartTableBody.insertAdjacentHTML('beforeend', row);
        });

        totalDisplay.textContent = `Total: ₦${new Intl.NumberFormat().format(total)}`;
    }

    // Function to update cart in local storage
    function updateCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    }

    // Event listener for quantity changes
    cartTableBody.addEventListener('change', (e) => {
        if (e.target.type === 'number') {
            const index = e.target.dataset.index;
            cart[index].quantity = parseInt(e.target.value, 10);
            updateCart();
        }
    });

    // Event listener for removing items
    cartTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-btn')) {
            const index = e.target.dataset.index;
            cart.splice(index, 1); // Remove the item from the cart
            updateCart();
        }
    });

    // Initial render
    renderCart();
});
localStorage.setItem('cart', JSON.stringify([
    { name: 'Mountain Bike', price: 150000, quantity: 1 },
    { name: 'Road Bike', price: 200000, quantity: 2 }
]));
