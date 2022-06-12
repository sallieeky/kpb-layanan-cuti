@extends("layouts.base")
@section("css")

<style type="text/css">
	.djs-container .highlight .djs-visual>:nth-child(1) {
	   fill: #bce2f5 !important;
	}

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>

@endsection
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
            <div class="col-md-12" id="container-canvas">
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
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nim">NIM</label>
                      <input type="number" id="nim" class="form-control" name="nim" placeholder="NIM" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" id="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="prodi">Program Studi</label>
                      <input type="text" id="prodi" class="form-control" name="prodi" placeholder="Program Studi" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="sks_tempuh">SKS Tempuh</label>
                      <input type="number" id="sks_tempuh" class="form-control" name="sks_tempuh" placeholder="SKS Tempuh" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="sks_lulus">SKS Lulus</label>
                      <input type="number" id="sks_lulus" class="form-control" name="sks_lulus" placeholder="SKS Lulus" required>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="alasan">Alasan</label>
                      <textarea class="form-control" id="alasan" name="alasan" rows="3" placeholder="Alasan" required></textarea>
                    </div>
                  </div>
                  {{-- tanda_tangan --}}
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="ttd_mahasiswa">Tanda Tangan</label>
                      <input type="file" id="ttd_mahasiswa" class="form-control" accept="image/*" name="ttd_mahasiswa" placeholder="Tanda Tangan" required>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nama_doswal">Nama Dosen Wali</label>
                      <input type="text" id="nama_doswal" class="form-control" name="nama_doswal" placeholder="Nama Dosen Wali" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nip_doswal">NIP/NIPH Dosen Wali</label>
                      <input type="number" id="nip_doswal" class="form-control" name="nip_doswal" placeholder="NIP/NIPH Dosen Wali" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nama_koorprodi">Nama Koordinator Prodi</label>
                      <input type="text" id="nama_koorprodi" class="form-control" name="nama_koorprodi" placeholder="Nama Koordinator Prodi" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nip_koorprodi">NIP/NIPH Koordinator Prodi</label>
                      <input type="number" id="nip_koorprodi" class="form-control" name="nip_koorprodi" placeholder="NIP/NIPH Koordinator Prodi" required>
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
@if(count($data["task"]) == 0)
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

@else
<script>
  $(document).ready(function() {

    var container = $('#container-canvas');
    const restAccess = "{{ env('API_URL') }}";
    const taskId = "{{ $data['task'][0][0]['id'] }}";
    const viewer = new BpmnJS({ container: '#canvas' });


    $.get(restAccess + '/task/' + taskId, function(marker) {
      $.get(restAccess + '/process-definition/' + marker.processDefinitionId + '/xml', function(data) {

        // show it in bpmn.io
        viewer.importXML(data.bpmn20Xml, function(err) {
          if (err) {
            console.log('error rendering', err);
          } else {
            var canvas = viewer.get('canvas');
            // zoom to fit full viewport
            canvas.zoom('fit-viewport');
            container.removeClass('with-error')
                  .addClass('with-diagram');
            // add marker
            @foreach ($data["task"] as $dtt)
              @foreach ($dtt as $dt)
                canvas.addMarker("{{ $dt['taskDefinitionKey'] }}", 'highlight');
              @endforeach
            @endforeach
          }
        });

      });
    });

  });
</script>
@endif

@endsection