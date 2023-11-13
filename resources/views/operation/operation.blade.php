@extends('layout')
@section('content')
<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/dashboard/operator/{{$user->NIP}}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                Data Mahasiswa
            </div>
            <ul class="nav-pill">
                <li><a href="#section1">Mahasiswa</a></li>
                <li><a href="#section2">Dosen</a></li>
            </ul>
            <hr />
            <div class="section" id="section1">
                <a href="/dashboard/operator/{{$user->NIP}}/manajemen/addaccount" type="button" class="btn btn-light btn-round px-5 d-flex justify-content-center align-items-center">
                    <i class="fas fa-folder-plus"></i> &nbsp; Tambah Akun
                </a>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Angkatan</th>
                                <th scope="col">Dosen Wali</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswa as $student)
                            <tr>
                                <th scope="row">{{$student->nama}}</th>
                                <td>{{$student->NIM}}</td>
                                <td>{{$student->angkatan}}</td>
                                <td>{{$student->nama_doswal}}</td>
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
                                <th scope="col">Semester</th>
                                <th scope="col">SKS Semester</th>
                                <th scope="col">SKS Kumulatif</th>
                                <th scope="col">IP Semester/th>
                                <th scope="col">IP Kumulatif</th>
                                <th scope="col">Scan KHS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"></th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>@mdo</td>
                                <td><a>Lihat File</a></td>
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