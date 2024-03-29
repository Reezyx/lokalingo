<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Traffic</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $data['traffic_current'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                @if ($data['percent_traffic'] < 0)
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i>
                                        {{ $data['percent_traffic'] }}%</span>
                                @else
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>
                                        {{ $data['percent_traffic'] }}%</span>
                                @endif
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $data['user_current'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                @if ($data['percentage'] < 0)
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i>
                                        {{ $data['percentage'] }}%</span>
                                @else
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>
                                        {{ $data['percentage'] }}%</span>
                                @endif
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Activity</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $data['user_activity'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                @if ($data['activity_percent'] < 0)
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i>
                                        {{ $data['activity_percent'] }}%</span>
                                @else
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>
                                        {{ $data['activity_percent'] }}%</span>
                                @endif
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Download</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $data['download'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                @if ($data['percent_download'] < 0)
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i>
                                        {{ $data['percent_download'] }}%</span>
                                @else
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>
                                        {{ $data['percent_download'] }}%</span>
                                @endif
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
