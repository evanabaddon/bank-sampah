<style type="text/css">
	body {
		margin: 0;
		padding: 0;
		background: #ffffff;
	}

	div,
	p,
	a,
	li,
	td {
		-webkit-text-size-adjust: none;
	}

	body {
		width: 88mm;
		height: 100%;
		background-color: #ffffff;
		margin: 0;
		padding: 0;
		-webkit-font-smoothing: antialiased;

	}

	p {
		padding: 0 !important;
		margin-top: 0 !important;
		margin-right: 0 !important;
		margin-bottom: 0 !important;
		margin- left: 0 !important;
	}

	.visibleMobile {
		display: none;
	}

	.hiddenMobile {
		display: block;
	}
</style>

<!-- Header -->
<table width="100%" border="0" cellpadding='2' cellspacing="2" align="center" bgcolor="#ffffff" style="padding-top:4px;">
	<tbody>
		<tr>
			<td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: bottom; text-align: center;">
				<strong style="font-size:16px;">Bumdesa Pringgondani</strong>
				<br>Desa Sukoanyar Kec. Pakis, Kab. Malang
			</td>
		</tr>
		<tr>
			<td height="2" colspan="0" style="border-bottom:1px solid #e4e4e4 "></td>
		</tr>
	</tbody>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="2" align="center">
	<tbody>
		<tr>
			<td colspan="100" style="font-size: 14px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: bottom; text-align: center;">
				<strong>Bukti Bayar</strong>
				<br>INVOICE: {{  'PPC/' . $tagihan->id . '/' . $tagihan->nasabah_id  . '/' . date('my', strtotime($tagihan->tanggal_tagihan)) }}
			</td>
		</tr>
		<tr>
			<td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: bottom; text-align: left;">
				Petugas : {{ auth()->user()->name }}
				<br>
			</td>
			<td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height:18px; vertical-align: top; text-align: right;">
				<br>Tanggal: {{ now()->format('d F Y') }}
			</td>
		</tr>
		<tr>
			<td height="2" colspan="100" style="padding-top:15px;border-bottom:1px solid #e4e4e4 "></td>
		</tr>
	</tbody>
</table>

<!-- /Header -->

<!-- Table Total -->
<table width="100%" border="0 " cellpadding="0" cellspacing="2" align="center" style="padding: 12px 0px 5px 2px">
	<tbody>
		<tr>
			<td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 16px; vertical-align: top; text-align:left; ">
				Biaya Layanan {{ $tagihan->nasabah->name }}
			</td>
			<td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 16px; vertical-align: top; text-align:right; white-space:nowrap; " width="100 ">
				{{ 'Rp. ' . number_format($tagihan->jumlah_tagihan, 0, ',', '.') . ',-'; }}
			</td>
		</tr>

		<tr>
			<td height="2" colspan="100" style="padding-top:8px;border-bottom:1px solid #e4e4e4 "></td>
		</tr>
	</tbody>
</table>
<!-- /Table Total -->

<!-- Stempel Lunas -->
<div style="text-align: center;">
	<img src="https://png.pngtree.com/png-vector/20230811/ourmid/pngtree-paid-off-stamp-in-red-color-vector-png-image_9127590.png" alt="Stempel Lunas" width="150" height="150">
</div>
<!-- /Stempel Lunas -->

<!-- Customer sign -->
<table width="100%" border="0" cellpadding='2' cellspacing="2" align="center" bgcolor="#ffffff" style="padding-top:4px;">
	<tbody>
		<tr>
			<td style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: bottom; text-align: center;">
				<strong style="font-size:16px;">Terimakasih</strong>
				<br>Telah Menggunakan Layanan Kami
				<br><strong>Bumdesa Pringgondani</strong>
				<br>Telp. +62 8121 6029 645
				<br>www.bumdespringgondani.com
			</td>
		</tr>
	</tbody>
</table>

<script>
    window.onload = function() {
        window.print();
    }
</script>
