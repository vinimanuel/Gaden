@php
  $label = $barang->status_label;
  $badges = [
    'ditebus'     => ['class' => 'b-blue',  'dot' => true, 'text' => 'Ditebus'],
    'lewat'       => ['class' => 'b-red',   'dot' => true, 'text' => 'Lewat JT'],
    'jatuh_tempo' => ['class' => 'b-amber', 'dot' => true, 'text' => 'Jatuh Tempo'],
    'aktif'       => ['class' => 'b-green', 'dot' => true, 'text' => 'Aktif'],
  ];
  $badge = $badges[$label] ?? $badges['aktif'];
@endphp
<span class="badge {{ $badge['class'] }}">
  @if($badge['dot'])<span class="dot"></span>@endif
  {{ $badge['text'] }}
</span>
