let divproductImages = document.querySelector(".product-images");
let mainImage = divproductImages.querySelector("img");
let additionalImages = divproductImages.querySelectorAll(
  ".additional-images img"
);
let anadirCarritoBtn = document.getElementById("añadir-carrito-btn");
let crtCount = document.querySelector(".cart-count");

additionalImages.forEach((image) => {
  image.addEventListener("click", () => {
    imagenPrincipal = mainImage.src;
    mainImage.src = image.src;
    image.src = imagenPrincipal;
  });
});

anadirCarritoBtn.addEventListener("click", (e) => {
  e.preventDefault();
  let currentCount = parseInt(crtCount.textContent);
  let cantidad = parseInt(document.getElementById("cantidad").value);
  crtCount.textContent = currentCount + cantidad;
  console.log("Añadido al carrito");
});

document.addEventListener("DOMContentLoaded", () => {
  cargarReviews();
});

function cargarReviews() {
  var xmlhttp = new XMLHttpRequest();
  var productId = document.getElementById("productId").value;
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        var response = JSON.parse(this.responseText);
        if (response) {
          // Normalize different response shapes to an array before rendering
          var reviewsArr = [];
          reviewsArr = response;
          console.log(response + "array");
          renderReviews(reviewsArr);
        }
      } catch (e) {
        console.error("Error parsing JSON response:", e);
      }
    }
  };
  xmlhttp.open(
    "GET",
    "/student024/Shop/backend/endpoints/product_detail/show_reviews.php?product_id=" +
      productId,
    true
  );
  xmlhttp.send();
}

function renderReviews(reviews) {
  const reviewsContainer = document.getElementById("reviews-section");
  if (!reviewsContainer) return;
  reviewsContainer.innerHTML = "";
  if (!Array.isArray(reviews)) return;
  reviews.forEach((review) => {
    let review_content = `
            <div class="review-item mb-4">
                <h4 class="border-b border-azul-claro">Posted by: ${
                  review.full_name
                }</h4>
                <span class="text-sm text-gray-500">Date: ${new Date(
                  review.created_at
                ).toLocaleDateString()}</span>
                <span class="flex">
                `;
                for (let i = 0; i < review.review_rating; i++) {
                review_content += `<img class="w-5 h-5" src="/student024/Shop/assets/logos/estrella_con_relleno.png" alt="estrella rellena">`;
                }
                for (let i = review.review_rating; i < 5; i++) {
                review_content += `<img class="w-5 h-5" src="/student024/Shop/assets/logos/estrella_sin_relleno.png" alt="estrella vacía">`;
                }
                review_content += `</span>`;

                review_content += `<p>${review.review_content}</p>
            </div>`;
    reviewsContainer.innerHTML += review_content;
  });
}
