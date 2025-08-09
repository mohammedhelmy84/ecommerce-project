<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            font-family: "Tajawal", sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #343a40;
            padding-top: 60px;
            width: 250px;
            transition: all 0.3s;
            overflow-y: auto;
        }

        .sidebar a {
            color: #ddd;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }

        .content {
            margin-right: 250px;
            padding: 20px;
            transition: all 0.3s;
            margin-top: 70px;
        }

        .sidebar.collapsed {
            right: -250px;
        }

        .content.expanded {
            margin-right: 0;
        }

        .navbar {
            z-index: 1000;
            overflow: visible; /* مهم لعرض القائمة كاملة */
        }

        .dropdown-menu {
            max-height: 300px; /* حد أقصى للطول */
            overflow-y: auto;  /* إضافة شريط تمرير عند الحاجة */
        }

        .card {
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            animation: float 2s ease-in-out infinite;
        }

        @keyframes float {
            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">

            <!-- القسم الأيمن: زر القائمة + العنوان -->
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-light" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <span class="navbar-brand mb-0 h1">لوحة التحكم</span>
            </div>

            <!-- القسم الأيسر: زر الإشعارات -->
            <div class="dropdown">
                <button class="btn btn-outline-warning position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell-fill"></i>
                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">3</span>
                </button>

                <!-- القائمة -->
                <ul class="dropdown-menu dropdown-menu-end text-end shadow mt-2" style="min-width: 280px;">
                    <li><h6 class="dropdown-header">الإشعارات</h6></li>
                    <li><a class="dropdown-item" href="#">📌 طلب جديد بانتظار الموافقة</a></li>
                    <li><a class="dropdown-item" href="#">✅ تم تحديث حالة الطلب</a></li>
                    <li><a class="dropdown-item" href="#">⚠️ مشكلة في الدفع</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center text-primary" href="#">عرض كل الإشعارات</a></li>
                </ul>
            </div>

        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="#">🏠 الرئيسية</a>
        <a href="#">📦 الطلبات</a>
        <a href="#">👥 العملاء</a>
        <a href="#">📊 التقارير</a>
        <a href="#">⚙ الإعدادات</a>
    </div>

    <!-- Content -->
    <div class="content" id="content">
        <div class="container-fluid mt-4">

            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card text-white bg-primary p-3">
                        <div>
                            <h5 class="card-title">عدد الطلبات</h5>
                            <p class="card-text fs-4">120</p>
                        </div>
                        <img src="https://cdn-icons-gif.flaticon.com/8121/8121335.gif" alt="طلبات">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success p-3">
                        <div>
                            <h5 class="card-title">المبيعات</h5>
                            <p class="card-text fs-4">$5400</p>
                        </div>
                        <img src="https://cdn-icons-gif.flaticon.com/8121/8121363.gif" alt="مبيعات">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning p-3">
                        <div>
                            <h5 class="card-title">العملاء</h5>
                            <p class="card-text fs-4">350</p>
                        </div>
                        <img src="https://cdn-icons-gif.flaticon.com/8121/8121350.gif" alt="عملاء">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger p-3">
                        <div>
                            <h5 class="card-title">المرتجعات</h5>
                            <p class="card-text fs-4">15</p>
                        </div>
                        <img src="https://cdn-icons-gif.flaticon.com/8121/8121323.gif" alt="مرتجعات">
                    </div>
                </div>
            </div>

            <h3 class="card-header">أحدث الطلبات</h3>
            <div class="table-responsive">
                <table class="table table-striped mb-0 w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1001</td>
                            <td>محمد أحمد</td>
                            <td>$200</td>
                            <td>✅ مكتمل</td>
                        </tr>
                        <tr>
                            <td>#1002</td>
                            <td>سارة علي</td>
                            <td>$150</td>
                            <td>⏳ قيد المعالجة</td>
                        </tr>
                        <tr>
                            <td>#1003</td>
                            <td>أحمد محمد</td>
                            <td>$300</td>
                            <td>❌ ملغي</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById("toggleSidebar");
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");

        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("expanded");
        });

        if (window.innerWidth < 768) {
            sidebar.classList.add("collapsed");
            content.classList.add("expanded");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
