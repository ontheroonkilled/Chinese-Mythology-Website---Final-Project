-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 26 Ara 2024, 22:50:27
-- Sunucu sürümü: 5.7.36
-- PHP Sürümü: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `chinamythology`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hakkimizda`
--

CREATE TABLE `hakkimizda` (
  `id` int(1) NOT NULL,
  `baslik` varchar(80) NOT NULL,
  `icerik` text NOT NULL,
  `resim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `hakkimizda`
--

INSERT INTO `hakkimizda` (`id`, `baslik`, `icerik`, `resim`) VALUES
(1, 'Çin Mitolojisi Dünyasına Hoş Geldiniz', '<p>Hoş geldiniz!</p><p>Bizler, zengin ve gizemli Çin mitolojisini keşfetmek, anlamak ve bu büyüleyici kültürü sizlerle paylaşmak için bir araya gelmiş bir ekibiz. Binlerce yıllık tarihe yayılan Çin mitolojisi, tanrılar, ejderhalar, kahramanlar ve büyülü yaratıklarla dolu eşsiz bir dünyanın kapılarını aralıyor.</p><p>Amacımız, bu mitolojik hazineleri, modern dünyanın karmaşasında kaybolmadan, hem akademik hem de eğlenceli bir şekilde sunmaktır. Efsanelerden halk hikayelerine, mitolojik yaratıklardan kadim ritüellere kadar, Çin mitolojisinin derinliklerine yaptığımız bu yolculukta sizleri de yanımızda görmekten mutluluk duyuyoruz.</p><p>Sitemizde, Çin mitolojisine dair derinlemesine incelemeler, görsel içerikler ve hikayeler bulabilirsiniz. Ayrıca, mitolojik karakterlerin ve kavramların tarihsel bağlamını anlamanıza yardımcı olacak rehberler de sunuyoruz. Hedefimiz, bu büyülü dünyanın herkes tarafından erişilebilir olmasını sağlamak ve bu kültürü daha geniş kitlelere tanıtmaktır.</p><p>Çin mitolojisi gibi köklü bir mirası keşfetmeye hazır mısınız? Bizimle birlikte bu serüvene katılın ve hayal gücünüzü serbest bırakın!</p><p>Sevgi ve ilhamla,</p><p>Çin Mitolojiler (Berat,Emir,Emircan)</p>', '1735229242_66eb7e5f23952240ab11.png');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `hakkimizda`
--
ALTER TABLE `hakkimizda`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `hakkimizda`
--
ALTER TABLE `hakkimizda`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
