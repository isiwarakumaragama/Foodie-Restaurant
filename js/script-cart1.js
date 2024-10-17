// Initialize an empty array to store cart items
let cartItems = [];

// Function to add an item to the cart
function addToCart(itemName, itemPrice) {
    const item = {
        name: itemName,
        price: itemPrice
    };

    // Add the item to the cartItems array
    cartItems.push(item);

    // Save the updated cartItems array to localStorage
    localStorage.setItem('cart', JSON.stringify(cartItems));

    // You can perform additional actions here if needed, like updating the UI or displaying a message
    console.log(`${itemName} added to cart!`);
}

// Function to display cart items on the cart page
function displayCart() {
    // Get the element where cart items will be displayed
    const cartContainer = document.getElementById('cart-items');

    // Clear the container before displaying the updated items
    cartContainer.innerHTML = '';

    // Retrieve cart items from localStorage
    const storedCartItems = JSON.parse(localStorage.getItem('cart'));

    if (storedCartItems) {
        // Loop through stored cart items and display them on the cart page
        storedCartItems.forEach((item, index) => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = '
                <p>${item.name} - $${item.price}</p>
                <button onclick="removeFromCart(${index})">Remove</button>
            ';
            cartContainer.appendChild(cartItem);
        });
    } else {
        cartContainer.innerHTML = '<p>No items in the cart</p>';
    }
}

// Function to remove an item from the cart
function removeFromCart(index) {
    // Remove the item at the specified index from the cartItems array
    cartItems.splice(index, 1);

    // Update the localStorage with the modified cartItems array
    localStorage.setItem('cart', JSON.stringify(cartItems));

    // Display the updated cart items on the cart page
    displayCart();
}

// Call the displayCart function when the page loads to show the cart items
document.addEventListener('DOMContentLoaded', displayCart);
