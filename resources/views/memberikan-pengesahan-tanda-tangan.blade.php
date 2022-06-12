@extends("layouts.base")
@section("content")

<div class="container-fluid">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Formulir Pengesahan Tanda Tangan {{ $data["task"][0]["assignee"] }}</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">

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
                        <img src="data:image/png;base64, {{ $data["ttd_file_dosen_wali"] }}" style="width:200px">
                      @else
                      <br><br><br>
                      @endif
                      <p>{{ $data["nama_doswal"][0]["value"] }}<br>NIP/NIPH. {{ $data["nip_doswal"][0]["value"] }}</p>
                  </div>
                  <div class="col-md-4">
                    <p><br> Mahasiswa,</p>
                      <img src="data:image/png;base64, {{ $data["ttd_mahasiswa"] }}" style="width:200px">
                    <p>{{ $data["nama"][0]["value"] }} <br>NIM. {{ $data["nim"][0]["value"] }}</p>
                  </div>
                  <div class="m-auto text-center">
                    <p>Mengetahui, <br>Koorprodi {{ $data["nama_koorprodi"][0]["value"] }}</p>
                    @if(count($data["ttd_koordinator_prodi"]) > 0)
                        <img src="data:image/png;base64, {{ $data["ttd_file_koordinator_prodi"] }}" style="width:200px">
                    @else
                    <br><br><br>
                    @endif
                    <p>{{ $data["nama_koorprodi"][0]["value"] }} <br>NIP/NIPH. {{ $data["nip_koorprodi"][0]["value"] }}</p>
                  </div>

                  <div class="col-md-12 m-auto text-center">
                    <p>Mengetahui, <br></p>
                    <img src="/img/ttd_wrba.jpeg" style="margin-left: -50px" alt="">
                  </div> 
                </div>
              </section>

              <hr>

              <button type="button" id="cmd" class="btn btn-primary w-100">
                Kirim Pengesahan Tanda Tangan
              </button>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br>
  
</div>

<div id="editor-content"></div>

@endsection
@section("script")
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>


<script>
var contenttoprint = document.getElementById("content-html");
$('#cmd').click(function () {

  // make loading and disable button
  $('#cmd').html('<i class="fas fa-spinner fa-spin"></i>');
  $('#cmd').attr('disabled', true);

  html2canvas(contenttoprint, {height: document.body.clientHeight, width: document.body.clientWidth})
    .then(function (canvas) {
      var wdt;
      var hgt;

      var img = canvas.toDataURL("image/png", wdt = canvas.width, hgt = canvas.height);
      var rasio = hgt/wdt;

      var doc = new jsPDF("p", "pt", "a4");
      var width = doc.internal.pageSize.width + 300;
      var height = width * rasio;
      doc.addImage(img, "png", -50, 50, width, height);
      // doc.save("Permohonan Izin Cuti.pdf");

      var blob = doc.output("blob");
      var formData = new FormData();
      formData.append("file", blob, "Permohonan Izin Cuti.pdf");
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('id', '{{ $data["task"][0]["id"] }}');
      formData.append('nama', '{{ $data["nama"][0]["value"] }}');
      formData.append('nim', '{{ $data["nim"][0]["value"] }}');
      formData.append('email', '{{ $data["email"][0]["value"] }}');
      formData.append('prodi', '{{ $data["prodi"][0]["value"] }}');
      formData.append('sks_tempuh', '{{ $data["sks_tempuh"][0]["value"] }}');
      formData.append('sks_lulus', '{{ $data["sks_lulus"][0]["value"] }}');
      formData.append('alasan', '{{ $data["alasan"][0]["value"] }}');
      formData.append('processInstanceId', '{{ $data["task"][0]["processInstanceId"] }}');
      
      $.ajax({
        url: "/memberikan-pengesahan-tanda-tangan",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
          $('#cmd').html('Kirim Pengesahan Tanda Tangan');
          $('#cmd').attr('disabled', false);
          window.location.href = "/";
        },
        error: function (data) {
          $('#cmd').html('Kirim Pengesahan Tanda Tangan');
          $('#cmd').attr('disabled', false);
          alert("Terjadi kesalahan");
        }
      });


    });
  });

</script>

@endsection