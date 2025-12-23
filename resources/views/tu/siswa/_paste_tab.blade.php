{{-- Tab Copy-Paste Content --}}
<div class="tab-pane fade" id="paste-panel" role="tabpanel">
    <form action="{{ route('tu.siswa.import-paste') }}" method="POST" id="pasteForm">
        @csrf
        <div class="alert alert-success">
            <h6 class="alert-heading">
                <i class="fas fa-lightbulb me-2"></i>
                Cara Copy-Paste dari Excel:
            </h6>
            <ol class="mb-0">
                <li>Buka file Excel Anda</li>
                <li><strong>Select semua data</strong> (termasuk header)</li>
                <li><strong>Copy</strong> (Ctrl+C)</li>
                <li><strong>Paste</strong> di kotak bawah (Ctrl+V)</li>
                <li>Klik "Import Data"</li>
            </ol>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>Contoh Format (Copy dari Excel):</strong>
            </div>
            <div class="card-body">
                <pre style="font-size: 11px; margin: 0;">NIS    Nama           Kelas  Jenis Kelamin  Tempat Lahir  Tanggal Lahir  Alamat                Status
10130  Ahmad Budi     7      Laki-laki      Jakarta       2010-05-15     Jl. Merdeka No. 10    aktif
10131  Siti Aisyah    7      Perempuan      Bandung       2010-06-20     Jl. Sudirman No. 15   aktif</pre>
            </div>
        </div>

        <div class="mb-3">
            <label for="pasteData" class="form-label">
                <strong>Paste Data Excel di Sini:</strong>
            </label>
            <textarea class="form-control" id="pasteData" name="paste_data" rows="10" 
                      placeholder="Paste data dari Excel di sini (Ctrl+V)..." required 
                      style="font-family: monospace; font-size: 12px;"></textarea>
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Data akan otomatis dipisahkan berdasarkan Tab dari Excel
            </small>
        </div>

        <div id="pastePreview" class="alert alert-info d-none">
            <strong>Preview:</strong>
            <div id="pastePreviewContent"></div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-paste me-2"></i>Import dari Copy-Paste
            </button>
        </div>
    </form>
</div>
