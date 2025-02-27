document.addEventListener("DOMContentLoaded", function () {
    // ✅ Event Delegation for Add to Cart
    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("add-to-cart")) {
            let productId = event.target.getAttribute("data-id");

            fetch("php/add_to_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "product_id=" + productId,
            })
            .then((response) => response.text())
            .then((data) => alert(data))
            .catch((error) => console.error("Add to Cart Error:", error));
        }
    });

    // ✅ Search on Button Click
    document.querySelector(".search-button").addEventListener("click", searchProducts);

    // ✅ Live Search on Typing (Enter Key)
    document.getElementById("search-bar").addEventListener("keyup", function (event) {
        if (event.key === "Enter") {
            searchProducts();
        }
    });

    // ✅ Event Delegation for Remove from Cart
    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-from-cart")) {
            const productId = event.target.getAttribute("data-id");

            fetch("php/remove_from_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `product_id=${productId}`,
            })
            .then((response) => response.text())
            .then((data) => {
                // ✅ Show Popup Message
                const popup = document.getElementById("popup-message");
                popup.style.display = "block";
                popup.innerText = "Item removed from cart!";

                // ✅ Hide popup after 3 seconds & refresh
                setTimeout(() => {
                    popup.style.display = "none";
                    window.location.reload();
                }, 3000);
            })
            .catch((error) => console.error("Remove from Cart Error:", error));
        }
    });
});

// 🔍 **Search Function to Fetch and Display Results**
function searchProducts() {
    let query = document.getElementById("search-bar").value.trim();
    let searchResults = document.getElementById("search-results");
    let productList = document.querySelector(".products");

    if (query === "") {
        // ✅ Show all products if search is empty
        searchResults.innerHTML = "";
        productList.style.display = "flex";
        return;
    }

    fetch("php/search.php?q=" + encodeURIComponent(query))
        .then((response) => response.text())
        .then((data) => {
            if (data.trim() === "") {
                searchResults.innerHTML = `<div class="no-results">❌ No results found</div>`;
            } else {
                searchResults.innerHTML = data;
            }
            productList.style.display = "none"; // ✅ Hide default product list
        })
        .catch((error) => console.error("Search Error:", error));
}

document.addEventListener("DOMContentLoaded", function () {
    // ✅ Event Delegation for "Order Now" Button
    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("order-now")) {
            let scheduleId = event.target.getAttribute("data-id");

            fetch("php/order_tiffin.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "schedule_id=" + scheduleId,
            })
            .then((response) => response.text())
            .then((data) => alert(data)) // Show response as alert
            .catch((error) => console.error("Order Error:", error));
        }
    });
});
