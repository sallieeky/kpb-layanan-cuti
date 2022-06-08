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
              <h5>Data Mahasiswa</h5>
              <div class="form-group">
                <label for="surat">Surat Cuti</label><br>
                <a href="{{ env("API_URL") }}/variable-instance/{{ $data["file"][1]["id"] }}/data" target="_blank" class="btn btn-primary w-100">
                  <i class="fas fa-file-pdf"></i>
                  Surat Cuti Mahasiswa
                </a>
              </div>
              <br>

              <form action="/memberikan-pengesahan-tanda-tangan" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $data["task"][0]["id"] }}">
                <input type="hidden" id="nama" name="nama" value="{{ $data["variable"][2]["value"] }}">
                <input type="hidden" id="nim" name="nim" value="{{ $data["variable"][1]["value"] }}">
                <input type="hidden" id="email" name="email" value="{{ $data["variable"][4]["value"] }}">
                <input type="hidden" id="prodi" name="prodi" value="{{ $data["variable"][3]["value"] }}">
                <input type="hidden" id="processInstanceId" name="processInstanceId" value="{{ $data["task"][0]["processInstanceId"] }}">
                <h5>Tanda Tangan Pengesahan {{ $data["task"][0]["assignee"] }}</h5>
                <div class="form-group">
                  <label for="tanda_tangan_pengesahan">File Tanda Tangan Pengesahan {{ $data["task"][0]["assignee"] }}</label>
                  <input type="file" id="tanda_tangan_pengesahan" class="form-control" name="tanda_tangan_pengesahan" accept=".pdf">
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pengesahan</button>
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