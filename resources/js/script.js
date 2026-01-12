let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
const menu = document.querySelector(".menu");
const mobileMenu = document.querySelector(".toggle-products");
const product = document.getElementById("products");

const keranjangBtn = document.querySelector(".keranjang");
const keranjangContainer = document.getElementById("keranjang-container");
const tutupBtn = keranjangContainer.querySelector("svg");
const isiKeranjang = document.querySelector(".isi-keranjang");
const totalKeranjang = document.querySelector(".total");
const tot = document.querySelector(".tot");
const kurangiii = document.querySelectorAll(".kurangiKer");
const tambahiii = document.querySelectorAll(".tambahKer");

tambahiii.forEach((tumb) => {
    tumb.addEventListener("click", function (e) {
        e.preventDefault();
        const id = this.getAttribute("data-id");
        const stok = this.getAttribute("data-stok");

        console.log(stok);
        const jumlahKer = document.getElementById(`jumlahKer${id}`);

        if (!jumlahKer) {
            console.error(
                `Elemen jumlah dengan ID jumlahKer${id} tidak ditemukan.`
            );
            return;
        }

        let jumlahLama = parseInt(jumlahKer.textContent, 10);

        if (isNaN(jumlahLama)) {
            jumlahLama = 0;
        }

        let jumlahBaru = jumlahLama + 1;
        if (jumlahBaru > stok) {
            Swal.fire({
                title: "Oops!",
                text: "Anda sudah mencapai batas pembelian",
                icon: "error",
                confirmButtonText: "OK",
            });
            return;
        }

        jumlahKer.innerHTML = jumlahBaru;
        jumlahKer.setAttribute("data-jumlah", jumlahBaru);
        validasiCheckboxStok(id);
        updateDatabase(id, jumlahBaru, csrfToken, jumlahKer, jumlahLama);
    });
});
kurangiii.forEach((tumb) => {
    tumb.addEventListener("click", function (e) {
        e.preventDefault();
        const id = this.getAttribute("data-id");
        const jumlahKer = document.getElementById(`jumlahKer${id}`);
        const stok = document.getElementById(`jumlahStok${id}`);
        const status = document.getElementById(`status-stok${id}`);

        if (!jumlahKer) {
            console.error(
                `Elemen jumlah dengan ID jumlahKer${id} tidak ditemukan.`
            );
            return;
        }

        let jumlahLama = parseInt(jumlahKer.textContent, 10);
        let jumlahStok = parseInt(stok.value, 10);
        if (isNaN(jumlahLama)) {
            jumlahLama = 0;
        }

        let jumlahBaru = jumlahLama - 1;
        if (jumlahBaru == 0) {
            alert("apakah anda ingin menghapus item ini?");
        }
        const cek = document.getElementById(`checkbox${id}`);
        // console.log(jumlahStok);

        if (jumlahBaru < jumlahStok) {
            cek.removeAttribute("disabled");
            cek.classList.remove("opacity-50");
            cek.classList.remove("cursor-not-allowed");
            cek.classList.add("cursor-pointer");
            cek.classList.add("item-checkbox");
            if (status) {
                status.setAttribute("hidden", "true");
            }
        }
        jumlahKer.innerHTML = jumlahBaru;
        jumlahKer.setAttribute("data-jumlah", jumlahBaru);
        validasiCheckboxStok(id);
        updateDatabase(id, jumlahBaru, csrfToken, jumlahKer, jumlahLama);
    });
});

const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
const csrfToken = csrfTokenElement
    ? csrfTokenElement.getAttribute("content")
    : null;

if (!csrfToken) {
    console.error(
        "Kesalahan: CSRF token tidak ditemukan. Pastikan meta tag sudah ada."
    );
}

function updateDatabase(itemId, newQuantity, token, element, oldQuantity) {
    const cek = document.getElementById(`checkbox${itemId}`);

    fetch("/keranjang/update", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token,
        },
        body: JSON.stringify({
            id: itemId,
            jumlah: newQuantity,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                if (data.new_subtotal_item !== undefined) {
                    const sub = document.getElementById(`sub${itemId}`);

                    cek.setAttribute("data-jumlah", newQuantity);
                    updateTotal();
                    sub.textContent =
                        "Rp " + data.new_subtotal_item.toLocaleString("id-ID");
                } else {
                    const carttt = document.getElementById(
                        `keranjangno${itemId}`
                    );
                    carttt.classList.add("hidden");
                    location.reload();
                }
                console.log("Jumlah berhasil diupdate di database:", data);
            } else {
                console.error("Gagal update database:", data.message);
                element.innerHTML = oldQuantity;
                element.setAttribute("data-jumlah", oldQuantity);
                alert(`Gagal update: ${data.message}`);
            }
        })
        .catch((error) => {
            console.error("Error saat koneksi ke server:", error);
            element.innerHTML = oldQuantity;
            element.setAttribute("data-jumlah", oldQuantity);
            alert("Terjadi kesalahan koneksi atau server.");
        });
}

const notif = document.getElementById("cart-badge");
const selectAll = document.getElementById("select-all");
const checkboxes = document.querySelectorAll(".item-checkbox");
const totalDisplay = document.getElementById("total-display");
const totalInput = document.getElementById("total-input");
const selectedItemsInput = document.getElementById("selected-items");
document.addEventListener("DOMContentLoaded", function () {
    if (notif.textContent.trim() !== "0") {
        notif.classList.remove("hidden");
    } else {
        notif.classList.add("hidden");
    }

    selectAll.addEventListener("change", function () {
        const checked = this.checked;

        getCheckboxes().forEach((cb) => {
            if (!cb.disabled) {
                cb.checked = checked;
            }
        });

        updateTotal();
    });
    document.addEventListener("change", function (e) {
        if (e.target && e.target.classList.contains("item-checkbox")) {
            updateTotal();
        }
    });

    document.querySelectorAll(".kurangiKer").forEach((btn) => {
        const id = btn.dataset.id;
        validasiCheckboxStok(id);
    });

    updateTotal();
});

function updateTotal() {
    let total = 0;
    let selectedItems = [];

    const checkboxes = getCheckboxes(); // ⬅️ KUNCI

    checkboxes.forEach((checkbox) => {
        if (checkbox.checked && !checkbox.disabled) {
            const harga = parseFloat(checkbox.dataset.harga);
            const jumlah = parseInt(checkbox.dataset.jumlah);
            const id = checkbox.dataset.id;

            total += harga * jumlah;
            selectedItems.push(id);
        }
    });

    totalDisplay.textContent = "Rp " + total.toLocaleString("id-ID");
    totalInput.value = total;
    selectedItemsInput.value = JSON.stringify(selectedItems);

    const checkboxAktif = [...checkboxes].filter((cb) => !cb.disabled);

    selectAll.checked =
        checkboxAktif.length > 0 && checkboxAktif.every((cb) => cb.checked);
}

// const hargaEl = document.getElementById("hargaEl");
// const subEl = document.querySelector(".subEl");
// const intharga = document.querySelector(".intharga").value;
// const subtotal = document.querySelector(".subtotal").value;
// document.addEventListener("DOMContentLoaded", function () {
//     hargaEl.textContent = `Rp${parseInt(intharga).toLocaleString("id-ID")}`;
//     subEl.textContent = `Rp${parseInt(subtotal).toLocaleString("id-ID")}`;
// });
keranjangBtn.addEventListener("click", function () {
    keranjangContainer.classList.remove("hidden");
    setTimeout(() => {
        keranjangContainer.classList.remove("translate-x-full");
    }, 50);
});

tutupBtn.addEventListener("click", function () {
    keranjangContainer.classList.add("translate-x-full");
    setTimeout(() => {
        keranjangContainer.classList.add("hidden");
    }, 300);
});

const about = document.querySelector(".about");
const aboutView = document.querySelector(".aboutView");

window.addEventListener("scroll", () => {
    const posisi = about.getBoundingClientRect().top;
    const tinggiLayar = window.innerHeight;

    if (posisi < tinggiLayar - 200) {
        aboutView.classList.remove("hidden");
        setTimeout(() => {
            aboutView.classList.remove("translate-y-full");
            aboutView.classList.add("translate-y-0");
        }, 100);
    }
});

// document.querySelectorAll(".tombol").forEach((tumb) => {
//     tumb.addEventListener("click", function (e) {
//         const tumbs = document.querySelectorAll(".tombol");
//         tumbs.forEach((tumm) => {
//             tumm.classList.remove("bg-gray-600", "text-white");
//         });

//         e.target.classList.add(
//             "focus:bg-gray-600",
//             "bg-gray-600",
//             "text-white"
//         );
//     });
// });

mobileMenu.addEventListener("click", function () {
    if (product.hasAttribute("hidden")) {
        product.removeAttribute("hidden");
    } else {
        product.setAttribute("hidden", "");
    }
});

const savekeranjang = document.getElementById("keranjang");
const beliBtn = document.getElementById("belibtn");
let jumlahElement = document.getElementById("jumlah");
let jumlahBeli = document.getElementById("jumlahPD");
let jumlahPD = document.querySelector(".jumlahPD");
let jumlah = parseInt(jumlahElement.innerHTML);
document.querySelector(".tambah").addEventListener("click", function (e) {
    jumlah += 1;
    if (jumlah > this.getAttribute("data-stok")) {
        Swal.fire({
            title: "Oops!",
            text: "Anda sudah mencapai batas pembelian",
            icon: "error",
            confirmButtonText: "OK",
        });
        return;
    }

    jumlahElement.innerHTML = jumlah;
    jumlahPD.value = jumlah;
    jumlahBeli.value = jumlah;
});

document.querySelector(".kurangi").addEventListener("click", function () {
    if (jumlah == 0) {
        return;
    } else {
        jumlah -= 1;
    }

    jumlahElement.innerHTML = jumlah;
    jumlahPD.value = jumlah;
    jumlahBeli.value = jumlah;
});

// function simpanKeranjang() {
//     localStorage.setItem("keranjang", JSON.stringify(keranjang));
//     jumlahElement.innerHTML = 0;
//     perbaruiKeranjang();
// }

savekeranjang.addEventListener("click", function (e) {
    const kode = this.getAttribute("data-kode");
    const nama = this.getAttribute("data-nama");
    const gambar = this.getAttribute("data-gambar");
    const harga = parseInt(this.getAttribute("data-harga"));
    if (jumlah == 0) {
        Swal.fire({
            title: "Oops!",
            text: "Masukkan jumlah terlebih dahulu",
            icon: "error",
            confirmButtonText: "OK",
        });
        e.preventDefault();
    }
});
beliBtn.addEventListener("click", function (e) {
    if (jumlah == 0) {
        Swal.fire({
            title: "Oops!",
            text: "Masukkan jumlah terlebih dahulu",
            icon: "error",
            confirmButtonText: "OK",
        });
        e.preventDefault();
    }
});

function validasiCheckboxStok(itemId) {
    const checkbox = document.getElementById(`checkbox${itemId}`);
    const jumlahKer = document.getElementById(`jumlahKer${itemId}`);
    const stokEl = document.getElementById(`jumlahStok${itemId}`);
    const status = document.getElementById(`status-stok${itemId}`);

    if (!checkbox || !jumlahKer || !stokEl) return;

    const jumlah = parseInt(jumlahKer.textContent, 10);
    const stok = parseInt(stokEl.value, 10);

    if (jumlah > stok) {
        checkbox.disabled = true;
        checkbox.checked = false;
        checkbox.classList.add("opacity-50", "cursor-not-allowed");
        checkbox.classList.remove("item-checkbox", "cursor-pointer");

        if (status) status.hidden = false;
    } else {
        checkbox.disabled = false;
        checkbox.classList.remove("opacity-50", "cursor-not-allowed");
        checkbox.classList.add("item-checkbox", "cursor-pointer");

        if (status) status.hidden = true;
    }

    updateTotal();
}

function getCheckboxes() {
    return document.querySelectorAll('input[id^="checkbox"]');
}
document.addEventListener("change", function (e) {
    if (e.target.matches('input[id^="checkbox"]')) {
        updateTotal();
    }
});
