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
            overflow: visible;
            /* مهم لعرض القائمة كاملة */
        }

        .dropdown-menu {
            max-height: 300px;
            /* حد أقصى للطول */
            overflow-y: auto;
            /* إضافة شريط تمرير عند الحاجة */
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

            <!-- زر الإشعارات -->
            <div class="dropdown">
                <button class="btn btn-outline-warning position-relative" id="notifBtn" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-bell-fill"></i>
                    @if ($notifications->count() > 0)
                        <span id="notifCount"
                            class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>

                    @endif
                </button>

                <!-- القائمة -->
                <ul class="dropdown-menu dropdown-menu-end text-end shadow mt-2" id="notifList"
                    style="min-width: 280px;">
                    <li class="text-center text-muted">جارِ التحميل...</li>
                </ul>

            </div>

        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}">🏠 الرئيسية</a>
        <a href="{{ route('admin.categories.index') }}">📦 الأصناف</a>
        <a href="{{ route('admin.products.index') }}">📦 المنتجات</a>
        <a href="{{ route('admin.orders.index') }}">📦 الطلبات</a>
        <a href="{{ route('admin.notifications') }}">📦 الاشعارات</a>
        <a href="#">👥 العملاء</a>
        <a href="#">📊 التقارير</a>
        <a href="#">⚙ الإعدادات</a>
    </div>

    <!-- Content -->
    <div class="content" id="content">
        @yield('content')
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
    <script>
        /*
        document.addEventListener("DOMContentLoaded", function () {
            const notifBtn = document.getElementById("notifBtn");
            const notifList = document.getElementById("notifList");
            const notifCount = document.getElementById("notifCount");

            notifBtn.addEventListener("click", function () {
                fetch("{{ route('admin.notifications') }}")
                    .then(res => res.json())
                    .then(data => {
                        notifList.innerHTML = '<li><h6 class="dropdown-header">الإشعارات</h6></li>';

                        if (data.length === 0) {
                            notifList.innerHTML += '<li class="text-center text-muted">لا توجد إشعارات</li>';
                        } else {
                            data.forEach(n => {
                                notifList.innerHTML += `
                            <li><a class="dropdown-item" href="/orders/${n.data.order_id}">
                                📌 ${n.data.message}
                            </a></li>
                        `;
                            });
                            notifList.innerHTML += '<li><hr class="dropdown-divider"></li>';
                            notifList.innerHTML += '<li><a class="dropdown-item text-center text-primary" href="#">عرض الكل</a></li>';
                        }

                        notifCount.textContent = data.length;
                    });
            });
        });
        */
    </script>
    <script>
        document.getElementById('notifBtn').addEventListener('click', function () {
            fetch("{{ route('admin.notifications.readAll') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            }).then(() => {
                document.getElementById('notifCount').innerText = "0";
            });
        });
    </script>
    <script>
        function loadNotifications() {
            fetch("{{ route('admin.notifications.latest') }}")
                .then(res => res.json())
                .then(data => {
                    // تحديث العدد
                    document.getElementById('notifCount').innerText = data.count;

                    // تحديث القائمة
                    let list = document.getElementById('notifList');
                    list.innerHTML = `
                    <li><h6 class="dropdown-header">الإشعارات</h6></li>
                `;

                    if (data.notifications.length > 0) {
                        data.notifications.forEach(n => {
                            list.insertAdjacentHTML("beforeend",
                                `<li><a class="dropdown-item" href="/admin/orders/${n.data.order_id}">
                                ${n.data.message}
                            </a></li>`
                            );
                        });

                        list.insertAdjacentHTML("beforeend",
                            `<li><hr class="dropdown-divider"></li>
                         <li><a class="dropdown-item text-center text-primary" href="{{ route('admin.notifications') }}">
                             عرض كل الإشعارات
                         </a></li>`
                        );
                    } else {
                        list.insertAdjacentHTML("beforeend",
                            `<li class="text-center text-muted">لا توجد إشعارات</li>`
                        );
                    }
                });
        }

        // تحميل أول مرة
        loadNotifications();

        // تكرار كل 30 ثانية
        setInterval(loadNotifications, 30000);
    </script>


</body>

</html>