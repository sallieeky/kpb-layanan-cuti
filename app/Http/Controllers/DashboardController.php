<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function home()
    {
        $data = [];
        $response1 = Http::post(env("API_URL") . "/process-instance", [
            "processDefinitionId" => env("PROCESS_DEFINITION_ID"),
        ]);
        $response1Finish = Http::post(env("API_URL") . "/history/process-instance", [
            "processDefinitionId" => env("PROCESS_DEFINITION_ID"),
        ]);
        $response1Finish = $response1Finish->json();

        // return $response1->json();
        // return $response1Finish;

        $response1 =  $response1->json();
        $data["instance"] =  $response1;

        $tempAct = [];
        $tempTask = [];
        foreach ($response1 as $rs) {
            $activity = Http::get(env("API_URL") . "/process-instance/" . $rs['id'] . '/activity-instances');
            $activity = $activity->json();

            $taskInstance = Http::get(env("API_URL") . "/task", [
                'processInstanceId' => $rs['id']
            ]);
            $taskInstance = $taskInstance->json();

            $tempAct[] = $activity;
            $tempTask[] = $taskInstance;
        }

        $data["activity"] = $tempAct;
        $data["task"] = $tempTask;

        $xml = Http::get(env("API_URL") . "/process-definition/" . env("PROCESS_DEFINITION_ID") . "/xml");
        $xml = $xml->json();
        // return $xml;

        // return $data;
        return view("dashboard", compact("data", "xml"));
    }

    public function login()
    {
        return view("login");
    }
    public function loginPost(Request $request)
    {
        $response = Http::post(env("API_URL") . "/identity/verify", [
            "username" => $request->username,
            "password" => $request->password
        ]);

        if ($response["authenticated"]) {
            $request->session()->put("user", $request->all());
            return redirect("/");
        } else {
            return redirect()->back()->with("pesan", "Username or Password is incorrect");
        }
    }
    public function logout()
    {
        session()->forget("user");
        return redirect("/login");
    }

    public function startInstance(Request $request)
    {
        Http::post(env("API_URL") . "/process-definition/" . env("PROCESS_DEFINITION_ID") . "/start", [
            "variables" => [
                "nama" => [
                    "value" => $request->nama,
                    "type" => "String"
                ],
                "nim" => [
                    "value" => $request->nim,
                    "type" => "String"
                ],
                "email" => [
                    "value" => $request->email,
                    "type" => "String"
                ],
                "prodi" => [
                    "value" => $request->prodi,
                    "type" => "String"
                ],
                'sks_tempuh' => [
                    'value' => $request->sks_tempuh,
                    'type' => 'String'
                ],
                'sks_lulus' => [
                    'value' => $request->sks_lulus,
                    'type' => 'String'
                ],
                'alasan' => [
                    'value' => $request->alasan,
                    'type' => 'String'
                ],
                'nama_doswal' => [
                    'value' => $request->nama_doswal,
                    'type' => 'String'
                ],
                'nip_doswal' => [
                    'value' => $request->nip_doswal,
                    'type' => 'String'
                ],
                'nama_koorprodi' => [
                    'value' => $request->nama_koorprodi,
                    'type' => 'String'
                ],
                'nip_koorprodi' => [
                    'value' => $request->nip_koorprodi,
                    'type' => 'String'
                ],
                'ttd_mahasiswa' => [
                    "value" => base64_encode($request->file('ttd_mahasiswa')->get()),
                    "type" => "File",
                    "valueInfo" => [
                        "filename" => $request->file("ttd_mahasiswa")->getClientOriginalName(),
                    ]
                ],
            ]
        ]);
        return back()->with("pesan", "Permohonan Cuti Berhasil Dikirim. Berhasil memulai instance");
    }

    public function deleteInstance(Request $request)
    {
        Http::delete(env("API_URL") . "/process-instance/" . $request->id, []);
        return back()->with("pesan", "Instance Berhasil Dihapus");
    }

    public function activity($idInstance)
    {
        $data = [];
        $instance = Http::get(env("API_URL") . "/process-instance/" . $idInstance . '/activity-instances');
        $instance = $instance->json();

        $data["instance"] = $instance;
        $variableInstance = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $instance['id']
        ]);
        $data["variable"] = $variableInstance->json();

        $taskInstance = Http::get(env("API_URL") . "/task", [
            'processInstanceId' => $idInstance
        ]);
        $data["task"] = $taskInstance->json();

        return $data;
    }

    public function activityMempertimbangkanPermohonanCuti($idInstance)
    {
        $data = [];
        $nama = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nama'
        ]);
        $nim = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nim'
        ]);
        $email = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'email'
        ]);
        $prodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'prodi'
        ]);
        $sks_tempuh = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'sks_tempuh'
        ]);
        $sks_lulus = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'sks_lulus'
        ]);
        $alasan = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'alasan'
        ]);
        $nama_doswal = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nama_doswal'
        ]);
        $nip_doswal = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nip_doswal'
        ]);
        $nama_koorprodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nama_koorprodi'
        ]);
        $nip_koorprodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nip_koorprodi'
        ]);
        $ttd_mahasiswa = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'ttd_mahasiswa'
        ]);
        $data["nama"] = $nama->json();
        $data["nim"] = $nim->json();
        $data["email"] = $email->json();
        $data["prodi"] = $prodi->json();
        $data["sks_tempuh"] = $sks_tempuh->json();
        $data["sks_lulus"] = $sks_lulus->json();
        $data["alasan"] = $alasan->json();
        $data["nama_doswal"] = $nama_doswal->json();
        $data["nip_doswal"] = $nip_doswal->json();
        $data["nama_koorprodi"] = $nama_koorprodi->json();
        $data["nip_koorprodi"] = $nip_koorprodi->json();
        $data["ttd_mahasiswa"] = $ttd_mahasiswa->json();

        $taskInstance = Http::get(env("API_URL") . "/task", [
            'processInstanceId' => $idInstance
        ]);
        $data["task"] = $taskInstance->json();

        return view("mempertimbangkan-permohonan-cuti", compact("data"));
    }
    public function mempertimbangkanPermohonanCutiPost(Request $request)
    {
        Http::post(env("API_URL") . "/task/" . $request->id . "/submit-form", [
            "variables" => [
                "disetujui" => [
                    "value" => $request->disetujui,
                    "type" => "String"
                ],
            ]
        ]);
        if ($request->disetujui == "tidak") {
            $data = [
                "nama" => $request->nama,
                "nim" => $request->nim,
                "email" => $request->email,
                "prodi" => $request->prodi,
                "sks_tempuh" => $request->sks_tempuh,
                "sks_lulus" => $request->sks_lulus,
                "alasan" => $request->alasan,
            ];
            Mail::send('mail.tidak_disetujui', $data, function ($message) use ($request) {
                $message->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"));
                $message->to($request->email, $request->nama);
                $message->subject("Penolakan Permohonan Cuti");
            });
        }
        return redirect("/")->with("pesan", "Permohonan Cuti Berhasil Direspon");
    }



    public function activityMemberikanTandaTangan($idInstance)
    {
        $data = [];
        $nama = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nama'
        ]);
        $nim = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nim'
        ]);
        $email = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'email'
        ]);
        $prodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'prodi'
        ]);
        $sks_tempuh = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'sks_tempuh'
        ]);
        $sks_lulus = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'sks_lulus'
        ]);
        $alasan = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'alasan'
        ]);
        $nama_doswal = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nama_doswal'
        ]);
        $nip_doswal = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nip_doswal'
        ]);
        $nama_koorprodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nama_koorprodi'
        ]);
        $nip_koorprodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nip_koorprodi'
        ]);
        $ttd_mahasiswa = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'ttd_mahasiswa'
        ]);
        // ttd_doswal, ttd_koorprodi
        $ttd_doswal = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'ttd_dosen_wali'
        ]);
        $ttd_koorprodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'ttd_koordinator_prodi'
        ]);


        $data["nama"] = $nama->json();
        $data["nim"] = $nim->json();
        $data["email"] = $email->json();
        $data["prodi"] = $prodi->json();
        $data["sks_tempuh"] = $sks_tempuh->json();
        $data["sks_lulus"] = $sks_lulus->json();
        $data["alasan"] = $alasan->json();
        $data["nama_doswal"] = $nama_doswal->json();
        $data["nip_doswal"] = $nip_doswal->json();
        $data["nama_koorprodi"] = $nama_koorprodi->json();
        $data["nip_koorprodi"] = $nip_koorprodi->json();
        $data["ttd_mahasiswa"] = $ttd_mahasiswa->json();
        $data["ttd_dosen_wali"] = $ttd_doswal->json();
        $data["ttd_koordinator_prodi"] = $ttd_koorprodi->json();

        $taskInstance = Http::get(env("API_URL") . "/task", [
            'processInstanceId' => $idInstance,
        ]);
        $data["task"] = $taskInstance->json();

        // return $data;
        return view("memberikan-tanda-tangan", compact("data"));
    }
    public function memberikanTandaTanganPost(Request $request)
    {
        // return $request;
        if ($request->assignee == "Dosen Wali") {
            Http::post(env("API_URL") . "/task/" . $request->id . "/submit-form", [
                "variables" => [
                    "ttd_dosen_wali" => [
                        "value" => base64_encode($request->file('ttd_dosen_wali')->get()),
                        "type" => "File",
                        "valueInfo" => [
                            "filename" => $request->file("ttd_dosen_wali")->getClientOriginalName(),
                        ]
                    ],
                ]
            ]);
        } else {
            Http::post(env("API_URL") . "/task/" . $request->id . "/submit-form", [
                "variables" => [
                    "ttd_koordinator_prodi" => [
                        "value" => base64_encode($request->file('ttd_koordinator_prodi')->get()),
                        "type" => "File",
                        "valueInfo" => [
                            "filename" => $request->file("ttd_koordinator_prodi")->getClientOriginalName(),
                        ]
                    ],
                ]
            ]);
        }
        return redirect("/")->with("pesan", "Tanda Tangan " . $request->assignee . " Berhasil Dikirim");
    }

    public function activityMemberikanPengesahanTandaTangan($idInstance)
    {
        $data = [];
        // $variableInstance = Http::get(env("API_URL") . "/variable-instance", [
        //     'processInstanceIdIn' => $idInstance
        // ]);
        // $data["variable"] = $variableInstance->json();
        // $variableFile = Http::get(env("API_URL") . "/variable-instance", [
        //     'processInstanceIdIn' => $idInstance,
        //     'variableNameLike' => 'tanda_tangan%',
        // ]);
        // $data["file"] = $variableFile->json();

        $nama = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nama'
        ]);
        $nim = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nim'
        ]);
        $email = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'email'
        ]);
        $prodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'prodi'
        ]);
        $sks_tempuh = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'sks_tempuh'
        ]);
        $sks_lulus = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'sks_lulus'
        ]);
        $alasan = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'alasan'
        ]);
        $nama_doswal = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nama_doswal'
        ]);
        $nip_doswal = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nip_doswal'
        ]);
        $nama_koorprodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nama_koorprodi'
        ]);
        $nip_koorprodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'nip_koorprodi'
        ]);
        $ttd_mahasiswa = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'ttd_mahasiswa'
        ]);
        // ttd_doswal, ttd_koorprodi
        $ttd_doswal = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'ttd_dosen_wali'
        ]);
        $ttd_koorprodi = Http::get(env("API_URL") . "/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'ttd_koordinator_prodi'
        ]);


        $data["nama"] = $nama->json();
        $data["nim"] = $nim->json();
        $data["email"] = $email->json();
        $data["prodi"] = $prodi->json();
        $data["sks_tempuh"] = $sks_tempuh->json();
        $data["sks_lulus"] = $sks_lulus->json();
        $data["alasan"] = $alasan->json();
        $data["nama_doswal"] = $nama_doswal->json();
        $data["nip_doswal"] = $nip_doswal->json();
        $data["nama_koorprodi"] = $nama_koorprodi->json();
        $data["nip_koorprodi"] = $nip_koorprodi->json();
        $data["ttd_mahasiswa"] = $ttd_mahasiswa->json();
        $data["ttd_dosen_wali"] = $ttd_doswal->json();
        $data["ttd_koordinator_prodi"] = $ttd_koorprodi->json();

        // download ttd_mahasiswa dan ttd_dosen_wali dan ttd_koordinator_prodi dari API dan simpan di folder public/img
        $ttd_mahasiswa = Http::get(env("API_URL") . "/variable-instance/" . $data["ttd_mahasiswa"][0]["id"] . "/data");
        $ttd_doswal = Http::get(env("API_URL") . "/variable-instance/" . $data["ttd_dosen_wali"][0]["id"] . "/data");
        $ttd_koorprodi = Http::get(env("API_URL") . "/variable-instance/" . $data["ttd_koordinator_prodi"][0]["id"] . "/data");
        $ttd_mahasiswa = base64_encode($ttd_mahasiswa);
        $ttd_doswal = base64_encode($ttd_doswal);
        $ttd_koorprodi = base64_encode($ttd_koorprodi);

        $data["ttd_mahasiswa"] = $ttd_mahasiswa;
        $data["ttd_file_dosen_wali"] = $ttd_doswal;
        $data["ttd_file_koordinator_prodi"] = $ttd_koorprodi;

        $taskInstance = Http::get(env("API_URL") . "/task", [
            'processInstanceId' => $idInstance
        ]);
        $data["task"] = $taskInstance->json();
        // return $data;
        return view("memberikan-pengesahan-tanda-tangan", compact("data"));
    }
    public function memberikanPengesahanTandaTanganPost(Request $request)
    {
        $data = [
            "nama" => $request->nama,
            "nim" => $request->nim,
            "email" => $request->email,
            "prodi" => $request->prodi,
            "sks_tempuh" => $request->sks_tempuh,
            "sks_lulus" => $request->sks_lulus,
            "alasan" => $request->alasan,
        ];

        Mail::send('mail.selesai', $data, function ($message) use ($request) {
            $message->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"));
            $message->to($request->email, $request->nama);
            $message->subject("Pengajuan Permohonan Cuti Selesai");
            $message->attachData($request->file('file')->get(), $request->file('file')->getClientOriginalName(), [
                'mime' => $request->file('file')->getMimeType(),
            ]);
        });

        Http::post(env("API_URL") . "/task/" . $request->id . "/submit-form", [
            "variables" => [
                "ttd_pengesahan" => [
                    "value" => base64_encode($request->file('file')->get()),
                    "type" => "File",
                    "valueInfo" => [
                        "filename" => $request->file("file")->getClientOriginalName(),
                    ]
                ],
            ]
        ]);


        return redirect("/")->with("pesan", "Pengesahan Tanda Tangan Berhasil Dikirim");
    }
}
