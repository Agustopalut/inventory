document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-delete').forEach(button => {

        button.addEventListener('click', function (e) {

            e.preventDefault();

            const form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });

});


const idbarang = document.getElementById('id_barang');

if (idbarang) {

    document.getElementById('id_barang').addEventListener('change', function () {

        let id = this.value;

        if (id == '') {
            document.getElementById('satuanBarang').value = '';
            return;
        }

        fetch('/barang-masuk/' + id)
            .then(response => response.json())
            .then(data => {

                document.getElementById('satuanBarang').value = data.satuan;

            });

    });


}







const harga = document.getElementById('hargaSatuan');
const jumlah = document.getElementById('jumlahBarang');
const subtotal = document.getElementById('subTotal');

function hitungSubtotal() {
    let hargaSatuan = Number(harga.value) || 0;
    let jumlahMasuk = Number(jumlah.value) || 0;

    subtotal.value = 'Rp' + (hargaSatuan * jumlahMasuk).toLocaleString('id-ID');
}

// Dijalankan setiap user mengetik

if (harga && jumlah && subtotal) {

    harga.addEventListener('input', hitungSubtotal);
    jumlah.addEventListener('input', hitungSubtotal);

}
// harga.addEventListener('input', hitungSubtotal);
// jumlah.addEventListener('input', hitungSubtotal);



// Proses barang keluar




