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
        $response1 = Http::post(env("API_URL")."/process-instance", [
            "processDefinitionId" => env("PROCESS_DEFINITION_ID"),
        ]);

        $response1 =  $response1->json();
        $data["instance"] =  $response1;

        $tempAct = [];
        $tempTask = [];
        foreach ($response1 as $rs) {
            $activity = Http::get(env("API_URL")."/process-instance/" . $rs['id'] . '/activity-instances');
            $activity = $activity->json();
            
            $taskInstance = Http::get(env("API_URL")."/task", [
                'processInstanceId' => $rs['id']
            ]);
            $taskInstance = $taskInstance->json();
            
            $tempAct[] = $activity;
            $tempTask[] = $taskInstance;
        }
        $data["activity"] = $tempAct;
        $data["task"] = $tempTask;

        $xml = Http::get(env("API_URL")."/process-definition/".env("PROCESS_DEFINITION_ID")."/xml");
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
        $response = Http::post(env("API_URL")."/identity/verify", [
            "username" => $request->username,
            "password" => $request->password
        ]);

        if($response["authenticated"]) {
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
        Http::post(env("API_URL")."/process-definition/" . env("PROCESS_DEFINITION_ID") . "/start",[
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
                "surat" => [
                    "value" => base64_encode($request->file('surat')->get()),
                    "type" => "File",
                    "valueInfo" => [
                        "filename" => $request->file("surat")->getClientOriginalName(),
                    ]
                ]
            ]
        ]);
        return back()->with("pesan", "Permohonan Cuti Berhasil Dikirim. Berhasil memulai instance");
    }

    public function deleteInstance(Request $request)
    {
        Http::delete(env("API_URL")."/process-instance/".$request->id, []);
        return back()->with("pesan", "Instance Berhasil Dihapus");
    }

    public function activity($idInstance)
    {
        $data = [];
        $instance = Http::get(env("API_URL")."/process-instance/".$idInstance . '/activity-instances');
        $instance = $instance->json();

        $data["instance"] = $instance;
        $variableInstance = Http::get(env("API_URL")."/variable-instance", [
            'processInstanceIdIn' => $instance['id']
        ]);
        $data["variable"] = $variableInstance->json();

        $taskInstance = Http::get(env("API_URL")."/task", [
            'processInstanceId' => $idInstance
        ]);
        $data["task"] = $taskInstance->json();

        return $data;
    }

    public function activityMempertimbangkanPermohonanCuti($idInstance)
    {
        $data = [];
        $variableInstance = Http::get(env("API_URL")."/variable-instance", [
            'processInstanceIdIn' => $idInstance
        ]);
        $data["variable"] = $variableInstance->json();
        $variableSurat = Http::get(env("API_URL")."/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableName' => 'surat'
        ]);
        $data["surat"] = $variableSurat->json();

        $taskInstance = Http::get(env("API_URL")."/task", [
            'processInstanceId' => $idInstance
        ]);
        $data["task"] = $taskInstance->json();

        // return $data;
        return view("mempertimbangkan-permohonan-cuti", compact("data"));
    }
    public function mempertimbangkanPermohonanCutiPost(Request $request)
    {
        Http::post(env("API_URL")."/task/" . $request->id ."/submit-form", [
            "variables" => [
                "disetujui" => [
                    "value" => $request->disetujui,
                    "type" => "String"
                ],
            ]
        ]);
        if($request->disetujui == "tidak") {
            $data = [
                "nama" => $request->nama,
                "nim" => $request->nim,
                "email" => $request->email,
                "prodi" => $request->prodi,
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
        $variableSurat = Http::get(env("API_URL")."/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            "variableName" => "surat",
        ]);
        $variableKoorpro = Http::get(env("API_URL")."/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            "variableName" => "tanda_tangan_koordinator_prodi",
        ]);
        $variableDoswal = Http::get(env("API_URL")."/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            "variableName" => "tanda_tangan_dosen_wali",
        ]);
        $data["surat"] = $variableSurat->json();
        $data["koorpro"] = $variableKoorpro->json();
        $data["doswal"] = $variableDoswal->json();

        $taskInstance = Http::get(env("API_URL")."/task", [
            'processInstanceId' => $idInstance,
        ]);
        $data["task"] = $taskInstance->json();

        // return $data;
        return view("memberikan-tanda-tangan", compact("data"));
    }
    public function memberikanTandaTanganPost(Request $request)
    {
        if($request->assignee == "Dosen Wali"){
            Http::post(env("API_URL")."/task/" . $request->id ."/submit-form", [
                "variables" => [
                    "tanda_tangan_dosen_wali" => [
                        "value" => base64_encode($request->file('tanda_tangan_dosen_wali')->get()),
                        "type" => "File",
                        "valueInfo" => [
                            "filename" => $request->file("tanda_tangan_dosen_wali")->getClientOriginalName(),
                        ]
                    ],
                ]
            ]);
        } else {
            Http::post(env("API_URL")."/task/" . $request->id ."/submit-form", [
                "variables" => [
                    "tanda_tangan_koordinator_prodi" => [
                        "value" => base64_encode($request->file('tanda_tangan_koordinator_prodi')->get()),
                        "type" => "File",
                        "valueInfo" => [
                            "filename" => $request->file("tanda_tangan_koordinator_prodi")->getClientOriginalName(),
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
        $variableInstance = Http::get(env("API_URL")."/variable-instance", [
            'processInstanceIdIn' => $idInstance
        ]);
        $data["variable"] = $variableInstance->json();
        $variableFile = Http::get(env("API_URL")."/variable-instance", [
            'processInstanceIdIn' => $idInstance,
            'variableNameLike' => 'tanda_tangan%',
        ]);
        $data["file"] = $variableFile->json();

        $taskInstance = Http::get(env("API_URL")."/task", [
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
        ];
        
        // base64 file
        
        Mail::send('mail.selesai', $data, function ($message) use ($request) {
            $message->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"));
            $message->to($request->email, $request->nama);
            $message->subject("Pengajuan Permohonan Cuti Selesai");
            $message->attachData($request->file('tanda_tangan_pengesahan')->get(), $request->file('tanda_tangan_pengesahan')->getClientOriginalName(), [
                'mime' => $request->file('tanda_tangan_pengesahan')->getMimeType(),
            ]);
        });

        Http::post(env("API_URL")."/task/" . $request->id ."/submit-form", [
            "variables" => [
                "tanda_tangan_pengesahan" => [
                    "value" => base64_encode($request->file('tanda_tangan_pengesahan')->get()),
                    "type" => "File",
                    "valueInfo" => [
                        "filename" => $request->file("tanda_tangan_pengesahan")->getClientOriginalName(),
                        ]
                    ],
                ]
            ]);


        return redirect("/")->with("pesan", "Pengesahan Tanda Tangan Berhasil Dikirim");
    }
}
