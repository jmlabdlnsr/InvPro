<?php
include_once 'config/Database.php';
include_once 'models/Barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

$id = isset($_GET['id']) ? $_GET['id'] : die('ID tidak ditemukan');
$query = "SELECT * FROM barang WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header("Location: index.php");
    exit();
}

include 'includes/header.php';
?>

<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="index.php" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-slate-900 mt-4">Edit Data Barang</h2>
        <p class="text-slate-500 text-sm">Update informasi stok atau harga barang.</p>
    </div>

    <div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
        <form action="proses.php" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-tag"></i>
                    </div>
                    <input type="text" name="nama_barang" value="<?php echo $data['nama_barang']; ?>" required 
                           class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition" 
                           placeholder="Masukkan nama barang...">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Satuan (Rp)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 font-bold">
                            Rp
                        </div>
                        <input type="number" name="harga" value="<?php echo $data['harga']; ?>" required min="1"
                               class="block w-full pl-12 pr-3 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition" 
                               placeholder="0">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Stok</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <input type="number" name="stok" value="<?php echo $data['stok']; ?>" required min="0"
                               class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition" 
                               placeholder="0">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center gap-4">
                <button type="submit" name="update" 
                        class="flex-1 bg-emerald-600 text-white py-3 px-6 rounded-xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition focus:ring-4 focus:ring-emerald-100">
                    <i class="fas fa-sync-alt mr-2"></i> Update Perubahan
                </button>
                <a href="index.php" class="px-6 py-3 border border-slate-200 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>