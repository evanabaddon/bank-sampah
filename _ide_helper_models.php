<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\DetailTransaksiBank
 *
 * @property int $id
 * @property int $id_transaksi_bank
 * @property int $id_jenis_sampah
 * @property string $berat
 * @property string $harga
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\JenisSampah|null $jenisSampah
 * @property-read \App\Models\TransaksiBank|null $transaksiBankSampah
 * @method static \Database\Factories\DetailTransaksiBankFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank query()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank whereBerat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank whereIdJenisSampah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank whereIdTransaksiBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DetailTransaksiBank whereUpdatedAt($value)
 */
	class DetailTransaksiBank extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JenisSampah
 *
 * @property int $id
 * @property string $name
 * @property int $harga
 * @property int $stok
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\JenisSampahFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah query()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSampah whereUpdatedAt($value)
 */
	class JenisSampah extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KategoriLayanan
 *
 * @property int $id
 * @property string $name
 * @property int $harga
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\KategoriLayananFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriLayanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriLayanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriLayanan query()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriLayanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriLayanan whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriLayanan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriLayanan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriLayanan whereUpdatedAt($value)
 */
	class KategoriLayanan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Nasabah
 *
 * @property int $id
 * @property string|null $kodenasabah
 * @property string $name
 * @property string|null $rt
 * @property string|null $rw
 * @property string $alamat
 * @property string $nohp
 * @property int $is_bsp
 * @property int $is_ppc
 * @property int|null $kategori_layanan_id
 * @property int $saldo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $pin
 * @property-read \App\Models\KategoriLayanan|null $kategoriLayanan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tagihan> $tagihans
 * @property-read int|null $tagihans_count
 * @method static \Database\Factories\NasabahFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah query()
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereIsBsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereIsPpc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereKategoriLayananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereKodenasabah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereNohp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah wherePin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereSaldo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nasabah whereUpdatedAt($value)
 */
	class Nasabah extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tagihan
 *
 * @property int $id
 * @property int $nasabah_id
 * @property string $tanggal_tagihan
 * @property string $tanggal_jatuh_tempo
 * @property string $jumlah_tagihan
 * @property string|null $jumlah_bayar
 * @property string|null $tanggal_bayar
 * @property string $status
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Nasabah|null $nasabah
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Tagihan> $tagihans
 * @property-read int|null $tagihans_count
 * @method static \Database\Factories\TagihanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereJumlahBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereJumlahTagihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereNasabahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereTanggalBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereTanggalJatuhTempo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereTanggalTagihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tagihan whereUpdatedAt($value)
 */
	class Tagihan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TransaksiBank
 *
 * @property int $id
 * @property string $id_nasabah
 * @property int $total_harga
 * @property int $id_operator
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetailTransaksiBank> $detailTransaksiBank
 * @property-read int|null $detail_transaksi_bank_count
 * @property-read \App\Models\Nasabah|null $nasabah
 * @property-read \App\Models\User|null $operator
 * @method static \Database\Factories\TransaksiBankFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiBank query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiBank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiBank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiBank whereIdNasabah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiBank whereIdOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiBank whereTotalHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransaksiBank whereUpdatedAt($value)
 */
	class TransaksiBank extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $nohp
 * @property string $email
 * @property string $akses
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAkses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNohp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

