<!DOCTYPE html>
<html>
<head>
    <title>Kasir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f5f7fb;
    margin: 0;
}

/* SIDEBAR */
.sidebar {
    width: 240px;
    height: 100vh;
    background: #3f4b5f;
    position: fixed;
    left: 0;
    top: 0;
    color: white;
    display: flex;
    flex-direction: column;
}

.logo {
    padding: 20px;
    text-align: center;
}

.menu {
    flex: 1;
    padding: 10px;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 12px;
    color: #d1d5db;
    text-decoration: none;
    border-radius: 10px;
    margin-bottom: 6px;
}

.menu-item:hover {
    background: #4f46e5;
    color: white;
}

.menu-item span {
    margin-left: 10px;
}

.content {
    margin-left: 240px;
    padding: 20px;
}

/* CARD */
.card-clean {
    border: none;
    border-radius: 16px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.06);
}

/* STEP */
.step { display: none; }
.step.active { display: block; }

.step-nav span {
    padding: 8px 14px;
    border-radius: 10px;
    background: #e5e7eb;
    margin-right: 6px;
    cursor: pointer;
}

.step-nav .active {
    background: #4f46e5;
    color: white;
}

/* INPUT */
.input-clean {
    border-radius: 10px;
    height: 44px;
}

/* TERAPIS */
.terapis-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px,1fr));
    gap: 15px;
}

.terapis-card {
    border-radius: 12px;
    overflow: hidden;
    background: white;
    cursor: pointer;
}

.terapis-card img {
    width: 100%;
    height: 140px;
    object-fit: cover;
}

.terapis-card.active {
    border: 2px solid #4f46e5;
}

.terapis-card.booked {
    background: #fee2e2;
    cursor: not-allowed;
}

/* ROOM */
.room-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(90px,1fr));
    gap: 12px;
}

.room-card {
    height: 70px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
}

.room-card.available { background: #22c55e; }
.room-card.booked { background: #ef4444; }
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">
        <h5>Radja</h5>
        <small>Reflexy & Pijat keluarga</small>
    </div>

    <div class="menu">
        <a href="/kasir" class="menu-item active">🏠 <span>Halaman Awal</span></a>
        <a href="#" class="menu-item">💰 <span>Transaksi</span></a>
        <a href="#" class="menu-item">👥 <span>Member</span></a>
        <a href="#" class="menu-item">👤 <span>Karyawan</span></a>
        <a href="#" class="menu-item">💳 <span>Keuangan</span></a>
        <a href="#" class="menu-item">📦 <span>Gudang</span></a>
        <a href="#" class="menu-item">🏷️ <span>Produk</span></a>
    </div>
</div>

<!-- CONTENT -->
<div class="content">

<!-- FORM -->
<div class="card card-clean">
<div class="card-body">

<h5 class="mb-4">Input Booking</h5>

<div class="step-nav mb-4">
    <span class="active">Tamu</span>
    <span>Layanan</span>
    <span>Waktu</span>
    <span>Terapis</span>
    <span>Ruangan</span>
    <!-- ================== RUANGAN ================== -->

@php
$lantai = [
    'LT 1' => [
        ['nama'=>'A1','status'=>'Terisi','terapis'=>'Budi','tamu'=>'Andi','waktu'=>'10:00'],
        ['nama'=>'A2','status'=>'Kosong','terapis'=>'-','tamu'=>'-','waktu'=>'-'],
        ['nama'=>'A3','status'=>'Terisi','terapis'=>'Siti','tamu'=>'Rina','waktu'=>'11:00'],
    ],
    'LT 2' => [
        ['nama'=>'B1','status'=>'Kosong','terapis'=>'-','tamu'=>'-','waktu'=>'-'],
        ['nama'=>'B2','status'=>'Terisi','terapis'=>'Dewi','tamu'=>'Rudi','waktu'=>'12:00'],
    ],
    'LT 3' => [
        ['nama'=>'C1','status'=>'Kosong','terapis'=>'-','tamu'=>'-','waktu'=>'-'],
        ['nama'=>'C2','status'=>'Kosong','terapis'=>'-','tamu'=>'-','waktu'=>'-'],
    ]
];
@endphp


@foreach($lantai as $namaLantai => $kamers)

<div class="mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center">
        <h5>Ruangan {{ $namaLantai }}</h5>
        <button class="btn btn-sm btn-outline-primary"
            onclick="toggleLantai('{{ str_replace(' ', '', $namaLantai) }}')">
            Tampilkan
        </button>
    </div>

    <!-- GRID -->
    <div id="lantai{{ str_replace(' ', '', $namaLantai) }}" class="room-grid mt-2" style="display:none">

        @foreach($kamers as $k)
        <div class="room-card {{ $k['status']=='Terisi' ? 'booked' : 'available' }}"
            onclick="showKamar({
                nama: '{{ $k['nama'] }}',
                status: '{{ $k['status'] }}',
                terapis: '{{ $k['terapis'] }}',
                tamu: '{{ $k['tamu'] }}',
                waktu: '{{ $k['waktu'] }}',
                lantai: '{{ $namaLantai }}'
            })">

            {{ $k['nama'] }}

        </div>
        @endforeach

    </div>

</div>

@endforeach
    <span>Review</span>
</div>

<form action="{{ route('kasir.store') }}" method="POST">
@csrf

<!-- STEP 1 -->
<div class="step active">
    <div class="row">
        <div class="col-md-6">
            <select name="member_id" class="form-control input-clean">
                <option value="">Non Member</option>
                @foreach($members as $m)
                <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <input type="text" name="nama_tamu" class="form-control input-clean" placeholder="Nama tamu">
        </div>
    </div>
</div>

<!-- STEP 2 -->
<div class="step">
    <select name="layanan_id" class="form-control input-clean">
        @foreach($layanans as $l)
        <option value="{{ $l->id }}">
            {{ $l->nama }} - {{ number_format($l->harga) }}
        </option>
        @endforeach
    </select>
</div>

<!-- STEP 3 -->
<div class="step">
    <input type="datetime-local" name="waktu" class="form-control input-clean">
</div>

<!-- STEP 4 -->
<div class="step">
    <div class="terapis-grid">

        @foreach($terapis as $t)
        <div class="terapis-card" onclick="selectTerapis(this, {{ $t->id }})">
            <img src="{{ $t->foto ?? 'https://i.pravatar.cc/300' }}">
            <div class="text-center p-2">{{ $t->nama }}</div>
        </div>
        @endforeach

    </div>

    <input type="hidden" name="terapis_id" id="terapis_id">
</div>

<!-- STEP 5 -->
<div class="step">
    <div class="room-grid">
        @foreach($kamars as $k)
        <div class="room-card available">{{ $k->nama }}</div>
        @endforeach
    </div>
</div>

<!-- STEP 6 -->
<div class="step">
    <p>Review sebelum simpan</p>
</div>

<div class="d-flex justify-content-between mt-4">
    <button type="button" class="btn btn-secondary" onclick="prevStep()">←</button>

    <div>
        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</div>

</form>

</div>
</div>

<!-- BAWAH -->
<div class="row mt-4">

<!-- KIRI -->
<div class="col-md-4">
<div class="card card-clean">
<div class="card-body">

<h6>Transaksi Belum Dibayar</h6>

@php $pending = $transaksis->where('status','pending'); @endphp

@if($pending->count())
    <ul class="list-group mb-3">
        @foreach($pending->take(3) as $p)
        <li class="list-group-item d-flex justify-content-between">
            {{ $p->nama_tamu }}
            <span>{{ number_format($p->harga) }}</span>
        </li>
        @endforeach
    </ul>

    <form action="{{ route('kasir.bayar',$pending->first()->id) }}" method="POST">
        @csrf
        <button class="btn w-100 text-white" style="background:#6366f1;">
            Bayar
        </button>
    </form>
@endif

</div>
</div>
</div>

<!-- KANAN -->
<div class="col-md-8">
<div class="card card-clean">
<div class="card-body">

<h6>Status Transaksi</h6>

<table class="table">
<thead>
<tr>
<th>Waktu</th>
<th>Tamu</th>
<th>Terapis</th>
<th>Kamar</th>
<th>Status</th>
</tr>
</thead>

<tbody>
@foreach($transaksis as $t)
<tr>
<td>{{ $t->waktu }}</td>
<td>{{ $t->nama_tamu }}</td>
<td>{{ $t->terapis->nama ?? '-' }}</td>
<td>{{ $t->kamar->nama ?? '-' }}</td>
<td>{{ $t->status }}</td>
</tr>
@endforeach
</tbody>

</table>

</div>
</div>
</div>

</div>

</div>

<script>
let currentStep = 0;

function showStep(i){
    let s=document.querySelectorAll('.step');
    let n=document.querySelectorAll('.step-nav span');

    s.forEach((e,x)=>{
        e.classList.remove('active');
        n[x].classList.remove('active');

        if(x===i){
            e.classList.add('active');
            n[x].classList.add('active');
        }
    });
}

function nextStep(){ if(currentStep<5){currentStep++;showStep(currentStep);} }
function prevStep(){ if(currentStep>0){currentStep--;showStep(currentStep);} }

function selectTerapis(el,id){
    document.querySelectorAll('.terapis-card').forEach(e=>e.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('terapis_id').value=id;
}

showStep(currentStep);
</script>

</body>
</html>