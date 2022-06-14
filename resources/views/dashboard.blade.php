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
                    <label for="">Tanda Tangan</label>
                    <div class="row">
                      <div class="col-md-6">
                        <canvas id="signature-pad" style="border: 1px solid black; width: 100%; height: 200px"></canvas>
                        <button class="btn btn-danger" id="clear" type="button">Clear</button>
                        <label for="signature-input-file" class="btn btn-primary mb-0">Choose From File</label>
                        <input type="file" id="signature-input-file" accept="image/*" style="display: none">
                      </div>
                      <div class="col-md-6">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAoMBgDTD2qgAAAAASUVORK5CYII=" id="img-sign" style="width: 100%; border: 3px dashed black; height:200px">
                      </div>
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
                <input type="text" name="signature" id="signature-file" required style="display: none">

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
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js" integrity="sha512-kw/nRM/BMR2XGArXnOoxKOO5VBHLdITAW00aG8qK4zBzcLVZ4nzg7/oYCaoiwc8U9zrnsO9UHqpyljJ8+iqYiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
       var canvas = document.getElementById("signature-pad");
       var clear = document.getElementById("clear");
       var signatureFile = document.getElementById("signature-file");
       var imgSign = document.getElementById("img-sign");
       var signatureInputFile = document.getElementById("signature-input-file");

       function resizeCanvas() {
           var ratio = Math.max(window.devicePixelRatio || 1, 1);
           canvas.width = canvas.offsetWidth * ratio;
           canvas.height = canvas.offsetHeight * ratio;
           canvas.getContext("2d").scale(ratio, ratio);
       }
       window.onresize = resizeCanvas;
       resizeCanvas();

      //  size the canvas to fit the signature pad

       const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            minWidth: 1,
            maxWidth: 3,
            penColor: "rgb(0,0,0)"
        });


        // get base64 value from signatureinputfile and set to signaturePad
        signatureInputFile.addEventListener("change", function() {
            var file = signatureInputFile.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                signaturePad.fromDataURL(e.target.result);
                imgSign.src = e.target.result;
                signatureFile.value = e.target.result;
            };
            reader.readAsDataURL(file);
        });

        clear.addEventListener("click", function(e) {
            signaturePad.clear();
            signatureFile.value = "";
            imgSign.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAoMBgDTD2qgAAAAASUVORK5CYII=";
            signatureInputFile.value = "";
        });

        // when mouse is released, log the signature using addEventListener
        signaturePad.addEventListener("endStroke", () => {
            const data = signaturePad.toDataURL("image/jpeg");
            signatureFile.value = data;
            imgSign.src = data;
            // change value signatureFile to data
          }, { once: false });
        
</script>
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