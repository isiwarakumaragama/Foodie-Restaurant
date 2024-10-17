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

// Example of how to use the addToCart function
// You can call this function when a user clicks an "Add to Cart" button on your website
// Replace these calls with your actual implementation

// Example 1:
// addToCart('Tasty Burger', 10.99);

// Example 2:
// addToCart('Tasty Pizza', 12.99);
