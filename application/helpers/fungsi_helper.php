<?php
// membuat format rupiah
function rupiah($rupiah = null)
{
	$rp = "Rp. " . number_format($rupiah, 0, ",", ".");
	return $rp;
}

function random($length = 8)
{
	$data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
	$string = '';
	for ($i = 0; $i < $length; $i++) {
		$pos = rand(0, strlen($data) - 1);
		$string .= $data[$pos];
	}
	return $string;
}

function random_num($length = 8)
{
	$data = '1234567890';
	$string = '';
	for ($i = 0; $i < $length; $i++) {
		$pos = rand(0, strlen($data) - 1);
		$string .= $data[$pos];
	}
	return $string;
}


function array_map_assoc($callback, $array)
{
	$r = array();
	foreach ($array as $key => $value)
		$r[$key] = $callback($key, $value);
	return $r;
}
function generateRandomString($length = 10)
{
	$characters = '0123456789';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function acak($str)
{
	$kunci = '979a218e0632df2935317f98d47956c7';
	$hasil = '';
	for ($i = 0; $i < strlen($str); $i++) {
		$karakter = substr($str, $i, 1);
		$kuncikarakter = substr($kunci, ($i % strlen($kunci)) - 1, 1);
		$karakter = chr(ord($karakter) + ord($kuncikarakter));
		$hasil .= $karakter;
	}
	return urlencode(base64_encode($hasil));
}
function susun($str)
{
	$str = base64_decode(urldecode($str));
	$hasil = '';
	$kunci = '979a218e0632df2935317f98d47956c7';
	for ($i = 0; $i < strlen($str); $i++) {
		$karakter = substr($str, $i, 1);
		$kuncikarakter = substr($kunci, ($i % strlen($kunci)) - 1, 1);
		$karakter = chr(ord($karakter) - ord($kuncikarakter));
		$hasil .= $karakter;
	}
	return $hasil;
}
function tgl($tgl)
{
	$tn = explode('/', $tgl);
	$tn = $tn[2] . '-' . $tn[0] . '-' . $tn[1];
	return $tr;
}

function send_Email($email, $pesan)
{
	$config = [
		'protocol'  => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_user' => 'lapas3329@gmail.com',
		'smtp_pass' => 'Oktober1',
		'smtp_port' => 465,
		'mailtype'  => 'html',
		'charset'   => 'utf-8',
		'newline'   => "\r\n"
	];

	$CI = &get_instance();
	// Load library email dan konfigurasinya
	$CI->load->library('email', $config);

	// Email dan nama pengirim
	$CI->email->from('lapas3329@gmail.com', 'LAPAS CABANG RUTAN');

	// Email penerima
	$CI->email->to($email); // Ganti dengan email tujuan kamu

	// Lampiran email, isi dengan url/path file
	//$this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

	// Subject email
	$CI->email->subject('Informasi');

	// Isi email
	$CI->email->message($pesan);

	// Tampilkan pesan sukses atau error
	if ($CI->email->send()) {
	} else {
		//echo 'Error! email tidak dapat dikirim.';
		echo $CI->email->print_debugger();
	}
}
function api_json($url)
{
	$jsons = $url;

	$son = file_get_contents($jsons);
	return $son = json_decode($son);
}

function send_Telegram($key, $id_chat, $pesan)
{
	$pesan = urlencode();
	$token = "bot" . $key;
	$chat_id = $id_chat;
	$proxy = "";
	//<ip_proxy>:<port>
	$url = "https://api.telegram.org/$token/sendMessage?parse_mode=markdown&chat_id=$chat_id&text=$pesan";

	$ch = curl_init();

	if ($proxy == "") {
		$optArray = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CAINFO => "C:\cacert.pem"
		);
	} else {
		$optArray = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_PROXY => "$proxy",
			CURLOPT_CAINFO => "C:\cacert.pem"
		);
	}

	curl_setopt_array($ch, $optArray);
	$result = curl_exec($ch);

	$err = curl_error($ch);
	curl_close($ch);

	if ($err <> "") echo "Error: $err";
	else echo "Pesan Terkirim";
}

function up($imges, $url)
{
	$config['upload_path']          = './' . $url;
	$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|csv|txt|doc|docx|rar|zip|svg|xml|GIF|JPG|PNG|JPEG|PDF|DOC|XML|DOCX|xls|xlsx|CSV|TXT|SVG|mov|avi|flv|wmv|mp3|mp4';
	$config['max_size']             = 500000;
	$config['overwrite'] = TRUE;
	$config['encrypt_name'] = TRUE;
	$new_name = time();
	$config['file_name'] = $new_name;
	$CI = &get_instance();
	$CI->load->library('upload', $config);
	$CI->upload->initialize($config);
	// ------------------------------------------
	if (!$CI->upload->do_upload($imges)) {
		return false;
	} else {
		$image = $CI->upload->data('file_name');
		return  $image;
	}
}


function byteToImageSave($base64_image, $path)
{
	$image = $base64_image;
	$image = str_replace('data:image/jpeg;base64,', '', $image);
	$image = base64_decode($image);
	$filename = 'image_' . time() . '.jpg';
	$path = '/' . $path;
	file_put_contents(FCPATH . $path . $filename, $image);
	return $filename;
}

// format tanggal indonesia
function tgl_i($tanggal)
{
	$bulan = array(
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

function enc($str)
{
	$CI = &get_instance();
	$CI->load->library('kripto');
	return $CI->kripto->encript_kripto($str);
}
function desc($str)
{
	$CI = &get_instance();
	$CI->load->library('kripto');
	return $CI->kripto->descript_kripto($str);
}


// format tanggal indonesia penyebut --------------
function bulan_indo($tanggal)
{
	$bulan = array(
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}


function penyebut($nilai)
{
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " " . $huruf[$nilai];
	} else if ($nilai < 20) {
		$temp = penyebut($nilai - 10) . " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
	}
	return $temp;
}

function terbilang($nilai)
{
	if ($nilai < 0) {
		$hasil = "minus " . trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}
	return $hasil;
}

//Fungsi ambil tanggal aja
function tgl_aja($tgl_a)
{
	$tanggal = substr($tgl_a, 8, 2);
	return $tanggal;
}

//Fungsi Ambil bulan aja
function bln_aja($bulan_a)
{
	$bulan = getBulan(substr($bulan_a, 5, 2));
	return $bulan;
}
function bln_dan_tahun($bulan_a)
{
	$bulan = getBulan(substr($bulan_a, 5, 2));
	return $bulan . " " . thn_aja($bulan_a);
}

//Fungsi Ambil tahun aja
function thn_aja($thn)
{
	$tahun = substr($thn, 0, 4);
	return $tahun;
}

//Fungsi konversi tanggal bulan dan tahun ke dalam bahasa indonesia
function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
//Fungsi konversi nama bulan ke dalam bahasa indonesia
function getBulan($bln)
{
	switch ($bln) {
		case 1:
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}
function hari_indonesia($tanggalInp)
{
	$tanggal = $tanggalInp;
	$hari   = date('l', microtime($tanggal));
	$hari_indonesia = array(
		'Monday'  => 'Senin',
		'Tuesday'  => 'Selasa',
		'Wednesday' => 'Rabu',
		'Thursday' => 'Kamis',
		'Friday' => 'Jumat',
		'Saturday' => 'Sabtu',
		'Sunday' => 'Minggu'
	);
	return $hari_indonesia[$hari];
	// Tanggal 2017-01-31 adalah hari Senin
}
// ---------------------------------------
function substrwords($text, $maxchar, $end = '...')
{
	if (strlen($text) > $maxchar || $text == '') {
		$words = preg_split('/\s/', $text);
		$output = '';
		$i      = 0;
		while (1) {
			$length = strlen($output) + strlen($words[$i]);
			if ($length > $maxchar) {
				break;
			} else {
				$output .= " " . $words[$i];
				++$i;
			}
		}
		$output .= $end;
	} else {
		$output = $text;
	}
	return $output;
}
function curl_request($url, $data = null)
{
	$url = "https://sendtalk-api.taptalk.io/api/v1/message/send_whatsapp";

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$headers = array(
		"API-Key: 23a4c4918e786bffc54e91c20c2244f65624ffe3454cefac673faaa84181e293",
		"Content-Type: application/json",
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

	//for debug only!
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$resp = curl_exec($curl);
	$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);

	return  ["result" => json_decode($resp, true), "status" => json_decode($statusCode, true)];
}
function sendWa($no, $msg)
{
	$req = curl_request(
		"https://sendtalk-api.taptalk.io/api/v1/message/send_whatsapp",
		[
			"phone"       => $no,
			"messageType" => "text",
			"body"        => $msg
		]
	);
	return $req;
}


function CurlPost($url, $data)
{
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$headers = array(
		"Content-Type: application/json",
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	//for debug only!
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$resp = curl_exec($curl);
	curl_close($curl);
	return $resp;
}
