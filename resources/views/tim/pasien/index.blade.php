@extends('tim.layout.app')
@section('title', 'Pasien')
@section('content')
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-custom">

                    <div class="table-responsive">
                        <table class="table" id="pasien-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Usia</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('libs/table/datatable/datatables.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('libs/table/datatable/dt-global_style.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('libs/simple-datatables/style.css') }}">
    <!-- notiflix -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notiflix/dist/notiflix-3.2.6.min.css" />
    <!-- DataTables CSS -->
@endpush

@push('script')
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/simple-datatables/umd/simple-datatables.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script></script>

    <script>
        $(document).ready(function() {


            const dataTable = new simpleDatatables.DataTable("#pasien-table", {
                searchable: true,
                fixedHeight: false,
                perPage: 5,
                perPageSelect: [5, 10, 20, 50],
                labels: {
                    placeholder: "Cari...",
                    perPage: "{select} data per halaman",
                    noRows: "Tidak ada data yang ditemukan",
                    info: "Menampilkan {start} hingga {end} dari {rows} data",
                    next: "<i class='fas fa-chevron-right'></i>",
                    prev: "<i class='fas fa-chevron-left'></i>"
                }
            });

            function loadPasienData() {
                const jumlahKuisioner = {{ $kuisioner }}; // dari controller
                $.ajax({

                    url: "{{ route('tim_peneliti.pasien.data') }}",
                    method: "GET",
                    dataType: "json",
                    beforeSend: function() {
                        Notiflix.Loading.standard("Memuat data...");
                        console.log("Memuat data...");
                    },
                    success: function(response) {
                        Notiflix.Loading.remove();
                        if (!response.data || response.data.length === 0) {
                            dataTable.clear();
                            dataTable.refresh();
                            return;
                        }

                        // Urutkan data: belum isi pretest -> isi pretest tapi belum posttest -> sudah lengkap
                        const sortedData = response.data.sort((a, b) => {
                            const getStatus = (pasien) => {
                                if (!pasien.hasil_analisis) return 0; // belum isi pretest
                                if (pasien.hasil_analisis && pasien.hasil_analisis
                                    .skor_posttest === null) return 1; // belum isi posttest
                                return 2; // sudah lengkap
                            };
                            return getStatus(a) - getStatus(b);
                        });

                        dataTable.clear();
                        let newData = sortedData.map(pasien => {
                            let aksiBtn = "";

                            if (jumlahKuisioner === 0) {
                                aksiBtn =
                                    `<span class="badge badge-outline-secondary ">Tidak ada kuisioner tersedia</span>`;
                            } else if (!pasien.hasil_analisis) {
                                aksiBtn = `
                <a href="/tim_peneliti/kuisioner/pretest/${pasien.id}" class="btn btn-sm btn-outline-primary" title="Isi Pretest">
                    <i class="ti ti-clipboard-text fs-5"></i> Pretest
                </a>
            `;
                            } else if (pasien.hasil_analisis && pasien.hasil_analisis
                                .skor_posttest === null) {
                                aksiBtn = `
                <a href="/tim_peneliti/kuisioner/posttest/${pasien.id}" class="btn btn-sm btn-outline-success" title="Isi Posttest">
                    <i class="ti ti-checklist fs-5"></i> Posttest
                </a>
            `;
                            } else {
                                aksiBtn =
                                    `<span class="badge rounded-pill badge-soft-success">Success</span>`;
                            }

                            return [
                                pasien.nama,
                                pasien.usia.toString(),
                                pasien.jenis_kelamin,
                                aksiBtn
                            ];
                        });

                        dataTable.rows().add(newData);
                        dataTable.refresh();
                    },
                    error: function(xhr, status, error) {
                        Notiflix.Loading.remove();
                        console.error("Gagal mengambil data:", error);
                    }
                });
            }


            loadPasienData();

        });
    </script>
@endpush
