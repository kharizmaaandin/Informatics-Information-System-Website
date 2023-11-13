@extends('layout')
@section('content')

<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/dashboard/mahasiswa/{{$user->NIP}}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                Validasi Mahasiswa
            </div>
            <ul class="nav-pill">
                <li><a href="#section1">IRS</a></li>
                <li><a href="#section2">KHS</a></li>
                <li><a href="#section3">PKL</a></li>
                <li><a href="#section4">Skripsi</a></li>
            </ul>
            <hr />
            <div class="section" id="section1">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Semester</th>
                                <th scope="col">Scan IRS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($irs as $ir)
                            <tr>
                                @if($ir->mahasiswa->NIP == $user->NIP)
                                <td>{{$ir->id_irs}}</td>
                                <td>{{$ir->mahasiswa->nama}}</td>
                                <td>{{$ir->mahasiswa->NIM}}</td>
                                <td>{{$ir->smst_aktif}}</td>
                                <td>{{$ir->berkas_irs}}</td>
                                <td>
                                    <button type="button" class="btn btn-light px-5 d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#exampleModalLong1" style="height: 30px; width: 30px;">
                                        Lihat File
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong1">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas IRS</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="background-color: #555555; max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($ir->berkas_irs, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($fileExtension)
                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_irs/' . $ir->berkas_irs) }}" type="application/pdf" width="100%" height="100%">
                                                        Your PDF viewer does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_irs/' . $ir->berkas_irs) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p>Unsupported file format: {{ $fileExtension }}</p>
                                                    @endif
                                                    @else
                                                    <p>File extension not found. Please check the file path.</p>
                                                    @endif

                                                    <form action="/dashboard/mahasiswa/{{$user->NIM}}/academic/addIRS/confirm" method="POST" enctype="multipart/form-data" id="validasiForm">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="ips">IP Semester</label>
                                                            <input type="text" class="form-control" id="ips" name="ips" placeholder="Masukkan IP Semester" />
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                    <!-- Add a "Validasi" button in the modal-footer -->
                                                    <button type="button" class="btn btn-primary" id="validasiButton">Validasi</button>
                                                </div>

                                                <script>
                                                    // JavaScript to handle the form submission when the "Validasi" button is clicked
                                                    document.getElementById('validasiButton').addEventListener('click', function() {
                                                        document.getElementById('validasiForm').submit();
                                                    });
                                                </script>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 2 content -->
            <div class="section" id="section2">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Semester</th>
                                <th scope="col">IP Semester</th>
                                <th scope="col">Status</th>
                                <th scope="col">Scan KHS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($khs as $k)
                            <tr>
                                <td>{{$k->id_khs}}</td>
                                <td>{{$k->mahasiswa->nama}}</td>
                                <td>{{$k->NIM}}</td>
                                <td>{{$k->smt_aktif}}</td>
                                <td>{{$k->IP_smt}}</td>
                                @if($k->IP_smt != NULL)
                                <td>Sudah divalidasi</td>
                                @else
                                <td>Belum divalidasi</td>
                                @endif
                                <td>
                                    @php
                                    $id = $k->id_khs;
                                    @endphp
                                    {{$id}}
                                    <button type="button" class="btn btn-light btn-round px-2 d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#exampleModalLong2">Lihat File</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong2">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas KHS</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="background-color: #555555; max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($k->berkas_khs, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_khs/' . $k->berkas_khs) }}" type="application/pdf" width="100%" height="100%">
                                                        Your browser does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_khs/' . $k->berkas_khs) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p>Unsupported file format.</p>
                                                    @endif
                                                    <form action="/dashboard/dosen/{{$user->NIP}}/validation/{{$k->id_khs}}" method="POST" enctype="multipart/form-data" id="validasiForm2">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="ips">IP Semester {{ $id }}</label>
                                                            <input type="text" class="form-control" id="ips" name="ips" placeholder="Masukkan IP Semester" />
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                    <!-- Add a "Validasi" button in the modal-footer -->
                                                    <button type="button" class="btn btn-primary" id="validasiButton2">Validasi</button>
                                                </div>

                                                <script>
                                                    // JavaScript to handle the form submission when the "Validasi" button is clicked
                                                    document.getElementById('validasiButton2').addEventListener('click', function() {
                                                        document.getElementById('validasiForm2').submit();
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 3 content -->
            <div class="section" id="section3">
                <!-- Content for section 3 -->

            </div>

            <!-- Section 4 content -->
            <div class="section" id="section4">

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