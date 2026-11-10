// console.log('file search terbaca');
// const searchInput = document.getElementById('input_pencarian');
// const hasilPencarian = document.getElementById('hasil_pencarian');

// let timer;
// let controller;



// function barisPesan(teks) {
//     const tr = document.createElement('tr');
//     const td = document.createElement('td');
//     td.colSpan = 3;
//     td.className = 'text-center';
//     td.textContent = teks;
//     tr.appendChild(td);
//     return tr;
// }

// async function cari(value) {
//     // batalkan request sebelumnya
//     if (controller) controller.abort();
//     controller = new AbortController();

//     const response = await fetch(`/barang-master/search?nama_barang=${encodeURIComponent(value)}`, { headers: { 'Accept': 'application/json' } });
//     const text = await response.text();
//     console.log(response.status, text);   // lihat apa yang sebenarnya dikirim server
//     const data = text ? JSON.parse(text) : [];

//     try {
//         const response = await fetch(
//             `/barang-master/search?nama_barang=${encodeURIComponent(value)}`,
//             {
//                 headers: { 'Accept': 'application/json' },
//                 signal: controller.signal,
//             }
//         );

//         if (!response.ok) {
//             throw new Error(`HTTP ${response.status}`);
//         }

//         const data = await response.json();

//         hasilPencarian.replaceChildren();

//         if (data.length === 0) {
//             hasilPencarian.appendChild(barisPesan('Data tidak ditemukan'));
//             return;
//         }

//         const fragment = document.createDocumentFragment();

//         data.forEach(item => {
//             const tr = document.createElement('tr');

//             [item.nama_barang, item.satuan, item.stok].forEach(teks => {
//                 const td = document.createElement('td');
//                 td.textContent = teks;
//                 tr.appendChild(td);
//             });

//             fragment.appendChild(tr);
//         });

//         hasilPencarian.appendChild(fragment);

//     } catch (error) {
//         if (error.name === 'AbortError') return; // abaikan, ini disengaja

//         console.error(error);
//         hasilPencarian.replaceChildren(barisPesan('Terjadi kesalahan saat mengambil data'));
//     }
// }

// searchInput.addEventListener('input', () => {
//     clearTimeout(timer);
//     timer = setTimeout(() => cari(searchInput.value.trim()), 300);
// });

const searchInput = document.getElementById('input_pencarian');
const hasilPencarian = document.getElementById('hasil_pencarian');

let timer;
let controller;

function barisPesan(teks) {
    const tr = document.createElement('tr');
    const td = document.createElement('td');
    td.colSpan = 5;
    td.className = 'text-center';
    td.textContent = teks;
    tr.appendChild(td);
    return tr;
}

function buatTd(teks) {
    const td = document.createElement('td');
    td.className = 'text-center align-middle';
    td.textContent = teks;
    return td;
}

function buatAction(id) {
    const td = document.createElement('td');
    td.className = 'text-center align-middle';

    // tombol edit
    const edit = document.createElement('a');
    edit.href = `/update/barang-master/${id}`;
    edit.className = 'btn btn-sm btn-warning me-1';
    edit.textContent = 'Edit';
    td.appendChild(edit);

    // tombol hapus
    const form = document.createElement('form');
    form.action = `/delete/barang-master/${id}`;
    form.method = 'POST';
    form.className = 'd-inline';
    form.onsubmit = () => confirm('Yakin hapus data ini?');

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').content;

    const method = document.createElement('input');
    method.type = 'hidden';
    method.name = '_method';
    method.value = 'DELETE';

    const btn = document.createElement('button');
    btn.type = 'submit';
    btn.className = 'btn btn-sm btn-danger';
    btn.textContent = 'Hapus';

    form.append(csrf, method, btn);
    td.appendChild(form);

    return td;
}

async function cari(value) {
    if (controller) controller.abort();
    controller = new AbortController();

    try {
        const response = await fetch(
            `/barang-master/search?nama_barang=${encodeURIComponent(value)}`,
            { headers: { 'Accept': 'application/json' }, signal: controller.signal }
        );

        if (!response.ok) throw new Error(`HTTP ${response.status}`);

        const data = await response.json();
        hasilPencarian.replaceChildren();

        if (data.length === 0) {
            hasilPencarian.appendChild(barisPesan('Data tidak ditemukan'));
            return;
        }

        const fragment = document.createDocumentFragment();

        data.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.append(
                buatTd(index + 1),          // No
                buatTd(item.nama_barang),
                buatTd(item.satuan),
                buatTd(item.stok),
                buatAction(item.id_barang)  // Action
            );
            fragment.appendChild(tr);
        });

        hasilPencarian.appendChild(fragment);

    } catch (error) {
        if (error.name === 'AbortError') return;
        console.error(error);
        hasilPencarian.replaceChildren(barisPesan('Terjadi kesalahan saat mengambil data'));
    }
}

searchInput.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(() => cari(searchInput.value.trim()), 300);
});