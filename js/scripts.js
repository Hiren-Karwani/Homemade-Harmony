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

    // ✅ Schedule Later: Set Minimum Date and Time for Checkout
    const dateInputCheckout = document.getElementById("delivery_date");
    const timeInputCheckout = document.getElementById("delivery_time");
    if (dateInputCheckout && timeInputCheckout) {
        const today = new Date().toISOString().split("T")[0];
        dateInputCheckout.setAttribute("min", today);

        // Adjust time based on today's date selection
        dateInputCheckout.addEventListener("change", function () {
            const selectedDate = new Date(dateInputCheckout.value);
            const now = new Date();
            if (selectedDate.toDateString() === now.toDateString()) {
                const currentTime = now.toTimeString().slice(0, 5); // e.g., "14:30"
                timeInputCheckout.setAttribute("min", currentTime);
            } else {
                timeInputCheckout.setAttribute("min", "09:00"); // Reset to default business hours
            }
        });
    }

    // ✅ Event Delegation for "Order Now" Button in Schedule
    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("order-now")) {
            const scheduleId = event.target.getAttribute("data-id");
            const form = document.getElementById(`form-${scheduleId}`);

            // Toggle form visibility
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    });

    // ✅ Schedule Later: Set Minimum Date for Schedule Forms
    document.querySelectorAll('input[type="date"]').forEach(input => {
        const today = new Date().toISOString().split("T")[0];
        input.setAttribute("min", today);

        // Adjust time dynamically based on date selection
        input.addEventListener("change", function () {
            const form = input.closest(".schedule-form");
            const timeInput = form.querySelector('input[type="time"]');
            const selectedDate = new Date(input.value);
            const now = new Date();

            if (selectedDate.toDateString() === now.toDateString()) {
                const currentTime = now.toTimeString().slice(0, 5); // e.g., "14:30"
                timeInput.setAttribute("min", currentTime);
            } else {
                timeInput.setAttribute("min", "09:00"); // Reset to default
            }
        });
    });

    // ✅ Schedule Form Submission Validation
    document.querySelectorAll(".schedule-form").forEach(form => {
        form.addEventListener("submit", function (event) {
            const dateInput = form.querySelector('input[type="date"]');
            const timeInput = form.querySelector('input[type="time"]');
            const selectedDateTime = new Date(`${dateInput.value} ${timeInput.value}`);
            const now = new Date();

            if (selectedDateTime <= now) {
                event.preventDefault(); // Prevent form submission
                alert("Please select a future date and time!");
            }
        });
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