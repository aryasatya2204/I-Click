// document.addEventListener("DOMContentLoaded", () => {
//   const openShopping = document.querySelector(".shopping");
//   const closeShopping = document.querySelector(".closeShopping");
//   const list = document.querySelector(".list");
//   const listCard = document.querySelector(".listCard");
//   const total = document.querySelector(".total");
//   const body = document.querySelector(".body");
//   const quantityDisplay = document.querySelector(".quantity");

//   if (
//     openShopping &&
//     closeShopping &&
//     list &&
//     listCard &&
//     total &&
//     body &&
//     quantityDisplay
//   ) {
//     openShopping.addEventListener("click", () => {
//       body.classList.add("active");
//     });

//     closeShopping.addEventListener("click", () => {
//       body.classList.remove("active");
//     });

//     let listCards = [];
//     let products = JSON.parse(localStorage.getItem("cart")) || [];

//     const initApp = () => {
//       products.forEach((value, key) => {
//         let newDiv = document.createElement("div");
//         newDiv.classList.add("item");
//         newDiv.innerHTML = `
//                     <img src="img/${value.image}" alt="${value.name}">
//                     <div class="title">${value.name}</div>
//                     <div class="price">${value.price.toLocaleString()}</div>
//                     <button onclick="addToCard(${key})">Add to Cart</button>
//                 `;
//         list.appendChild(newDiv);
//       });
//     };

//     initApp();

//     const addToCard = (key) => {
//       if (!listCards[key]) {
//         listCards[key] = { ...products[key], quantity: 1 };
//       } else {
//         listCards[key].quantity += 1;
//       }
//       reloadCard();
//     };

//     const reloadCard = () => {
//       listCard.innerHTML = "";
//       let count = 0;
//       let totalPrice = 0;

//       listCards.forEach((value, key) => {
//         if (value) {
//           totalPrice += value.price * value.quantity;
//           count += value.quantity;

//           let newDiv = document.createElement("li");
//           newDiv.innerHTML = `
//                         <div><img src="img/${value.image}" alt="${
//             value.name
//           }"></div>
//                         <div class="cardTitle">${value.name}</div>
//                         <div class="cardPrice">${(
//                           value.price * value.quantity
//                         ).toLocaleString()}</div>
//                         <div>
//                             <button class="cardButton" onclick="changeQuantity(${key}, ${
//             value.quantity - 1
//           })">-</button>
//                             <div class="count">${value.quantity}</div>
//                             <button class="cardButton" onclick="changeQuantity(${key}, ${
//             value.quantity + 1
//           })">+</button>
//                         </div>
//                     `;
//           listCard.appendChild(newDiv);
//         }
//       });

//       total.innerText = totalPrice.toLocaleString();
//       quantityDisplay.innerText = count;
//     };

//     const changeQuantity = (key, quantity) => {
//       if (quantity <= 0) {
//         delete listCards[key];
//       } else {
//         listCards[key].quantity = quantity;
//       }
//       reloadCard();
//     };
//   } else {
//     console.error("One or more elements are missing from the HTML.");
//   }
// });
