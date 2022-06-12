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
                        <img src="{{ env("API_URL") }}/variable-instance/{{ $data["ttd_dosen_wali"][0]["id"] }}/data" style="max-width: 100px; max-height:75px">
                      @else
                      <br><br><br>
                      @endif
                      <p>{{ $data["nama_doswal"][0]["value"] }}<br>NIP/NIPH. {{ $data["nip_doswal"][0]["value"] }}</p>
                  </div>
                  <div class="col-md-4">
                    <p><br> Mahasiswa,</p>
                      <img src="{{ env("API_URL") }}/variable-instance/{{ $data["ttd_mahasiswa"][0]["id"] }}/data" style="max-width: 100px; max-height:75px">
                    <p>{{ $data["nama"][0]["value"] }} <br>NIM. {{ $data["nim"][0]["value"] }}</p>
                  </div>
                  <div class="m-auto text-center">
                    <p>Mengetahui, <br>Koorprodi {{ $data["nama_koorprodi"][0]["value"] }}</p>
                    @if(count($data["ttd_koordinator_prodi"]) > 0)
                        <img src="{{ env("API_URL") }}/variable-instance/{{ $data["ttd_koordinator_prodi"][0]["id"] }}/data" style="max-width: 100px; max-height:75px">
                    @else
                    <br><br><br>
                    @endif
                    <p>{{ $data["nama_koorprodi"][0]["value"] }} <br>NIP/NIPH. {{ $data["nip_koorprodi"][0]["value"] }}</p>
                  </div>
                </div>
              </section>

              <hr>

              <div class="row">
              @foreach ($data["task"] as $dt)
              <div class="col-md-6">
                <form action="/memberikan-tanda-tangan" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="id" value="{{ $dt["id"] }}">
                  <input type="hidden" name="assignee" value="{{ $dt["assignee"] }}">
                  <div class="form-group">
                    <label for="tanda_tangan">Tanda Tangan {{ $dt["assignee"] }}</label>
                    <input type="file" id="ttd_{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" class="form-control" name="ttd_{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" accept="image/*" required>
                  </div>
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

@endsection
