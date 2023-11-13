@extends('layout')
@section('content')

<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/dashboard/mahasiswa/{{$user->NIM}}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                Akademik
            </div>
            <ul class="nav-pill">
                <li><a href="#section1">IRS</a></li>
                <li><a href="#section2">KHS</a></li>
                <li><a href="#section3">PKL</a></li>
                <li><a href="#section4">Skripsi</a></li>
            </ul>
            <hr />
            <div class="section" id="section1">
                <a href="/dashboard/mahasiswa/{{$user->NIM}}/academic/addIRS" type="button" class="btn btn-light btn-round px-5 d-flex justify-content-center align-items-center">
                    <i class="fas fa-folder-plus"></i> &nbsp; Tambah IRS
                </a>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Semester</th>
                                <th scope="col">SKS Diambil</th>
                                <th scope="col">Scan IRS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($user->mahasiswa->irs != NULL)
                            @foreach($irs as $ir)
                            <tr>
                                @if($ir->NIM == $user->NIM)
                                <th scope="row">{{$ir->smst_aktif}}</th>
                                <td>{{$ir->jumlah_sks}}</td>
                                <td><!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">Lihat File</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas IRS</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($user->mahasiswa->irs->berkas_irs, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_irs/' . $user->mahasiswa->irs->berkas_irs) }}" type="application/pdf" width="100%" height="100%">
                                                        Your browser does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_irs/' . $user->mahasiswa->irs->berkas_irs) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p>Unsupported file format.</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <th scope="row"></th>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 2 content -->
            <div class="section" id="section2">
                <a href="/dashboard/mahasiswa/{{$user->NIM}}/academic/addKHS" type="button" class="btn btn-light btn-round px-5 d-flex justify-content-center align-items-center">
                    <i class="fas fa-folder-plus"></i> &nbsp; Tambah KHS
                </a>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Semester</th>
                                <th scope="col">SKS Semester</th>
                                <th scope="col">SKS Kumulatif</th>
                                <th scope="col">IP Semester</th>
                                <th scope="col">IP Kumulatif</th>
                                <th scope="col">Status</th>
                                <th scope="col">Scan KHS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($user->mahasiswa->khs != NULL)
                            @foreach($khs as $k)
                            <tr>
                                @if($k->NIM == $user->NIM)
                                <th scope="row">{{$k->smt_aktif}}</th>
                                <td>{{$k->SKS_semester}}</td>
                                <td>{{$k->SKS_kumulatif}}</td>
                                <td>{{$k->IP_smt}}</td>
                                <td>{{$k->IP_Kumulatif}}</td>
                                @if($k->IP_smt != NULL)
                                <td>Sudah divalidasi</td>
                                @else
                                <td>Belum divalidasi</td>
                                @endif
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong2">Lihat File</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong2">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas KHS</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($user->mahasiswa->khs->berkas_khs, PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_khs/' . $user->mahasiswa->khs->berkas_khs) }}" type="application/pdf" width="100%" height="100%">
                                                        Your browser does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_khs/' . $user->mahasiswa->khs->berkas_khs) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p>Unsupported file format.</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <th scope="row"></th>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 3 content -->
            <div class="section" id="section3">
                <!-- Content for section 3 -->
                <button type="button" class="btn btn-light btn-round px-5 d-flex justify-content-center align-items-center mx-auto" data-toggle="modal" data-target="#basicModal">Entry PKL</button>
                <!-- Modal -->
                @php
                $sks_total = 0;
                foreach($khs as $k){
                if($k->NIM == $user->NIM){
                $sks_total += $k->SKS_semester;
                }
                }
                @endphp
                <div class="modal fade" id="basicModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" style="color:black;">Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            @if($sks_total >= 100 && $user->mahasiswa->pkl->status_pkl == 'belum ambil')
                            <div class="modal-body" style="color: black;">Apakah Anda ingin mengambil PKL.</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="/dashboard/mahasiswa/{{$user->NIM}}/academic/addPKL" type="button" class="btn btn-primary">Konfirmasi</a>
                            </div>
                            @else
                            <div class="modal-body">
                                @if($user->mahasiswa->pkl->status_pkl == 'lulus')
                                <h7 style="color: black;">Anda sudah mengambil PKL</h7>
                                @elseif($user->mahasiswa->pkl->status_pkl == 'sedang ambil')
                                <h7 style="color: black;">Anda sedang PKL</h7>
                                @else
                                <h7 style="color: black;">Anda tidak dapat mengambil PKL. Minimal 100 SKS</h7>
                                <br>
                                <h7 style="color: black;">Total SKS Anda : {{$sks_total}}</h7>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Status</th>
                                <th class="text-center">Berita Acara PKL</th>
                                <th class="text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{$user->mahasiswa->pkl->status_pkl}}</td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong3">Lihat File</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong3">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas PKL</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($user->mahasiswa->pkl->berkas, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_pkl/' . $user->mahasiswa->pkl->berkas) }}" type="application/pdf" width="100%" height="100%">
                                                        Your browser does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_pkl/' . $user->mahasiswa->pkl->berkas) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p>Unsupported file format.</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{$user->mahasiswa->pkl->nilai_pkl}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 4 content -->
            <div class="section" id="section4">
                <!-- Content for section 4 -->
                <button type="button" class="btn btn-light btn-round px-5 d-flex justify-content-center align-items-center mx-auto" data-toggle="modal" data-target="#basicModal2">Entry Skripsi</button>
                <!-- Modal -->
                @php
                $sks_total = 0;
                foreach($khs as $k){
                if($k->NIM == $user->NIM){
                $sks_total += $k->SKS_semester;
                }
                }
                @endphp
                <div class="modal fade" id="basicModal2">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" style="color:black;">Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            @if($sks_total >= 138 && $user->mahasiswa->skripsi->status_skripsi == 'belum ambil')
                            <div class="modal-body" style="color: black;">Apakah Anda ingin mengambil skripsi?</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="/dashboard/mahasiswa/{{$user->NIM}}/academic/addSkripsi" type="button" class="btn btn-primary">Konfirmasi</a>
                            </div>
                            @else
                            <div class="modal-body">
                                @if($user->mahasiswa->skripsi->status_skripsi == 'sudah ambil')
                                <h7 style="color: black;">Anda sudah mengambil skripsi</h7>
                                @elseif($user->mahasiswa->skripsi->status_skripsi == 'sedang ambil')
                                <h7 style="color: black;">Anda sedang skripsi</h7>
                                @else
                                <h7 style="color: black;">Anda tidak dapat mengambil PKL. Minimal 100 SKS</h7>
                                <br>
                                <h7 style="color: black;">Total SKS Anda : {{$sks_total}}</h7>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Status</th>
                                <th class="text-center">Berita Acara Skripsi</th>
                                <th class="text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{$user->mahasiswa->skripsi->status_skripsi}}</td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong4">Lihat File</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong4">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas Skripsi</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($user->mahasiswa->skripsi->berkas_skripsi, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_skripsi/' . $user->mahasiswa->skripsi->berkas_skripsi) }}" type="application/pdf" width="100%" height="100%">
                                                        Your browser does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_skripsi/' . $user->mahasiswa->skripsi->berkas_skripsi) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p>Unsupported file format.</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @if($user->mahasiswa->skripsi->nilai_skripsi == NULL)
                                <td class="text-center">-</td>
                                @else
                                <td class="text-center">{{$user->mahasiswa->skripsi->nilai_skripsi}}</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                // JavaScript to show/hide sections when tabs are clicked
                const navPills = document.querySelectorAll('.nav-pill a');
                const sections = document.querySelectorAll('.section');

                function showSection(index) {
                    // Hide all sections
                    sections.forEach((section) => {
                        section.style.display = 'none';
                    });
                    // Show the selected section
                    sections[index].style.display = 'block';
                }

                navPills.forEach((pill, index) => {
                    pill.addEventListener('click', (e) => {
                        e.preventDefault();
                        showSection(index);
                        // Save the selected section to local storage
                        localStorage.setItem('selectedSection', index);
                    });
                });

                // Check local storage for the selected section
                const selectedSection = localStorage.getItem('selectedSection');
                if (selectedSection !== null) {
                    showSection(parseInt(selectedSection, 10));
                } else {
                    // If no selection is found, show the first section
                    showSection(0);
                }
            </script>
        </div>

    </div>
</div>

@endsection