function addToCart(productId) {
  fetch('add_to_cart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'product_id=' + productId
  })
  .then(response => response.json())
  .then(data => {
      alert(data.message);
  })
  .catch(error => {
      console.error('Error:', error);
  });
}

// Prevent Image Selection
document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll("img").forEach(img => {
      img.oncontextmenu = (e) => e.preventDefault(); // Disable right-click
      img.oncopy = (e) => e.preventDefault(); // Disable copying
      img.oncut = (e) => e.preventDefault(); // Disable cutting
      img.ondragstart = (e) => e.preventDefault(); // Disable dragging
  });
});

// Disable Print Screen
document.addEventListener("keydown", function (event) {
    if (event.key === "PrintScreen") {
        event.preventDefault();
        alert("Screenshots are disabled on this site!");
    }
});

// Disable Screenshot via Clipboard
document.addEventListener("keyup", function (event) {
    if (event.key === "PrintScreen") {
        navigator.clipboard.writeText(""); // Clears copied screenshot
        alert("Screenshots are disabled on this site!");
    }
});

// Detect Screenshot Tools (for some screen capture extensions)
// setInterval(function () {
//     let element = document.createElement("input");
//     element.setAttribute("type", "text");
//     element.setAttribute("onfocus", "console.log('Screen Capture Detected')");
//     document.body.appendChild(element);
//     element.focus();
//     document.body.removeChild(element);
// }, 1000);

// setInterval(() => {
//   let elem = document.documentElement;
//   if (window.outerWidth - window.innerWidth > 200) {
//       elem.style.filter = "blur(10px)";
//   } else {
//       elem.style.filter = "none";
//   }
// }, 1000);
