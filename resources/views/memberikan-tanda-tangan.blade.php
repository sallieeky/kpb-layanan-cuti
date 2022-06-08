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
              <div class="form-group">
                <label for="surat">Surat Cuti</label><br>
                @if(count($data["koorpro"]) > 0)
                <a href="{{ env("API_URL") }}/variable-instance/{{ $data["koorpro"][0]["id"] }}/data" target="_blank" class="btn btn-primary w-100">
                  <i class="fas fa-file-pdf"></i>
                  Surat Cuti Mahasiswa
                </a>
                @elseif (count($data["doswal"]) > 0)
                <a href="{{ env("API_URL") }}/variable-instance/{{ $data["doswal"][0]["id"] }}/data" target="_blank" class="btn btn-primary w-100">
                  <i class="fas fa-file-pdf"></i>
                  Surat Cuti Mahasiswa
                </a>
                @else
                <a href="{{ env("API_URL") }}/variable-instance/{{ $data["surat"][0]["id"] }}/data" target="_blank" class="btn btn-primary w-100">
                  <i class="fas fa-file-pdf"></i>
                  Surat Cuti Mahasiswa
                </a>
                @endif
              </div>
              <br>

              @foreach ($data["task"] as $dt)
              <form action="/memberikan-tanda-tangan" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $dt["id"] }}">
                <input type="hidden" name="assignee" value="{{ $dt["assignee"] }}">
                <h5>Tanda Tangan {{ $dt["assignee"] }}</h5>
                <div class="form-group">
                  <label for="tanda_tangan">File Hasil Tanda Tangan {{ $dt["assignee"] }}</label>
                  <input type="file" id="tanda_tangan_{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" class="form-control" name="tanda_tangan_{{ str_replace(" ", "_", strtolower($dt["assignee"])) }}" accept=".pdf" required>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
              </form>
              <hr>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br>
  
</div>

@endsection