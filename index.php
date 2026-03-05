<?php include 'includes/header.php'; ?>

<!-- Page Title & CTA -->
<div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="flex-1">
        <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900 leading-tight">Daftar Barang</h2>
    </div>
    <div class="flex">
        <button onclick="toggleModal('modal-barang', 'add')" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 sm:px-6 border border-transparent rounded-xl shadow-lg shadow-indigo-100 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition-all">
            <i class="fas fa-plus mr-2 text-xs"></i> Tambah Barang
        </button>
    </div>
</div>

<!-- Stats Dashboard (Grid 1 Kolom HP, 2 Kolom Tablet, 3 Kolom Desktop) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-200 hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-5 flex items-center">
            <div class="bg-blue-100 p-2.5 sm:p-3 rounded-xl text-blue-600 mr-4">
                <i class="fas fa-boxes text-lg sm:text-xl"></i>
            </div>
            <div>
                <dt class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest">Total Jenis</dt>
                <dd id="stat-jenis" class="text-xl sm:text-2xl font-black text-slate-900">0</dd>
            </div>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-200 hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-5 flex items-center">
            <div class="bg-emerald-100 p-2.5 sm:p-3 rounded-xl text-emerald-600 mr-4">
                <i class="fas fa-layer-group text-lg sm:text-xl"></i>
            </div>
            <div>
                <dt class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest">Total Stok</dt>
                <dd id="stat-stok" class="text-xl sm:text-2xl font-black text-slate-900">0</dd>
            </div>
        </div>
    </div>
    <!-- Nilai Inventaris Menjadi Full-width di Tablet untuk menjaga estetika -->
    <div class="bg-indigo-600 overflow-hidden shadow-lg shadow-indigo-100 rounded-2xl sm:col-span-2 lg:col-span-1">
        <div class="p-4 sm:p-5 flex items-center">
            <div class="bg-indigo-500/50 p-2.5 sm:p-3 rounded-xl text-white mr-4">
                <i class="fas fa-coins text-lg sm:text-xl"></i>
            </div>
            <div>
                <dt class="text-[10px] sm:text-xs font-bold text-indigo-100 uppercase tracking-widest">Nilai Inventaris</dt>
                <dd id="stat-nilai" class="text-xl sm:text-2xl font-black text-white">Rp 0</dd>
            </div>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
    <!-- Kontainer Overflow Horizontal dengan Scrollbar Kustom -->
    <div class="overflow-x-auto custom-scrollbar">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 sm:px-6 py-4 text-left text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-widest">Barang</th>
                    <th class="px-5 sm:px-6 py-4 text-left text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-widest">Harga</th>
                    <th class="px-5 sm:px-6 py-4 text-center text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-widest">Stok</th>
                    <th class="px-5 sm:px-6 py-4 text-right text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-widest">Opsi</th>
                </tr>
            </thead>
            <tbody id="api-table-body" class="bg-white divide-y divide-slate-100">
                <!-- Data Rendered by API -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form - Fit Screen for Mobile -->
<div id="modal-barang" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 transition-all opacity-0 overflow-y-auto">
    <div class="bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform translate-y-full sm:translate-y-0 sm:scale-95 transition-all duration-300">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 id="modal-title" class="text-lg font-bold text-slate-900">Tambah Barang Baru</h3>
            <button onclick="toggleModal('modal-barang')" class="w-8 h-8 rounded-full hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-colors"><i class="fas fa-times"></i></button>
        </div>
        <form id="form-barang" class="p-6 sm:p-8 space-y-5">
            <input type="hidden" id="item-id">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Barang</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-300 text-sm"><i class="fas fa-tag"></i></div>
                    <input type="text" id="nama_barang" required class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 text-sm outline-none transition-all" placeholder="Contoh: Meja Lipat">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Harga (Rp)</label>
                    <input type="number" id="harga" required min="1" class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 text-sm outline-none transition-all" placeholder="0">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Jumlah Stok</label>
                    <input type="number" id="stok" required min="0" class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 text-sm outline-none transition-all" placeholder="0">
                </div>
            </div>
            <div class="flex gap-4 pt-4 mb-4 sm:mb-0">
                <button type="button" onclick="toggleModal('modal-barang')" class="flex-1 py-3.5 px-4 border border-slate-200 rounded-xl text-slate-600 text-sm font-bold hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-3.5 px-4 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all active:scale-95">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Alert (Center Mobile, Right-Bottom Desktop) -->
<div id="toast" class="fixed bottom-6 left-6 right-6 sm:left-auto sm:right-10 px-6 py-4 rounded-2xl text-white text-sm font-bold shadow-2xl z-[60] hidden flex items-center gap-3 transition-all transform translate-y-10">
    <i id="toast-icon" class="fas fa-check-circle"></i>
    <span id="toast-msg">Notifikasi</span>
</div>

<script>
    const API_URLS = {
        read: 'api/read.php',
        create: 'api/create.php',
        update: 'api/update.php',
        delete: 'api/delete.php'
    };

    let isEditMode = false;
    let allItems = []; // Simpan data di variabel global

    async function loadData() {
        try {
            const res = await fetch(API_URLS.read);
            const data = await res.json();
            allItems = data.records || [];
            const tbody = document.getElementById('api-table-body');
            
            if (allItems.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 text-sm italic">Database API Kosong.</td></tr>`;
            } else {
                tbody.innerHTML = allItems.map(item => `
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-5 sm:px-6 py-4">
                            <div class="flex items-center min-w-[120px]">
                                <div class="h-8 w-8 sm:h-9 sm:w-9 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 mr-3 sm:mr-4 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                    <i class="fas fa-box text-sm sm:text-base"></i>
                                </div>
                                <div class="font-bold text-slate-900 text-sm sm:text-base">${item.nama_barang}</div>
                            </div>
                        </td>
                        <td class="px-5 sm:px-6 py-4 text-xs sm:text-sm text-slate-500">
                            Rp ${parseInt(item.harga).toLocaleString('id-ID')}
                        </td>
                        <td class="px-5 sm:px-6 py-4 text-center">
                            <span class="inline-flex px-2 sm:px-3 py-1 text-[10px] font-black rounded-full border ${item.stok <= 5 ? 'bg-rose-50 border-rose-100 text-rose-600' : 'bg-emerald-50 border-emerald-100 text-emerald-600'}">
                                ${item.stok} <span class="hidden sm:inline ml-1">Unit</span>
                            </span>
                        </td>
                        <td class="px-5 sm:px-6 py-4 text-right space-x-1 sm:space-x-2 whitespace-nowrap">
                            <button onclick="openEdit(${item.id})" class="text-indigo-600 hover:bg-indigo-50 p-2 rounded-lg transition-colors" title="Edit">
                                <i class="fas fa-edit text-xs sm:text-sm"></i>
                            </button>
                            <button onclick="deleteItem(${item.id})" class="text-rose-600 hover:bg-rose-50 p-2 rounded-lg transition-colors" title="Hapus">
                                <i class="fas fa-trash text-xs sm:text-sm"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
            }

            // Update Statistik
            const totalStok = allItems.reduce((a, b) => a + parseInt(b.stok), 0);
            const totalNilai = allItems.reduce((a, b) => a + (parseInt(b.harga) * parseInt(b.stok)), 0);
            
            document.getElementById('stat-jenis').innerText = allItems.length;
            document.getElementById('stat-stok').innerText = totalStok;
            document.getElementById('stat-nilai').innerText = `Rp ${totalNilai.toLocaleString('id-ID')}`;

        } catch (error) {
            console.error("API Connection Error:", error);
        }
    }

    document.getElementById('form-barang').addEventListener('submit', async (e) => {
        e.preventDefault();
        const payload = {
            id: document.getElementById('item-id').value,
            nama_barang: document.getElementById('nama_barang').value,
            harga: document.getElementById('harga').value,
            stok: document.getElementById('stok').value
        };
        const method = isEditMode ? 'PUT' : 'POST';
        const url = isEditMode ? API_URLS.update : API_URLS.create;

        try {
            const res = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const result = await res.json();
            showToast(result.message, res.ok ? 'success' : 'error');
            if (res.ok) { toggleModal('modal-barang'); loadData(); }
        } catch (error) { showToast("Gagal memproses data", "error"); }
    });

    async function deleteItem(id) {
        if (!confirm("Hapus data ini?")) return;
        try {
            const res = await fetch(API_URLS.delete, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });
            const result = await res.json();
            showToast(result.message, res.ok ? 'success' : 'error');
            loadData();
        } catch (err) { showToast("Gagal menghapus", "error"); }
    }

    // Modal & Toast Helpers
    function toggleModal(id, mode = 'add') {
        const modal = document.getElementById(id);
        const inner = modal.querySelector('div');
        isEditMode = (mode === 'edit');
        document.getElementById('modal-title').innerText = isEditMode ? 'Edit Data Barang' : 'Tambah Barang Baru';
        if (!isEditMode) {
            document.getElementById('form-barang').reset();
            document.getElementById('item-id').value = '';
        }

        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                inner.classList.remove('translate-y-full', 'sm:scale-95');
                inner.classList.add('translate-y-0', 'sm:scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('opacity-0');
            inner.classList.remove('translate-y-0', 'sm:scale-100');
            inner.classList.add('translate-y-full', 'sm:scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }
    }

    function openEdit(id) {
        const item = allItems.find(i => i.id == id);
        if (!item) return;

        toggleModal('modal-barang', 'edit');
        document.getElementById('item-id').value = item.id;
        document.getElementById('nama_barang').value = item.nama_barang;
        document.getElementById('harga').value = item.harga;
        document.getElementById('stok').value = item.stok;
    }

    function showToast(msg, type) {
        const toast = document.getElementById('toast');
        const icon = document.getElementById('toast-icon');
        toast.className = `fixed bottom-6 left-6 right-6 sm:left-auto sm:right-10 px-6 py-4 rounded-2xl text-white text-sm font-bold shadow-2xl z-[60] transition-all transform flex items-center gap-3 ${type === 'success' ? 'bg-emerald-600' : 'bg-rose-600'}`;
        icon.className = `fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'}`;
        document.getElementById('toast-msg').innerText = msg;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.remove('translate-y-10'), 10);
        setTimeout(() => {
            toast.classList.add('translate-y-10');
            setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3000);
    }

    window.onload = loadData;
</script>

<?php include 'includes/footer.php'; ?>