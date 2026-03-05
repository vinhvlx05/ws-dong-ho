@include('admin/template/header')

<style>
    .stats-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .stats-header h2 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .chart-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        transition: transform 0.3s;
    }
    
    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .chart-card h5 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .chart-card h5 i {
        color: #667eea;
    }
    
    .top-product-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #f1f3f5;
        transition: background 0.3s;
    }
    
    .top-product-item:hover {
        background: #f8f9fa;
    }
    
    .top-product-item:last-child {
        border-bottom: none;
    }
    
    .product-rank {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        margin-right: 15px;
    }
    
    .product-rank.gold {
        background: linear-gradient(135deg, #f39c12 0%, #e74c3c 100%);
    }
    
    .product-rank.silver {
        background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
    }
    
    .product-rank.bronze {
        background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
    }
    
    .product-thumb {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        margin-right: 15px;
    }
    
    .product-info {
        flex: 1;
    }
    
    .product-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .product-stats {
        display: flex;
        gap: 20px;
    }
    
    .stat-item {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #7f8c8d;
        font-size: 13px;
    }
    
    .stat-value {
        font-weight: 600;
        color: #2c3e50;
    }
    
    .customer-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #f1f3f5;
    }
    
    .customer-row:hover {
        background: #f8f9fa;
    }
    
    .customer-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .customer-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
    }
</style>

<!-- Stats Header -->
<div class="stats-header">
    <h2>
        <i class="fas fa-chart-line"></i> 
        Thống Kê & Báo Cáo
    </h2>
    <p>Tổng quan về hiệu suất kinh doanh và xu hướng khách hàng</p>
</div>

<!-- Charts Row 1 -->
<div class="row mb-4">
    <!-- Doanh thu theo tháng -->
    <div class="col-md-8">
        <div class="chart-card">
            <h5>
                <i class="fas fa-chart-line"></i>
                Doanh Thu Theo Tháng ({{ date('Y') }})
            </h5>
            <canvas id="revenueChart" height="80"></canvas>
        </div>
    </div>
    
    <!-- Đơn hàng theo trạng thái -->
    <div class="col-md-4">
        <div class="chart-card">
            <h5>
                <i class="fas fa-chart-pie"></i>
                Đơn Hàng Theo Trạng Thái
            </h5>
            <canvas id="orderStatusChart"></canvas>
            <div class="mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Chờ xử lý:</span>
                    <strong>{{ $statusData['pending'] }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Đang xử lý:</span>
                    <strong>{{ $statusData['processing'] }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Đang giao:</span>
                    <strong>{{ $statusData['shipping'] }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Hoàn thành:</span>
                    <strong class="text-success">{{ $statusData['completed'] }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Đã hủy:</span>
                    <strong class="text-danger">{{ $statusData['cancelled'] }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="row mb-4">
    <!-- Sản phẩm theo danh mục -->
    <div class="col-md-6">
        <div class="chart-card">
            <h5>
                <i class="fas fa-layer-group"></i>
                Sản Phẩm Theo Danh Mục
            </h5>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
    
    <!-- Sản phẩm bán chạy -->
    <div class="col-md-6">
        <div class="chart-card">
            <h5>
                <i class="fas fa-fire"></i>
                Top 10 Sản Phẩm Bán Chạy
            </h5>
            <div style="max-height: 400px; overflow-y: auto;">
                @foreach($topProducts as $index => $product)
                <div class="top-product-item">
                    <div class="product-rank {{ $index == 0 ? 'gold' : ($index == 1 ? 'silver' : ($index == 2 ? 'bronze' : '')) }}">
                        {{ $index + 1 }}
                    </div>
                    <img src="{{ asset($product->product_img) }}" class="product-thumb" alt="{{ $product->product_name }}">
                    <div class="product-info">
                        <div class="product-name">{{ $product->product_name }}</div>
                        <div class="product-stats">
                            <div class="stat-item">
                                <i class="fas fa-shopping-cart"></i>
                                Đã bán: <span class="stat-value">{{ $product->total_sold }}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-dollar-sign"></i>
                                Doanh thu: <span class="stat-value">{{ number_format($product->revenue, 0, ',', '.') }}₫</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Top Customers -->
<div class="chart-card">
    <h5>
        <i class="fas fa-users"></i>
        Top 10 Khách Hàng Thân Thiết
    </h5>
    <div class="row">
        @foreach($topCustomers as $customer)
        <div class="col-md-6">
            <div class="customer-row">
                <div class="customer-info">
                    <div class="customer-avatar">
                        {{ strtoupper(substr($customer->user_fullname, 0, 1)) }}
                    </div>
                    <div>
                        <div class="product-name">{{ $customer->user_fullname }}</div>
                        <small class="text-muted">@{{ $customer->user_username }}</small>
                    </div>
                </div>
                <div class="text-end">
                    <div class="stat-value text-danger">{{ number_format($customer->total_spent, 0, ',', '.') }}₫</div>
                    <small class="text-muted">{{ $customer->order_count }} đơn hàng</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Doanh thu theo tháng
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [{
                label: 'Doanh Thu (VNĐ)',
                data: [
                    {{ $monthlyRevenue[1] }},
                    {{ $monthlyRevenue[2] }},
                    {{ $monthlyRevenue[3] }},
                    {{ $monthlyRevenue[4] }},
                    {{ $monthlyRevenue[5] }},
                    {{ $monthlyRevenue[6] }},
                    {{ $monthlyRevenue[7] }},
                    {{ $monthlyRevenue[8] }},
                    {{ $monthlyRevenue[9] }},
                    {{ $monthlyRevenue[10] }},
                    {{ $monthlyRevenue[11] }},
                    {{ $monthlyRevenue[12] }}
                ],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + context.parsed.y.toLocaleString('vi-VN') + '₫';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return (value / 1000000).toFixed(0) + 'M';
                        }
                    },
                    grid: {
                        color: '#f1f3f5'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // Đơn hàng theo trạng thái
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Chờ xử lý', 'Đang xử lý', 'Đang giao', 'Hoàn thành', 'Đã hủy'],
            datasets: [{
                data: [
                    {{ $statusData['pending'] }},
                    {{ $statusData['processing'] }},
                    {{ $statusData['shipping'] }},
                    {{ $statusData['completed'] }},
                    {{ $statusData['cancelled'] }}
                ],
                backgroundColor: [
                    '#ffc107',
                    '#0dcaf0',
                    '#0d6efd',
                    '#198754',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    
    // Sản phẩm theo danh mục
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($productsByCategory as $cat)
                    '{{ $cat->category_name }}',
                @endforeach
            ],
            datasets: [{
                label: 'Số lượng sản phẩm',
                data: [
                    @foreach($productsByCategory as $cat)
                        {{ $cat->count }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(240, 147, 251, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(67, 233, 123, 0.8)',
                    'rgba(250, 112, 154, 0.8)'
                ],
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

@include('admin/template/footer')