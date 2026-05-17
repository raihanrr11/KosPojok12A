@extends('user.layout')

@section('content')
    <div style="background: var(--color-background-tertiary, #FFF9EB); min-height: 100vh; padding-bottom: 48px;">
        {{-- Hero Banner Split Layout --}}
        <div
            style="background: #000811; display: flex; align-items: stretch; min-height: 320px; width: 100%; overflow: hidden;">

            {{-- Kiri: Teks --}}
            <div
                style="flex: 1; padding: 40px 48px; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; gap: 12px; min-width: 0;">
                {{-- Badge --}}
                <span
                    style="background: rgba(43,213,187,0.12); color: #2BD5BB; font-size: 10px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; padding: 4px 12px; border-radius: 999px; border: 0.5px solid rgba(43,213,187,0.3);">
                    Profile Kos
                </span>
                {{-- Nama Kos --}}
                <h1
                    style="font-size: 26px; font-weight: 700; color: #2BD5BB; margin: 0; letter-spacing: 0.06em; text-transform: uppercase; line-height: 1.2;">
                    {{ $info['dorm_name'] ?? 'Nama Kos' }}
                </h1>
                {{-- Deskripsi --}}
                @if($info['dorm_description'])
                    <p style="font-size: 13px; color: rgba(255,255,255,0.45); margin: 0; line-height: 1.7; max-width: 300px;">
                        {{ $info['dorm_description'] }}
                    </p>
                    <p style="font-size: 13px; color: rgba(255,255,255,0.45); margin: 0; line-height: 1.7; max-width: 300px;">
                        Nikmati kenyamanan tinggal di kos dengan lokasi strategis yang memudahkan aktivitas harian.
                    </p>
                @endif
                {{-- Garis aksen --}}
                <div style="width: 40px; height: 2px; background: #2BD5BB; opacity: 0.5; border-radius: 999px;"></div>
            </div>

            {{-- Kanan: Foto --}}
            <div style="flex: 1.2; padding: 20px 20px 20px 0; display: flex; align-items: center; min-width: 0;">
                @if(file_exists(public_path('images/foto-kos.jpg')))
                    <div style="width: 100%; border-radius: 12px; overflow: hidden; aspect-ratio: 4/3;">
                        <img src="{{ asset('images/foto-kos.jpg') }}" alt="Foto Kos"
                            style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                @else
                    <div style="width: 100%; border-radius: 12px; aspect-ratio: 4/3; background: #111820;"></div>
                @endif
            </div>

        </div>

        {{-- Konten utama --}}
        <div style="max-width:680px;margin:0 auto;padding:0 16px;">
            {{-- Divider Label --}}
            @php
                $divider = fn($label) => '
                                                <div style="display:flex;align-items:center;gap:12px;margin:24px 0 12px;">
                                                    <hr style="flex:1;border:none;border-top:0.5px solid rgba(0,8,17,0.1);">
                                                    <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:#1D9E75;">' . $label . '</span>
                                                    <hr style="flex:1;border:none;border-top:0.5px solid rgba(0,8,17,0.1);">
                                                </div>';
            @endphp

            {!! $divider('Lokasi & Jam') !!}
            {{-- Lokasi & Jam --}}
            <div
                style="background:#fff;border:0.5px solid rgba(0,8,17,0.08);border-radius:12px;display:flex;overflow:hidden;">
                @if($info['dorm_address'] || $info['dorm_city'])
                    <div
                        style="flex:1;padding:16px 20px;{{ $info['dorm_open_hours'] ? 'border-right:0.5px solid rgba(0,8,17,0.07);' : '' }}">
                        <div
                            style="width:36px;height:36px;border-radius:8px;background:#E1F5EE;border:0.5px solid #9FE1CB;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                            <svg width="16" height="16" fill="none" stroke="#1D9E75" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p
                            style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:#aaa;margin-bottom:2px;">
                            Alamat</p>
                        <p style="font-size:14px;font-weight:600;color:#000811;">{{ $info['dorm_address'] ?? '-' }}</p>
                        @if($info['dorm_city'])
                            <p style="font-size:12px;color:#999;margin-top:2px;">{{ $info['dorm_city'] }}</p>
                        @endif
                    </div>
                @endif

                @if($info['dorm_open_hours'])
                    <div style="flex:1;padding:16px 20px;">
                        <div
                            style="width:36px;height:36px;border-radius:8px;background:#E1F5EE;border:0.5px solid #9FE1CB;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                            <svg width="16" height="16" fill="none" stroke="#1D9E75" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p
                            style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:#aaa;margin-bottom:2px;">
                            Jam Operasional</p>
                        <p style="font-size:14px;font-weight:600;color:#000811;">{{ $info['dorm_open_hours'] }}</p>
                        <p style="font-size:12px;color:#999;margin-top:2px;">Setiap hari</p>
                    </div>
                @endif
            </div>

            {!! $divider('Kontak') !!}
            {{-- Grid Kontak --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                {{-- WhatsApp --}}
                @if($info['dorm_whatsapp'])
                    <div class="rounded-2xl p-5 flex flex-col items-center text-center gap-2"
                        style="background:#fff; border:1px solid rgba(0,8,17,0.08);">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden flex-shrink-0">
                            <img src="{{ asset('images/logo-whatsapp.png') }}" alt="WhatsApp"
                                style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <p class="text-xs font-black uppercase tracking-widest" style="color:#bbb;">WhatsApp</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $info['dorm_whatsapp']) }}" target="_blank"
                            class="text-sm font-bold hover:underline" style="color:#1aab55;">{{ $info['dorm_whatsapp'] }}</a>
                    </div>
                @endif

                {{-- Email --}}
                @if($info['dorm_email'])
                    <div class="rounded-2xl p-5 flex flex-col items-center text-center gap-2"
                        style="background:#fff; border:1px solid rgba(0,8,17,0.08);">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                            style="background:#fff; border:1px solid rgba(0,0,0,0.1);">
                            <img src="{{ asset('images/logo-gmail.png') }}" alt="Gmail"
                                style="width:36px; height:auto; object-fit:cover;">
                        </div>
                        <p class="text-xs font-black uppercase tracking-widest" style="color:#bbb;">Email</p>
                        <a href="mailto:{{ $info['dorm_email'] }}" class="text-sm font-bold hover:underline break-all"
                            style="color:#d93025;">{{ $info['dorm_email'] }}</a>
                    </div>
                @endif
            </div>

            {{-- Rekening Bank --}}
            @if($info['dorm_bank_name'] || $info['dorm_bank_account_no'])
                {!! $divider('Rekening Pembayaran') !!}
                <div
                    style="background:#000811;border:0.5px solid rgba(43,213,187,0.2);border-radius:12px;padding:20px;display:flex;align-items:center;gap:20px;">
                    <div
                        style="width:56px;height:56px;border-radius:12px;background:#fff;border:0.5px solid rgba(0,8,17,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                        <img src="{{ asset('images/logo-bca.png') }}" alt="{{ $info['dorm_bank_name'] ?? 'Bank' }}"
                            style="width:44px;height:44px;object-fit:cover;">
                    </div>
                    <div style="flex:1;">
                        <p
                            style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:rgba(255,255,255,0.35);margin-bottom:4px;">
                            {{ $info['dorm_bank_name'] ?? 'Rekening Bank' }}
                        </p>
                        @if($info['dorm_bank_account_no'])
                            <p style="font-size:20px;font-weight:700;color:#2BD5BB;font-family:monospace;letter-spacing:0.1em;">
                                {{ $info['dorm_bank_account_no'] }}
                            </p>
                        @endif
                        @if($info['dorm_bank_account_name'])
                            <p style="font-size:12px;color:rgba(255,255,255,0.4);margin-top:2px;">
                                a.n. {{ $info['dorm_bank_account_name'] }}
                            </p>
                        @endif
                    </div>
                    @if($info['dorm_bank_account_no'])
                        <button
                            onclick="navigator.clipboard.writeText('{{ $info['dorm_bank_account_no'] }}').then(()=>{ this.textContent='Disalin!'; setTimeout(()=>this.textContent='Salin',2000) })"
                            style="background:#2BD5BB;color:#000811;border:none;border-radius:8px;font-size:12px;font-weight:700;padding:8px 16px;cursor:pointer;flex-shrink:0;">
                            Salin
                        </button>
                    @endif
                </div>
            @endif

        </div>
    </div>
@endsection