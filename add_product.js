// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get the form element
    const form = document.querySelector("form");

    // Add event listener for form submission
    form.addEventListener("submit", function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Validate form data
        const productName = document.getElementById("product_name").value.trim();
        const price = document.getElementById("price").value.trim();
        const width = document.getElementById("width").value.trim();
        const height = document.getElementById("height").value.trim();
        const depth = document.getElementById("depth").value.trim();
        const picture = document.getElementById("product_picture").value.trim();

        // Check if any field is empty
        if (!productName || !price || !width || !height || !depth || !picture) {
            alert("Please fill out all fields.");
            return;
        }

        // Check if price, width, height, and depth are numbers
        if (isNaN(price) || isNaN(width) || isNaN(height) || isNaN(depth)) {
            alert("Price, width, height, and depth must be numbers.");
            return;
        }

        // If all validation passes, submit the form
        form.submit();
    });
});
