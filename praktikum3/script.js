/* =================================
FORM PENDAFTARAN MAHASISWA
================================= */

const form = document.getElementById("formPendaftaran");

const fotoInput = document.getElementById("foto");

const fotoTampil = document.getElementById("fotoTampil");

const fotoPlaceholder =
document.getElementById("fotoPlaceholder");

const pesan = document.getElementById("pesan");

/* =================================
MEMBACA DATA DARI LOCAL STORAGE
================================= */

function tampilkanData() {

const data =
    JSON.parse(localStorage.getItem("dataMahasiswa"));

if (!data) {
    return;
}


document.getElementById("nama").value =
    data.nama || "";

document.getElementById("nim").value =
    data.nim || "";

document.getElementById("nik").value =
    data.nik || "";

document.getElementById("tempatLahir").value =
    data.tempatLahir || "";

document.getElementById("tanggalLahir").value =
    data.tanggalLahir || "";

document.getElementById("prodi").value =
    data.prodi || "";

document.getElementById("tahunMasuk").value =
    data.tahunMasuk || "";

document.getElementById("email").value =
    data.email || "";

document.getElementById("hp").value =
    data.hp || "";

document.getElementById("alamat").value =
    data.alamat || "";


/* Radio jenis kelamin */

if (data.kelamin) {

    const radio =
        document.querySelector(
            `input[name="kelamin"][value="${data.kelamin}"]`
        );

    if (radio) {
        radio.checked = true;
    }

}


perbaruiProfil(data);


/* Foto */

if (data.foto) {

    fotoTampil.src = data.foto;

    fotoTampil.style.display = "block";

    fotoPlaceholder.style.display = "none";

}

}

/* =================================
MENAMPILKAN DATA KE PROFIL
================================= */

function perbaruiProfil(data) {

document.getElementById("tampilNama").textContent =
    data.nama || "Belum diisi";

document.getElementById("tampilNim").textContent =
    data.nim || "Belum diisi";

document.getElementById("tampilProdi").textContent =
    data.prodi || "Belum diisi";

document.getElementById("tampilLahir").textContent =
    data.tempatLahir && data.tanggalLahir
        ? `${data.tempatLahir}, ${data.tanggalLahir}`
        : "Belum diisi";

document.getElementById("tampilKelamin").textContent =
    data.kelamin || "Belum diisi";

document.getElementById("tampilAlamat").textContent =
    data.alamat || "Belum diisi";

document.getElementById("tampilEmail").textContent =
    data.email || "Belum diisi";

document.getElementById("tampilHp").textContent =
    data.hp || "Belum diisi";

}

/* =================================
PREVIEW FOTO
================================= */

fotoInput.addEventListener("change", function () {

const file = this.files[0];

if (!file) {
    return;
}


if (!file.type.startsWith("image/")) {

    alert("File yang dipilih harus berupa gambar.");

    this.value = "";

    return;
}


const reader = new FileReader();


reader.onload = function (event) {

    fotoTampil.src = event.target.result;

    fotoTampil.style.display = "block";

    fotoPlaceholder.style.display = "none";

};


reader.readAsDataURL(file);

});

/* =================================
SIMPAN FORM
================================= */

form.addEventListener("submit", function (event) {

event.preventDefault();


const dataLama =
    JSON.parse(localStorage.getItem("dataMahasiswa")) || {};


const kelamin =
    document.querySelector(
        'input[name="kelamin"]:checked'
    );


const data = {

    nama:
        document.getElementById("nama").value,

    nim:
        document.getElementById("nim").value,

    nik:
        document.getElementById("nik").value,

    tempatLahir:
        document.getElementById("tempatLahir").value,

    tanggalLahir:
        document.getElementById("tanggalLahir").value,

    kelamin:
        kelamin ? kelamin.value : "",

    prodi:
        document.getElementById("prodi").value,

    tahunMasuk:
        document.getElementById("tahunMasuk").value,

    email:
        document.getElementById("email").value,

    hp:
        document.getElementById("hp").value,

    alamat:
        document.getElementById("alamat").value,

    foto:
        dataLama.foto || ""

};


/* Jika memilih foto baru */

const file = fotoInput.files[0];


if (file) {

    const reader = new FileReader();


    reader.onload = function (event) {

        data.foto = event.target.result;

        simpanData(data);

    };


    reader.readAsDataURL(file);

} else {

    simpanData(data);

}

});

/* =================================
FUNGSI SIMPAN
================================= */

function simpanData(data) {

localStorage.setItem(
    "dataMahasiswa",
    JSON.stringify(data)
);


perbaruiProfil(data);


if (data.foto) {

    fotoTampil.src = data.foto;

    fotoTampil.style.display = "block";

    fotoPlaceholder.style.display = "none";

}


pesan.textContent =
    "Data mahasiswa berhasil disimpan.";

pesan.className = "pesan sukses";


/* Pindah ke profil */

document.getElementById("profil").scrollIntoView({
    behavior: "smooth"
});

}

/* =================================
RESET DATA
================================= */

document.getElementById("btnReset")
.addEventListener("click", function () {

    const yakin =
        confirm(
            "Apakah Anda yakin ingin menghapus seluruh data?"
        );


    if (!yakin) {
        return;
    }


    localStorage.removeItem("dataMahasiswa");


    form.reset();


    document.getElementById("tampilNama").textContent =
        "Belum diisi";

    document.getElementById("tampilNim").textContent =
        "Belum diisi";

    document.getElementById("tampilProdi").textContent =
        "Belum diisi";

    document.getElementById("tampilLahir").textContent =
        "Belum diisi";

    document.getElementById("tampilKelamin").textContent =
        "Belum diisi";

    document.getElementById("tampilAlamat").textContent =
        "Belum diisi";

    document.getElementById("tampilEmail").textContent =
        "Belum diisi";

    document.getElementById("tampilHp").textContent =
        "Belum diisi";


    fotoTampil.src = "";

    fotoTampil.style.display = "none";

    fotoPlaceholder.style.display = "flex";


    pesan.textContent =
        "Data mahasiswa berhasil dihapus.";

    pesan.className = "pesan sukses";

});

/* =================================
JALANKAN SAAT HALAMAN DIBUKA
================================= */

tampilkanData();