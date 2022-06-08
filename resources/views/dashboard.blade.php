@extends("layouts.base")
@section("content")

<div class="container-fluid">

  <div class="row">
    <div class="col-md-12">
      @if (session('pesan'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('pesan') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Diagram Process</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div id="canvas" style="height:575px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Start Instance</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <!-- BPMN diagram container -->
              
              <form action="/start-instance" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nim">NIM</label>
                      <input type="number" id="nim" class="form-control" name="nim" placeholder="NIM" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" id="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="prodi">Program Studi</label>
                      <input type="text" id="prodi" class="form-control" name="prodi" placeholder="Program Studi" required>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="surat">Surat Cuti</label>
                      <input type="file" id="surat" class="form-control" name="surat" accept=".pdf" required>
                    </div>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">Start Instance</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <br>
  
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h6 class="m-0 font-weight-bold text-primary">Table Instance</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Id Instance</th>
                  <th>Assignee</th>
                  <th>Nama Aktivitas</th>
                  <th>Tipe Aktivitas</th>
                  <th>Ended</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @for ($i=0; $i < count($data["instance"]); $i++)
                  <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                      <a href="/activity/{{ $data["instance"][$i]['id'] }}/{{ str_replace(' ','-',strtolower($data["task"][$i][0]['name'])) }}">{{ $data["instance"][$i]['id'] }}</a>
                    </td>
                    <td>
                      @for ($j=0; $j < count($data["task"][$i]); $j++)
                        {{ $data["task"][$i][$j]['assignee'] }}
                        @if ($j < count($data["task"][$i])-1)
                          ,
                        @endif
                      @endfor
                    </td>
                    <td>
                      @for ($j=0; $j < count($data["task"][$i]); $j++)
                        {{ $data["task"][$i][$j]['name'] }}
                        @if ($j < count($data["task"][$i])-1)
                          ,
                        @endif
                      @endfor
                    </td>
                    {{-- <td>{{ $data["activity"][$i]['childActivityInstances'][0]["name"] }}</td> --}}
                    <td>{{ $data["activity"][$i]['childActivityInstances'][0]["activityType"] }}</td>
                    <td>@if($data["instance"][$i]["ended"]) Selesai @else Belum Selesai @endif</td>
                    <td>
                      <form action="/delete-instance" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data["instance"][$i]['id'] }}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                      </form>
                    </td>
                  </tr>
                @endfor
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <br>
</div>



<!-- replace CDN url with local bpmn-js path -->
@endsection
@section('script')
<script src="https://unpkg.com/bpmn-js/dist/bpmn-viewer.development.js"></script>
<script>
  function fetchDiagram() {
    return fetch("{{ env('API_URL').'/process-definition/'.env('PROCESS_DEFINITION_ID').'/xml' }}")
      .then(response => response.json())
      .then(data => {
        return data.bpmn20Xml
      });

  }

async function run() {
  const diagram = await fetchDiagram();
  const viewer = new BpmnJS({ container: '#canvas' });


  try {
    await viewer.importXML(diagram);
    viewer.get('canvas').zoom('fit-viewport');
    // ...
  } catch (err) {
    // ...
  }
}

run();
</script>
@endsection