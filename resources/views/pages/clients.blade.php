@extends('layouts.app')

@section('title', __('site.footer.clients') . ' — ' . config('app.name'))

@section('content')

    <style>
        .clients-section {
            padding: 100px 20px;
            text-align: center;
        }

        .clients-container {
            max-width: 1100px;
            margin: auto;
        }

        .clients-title {
            font-size: 38px;
            font-weight: 800;
            margin-bottom: 50px;
        }

        .clients-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 25px;
            align-items: center;
        }

        @media (max-width: 1024px) {
            .clients-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .clients-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .client-card {
            padding: 20px;
            border-radius: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.04);
        }

        .dark .client-card {
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        body:not(.dark) .client-card {
            background: #fff;
            border: 1px solid #e5e7eb;
        }

        .client-card:hover {
            transform: translateY(-5px);
            border-color: var(--color-primary);
        }

        .client-logo {
            width: 100%;
            max-height: 60px;
            object-fit: contain;
            transition: 0.3s ease;
        }

        .client-card:hover .client-logo {
            transform: scale(1.05);
        }

        .client-name {
            margin-top: 10px;
            font-size: 14px;
            color: #9ca3af;
        }

        body:not(.dark) .client-name {
            color: #6b7280;
        }
    </style>

    <section class="clients-section">

        <div class="clients-container">

            <h1 class="clients-title">
                {{ __('site.footer.clients') }}
            </h1>

            <div class="clients-grid">

                @php
                    $clients = [
                        'وزارة الدفاع.jpeg',
                        'dussmann.png',
                        'go telecom.jpeg',
                        'mitsubishi electric.png',
                        'البنك السعودي للاستثمار.png',
                        'العليان.png',
                        'المجال العربي.jpeg',
                        'زهران.png',
                        'شركة العرض المتقن.png',
                        'عجلان واخوانه.png',
                        'غرفة الرياض.jpeg',
                        'مجموعة سدر.jpeg'
                    ];
                @endphp

                @foreach ($clients as $logo)
                    <div class="client-card">
                        <img src="{{ asset('images/clients/' . $logo) }}" alt="client" class="client-logo">

                        <div class="client-name">
                            {{ pathinfo($logo, PATHINFO_FILENAME) }}
                        </div>
                    </div>
                @endforeach

            </div>

        </div>

    </section>

@endsection