@extends("layouts.base")
@section("content")

<div class="container-fluid">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Formulir Pertimbangan Permohonan Cuti</h6>
        </div>
        <div class="card-body" >
          <div class="row">
            <div class="col-md-12">
              {{-- <h5>Data Mahasiswa</h5> --}}

              <section style="font-family: serif; color: black; padding:16px 20%" id="content-html">
                <h6 class="text-center"><strong>PERMOHONAN IZIN CUTI</strong></h6>
                <p class="mb-0">Yang bertanda tangan dibawah ini : </p>
                <table>
                  <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $data["nama"][0]["value"] }}</td>
                  </tr>
                  <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td>{{ $data["nim"][0]["value"] }}</td>
                  </tr>
                  <tr>
                    <td>Program Studi</td>
                    <td>:</td>
                    <td>{{ $data["prodi"][0]["value"] }}</td>
                  </tr>
                  <tr>
                    <td>SKS Tempuh</td>
                    <td>:</td>
                    <td>{{ $data["sks_tempuh"][0]["value"] }}</td>
                  </tr>
                  <tr>
                    <td>SKS Lulus</td>
                    <td>:</td>
                    <td>{{ $data["sks_lulus"][0]["value"] }}</td>
                  </tr>
                </table>
                <p>Dengan ini mengajukan izin Cuti Studi dengan alasan <strong>{{ $data["alasan"][0]["value"] }}</strong>.</p>
                <p>Demikian permohonan izin cuti ini dibuat untuk dipertimbangkan sesuai peraturan/ketentuan yang berlaku.</p>
                
                <div class="row ">
                  <div class="offset-md-8 col-md-4">
                    <p>Balikpapan, {{ date("d M Y") }}</p>
                  </div>
                  <div class="col-md-8">
                    <p>Mengetahui, <br>Dosen Wali,</p>
                      @if(count($data["ttd_dosen_wali"]) > 0)
                        <img src="{{ env("API_URL") }}/variable-instance/{{ $data["ttd_dosen_wali"][0]["id"] }}/data" style="width:200px; height:67.75px">
                      @else
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAoMBgDTD2qgAAAAASUVORK5CYII=" id="img-sign-dosen_wali" alt="" style="width:200px; height:67.75px">
                      @endif
                      <p>{{ $data["nama_doswal"][0]["value"] }}<br>NIP/NIPH. {{ $data["nip_doswal"][0]["value"] }}</p>
                  </div>
                  <div class="col-md-4">
                    <p><br> Mahasiswa,</p>
                      <img src="{{ env("API_URL") }}/variable-instance/{{ $data["ttd_mahasiswa"][0]["id"] }}/data" style="width:200px; height:67.75px">
                    <p>{{ $data["nama"][0]["value"] }} <br>NIM. {{ $data["nim"][0]["value"] }}</p>
                  </div>
                  <div class="m-auto text-center">
                    <p>Mengetahui, <br>Koorprodi {{ $data["nama_koorprodi"][0]["value"] }}</p>
                    @if(count($data["ttd_koordinator_prodi"]) > 0)
                        <img src="{{ env("API_URL") }}/variable-instance/{{ $data["ttd_koordinator_prodi"][0]["id"] }}/data" style="width:200px; height:67.75px">
                    @else
                      <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAoMBgDTD2qgAAAAASUVORK5CYII=" id="img-sign-koordinator_prodi" alt="" style="width:200px; height:67.75px">
                    @endif
                    <p>{{ $data["nama_koorprodi"][0]["value"] }} <br>NIP/NIPH. {{ $data["nip_koorprodi"][0]["value"] }}</p>
                  </div>
                </div>
              </section>

              <hr>

              <div class="row">
              @foreach ($data["task"] as $dt)
              <div class="col-md-6">
                <label for="">Tanda Tangan {{ $dt["assignee"] }}</label>
                <canvas id="signature-pad-{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" style="border: 1px solid black; width: 100%; height: 200px"></canvas>
                <button class="btn btn-danger" id="clear_{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" type="button">Clear</button>
                
                <label for="signature-input-file-{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" class="btn btn-primary mb-0">Choose From File</label>

                <form action="/memberikan-tanda-tangan" method="POST" enctype="multipart/form-data">
                  @csrf
                  <br>
                  <input type="hidden" name="id" value="{{ $dt["id"] }}">
                  <input type="hidden" name="assignee" value="{{ $dt["assignee"] }}">
                  <input type="hidden" name="file" id="">

                  <input type="file" id="signature-input-file-{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" accept="image/*" style="display: none">

                  <input type="text" name="signature_{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" id="signature-file-{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" required style="display: none">

                  {{-- <div class="form-group">
                    <label for="tanda_tangan">Tanda Tangan {{ $dt["assignee"] }}</label>
                    <input type="file" id="ttd_{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" class="form-control" name="ttd_{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" accept="image/*" required>
                  </div> --}}
                  <button type="submit" class="btn btn-primary w-100">Kirim</button>
                </form>
              </div>
              @endforeach
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br>

</div>


<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
  @if(count($data["ttd_dosen_wali"]) == 0)

  var canvasDoswal = document.getElementById("signature-pad-dosen_wali");
  var clearDoswal = document.getElementById("clear_dosen_wali");
  var imgSignDosenWali = document.getElementById("img-sign-dosen_wali");
  var signatureFileDoswal = document.getElementById("signature-file-dosen_wali");

  var signatureInputFileDoswal = document.getElementById("signature-input-file-dosen_wali");
    
    function resizeCanvasDoswal() {
      var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvasDoswal.width = canvasDoswal.offsetWidth * ratio;
        canvasDoswal.height = canvasDoswal.offsetHeight * ratio;
        canvasDoswal.getContext("2d").scale(ratio, ratio);
        
      }
      window.onresize = resizeCanvasDoswal;
      resizeCanvasDoswal();
      
      const signaturePadDoswal = new SignaturePad(canvasDoswal, {
        backgroundColor: 'rgb(255, 255, 255)',
        minWidth: 1,
        maxWidth: 3,
        penColor: "rgb(0,0,0)"
      });

      signatureInputFileDoswal.addEventListener("change", function() {
            var file = signatureInputFileDoswal.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                signaturePadDoswal.fromDataURL(e.target.result);
                imgSignDosenWali.src = e.target.result;
                signatureFileDoswal.value = e.target.result;
            };
            reader.readAsDataURL(file);
        });
      
      clearDoswal.addEventListener("click", function(e) {
        signaturePadDoswal.clear();
        signatureFileDoswal.value = "";
        imgSignDosenWali.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAoMBgDTD2qgAAAAASUVORK5CYII=";
        signatureInputFileDoswal.value = "";
      });
      
      signaturePadDoswal.addEventListener("endStroke", () => {
        const data = signaturePadDoswal.toDataURL("image/jpeg");
        signatureFileDoswal.value = data;
        imgSignDosenWali.src = data;
      }, { once: false });
    @endif
      
  @if(count($data["ttd_koordinator_prodi"]) == 0)
    var canvasKoorpro = document.getElementById("signature-pad-koordinator_prodi");
    var clearKoorpro = document.getElementById("clear_koordinator_prodi");
    var imgSignKoorprodi = document.getElementById("img-sign-koordinator_prodi");
    var signatureFileKoorpro = document.getElementById("signature-file-koordinator_prodi");

    var signatureInputFileKoorpro = document.getElementById("signature-input-file-koordinator_prodi");

    function resizeCanvasKoorprodi() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvasKoorpro.width = canvasKoorpro.offsetWidth * ratio;
        canvasKoorpro.height = canvasKoorpro.offsetHeight * ratio;
        canvasKoorpro.getContext("2d").scale(ratio, ratio);
      }
      window.onresize = resizeCanvasKoorprodi;
      resizeCanvasKoorprodi();

    const signaturePadKoorpro = new SignaturePad(canvasKoorpro, {
        backgroundColor: 'rgb(255, 255, 255)',
        minWidth: 1,
        maxWidth: 3,
        penColor: "rgb(0,0,0)"
    });

    signatureInputFileKoorpro.addEventListener("change", function() {
            var file = signatureInputFileKoorpro.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                signaturePadKoorpro.fromDataURL(e.target.result);
                imgSignKoorprodi.src = e.target.result;
                signatureFileKoorpro.value = e.target.result;
            };
            reader.readAsDataURL(file);
        });

    clearKoorpro.addEventListener("click", function(e) {
        signaturePadKoorpro.clear();
        signatureFileKoorpro.value = "";
        imgSignKoorprodi.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAoMBgDTD2qgAAAAASUVORK5CYII=";
        signatureInputFileKoorpro.value = "";
    });

    signaturePadKoorpro.addEventListener("endStroke", () => {
        const data = signaturePadKoorpro.toDataURL("image/jpeg");
        signatureFileKoorpro.value = data;
        imgSignKoorprodi.src = data;
      }, { once: false });
  @endif


</script>
@endsection
