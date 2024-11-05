<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dukung Arvandha</title>
    <link rel="icon" href="public/img/logo-nyawer2-removebg-preview.png" type="image/png">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/popup_condition.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="public/js/script.js"></script>
</head>
<body>
    <div class="container">
        <div class="contents">
            <img src="public/img/unnamed.jpg" alt="Lingkaran" class="responsive-image">
            <h1>
                Arvandha
                <span class="icon-container">
                    <i class="fas fa-check-circle animated-check" style="color: #1DA1F2;"></i>
                    <span class="tooltip">Developer</br>Nyaweria</span>
                </span>
            </h1>
            <?php include 'other/icon_link_sosmed.php'; ?>

            <p class="thank-you-message">
                Terimakasih yang telah mensupport aku.<br>
                Have a good day and God bless you!
            </p>

            <form action="confirm.php" method="POST">
                <div class="form-container">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="name">Dari<span class="required"> * </span></label>
                            <input type="text" id="name" name="name" placeholder="Tulis nama/nickname disini..." required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email<span class="required"> * </span></label>
                            <input type="email" id="email" name="email" placeholder="Tulis email disini..." required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Nominal (IDR)<span class="required"> * </span></label>
                            <input type="number" id="amount" name="amount" placeholder="Jumlah dukungan (contoh: 1000)" required oninput="validateAmount()">
                            <!-- Notifikasi error dengan ikon -->
                            <p id="error-message" class="error-message" style="display: none;">
                                Jumlah dukungan minimal adalah Rp 1.000.
                            </p>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="message">Pesan<span class="required"> * </span></label>
                            <textarea id="message" name="message" rows="4" placeholder="Tulis pesan Anda di sini..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="donation-buttons">
                    <button type="button" onclick="setDonationAmount(1000, this)">1.000</button>
                    <button type="button" onclick="setDonationAmount(5000, this)">5.000</button>
                    <button type="button" onclick="setDonationAmount(10000, this)">10.000</button>
                    <button type="button" onclick="setDonationAmount(25000, this)">25.000</button>
                </div>

                <!-- Link to terms and checkbox for agreement -->
                <div class="terms-conditions">
                    <div>
                        <input type="checkbox" id="accept-terms" onclick="toggleSubmitButton()">
                        <label for="accept-terms.php"> Saya menyetujui syarat dan ketentuan <a href="#" onclick="showTerms(event)">disini</a></label>
                    </div>
                </div>

                <button type="submit" id="submit-button" class="btn" disabled>Konfirmasi Dukungan</button>
                <!-- Suggestion Box -->
                <div class="suggestion-box">
                    <h3>Kotak Saran</h3>
                    <p>Ingin menyampaikan pesan atau saran langsung? Kirimkan melalui Telegram dan siarkan pesan Anda dengan mengunjungi</p>
                    <a href="https://t.me/arvandha/" target="_blank" class="telegram-link">
                        <i class="bi bi-telegram"></i> Kirim Pesan ke Telegram
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Popup for Terms and Conditions -->
    <?php include 'other/popup_terms.php'; ?>

    <script src="public/js/scriptpopupcondition.js"></script>
</body>
</html>
