document.addEventListener("alpine:init", () => {
  Alpine.data("products", () => ({
    items: [
      { id: 1, name: "Teh Kulit Salak Celup Kecil", img: "1.jpg", price: 8000 },
      {
        id: 2,
        name: "Teh Kulit Salak Celup Besar",
        img: "1.jpg",
        price: 15000,
      },
      {
        id: 3,
        name: "Teh Kulit Salak Serbuk Kecil",
        img: "2.jpg",
        price: 8000,
      },
      {
        id: 4,
        name: "Teh Kulit Salak Serbuk Besar",
        img: "2.jpg",
        price: 15000,
      },
      { id: 5, name: "Teh Kulit Salak Cup", img: "3.jpg", price: 3000 },
    ],
  }));

  Alpine.store("cart", {
    items: [],
    total: 0,
    quantity: 0,
    add(newItem) {
      // cek barang di cart
      const cartItem = this.items.find((item) => item.id === newItem.id);

      // Jika cart kosng
      if (!cartItem) {
        this.items.push({ ...newItem, quantity: 1, total: newItem.price });
        this.quantity++;
        this.total += newItem.price;
      } else {
        // Jika sudah ada, cek barang sama
        this.items = this.items.map((item) => {
          // Jika barang berbeda
          if (item.id !== newItem.id) {
            return item;
          } else {
            // Jika barang sudah ada, tambah quantity
            item.quantity++;
            item.total = item.price * item.quantity;
            this.quantity++;
            this.total += item.price;
            return item;
          }
        });
      }
    },
    remove(id) {
      // Ambil item berdasarkan id
      const cartItem = this.items.find((item) => item.id === id);

      // Jika item lebih dari 1
      if (cartItem.quantity > 1) {
        this.items = this.items.map((item) => {
          // Jika bukan barang yang diklik
          if (item.id !== id) {
            return item;
          } else {
            item.quantity--;
            item.total = item.price * item.quantity;
            this.quantity--;
            this.total -= item.price;
            return item;
          }
        });
      } else if (cartItem.quantity === 1) {
        // Jika barang sisa 1
        this.items = this.items.filter((item) => item.id !== id);
        this.quantity--;
        this.total -= cartItem.price;
      }
    },
  });
});

// Kirim data checkout
checkoutButton.addEventListener("click", async (e) => {
  e.preventDefault();
  const formData = new FormData(form);
  const data = new URLSearchParams(formData);
  const objData = Object.fromEntries(data);
  // const message = formatMessage(objData);
  // window.open("http://wa.me/6281284164919?text=" + encodeURIComponent(message));

  // fetch transaction
  try {
    const response = await fetch("php/placeOrder.php", {
      method: "POST",
      body: data,
    });
    const token = await response.text();
    // console.log(token);
    window.snap.pay(token, {
      onSuccess: function (result) {
        /* You may add your own implementation here */
        alert("payment success!");
        console.log(result);
      },
      onPending: function (result) {
        /* You may add your own implementation here */
        alert("wating your payment!");
        console.log(result);
      },
      onError: function (result) {
        /* You may add your own implementation here */
        alert("payment failed!");
        console.log(result);
      },
      onClose: function () {
        /* You may add your own implementation here */
        alert("you closed the popup without finishing the payment");
      },
    });
  } catch (error) {
    console.log(error.message);
  }
});

// Format pesan WA
const formatMessage = (obj) => {
  return `Data Pelanggan
  Nama: ${obj.name}
  Email: ${obj.email}
  No. HP: ${obj.phone}
  Data Pesanan
  ${JSON.parse(obj.items).map(
    (item) => `${item.name} (${item.quantity} x ${rupiah(item.total)}) \n`
  )}
  TOTAL: ${rupiah(obj.total)}
  Terima Kasih.`;
};

// Konversi Rupiah
// const rupiah = (number) => {
//   return new Intl.NumberFormat("id-ID", {
//     style: "currency",
//     currency: "IDR",
//     minimumFractionDigits: 0,
//   }).format(number);
// };
