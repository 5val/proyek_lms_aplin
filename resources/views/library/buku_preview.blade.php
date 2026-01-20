<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preview Buku - {{ $book->JUDUL }}</title>
  <style>
    body, html { margin: 0; padding: 0; height: 100%; background: #0b1a2b; color: #e8edf4; font-family: Arial, sans-serif; }
    header { padding: 12px 16px; background: #0f243a; border-bottom: 1px solid #1f3b55; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
    header .title { font-size: 15px; font-weight: 600; }
    header .meta { font-size: 12px; color: #8fa3b8; }
    #controls { display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: #0f243a; border-bottom: 1px solid #1f3b55; flex-wrap: wrap; }
    #controls input { width: 80px; padding: 6px 8px; border-radius: 4px; border: 1px solid #24476a; background: #0b1a2b; color: #e8edf4; }
    #controls button { padding: 6px 12px; border: none; border-radius: 4px; background: #f97316; color: #fff; cursor: pointer; }
    #controls .info { font-size: 12px; color: #8fa3b8; }
    #viewer { height: calc(100% - 112px); overflow-y: auto; }
    .page-container { margin: 8px auto; max-width: 980px; box-shadow: 0 6px 22px rgba(0,0,0,0.35); background: #0f243a; padding: 12px; border-radius: 6px; }
    canvas { width: 100%; height: auto; background: white; border-radius: 4px; }
    .loading { text-align: center; padding: 24px; color: #c9d6e2; }
    .error { color: #f56565; text-align: center; padding: 16px; }
    .watermark-note { font-size: 11px; color: #9fb3c8; }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
  <header>
    <div>
      <div class="title">{{ $book->JUDUL }}</div>
      <div class="meta">Preview hanya-baca</div>
    </div>
    <div class="watermark-note"></div>
    <a href="{{ route($backRoute ?? 'siswa.buku.index') }}" style="color:#f97316; font-weight:600; text-decoration:none;">&larr; Kembali</a>
  </header>
  <div id="controls">
    <span class="info">Lompat ke halaman:</span>
    <input type="number" id="pageInput" min="1" value="1" aria-label="Nomor halaman">
    <button id="goPage" type="button">Ke Halaman</button>
    <span class="info" id="pageInfo">Halaman 1</span>
  </div>
  <div id="viewer"></div>
  <div id="status" class="loading">Memuat buku...</div>

  <script>
    const url = @json($fileUrl);

    const statusEl = document.getElementById('status');
    const viewer = document.getElementById('viewer');
    const pageInput = document.getElementById('pageInput');
    const pageInfo = document.getElementById('pageInfo');
    const goPage = document.getElementById('goPage');
    const pageNodes = new Map();
    let totalPages = 0;

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    function renderPage(pdf, pageNumber) {
      return pdf.getPage(pageNumber).then(page => {
        const viewport = page.getViewport({ scale: 1.2 });
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const container = document.createElement('div');
        container.className = 'page-container';
        container.id = `page-${pageNumber}`;
        container.appendChild(canvas);
        viewer.appendChild(container);
        pageNodes.set(pageNumber, container);

        const renderContext = { canvasContext: context, viewport: viewport }; // Canvas render
        return page.render(renderContext).promise;
      });
    }

    pdfjsLib.getDocument({ url, withCredentials: true }).promise.then(pdf => {
      statusEl.textContent = 'Merender halaman...';
      const renderTasks = [];
      totalPages = pdf.numPages;
      pageInfo.textContent = `Halaman 1 dari ${totalPages}`;
      pageInput.max = totalPages;
      for (let i = 1; i <= pdf.numPages; i++) {
        renderTasks.push(renderPage(pdf, i));
      }
      return Promise.all(renderTasks);
    }).then(() => {
      statusEl.remove();
    }).catch(err => {
      console.error(err);
      statusEl.className = 'error';
      statusEl.textContent = 'Gagal memuat PDF.';
    });

    function scrollToPage(pageNumber) {
      if (!pageNodes.has(pageNumber)) {
        return;
      }
      const target = pageNodes.get(pageNumber);
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      pageInfo.textContent = `Halaman ${pageNumber} dari ${totalPages}`;
    }

    goPage.addEventListener('click', () => {
      const value = parseInt(pageInput.value, 10);
      if (!Number.isInteger(value)) return;
      const clamped = Math.min(Math.max(value, 1), totalPages || 1);
      scrollToPage(clamped);
    });

    pageInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        goPage.click();
      }
    });

    // Disable context menu to reduce easy save attempts
    document.addEventListener('contextmenu', (e) => e.preventDefault());
  </script>
</body>
</html>
