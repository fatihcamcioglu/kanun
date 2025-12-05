@props(['url'])
@php
    $appUrl = rtrim(config('app.url'), '/');
    // Logo PNG dosyasının direkt URL'sini kullanıyoruz
    $logoUrl = $appUrl . '/logo.png';
@endphp
<tr>
<td class="header" style="text-align: center; padding: 20px 0; background-color: #ffffff;">
<a href="{{ $url ?? $appUrl }}" style="display: inline-block; text-decoration: none;">
<img src="{{ $logoUrl }}" class="logo" alt="Kanun-i Logo" style="max-width: 200px; height: auto; display: block; margin: 0 auto; border: 0;" />
</a>
</td>
</tr>
