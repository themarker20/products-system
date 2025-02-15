document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-button").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.dataset.productId; // Get product ID
            let button = this;

            fetch("like_product.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "product_id=" + productId
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Product liked successfully!");
                    button.textContent = "Liked"; // Change button text
                    button.disabled = true; // Prevent multiple likes
                } else {
                    alert("Error: " + data); // Show error message
                }
            })
            .catch(error => alert("Request failed: " + error));
        });
    });
});
