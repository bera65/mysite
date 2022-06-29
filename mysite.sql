-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 28 Haz 2022, 15:51:21
-- Sunucu sürümü: 10.4.24-MariaDB
-- PHP Sürümü: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `mysite`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attirupe`
--

CREATE TABLE `attirupe` (
  `id_attirupe` int(5) NOT NULL,
  `attirupe_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `attirupe`
--

INSERT INTO `attirupe` (`id_attirupe`, `attirupe_name`) VALUES
(1, 'Renk'),
(2, 'Beden'),
(3, 'Numara');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attirupe_grup`
--

CREATE TABLE `attirupe_grup` (
  `id_grup` int(5) NOT NULL,
  `value1` int(5) NOT NULL,
  `value2` int(5) DEFAULT 0,
  `value3` int(5) DEFAULT 0,
  `id_product` int(5) NOT NULL,
  `quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `attirupe_grup`
--

INSERT INTO `attirupe_grup` (`id_grup`, `value1`, `value2`, `value3`, `id_product`, `quantity`) VALUES
(14, 9, 0, 0, 2, 1),
(15, 10, 0, 0, 2, 2),
(16, 11, 0, 0, 2, 3),
(17, 12, 0, 0, 2, 4),
(18, 1, 5, 0, 3, 1),
(19, 1, 6, 0, 3, 2),
(20, 1, 7, 0, 3, 3),
(21, 1, 8, 0, 3, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attirupe_value`
--

CREATE TABLE `attirupe_value` (
  `id_attirupe_value` int(5) NOT NULL,
  `id_attirupe` int(5) NOT NULL,
  `value` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `attirupe_value`
--

INSERT INTO `attirupe_value` (`id_attirupe_value`, `id_attirupe`, `value`) VALUES
(1, 1, 'Mavi'),
(2, 1, 'Yeşil'),
(3, 1, 'Kahverengi'),
(4, 1, 'Siyah'),
(5, 2, 'S'),
(6, 2, 'M'),
(7, 2, 'L'),
(8, 2, 'XL'),
(9, 3, '40'),
(10, 3, '41'),
(11, 3, '42'),
(12, 3, '43'),
(13, 3, '44'),
(14, 3, '45');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `image`
--

CREATE TABLE `image` (
  `id_image` int(5) NOT NULL,
  `id_product` int(5) NOT NULL,
  `cover` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `image`
--

INSERT INTO `image` (`id_image`, `id_product`, `cover`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product`
--

CREATE TABLE `product` (
  `id_product` int(5) NOT NULL,
  `name` varchar(128) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  `description_long` text NOT NULL,
  `bundle` varchar(128) DEFAULT NULL,
  `btotal` int(1) NOT NULL DEFAULT 0,
  `stock` int(5) NOT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `date_upd` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `product`
--

INSERT INTO `product` (`id_product`, `name`, `price`, `description`, `description_long`, `bundle`, `btotal`, `stock`, `date_add`, `date_upd`) VALUES
(1, 'Samsung Süpürge Makinesi', 1499.99, 'Sessiz süpürge makinesi', '<p>Ürün ultra hafif ve sessiz bir ürün</p><ul><li>İki yıl servis garantisi</li><li>Birebir değişim</li><li>Motor garantisi</li></ul><p><i><strong>Harika bir ürün</strong></i></p>', NULL, 1, 2, '2022-06-28 16:05:04', '2022-06-28 16:05:04'),
(2, 'Siyah Erkek Ayakkabısı', 400, 'Hakiki deriden oluşan erkek ayakkabısı', '<p>Erkek ayakkabısı siyah renk</p>', NULL, 1, 3, '2022-06-28 16:14:10', '2022-06-28 16:14:10'),
(3, 'Erkek Renkli Yatay Çizgili Uzun Kollu Gömlek', 300, 'Gri çizgili ürün. Babalar günü için çok ideal bir ürün', '<p>Ürün İçeriği: %100 Pamuk<br>Modelin Ölçüleri: Boy:1,88 Bel:77 Göğüs:103 Kalça:101 Kilo:80 Numune Bedeni L Bedendir.<br>Ürün Kalıbı: Slim Fit<br>Gömlek her mevsimde terich dilebilir.<br>İçerisinde yedek düğmesi bulunmaktadır.</p>', NULL, 1, 2, '2022-06-28 16:45:41', '2022-06-28 16:45:41'),
(4, 'Babablar günü hediyesi', 1500, 'Babalar günü için bir hediye paketi', '', '{\"0\" : 14,\"1\" : 15,\"2\" : 16,\"3\" : 17,\"4\" : 18,\"5\" : 19,\"6\" : 20,\"7\" : 21}', 1, 0, '2022-06-28 16:47:06', '2022-06-28 16:47:06');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `attirupe`
--
ALTER TABLE `attirupe`
  ADD PRIMARY KEY (`id_attirupe`);

--
-- Tablo için indeksler `attirupe_grup`
--
ALTER TABLE `attirupe_grup`
  ADD PRIMARY KEY (`id_grup`);

--
-- Tablo için indeksler `attirupe_value`
--
ALTER TABLE `attirupe_value`
  ADD PRIMARY KEY (`id_attirupe_value`);

--
-- Tablo için indeksler `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id_image`);

--
-- Tablo için indeksler `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `attirupe`
--
ALTER TABLE `attirupe`
  MODIFY `id_attirupe` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `attirupe_grup`
--
ALTER TABLE `attirupe_grup`
  MODIFY `id_grup` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `attirupe_value`
--
ALTER TABLE `attirupe_value`
  MODIFY `id_attirupe_value` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `image`
--
ALTER TABLE `image`
  MODIFY `id_image` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
