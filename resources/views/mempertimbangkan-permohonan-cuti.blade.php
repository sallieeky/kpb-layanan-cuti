@extends("layouts.base")
@section("content")

<div class="container-fluid">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Formulir Pertimbangan Permohonan Cuti</h6>
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
                    <br>
                    <br>
                    <br>
                    <p>{{ $data["nama_doswal"][0]["value"] }}<br>NIP/NIPH. {{ $data["nip_doswal"][0]["value"] }}</p>
                  </div>
                  <div class="col-md-4">
                    <p><br> Mahasiswa,</p>
                    <img src="{{ env("API_URL") }}/variable-instance/{{ $data["ttd_mahasiswa"][0]["id"] }}/data" style="width: 200px">
                    <p>{{ $data["nama"][0]["value"] }} <br>NIM. {{ $data["nim"][0]["value"] }}</p>
                  </div>
                  <div class="m-auto text-center">
                    <p>Mengetahui, <br>Koorprodi {{ $data["nama_koorprodi"][0]["value"] }}</p>
                    <br>
                    <br>
                    <br>
                    <p>{{ $data["nama_koorprodi"][0]["value"] }} <br>NIP/NIPH. {{ $data["nip_koorprodi"][0]["value"] }}</p>
                  </div>
                </div>
              </section>

            </div>

            
            <div class="col-md-12">
              
              <hr>
              
              <form action="/mempertimbangkan-permohonan-cuti" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $data["task"][0]["id"] }}">
                {{-- hidden nama, nim, email, prodi --}}
                <input type="hidden" name="nama" value="{{ $data["nama"][0]["value"] }}">
                <input type="hidden" name="nim" value="{{ $data["nim"][0]["value"] }}">
                <input type="hidden" name="email" value="{{ $data["email"][0]["value"] }}">
                <input type="hidden" name="prodi" value="{{ $data["prodi"][0]["value"] }}">
                <input type="hidden" name="sks_tempuh" value="{{ $data["sks_tempuh"][0]["value"] }}">
                <input type="hidden" name="sks_lulus" value="{{ $data["sks_lulus"][0]["value"] }}">
                <input type="hidden" name="alasan" value="{{ $data["alasan"][0]["value"] }}">
                <div class="form-group">
                  <label for="disetujui">Disetujui</label>
                  <select class="form-control" id="disetujui" name="disetujui" required>
                    <option value="iya">Ya</option>
                    <option value="tidak">Tidak</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Respon</button>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <br>
  
</div>

@endsection