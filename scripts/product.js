document.addEventListener("DOMContentLoaded", () => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Function to add an item to the cart
    function addToCart(name, price) {
        const existingItem = cart.find(item => item.name === name);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ name, price, quantity: 1 });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${name} has been added to your cart.`);
    }

    // Attach event listeners to "Add to Cart" buttons
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const name = button.dataset.name;
            const price = parseFloat(button.dataset.price);
            addToCart(name, price);
        });
    });
});
