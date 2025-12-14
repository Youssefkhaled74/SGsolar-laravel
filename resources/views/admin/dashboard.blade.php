<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - SgSolar</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #F3F4F6;
            color: #1F2937;
        }
        
        .header {
            background: linear-gradient(135deg, #0C2D1C 0%, #115F45 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 1.5rem;
        }
        
        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1.5rem;
            border: 2px solid white;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .logout-btn:hover {
            background: white;
            color: #0C2D1C;
        }
        
        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        
        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stat-card.new .icon { background: #DBEAFE; color: #1E40AF; }
        .stat-card.progress .icon { background: #FEF3C7; color: #92400E; }
        .stat-card.done .icon { background: #D1FAE5; color: #065F46; }
        .stat-card.invalid .icon { background: #FEE2E2; color: #991B1B; }
        
        .stat-card h3 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-card p {
            color: #6B7280;
        }
        
        .contacts-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .section-header {
            padding: 1.5rem 2rem;
            border-bottom: 2px solid #F3F4F6;
        }
        
        .section-header h2 {
            font-size: 1.5rem;
            color: #0C2D1C;
        }
        
        .contacts-table {
            width: 100%;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #F9FAFB;
            padding: 1rem;
            text-align: right;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #E5E7EB;
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid #F3F4F6;
        }
        
        tr:hover {
            background: #F9FAFB;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-new { background: #DBEAFE; color: #1E40AF; }
        .status-in_progress { background: #FEF3C7; color: #92400E; }
        .status-done { background: #D1FAE5; color: #065F46; }
        .status-invalid { background: #FEE2E2; color: #991B1B; }
        
        .status-select {
            padding: 0.5rem;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            font-family: inherit;
            cursor: pointer;
        }
        
        .btn-delete {
            background: #EF4444;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-delete:hover {
            background: #DC2626;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6B7280;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .contacts-table {
                overflow-x: scroll;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌞 لوحة التحكم - SgSolar</h1>
            <a href="{{ route('admin.logout') }}" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
            </a>
        </div>
    </div>
    
    <div class="container">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card new">
                <div class="icon"><i class="fas fa-envelope"></i></div>
                <h3>{{ collect($contacts)->where('status', 'new')->count() }}</h3>
                <p>رسائل جديدة</p>
            </div>
            
            <div class="stat-card progress">
                <div class="icon"><i class="fas fa-clock"></i></div>
                <h3>{{ collect($contacts)->where('status', 'in_progress')->count() }}</h3>
                <p>قيد المعالجة</p>
            </div>
            
            <div class="stat-card done">
                <div class="icon"><i class="fas fa-check-circle"></i></div>
                <h3>{{ collect($contacts)->where('status', 'done')->count() }}</h3>
                <p>تم الإنجاز</p>
            </div>
            
            <div class="stat-card invalid">
                <div class="icon"><i class="fas fa-times-circle"></i></div>
                <h3>{{ collect($contacts)->where('status', 'invalid')->count() }}</h3>
                <p>بيانات غير صحيحة</p>
            </div>
        </div>
        
        <!-- Contacts Table -->
        <div class="contacts-section">
            <div class="section-header">
                <h2>📋 جميع الرسائل ({{ count($contacts) }})</h2>
            </div>
            
            @if(count($contacts) > 0)
                <div class="contacts-table">
                    <table>
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الهاتف</th>
                                <th>الموضوع</th>
                                <th>الرسالة</th>
                                <th>الحالة</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_reverse($contacts, true) as $id => $contact)
                                <tr>
                                    <td style="white-space: nowrap;">{{ $contact['created_at'] ?? $contact['date'] ?? '-' }}</td>
                                    <td><strong>{{ $contact['name'] }}</strong></td>
                                    <td>{{ $contact['email'] }}</td>
                                    <td>{{ $contact['phone'] ?? '-' }}</td>
                                    <td>
                                        @if($contact['subject'] == 'product')
                                            استفسار عن منتج
                                        @elseif($contact['subject'] == 'quote')
                                            طلب عرض سعر
                                        @elseif($contact['subject'] == 'installation')
                                            سؤال عن التركيب
                                        @elseif($contact['subject'] == 'maintenance')
                                            الصيانة والدعم
                                        @else
                                            أخرى
                                        @endif
                                    </td>
                                    <td style="max-width: 300px;">{{ $contact['message'] }}</td>
                                    <td>
                                        <select class="status-select" onchange="updateStatus('{{ $id }}', this.value)">
                                            <option value="new" {{ $contact['status'] == 'new' ? 'selected' : '' }}>جديد</option>
                                            <option value="in_progress" {{ $contact['status'] == 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                                            <option value="done" {{ $contact['status'] == 'done' ? 'selected' : '' }}>تم</option>
                                            <option value="invalid" {{ $contact['status'] == 'invalid' ? 'selected' : '' }}>غير صحيح</option>
                                        </select>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.contact.delete', $id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>لا توجد رسائل حتى الآن</h3>
                    <p>سيتم عرض رسائل العملاء هنا</p>
                </div>
            @endif
        </div>
    </div>
    
    <script>
        function updateStatus(id, status) {
            fetch(`/dashboard_admin/contact/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    </script>
</body>
</html>
