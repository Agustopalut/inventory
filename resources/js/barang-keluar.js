
document.addEventListener('DOMContentLoaded', function () {

    const tombol = document.getElementById('btnTambahBarang');
    const tbody = document.getElementById('detailBarang');

    // TAMBAH BARANG
    if (tombol) {
        tombol.addEventListener('click', function () {

            const row = document.createElement('tr');

            let options = `
            <option value="">Pilih Barang :</option>
        `;

            dataBarang.forEach(function (item) {

                options += `
                <option value="${item.id_barang}">
                    ${item.nama_barang}
                </option>
            `;

            });

            row.innerHTML = `
            <td>
                <select class="form-select barang-detail" name="id_barang[]">
                    ${options}
                </select>
            </td>

            <td>
                <input type="number"
                       name="jumlah[]"
                       class="form-control">
            </td>
            <td>
                <input type="text"
                       name="satuan"
                       class="form-control satuan-detail" id="satuan_barang" disabled readonly>
            </td>

            <td>
                <button type="button"
                        class="btn btn-danger btnHapusBarang">
                    Hapus
                </button>
            </td>
        `;

            tbody.appendChild(row);

            const selectBarang = row.querySelector('.barang-detail');
            const inputSatuan = row.querySelector('.satuan-detail');

            selectBarang.addEventListener('change', function () {

                const id = this.value;

                if (id === '') {
                    inputSatuan.value = '';
                    return;
                }

                const barang = dataBarang.find(item => item.id_barang == id);

                if (barang) {
                    inputSatuan.value = barang.satuan;
                }
            });

        });
    }


    if(tbody) {

        tbody.addEventListener('click', function (event) {

        const tombolHapus = event.target.closest('.btnHapusBarang');

        if (tombolHapus) {

            const row = tombolHapus.closest('tr');

            row.remove();

            console.log('Barang berhasil dihapus');
        }

    });

    }    

});