@extends('layouts.superadmin_app', ['use_chartjs' => true])



@section('content')
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <x-stats-card title="Total Projects" sub_title='All Time' number="{{ $total_projects }}">

                    </x-stats-card>
                </div>
                <div class="col-md-6 col-xl-4">
                    <x-stats-card title="Total Income" sub_title='All Time' number="{{ $total_income }} PKR"
                        bg='bg-arielle-smile'>

                    </x-stats-card>
                </div>
                <div class="col-md-6 col-xl-4">
                    <x-stats-card title="{{ $best_team != null ? $best_team->team_name : '' }}"
                        sub_title='Top Performing Team' number="{{ $best_team_projects }}" bg='bg-grow-early'>

                    </x-stats-card>
                </div>
                <div class="d-xl-nones d-lg-block col-md-6 col-xl-4">
                    <a href="{{ route('tickets.index', ['status' => 'pending']) }}">
                        <x-stats-card title="Pending Tickets" sub_title='This Month' number="{{ $pending_tickets }}"
                            bg=' bg-premium-dark'>

                        </x-stats-card>
                    </a>
                </div>
                <div class="d-xl-nones d-lg-block col-md-6 col-xl-4">
                    <a href="{{ route('tasks.index', ['status' => 'pending']) }}">
                        <x-stats-card title="Pending Tasks" sub_title='This Month' number="{{ $pending_tasks }}"
                            bg='bg-arielle-smile'>

                        </x-stats-card>
                    </a>
                </div>
                <div class="d-xl-nones d-lg-block col-md-6 col-xl-4">
                    <x-stats-card title="All Users" sub_title='' number="{{ $total_users }}" bg=' bg-midnight-bloom'>

                    </x-stats-card>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <x-card title='Pending Tasks in Every Priority'>

                        <div class="">
                            <canvas style="max-height:300px" id="tasks-priority-wise"></canvas>
                        </div>
                    </x-card>

                </div>

                <div class="col-md-6">
                    <x-card title='Pending Tickets in Every Priority'>

                        <div class="">
                            <canvas style="max-height:300px" id="tickets-priority-wise"></canvas>
                        </div>
                    </x-card>

                </div>

            </div>


            <x-card title='Projects Per Month' tab1="Year {{strtoupper(date('Y'))}}">

                <div class="">
                    <canvas id="projects-success-per-month"></canvas>
                </div>
            </x-card>

            {{-- <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Total Check Ups</div>
                                    <div class="widget-subheading">Last Month</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-success">1896</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Total Revenue</div>
                                    <div class="widget-subheading">Revenue streams</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-warning">$3M</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Good Reviews</div>
                                    <div class="widget-subheading">People Interested</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-danger">45,9%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-xl-none d-lg-block col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Income</div>
                                    <div class="widget-subheading">Expected totals</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-focus">$147</div>
                                </div>
                            </div>
                            <div class="widget-progress-wrapper">
                                <div class="progress-bar-sm progress-bar-animated-alt progress">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="54"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 54%;"></div>
                                </div>
                                <div class="progress-sub-label">
                                    <div class="sub-label-left">Expenses</div>
                                    <div class="sub-label-right">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">Last Projects with Pending Work
                            <div class="btn-actions-pane-right">

                            </div>
                        </div>
                        <div class="table-responsive">
                            <x-fancy-table>
                                <x-fancy-table-head>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th class="text-center">Pending Tasks</th>
                                        <th class="text-center">Pending Tickets</th>
                                        <th class="text-center">Progress</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </x-fancy-table-head>

                                <x-fancy-table-body>

                                    @foreach ($latest_project as $key=> $project)
                                        <tr>
                                            <td class="text-center text-muted">#{{$key}}</td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img width="40" class="rounded-circle"
                                                                    src="assets/images/avatars/3.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">{{$project->name}}</div>
                                                            <div class="widget-subheading opacity-7">
                                                                <b>Lead: </b>{{$project->lead->name}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $project->pendingTasks("count") }}</td>
                                            <td class="text-center">{{ $project->pendingTickets("count") }}</td>
                                            <td class="text-center">
                                                <x-progress-card value="{{ $project->progress()['progress_percentage'] }}"
                                                    color="{{ $project->progress()['status_color'] }}" showCard="false" />
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route("projects.edit",['project'=>$project->id]) }}" type="button" id="PopoverCustomT-2"
                                                    class="btn btn-primary btn-sm">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </x-fancy-table-body>
                            </x-fancy-table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection



@section('js')
    <script>
        Chart.register(ChartDataLabels);
        Chart.defaults.font.size = 20;

        /// SETUP POJECT SUCCESS Chart
        const DATA_COUNT = 12;
        const NUMBER_CFG = {
            count: DATA_COUNT,
            min: 0,
        };

        const monthLabels = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec"
        ];

        const new_project_data = [
            @for ($i = 1; $i <= 12; $i++)
                @php
                    if (isset($porject_success_months_new_prjects_arr[$i])) {
                        echo $porject_success_months_new_prjects_arr[$i] . ',';
                    } else {
                        echo '0,';
                    }

                @endphp
            @endfor
        ];

        const completed_project_data = [
            @for ($i = 1; $i <= 12; $i++)
                @php
                    if (isset($porject_success_months_completed_prjects_arr[$i])) {
                        echo $porject_success_months_completed_prjects_arr[$i];
                    } else {
                        echo '0,';
                    }

                @endphp
            @endfor
        ];

        console.log("new project", new_project_data)

        const data = {
            labels: monthLabels,
            datasets: [{
                    label: 'New Projects',
                    data: new_project_data,
                    borderColor: Utils.CHART_COLORS.green,
                    backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.3),
                },
                {
                    label: 'Completed Projects',
                    data: completed_project_data,
                    borderColor: Utils.CHART_COLORS.red,
                    backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.3),
                }
            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        color: "white"
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Projects'
                        },
                        min: 0,
                        ticks: {
                            // forces step size to be 50 units
                            stepSize: 1
                        }
                    }
                }
            }

        };
        const project_success_chart_canvas = document.getElementById("projects-success-per-month")
        var project_success_chart = new Chart(project_success_chart_canvas, config);
    </script>





    <script>
        /**
         * 
         * TASKS IN EVERY PRIORITY 
         * 
         * */
        const task_priority_labels = ['high', 'medium', 'low']
        let task_priority_dataset = [0, 0, 0]

        <?php 
                foreach ($task_in_every_priortiy_arr as $priority_name=>$priority) {
                    
                    ?>
        if (task_priority_labels.indexOf("<?= $priority_name ?>") >= 0) {
            task_priority_dataset[task_priority_labels.indexOf("<?= $priority_name ?>")] = "<?= $priority ?>"
        }

        <?php
                    
                }
            ?>

        const task_priority_data = {
            labels: ['High', 'Medium', 'Low'],
            datasets: [{
                label: 'Tasks: ',
                data: task_priority_dataset,
                backgroundColor: [Utils.CHART_COLORS.red, Utils.CHART_COLORS.orange, Utils.CHART_COLORS.blue],
            }]
        };

        const task_priority_config = {
            type: 'doughnut',
            data: task_priority_data,
            showDatapoints: true,
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Tasks in Every Priority'
                    },
                    datalabels: {
                        color: "white"
                    },
                }
            },
        };

        const task_priority_canvas = document.getElementById("tasks-priority-wise")
        let task_priority_chart = new Chart(task_priority_canvas, task_priority_config)
    </script>



    <script>
        /**
         * 
         * Tickets IN EVERY PRIORITY 
         * 
         * */
        const ticket_priority_labels = ['high', 'medium', 'low']
        let ticket_priority_dataset = [0, 0, 0]

        <?php 
                foreach ($ticket_in_every_priortiy_arr as $priority_name=>$priority) {
                    
                    ?>
        console.log("props", "<?= $priority ?>")
        if (ticket_priority_labels.indexOf("<?= $priority_name ?>") >= 0) {
            ticket_priority_dataset[ticket_priority_labels.indexOf("<?= $priority_name ?>")] = "<?= $priority ?>"
        }
        <?php
                    
                }
            ?>
        const ticket_priority_data = {
            labels: ['High', 'Medium', 'Low'],
            datasets: [{
                label: 'tickets: ',
                data: ticket_priority_dataset,
                backgroundColor: [Utils.CHART_COLORS.red, Utils.CHART_COLORS.orange, Utils.CHART_COLORS.blue],
            }]
        };

        console.log("ticktes", ticket_priority_dataset)

        const ticket_priority_config = {
            type: 'doughnut',
            data: ticket_priority_data,
            showDatapoints: true,
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'tickets in Every Priority'
                    },
                    datalabels: {
                        color: "white"
                    },
                }
            },
        };

        const ticket_priority_canvas = document.getElementById("tickets-priority-wise")
        let ticket_priority_chart = new Chart(ticket_priority_canvas, ticket_priority_config)
    </script>
@endsection
