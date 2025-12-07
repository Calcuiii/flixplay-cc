@extends('layouts.app')
@section('title', 'Hubungi Kami')
@section('content')

<!-- ============ CONTACT HERO ============ -->
<section style="background: linear-gradient(135deg, rgba(233, 75, 60, 0.1), rgba(0, 0, 0, 0.9)); padding: 80px 20px 40px; text-align: center;">
    <h1 style="font-size: 48px; margin-bottom: 15px; color: #fff;">
        📧 Hubungi Kami
    </h1>
    <p style="font-size: 18px; color: #b0b0b0; max-width: 600px; margin: 0 auto;">
        Punya pertanyaan, saran, atau masukan? Kami siap membantu Anda!
    </p>
</section>

<!-- ============ CONTACT CONTENT ============ -->
<section style="padding: 60px 20px; max-width: 1200px; margin: 0 auto;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
        
        <!-- FORM KONTAK -->
        <div style="background: rgba(255, 255, 255, 0.05); padding: 40px; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <h2 style="font-size: 28px; margin-bottom: 10px; color: #fff;">Kirim Pesan</h2>
            <p style="color: #b0b0b0; margin-bottom: 30px;">Isi form di bawah ini dan kami akan segera menghubungi Anda</p>
            
            @if(session('success'))
                <div style="background: rgba(76, 175, 80, 0.2); color: #4CAF50; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #4CAF50;">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: 500;">
                        Nama Lengkap <span style="color: #e94b3c;">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama Anda" required 
                           style="width: 100%; padding: 12px 15px; background: rgba(255, 255, 255, 0.1); border: 1px solid {{ $errors->has('name') ? '#e94b3c' : 'rgba(255, 255, 255, 0.2)' }}; border-radius: 8px; color: #fff; font-size: 15px;">
                    @error('name')
                        <span style="color: #e94b3c; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: 500;">
                        Email <span style="color: #e94b3c;">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required 
                           style="width: 100%; padding: 12px 15px; background: rgba(255, 255, 255, 0.1); border: 1px solid {{ $errors->has('email') ? '#e94b3c' : 'rgba(255, 255, 255, 0.2)' }}; border-radius: 8px; color: #fff; font-size: 15px;">
                    @error('email')
                        <span style="color: #e94b3c; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: 500;">
                        Subjek <span style="color: #e94b3c;">*</span>
                    </label>
                    <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Topik pesan Anda" required 
                           style="width: 100%; padding: 12px 15px; background: rgba(255, 255, 255, 0.1); border: 1px solid {{ $errors->has('subject') ? '#e94b3c' : 'rgba(255, 255, 255, 0.2)' }}; border-radius: 8px; color: #fff; font-size: 15px;">
                    @error('subject')
                        <span style="color: #e94b3c; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: 500;">
                        Pesan <span style="color: #e94b3c;">*</span>
                    </label>
                    <textarea name="message" rows="6" placeholder="Tulis pesan Anda di sini..." required 
                              style="width: 100%; padding: 12px 15px; background: rgba(255, 255, 255, 0.1); border: 1px solid {{ $errors->has('message') ? '#e94b3c' : 'rgba(255, 255, 255, 0.2)' }}; border-radius: 8px; color: #fff; font-size: 15px; resize: vertical; font-family: inherit;">{{ old('message') }}</textarea>
                    @error('message')
                        <span style="color: #e94b3c; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" style="width: 100%; padding: 15px; background: linear-gradient(135deg, #e94b3c, #ff6b6b); border: none; border-radius: 8px; color: #fff; font-size: 16px; font-weight: bold; cursor: pointer; transition: transform 0.2s;">
                    <i class="bi bi-send"></i> Kirim Pesan
                </button>
            </form>
        </div>

        <!-- INFORMASI KONTAK -->
        <div>
            <div style="background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 20px;">
                <h3 style="font-size: 22px; margin-bottom: 20px; color: #fff;">
                    <i class="bi bi-info-circle" style="color: #e94b3c;"></i> Informasi Kontak
                </h3>
                
                <div style="margin-bottom: 20px; display: flex; align-items: start; gap: 15px;">
                    <div style="background: rgba(233, 75, 60, 0.2); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-envelope" style="color: #e94b3c; font-size: 20px;"></i>
                    </div>
                    <div>
                        <strong style="color: #fff; display: block; margin-bottom: 5px;">Email</strong>
                        <a href="mailto:support@flixplay.com" style="color: #b0b0b0; text-decoration: none;">support@flixplay.com</a>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px; display: flex; align-items: start; gap: 15px;">
                    <div style="background: rgba(233, 75, 60, 0.2); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-telephone" style="color: #e94b3c; font-size: 20px;"></i>
                    </div>
                    <div>
                        <strong style="color: #fff; display: block; margin-bottom: 5px;">Telepon</strong>
                        <a href="tel:+6281234567890" style="color: #b0b0b0; text-decoration: none;">+62 812-3456-7890</a>
                    </div>
                </div>
                
                <div style="display: flex; align-items: start; gap: 15px;">
                    <div style="background: rgba(233, 75, 60, 0.2); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="bi bi-geo-alt" style="color: #e94b3c; font-size: 20px;"></i>
                    </div>
                    <div>
                        <strong style="color: #fff; display: block; margin-bottom: 5px;">Alamat</strong>
                        <span style="color: #b0b0b0;">Jl. Streaming No. 123<br>Surabaya, Jawa Timur 60123</span>
                    </div>
                </div>
            </div>

            <div style="background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
                <h3 style="font-size: 22px; margin-bottom: 15px; color: #fff;">
                    <i class="bi bi-clock" style="color: #e94b3c;"></i> Jam Operasional
                </h3>
                <div style="color: #b0b0b0; line-height: 1.8;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Senin - Jumat</span>
                        <strong style="color: #fff;">09:00 - 18:00</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Sabtu</span>
                        <strong style="color: #fff;">10:00 - 16:00</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Minggu</span>
                        <strong style="color: #ff9800;">Tutup</strong>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px; background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
                <h3 style="font-size: 22px; margin-bottom: 15px; color: #fff;">
                    <i class="bi bi-share" style="color: #e94b3c;"></i> Ikuti Kami
                </h3>
                <div style="display: flex; gap: 15px;">
                    <a href="#" style="background: rgba(233, 75, 60, 0.2); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #e94b3c; text-decoration: none; transition: transform 0.2s;">
                        <i class="bi bi-facebook" style="font-size: 20px;"></i>
                    </a>
                    <a href="#" style="background: rgba(233, 75, 60, 0.2); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #e94b3c; text-decoration: none; transition: transform 0.2s;">
                        <i class="bi bi-instagram" style="font-size: 20px;"></i>
                    </a>
                    <a href="#" style="background: rgba(233, 75, 60, 0.2); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #e94b3c; text-decoration: none; transition: transform 0.2s;">
                        <i class="bi bi-twitter" style="font-size: 20px;"></i>
                    </a>
                    <a href="#" style="background: rgba(233, 75, 60, 0.2); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #e94b3c; text-decoration: none; transition: transform 0.2s;">
                        <i class="bi bi-youtube" style="font-size: 20px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ FAQ SECTION ============ -->
<section style="padding: 60px 20px; background: rgba(255, 255, 255, 0.02); max-width: 1200px; margin: 0 auto;">
    <h2 style="text-align: center; font-size: 36px; margin-bottom: 40px; color: #fff;">
        ❓ Pertanyaan yang Sering Diajukan
    </h2>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="background: rgba(255, 255, 255, 0.05); padding: 25px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <h4 style="color: #e94b3c; margin-bottom: 10px;">Bagaimana cara berlangganan?</h4>
            <p style="color: #b0b0b0; line-height: 1.6;">Anda bisa berlangganan melalui menu "Pricing" dan pilih paket yang sesuai dengan kebutuhan Anda.</p>
        </div>
        <div style="background: rgba(255, 255, 255, 0.05); padding: 25px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <h4 style="color: #e94b3c; margin-bottom: 10px;">Berapa perangkat yang bisa digunakan?</h4>
            <p style="color: #b0b0b0; line-height: 1.6;">Tergantung paket yang Anda pilih. Paket Premium bisa digunakan hingga 2 perangkat sekaligus.</p>
        </div>
        <div style="background: rgba(255, 255, 255, 0.05); padding: 25px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <h4 style="color: #e94b3c; margin-bottom: 10px;">Bagaimana cara menghubungi support?</h4>
            <p style="color: #b0b0b0; line-height: 1.6;">Anda bisa mengisi form di atas atau hubungi kami via email dan telepon yang tertera.</p>
        </div>
    </div>
</section>

@endsection