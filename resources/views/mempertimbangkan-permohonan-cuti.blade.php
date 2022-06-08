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
              <h5>Data Mahasiswa</h5>
              <form action="/mempertimbangkan-permohonan-cuti" method="post">
                @csrf
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" class="form-control" name="nama" readonly value="{{ $data["variable"][2]["value"] }}">
              </div>
              <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" class="form-control" name="nim" readonly value="{{ $data["variable"][1]["value"] }}">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" name="email" readonly value="{{ $data["variable"][4]["value"] }}">
              </div>
              <div class="form-group">
                <label for="prodi">Program Studi</label>
                <input type="text" id="prodi" class="form-control" name="prodi" readonly value="{{ $data["variable"][3]["value"] }}">
              </div>
              <div class="form-group">
                <label for="surat">Surat Cuti</label><br>
                {{-- using a and icon --}}
                <a href="{{ env("API_URL") }}/variable-instance/{{ $data["surat"][0]["id"] }}/data" target="_blank" class="btn btn-primary">
                  <i class="fas fa-file-pdf"></i>
                  Surat Cuti Mahasiswa
                </a>
              </div>

              <h5>Pertimbangan</h5>
                <input type="hidden" name="id" value="{{ $data["task"][0]["id"] }}">
                <div class="form-group">
                  <label for="disetujui">Disetujui</label>
                  <select class="form-control" id="disetujui" name="disetujui">
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