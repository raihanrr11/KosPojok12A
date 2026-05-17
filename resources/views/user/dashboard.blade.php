@extends('user.layout')

@section('content')
    <div class="kos-dashboard-container" style="font-family:'DM Sans',sans-serif; background:#F5EEDD; margin-top:-2rem;">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Serif+Display:ital@0;1&display=swap');

            .kos-hchip {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 100px;
                padding: 6px 14px;
                font-size: 12px;
                font-weight: 300;
                color: rgba(255, 255, 255, 0.95);
                text-shadow: 0 0 10px rgba(122, 226, 207, 0.3);
            }

            .kos-hchip svg {
                width: 12px;
                height: 12px;
                stroke: #7AE2CF;
                fill: none;
                stroke-width: 1.5;
                flex-shrink: 0;
            }

            .kos-card {
                background: #fff;
                border-radius: 18px;
                overflow: hidden;
                margin-bottom: 14px;
                border: 1px solid rgba(0, 0, 0, 0.04);
            }

            .kos-card:last-child {
                margin-bottom: 0;
            }

            .kos-card-head {
                padding: 15px 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .kos-chead-l {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .kos-cicon {
                width: 32px;
                height: 32px;
                border-radius: 9px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .kos-ctitle {
                font-size: 12px;
                font-weight: 600;
                color: #111;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .kos-csub {
                font-size: 12px;
                font-weight: 400;
                color: rgba(0, 0, 0, 0.4);
                margin-top: 2px;
            }

            .kos-see-all {
                font-size: 12px;
                font-weight: 500;
                color: rgba(0, 0, 0, 0.4);
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                padding: 6px 12px;
                transition: all 0.12s;
            }

            .kos-see-all:hover {
                background: #000C14;
                color: #fff;
                border-color: #000C14;
            }

            .kos-mstats {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                background: #FAFAF8;
            }

            .kos-msitem {
                padding: 16px 12px;
                text-align: center;
                border-right: 1px solid rgba(0, 0, 0, 0.05);
            }

            .kos-msitem:last-child {
                border-right: none;
            }

            .kos-msico {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 8px;
            }

            .kos-msval {
                font-family: 'DM Serif Display', serif;
                font-size: 26px;
                color: #111;
                line-height: 1;
            }

            .kos-mslbl {
                font-size: 11px;
                font-weight: 500;
                color: rgba(0, 0, 0, 0.4);
                margin-top: 4px;
                text-transform: uppercase;
                letter-spacing: 0.07em;
            }

            .kos-ci {
                display: flex;
                align-items: flex-start;
                gap: 13px;
                padding: 14px 20px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
                text-decoration: none;
                transition: background 0.1s;
            }

            .kos-ci:last-child {
                border-bottom: none;
            }

            .kos-ci:hover {
                background: #FAFAF8;
            }

            .kos-avatar {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 13px;
                font-weight: 500;
                color: #fff;
                flex-shrink: 0;
                background: linear-gradient(135deg, #7AE2CF 0%, #077A7D 100%);
            }

            .kos-badge {
                font-size: 11px;
                font-weight: 500;
                padding: 2px 8px;
                border-radius: 100px;
                margin-left: 5px;
                display: inline-flex;
            }

            .kos-admin-box {
                background: #F0F5FD;
                border-left: 2px solid #93C2F0;
                padding: 6px 10px;
                border-radius: 0 6px 6px 0;
                margin-top: 7px;
            }

            .kos-pi {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 20px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            }

            .kos-pi:last-child {
                border-bottom: none;
            }

            .kos-piico {
                width: 34px;
                height: 34px;
                border-radius: 9px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .kos-pipill {
                font-size: 11px;
                font-weight: 500;
                padding: 3px 9px;
                border-radius: 100px;
                display: inline-flex;
            }

            .kos-sid {
                background: #fff;
                border-radius: 18px;
                overflow: hidden;
                margin-bottom: 14px;
                border: 1px solid rgba(0, 0, 0, 0.04);
            }

            .kos-sid:last-child {
                margin-bottom: 0;
            }

            .kos-sid-head {
                padding: 16px 18px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .kos-sid-ico {
                width: 30px;
                height: 30px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .kos-sid-title {
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #fff;
            }

            .kos-sid-sub {
                font-size: 12px;
                font-weight: 400;
                color: rgba(255, 255, 255, 0.5);
                margin-top: 2px;
            }

            .kos-srow {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 11px 18px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            }

            .kos-srow:last-child {
                border-bottom: none;
            }

            .kos-sdot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                display: inline-block;
                flex-shrink: 0;
            }

            .kos-srlbl {
                font-size: 13px;
                font-weight: 400;
                color: rgba(0, 0, 0, 0.55);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .kos-srval {
                font-size: 14px;
                font-weight: 600;
                color: #111;
            }

            .kos-aitem {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 13px 18px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
                text-decoration: none;
                transition: background 0.1s;
            }

            .kos-aitem:last-child {
                border-bottom: none;
            }

            .kos-aitem:hover {
                background: #FAFAF8;
            }

            .kos-aico {
                width: 32px;
                height: 32px;
                border-radius: 9px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .kos-albl {
                font-size: 13px;
                font-weight: 600;
                color: #111;
            }

            .kos-asub {
                font-size: 12px;
                font-weight: 400;
                color: rgba(0, 0, 0, 0.4);
                margin-top: 2px;
            }

            /* ─── RESPONSIVE ─── */
            @media (max-width: 768px) {
                .kos-dashboard-container {
                    margin-top: 0 !important;
                }

                .kos-hero-inner {
                    padding: 40px 20px 0 !important;
                    display: flex !important;
                    flex-direction: column !important;
                }

                .kos-hero-left {
                    max-width: 100% !important;
                    order: 1 !important;
                }

                .kos-hero-floatcard {
                    position: relative !important;
                    right: auto !important;
                    top: auto !important;
                    transform: none !important;
                    width: 100% !important;
                    margin-top: 24px !important;
                    order: 2 !important;
                }

                .kos-stat-strip {
                    grid-template-columns: repeat(2, 1fr) !important;
                    order: 3 !important;
                    margin-top: 28px !important;
                }

                .kos-stat-strip>div:nth-child(2) {
                    border-left: 1px solid rgba(122, 226, 207, 0.2);
                }

                .kos-stat-strip>div:nth-child(3) {
                    border-top: 1px solid rgba(122, 226, 207, 0.2);
                    border-left: none;
                }

                .kos-stat-strip>div:nth-child(4) {
                    border-top: 1px solid rgba(122, 226, 207, 0.2);
                    border-left: 1px solid rgba(122, 226, 207, 0.2);
                }

                .kos-body-grid {
                    grid-template-columns: 1fr !important;
                    padding: 16px 16px 32px !important;
                    gap: 14px !important;
                }

                .kos-hero-name {
                    font-size: 2rem !important;
                }
            }
        </style>

        {{-- ══════════════ HERO ══════════════ --}}
        <div class="kos-hero-inner" style="background:#06202B;padding:44px 40px 0;position:relative;overflow:hidden;">

            {{-- Background noise --}}
            <div style="position:absolute;inset:0;background-image:url(\" data:image/svg+xml,%3Csvg viewBox='0 0 256 256'
                xmlns='http://www.w3.org/2000/svg' %3E%3Cfilter id='noise' %3E%3CfeTurbulence type='fractalNoise'
                baseFrequency='0.9' numOctaves='4' stitchTiles='stitch' /%3E%3C/filter%3E%3Crect width='100%25'
                height='100%25' filter='url(%23noise)' opacity='0.03' /%3E%3C/svg%3E\");pointer-events:none;opacity:0.4;">
            </div>

            {{-- Glow kiri --}}
            <div
                style="position:absolute;width:500px;height:260px;top:-60px;left:50%;transform:translateX(-30%);background:radial-gradient(ellipse,rgba(43,213,187,0.07) 0%,transparent 65%);pointer-events:none;">
            </div>

            {{-- ===== DEKORASI KANAN ===== --}}
            <div
                style="position:absolute;right:-60px;top:-80px;width:340px;height:340px;border-radius:50%;border:1px solid rgba(43,213,187,0.08);pointer-events:none;">
            </div>
            <div
                style="position:absolute;right:-20px;top:-40px;width:220px;height:220px;border-radius:50%;border:1px solid rgba(43,213,187,0.06);pointer-events:none;">
            </div>
            <div
                style="position:absolute;right:30px;top:10px;width:120px;height:120px;border-radius:50%;border:1px solid rgba(43,213,187,0.1);pointer-events:none;">
            </div>

            <svg style="position:absolute;right:0;top:0;width:280px;height:240px;pointer-events:none;opacity:0.5;"
                viewBox="0 0 280 240">
                @for($row = 0; $row < 8; $row++)
                    @for($col = 0; $col < 9; $col++)
                        <circle cx="{{ 20 + $col * 30 }}" cy="{{ 20 + $row * 30 }}" r="1.2"
                            fill="rgba(122,226,207,{{ $col > 5 ? '0.25' : ($col > 3 ? '0.12' : '0.05') }})" />
                    @endfor
                @endfor
            </svg>

            <svg style="position:absolute;right:0;top:0;width:300px;height:280px;pointer-events:none;"
                viewBox="0 0 300 280">
                <line x1="300" y1="0" x2="160" y2="280" stroke="rgba(122,226,207,0.05)" stroke-width="1" />
                <line x1="270" y1="0" x2="130" y2="280" stroke="rgba(122,226,207,0.04)" stroke-width="0.5" />
                <line x1="240" y1="0" x2="100" y2="280" stroke="rgba(122,226,207,0.03)" stroke-width="0.5" />
            </svg>

            {{-- Mini Card Status Pembayaran --}}
            <div class="kos-hero-floatcard"
                style="position:absolute;right:40px;top:38%;transform:translateY(-50%);z-index:2;width:340px;">
                <div
                    style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,0.3);">
                    <div style="display:flex;align-items:stretch;">

                        {{-- Kiri: ikon status --}}
                        @php
                            $currentMonthPaid = $recent_payments->filter(
                                fn($p) =>
                                $p->payment_date->month == now()->month &&
                                $p->payment_date->year == now()->year &&
                                $p->status === 'verified'
                            )->count() > 0;

                            $pendingThisMonth = $recent_payments->filter(
                                fn($p) =>
                                $p->payment_date->month == now()->month &&
                                $p->payment_date->year == now()->year &&
                                $p->status === 'pending'
                            )->count() > 0;

                            $statusColor = $currentMonthPaid ? '#7AE2CF' : ($pendingThisMonth ? '#e8a12a' : '#e05c5c');
                            $statusBg = $currentMonthPaid ? 'rgba(122,226,207,0.12)' : ($pendingThisMonth ? 'rgba(232,161,42,0.12)' : 'rgba(224,92,92,0.12)');
                            $statusLabel = $currentMonthPaid ? 'Lunas' : ($pendingThisMonth ? 'Menunggu' : 'Belum Bayar');
                            $statusSub = $currentMonthPaid ? 'Terverifikasi' : ($pendingThisMonth ? 'Diverifikasi' : 'Bulan ini');
                            $statusMsg = $currentMonthPaid ? 'Dikonfirmasi admin' : ($pendingThisMonth ? '⏳ Menunggu konfirmasi' : 'Upload bukti pembayaran');
                        @endphp

                        <div
                            style="width:64px;background:{{ $statusBg }};border-right:1px solid rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            @if($currentMonthPaid)
                                <svg width="22" height="22" fill="{{ $statusColor }}" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            @elseif($pendingThisMonth)
                                <svg width="22" height="22" fill="{{ $statusColor }}" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg width="22" height="22" fill="{{ $statusColor }}" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>

                        {{-- Tengah: info status --}}
                        <div style="flex:1;padding:12px 14px;">
                            <div
                                style="font-size:11px;font-weight:600;letter-spacing:0.15em;text-transform:uppercase;color:rgba(255,255,255,0.6);margin-bottom:4px;">
                                Status Pembayaran · {{ now()->translatedFormat('F Y') }}</div>
                            <div
                                style="font-size:15px;font-weight:500;color:{{ $statusColor }};line-height:1.2;margin-bottom:3px;">
                                {{ $statusLabel }}
                            </div>
                            <div style="font-size:11px;color:rgba(255,255,255,0.6);">{{ $statusSub }}</div>
                            <div
                                style="margin-top:8px;background:{{ $statusBg }};border:1px solid {{ $statusColor }}22;border-radius:5px;padding:4px 8px;font-size:11px;color:{{ $statusColor }};opacity:0.85;">
                                {{ $statusMsg }}
                            </div>
                        </div>

                        {{-- Kanan: tagihan + jam --}}
                        <div
                            style="width:100px;border-left:1px solid rgba(255,255,255,0.06);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;padding:12px 10px;flex-shrink:0;">
                            <div style="text-align:center;">
                                <div
                                    style="font-size:11px;font-weight:600;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.1em;">
                                    Tagihan</div>
                                <div
                                    style="font-size:12px;font-weight:500;color:rgba(255,255,255,0.9);font-style:italic;font-family:'DM Serif Display',serif;margin-top:2px;">
                                    Rp {{ number_format(Auth::user()->monthly_rent ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div style="width:100%;height:1px;background:rgba(255,255,255,0.06);"></div>
                            <div style="text-align:center;">
                                <div
                                    style="font-size:11px;font-weight:500;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.1em;">
                                    {{ now()->translatedFormat('d M') }}
                                </div>
                                <div style="font-size:12px;font-weight:400;color:rgba(255,255,255,0.9);margin-top:1px;font-family:monospace;"
                                    id="hero-clock">--:--</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <style>
                @keyframes rpulse {

                    0%,
                    100% {
                        opacity: 1
                    }

                    50% {
                        opacity: 0.6
                    }
                }
            </style>
            <script>
                (function () {
                    function tick() {
                        var el = document.getElementById('hero-clock');
                        if (!el) return;
                        var n = new Date();
                        el.textContent = [n.getHours(), n.getMinutes(), n.getSeconds()].map(v => String(v).padStart(2, '0')).join(':');
                    }
                    tick(); setInterval(tick, 1000);
                })();
            </script>

            {{-- Konten kiri --}}
            <div class="kos-hero-left" style="position:relative;z-index:1;max-width:60%;">
                <div
                    style="font-size:11px;font-weight:700;letter-spacing:0.25em;text-transform:uppercase;color:#7AE2CF;margin-bottom:16px;text-shadow:0 0 15px rgba(122,226,207,0.5);">
                    ✦ Pusat Informasi
                </div>
                <div
                    style="font-size:17px;font-weight:400;color:rgba(255,255,255,0.75);margin-bottom:8px;letter-spacing:0.01em;">
                    Selamat datang kembali 👋
                </div>
                @php $nameParts = explode(' ', Auth::user()->name); @endphp
                <div class="kos-hero-name"
                    style="font-family:'Instrument Serif',Georgia,serif;font-size:2.6rem;color:#FFFFFF;line-height:1.05;margin-bottom:2rem;font-weight:400;letter-spacing:-0.5px;text-shadow:0 0 25px rgba(255,255,255,0.1);">
                    {{ $nameParts[0] ?? '' }}
                    <span
                        style="font-style:italic;color:#7AE2CF;text-shadow:0 0 15px rgba(122,226,207,0.4);">{{ implode(' ', array_slice($nameParts, 1)) }}</span>
                </div>

                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span class="kos-hchip">
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kamar {{ Auth::user()->room_number ?? 'Belum Diset' }}
                    </span>
                    <span class="kos-hchip">
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Rp {{ number_format(Auth::user()->monthly_rent ?? 0, 0, ',', '.') }} / bln
                    </span>
                </div>
            </div>

            {{-- Stat Strip --}}
            <div class="kos-stat-strip"
                style="display:grid;grid-template-columns:repeat(4,1fr);margin-top:32px;border-top:1px solid rgba(122,226,207,0.4);box-shadow:0 -1px 12px rgba(122,226,207,0.15);position:relative;z-index:1;">
                @php
                    $strips = [
                        ['lbl' => 'Total Bayar', 'val' => $stats['total_payments'] ?? 0, 'color' => '#fff', 'tag' => 'transaksi', 'tagcolor' => 'rgba(255,255,255,0.6)'],
                        ['lbl' => 'Terverifikasi', 'val' => $stats['verified_payments'] ?? 0, 'color' => '#7AE2CF', 'tag' => 'selesai', 'tagcolor' => 'rgba(122,226,207,0.6)'],
                        ['lbl' => 'Pending', 'val' => $stats['pending_payments'] ?? 0, 'color' => '#e8a12a', 'tag' => 'menunggu', 'tagcolor' => 'rgba(232,161,42,0.7)'],
                        ['lbl' => 'Keluhan Aktif', 'val' => $stats['total_complaints'] ?? 0, 'color' => '#e05c5c', 'tag' => 'tiket', 'tagcolor' => 'rgba(224,92,92,0.7)'],
                    ];
                @endphp
                @foreach($strips as $s)
                    <div style="padding:24px 28px;{{ !$loop->first ? 'border-left:1px solid rgba(122,226,207,0.2);' : '' }}">
                        <div
                            style="font-size:11px;font-weight:600;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.15em;margin-bottom:8px;">
                            {{ $s['lbl'] }}
                        </div>
                        <div
                            style="font-family:'DM Serif Display',serif;font-size:2.6rem;color:{{ $s['color'] }};line-height:1;letter-spacing:-1px;">
                            {{ $s['val'] }}
                        </div>
                        <div
                            style="font-size:11px;font-weight:500;color:{{ $s['tagcolor'] }};margin-top:8px;letter-spacing:0.04em;">
                            {{ $s['tag'] }}
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- ══════════════ BODY GRID ══════════════ --}}
        <div class="kos-body-grid" style="display:grid;grid-template-columns:1fr 255px;gap:18px;padding:22px 40px 44px;">

            {{-- LEFT MAIN --}}
            <div>

                {{-- Keluhan Umum --}}
                <div class="kos-card">
                    <div class="kos-card-head">
                        <div class="kos-chead-l">
                            <div class="kos-cicon" style="background:#E8F8F4;">
                                <svg width="15" height="15" fill="none" stroke="#1a9e8a" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="kos-ctitle">Keluhan Umum Kos</div>
                                <div class="kos-csub">Laporan dari seluruh penghuni</div>
                            </div>
                        </div>
                        <a href="{{ route('user.public-complaints') }}" class="kos-see-all">Lihat semua →</a>
                    </div>

                    <div class="kos-mstats">
                        <div class="kos-msitem">
                            <div class="kos-msico" style="background:#F2F2F0;">
                                <svg width="12" height="12" fill="none" stroke="rgba(0,0,0,0.35)" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div class="kos-msval">{{ $public_stats['total_public_complaints'] ?? 0 }}</div>
                            <div class="kos-mslbl">Total</div>
                        </div>
                        <div class="kos-msitem">
                            <div class="kos-msico" style="background:#FEF0EF;">
                                <svg width="12" height="12" fill="#e05c5c" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="kos-msval">{{ $public_stats['open_public_complaints'] ?? 0 }}</div>
                            <div class="kos-mslbl">Belum ditangani</div>
                        </div>
                        <div class="kos-msitem">
                            <div class="kos-msico" style="background:#E8F8F4;">
                                <svg width="12" height="12" fill="#1a9e8a" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="kos-msval">{{ $public_stats['resolved_public_complaints'] ?? 0 }}</div>
                            <div class="kos-mslbl">Sudah ditangani</div>
                        </div>
                    </div>

                    @forelse($public_complaints ?? [] as $complaint)
                        <a href="{{ route('user.public-complaint-show', $complaint) }}" class="kos-ci">
                            <div class="kos-avatar">{{ strtoupper(substr($complaint->user->name, 0, 1)) }}</div>
                            <div style="flex:1;min-width:0;">
                                <div style="display:flex;align-items:center;flex-wrap:wrap;gap:4px;">
                                    <span
                                        style="font-size:14px;font-weight:600;color:#111;line-height:1.4;">{{ $complaint->subject }}</span>
                                    @if($complaint->status === 'resolved')
                                        <span class="kos-badge"
                                            style="background:#E8F8F4;color:#1a9e8a;font-size:11px;">Selesai</span>
                                    @elseif($complaint->status === 'in_progress')
                                        <span class="kos-badge"
                                            style="background:#EDF3FE;color:#3b6fc4;font-size:11px;">Diproses</span>
                                    @else
                                        <span class="kos-badge"
                                            style="background:#FEF0EF;color:#e05c5c;font-size:11px;">Menunggu</span>
                                    @endif
                                    @if($complaint->priority === 'high')
                                        <span class="kos-badge"
                                            style="background:#FFF3E0;color:#c97b1a;font-size:11px;">Urgent</span>
                                    @endif
                                </div>
                                <div style="font-size:12px;font-weight:400;color:rgba(0,0,0,0.45);margin-top:3px;">
                                    {{ $complaint->user->name }} · Kamar {{ $complaint->user->room_number ?? '-' }} ·
                                    {{ $complaint->category_label }}
                                </div>
                                <div
                                    style="font-size:13px;font-weight:400;color:rgba(0,0,0,0.55);margin-top:5px;line-height:1.6;">
                                    {{ Str::limit($complaint->description, 110) }}
                                </div>
                                @if($complaint->admin_response)
                                    <div class="kos-admin-box">
                                        <div
                                            style="font-size:10px;font-weight:500;color:#3b6fc4;text-transform:uppercase;letter-spacing:0.08em;">
                                            Respon admin</div>
                                        <div style="font-size:11px;font-weight:300;color:#3b6fc4;margin-top:2px;opacity:0.85;">
                                            {{ Str::limit($complaint->admin_response, 80) }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <svg style="width:13px;height:13px;color:rgba(0,0,0,0.18);flex-shrink:0;" fill="none"
                                stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @empty
                        <div style="text-align:center;padding:32px 16px;">
                            <svg style="width:28px;height:28px;color:rgba(0,0,0,0.18);margin:0 auto 8px;display:block;"
                                fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p style="font-size:13px;font-weight:300;color:rgba(0,0,0,0.45);">Belum ada keluhan umum</p>
                            <small
                                style="font-size:11px;font-weight:300;color:rgba(0,0,0,0.28);display:block;margin-top:3px;">Keluhan
                                dari penghuni kos akan muncul di sini</small>
                        </div>
                    @endforelse
                </div>

                {{-- Riwayat Pembayaran --}}
                <div class="kos-card">
                    <div class="kos-card-head">
                        <div class="kos-chead-l">
                            <div class="kos-cicon" style="background:#E8F8F4;">
                                <svg width="15" height="15" fill="none" stroke="#1a9e8a" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="kos-ctitle">Riwayat Pembayaran</div>
                                <div class="kos-csub">Transaksi sewa kamar Anda</div>
                            </div>
                        </div>
                        <a href="{{ route('user.payments') }}" class="kos-see-all">Lihat semua →</a>
                    </div>

                    @forelse($recent_payments ?? [] as $payment)
                        <div class="kos-pi">
                            <div class="kos-piico" @if($payment->status === 'verified') style="background:#E8F8F4;"
                            @elseif($payment->status === 'rejected') style="background:#FEF0EF;" @else
                                style="background:#FFF8EC;" @endif>
                                @if($payment->status === 'verified')
                                    <svg width="13" height="13" fill="#1a9e8a" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @elseif($payment->status === 'rejected')
                                    <svg width="13" height="13" fill="#e05c5c" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg width="13" height="13" fill="#e8a12a" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:14px;font-weight:600;color:#111;">Rp
                                    {{ number_format($payment->amount, 0, ',', '.') }}</div>
                                <div style="font-size:12px;font-weight:400;color:rgba(0,0,0,0.45);margin-top:2px;">
                                    {{ $payment->payment_date->format('d F Y') }}
                                </div>
                            </div>
                            @if($payment->status === 'verified')
                                <span class="kos-pipill" style="background:#E8F8F4;color:#1a9e8a;">Terverifikasi</span>
                            @elseif($payment->status === 'rejected')
                                <span class="kos-pipill" style="background:#FEF0EF;color:#e05c5c;">Ditolak</span>
                            @else
                                <span class="kos-pipill" style="background:#FFF8EC;color:#e8a12a;">Pending</span>
                            @endif
                        </div>
                    @empty
                        <div style="text-align:center;padding:28px 16px;">
                            <svg style="width:28px;height:28px;color:rgba(0,0,0,0.18);margin:0 auto 7px;display:block;"
                                fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p style="font-size:13px;font-weight:300;color:rgba(0,0,0,0.45);">Belum ada riwayat pembayaran</p>
                            <small
                                style="font-size:11px;font-weight:300;color:rgba(0,0,0,0.28);display:block;margin-top:3px;">Transaksi
                                Anda akan muncul di sini</small>
                        </div>
                    @endforelse
                </div>

            </div>

            {{-- RIGHT SIDEBAR --}}
            <div>

                {{-- Statistik Pribadi --}}
                <div class="kos-sid">
                    <div class="kos-sid-head" style="background:linear-gradient(135deg,#7AE2CF 0%,#077A7D 100%);">
                        <div class="kos-sid-ico" style="background:rgba(0,0,0,0.12);">
                            <svg width="14" height="14" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="kos-sid-title">Statistik Pribadi</div>
                            <div class="kos-sid-sub">Ringkasan akun Anda</div>
                        </div>
                    </div>
                    <div style="padding:5px 18px 3px;background:#FAFAF8;border-bottom:1px solid rgba(0,0,0,0.04);">
                        <span
                            style="font-size:10px;font-weight:400;color:rgba(0,0,0,0.25);text-transform:uppercase;letter-spacing:0.2em;">Ringkasan</span>
                    </div>
                    @php
                        $statRows = [
                            ['dot' => '#3b82f6', 'label' => 'Total pembayaran', 'val' => $stats['total_payments'] ?? 0],
                            ['dot' => '#7AE2CF', 'label' => 'Terverifikasi', 'val' => $stats['verified_payments'] ?? 0],
                            ['dot' => '#e8a12a', 'label' => 'Pending', 'val' => $stats['pending_payments'] ?? 0],
                            ['dot' => '#e05c5c', 'label' => 'Keluhan saya', 'val' => $stats['total_complaints'] ?? 0],
                            ['dot' => '#f97316', 'label' => 'Keluhan terbuka', 'val' => $stats['open_complaints'] ?? 0],
                        ];
                    @endphp
                    @foreach($statRows as $r)
                        <div class="kos-srow">
                            <span class="kos-srlbl">
                                <span class="kos-sdot" style="background:{{ $r['dot'] }};"></span>
                                {{ $r['label'] }}
                            </span>
                            <span class="kos-srval">{{ $r['val'] }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Aksi Cepat --}}
                <div class="kos-sid">
                    <div class="kos-sid-head" style="background:#000C14;">
                        <div class="kos-sid-ico" style="background:rgba(43,213,187,0.12);">
                            <svg width="14" height="14" fill="none" stroke="#2BD5BB" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="kos-sid-title">Aksi Cepat</div>
                            <div class="kos-sid-sub">Navigasi singkat</div>
                        </div>
                    </div>
                    <a href="{{ route('user.payments.create') }}" class="kos-aitem">
                        <div class="kos-aico" style="background:#EDF3FE;">
                            <svg width="14" height="14" fill="none" stroke="#3b6fc4" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <div>
                            <div class="kos-albl">Upload bukti pembayaran</div>
                            <div class="kos-asub">Kirim bukti transfer</div>
                        </div>
                        <svg style="width:13px;height:13px;color:rgba(0,0,0,0.18);margin-left:auto;flex-shrink:0;"
                            fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('user.complaints.create') }}" class="kos-aitem">
                        <div class="kos-aico" style="background:#FEF0EF;">
                            <svg width="14" height="14" fill="#e05c5c" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="kos-albl">Ajukan keluhan</div>
                            <div class="kos-asub">Laporkan masalah</div>
                        </div>
                        <svg style="width:13px;height:13px;color:rgba(0,0,0,0.18);margin-left:auto;flex-shrink:0;"
                            fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('user.public-complaints') }}" class="kos-aitem">
                        <div class="kos-aico" style="background:#F0EFFE;">
                            <svg width="14" height="14" fill="#7c3aed" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                            </svg>
                        </div>
                        <div>
                            <div class="kos-albl">Lihat keluhan umum</div>
                            <div class="kos-asub">Keluhan penghuni lain</div>
                        </div>
                        <svg style="width:13px;height:13px;color:rgba(0,0,0,0.18);margin-left:auto;flex-shrink:0;"
                            fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection