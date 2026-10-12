document.addEventListener('DOMContentLoaded', function () {
    const jenisLaporan = document.getElementById('jenisLaporan');

    if (jenisLaporan) { 

    
        const tanggalAwal = document.getElementById('tanggalAwal');
        const tanggalAkhir = document.getElementById('tanggalAkhir');
        const bulanContainer = document.getElementById('containerBulan');
        const tahunContainer = document.getElementById('containerTahun');
        console.log(bulanContainer);

        jenisLaporan.addEventListener('change', function (e) {

            tanggalAwal.style.display = 'none';
            tanggalAkhir.style.display = 'none';
            bulanContainer.style.display = 'none';
            tahunContainer.style.display = 'none';

            if (this.value === 'harian') {
                bulanContainer.style.display = 'none'
                tahunContainer.style.display = 'none'
                tanggalAwal.style.display = 'block';
                tanggalAkhir.style.display = 'block';
            } 

            if(this.value === 'bulan') {
                bulanContainer.style.display = 'block'
                tahunContainer.style.display = 'block'
                tanggalAwal.style.display = 'none';
                tanggalAkhir.style.display = 'none';
            }

        });
    } else {
        console.log('Error');
    }


})

