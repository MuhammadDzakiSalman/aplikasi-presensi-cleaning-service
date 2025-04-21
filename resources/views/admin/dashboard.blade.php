@extends('app.main')
@section('title', 'Dashboard')
@section('content')
    <div id="main">
        <header class="mb-3"><a class="d-block d-xl-none burger-btn" href="#"><i class="fs-3 bi bi-justify"></i></a>
        </header>
        <div class="page-heading">
            <h3>Dashboard</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col">
                    <div class="row gx-3 gy-3 mb-3">
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="card h-100">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row gx-1">
                                        <div
                                            class="col-3 col-sm-1 col-md-4 col-lg-2 col-xl-3 col-xxl-2 d-flex justify-content-start">
                                            <div class="purple stats-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
                                                    class="bi bi-people-fill fs-3 text-white">
                                                    <path
                                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5">
                                                    </path>
                                                </svg></div>
                                        </div>
                                        <div class="col">
                                            <h6 class="text-muted font-semibold">Total Cleaning Service</h6>
                                            <h6 class="font-extrabold mb-0">{{ $cleaningServiceCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="card h-100">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row gx-1">
                                        <div
                                            class="col-3 col-sm-1 col-md-4 col-lg-2 col-xl-3 col-xxl-2 d-flex justify-content-start">
                                            <div class="green stats-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
                                                    class="bi bi-calendar-check-fill fs-3 text-white">
                                                    <path
                                                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z">
                                                    </path>
                                                </svg></div>
                                        </div>
                                        <div class="col">
                                            <h6 class="text-muted font-semibold">Hadir Hari Ini</h6>
                                            <h6 class="font-extrabold mb-0">{{ $todayPresensiInCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="card h-100">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row gx-1">
                                        <div
                                            class="col-3 col-sm-1 col-md-4 col-lg-2 col-xl-3 col-xxl-2 d-flex justify-content-start">
                                            <div class="red stats-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
                                                    class="bi bi-calendar-x-fill fs-3 text-white">
                                                    <path
                                                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M6.854 8.146 8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 1 1 .708-.708z">
                                                    </path>
                                                </svg></div>
                                        </div>
                                        <div class="col">
                                            <h6 class="text-muted font-semibold">Izin Hari Ini</h6>
                                            <h6 class="font-extrabold mb-0">{{ $todayIzinCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-3 gy-3 mb-3">
                        <div class="col-12 col-md-8 col-xl-8">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h4>Grafik Presensi</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-profile-visit"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h4>Distribusi Jenis Kelamin</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-visitors-profile"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var optionsProfileVisit = {
            annotations: {
                position: "back",
            },
            dataLabels: {
                enabled: false,
            },
            chart: {
                type: "bar",
                height: 300,
            },
            fill: {
                opacity: 1,
            },
            plotOptions: {},
            series: [{
                name: "Presensi",
                data: @json(array_values($monthlyData)),
            }, ],
            colors: "#435ebe",
            xaxis: {
                categories: [
                    "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
                ],
            },
        }

        let optionsVisitorsProfile = {
            series: [@json($genderData['Male']), @json($genderData['Female'])],
            labels: ["Male", "Female"],
            colors: ["#435ebe", "#55c6e8"],
            chart: {
                type: "donut",
                width: "100%",
                height: "350px",
            },
            legend: {
                position: "bottom",
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "30%",
                    },
                },
            },
        }

        var chartProfileVisit = new ApexCharts(
            document.querySelector("#chart-profile-visit"),
            optionsProfileVisit
        )
        var chartVisitorsProfile = new ApexCharts(
            document.getElementById("chart-visitors-profile"),
            optionsVisitorsProfile
        )

        chartProfileVisit.render()
        chartVisitorsProfile.render()
    </script>

@endsection
