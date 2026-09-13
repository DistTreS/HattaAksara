@extends('layouts.alumni')

@section('title', 'Direktori Jejaring Alumni')
@section('page_title', 'Direktori Jejaring Hatta Muda Connection')

@push('styles')
<style>
    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 14px;
        align-items: center;
    }
    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<div style="margin-bottom: 24px;">
    <h2 style="font-family: var(--font-display); font-size: 1.4rem; color: #0f172a; margin-bottom: 4px;">
        Jejaring Pemimpin Muda Se-Indonesia
    </h2>
    <p style="color: #64748b; font-size: 0.9rem;">
        Temukan dan terhubung dengan sesama alumni pelatihan ISLT dari berbagai angkatan dan provinsi. Hubungi melalui media sosial atau kontak profesional.
    </p>
</div>

<!-- Filter Bar -->
<div style="background: white; border-radius: 14px; padding: 20px; border: 1px solid var(--border-color); margin-bottom: 30px;">
    <form action="{{ route('alumni.networking') }}" method="GET" class="filter-grid">
        <div>
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, sekolah, kampus, atau kota..." class="form-control" style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:8px;">
        </div>
        <div>
            <select name="prov" class="form-control" style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:8px;">
                <option value="">-- Semua Provinsi --</option>
                @foreach($provinces as $p)
                    <option value="{{ $p }}" {{ $selectedProvince === $p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="batch" class="form-control" style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:8px;">
                <option value="">-- Semua Angkatan --</option>
                @foreach($batches as $b)
                    <option value="{{ $b }}" {{ $selectedBatch === $b ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">
                <i class="fa-solid fa-filter"></i> Saring
            </button>
        </div>
    </form>
</div>

<!-- Alumni Cards Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
    @forelse($alumniMembers as $member)
        @php
            $prof = $member->alumniProfile;
        @endphp
        <div style="background: white; border-radius: 16px; border: 1px solid var(--border-color); padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
            <div>
                <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 16px;">
                    <div style="width: 54px; height: 54px; border-radius: 50%; background: linear-gradient(135deg, var(--maroon-primary), var(--maroon-deep)); border: 2px solid var(--gold-primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; flex-shrink: 0;">
                        {{ substr($member->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 3px;">{{ $member->name }}</h3>
                        <span style="font-size: 0.76rem; background: rgba(197, 155, 39, 0.15); color: var(--gold-dark); font-weight: 700; padding: 2px 8px; border-radius: 10px;">
                            {{ $prof?->islt_batch ?? 'Alumni ISLT' }}
                        </span>
                    </div>
                </div>

                <div style="font-size: 0.84rem; color: #475569; display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px;">
                    <div><i class="fa-solid fa-location-dot" style="color:#ef4444; width:18px;"></i> {{ $prof?->city ?? '-' }}, {{ $prof?->province ?? '-' }}</div>
                    <div><i class="fa-solid fa-school" style="color:#0284c7; width:18px;"></i> Asal: {{ $prof?->school_origin ?? '-' }}</div>
                    @if($prof?->current_institution)
                        <div><i class="fa-solid fa-building-columns" style="color:#10b981; width:18px;"></i> {{ $prof->current_institution }}</div>
                    @endif
                </div>

                @if($prof?->bio)
                    <p style="font-size: 0.82rem; color: #64748b; line-height: 1.5; margin-bottom: 18px; font-style: italic;">
                        "{{ Str::limit($prof->bio, 100) }}"
                    </p>
                @endif
            </div>

            <!-- External Contacts -->
            <div style="padding-top: 14px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 8px;">
                    @if($prof?->linkedin_url)
                        <a href="{{ $prof->linkedin_url }}" target="_blank" class="btn btn-outline btn-sm" title="LinkedIn" style="padding: 4px 8px; color:#0A66C2;">
                            <i class="fa-brands fa-linkedin"></i>
                        </a>
                    @endif
                    @if($prof?->instagram_url)
                        @php
                            $ig = ltrim($prof->instagram_url, '@');
                        @endphp
                        <a href="https://instagram.com/{{ $ig }}" target="_blank" class="btn btn-outline btn-sm" title="Instagram" style="padding: 4px 8px; color:#E1306C;">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                    @if($prof?->is_phone_public && $prof?->phone_number)
                        @php
                            $wa = preg_replace('/[^0-9]/', '', $prof->phone_number);
                            if (str_starts_with($wa, '0')) {
                                $wa = '62' . substr($wa, 1);
                            }
                        @endphp
                        <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn btn-outline btn-sm" title="WhatsApp" style="padding: 4px 8px; color:#25D366;">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    @endif
                </div>

                <span style="font-size: 0.74rem; color: #94a3b8;">
                    <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> Terverifikasi
                </span>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: white; border-radius: 16px; border: 1px dashed var(--border-color);">
            <i class="fa-solid fa-users" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 12px;"></i>
            <h3 style="color: #334155; margin-bottom: 4px;">Tidak ada rekan alumni yang cocok</h3>
            <p style="color: #64748b; font-size: 0.9rem;">Coba sesuaikan filter pencarian wilayah atau angkatan.</p>
        </div>
    @endforelse
</div>

<div style="margin-top: 35px;">
    {{ $alumniMembers->links() }}
</div>

@endsection
